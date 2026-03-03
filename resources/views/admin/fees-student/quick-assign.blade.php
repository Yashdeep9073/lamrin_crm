@extends('admin.layouts.master')
@section('title', $title)
@section('content')

    <!-- Start Content-->
    <div class="main-body">
        <div class="page-wrapper">
            <!-- [ Main Content ] start -->
            <div class="row">
                <!-- [ Card ] start -->
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ $title }}</h5>
                        </div>
                        <form class="needs-validation" novalidate action="{{ route($route . '.quick.assign.store') }}"
                            method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-block">
                                <div class="row">
                                    <!-- Form Start -->
                                    <div class="form-group col-md-6">
                                        <label for="student">{{ __('field_student_id') }} <span>*</span></label>
                                        <select class="form-control select2" name="student" id="student" required>
                                            <option value="">{{ __('select') }}</option>
                                            @foreach ($students as $student)
                                                <option value="{{ $student->id }}"
                                                    @if (old('student') == $student->id) selected @endif>
                                                    {{ $student->student->student_id ?? '' }} -
                                                    {{ $student->student->first_name ?? '' }}
                                                    {{ $student->student->last_name ?? '' }} -
                                                    {{ $student->student->father_name ?? '' }} </option>
                                            @endforeach
                                        </select>

                                        <div class="invalid-feedback">
                                            {{ __('required_field') }} {{ __('field_student_id') }}
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="category">{{ __('field_fees_type') }} <span>*</span></label>
                                        <select class="form-control" name="category" id="category" required>
                                            <option value="">{{ __('select') }}</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    @if (old('category') == $category->id) selected @endif>
                                                    {{ $category->title }}</option>
                                            @endforeach
                                        </select>

                                        <div class="invalid-feedback">
                                            {{ __('required_field') }} {{ __('field_fees_type') }}
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="assign_date" class="form-label">{{ __('field_assign') }}
                                            {{ __('field_date') }} <span>*</span></label>
                                        <input type="date" class="form-control" name="assign_date" id="assign_date"
                                            value="{{ date('Y-m-d') }}" readonly required>

                                        <div class="invalid-feedback">
                                            {{ __('required_field') }} {{ __('field_assign') }} {{ __('field_date') }}
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="due_date" class="form-label">{{ __('field_due_date') }}
                                            <span>*</span></label>
                                        <input type="date" class="form-control date" name="due_date" id="due_date"
                                            value="{{ date('Y-m-d') }}" required>

                                        <div class="invalid-feedback">
                                            {{ __('required_field') }} {{ __('field_due_date') }}
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="amount" class="form-label">{{ __('field_amount') }}
                                            ({!! $setting->currency_symbol !!}) <span>*</span></label>
                                        <input type="text" class="form-control autonumber" name="amount" id="amount"
                                            value="{{ old('amount') }}" required>
                                        <small id="fee_text" class="form-text text-muted text-primary"></small>
                                        <div class="invalid-feedback">
                                            {{ __('required_field') }} {{ __('field_amount') }}
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="amount" class="form-label">{{ __('field_discount') }}
                                            ({!! $setting->currency_symbol !!}) <span>*</span></label>
                                        <input type="text" class="form-control autonumber" name="discount" id="discount"
                                            value="{{ old('amount') }}" required>
                                        <small id="discount_text" class="form-text text-muted text-primary"></small>
                                        <div class="invalid-feedback">
                                            {{ __('required_field') }} {{ __('field_amount') }}
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>{{ __('field_amount_type') }}</label><br />
                                        <div class="radio d-inline">
                                            <input type="radio" name="type" id="type_fixed" value="1"
                                                @if (old('type') == null) checked @elseif(old('type') == 1)  checked @endif>
                                            <label for="type_fixed" class="cr">{{ __('amount_type_fixed') }}</label>
                                        </div>
                                        <div class="radio d-inline">
                                            <input type="radio" name="type" id="type_per_credit" value="2"
                                                @if (old('type') == 2) checked @endif>
                                            <label for="type_per_credit"
                                                class="cr">{{ __('amount_type_per_credit') }}</label>
                                        </div>
                                    </div>
                                    <!-- Form End -->
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success"><i class="fas fa-check"></i>
                                    {{ __('btn_save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- [ Card ] end -->
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>
    <!-- End Content-->

@endsection

@section('page_js')
    <script type="text/javascript">
        // Function to convert number to words
        function numberToWords(num) {
            if (num === 0) return 'Zero';

            const a = [
                '', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten',
                'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen',
                'Eighteen', 'Nineteen'
            ];
            const b = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];

            const inWords = (n) => {
                if (n < 20) return a[n];
                if (n < 100) return b[Math.floor(n / 10)] + (n % 10 ? ' ' + a[n % 10] : '');
                if (n < 1000) return a[Math.floor(n / 100)] + ' Hundred' + (n % 100 ? ' ' + inWords(n % 100) : '');
                if (n < 100000) return inWords(Math.floor(n / 1000)) + ' Thousand' + (n % 1000 ? ' ' + inWords(n %
                    1000) : '');
                if (n < 10000000) return inWords(Math.floor(n / 100000)) + ' Lakh' + (n % 100000 ? ' ' + inWords(n %
                    100000) : '');
                if (n < 1000000000) return inWords(Math.floor(n / 10000000)) + ' Crore' + (n % 10000000 ? ' ' + inWords(
                    n % 10000000) : '');
                return 'Number too large';
            };

            return inWords(num);
        }


        // Event listener for input field
        document.getElementById('amount').addEventListener('input', function() {
            const feeAmount = this.value;
            const feeText = feeAmount ? numberToWords(parseInt(feeAmount)) : '';
            document.getElementById('fee_text').textContent = feeText ? `(${feeText})` : '';
        });

        // Event listener for input field
        document.getElementById('discount').addEventListener('input', function() {
            const feeAmount = this.value;
            const feeText = feeAmount ? numberToWords(parseInt(feeAmount)) : '';
            document.getElementById('discount_text').textContent = feeText ? `(${feeText})` : '';
        });
    </script>

@endsection
