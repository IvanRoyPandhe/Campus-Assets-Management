@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-md-6">
        <h2>Add New Location</h2>
    </div>
    <div class="col-md-6 text-end">
        <a href="{{ route('locations.index') }}" class="btn btn-secondary">
            Back to Locations
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('locations.store') }}" method="POST">
            @csrf
            
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="name" class="form-label">Location Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="building" class="form-label">Building</label>
                        <input type="text" class="form-control @error('building') is-invalid @enderror" id="building" name="building" value="{{ old('building') }}">
                        @error('building')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="floor" class="form-label">Floor</label>
                        <input type="text" class="form-control @error('floor') is-invalid @enderror" id="floor" name="floor" value="{{ old('floor') }}">
                        @error('floor')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="room" class="form-label">Room</label>
                        <input type="text" class="form-control @error('room') is-invalid @enderror" id="room" name="room" value="{{ old('room') }}">
                        @error('room')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="submit" class="btn btn-primary">Save Location</button>
            </div>
        </form>
    </div>
</div>
@endsection