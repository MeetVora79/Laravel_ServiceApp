@extends('layouts.back')
@section('title', 'Departments')
@section('content')
<section class="section">
    <div class="section-header">
      <h1>Departments</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route(Auth::user()->getDashboardRouteName()) }}">Dashboard</a></div>
        <div class="breadcrumb-item">Departments</div>
      </div>
    </div>

    <div class="section-body">

      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h4>Manage Departments</h4>
              <div class="card-header-form">
                @can('create-user')
                    <a href="{{ route('departments.create') }}" class="btn btn-success btn-sm my-2"><i class="bi bi-plus-circle"></i> Add New Department</a>
                @endcan
              </div>
            </div>
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table table-striped">
                  <tr>
                    <th scope="col">Department Id</th>
                    <th scope="col">Department Name</th>
                    <th scope="col">Action</th>
                  </tr>
                  @forelse ($departments as $department)
                <tr>
                    <td>{{ $department->DepartmentId }}</td>
                    <td>{{ $department->DepartmentName }}</td>
                    <td>
                        <form action="{{ route('departments.destroy', $department->DepartmentId) }}" method="post">
                            @csrf
                            @method('DELETE')

                            <a href="{{ route('departments.show', $department->DepartmentId) }}" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Show"><i class="bi bi-eye"></i> </a>

                            <a href="{{ route('departments.edit', $department->DepartmentId) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"></i> </a>

                            @if(auth()->user()->role == 1)
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this departments?');"><i class="bi bi-trash" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"></i> </button>
                            @endif

                        </form>
                    </td>
                </tr>
                @empty
                    <td colspan="5">
                        <span class="text-danger">
                            <strong>No Department Found!</strong>
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
    return new bootstrap.Tooltip(tooltipTriggerEl)
  })
</script>

@endpush