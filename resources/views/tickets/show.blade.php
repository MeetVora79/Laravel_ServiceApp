@extends('layouts.back')
@section('title', 'Ticket Information')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Ticket Information</h1>
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
                        <h4> Ticket Information</h4>
                        <div class="card-header-form">
                            <a href="{{  url()->previous() }}" class="btn btn-primary my-2"><i class="bi bi-arrow-left"></i>Back</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3 row">
                                    <label for="ticketid" class="col-md-4 col-form-label text-md-end text-start"><strong>Ticket Id:</strong></label>
                                    <div class="col-md-4" style="line-height: 35px;">
                                        {{ $ticket->TicketId }}
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="name" class="col-md-4 col-form-label text-md-end text-start"><strong>Creater Name:</strong></label>
                                    <div class="col-md-4" style="line-height: 35px;">
                                        {{ $ticket->customer->firstname }} {{ $ticket->customer->lastname }}
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="subject" class="col-md-4 col-form-label text-md-end text-start"><strong>Subject:</strong></label>
                                    <div class="col-md-4" style="line-height: 35px;">
                                        {{ $ticket->TicketSubject }}
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="name" class="col-md-4 col-form-label text-md-end text-start"><strong>Asset Name:</strong></label>
                                    <div class="col-md-4" style="line-height: 35px;">
                                        {{ $ticket->asset->AssetName  }}
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="name" class="col-md-4 col-form-label text-md-end text-start"><strong>Priority:</strong></label>
                                    <div class="col-md-4" style="line-height: 35px;">
                                        {{ $ticket->priorityticket->PriorityName  }}
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="name" class="col-md-4 col-form-label text-md-end text-start"><strong>Description:</strong></label>
                                    <div class="col-md-4" style="line-height: 35px;">
                                        {{ $ticket->TicketDescription }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3 row">
                                    <label for="name" class="col-md-4 col-form-label text-md-end text-start"><strong>Allocation Status:</strong></label>
                                    <div class="col-md-4" style="line-height: 35px;">
                                        {{ $ticket->allocationStatus  }}
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="name" class="col-md-4 col-form-label text-md-end text-start"><strong>Ticket Status:</strong></label>
                                    <div class="col-md-4" style="line-height: 35px;">
                                        {{ $ticket->statusticket->StatusName  }}
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="name" class="col-md-4 col-form-label text-md-end text-start"><strong>Ticket Created At:</strong></label>
                                    <div class="col-md-4" style="line-height: 35px;">
                                        {{ $ticket->TicketCreatedAt }}
                                    </div>
                                </div>
                                
                                <div class="mb-3 row">
                                    <label for="name" class="col-md-4 col-form-label text-md-end text-start"><strong>Attachments:</strong></label>
                                    <div class="col-md-4" style="line-height: 35px;">
                                        <img style="width:80px; height:80px" src="{{asset('uploads/'.$ticket->Attachments)}}" alt="No Image Found!!">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection