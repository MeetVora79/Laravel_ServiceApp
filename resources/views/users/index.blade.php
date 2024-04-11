@extends('layouts.back')
@section('title', 'Manage Staff')
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
    <h1>Manage Staff</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route(Auth::user()->getDashboardRouteName()) }}">Dashboard</a></div>
      <div class="breadcrumb-item">Staff</div>
    </div>
  </div>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header justify-content-between">
            <h4>All Staff</h4>
            <div class="search-box form-inline search-element">
              <form action="{{ route('users.index') }}" method="GET">
                <input class="form-control" type="text" name="searchTerm" id="searchTerm" placeholder="Search..." value="{{ request('searchTerm', '') }}" aria-label="Search" data-width="250" required> <span class="clear-btn" onclick="clearAndRedirect()" style="display: none;">×</span>
                <button class="btn form-control" type="submit"><i class="fas fa-search"></i></button>
              </form>
            </div>
            <div class="card-header-form">
              @can('create-user')
              <a href="{{ route('users.create') }}" class="btn btn-success btn-sm my-2"><i class="bi bi-plus-circle"></i> Add New Staff</a>
              @endcan
            </div>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-striped">
                <tr>
                  <th scope="col">S#<a href="{{ route('users.index', ['sort' => 'StaffId', 'direction' => $nextDirection]) }}"><i class="fa fa-sort"></i></a></th>
                  <th scope="col">Name<a href="{{ route('users.index', ['sort' => 'name', 'direction' => $nextDirection]) }}"><i class="fa fa-sort"></i></a></th>
                  <th scope="col">Mobile No.<a href="{{ route('users.index', ['sort' => 'mobile', 'direction' => $nextDirection]) }}"><i class="fa fa-sort"></i></a></th>
                  <th scope="col">Email<a href="{{ route('users.index', ['sort' => 'email', 'direction' => $nextDirection]) }}"><i class="fa fa-sort"></i></a></th>
                  <th scope="col">Address</th>
                  <th scope="col">Roles<a href="{{ route('users.index', ['sort' => 'role', 'direction' => $nextDirection]) }}"><i class="fa fa-sort"></i></a></th>
                  <th scope="col">Action</th>
                </tr>
                @forelse ($staffs as $staff)
                <tr>
                  <td>{{ $staff->StaffId }}</td>
                  <td>{{ $staff->StaffName }}</td>
                  <td>{{ $staff->mobile }}</td>   
                  <td>{{ $staff->email }}</td>   
                  <td>{{ $staff->address }}</td>   
                  <td><span class="badge bg-primary">{{ $staff->roles->name }}</span></td>
                  <td>
                    <form action="{{ route('users.destroy', $staff->StaffId) }}" method="post">
                      @csrf
                      @method('DELETE')

                      <a href="{{ route('users.show', $staff->StaffId) }}" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Show"><i class="bi bi-eye"></i></a>
                    
                      <a href="{{ route('users.edit', $staff->StaffId) }}" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="bi bi-pencil-square"></i></a>

                      @if(auth()->user()->role == 1 && auth()->user()->role !== $staff->role)
                      <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" onclick="return confirm('Do you want to delete this user?');"><i class="bi bi-trash"></i> </button>
                      @endif

                    </form>
                  </td>
                </tr>
                @empty
                <td colspan="5">
                  <span class="text-danger">
                    <strong>No Staff Found!</strong>
                  </span>
                </td>
                @endforelse
              </table>
              {{ $staffs->links() }}
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
        window.location.href = 'http://127.0.0.1:8000/staffs';
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