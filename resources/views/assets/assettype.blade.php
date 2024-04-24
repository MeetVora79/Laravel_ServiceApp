@extends('layouts.back')
@section('title', 'Create AssetType')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>New Asset Type</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route(Auth::user()->getDashboardRouteName()) }}">Dashboard</a></div>
            <div class="breadcrumb-item">Assets</div>
        </div>
    </div>
    <div class="section-body">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Create Asset Type</h4>
                        <div class="card-header-form">
                            <a href="{{ url()->previous() }}" class="btn btn-primary btn-sm">&larr; Back</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('storeAssetType') }}" method="post">
                            @csrf
                            <div class="mb-3 mt-2 row">
                                <label for="AssetTypeName" class="col-md-2 col-form-label text-start"><strong>Asset Type:</strong></label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control @error('AssetTypeName') is-invalid @enderror" id="AssetTypeName" name="AssetTypeName" value="{{ old('AssetTypeName') }}" required>
                                    @if ($errors->has('AssetTypeName'))
                                    <span class="text-danger">{{ $errors->first('AssetTypeName') }}</span>
                                    @endif
                                </div>
                                <input type="submit" class="offset-md-1 btn btn-primary" value="Add">
                            </div>
                            <div class="mb-3 row"></div>
                        </form>
                        <hr>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tr>
                                <th scope="col">Asset Type Id</th>
                                <th scope="col">Asset Type</th>
                                <th scope="col">Action</th>
                            </tr>
                            @forelse ($assettypes as $assettype)
                            <tr>
                                <td>{{ $assettype->AssetTypeId }}</td>
                                <td>{{ $assettype->AssetTypeName }}</td>
                                <td>
                                    <form action="{{ route('deleteAssetType', $assettype->AssetTypeId) }}" method="post">
                                        @csrf
                                        @method('DELETE')

                                        <a href="{{ route('editAssetType', $assettype->AssetTypeId) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"></i> </a>

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
                        {{ $assettypes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('scripts')

@endpush