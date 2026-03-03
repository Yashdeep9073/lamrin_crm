<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeesAssign extends Model
{
    use HasFactory;

    // Explicitly define the table name to avoid pluralization
    protected $table = 'fees_assign';

    protected $fillable = [
        'student_enroll_id',
        'category_id',
        'fees_total_amount',
        'fee_amount',
        'fine_amount',
        'discount_amount',
        'paid_amount',
        'assign_date',
        'due_date',
        'pay_date',
        'payment_method',
        'note',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'assign_date' => 'date',
        'due_date' => 'date',
        'pay_date' => 'date',
    ];

    public function studentEnroll()
    {
        return $this->belongsTo(StudentEnroll::class, 'student_enroll_id');
    }

    public function category()
    {
        return $this->belongsTo(FeesCategory::class, 'category_id');
    }
}