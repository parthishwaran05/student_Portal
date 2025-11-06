<?php

use App\Http\Controllers\Api\StudentController;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Public API routes with advanced filtering
Route::get('/students', function (Request $request) {
    $query = Student::query();
    
    // Search by name, email, or course
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
    
    // Filter by minimum marks
    if ($request->has('min_marks') && $request->min_marks != '') {
        $query->where('marks', '>=', $request->min_marks);
    }
    
    // Filter by maximum marks
    if ($request->has('max_marks') && $request->max_marks != '') {
        $query->where('marks', '<=', $request->max_marks);
    }
    
    // Sort by field
    if ($request->has('sort_by') && $request->sort_by != '') {
        $sortOrder = $request->has('sort_order') ? $request->sort_order : 'asc';
        $query->orderBy($request->sort_by, $sortOrder);
    } else {
        $query->orderBy('id', 'desc');
    }
    
    // Pagination
    $perPage = $request->has('per_page') ? $request->per_page : 10;
    $students = $query->paginate($perPage);
    
    return StudentResource::collection($students);
});

// Backward compatibility - Search students by name or course
Route::get('/students/search/{query}', function ($query) {
    $students = Student::where('name', 'like', "%{$query}%")
                        ->orWhere('course', 'like', "%{$query}%")
                        ->get();
    
    return StudentResource::collection($students);
});

// Backward compatibility - Filter students by status
Route::get('/students/filter/{status}', function ($status) {
    $students = Student::where('status', $status)->get();
    return StudentResource::collection($students);
});

// Individual student operations
Route::get('/students/{id}', function ($id) {
    $student = Student::find($id);
    
    if (!$student) {
        return response()->json([
            'error' => 'Student not found',
            'message' => 'The requested student does not exist.'
        ], 404);
    }

    return new StudentResource($student);
});

Route::post('/students', [StudentController::class, 'store']);
Route::put('/students/{id}', [StudentController::class, 'update']);
Route::delete('/students/{id}', [StudentController::class, 'destroy']);