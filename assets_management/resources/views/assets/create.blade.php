@extends('layouts.app')

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col-md-6">
        <h2 class="fw-bold text-dark">
            <i class="bi bi-plus-circle me-2"></i>Add New Asset
        </h2>
        <p class="text-muted">Create a new asset in the inventory system</p>
    </div>
    <div class="col-md-6 text-end">
        <a href="{{ route('assets.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i> Back to Assets
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <i class="bi bi-file-earmark-text me-2"></i>Asset Information
    </div>
    <div class="card-body">
        <form action="{{ route('assets.store') }}" method="POST">
            @csrf
            
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="name" class="form-label">
                            <i class="bi bi-tag me-1"></i> Asset Name
                        </label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required placeholder="Enter asset name">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="category" class="form-label">
                            <i class="bi bi-bookmark me-1"></i> Category
                        </label>
                        <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category }}" {{ old('category') == $category ? 'selected' : '' }}>
                                    @if($category == 'furniture')
                                        🪑 
                                    @elseif($category == 'electronics')
                                        💻 
                                    @elseif($category == 'office equipment')
                                        🖨️ 
                                    @elseif($category == 'laboratory equipment')
                                        🧪 
                                    @elseif($category == 'sports equipment')
                                        🏆 
                                    @else
                                        📦 
                                    @endif
                                    {{ ucfirst($category) }}
                                </option>
                            @endforeach
                        </select>
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="location_id" class="form-label">
                            <i class="bi bi-geo-alt me-1"></i> Location
                        </label>
                        <select class="form-select @error('location_id') is-invalid @enderror" id="location_id" name="location_id" required>
                            <option value="">Select Location</option>
                            @foreach($locations as $location)
                                <option value="{{ $location->id }}" {{ old('location_id') == $location->id ? 'selected' : '' }}>
                                    {{ $location->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('location_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text mt-2">
                            <a href="{{ route('locations.create') }}" class="text-primary">
                                <i class="bi bi-plus-circle me-1"></i> Add new location
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="condition" class="form-label">
                            <i class="bi bi-heart-pulse me-1"></i> Condition
                        </label>
                        <select class="form-select @error('condition') is-invalid @enderror" id="condition" name="condition" required>
                            <option value="">Select Condition</option>
                            @foreach($conditions as $condition)
                                <option value="{{ $condition }}" {{ old('condition') == $condition ? 'selected' : '' }}>
                                    @if($condition === 'good')
                                        ✅ 
                                    @elseif($condition === 'damaged')
                                        ❌ 
                                    @elseif($condition === 'under repair')
                                        🔧 
                                    @else
                                        ⚪ 
                                    @endif
                                    {{ ucfirst($condition) }}
                                </option>
                            @endforeach
                        </select>
                        @error('condition')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="purchase_date" class="form-label">
                            <i class="bi bi-calendar-date me-1"></i> Purchase Date
                        </label>
                        <input type="date" class="form-control @error('purchase_date') is-invalid @enderror" id="purchase_date" name="purchase_date" value="{{ old('purchase_date') }}">
                        @error('purchase_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="mb-4">
                <label for="description" class="form-label">
                    <i class="bi bi-file-text me-1"></i> Description
                </label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" placeholder="Enter asset description (optional)">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="d-flex justify-content-between align-items-center mt-4">
                <a href="{{ route('assets.index') }}" class="btn btn-light">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-2"></i> Save Asset
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header bg-light">
        <i class="bi bi-info-circle me-2"></i>Information
    </div>
    <div class="card-body">
        <p class="mb-0">
            <small class="text-muted">
                After creating this asset, a unique asset code and QR code will be automatically generated.
                You can print the QR code from the asset details page.
            </small>
        </p>
    </div>
</div>
@endsection