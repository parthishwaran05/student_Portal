@extends('layouts.app')

@section('title', 'Student Details')
@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">Student Details</h3>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-3">ID:</dt>
                    <dd class="col-sm-9">{{ $student->id }}</dd>

                    <dt class="col-sm-3">Name:</dt>
                    <dd class="col-sm-9">{{ $student->name }}</dd>

                    <dt class="col-sm-3">Email:</dt>
                    <dd class="col-sm-9">{{ $student->email }}</dd>

                    <dt class="col-sm-3">Course:</dt>
                    <dd class="col-sm-9">{{ $student->course }}</dd>

                    <dt class="col-sm-3">Marks:</dt>
                    <dd class="col-sm-9">{{ $student->marks }}</dd>

                    <dt class="col-sm-3">Status:</dt>
                    <dd class="col-sm-9">
                        <span class="badge {{ $student->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                            {{ ucfirst($student->status) }}
                        </span>
                    </dd>

                    <dt class="col-sm-3">Created At:</dt>
                    <dd class="col-sm-9">{{ $student->created_at->format('M d, Y h:i A') }}</dd>

                    <dt class="col-sm-3">Updated At:</dt>
                    <dd class="col-sm-9">{{ $student->updated_at->format('M d, Y h:i A') }}</dd>
                </dl>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('students.index') }}" class="btn btn-secondary">Back to List</a>
                    <div>
                        <a href="{{ route('students.edit', $student->id) }}" class="btn btn-primary">Edit</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

