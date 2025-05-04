@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-md-6">
        <h2>Edit Asset</h2>
    </div>
    <div class="col-md-6 text-end">
        <a href="{{ route('assets.show', $asset) }}" class="btn btn-secondary">
            Back to Asset Details
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('assets.update', $asset) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="asset_code" class="form-label">Asset Code</label>
                        <input type="text" class="form-control" id="asset_code" value="{{ $asset->asset_code }}" disabled readonly>
                    </div>
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="name" class="form-label">Asset Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $asset->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category }}" {{ old('category', $asset->category) == $category ? 'selected' : '' }}>{{ ucfirst($category) }}</option>
                            @endforeach
                        </select>
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="location_id" class="form-label">Location</label>
                        <select class="form-select @error('location_id') is-invalid @enderror" id="location_id" name="location_id" required>
                            <option value="">Select Location</option>
                            @foreach($locations as $location)
                                <option value="{{ $location->id }}" {{ old('location_id', $asset->location_id) == $location->id ? 'selected' : '' }}>{{ $location->name }}</option>
                            @endforeach
                        </select>
                        @error('location_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="condition" class="form-label">Condition</label>
                        <select class="form-select @error('condition') is-invalid @enderror" id="condition" name="condition" required>
                            <option value="">Select Condition</option>
                            @foreach($conditions as $condition)
                                <option value="{{ $condition }}" {{ old('condition', $asset->condition) == $condition ? 'selected' : '' }}>{{ ucfirst($condition) }}</option>
                            @endforeach
                        </select>
                        @error('condition')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="purchase_date" class="form-label">Purchase Date</label>
                        <input type="date" class="form-control @error('purchase_date') is-invalid @enderror" id="purchase_date" name="purchase_date" value="{{ old('purchase_date', $asset->purchase_date ? $asset->purchase_date->format('Y-m-d') : '') }}">
                        @error('purchase_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $asset->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="submit" class="btn btn-primary">Update Asset</button>
            </div>
        </form>
    </div>
</div>
@endsection