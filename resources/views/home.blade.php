@extends('layouts.app')

@section('title', 'Home')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="jumbotron bg-light p-5 rounded">
            <h1 class="display-4">Welcome to {{ config('app.name') }}</h1>
            <p class="lead">Your gateway to academic excellence and student resources.</p>
            <hr class="my-4">
            <p>Access your courses, grades, and university resources all in one place.</p>
            <a class="btn btn-primary btn-lg" href="{{ route('about') }}" role="button">Learn More</a>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Course Management</h5>
                <p class="card-text">Manage your courses, view schedules, and access learning materials.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Grade Portal</h5>
                <p class="card-text">Check your grades and academic progress throughout the semester.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Student Resources</h5>
                <p class="card-text">Access library resources, counseling services, and campus events.</p>
            </div>
        </div>
    </div>
</div>
@endsection