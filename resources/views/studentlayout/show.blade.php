@extends('format.layout')

@section('title')
    Student Details
@endsection

@section('content')
    <div style="margin-bottom: 40px;">
        <h1 style="color: #ec4899; font-size: 2.5rem; font-weight: 700; margin: 0;">Student Details</h1>
        <p style="color: #9f1239; font-size: 1rem; margin-top: 0.5rem;">View and manage student information</p>
    </div>

    @if(session('success'))
    <div style="padding: 1rem; background-color: #fce7f3; border-left: 4px solid #ec4899; border-radius: 4px; margin-bottom: 1.5rem; color: #9f1239;">
        {{ session('success') }}
    </div>
    @endif

    <div style="display: grid; grid-template-columns: 1fr; gap: 2rem;">
        @foreach($students as $student)
        <div style="background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px rgba(236, 72, 153, 0.15);">
            
            <!-- Premium Header Section -->
            <div style="background: linear-gradient(135deg, #ec4899 0%, #db2777 100%); padding: 3rem 2rem; color: #fff; position: relative; overflow: hidden;">
                <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(255, 255, 255, 0.1); border-radius: 50%;"></div>
                <div style="position: absolute; bottom: -30px; left: -30px; width: 150px; height: 150px; background: rgba(255, 255, 255, 0.1); border-radius: 50%;"></div>
                
                <div style="position: relative; z-index: 1;">
                    <div style="display: flex; align-items: center; gap: 2rem;">
                        <!-- Avatar Circle -->
                        <div style="width: 100px; height: 100px; background: rgba(255, 255, 255, 0.25); border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 4px solid rgba(255, 255, 255, 0.5);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="white" viewBox="0 0 16 16">
                                <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm.027 6c.11.25.022.515-.674.51a3.97 3.97 0 0 1-1.596-.694.997.997 0 0 0-1.314.913c-.048.169-.054.38-.054.608 0 .868.601 1.538 1.6 1.538h5.945c1 0 1.6-.67 1.6-1.538 0-.228-.006-.44-.054-.607a.998.998 0 0 0-1.315-.914 3.97 3.97 0 0 1-1.596.693c-.696.005-.786-.26-.675-.51.236-.4.557-.826.93-1.122.368-.296.713-.472 1.005-.477a.968.968 0 0 0 .814-.497 36.6 36.6 0 0 0 2.228-1.204 1 1 0 0 0 .437-1.122A.987.987 0 0 0 15.146 7h-2.184a1 1 0 0 0-.822.402l-.675 1.012a.5.5 0 0 1-.419.208h-3.09a.5.5 0 0 1-.419-.208l-.675-1.012a1 1 0 0 0-.822-.402h-2.184a.987.987 0 0 0-.953.953 36.6 36.6 0 0 0 2.228 1.204 1 1 0 0 0 .437 1.122 3.95 3.95 0 0 1 .93 1.122z"/>
                            </svg>
                        </div>
                        
                        <!-- Student Info -->
                        <div>
                            <h2 style="margin: 0 0 0.5rem 0; font-size: 2rem; font-weight: 700;">{{ $student->fname }}</h2>
                            <p style="margin: 0 0 0.75rem 0; opacity: 0.9; font-size: 1rem;">{{ $student->mname }} {{ $student->lname }}</p>
                            <div style="display: flex; gap: 1rem; margin-top: 1rem;">
                                <span style="background: rgba(255, 255, 255, 0.2); padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.875rem; font-weight: 600;">ID: {{ $student->id }}</span>
                                <span style="background: rgba(255, 255, 255, 0.2); padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.875rem; font-weight: 600;">Active ✓</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Details Section -->
            <div style="padding: 2rem;">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem;">
                    
                    <!-- Email Card -->
                    <div style="padding: 1.5rem; background: linear-gradient(135deg, #fdf2f8 0%, #fbecf8 100%); border-radius: 12px; border-left: 4px solid #ec4899;">
                        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.75rem;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#ec4899" viewBox="0 0 16 16">
                                <path d="M4 4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H4Zm0 1h8a1 1 0 0 1 1 1v.217l-7 4.2-7-4.2V6a1 1 0 0 1 1-1Z"/>
                            </svg>
                            <label style="color: #ec4899; font-weight: 600; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px; margin: 0;">Email Address</label>
                        </div>
                        <p style="margin: 0; color: #374151; font-size: 1.125rem; font-weight: 600; word-break: break-word;">{{ $student->user->email }}</p>
                    </div>

                    <!-- Contact Card -->
                    <div style="padding: 1.5rem; background: linear-gradient(135deg, #fce7f3 0%, #fdf2f8 100%); border-radius: 12px; border-left: 4px solid #f59e0b;">
                        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.75rem;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#f59e0b" viewBox="0 0 16 16">
                                <path d="M3.854 3.854c3.122-3.129 8.196-3.129 11.319 0l.464.464a1 1 0 1 1-1.415 1.414l-.464-.464c-2.343-2.343-6.145-2.343-8.488 0l-.464.464a1 1 0 1 1-1.414-1.414l.464-.464Zm1.414 1.415a.5.5 0 0 1 .707 0l.707.707a.5.5 0 1 1-.707.707l-.707-.707a.5.5 0 0 1 0-.707Z"/>
                            </svg>
                            <label style="color: #f59e0b; font-weight: 600; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px; margin: 0;">Contact Number</label>
                        </div>
                        <p style="margin: 0; color: #374151; font-size: 1.125rem; font-weight: 600;">{{ $student->contact }}</p>
                    </div>

                    <!-- Course Card -->
                    <div style="padding: 1.5rem; background: linear-gradient(135deg, #dbeafe 0%, #e0f2fe 100%); border-radius: 12px; border-left: 4px solid #06b6d4;">
                        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.75rem;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#06b6d4" viewBox="0 0 16 16">
                                <path d="M4.5 13a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1h-8zm7-12H4.5a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2z"/>
                                <path d="M8 5.5a.5.5 0 1 1 0 1 .5.5 0 0 1 0-1zm0 2a.5.5 0 1 1 0 1 .5.5 0 0 1 0-1zm0 2a.5.5 0 1 1 0 1 .5.5 0 0 1 0-1z"/>
                            </svg>
                            <label style="color: #06b6d4; font-weight: 600; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px; margin: 0;">Course/Degree</label>
                        </div>
                        <p style="margin: 0; color: #374151; font-size: 1.125rem; font-weight: 600;">{{ $student->course?->name ?? 'Not Assigned' }}</p>
                    </div>

                    <!-- Status Card -->
                    <div style="padding: 1.5rem; background: linear-gradient(135deg, #f0fdf4 0%, #f0fdf4 100%); border-radius: 12px; border-left: 4px solid #22c55e;">
                        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.75rem;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#22c55e" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="m10.97 4.97-.02.02-3.6 3.85-1.74-1.885a.75.75 0 0 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.1-.043l4.131-4.441a.75.75 0 0 0-1.06-1.06z"/>
                            </svg>
                            <label style="color: #22c55e; font-weight: 600; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px; margin: 0;">Status</label>
                        </div>
                        <p style="margin: 0; color: #374151; font-size: 1.125rem; font-weight: 600;">Enrolled</p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div style="display: flex; gap: 1rem; margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #fce7f3;">
                    <a href="/students/{{ $student->id }}/edit" style="flex: 1; padding: 1rem; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: #fff; text-decoration: none; border-radius: 8px; font-weight: 600; text-align: center; transition: all 0.3s ease; box-shadow: 0 4px 6px rgba(245, 158, 11, 0.2);" 
                       onmouseover="this.style.boxShadow='0 8px 12px rgba(245, 158, 11, 0.3)'; this.style.transform='translateY(-2px)';" 
                       onmouseout="this.style.boxShadow='0 4px 6px rgba(245, 158, 11, 0.2)'; this.style.transform='translateY(0)';">
                        ✏️ Edit Information
                    </a>
                    <form action="/students/{{ $student->id }}" method="POST" style="flex: 1;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="width: 100%; padding: 1rem; background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: #fff; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 6px rgba(239, 68, 68, 0.2);" 
                                onmouseover="this.style.boxShadow='0 8px 12px rgba(239, 68, 68, 0.3)'; this.style.transform='translateY(-2px)';" 
                                onmouseout="this.style.boxShadow='0 4px 6px rgba(239, 68, 68, 0.2)'; this.style.transform='translateY(0)';">
                            🗑️ Delete Record
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    <a href="{{ route('students.index') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.5rem; background-color: #e5e7eb; color: #374151; text-decoration: none; border-radius: 8px; margin-top: 2rem; font-weight: 600; transition: all 0.2s ease;" onmouseover="this.style.backgroundColor='#d1d5db'; this.style.transform='translateX(-5px)';" onmouseout="this.style.backgroundColor='#e5e7eb'; this.style.transform='translateX(0)';">
        ← Back to Student List
    </a>

@endsection
