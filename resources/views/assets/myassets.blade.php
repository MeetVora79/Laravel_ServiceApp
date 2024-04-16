@extends('layouts.back')
@section('title', 'Manage Assets')
@push('styles')
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
      <h1>Manage Assets</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route(Auth::user()->getDashboardRouteName()) }}">Dashboard</a></div>
        <div class="breadcrumb-item">Assets</div>
      </div>
    </div>

    <div class="section-body">

      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header justify-content-between">
              <h4>List My Assets</h4>
              <div class="search-box form-inline search-element">
              <form action="{{ route('assets.myassets') }}" method="GET">
                <input class="form-control" type="text" name="searchTerm" id="searchTerm" placeholder="Search..." value="{{ request('searchTerm', '') }}" aria-label="Search" data-width="250" required> <span class="clear-btn" onclick="clearAndRedirect()" style="display: none;">×</span>
                <button class="btn form-control" type="submit"><i class="fas fa-search"></i></button>
              </form>
            </div>
              <div class="card-header-form">               
                    <a href="{{ route('assets.create') }}" class="btn btn-success btn-sm my-2"><i class="bi bi-plus-circle"> </i>Add New Asset</a>
              </div>
            </div>
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table table-striped">
                  <tr>
                  <th scope="col">Asset Id<a href="{{ route('assets.myassets', ['sort' => 'AssetId', 'direction' => $nextDirection]) }}"><i class="fa fa-sort"></i></a></th>
                  <th scope="col">Customer Name</th>
                    <th scope="col">Asset Name<a href="{{ route('assets.myassets', ['sort' => 'AssetName', 'direction' => $nextDirection]) }}"><i class="fa fa-sort"></i></a></th>
                    <th scope="col">Asset Serial No.</th>
                    <th scope="col">Asset Type</th>
                    <th scope="col">Asset Department</th>
                    <th scope="col">Asset Organization</th>
                    <th scope="col">Asset Location<a href="{{ route('assets.myassets', ['sort' => 'AssetLocation', 'direction' => $nextDirection]) }}"><i class="fa fa-sort"></i></a></th>
                    <th scope="col">Managed BY</th>
                    <th scope="col">Service Type</th>
                    <th scope="col">Warranty Expiry Date<a href="{{ route('assets.myassets', ['sort' => 'AssetWarrantyExpiryDate', 'direction' => $nextDirection]) }}"><i class="fa fa-sort"></i></a></th>
                    <th scope="col">Asset Image</th>
                    <th scope="col">Action</th>
                  </tr>
                  @forelse ($assets as $asset)
                <tr>
                    <!-- <th scope="row">{{ $loop->iteration }}</th> -->
                    <td>{{ $asset->AssetId  }}</td>
                    <td>{{ $asset->customer->firstname }} {{ $asset->customer->lastname }}</td>
                    <td>{{ $asset->AssetName }}</td>
                    <td>{{ $asset->AssetSerialNum }}</td>
                    <td>{{ $asset->assettype->AssetTypeName  }}</td>
                    <td>{{ $asset->department->DepartmentName  }}</td>
                    <td>{{ $asset->organization->OrganizationName  }}</td>
                    <td>{{ $asset->AssetLocation }}</td>
                    <td>{{ $asset->staff->StaffName  }}</td>
                    <td>{{ $asset->servicetype->ServiceDesc }}</td>
                    <td>{{ $asset->AssetWarrantyExpiryDate }}</td>
                    <td><img style="width:80px; height:80px" src="{{asset('uploads/'.$asset->AssetImage)}}" alt="No Image Found!!"></td>
                    <td>
                        <form action="{{ route('assets.destroy', $asset->AssetId) }}" method="post">
                            @csrf
                            @method('DELETE')

                            <a href="{{ route('assets.show', $asset->AssetId) }}" class="btn btn-warning btn-sm m-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Show"><i class="bi bi-eye"></i> </a>

                            @if(auth()->user()->role == 1 || auth()->user()->role == 2)
                            <a href="{{ route('assets.edit', $asset->AssetId) }}" class="btn btn-primary btn-sm m-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="bi bi-pencil-square"></i> </a>
                            @endif

                            <button type="submit" class="btn btn-danger btn-sm m-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" onclick="return confirm('Do you want to delete this Asset?');"><i class="bi bi-trash"></i> </button>

                        </form>
                    </td>
                </tr>
                @empty
                    <td colspan="5">
                        <span class="text-danger">
                            <strong>No Asset Found!</strong>
                        </span>
                    </td>
                @endforelse
                </table>
                {{ $assets->links() }}
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
        window.location.href = 'http://127.0.0.1:8000/assets/myassets/list';
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
