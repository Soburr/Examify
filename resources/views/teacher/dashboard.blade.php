@extends('layouts.teacher.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Welcome to Teacher Dashboard</div>
                <div class="card-body">
                    <h1>Hello, {{ Auth::user()->name }}! 👋</h1>
                    <p class="lead mt-4">Welcome back to Examify. We're glad to see you again!</p>
                    <p>You have everything you need to manage your exams and students right here.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection