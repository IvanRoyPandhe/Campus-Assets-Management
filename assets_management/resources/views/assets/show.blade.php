@extends('layouts.app')

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col-md-6">
        <h2 class="fw-bold text-dark">
            <i class="bi bi-box me-2"></i>Asset Details
        </h2>
        <p class="text-muted">View complete information about this asset</p>
    </div>
    <div class="col-md-6 text-end">
        <a href="{{ route('assets.index') }}" class="btn btn-secondary me-2">
            <i class="bi bi-arrow-left me-1"></i> Back to Assets
        </a>
        @if(auth()->user()->isAdmin())
            <a href="{{ route('assets.edit', $asset) }}" class="btn btn-warning">
                <i class="bi bi-pencil me-1"></i> Edit Asset
            </a>
        @endif
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-info-circle me-2"></i>Asset Information</span>
                <span class="badge {{ $asset->condition === 'good' ? 'bg-success' : ($asset->condition === 'damaged' ? 'bg-danger' : ($asset->condition === 'under repair' ? 'bg-warning' : 'bg-secondary')) }} px-3 py-2">
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
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-4 fw-bold text-muted">Asset Code:</div>
                    <div class="col-md-8">
                        <span class="badge bg-dark px-3 py-2 fw-normal">{{ $asset->asset_code }}</span>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-4 fw-bold text-muted">Name:</div>
                    <div class="col-md-8 fs-5">{{ $asset->name }}</div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-4 fw-bold text-muted">Category:</div>
                    <div class="col-md-8">
                        <span class="badge bg-light text-dark px-3 py-2">
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
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-4 fw-bold text-muted">Location:</div>
                    <div class="col-md-8">
                        <a href="{{ route('locations.show', $asset->location) }}" class="text-decoration-none">
                            <i class="bi bi-geo-alt me-1"></i>
                            {{ $asset->location->name }}
                        </a>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-4 fw-bold text-muted">Purchase Date:</div>
                    <div class="col-md-8">
                        @if($asset->purchase_date)
                            <i class="bi bi-calendar-date me-1"></i>
                            {{ $asset->purchase_date->format('Y-m-d') }}
                            <small class="text-muted ms-2">
                                ({{ $asset->purchase_date->diffForHumans() }})
                            </small>
                        @else
                            <span class="text-muted">N/A</span>
                        @endif
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-4 fw-bold text-muted">Description:</div>
                    <div class="col-md-8">
                        @if($asset->description)
                            {{ $asset->description }}
                        @else
                            <span class="text-muted">No description available</span>
                        @endif
                    </div>
                </div>
                
                <hr class="my-4">
                
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold text-muted">Created At:</div>
                    <div class="col-md-8">
                        <i class="bi bi-clock-history me-1"></i>
                        {{ $asset->created_at->format('Y-m-d H:i:s') }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold text-muted">Last Updated:</div>
                    <div class="col-md-8">
                        <i class="bi bi-clock me-1"></i>
                        {{ $asset->updated_at->format('Y-m-d H:i:s') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-qr-code me-2"></i>Asset QR Code
            </div>
            <div class="card-body qr-container">
                <div class="mb-4">
                    {!! $qrCode !!}
                </div>
                <p class="mb-1">Scan to view asset details</p>
                <small class="text-muted d-block mb-4">{{ $asset->asset_code }}</small>
                <div class="d-grid gap-2">
                    <button class="btn btn-primary" onclick="window.print();">
                        <i class="bi bi-printer me-2"></i> Print QR Code
                    </button>
                    <button class="btn btn-outline-secondary" onclick="downloadQR()">
                        <i class="bi bi-download me-2"></i> Download QR Code
                    </button>
                </div>
            </div>
        </div>
        
        @if(auth()->user()->isAdmin())
            <div class="card mt-4">
                <div class="card-header">
                    <i class="bi bi-gear me-2"></i>Asset Actions
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('assets.edit', $asset) }}" class="btn btn-warning">
                            <i class="bi bi-pencil me-2"></i> Edit Asset
                        </a>
                        <form action="{{ route('assets.destroy', $asset) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this asset?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="bi bi-trash me-2"></i> Delete Asset
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
    function downloadQR() {
        // Create a canvas from the QR code SVG
        const svg = document.querySelector('.qr-container svg');
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        
        // Set canvas dimensions
        canvas.width = svg.width.baseVal.value * 2;
        canvas.height = svg.height.baseVal.value * 2;
        
        // Create an image from the SVG
        const svgData = new XMLSerializer().serializeToString(svg);
        const img = new Image();
        
        img.onload = function() {
            // Draw white background
            ctx.fillStyle = 'white';
            ctx.fillRect(0, 0, canvas.width, canvas.height);
            
            // Draw the image
            ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
            
            // Create download link
            const link = document.createElement('a');
            link.download = '{{ $asset->asset_code }}_qr.png';
            link.href = canvas.toDataURL('image/png');
            link.click();
        };
        
        img.src = 'data:image/svg+xml;base64,' + btoa(svgData);
    }
</script>

<style>
    @media print {
        body * {
            visibility: hidden;
        }
        .qr-container, .qr-container * {
            visibility: visible;
        }
        .qr-container {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background: white;
        }
        .btn {
            display: none !important;
        }
    }
    
    .qr-container svg {
        max-width: 100%;
        height: auto;
    }
</style>
@endsection