<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    /**
     * Display maintenance dashboard.
     */
    public function index()
    {
        $maintenances = Maintenance::latest()->get();
        $active = Maintenance::where('status', 'active')->first();
        return view('maintenance-dashboard', [
            'maintenances' => $maintenances,
            'active' => $active,
        ]);
    }

    /**
     * Show the form for creating a new maintenance.
     */
    public function create()
    {
        return view('maintenance-create');
    }

    /**
     * Store a newly created maintenance record.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'maintenance_type' => 'required|in:system,database,infrastructure,security,other',
            'status' => 'required|in:scheduled,active,completed,cancelled',
            'started_at' => 'required|date',
            'estimated_end_at' => 'required|date|after:started_at',
        ]);

        Maintenance::create($validated);

        return redirect()->route('maintenance.index')->with('success', 'Maintenance record created successfully.');
    }

    /**
     * Display the specified maintenance.
     */
    public function show(Maintenance $maintenance)
    {
        return view('maintenance-show', compact('maintenance'));
    }

    /**
     * Show the form for editing the specified maintenance.
     */
    public function edit(Maintenance $maintenance)
    {
        return view('maintenance-edit', compact('maintenance'));
    }

    /**
     * Update the specified maintenance in storage.
     */
    public function update(Request $request, Maintenance $maintenance)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'maintenance_type' => 'required|in:system,database,infrastructure,security,other',
            'status' => 'required|in:scheduled,active,completed,cancelled',
            'started_at' => 'required|date',
            'estimated_end_at' => 'required|date|after:started_at',
        ]);

        $maintenance->update($validated);

        return redirect()->route('maintenance.index')->with('success', 'Maintenance record updated successfully.');
    }

    /**
     * Delete the specified maintenance from storage.
     */
    public function destroy(Maintenance $maintenance)
    {
        $maintenance->delete();
        return redirect()->route('maintenance.index')->with('success', 'Maintenance record deleted successfully.');
    }

    /**
     * Activate maintenance mode.
     */
    public function activate(Maintenance $maintenance)
    {
        // Deactivate any other active maintenance
        Maintenance::where('status', 'active')->update(['status' => 'scheduled']);

        // Activate the selected maintenance
        $maintenance->update([
            'status' => 'active',
            'started_at' => now(),
        ]);

        return redirect()->route('maintenance.index')->with('success', 'Maintenance mode activated.');
    }

    /**
     * Deactivate maintenance mode.
     */
    public function deactivate(Maintenance $maintenance)
    {
        $maintenance->complete();
        return redirect()->route('maintenance.index')->with('success', 'Maintenance mode deactivated.');
    }
}
