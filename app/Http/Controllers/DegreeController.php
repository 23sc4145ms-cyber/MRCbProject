<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Degree;

class DegreeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $degrees = Degree::all();
        return view('degreeDetails')->with('degrees', $degrees);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('degreelayout.addDegree');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'Degree' => 'required|string|max:255|unique:degrees,Degree',
        ]);

        Degree::create([
            'Degree' => $request->input('Degree'),
        ]);
        
        return redirect()->route('degrees.index')->with('success', 'Degree added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $degree = Degree::find($id);
        return view('degreelayout.show')->with("degree", $degree);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $degree = Degree::find($id);
        return view('degreelayout.edit')->with('degree', $degree);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'Degree' => 'required|string|max:255|unique:degrees,Degree,' . $id,
        ]);

        $degree = Degree::find($id);
        $degree->update([
            'Degree' => $request->input('Degree'),
        ]);

        return redirect()->route('degrees.index')->with('success', 'Degree updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Degree::destroy($id);
        return redirect()->route('degrees.index')->with('success', 'Degree deleted successfully.');
    }
}
