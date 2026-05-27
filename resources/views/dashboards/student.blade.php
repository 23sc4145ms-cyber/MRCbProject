@extends('format.layout')

@section('title', 'Student Dashboard')

@section('content')
<style>
    .dashboard-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 2rem;
    }

    .welcome-header {
        background: linear-gradient(135deg, #ABC28B 0%, #90A854 100%);
        border-radius: 12px;
        padding: 2rem;
        margin-bottom: 2rem;
        color: white;
        box-shadow: 0 4px 6px rgba(171, 194, 139, 0.3);
    }

    .welcome-header h1 {
        margin: 0 0 0.5rem 0;
        font-size: 2rem;
        font-weight: 700;
    }

    .welcome-header p {
        margin: 0;
        opacity: 0.9;
    }

    /* Tab Navigation */
    .tab-navigation {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 2rem;
        border-bottom: 2px solid #e0e7d8;
        flex-wrap: wrap;
    }

    .tab-button {
        padding: 1rem 2rem;
        background: none;
        border: none;
        border-bottom: 3px solid transparent;
        color: #677C56;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        font-size: 1rem;
    }

    .tab-button:hover {
        color: #ABC28B;
        background: rgba(171, 194, 139, 0.1);
    }

    .tab-button.active {
        color: #112C01;
        border-bottom-color: #ABC28B;
        background: rgba(171, 194, 139, 0.1);
    }

    /* Tab Content */
    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
        animation: fadeIn 0.3s;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Info Cards */
    .info-card {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 4px 6px rgba(171, 194, 139, 0.15);
        margin-bottom: 2rem;
    }

    .info-card h2 {
        color: #ABC28B;
        font-size: 1.3rem;
        margin: 0 0 2rem 0;
        padding-bottom: 1rem;
        border-bottom: 2px solid #e0e7d8;
        font-weight: 600;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.2rem;
    }

    .info-item {
        padding: 1.5rem;
        background: #f8faf5;
        border-radius: 10px;
        border: 1px solid #e0e7d8;
        transition: all 0.3s ease;
    }

    .info-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(171, 194, 139, 0.2);
        border-color: #ABC28B;
    }

    .info-item label {
        display: block;
        color: #90A854;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 0.75rem;
    }

    .info-item .value {
        color: #112C01;
        font-size: 1.05rem;
        font-weight: 600;
        word-break: break-word;
        line-height: 1.4;
    }

    .note-box {
        margin-top: 1.5rem;
        padding: 1rem 1rem 1rem 3rem;
        background: #fff3cd;
        border-left: 4px solid #ffc107;
        border-radius: 8px;
        position: relative;
    }

    .note-box::before {
        content: "📘";
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        font-size: 1.2rem;
    }

    .note-box strong {
        color: #856404;
        font-weight: 600;
    }

    .note-box span {
        color: #856404;
    }

    /* Password Form */
    .password-form {
        max-width: 600px;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        color: #ABC28B;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .form-group input {
        width: 100%;
        padding: 0.9rem;
        border: 2px solid #e0e7d8;
        border-radius: 10px;
        font-size: 1rem;
        transition: 0.2s;
    }

    .form-group input:focus {
        border-color: #ABC28B;
        outline: none;
        box-shadow: 0 0 0 3px rgba(171,194,139,0.2);
    }

    .btn-submit {
        padding: 1rem 2.5rem;
        background: linear-gradient(135deg, #ABC28B, #90A854);
        color: #fff;
        border: none;
        border-radius: 10px;
        font-size: 1.1rem;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 8px 16px rgba(171, 194, 139, 0.4);
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .btn-submit:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 24px rgba(171, 194, 139, 0.5);
        background: linear-gradient(135deg, #90A854, #7a8f47);
    }

    .btn-submit:active {
        transform: translateY(-1px);
        box-shadow: 0 6px 12px rgba(171, 194, 139, 0.4);
    }

    .alert {
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
    }

    .alert-success {
        background-color: #f0f5eb;
        border-left: 4px solid #ABC28B;
        color: #677C56;
    }

    .alert-error {
        background-color: #fee2e2;
        border-left: 4px solid #ef4444;
        color: #7f1d1d;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem;
        color: #677C56;
    }

    .empty-state svg {
        width: 100px;
        height: 100px;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    @media (max-width: 768px) {
        .tab-button {
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 1024px) {
        .info-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>

<div class="dashboard-container">
    <!-- Welcome Header -->
    <div class="welcome-header">
        <h1>Welcome, {{ session('user')->username }}!</h1>
        <p>Student Dashboard - View your information and manage your account</p>
    </div>

    <!-- Tab Navigation -->
    <div class="tab-navigation">
        <button class="tab-button active" onclick="switchTab('info')">
            📋 Student Info
        </button>
        <button class="tab-button" onclick="switchTab('posts')">
            📝 Posts
        </button>
        <button class="tab-button" onclick="switchTab('profile')">
            👤 Profile
        </button>
        <button class="tab-button" onclick="switchTab('password')">
            🔒 Change Password
        </button>
    </div>

    <!-- Tab 1: Student Info -->
    <div id="tab-info" class="tab-content active">
        <div class="info-card">
            <h2>Personal Information</h2>
            
            @php
                $student = \App\Models\Student::where('user_id', session('user_id'))->with(['course', 'user'])->first();
            @endphp

            @if($student)
                <div class="info-grid">
                    <div class="info-item">
                        <label>First Name</label>
                        <div class="value">{{ $student->fname }}</div>
                    </div>
                    <div class="info-item">
                        <label>Middle Name</label>
                        <div class="value">{{ $student->mname ?? 'N/A' }}</div>
                    </div>
                    <div class="info-item">
                        <label>Last Name</label>
                        <div class="value">{{ $student->lname }}</div>
                    </div>
                    <div class="info-item">
                        <label>Username</label>
                        <div class="value">{{ $student->user->username }}</div>
                    </div>
                    <div class="info-item">
                        <label>Email Address</label>
                        <div class="value">{{ $student->user->email }}</div>
                    </div>
                    <div class="info-item">
                        <label>Contact Number</label>
                        <div class="value">{{ $student->contact }}</div>
                    </div>
                    <div class="info-item">
                        <label>Degree</label>
                        <div class="value">{{ $student->degree->name ?? $student->degree->Degree ?? 'Not Assigned' }}</div>
                    </div>
                    <div class="info-item">
                        <label>Student ID</label>
                        <div class="value">{{ $student->id }}</div>
                    </div>
                    <div class="info-item">
                        <label>Status</label>
                        <div class="value" style="color: #22c55e;">✓ Active</div>
                    </div>
                </div>

                <div class="note-box">
                    <strong>Note:</strong> <span>If you need to update your information, please contact the administrator.</span>
                </div>
            @else
                <div class="empty-state">
                    <p>No student information found. Please contact the administrator.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Tab 2: Posts -->
    <div id="tab-posts" class="tab-content">
        <div class="info-card">
            <h2>Posts</h2>
            
            @php
                $posts = \App\Models\Post::latest()->take(10)->get();
            @endphp

            @if($posts->count() > 0)
                @foreach($posts as $post)
                    <div style="padding: 1.5rem; background: #f0f5eb; border-radius: 8px; margin-bottom: 1rem; border-left: 4px solid #ABC28B;">
                        <h3 style="margin: 0 0 0.5rem 0; color: #112C01;">{{ $post->title }}</h3>
                        <p style="margin: 0 0 1rem 0; color: #677C56;">{{ $post->content }}</p>
                        <small style="color: #90A854;">Posted on {{ $post->created_at->format('F d, Y') }}</small>
                    </div>
                @endforeach
            @else
                <div class="empty-state">
                    <p>No post created</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Tab 3: Profile -->
    <div id="tab-profile" class="tab-content">
        <div class="info-card">
            <h2>Profile</h2>
            
            @php
                $profiles = \App\Models\Profile::latest()->take(10)->get();
            @endphp

            @if($profiles->count() > 0)
                @foreach($profiles as $profile)
                    <div style="padding: 1.5rem; background: #f0f5eb; border-radius: 8px; margin-bottom: 1rem; border-left: 4px solid #ABC28B;">
                        <h3 style="margin: 0 0 0.5rem 0; color: #112C01;">{{ $profile->title }}</h3>
                        <p style="margin: 0 0 1rem 0; color: #677C56;">{{ $profile->description }}</p>
                        <small style="color: #90A854;">Updated on {{ $profile->updated_at->format('F d, Y') }}</small>
                    </div>
                @endforeach
            @else
                <div class="empty-state">
                    <p>No profile</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Tab 4: Change Password -->
    <div id="tab-password" class="tab-content">
        <div class="info-card">
            <h2>Change Password</h2>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-error">
                    <strong>Please fix the following errors:</strong>
                    <ul style="margin: 0.5rem 0 0 1.5rem;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('student.password.update') }}" method="POST" class="password-form" onsubmit="return confirmPasswordChange()">
                @csrf
                
                <div class="form-group">
                    <label for="current_password">Current Password</label>
                    <input type="password" name="current_password" id="current_password" required>
                </div>

                <div class="form-group">
                    <label for="new_password">New Password</label>
                    <input type="password" name="new_password" id="new_password" required minlength="8">
                    <small style="color: #677C56; display: block; margin-top: 0.25rem;">Minimum 8 characters</small>
                </div>

                <div class="form-group">
                    <label for="new_password_confirmation">Confirm New Password</label>
                    <input type="password" name="new_password_confirmation" id="new_password_confirmation" required>
                </div>

                <button type="submit" class="btn-submit">Update Password</button>
            </form>
        </div>
    </div>
</div>

<script>
    function switchTab(tabName) {
        // Hide all tabs
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.classList.remove('active');
        });
        
        // Remove active class from all buttons
        document.querySelectorAll('.tab-button').forEach(btn => {
            btn.classList.remove('active');
        });
        
        // Show selected tab
        document.getElementById('tab-' + tabName).classList.add('active');
        
        // Add active class to clicked button
        event.target.classList.add('active');
    }
    
    function confirmPasswordChange() {
        return confirm('Are you sure you want to change your password?');
    }
</script>

@endsection
