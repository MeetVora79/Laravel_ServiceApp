@extends('layouts.back')
@section('title', 'Organization')
@section('content')
<section class="section">
    <div class="section-header">
      <h1>Organization</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route(Auth::user()->getDashboardRouteName()) }}">Dashboard</a></div>
        <div class="breadcrumb-item">Organizations</div>
      </div>
    </div>

    <div class="section-body">

      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h4>Manage Organizations</h4>
              <div class="card-header-form">
                @can('create-user')
                    <a href="{{ route('organizations.create') }}" class="btn btn-success btn-sm my-2"><i class="bi bi-plus-circle"></i> Add New Organization</a>
                @endcan
              </div>
            </div>
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table table-striped">
                  <tr>
                    <th scope="col">Organization Id</th>
                    <th scope="col">Organization Name</th>
                    <th scope="col">Action</th>
                  </tr>
                  @forelse ($organizations as $organization)
                <tr>
                    <!-- <th scope="row">{{ $loop->iteration }}</th> -->
                    <td>{{ $organization->OrganizationId }}</td>
                    <td>{{ $organization->OrganizationName }}</td>
                    <td>
                        <form action="{{ route('organizations.destroy', $organization->OrganizationId) }}" method="post">
                            @csrf
                            @method('DELETE')

                            <a href="{{ route('organizations.show', $organization->OrganizationId) }}" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Show"><i class="bi bi-eye"></i> </a>

                            <a href="{{ route('organizations.edit', $organization->OrganizationId) }}" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="bi bi-pencil-square"></i> </a>

                            @if(auth()->user()->role == 1)
                            <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" onclick="return confirm('Do you want to delete this organizations?');"><i class="bi bi-trash"></i> </button>
                            @endif

                        </form>
                    </td>
                </tr>
                @empty
                    <td colspan="5">
                        <span class="text-danger">
                            <strong>No Organization Found!</strong>
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