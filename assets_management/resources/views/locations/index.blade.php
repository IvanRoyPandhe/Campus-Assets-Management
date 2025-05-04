@extends('layouts.app')

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col-md-6">
        <h2 class="fw-bold text-dark">
            <i class="bi bi-geo-alt me-2"></i>Locations
        </h2>
        <p class="text-muted">Manage all campus facility locations</p>
    </div>
    <div class="col-md-6 text-end">
        @if(auth()->user()->isAdmin())
            <a href="{{ route('locations.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i> Add New Location
            </a>
        @endif
    </div>
</div>

<!-- Location Stats -->
<div class="row mb-4">
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="stat-card bg-gradient-primary">
            <div class="stat-icon">
                <i class="bi bi-geo-alt"></i>
            </div>
            <div class="stat-value">{{ $locations->total() }}</div>
            <div class="stat-label">Total Locations</div>
        </div>
    </div>
    
    @php
        $totalAssets = 0;
        foreach($locations as $location) {
            $totalAssets += $location->assets_count;
        }
        
        $avgAssets = $locations->count() > 0 ? round($totalAssets / $locations->count(), 1) : 0;
    @endphp
    
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="stat-card bg-gradient-info">
            <div class="stat-icon">
                <i class="bi bi-box-seam"></i>
            </div>
            <div class="stat-value">{{ $totalAssets }}</div>
            <div class="stat-label">Total Assets</div>
        </div>
    </div>
    
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="stat-card bg-gradient-success">
            <div class="stat-icon">
                <i class="bi bi-calculator"></i>
            </div>
            <div class="stat-value">{{ $avgAssets }}</div>
            <div class="stat-label">Avg. Assets per Location</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-list-ul me-2"></i>Location List</span>
        <div class="input-group" style="max-width: 300px;">
            <input type="text" class="form-control" placeholder="Search locations..." id="locationSearch">
            <button class="btn btn-outline-secondary" type="button">
                <i class="bi bi-search"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        @if($locations->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>NAME</th>
                            <th>BUILDING</th>
                            <th>FLOOR</th>
                            <th>ROOM</th>
                            <th>ASSETS</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($locations as $location)
                            <tr>
                                <td class="fw-medium">{{ $location->name }}</td>
                                <td>{{ $location->building ?: 'N/A' }}</td>
                                <td>{{ $location->floor ?: 'N/A' }}</td>
                                <td>{{ $location->room ?: 'N/A' }}</td>
                                <td>
                                    <span class="badge bg-info px-3 py-2">
                                        <i class="bi bi-box-seam me-1"></i> {{ $location->assets_count }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('locations.show', $location) }}" class="btn btn-sm btn-info text-white">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        @if(auth()->user()->isAdmin())
                                            <a href="{{ route('locations.edit', $location) }}" class="btn btn-sm btn-warning text-white">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('locations.destroy', $location) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this location?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" {{ $location->assets_count > 0 ? 'disabled' : '' }}>
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $locations->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <img src="https://cdn-icons-png.flaticon.com/512/854/854878.png" alt="No locations" style="width: 120px; opacity: 0.5;" class="mb-3">
                <h4 class="text-muted">No locations found</h4>
                <p class="text-muted mb-4">
                    @if(auth()->user()->isAdmin())
                        Start by adding your first location
                    @else
                        No locations have been added to the system yet
                    @endif
                </p>
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('locations.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i> Add New Location
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Simple search functionality
    document.getElementById('locationSearch').addEventListener('keyup', function() {
        const searchValue = this.value.toLowerCase();
        const tableRows = document.querySelectorAll('tbody tr');
        
        tableRows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchValue) ? '' : 'none';
        });
    });
</script>
@endsection