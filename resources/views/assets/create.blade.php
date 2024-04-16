@extends('layouts.back')
@section('title', 'Create Asset')
@push('styles')
<link rel="stylesheet" href="{{ asset('backend/assets/modules/select2/dist/css/select2.min.css') }}">
@endpush
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Create New Asset</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route(Auth::user()->getDashboardRouteName()) }}">Dashboard</a></div>
            <div class="breadcrumb-item">Assets</div>
        </div>
    </div>
    <div class="section-body">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Asset Information</h4>
                        <div class="card-header-form">
                            <a href="{{ url()->previous() }}" class="btn btn-primary btn-sm">&larr; Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('assets.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <p class="text-right"><strong>Date : <?php $mytime = Carbon\Carbon::now()->format('d-m-Y');
                                                                    echo $mytime; ?></strong></p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3 row">
                                        <label for="AssetCusId" class="col-md-4 col-form-label text-md-end text-start"><strong>Customer Name</strong></label>
                                        <div class="col-md-6">
                                            <select class="form-control @error('AssetCusId') is-invalid @enderror" aria-label="Customer Name" id="AssetCusId" name="AssetCusId" required>
                                                <option>Select Name</option>
                                                @forelse ($customers as $customer)
                                                <option value="{{  $customer->CustomerId }}">
                                                    {{ $customer->firstname }} {{ $customer->lastname }}
                                                </option>
                                                @empty
                                                @endforelse
                                            </select>
                                            @if ($errors->has('AssetCusId'))
                                            <span class="text-danger">{{ $errors->first('AssetCusId') }}</span>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="mb-3 row">
                                        <label for="AssetName" class="col-md-4 col-form-label text-md-end text-start"><strong>Asset Name</strong></label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control @error('AssetName') is-invalid @enderror" id="AssetName" name="AssetName" value="{{ old('AssetName') }}" required>
                                            @if ($errors->has('AssetName'))
                                            <span class="text-danger">{{ $errors->first('AssetName') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="AssetSerialNum" class="col-md-4 col-form-label text-md-end text-start"><strong>Asset Serial No.</strong></label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control @error('AssetSerialNum') is-invalid @enderror" id="AssetSerialNum" name="AssetSerialNum" value="{{ old('AssetSerialNum') }}" required>
                                            @if ($errors->has('AssetSerialNum'))
                                            <span class="text-danger">{{ $errors->first('AssetSerialNum') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="AssetTypeId" class="col-md-4 col-form-label text-md-end text-start"><strong>Asset Type</strong></label>
                                        <div class="col-md-6">
                                            <select class="form-control @error('AssetTypeId') is-invalid @enderror" aria-label="Asset Type" id="AssetTypeId" name="AssetTypeId" required>
                                                <option>Select Type</option>
                                                @forelse ($assettypes as $type)
                                                <option value="{{  $type->AssetTypeId }}">
                                                    {{ $type->AssetTypeName }}
                                                </option>
                                                @empty
                                                @endforelse
                                            </select>
                                            @if ($errors->has('AssetTypeId'))
                                            <span class="text-danger">{{ $errors->first('AssetTypeId') }}</span>
                                            @endif
                                        </div><a href="{{ route('assettype.create') }}" class="btn btn-light btn-sm my-2"><i class=""> </i>New</a>
                                    </div>


                                    <div class="mb-3 row">
                                        <label for="AssetDescription" class="col-md-4 col-form-label text-md-end text-start"><strong>Asset Description</strong></label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control @error('AssetDescription') is-invalid @enderror" id="AssetDescription" name="AssetDescription" value="{{ old('AssetDescription') }}" required>
                                            @if ($errors->has('AssetDescription'))
                                            <span class="text-danger">{{ $errors->first('AssetDescription') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="AssetDepartmentId" class="col-md-4 col-form-label text-md-end text-start"><strong>Asset Department</strong></label>
                                        <div class="dropdown col-md-6">
                                            <select class="form-control @error('AssetDepartmentId') is-invalid @enderror " aria-label="Asset Department" id="AssetDepartmentId" name="AssetDepartmentId" required>
                                                <option>Select Department</option>
                                                @forelse ($assetdepartments as $department)
                                                <option value="{{  $department->DepartmentId }}">
                                                    {{ $department->DepartmentName }}
                                                </option>
                                                @empty
                                                @endforelse
                                            </select>
                                            @if ($errors->has('AssetDepartmentId'))
                                            <span class="text-danger">{{ $errors->first('AssetDepartmentId') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="AssetOrganizationId" class="col-md-4 col-form-label text-md-end text-start"><strong>Asset Organization</strong></label>
                                        <div class="col-md-6">
                                            <select class="form-control @error('AssetOrganizationId') is-invalid @enderror " aria-label="Asset Organization" id="AssetOrganizationId" name="AssetOrganizationId" required>
                                                <option>Select Organization</option>
                                                @forelse ($assetorganizations as $organization)
                                                <option value="{{  $organization->OrganizationId }}">
                                                    {{ $organization->OrganizationName }}
                                                </option>
                                                @empty
                                                @endforelse
                                            </select>
                                            @if ($errors->has('AssetOrganizationId'))
                                            <span class="text-danger">{{ $errors->first('AssetOrganizationId') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="AssetLocation" class="col-md-4 col-form-label text-md-end text-start"><strong>Asset Location</strong></label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control @error('AssetLocation') is-invalid @enderror" id="AssetLocation" name="AssetLocation" value="{{ old('AssetLocation') }}" required>
                                            @if ($errors->has('AssetLocation'))
                                            <span class="text-danger">{{ $errors->first('AssetLocation') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="AssetManagedBy" class="col-md-4 col-form-label text-md-end text-start"><strong>Managed By</strong></label>
                                        <div class="col-md-6">
                                            <select class="form-control @error('AssetManagedBy') is-invalid @enderror " aria-label="Managed By" id="AssetManagedBy" name="AssetManagedBy" required>
                                                <option>Select Name</option>
                                                @forelse ($staffs as $staff)
                                                <option value="{{  $staff->StaffId }}">
                                                    {{ $staff->StaffName }}
                                                </option>
                                                @empty
                                                @endforelse
                                            </select>
                                            @if ($errors->has('AssetManagedBy'))
                                            <span class="text-danger">{{ $errors->first('AssetManagedBy') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">


                                    <div class="mb-3 row">
                                        <label for="AssetPurchaseDate" class="col-md-4 col-form-label text-md-end text-start"><strong>Purchase Date</strong></label>
                                        <div class="col-md-6">
                                            <input type="date" class="form-control @error('AssetPurchaseDate') is-invalid @enderror" id="AssetPurchaseDate" name="AssetPurchaseDate" value="{{ old('AssetPurchaseDate') }}" required>
                                            @if ($errors->has('AssetPurchaseDate'))
                                            <span class="text-danger">{{ $errors->first('AssetPurchaseDate') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="AssetWarrantyExpiryDate" class="col-md-4 col-form-label text-md-end text-start"><strong>Warranty Expiry Date</strong></label>
                                        <div class="col-md-6">
                                            <input type="date" class="form-control @error('AssetWarrantyExpiryDate') is-invalid @enderror" id="AssetWarrantyExpiryDate" name="AssetWarrantyExpiryDate" value="{{ old('AssetWarrantyExpiryDate') }}" required>
                                            @if ($errors->has('AssetWarrantyExpiryDate'))
                                            <span class="text-danger">{{ $errors->first('AssetWarrantyExpiryDate') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="AssetServiceTypeId" class="col-md-4 col-form-label text-md-end text-start"><strong>Service Type</strong></label>
                                        <div class="col-md-6">
                                            <select class="form-control @error('AssetServiceTypeId') is-invalid @enderror " aria-label="Managed By" id="AssetServiceTypeId" name="AssetServiceTypeId" required>
                                                <option>Select Type</option>
                                                @forelse ($services as $service)
                                                <option value="{{  $service->id }}">
                                                    {{ $service->ServiceDesc }}
                                                </option>
                                                @empty
                                                @endforelse
                                            </select>
                                            @if ($errors->has('AssetServiceTypeId'))
                                            <span class="text-danger">{{ $errors->first('AssetServiceTypeId') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="NumberOfServices" class="col-md-4 col-form-label text-md-end text-start"><strong>Number of Services</strong></label>
                                        <div class="col-md-6">
                                            <select class="form-control" id="NumberOfServices" name="NumberOfServices" required>
                                                <option value="">Select Number of Services</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row" id="datePickersContainer"></div>

                                    <div class="mb-3 row">
                                        <label for="AssetImage" class="col-md-4 col-form-label text-md-end text-start"><strong>Asset Image</strong></label>
                                        <div class="col-md-6">
                                            <input type="file" class="form-control @error('AssetImage') is-invalid @enderror" id="AssetImage" name="AssetImage" value="{{ old('AssetImage') }}" required>
                                            @if ($errors->has('AssetImage'))
                                            <span class="text-danger">{{ $errors->first('AssetImage') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="m-3 row">
                                <input type="submit" class="offset-md-5 btn btn-primary" value="Add Asset">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('scripts')
<script src="{{ asset('backend/assets/modules/select2/dist/js/select2.full.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
<!-- <script>
    document.addEventListener('DOMContentLoaded', (event) => {
        // Load saved data from LocalStorage
        if (localStorage.getItem('AssetName')) {
            document.getElementById('AssetName').value = localStorage.getItem('AssetName');
        }
        document.getElementById('AssetName').addEventListener('input', function() {
            localStorage.setItem('AssetName', this.value);
        });

        if (localStorage.getItem('AssetSerialNum')) {
            document.getElementById('AssetSerialNum').value = localStorage.getItem('AssetSerialNum');
        }
        document.getElementById('AssetSerialNum').addEventListener('input', function() {
            localStorage.setItem('AssetSerialNum', this.value);
        });

        if (localStorage.getItem('AssetDescription')) {
            document.getElementById('AssetDescription').value = localStorage.getItem('AssetDescription');
        }
        document.getElementById('AssetDescription').addEventListener('input', function() {
            localStorage.setItem('AssetDescription', this.value);
        });

        if (localStorage.getItem('AssetLocation')) {
            document.getElementById('AssetLocation').value = localStorage.getItem('AssetLocation');
        }
        document.getElementById('AssetLocation').addEventListener('input', function() {
            localStorage.setItem('AssetLocation', this.value);
        });


        // Assuming you're using jQuery for the select2 plugin
        $('#AssetCusId').on('change', function() {
            localStorage.setItem('AssetCusId', this.value);
        });
        if (localStorage.getItem('AssetCusId')) {
            $('#AssetCusId').val(localStorage.getItem('AssetCusId')).trigger('change');
        }

        $('#AssetTypeId').on('change', function() {
            localStorage.setItem('AssetTypeId', this.value);
        });
        if (localStorage.getItem('AssetTypeId')) {
            $('#AssetTypeId').val(localStorage.getItem('AssetTypeId')).trigger('change');
        }

        $('#AssetDepartmentId').on('change', function() {
            localStorage.setItem('AssetDepartmentId', this.value);
        });
        if (localStorage.getItem('AssetDepartmentId')) {
            $('#AssetDepartmentId').val(localStorage.getItem('AssetDepartmentId')).trigger('change');
        }

        $('#AssetOrganizationId').on('change', function() {
            localStorage.setItem('AssetOrganizationId', this.value);
        });
        if (localStorage.getItem('AssetOrganizationId')) {
            $('#AssetOrganizationId').val(localStorage.getItem('AssetOrganizationId')).trigger('change');
        }

        $('#AssetManagedBy').on('change', function() {
            localStorage.setItem('AssetManagedBy', this.value);
        });
        if (localStorage.getItem('AssetManagedBy')) {
            $('#AssetManagedBy').val(localStorage.getItem('AssetManagedBy')).trigger('change');
        }

        $('#AssetServiceTypeId').on('change', function() {
            localStorage.setItem('AssetServiceTypeId', this.value);
        });
        if (localStorage.getItem('AssetServiceTypeId')) {
            $('#AssetServiceTypeId').val(localStorage.getItem('AssetServiceTypeId')).trigger('change');
        }

        // Assuming the date input field has an ID of 'AssetDate'
        const assetDateInput = document.getElementById('AssetPurchaseDate');
        const savedDate = localStorage.getItem('AssetPurchaseDate');
        if (savedDate) {
            assetDateInput.value = savedDate;
        }
        assetDateInput.addEventListener('change', function() {
            localStorage.setItem('AssetPurchaseDate', this.value);
        });

        const ExpiryDate = document.getElementById('AssetWarrantyExpiryDate');
        const saveDate = localStorage.getItem('AssetWarrantyExpiryDate');
        if (saveDate) {
            ExpiryDate.value = saveDate;
        }
        ExpiryDate.addEventListener('change', function() {
            localStorage.setItem('AssetWarrantyExpiryDate', this.value);
        });

    });
</script> -->

<!-- <script>
    document.addEventListener('DOMContentLoaded', (event) => {
        // Load saved data from LocalStorage
        loadFormData();

        // Listen to form submit event
        document.querySelector('form').addEventListener('submit', function(event) {
            // Prevent the default form submission to handle the data first
            // event.preventDefault();
            
            // You can add your validation or AJAX submission logic here
            
            // Assuming the AJAX call or validation is successful, clear localStorage
            localStorage.clear();

            // You might want to submit the form programmatically if you are not doing AJAX and prevented the default action
            // this.submit(); // Uncomment if needed, ensure you're not causing an infinite loop
        });
    });

    function loadFormData() {
        const fields = ['AssetName', 'AssetSerialNum', 'AssetDescription', 'AssetLocation', 'AssetCusId', 'AssetTypeId', 'AssetDepartmentId', 'AssetOrganizationId', 'AssetManagedBy', 'AssetServiceTypeId', 'AssetPurchaseDate', 'AssetWarrantyExpiryDate'];

        fields.forEach(field => {
            const value = localStorage.getItem(field);
            if (value) {
                if (field.includes('Date') || !field.includes('Id')) {
                    document.getElementById(field).value = value;
                } else {
                    $(`#${field}`).val(value).trigger('change');
                }
            }
        });
    }

    localStorage.removeItem('AssetName');
    localStorage.removeItem('AssetSerialNum');
    localStorage.removeItem('AssetDescription');
    localStorage.removeItem('AssetLocation');
    localStorage.removeItem('AssetCusId');
    localStorage.removeItem('AssetTypeId');
    localStorage.removeItem('AssetDepartmentId');
    localStorage.removeItem('AssetOrganizationId');
    localStorage.removeItem('AssetManagedBy');
    localStorage.removeItem('AssetServiceTypeId');
    localStorage.removeItem('AssetPurchaseDate');
    localStorage.removeItem('AssetWarrantyExpiryDate');

</script> -->

<!-- <script>
    document.addEventListener('DOMContentLoaded', (event) => {
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(event) {
                sessionStorage.clear(); // Clears all sessionStorage
            });
        } else {
            console.log("Form not found");
        }
        // Restoration of form data
        document.querySelectorAll('form input, form select').forEach(element => {
            const savedValue = sessionStorage.getItem(element.name);
            if (savedValue) {
                element.value = savedValue;
            }
            // Save data on change
            element.addEventListener('input', function() {
                sessionStorage.setItem(this.name, this.value);
            });
        });

        if ($('.select2').length) {
            $('.select2').each(function() {
                // Initialize Select2
                $(this).select2();

                // Restore value from sessionStorage
                const savedValue = sessionStorage.getItem(this.name);
                if (savedValue !== null) {
                    $(this).val(savedValue).trigger('change');
                }

                // Save data on change
                $(this).on('change', function() {
                    sessionStorage.setItem(this.name, $(this).val());
                });
            });
        }
    });
</script> -->

<script>
    $(document).ready(function() {
        $('#NumberOfServices').on('change', function() {
            const numberOfServices = $(this).val();
            const datePickersContainer = $('#datePickersContainer');
            datePickersContainer.empty(); // Clear the previous date pickers

            for (let i = 0; i < numberOfServices; i++) {
                const date = new Date();
                date.setMonth(date.getMonth() + 3 * (i + 1)); // Calculate the date 3 months apart
                const formattedDate = date.toISOString().split('T')[0]; // Format the date to YYYY-MM-DD

                const datePickerHtml = `
                <label for="ServiceDate${i+1}" class="col-md-4 col-form-label text-md-end text-start"><strong>Service Date ${i+1}</strong></label>
                    <div class="mb-3 col-md-6">
                        <input type="date" class="form-control" name="ServiceDate[]" id="ServiceDate${i+1}" value="${formattedDate}" required>
                    </div>
                `;
                datePickersContainer.append(datePickerHtml);
            }
        });
    });
</script>

@endpush