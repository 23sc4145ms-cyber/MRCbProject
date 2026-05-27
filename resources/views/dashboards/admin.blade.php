@extends('format.layout')

@section('title', 'Dashboard')

@section('content')
<div style="min-height: 100vh; padding: 2rem;">
    
    <div style="max-width: 1400px; margin: 0 auto;">
        
        <!-- Welcome Header -->
        <div style="background: white; border-radius: 12px; padding: 2.5rem; margin-bottom: 2.5rem; box-shadow: 0 4px 6px rgba(171, 194, 139, 0.15); border-left: 5px solid #ABC28B;">
            <h1 style="color: #112C01; font-size: 2.5rem; font-weight: 700; margin: 0 0 0.5rem 0;">
                Welcome, {{ session('user')->username }}!
            </h1>
            <p style="color: #677C56; font-size: 1.1rem; margin: 0;">
                Administrator Dashboard
            </p>
        </div>

        <!-- Statistics Cards -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem;">
            
            <!-- Total Students -->
            <div style="background: linear-gradient(135deg, #ABC28B 0%, #90A854 100%); border-radius: 12px; padding: 2rem; box-shadow: 0 4px 6px rgba(171, 194, 139, 0.3); color: white;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <p style="margin: 0; font-size: 0.9rem; opacity: 0.9;">Total Students</p>
                        <h2 style="margin: 0.5rem 0 0 0; font-size: 3rem; font-weight: 700;">{{ $studentCount }}</h2>
                    </div>
                    <div style="width: 70px; height: 70px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem;">
                        🎓
                    </div>
                </div>
            </div>

            <!-- Total Teachers -->
            <div style="background: linear-gradient(135deg, #90A854 0%, #7a8f47 100%); border-radius: 12px; padding: 2rem; box-shadow: 0 4px 6px rgba(144, 168, 84, 0.3); color: white;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <p style="margin: 0; font-size: 0.9rem; opacity: 0.9;">Total Teachers</p>
                        <h2 style="margin: 0.5rem 0 0 0; font-size: 3rem; font-weight: 700;">{{ $teacherCount }}</h2>
                    </div>
                    <div style="width: 70px; height: 70px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem;">
                        👨‍🏫
                    </div>
                </div>
            </div>

            <!-- Total Courses -->
            <div style="background: linear-gradient(135deg, #677C56 0%, #556647 100%); border-radius: 12px; padding: 2rem; box-shadow: 0 4px 6px rgba(103, 124, 86, 0.3); color: white;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <p style="margin: 0; font-size: 0.9rem; opacity: 0.9;">Total Degree</p>
                        <h2 style="margin: 0.5rem 0 0 0; font-size: 3rem; font-weight: 700;">{{ $courseCount }}</h2>
                    </div>
                    <div style="width: 70px; height: 70px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem;">
                        📚
                    </div>
                </div>
            </div>

        </div>

        <!-- Quick Actions -->
        <div style="margin-top: 2rem; background: white; border-radius: 12px; padding: 1.75rem; box-shadow: 0 4px 6px rgba(171, 194, 139, 0.15); border-left: 5px solid #90A854;">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                <div>
                    <h3 style="margin: 0; color: #112C01; font-size: 1.25rem; font-weight: 700;">Quick Actions</h3>
                    <p style="margin: 0.35rem 0 0 0; color: #677C56;">Manage courses faster from the dashboard</p>
                </div>

                <div class="action-group">
                    <a href="{{ route('courses.create') }}" class="action-btn action-btn-view" style="text-transform: none;">
                        + Add Course
                    </a>
                    <a href="{{ route('courses.index') }}" class="action-btn action-btn-edit" style="text-transform: none;">
                        View Courses
                    </a>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
