<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Student::query();
        
        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('course', 'like', "%{$search}%");
            });
        }
        
        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        // Paginate with 10 students per page
        $students = $query->orderBy('id', 'desc')->paginate(10);
        
        return view('students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('students.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation rules
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email|max:255',
            'course' => 'required|string|max:255',
            'marks' => 'required|numeric|min:0|max:100',
            'status' => 'required|in:active,inactive'
        ], [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'This email has already been taken.',
            'course.required' => 'The course field is required.',
            'marks.required' => 'The marks field is required.',
            'marks.numeric' => 'The marks must be a number.',
            'marks.min' => 'The marks must be at least 0.',
            'marks.max' => 'The marks must not exceed 100.',
            'status.required' => 'The status field is required.',
            'status.in' => 'The status must be either active or inactive.'
        ]);

        Student::create($validated);

        return redirect()->route('students.index')
            ->with('success', 'Student created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        return view('students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        // Validation rules - email unique except current student
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $student->id . '|max:255',
            'course' => 'required|string|max:255',
            'marks' => 'required|numeric|min:0|max:100',
            'status' => 'required|in:active,inactive'
        ], [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'This email has already been taken.',
            'course.required' => 'The course field is required.',
            'marks.required' => 'The marks field is required.',
            'marks.numeric' => 'The marks must be a number.',
            'marks.min' => 'The marks must be at least 0.',
            'marks.max' => 'The marks must not exceed 100.',
            'status.required' => 'The status field is required.',
            'status.in' => 'The status must be either active or inactive.'
        ]);

        $student->update($validated);

        return redirect()->route('students.index')
            ->with('success', 'Student updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('students.index')
            ->with('success', 'Student deleted successfully!');
    }
}