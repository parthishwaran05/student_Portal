@extends('layouts.app')

@section('title', 'About Us')
@section('content')
<div class="row">
    <div class="col-12">
        <h1>About {{ config('app.name') }}</h1>
        <p class="lead">Learn more about our student portal and its features.</p>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <h3>Our Mission</h3>
        <p>To provide students with a comprehensive digital platform that enhances their academic experience and simplifies access to educational resources.</p>
        
        <h3>Features</h3>
        <ul>
            <li>Course registration and management</li>
            <li>Grade tracking and reporting</li>
            <li>Resource library access</li>
            <li>Communication tools</li>
            <li>Campus event calendar</li>
        </ul>
    </div>
    
    <div class="col-md-6">
        <h3>Contact Information</h3>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Student Support</h5>
                <p class="card-text">
                    <strong>Email:</strong> support@studentportal.edu<br>
                    <strong>Phone:</strong> (555) 123-4567<br>
                    <strong>Hours:</strong> Mon-Fri, 8:00 AM - 5:00 PM
                </p>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-body">
                <h5 class="card-title">Technical Support</h5>
                <p class="card-text">
                    <strong>Email:</strong> techsupport@studentportal.edu<br>
                    <strong>Phone:</strong> (555) 123-4568<br>
                    <strong>Hours:</strong> 24/7
                </p>
            </div>
        </div>
    </div>
</div>
@endsection