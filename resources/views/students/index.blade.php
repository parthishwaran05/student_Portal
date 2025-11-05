@extends('layouts.app')

@section('title', 'Students')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Student List</h1>
            <span class="badge bg-primary">Total: {{ $students->count() }} Students</span>
        </div>

        @if($students->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Course</th>
                        <th>Marks</th>
                        <th>Status</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                    <tr>
                        <td>{{ $student->id }}</td>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->email }}</td>
                        <td>{{ $student->course }}</td>
                        <td>{{ $student->marks }}</td>
                        <td>
                            <span class="badge {{ $student->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                                {{ ucfirst($student->status) }}
                            </span>
                        </td>
                        <td>{{ $student->created_at->format('M d, Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="alert alert-info">
            <h4>No Students Found</h4>
            <p class="mb-0">There are no students in the database yet.</p>
        </div>
        @endif
    </div>
</div>
@endsection