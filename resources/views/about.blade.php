@extends('format.layout')

@section('title', 'About')

@section('content')

<div style="margin-bottom: 40px;">
    <h1 style="color: #ABC28B; font-size: 2.5rem; font-weight: 700; margin: 0;">About This Project</h1>
    <p style="color: #677C56; font-size: 1rem; margin-top: 0.5rem;">Learn more about our Student Management System</p>
</div>

<div style="background: #fff; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(171, 194, 139, 0.15);">
    <p style="font-size: 1rem; line-height: 1.8; margin-bottom: 1.5rem; color: #374151;">
        This project is a <strong style="color: #ABC28B;">Student Management Dashboard</strong> developed using 
        <strong style="color: #ABC28B;">Laravel Blade Templates</strong>. It demonstrates how Laravel can be used 
        to build dynamic and reusable web interfaces with modern design patterns.
    </p>

    <p style="font-size: 1rem; line-height: 1.8; margin-bottom: 1.5rem; color: #374151;">
        The system uses <strong style="color: #ABC28B;">Blade layout inheritance</strong> to maintain a consistent 
        design across pages. It also implements <strong style="color: #ABC28B;">loops</strong> and 
        <strong style="color: #ABC28B;">conditional statements</strong> to dynamically display student information with a clean UI.
    </p>

    <p style="font-size: 1rem; line-height: 1.8; color: #374151;">
        This project highlights the use of Laravel's templating features to create 
        a clean, organized, and maintainable web application interface with beautiful green-themed design aesthetics.
    </p>
</div>

@endsection