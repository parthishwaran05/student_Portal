@extends('layouts.app')

@section('title', 'Students')

@section('content')
<div class="container">
    {{-- Flash Messages --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- Rest of your existing students index content remains the same --}}
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Student List</h1>
                <div>
                    <span class="badge bg-primary me-2">Total: {{ $students->total() }} Students</span>
                    
                    {{-- Export Button --}}
                    @if($students->count() > 0)
                    <div class="btn-group">
                        <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fas fa-download"></i> Export
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="{{ route('students.export.all') }}">
                                    Export All Students
                                </a>
                            </li>
                            @if(request()->hasAny(['search', 'status']))
                            <li>
                                <a class="dropdown-item" href="{{ route('students.export.filtered', request()->query()) }}">
                                    Export Filtered Results
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                    @endif
                    
                    <a href="{{ route('students.create') }}" class="btn btn-success ms-2">
                        <i class="fas fa-plus"></i> Add New Student
                    </a>
                </div>
            </div>

            {{-- Search and Filter Form --}}
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Search & Filter</h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('students.index') }}">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" 
                                       placeholder="Search by name, email, or course..." 
                                       value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <select name="status" class="form-select">
                                    <option value="">All Status</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
                            </div>
                            <div class="col-md-2">
                                <a href="{{ route('students.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Rest of your table code remains exactly the same --}}
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
                            <th>Actions</th>
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
                            <td>
                                <a href="{{ route('students.show', $student->id) }}" class="btn btn-info btn-sm">View</a>
                                <a href="{{ route('students.edit', $student->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
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

            {{-- Pagination --}}
            @if($students->hasPages())
            <div class="row mt-4">
                <div class="col-12">
                    <nav aria-label="Student pagination">
                        <ul class="pagination justify-content-center">
                            {{-- Previous Page Link --}}
                            @if($students->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link">Previous</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $students->previousPageUrl() }}" rel="prev">Previous</a>
                                </li>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach($students->getUrlRange(1, $students->lastPage()) as $page => $url)
                                @if($page == $students->currentPage())
                                    <li class="page-item active">
                                        <span class="page-link">{{ $page }}</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if($students->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $students->nextPageUrl() }}" rel="next">Next</a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link">Next</span>
                                </li>
                            @endif
                        </ul>
                    </nav>
                    
                    {{-- Pagination Info --}}
                    <div class="text-center text-muted">
                        <small>
                            Showing {{ $students->firstItem() }} to {{ $students->lastItem() }} 
                            of {{ $students->total() }} students
                        </small>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
