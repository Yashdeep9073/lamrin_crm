<!-- Edit modal content -->
<div id="payModal-{{ $row->id }}" class="modal fade" tabindex="-1" role="dialog" id="payModal-{{ $row->id }}"
    aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form class="needs-validation" novalidate action="{{ route($route . '.pay') }}" method="post"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">{{ $title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <!-- View Start -->
                    <div class="">
                        <div class="row">
                            <div class="col-md-6">
                                <p><mark class="text-primary">{{ __('field_student_id') }}:</mark>
                                    #{{ $row->studentEnroll->student->student_id ?? '' }}</p>
                                <hr />
                                <p><mark class="text-primary">{{ __('field_name') }}:</mark>
                                    {{ $row->studentEnroll->student->first_name ?? '' }}
                                    {{ $row->studentEnroll->student->last_name ?? '' }}
                                </p>
                                <hr />
                                <p><mark class="text-primary">{{ __('field_father_name') }}:</mark>
                                    {{ $row->studentEnroll->student->father_name ?? '' }}</p>
                                <hr />
                                <p><mark class="text-primary">{{ __('field_program') }}:</mark>
                                    {{ $row->studentEnroll->program->title ?? '' }}</p>
                                <hr />
                            </div>
                            <div class="col-md-6">
                                <p><mark class="text-primary">{{ __('field_fees_type') }}:</mark>
                                    {{ $row->category->title ?? '' }}</p>
                                <hr />
                                <p><mark class="text-primary">{{ __('field_session') }}:</mark>
                                    {{ $row->studentEnroll->session->title ?? '' }}</p>
                                <hr />
                                <p><mark class="text-primary">{{ __('field_semester') }}:</mark>
                                    {{ $row->studentEnroll->semester->title ?? '' }}
                                    ({{ $row->studentEnroll->section->title ?? '' }})</p>
                                <hr />
                            </div>
                        </div>
                    </div>
                    <br />

                    <input type="text" name="fee_id" value="{{ $row->id }}" hidden>

                    <!-- Form Start -->
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="due_date" class="form-label">{{ __('field_due_date') }} <span>*</span></label>
                            <input type="date" class="form-control" name="due_date" id="due_date"
                                value="{{ $row->due_date }}" required>

                            <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('field_due_date') }}
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="fee_amount" class="form-label">{{ __('field_amount') }}
                                ({!! $setting->currency_symbol !!}) <span>*</span></label>
                            <input type="text" class="form-control autonumber" name="fee_amount" id="fee_amount"
                                value="{{ round($row->fees_total_amount, 2) }}" required >

                            <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('field_amount') }}
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="discount_amount" class="form-label">{{ __('field_discount') }}
                                ({!! $setting->currency_symbol !!}) <span>*</span></label>
                            <input type="text" class="form-control autonumber" name="discount_amount"
                                id="discount_amount" value="{{ round($row->discount_amount, 2) }}" required >

                            <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('field_discount') }}
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="fine_amount" class="form-label">{{ __('field_fine_amount') }}
                                ({!! $setting->currency_symbol !!}) <span>*</span></label>
                            <input type="text" class="form-control autonumber" name="fine_amount" id="fine_amount"
                                value="{{ round($fine_amount, 2) }}" required>

                            <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('field_fine_amount') }}
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="net_amount" class="form-label">{{ __('field_net_amount') }}
                                ({!! $setting->currency_symbol !!}) <span>*</span></label>
                            <input type="text" class="form-control autonumber" name="paid_amount" id="net_amount"
                                value="{{ round($net_amount, 2) }}" required>

                            <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('field_net_amount') }}
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="note" class="form-label">{{ __('field_note') }}</label>
                            <input type="text" class="form-control" name="note" id="note-{{ $row->id }}"
                                value="{{ old('note') }}">
                        </div>
                    </div>
                    <!-- Form End -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i>
                        {{ __('btn_close') }}</button>
                    <button type="submit" class="btn btn-success"><i class="fas fa-money-check"></i> Save
                        Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>