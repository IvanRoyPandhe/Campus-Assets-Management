<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Middleware\IsAdmin;

class AssetController extends BaseController
{
    /**
     * Constructor to apply middleware
     */
    public function __construct()
    {
        $this->middleware(IsAdmin::class)->only([
            'create', 'store', 'edit', 'update', 'destroy'
        ]);
    }
    
    /**
     * Display a listing of the assets.
     */
    public function index(): View
    {
        $assets = Asset::with('location')->latest()->paginate(10);
        
        return view('assets.index', compact('assets'));
    }

    /**
     * Show the form for creating a new asset.
     */
    public function create(): View
    {
        $locations = Location::all();
        $conditions = ['good', 'damaged', 'under repair', 'disposed'];
        $categories = ['furniture', 'electronics', 'office equipment', 'laboratory equipment', 'sports equipment', 'other'];
        
        return view('assets.create', compact('locations', 'conditions', 'categories'));
    }

    /**
     * Store a newly created asset in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'location_id' => 'required|exists:locations,id',
            'condition' => 'required|in:good,damaged,under repair,disposed',
            'description' => 'nullable|string',
            'purchase_date' => 'nullable|date',
        ]);
        
        $asset = Asset::create($validated);
        
        return redirect()->route('assets.show', ['asset' => $asset->id])
            ->with('success', 'Asset created successfully.');
    }

    /**
     * Display the specified asset.
     */
    public function show(Asset $asset): View
    {
        // Generate QR code for the asset
        $qrCode = QrCode::size(200)->generate(route('assets.show', ['asset' => $asset->id]));
        
        return view('assets.show', compact('asset', 'qrCode'));
    }

    /**
     * Show the form for editing the specified asset.
     */
    public function edit(Asset $asset): View
    {
        $locations = Location::all();
        $conditions = ['good', 'damaged', 'under repair', 'disposed'];
        $categories = ['furniture', 'electronics', 'office equipment', 'laboratory equipment', 'sports equipment', 'other'];
        
        return view('assets.edit', compact('asset', 'locations', 'conditions', 'categories'));
    }

    /**
     * Update the specified asset in storage.
     */
    public function update(Request $request, Asset $asset): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'location_id' => 'required|exists:locations,id',
            'condition' => 'required|in:good,damaged,under repair,disposed',
            'description' => 'nullable|string',
            'purchase_date' => 'nullable|date',
        ]);
        
        $asset->update($validated);
        
        return redirect()->route('assets.show', ['asset' => $asset->id])
            ->with('success', 'Asset updated successfully.');
    }

    /**
     * Remove the specified asset from storage.
     */
    public function destroy(Asset $asset): RedirectResponse
    {
        $asset->delete();
        
        return redirect()->route('assets.index')
            ->with('success', 'Asset deleted successfully.');
    }
}