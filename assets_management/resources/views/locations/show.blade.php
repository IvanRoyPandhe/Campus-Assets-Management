@extends('layouts.app')

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col-md-6">
        <h2 class="fw-bold text-dark">
            <i class="bi bi-geo-alt me-2"></i>Location Details
        </h2>
        <p class="text-muted">View complete information about this location</p>
    </div>
    <div class="col-md-6 text-end">
        <a href="{{ route('locations.index') }}" class="btn btn-secondary me-2">
            <i class="bi bi-arrow-left me-1"></i> Back to Locations
        </a>
        @if(auth()->user()->isAdmin())
            <a href="{{ route('locations.edit', $location) }}" class="btn btn-warning">
                <i class="bi bi-pencil me-1"></i> Edit Location
            </a>
        @endif
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">
                <i class="bi bi-info-circle me-2"></i>Location Information
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-3 fw-bold text-muted">Name:</div>
                    <div class="col-md-9 fs-5">{{ $location->name }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3 fw-bold text-muted">Building:</div>
                    <div class="col-md-9">{{ $location->building ?: 'N/A' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3 fw-bold text-muted">Floor:</div>
                    <div class="col-md-9">{{ $location->floor ?: 'N/A' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3 fw-bold text-muted">Room:</div>
                    <div class="col-md-9">{{ $location->room ?: 'N/A' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3 fw-bold text-muted">Description:</div>
                    <div class="col-md-9">{{ $location->description ?: 'No description available' }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4 align-items-center">
    <div class="col-md-6">
        <h3 class="fw-bold">Assets in this Location</h3>
        <p class="text-muted">Total: {{ $assets->total() }} assets</p>
    </div>
    <div class="col-md-6 text-end">
        @if(auth()->user()->isAdmin())
            <a href="{{ route('assets.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i> Add New Asset
            </a>
        @endif
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if($assets->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ASSET CODE</th>
                            <th>NAME</th>
                            <th>CATEGORY</th>
                            <th>CONDITION</th>
                            <th>PURCHASE DATE</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($assets as $asset)
                            <tr>
                                <td>
                                    <span class="fw-medium">{{ $asset->asset_code }}</span>
                                </td>
                                <td>{{ $asset->name }}</td>
                                <td>
                                    <span class="badge bg-light text-dark">
                                        @if($asset->category == 'furniture')
                                            <i class="bi bi-chair me-1"></i>
                                        @elseif($asset->category == 'electronics')
                                            <i class="bi bi-laptop me-1"></i>
                                        @elseif($asset->category == 'office equipment')
                                            <i class="bi bi-printer me-1"></i>
                                        @elseif($asset->category == 'laboratory equipment')
                                            <i class="bi bi-flask me-1"></i>
                                        @elseif($asset->category == 'sports equipment')
                                            <i class="bi bi-trophy me-1"></i>
                                        @else
                                            <i class="bi bi-box me-1"></i>
                                        @endif
                                        {{ ucfirst($asset->category) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{ $asset->condition === 'good' ? 'bg-success' : ($asset->condition === 'damaged' ? 'bg-danger' : ($asset->condition === 'under repair' ? 'bg-warning' : 'bg-secondary')) }}">
                                        @if($asset->condition === 'good')
                                            <i class="bi bi-check-circle me-1"></i>
                                        @elseif($asset->condition === 'damaged')
                                            <i class="bi bi-x-circle me-1"></i>
                                        @elseif($asset->condition === 'under repair')
                                            <i class="bi bi-tools me-1"></i>
                                        @else
                                            <i class="bi bi-dash-circle me-1"></i>
                                        @endif
                                        {{ ucfirst($asset->condition) }}
                                    </span>
                                </td>
                                <td>{{ $asset->purchase_date ? $asset->purchase_date->format('Y-m-d') : 'N/A' }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('assets.show', $asset) }}" class="btn btn-sm btn-info text-white">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        @if(auth()->user()->isAdmin())
                                            <a href="{{ route('assets.edit', $asset) }}" class="btn btn-sm btn-warning text-white">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $assets->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <img src="https://cdn-icons-png.flaticon.com/512/7486/7486754.png" alt="No assets" style="width: 120px; opacity: 0.5;" class="mb-3">
                <h4 class="text-muted">No assets found in this location</h4>
                <p class="text-muted mb-4">
                    @if(auth()->user()->isAdmin())
                        Add assets to this location
                    @else
                        No assets have been assigned to this location yet
                    @endif
                </p>
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('assets.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i> Add New Asset
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection