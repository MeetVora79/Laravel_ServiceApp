@extends('layouts.back')
@section('title', 'Create Ticket')
@push('styles')
    <link rel="stylesheet" href="{{ asset('backend/assets/modules/select2/dist/css/select2.min.css') }}">
@endpush
@section('content')
<section class="section">
    <div class="section-header">
      <h1>Create New Ticket</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route(Auth::user()->getDashboardRouteName()) }}">Dashboard</a></div>
        <div class="breadcrumb-item">Tickets</div>
      </div>
    </div>
    <div class="section-body">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Create Ticket</h4>
                        <div class="card-header-form">
                            <a href="{{ url()->previous() }}" class="btn btn-primary btn-sm">&larr; Back</a>
                        </div>                    
                    </div>

                    <div class="card-body">
                        
                        <form action="{{ route('tickets.store') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3 row" id="uncheckedContent" >
                                <label for="TicketCreaterId" class="col-md-2 col-form-label text-md-end text-start"><strong>Creater Name</strong></label>
                                <div class="col-md-4">
                                  <select class="form-control @error('TicketCreaterId') is-invalid @enderror " aria-label="Creater Name" id="TicketCreaterId" name="TicketCreaterId" required>
                                   <option>Select Your Name</option>
                                        @forelse ($customers as $customer)
                                            <option value="{{  $customer->CustomerId }}">
                                                {{ $customer->firstname }} {{ $customer->lastname }}
                                            </option>                                         
                                            @empty                               
                                        @endforelse
                                    </select>
                                    @if ($errors->has('TicketCreaterId'))
                                        <span class="text-danger">{{ $errors->first('TicketCreaterId') }}</span>
                                    @endif
                                </div>
                            </div>
             
                            <div class="mb-3 row">
                                <label for="TicketSubject" class="col-md-2 col-form-label text-md-end text-start"><strong>Subject</strong></label>
                                <div class="col-md-4">
                                  <input type="text" class="form-control @error('TicketSubject') is-invalid @enderror" id="TicketSubject" name="TicketSubject" value="{{ old('TicketSubject') }}" required>
                                    @if ($errors->has('TicketSubject'))
                                        <span class="text-danger">{{ $errors->first('TicketSubject') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="TicketAssetId" class="col-md-2 col-form-label text-md-end text-start"><strong>Asset Name</strong></label>
                                <div class="col-md-4">
                                  <select class="form-control @error('TicketAssetId') is-invalid @enderror " aria-label="Assets" id="TicketAssetId" name="TicketAssetId"  required>
                                   <option>Select Asset </option>
                                        @forelse ($assets as $asset)
                                            <option value="{{  $asset->AssetId }}" {{ (isset($ticket) && $ticket->TicketAssetId  == $asset->AssetId) ? 'selected' : '' }}>
                                                {{ $asset->AssetName }}
                                            </option>                                         
                                            @empty                               
                                        @endforelse
                                    </select>
                                    @if ($errors->has('TicketAssetId'))
                                        <span class="text-danger">{{ $errors->first('TicketAssetId') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="TicketPriorityId" class="col-md-2 col-form-label text-md-end text-start"><strong>Priority</strong></label>
                                <div class="col-md-4">
                                <select class="form-control @error('TicketPriorityId') is-invalid @enderror " aria-label="Priority" id="TicketPriorityId" name="TicketPriorityId"  required>
                                   <option>Select Priority </option>
                                        @forelse ($ticketpriority as $priority)
                                            <option value="{{  $priority->PriorityId }}" {{ (isset($ticket) && $ticket->TicketPriorityId  == $priority->PriorityId) ? 'selected' : '' }}>
                                                {{ $priority->PriorityName }}
                                            </option>                                         
                                            @empty                               
                                        @endforelse
                                    </select>
                                    @if ($errors->has('TicketPriorityId'))
                                        <span class="text-danger">{{ $errors->first('TicketPriorityId') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="TicketDescription" class="col-md-2 col-form-label text-md-end text-start"><strong>Description</strong></label>
                                <div class="col-md-4">
                                  <input type="text" class="form-control @error('TicketDescription') is-invalid @enderror" id="TicketDescription" name="TicketDescription" value="{{ old('TicketDescription') }}" required>
                                    @if ($errors->has('TicketDescription'))
                                        <span class="text-danger">{{ $errors->first('TicketDescription') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="Attachments" class="col-md-2 col-form-label text-md-end text-start"><strong>Attachments</strong></label>
                                <div class="col-md-4">
                                  <input type="file" class="form-control @error('Attachments') is-invalid @enderror" id="Attachments " name="Attachments" value="{{ old('Attachments') }}" required>
                                    @if ($errors->has('Attachments'))
                                        <span class="text-danger">{{ $errors->first('Attachments') }}</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="m-4 row">
                                <input type="submit" class="offset-md-2 btn btn-primary" value="Create Ticket">
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
    <script>
        // On page load, check if there's a saved value for the checkbox (assuming "checked" state is what's stored)
        document.addEventListener('DOMContentLoaded', function() {
        var isChecked = localStorage.getItem('toggleCheckbox') === 'true';a
        document.getElementById('toggleCheckbox').checked = isChecked;
        toggleContent(isChecked); // Call the toggle function on page load
        });

        document.getElementById('toggleCheckbox').addEventListener('change', function() {
        var isChecked = this.checked;
        localStorage.setItem('toggleCheckbox', isChecked); // Save the checkbox state
        toggleContent(isChecked);
        });

        function toggleContent(isChecked) {
        if (isChecked) {
            document.getElementById('checkedContent').style.display = 'flex';
            document.getElementById('uncheckedContent').style.display = 'none';
        } else {
            document.getElementById('checkedContent').style.display = 'none';
            document.getElementById('uncheckedContent').style.display = 'flex';
        }
        }


    </script>

@endpush

