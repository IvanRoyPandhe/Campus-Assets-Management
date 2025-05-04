@extends('layouts.app')

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col-md-6">
        <h2 class="fw-bold text-dark"><i class="bi bi-boxes me-2"></i>Asset Management</h2>
        <p class="text-muted">Manage and track all campus assets</p>
    </div>
    <div class="col-md-6 text-end">
        @if(auth()->user()->isAdmin())
            <a href="{{ route('assets.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i> Add New Asset
            </a>
        @endif
    </div>
</div>

<!-- Dashboard Stats -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stat-card bg-gradient-primary">
            <div class="stat-icon">
                <i class="bi bi-box-seam"></i>
            </div>
            <div class="stat-value">{{ $assets->total() }}</div>
            <div class="stat-label">Total Assets</div>
        </div>
    </div>
    
    @php
        $goodCount = $assets->where('condition', 'good')->count();
        $damagedCount = $assets->where('condition', 'damaged')->count();
        $repairCount = $assets->where('condition', 'under repair')->count();
    @endphp
    
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stat-card bg-gradient-success">
            <div class="stat-icon">
                <i class="bi bi-check-circle"></i>
            </div>
            <div class="stat-value">{{ $goodCount }}</div>
            <div class="stat-label">Good Condition</div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stat-card bg-gradient-warning">
            <div class="stat-icon">
                <i class="bi bi-tools"></i>
            </div>
            <div class="stat-value">{{ $repairCount }}</div>
            <div class="stat-label">Under Repair</div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stat-card bg-gradient-danger">
            <div class="stat-icon">
                <i class="bi bi-exclamation-triangle"></i>
            </div>
            <div class="stat-value">{{ $damagedCount }}</div>
            <div class="stat-label">Damaged</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-list-ul me-2"></i>Asset List</span>
        <div class="input-group" style="max-width: 300px;">
            <input type="text" class="form-control" placeholder="Search assets..." id="assetSearch">
            <button class="btn btn-outline-secondary" type="button">
                <i class="bi bi-search"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        @if($assets->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ASSET CODE</th>
                            <th>NAME</th>
                            <th>CATEGORY</th>
                            <th>LOCATION</th>
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
                                <td>{{ $asset->location->name }}</td>
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
                                            <form action="{{ route('assets.destroy', $asset) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this asset?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
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
                {{ $assets->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <img src="https://cdn-icons-png.flaticon.com/512/7486/7486754.png" alt="No assets" style="width: 120px; opacity: 0.5;" class="mb-3">
                <h4 class="text-muted">No assets found</h4>
                <p class="text-muted mb-4">
                    @if(auth()->user()->isAdmin())
                        Start by adding your first asset
                    @else
                        No assets have been added to the system yet
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

@section('scripts')
<script>
    // Simple search functionality
    document.getElementById('assetSearch').addEventListener('keyup', function() {
        const searchValue = this.value.toLowerCase();
        const tableRows = document.querySelectorAll('tbody tr');
        
        tableRows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchValue) ? '' : 'none';
        });
    });
</script>
@endsection