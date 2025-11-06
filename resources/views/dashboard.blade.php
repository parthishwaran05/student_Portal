@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Dashboard</h1>
            <p class="lead">Welcome back, {{ Auth::user()->name }}!</p>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Student Management</h5>
                    <p class="card-text">Manage student records and information.</p>
                    <a href="{{ route('students.index') }}" class="btn btn-light">Go to Students</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Your Profile</h5>
                    <p class="card-text">Update your personal information and settings.</p>
                    <a href="{{ route('profile.edit') }}" class="btn btn-light">Edit Profile</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h5 class="card-title">Quick Stats</h5>
                    <p class="card-text">
                        <strong>Email:</strong> {{ Auth::user()->email }}<br>
                        <strong>Member since:</strong> {{ Auth::user()->created_at->format('M d, Y') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Show admin info if user is admin --}}
    @if(auth()->user()->email === 'admin@studentportal.com')
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-warning">
                <div class="card-header bg-warning">
                    <h5 class="mb-0">Admin Panel Access</h5>
                </div>
                <div class="card-body">
                    <p>You have administrator privileges. Access the admin panel for advanced management.</p>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-warning">Go to Admin Panel</a>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection