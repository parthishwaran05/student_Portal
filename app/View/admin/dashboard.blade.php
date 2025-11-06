@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Admin Dashboard</h1>
                <span class="badge bg-danger">Administrator</span>
            </div>
            
            <div class="alert alert-warning">
                <h5>Welcome, Administrator!</h5>
                <p class="mb-0">You have full access to the system management features.</p>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">System Information</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li><strong>Logged in as:</strong> {{ Auth::user()->name }}</li>
                        <li><strong>Email:</strong> {{ Auth::user()->email }}</li>
                        <li><strong>User ID:</strong> {{ Auth::user()->id }}</li>
                        <li><strong>Account Created:</strong> {{ Auth::user()->created_at->format('F d, Y') }}</li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('students.index') }}" class="btn btn-primary">Manage Students</a>
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-primary">User Dashboard</a>
                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary">Edit Profile</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Admin Features</h5>
                </div>
                <div class="card-body">
                    <p>This area is reserved for future administrative features:</p>
                    <ul>
                        <li>User management</li>
                        <li>System configuration</li>
                        <li>Reports and analytics</li>
                        <li>Database maintenance</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection