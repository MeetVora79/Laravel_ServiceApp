@extends('layouts.back')
@section('title', 'Manage Tickets')
@push('styles')
<link rel="stylesheet" href="{{ asset('backend/assets/modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" integrity="sha384-4LISF5TTJX/fLmGSxO53rV4miRxdg84mZsxmO8Rx5jGtp/LbrixFETvWa5a6sESd" crossorigin="anonymous">
<style>
  .dropdown-menu li {
    position: relative;
  }

  .dropdown-menu .dropdown-submenu {
    display: none;
    position: absolute;
    left: 100%;
    top: -7px;
  }

  .dropdown-menu .dropdown-submenu-left {
    right: 100%;
    left: auto;
  }

  .dropdown-menu>li:hover>.dropdown-submenu {
    display: block;
  }

  .dropdown-hover:hover>.dropdown-menu {
    display: inline-block;
  }

  .dropdown-hover>.dropdown-toggle:active {
    /*Without this, clicking will make it sticky*/
    pointer-events: none;
  }

  .search-box {
    position: relative;
    display: inline-block;
  }

  .clear-btn {
    position: absolute;
    right: 60px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    background-color: transparent;
    border: none;
  }

  .clear-btn:hover {
    color: red;
  }
</style>
@endpush
@section('content')
<section class="section">
  <div class="section-header">
    <h1>List of Tickets</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route(Auth::user()->getDashboardRouteName()) }}">Dashboard</a></div>
      <div class="breadcrumb-item">Tickets</div>
    </div>
  </div>

  <div class="section-body">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header  justify-content-between">
            <h4> <a class="navbar-brand text-dark" href="{{ route('tickets.index') }}">All Tickets</a></h4>
            <div class="search-box form-inline search-element">
              <form action="{{ route('mytickets') }}" method="GET">
                <input class="form-control" type="text" name="searchTerm" id="searchTerm" placeholder="Search..." value="{{ request('searchTerm', '') }}" aria-label="Search" data-width="250" required> <span class="clear-btn" onclick="clearAndRedirect()" style="display: none;">×</span>
                <button class="btn form-control" type="submit"><i class="fas fa-search"></i></button>
              </form>
            </div>
            <div class="card-header-form">
              <a href="{{ route('tickets.mycreate') }}" class="btn btn-success btn-sm my-2"><i class="bi bi-plus-circle"> </i>Create Ticket</a>
              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Filter
              </button>
              <div class="dropdown-menu">
                <a href="{{ route('tickets.index', ['status' => 'Open']) }}" class="dropdown-item my-2">Open Tickets</a>
                <a href="{{ route('tickets.index', ['status' => 'Closed']) }}" class="dropdown-item my-2">Closed Tickets</a>
                <a href="{{ route('tickets.index', ['status' => 'Resolved']) }}" class="dropdown-item my-2">Resolved Tickets</a>
              </div>
            </div>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-striped">
                <tr>
                  <th scope="col">Ticket Id<a href="{{ route('mytickets', ['sort' => 'TicketId', 'direction' => $nextDirection]) }}"><i class="fa fa-sort"></i></a></th>
                  <th scope="col">Created By<a href="{{ route('mytickets', ['sort' => 'TicketCreaterId' , 'direction' => $nextDirection]) }}"><i class="fa fa-sort"></i></a></th>
                  <th scope="col">Asset Name</th>
                  <th scope="col">Subject</th>
                  <th scope="col">Priority</th>
                  <th scope="col">Allocation Status</th>
                  <th scope="col">Ticket Status</th>
                  <th scope="col">Attachments</th>
                  <th scope="col">Created At<a href="{{ route('mytickets', ['sort' => 'TicketCreatedAt', 'direction' => $nextDirection]) }}"><i class="fa fa-sort"></i></a></th>
                  <th scope="col">Action</th>
                </tr>
                @forelse ($tickets as $ticket)
                <tr>

                  <td>{{ $ticket->TicketId  }}</td>
                  <td>{{ $ticket->customer->firstname }} {{ $ticket->customer->lastname }}</td>
                  <td>{{ $ticket->asset->AssetName  }}</td>
                  <td>{{ $ticket->TicketSubject }}</td>
                  <td>{{ $ticket->priorityticket->PriorityName }}</td>
                  <td>{{ $ticket->allocationStatus }}</td>
                  <td>{{ $ticket->statusticket->StatusName }}</td>
                  <td><img style="width:80px; height:70px" src="{{asset('uploads/'.$ticket->Attachments)}}" alt="No Image Found!!"></td>
                  <td>{{ $ticket->TicketCreatedAt }}</td>
                  <td>
                    <form action="{{ route('myticketsdestroy', $ticket->TicketId) }}" method="post">
                      @csrf
                      @method('DELETE')

                      <a href="{{ route('myshow', $ticket->TicketId) }}" class="btn btn-warning btn-sm m-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Show"><i class="bi bi-eye"></i> </a>

                      <a href="{{ route('tickets.myedit', $ticket->TicketId) }}" class="btn btn-primary btn-sm m-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="bi bi-pencil-square"></i> </a>

                      <button type="submit" class="btn btn-danger btn-sm m-1" onclick="return confirm('Do you want to delete this ticket?');" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="bi bi-trash"></i> </button>

                    </form>
                  </td>
                </tr>
                @empty
                <td colspan="5">
                  <span class="text-danger">
                    <strong>No Ticket Found!</strong>
                  </span>
                </td>
                @endforelse
              </table>
            </div>
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
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
  })
</script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var searchTermInput = document.getElementById('searchTerm');
    var cancelButton = document.querySelector('.clear-btn');

    // Show the cancel button when the input field is focused or has text.
    function toggleCancelButton() {
      if (searchTermInput.value.length > 0 || searchTermInput === document.activeElement) {
        cancelButton.style.display = 'inline';
      } else {
        cancelButton.style.display = 'none';
      }
    }

    // Clear the input and redirect, or just hide the button on clear
    function clearAndRedirect() {
      searchTermInput.value = '';
      toggleCancelButton();
      searchTermInput.focus();
      window.location.href = 'http://127.0.0.1:8000/mytickets';
    }

    // Event listeners
    searchTermInput.addEventListener('input', toggleCancelButton);
    searchTermInput.addEventListener('focus', toggleCancelButton);
    searchTermInput.addEventListener('blur', toggleCancelButton);

    toggleCancelButton();
    cancelButton.onclick = clearAndRedirect;
  });
</script>

@endpush