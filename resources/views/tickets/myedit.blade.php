@extends('layouts.back')
@section('title', 'Edit Ticket')
@push('styles')
    <link rel="stylesheet" href="{{ asset('backend/assets/modules/select2/dist/css/select2.min.css') }}">
@endpush
@section('content')
<section class="section">
    <div class="section-header">
      <h1>Manage Ticket</h1>
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
                        <h4>Edit Ticket</h4>
                        <div class="card-header-form">
                                <a href="{{  url()->previous() }}" class="btn btn-primary my-2"><i class="bi bi-arrow-left"></i>Back</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('myupdate', $ticket->TicketId) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method("PUT")

                           <div class="mb-3 row" >
                                <label for="TicketCreaterId" class="col-md-2 col-form-label text-md-end text-start"><strong>Creater Name</strong></label>
                                <div class="col-md-4">
                                <select class="form-control @error('TicketCreaterId') is-invalid @enderror select2 col-md-11" aria-label="Assets" id="TicketCreaterId" name="TicketCreaterId"  required>
                                   <option>Select Asset </option>
                                        @forelse ($customers as $customer)
                                            <option value="{{  $customer->CustomerId }}" {{ (isset($ticket) && $ticket->TicketCreaterId  == $customer->CustomerId) ? 'selected' : '' }}>
                                                {{ $customer->firstname }}  {{ $customer->lastname }}
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
                                  <input type="text" class="form-control @error('TicketSubject') is-invalid @enderror" id="TicketSubject" name="TicketSubject" value="{{ $ticket->TicketSubject }}" required>
                                    @if ($errors->has('TicketSubject'))
                                        <span class="text-danger">{{ $errors->first('TicketSubject') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="TicketAssetId" class="col-md-2 col-form-label text-md-end text-start"><strong>Assets</strong></label>
                                <div class="col-md-4">
                                  <select class="form-control @error('TicketAssetId') is-invalid @enderror select2 col-md-11" aria-label="Assets" id="AssetId" name="TicketAssetId"  required>
                                   <option>Select Asset </option>
                                        @forelse ($assets as $asset)
                                            <option value="{{  $asset->AssetId }}" {{ (isset($ticket) && $ticket->TicketAssetId  == $asset->AssetId) ? 'selected' : '' }}>
                                                {{ $asset->AssetName }}
                                            </option>                                         
                                            @empty                               
                                        @endforelse
                                    </select>
                                    @if ($errors->has('TicketAssetId  '))
                                        <span class="text-danger">{{ $errors->first('TicketAssetId') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="TicketPriorityId " class="col-md-2 col-form-label text-md-end text-start"><strong>Priority</strong></label>
                                <div class="col-md-4">
                                <select class="form-control @error('TicketPriorityId') is-invalid @enderror select2 col-md-11" aria-label="Priority" id="PriorityId" name="TicketPriorityId" required>
                                   <option>Select Priority </option>
                                        @forelse ($ticketpriorities as $priority)
                                            <option value="{{  $priority->PriorityId }}" {{ (isset($ticket) && $ticket->TicketPriorityId  == $priority->PriorityId) ? 'selected' : '' }}>
                                                {{ $priority->PriorityName }}
                                            </option>                                         
                                            @empty                               
                                        @endforelse
                                    </select>
                                    @if ($errors->has('TicketPriorityId '))
                                        <span class="text-danger">{{ $errors->first('TicketPriorityId ') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="TicketDescription" class="col-md-2 col-form-label text-md-end text-start"><strong>Description</strong></label>
                                <div class="col-md-4">
                                  <input type="text" class="form-control @error('TicketDescription ') is-invalid @enderror" id="TicketDescription" name="TicketDescription" value="{{ $ticket->TicketDescription }}" required>
                                    @if ($errors->has('TicketDescription '))
                                        <span class="text-danger">{{ $errors->first('TicketDescription ') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3 row">
                                        <label for="Attachments" class="col-md-2 col-form-label text-md-end text-start"><strong>Current Attachment</strong></label>
                                        <div class="col-md-4 ">
                                            <span class="form-control"> {{ $ticket->Attachments }} </span>
                                        </div>
                                    </div>

                            <div class="mb-3 row">
                                <label for="Attachments" class="col-md-2 col-form-label text-md-end text-start"><strong>New Attachment</strong></label>
                                <div class="col-md-4">
                                  <input type="file" class="form-control @error('Attachments') is-invalid @enderror" id="Attachments" name="Attachments" value="{{ $ticket->Attachments }}">
                                    @if ($errors->has('Attachments'))
                                        <span class="text-danger">{{ $errors->first('Attachments') }}</span>
                                    @endif
                                </div>
                            </div>
                            

                            <div class="m-4 row">
                                <input type="submit" class="offset-md-2 btn btn-primary" value="Update Ticket">
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
        var isChecked = localStorage.getItem('toggleCheckbox') === 'true';
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
