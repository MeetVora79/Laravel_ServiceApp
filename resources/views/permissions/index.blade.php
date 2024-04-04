@extends('layouts.back')
@section('title', 'Manage Permissions')
@section('content')
<section class="section">
    <div class="section-header">
      <h1>Manage Permissions</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route(Auth::user()->getDashboardRouteName()) }}">Dashboard</a></div>
        <div class="breadcrumb-item">Permissions</div>
      </div>
    </div>

    <div class="section-body">

      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h4>List of Permissions</h4>
              <div class="card-header-form">
                @can('create-user')
                    <a href="{{ route('permissions.create') }}" class="btn btn-success btn-sm my-2"><i class="bi bi-plus-circle"></i> Add New Permissions</a>
                @endcan
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
                  @forelse ($permissions as $permission)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $permission->name }}</td>
                        <td>
                            <form action="{{ route('permissions.destroy', $permission->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                @can('edit-permission')
                                    <a href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="bi bi-pencil-square"></i> </a>
                                @endcan

                                @can('delete-permission')
                                    <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" onclick="return confirm('Do you want to delete this role?');"><i class="bi bi-trash"></i> </button>

                                @endcan

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
                {{ $permissions->links() }}
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