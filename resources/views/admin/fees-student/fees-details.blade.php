<!-- Edit modal content -->
<div class="modal fade" tabindex="-1" role="dialog" id="payModal-{{ $row->student_enroll_id }}"
    aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form class="needs-validation" novalidate action="{{ route($route . '.pay') }}" method="post"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">{{ $title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
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
                                    {{ $row->studentEnroll->student->last_name ?? '' }}</p>
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

                    <!-- Form Start -->
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="totalFeeAmount" class="form-label">{{ __('Total Fees') }} <span>*</span></label>
                            <input type="text" class="form-control" name="total_fee_amount" id="totalFeeAmount" required
                                readonly>
                            <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('Total Fees') }}
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="pendingFeeAmount" class="form-label">{{ __('Pending Fees Amount') }} <span>*</span></label>
                            <input type="text" class="form-control" name="pending_fee_amount" id="pendingFeeAmount" required
                                readonly>
                            <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('Pending Fees Amount') }}
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="feesDiscount" class="form-label">{{ __('Discount') }} <span>*</span></label>
                            <input type="text" class="form-control" name="discount_amount" id="feesDiscount" required
                                readonly>
                            <div class="invalid-feedback">
                                {{ __('required_field') }} {{ __('Discount') }}
                            </div>
                        </div>
                    </div>
                    <!-- Form End -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> {{ __('btn_close') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>