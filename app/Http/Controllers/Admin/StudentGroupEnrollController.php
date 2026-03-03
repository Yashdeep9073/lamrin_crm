<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudentEnroll;
use Illuminate\Http\Request;
use App\Models\Semester;
use App\Models\Faculty;
use App\Models\Program;
use App\Models\Section;
use App\Models\Session;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Grade;
use Toastr;
use Auth;
use DB;

class StudentGroupEnrollController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_group_enroll', 1);
        $this->route = 'admin.group-enroll';
        $this->view = 'admin.group-enroll';
        $this->path = 'student';
        $this->access = 'student-enroll';


        $this->middleware('permission:' . $this->access . '-group');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;


        if (!empty($request->faculty) || $request->faculty != null) {
            $data['selected_faculty'] = $faculty = $request->faculty;
        } else {
            $data['selected_faculty'] = '0';
        }

        if (!empty($request->program) || $request->program != null) {
            $data['selected_program'] = $program = $request->program;
        } else {
            $data['selected_program'] = '0';
        }

        if (!empty($request->session) || $request->session != null) {
            $data['selected_session'] = $session = $request->session;
        } else {
            $data['selected_session'] = '0';
        }

        if (!empty($request->semester) || $request->semester != null) {
            $data['selected_semester'] = $semester = $request->semester;
        } else {
            $data['selected_semester'] = '0';
        }

        if (!empty($request->section) || $request->section != null) {
            $data['selected_section'] = $section = $request->section;
        } else {
            $data['selected_section'] = '0';
        }


        // Search Filter
        $data['faculties'] = Faculty::where('status', '1')->orderBy('title', 'asc')->get();


        if (!empty($request->faculty) && !empty($request->program) && !empty($request->session) && !empty($request->semester) && !empty($request->section)) {

            $data['programs'] = Program::where('faculty_id', $faculty)->where('status', '1')->orderBy('title', 'asc')->get();

            $sessions = Session::where('status', 1);
            $sessions->with('programs')->whereHas('programs', function ($query) use ($program) {
                $query->where('program_id', $program);
            });
            $data['sessions'] = $sessions->orderBy('id', 'desc')->get();

            $semesters = Semester::where('status', 1);
            $semesters->with('programs')->whereHas('programs', function ($query) use ($program) {
                $query->where('program_id', $program);
            });
            $data['semesters'] = $semesters->orderBy('id', 'asc')->get();

            $sections = Section::where('status', 1);
            $sections->with('semesterPrograms')->whereHas('semesterPrograms', function ($query) use ($program, $semester) {
                $query->where('program_id', $program);
                $query->where('semester_id', $semester);
            });
            $data['sections'] = $sections->orderBy('title', 'asc')->get();

            $subjects = Subject::where('status', 1);
            $subjects->with('programs')->whereHas('programs', function ($query) use ($program) {
                $query->where('program_id', $program);
            });
            $data['subjects'] = $subjects->orderBy('code', 'asc')->get();

            $data['grades'] = Grade::where('status', '1')->orderBy('min_mark', 'desc')->get();
        }


        // Student Filter
        if (!empty($request->faculty) && !empty($request->program) && !empty($request->session) && !empty($request->semester) && !empty($request->section)) {

            $students = Student::where('status', '1');
            if (!empty($request->faculty)) {
                $students->with('program')->whereHas('program', function ($query) use ($faculty) {
                    $query->where('faculty_id', $faculty);
                });
            }
            if (!empty($request->program) && !empty($request->session) && !empty($request->semester) && !empty($request->section)) {
                $students->with('currentEnroll')->whereHas('currentEnroll', function ($query) use ($program, $session, $semester, $section) {
                    $query->where('program_id', $program);
                    $query->where('session_id', $session);
                    $query->where('semester_id', $semester);
                    $query->where('section_id', $section);
                    $query->where('status', '1');
                });
            }

            $rows = $students->orderBy('student_id', 'asc')->get();

            // Array Sorting
            $data['rows'] = $rows->sortBy(function ($query) {

                return $query->student_id;

            })->all();
        }


        return view($this->view . '.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Field Validation
        $request->validate([
            'semester' => 'required',
            'session' => 'required',
            'section' => 'required',
            'program' => 'required',
            'students' => 'required|array', // Ensure students is an array
            'subjects' => 'required',
        ]);

        try {
            DB::beginTransaction();

            foreach ($request->students as $key => $student) {
                // Skip if student is empty or null
                if (empty($student) || $student === '') {
                    continue;
                }

                // Find existing enrollment for the student
                $enroll = StudentEnroll::where('student_id', $student)->first();

                if ($enroll) {
                    // Update existing enrollment
                    $enroll->program_id = $request->program;
                    $enroll->session_id = $request->session;
                    $enroll->semester_id = $request->semester;
                    $enroll->section_id = $request->section;
                    $enroll->updated_by = Auth::guard('web')->user()->id; // Track who updated
                    $enroll->status = 1; // Assuming you want active status
                    $enroll->save();

                    // Sync subjects (updates the relationship instead of attaching duplicates)
                    $enroll->subjects()->sync($request->subjects);

                    Toastr::success(__('msg_updated_successfully'), __('msg_success'));
                } else {
                    // If no enrollment exists, show an error (no creation)
                    Toastr::error(__('msg_no_enrollment_found_for_student') . ' ' . $student, __('msg_error'));
                }
            }

            DB::commit();
            return redirect()->back();

        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error(__('msg_updated_error'), __('msg_error'));
            return redirect()->back();
        }
    }
}
