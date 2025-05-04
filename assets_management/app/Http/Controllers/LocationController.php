<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Middleware\IsAdmin;

class LocationController extends BaseController
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
     * Display a listing of the locations.
     */
    public function index(): View
    {
        $locations = Location::withCount('assets')->latest()->paginate(10);
        
        return view('locations.index', compact('locations'));
    }

    /**
     * Show the form for creating a new location.
     */
    public function create(): View
    {
        return view('locations.create');
    }

    /**
     * Store a newly created location in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'building' => 'nullable|string|max:255',
            'floor' => 'nullable|string|max:255',
            'room' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);
        
        $location = Location::create($validated);
        
        return redirect()->route('locations.index')
            ->with('success', 'Location created successfully.');
    }

    /**
     * Display the specified location.
     */
    public function show(Location $location): View
    {
        $assets = $location->assets()->paginate(10);
        
        return view('locations.show', compact('location', 'assets'));
    }

    /**
     * Show the form for editing the specified location.
     */
    public function edit(Location $location): View
    {
        return view('locations.edit', compact('location'));
    }

    /**
     * Update the specified location in storage.
     */
    public function update(Request $request, Location $location): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'building' => 'nullable|string|max:255',
            'floor' => 'nullable|string|max:255',
            'room' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);
        
        $location->update($validated);
        
        return redirect()->route('locations.index')
            ->with('success', 'Location updated successfully.');
    }

    /**
     * Remove the specified location from storage.
     */
    public function destroy(Location $location): RedirectResponse
    {
        // Check if location has assets
        if ($location->assets()->count() > 0) {
            return redirect()->route('locations.index')
                ->with('error', 'Cannot delete location with associated assets.');
        }
        
        $location->delete();
        
        return redirect()->route('locations.index')
            ->with('success', 'Location deleted successfully.');
    }
}