<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::latest()->paginate(10);
        return view('subject.index', compact('subjects'));
    }

    public function create()
    {
        return view('subject.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:20', 'unique:subjects,code'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'units' => ['required', 'integer', 'min:1', 'max:6'],
        ]);

        Subject::create($validated);

        return redirect()->route('subjects.index')->with('success', 'Subject created successfully.');
    }

    public function show(string $id)
    {
        $subject = Subject::with('students')->findOrFail($id);
        return view('subject.show', compact('subject'));
    }

    public function edit(string $id)
    {
        $subject = Subject::findOrFail($id);
        return view('subject.edit', compact('subject'));
    }

    public function update(Request $request, string $id)
    {
        $subject = Subject::findOrFail($id);
        
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:20', 'unique:subjects,code,'.$id],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'units' => ['required', 'integer', 'min:1', 'max:6'],
        ]);

        $subject->update($validated);

        return redirect()->route('subjects.index')->with('success', 'Subject updated successfully.');
    }

    public function destroy(string $id)
    {
        $subject = Subject::findOrFail($id);
        $subject->delete();

        return redirect()->route('subjects.index')->with('success', 'Subject deleted successfully.');
    }
}
