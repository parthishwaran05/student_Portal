<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ExportController extends Controller
{
    public function exportStudentsCSV(Request $request)
    {
        $fileName = 'students_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $students = Student::query();
        
        // Apply filters if present
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $students->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('course', 'like', "%{$search}%");
            });
        }
        
        if ($request->has('status') && $request->status != '') {
            $students->where('status', $request->status);
        }

        $students = $students->orderBy('id', 'desc')->get();

        $columns = ['ID', 'Name', 'Email', 'Course', 'Marks', 'Status', 'Created At'];

        $callback = function() use ($students, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($students as $student) {
                $row = [
                    $student->id,
                    $student->name,
                    $student->email,
                    $student->course,
                    $student->marks,
                    $student->status,
                    $student->created_at->format('Y-m-d H:i:s')
                ];

                fputcsv($file, $row);
            }
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
    
    public function exportAllStudentsCSV()
    {
        return $this->exportStudentsCSV(new Request());
    }
}
