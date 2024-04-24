@extends('layouts.back')
@section('title', 'Manage Roles')
@section('content')
<section class="section">
  <div class="section-header">
    <h1>Manage Roles</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route(Auth::user()->getDashboardRouteName()) }}">Dashboard</a></div>
      <div class="breadcrumb-item">Roles</div>
    </div>
  </div>

  <div class="section-body">

    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>Manage Roles</h4>
            <div class="card-header-form">
              <a href="{{ route('roles.create') }}" class="btn btn-success btn-sm my-2"><i class="bi bi-plus-circle"> </i>Add New Role</a>
            </div>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-striped">
                <tr>
                  <th scope="col">S#</th>
                  <th scope="col">Name</th>
                  <th scope="col" width="250px">Action</th>
                </tr>
                @forelse ($roles as $role)
                <tr>
                  <th scope="row">{{ $loop->iteration }}</th>
                  <td>{{ $role->name }}</td>
                  <td>
                    <form action="{{ route('roles.destroy', $role->id) }}" method="post">
                      @csrf
                      @method('DELETE')

                      <a href="{{ route('roles.show', $role->id) }}" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Show"><i class="bi bi-eye"></i> </a>

                      <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="bi bi-pencil-square"></i> </a>

                      @if ($role->name!='Admin')
                      @can('delete-role')
                      @if ($role->name!=Auth::user()->hasRole($role->name))
                      <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" onclick="return confirm('Do you want to delete this role?');"><i class="bi bi-trash"></i> </button>
                      @endif
                      @endcan
                      @endif
                    </form>
                  </td>
                </tr>
                @empty
                <td colspan="3">
                  <span class="text-danger">
                    <strong>No Role Found!</strong>
                  </span>
                </td>
                @endforelse
              </table>
              {{ $roles->links() }}
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

@endpush