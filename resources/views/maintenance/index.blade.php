@extends('layouts.back')
@section('title', 'Maintenance Management')
@push('styles')
<link rel="stylesheet" href="{{ asset('backend/assets/modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" integrity="sha384-4LISF5TTJX/fLmGSxO53rV4miRxdg84mZsxmO8Rx5jGtp/LbrixFETvWa5a6sESd" crossorigin="anonymous">
<style>
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
    <h1>Manage Maintenance</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route(Auth::user()->getDashboardRouteName()) }}">Dashboard</a></div>
      <div class="breadcrumb-item">Maintenance</div>
    </div>
  </div>

  <div class="section-body">

    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header justify-content-between">
            <h4>List of Maintenance</h4>
            <div class="search-box form-inline search-element">
              <form action="{{ route('maintenance.index') }}" method="GET">
                <input class="form-control" type="text" name="searchTerm" id="searchTerm" placeholder="Search..." value="{{ request('searchTerm', '') }}" aria-label="Search" data-width="250" required> <span class="clear-btn" onclick="clearAndRedirect()" style="display: none;">×</span>
                <button class="btn form-control" type="submit"><i class="fas fa-search"></i></button>
              </form>
            </div>

          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-striped">
                <tr>
                  <th scope="col">Asset Id<a href="{{ route('maintenance.index', ['sort' => 'AssetId', 'direction' => $nextDirection]) }}"><i class="fa fa-sort"></i></a></th>
                  <th scope="col">Asset Name<a href="{{ route('maintenance.index', ['sort' => 'AssetName', 'direction' => $nextDirection]) }}"><i class="fa fa-sort"></i></a></th>
                  <th scope="col">Customer Name</th>
                  <th scope="col">Maintenance Engineer</th>
                  <th scope="col">Maintenance Status</th>
                  <th scope="col">Service Type</th>
                  <th scope="col">Total Services</th>
                  <th scope="col">Warranty Expiry Date<a href="{{ route('maintenance.index', ['sort' => 'AssetWarrantyExpiryDate', 'direction' => $nextDirection]) }}"><i class="fa fa-sort"></i></a></th>
                  <th scope="col">Asset Image</th>
                  <th scope="col">Action</th>
                </tr>
                @forelse ($assets as $asset)
                <tr>
                  <td>{{ $asset->AssetId  }}</td>
                  <td>{{ $asset->AssetName }}</td>
                  <td>{{ $asset->customer->firstname }} {{ $asset->customer->lastname }}</td>
                  <td>{{ $asset->staff->StaffName  }}</td>
                  <td>{{ $asset->maintenanceStatus }}</td>
                  <td>{{ $asset->servicetype->ServiceDesc }}</td>
                  <td>{{ $asset->NumberOfServices }}</td>
                  <td>{{ $asset->AssetWarrantyExpiryDate }}</td>
                  <td><img style="width:80px; height:80px" src="{{asset('uploads/'.$asset->AssetImage)}}" alt="No Image Found!!"></td>
                  <td>
                    @if(auth()->user()->role == 1 || auth()->user()->role == 2)
                    <a href="{{ route('maintenance.create', $asset->AssetId) }}" class="btn btn-info btn-sm m-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Create Schedule"><i class="bi bi-plus-circle"></i> </a>
                    @endif
                  </td>
                </tr>
                @empty
                <td colspan="5">
                  <span class="text-danger">
                    <strong>No Maintenance Found!</strong>
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

<script>
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
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
      window.location.href = 'http://127.0.0.1:8000/maintenance';
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