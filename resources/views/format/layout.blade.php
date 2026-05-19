<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Pangasinan State University - Student Management Dashboard">
    <meta name="theme-color" content="#ABC28B">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'PSU - Student Management Dashboard')</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Helvetica Neue', sans-serif;
            background: linear-gradient(135deg,#112C01,#677C56);
            color: #4b1f3a;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        /* NAVBAR */
        nav {
            background: #ffffff;
            padding: 1rem 2rem;
            box-shadow: 0 4px 12px rgba(171,194,139,0.15);
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 2px solid #ABC28B;
        }

        nav ul {
            display: flex;
            align-items: center;
            width: 100%;
            max-width: 1400px;
            margin: auto;
            list-style: none;
        }

        .nav-left {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .hamburger {
            display: none;
        }

        .hamburger:hover {
            display: none;
        }

        nav a {
            color: #ABC28B;
            text-decoration: none;
            padding: 0.6rem 1rem;
            border-radius: 0.5rem;
            transition: 0.3s;
            font-weight: 500;
        }

        nav a.active {
            color: #112C01;
            background: linear-gradient(135deg,#ABC28B,#90A854);
        }

        nav a:hover {
            background: rgba(171, 194, 139, 0.2);
            color: #ABC28B;
        }

        .nav-right {
            margin-left: auto;
            display: flex;
            align-items: center;
        }

        .logo a {
            display: none;
        }

        .logo span {
            display: none;
        }

        /* SIDEBAR (HIDDEN - using top nav instead) */
        .sidebar {
            display: none;
        }

        .sidebar.active {
            display: none;
        }

        .sidebar h2 {
            display: none;
        }

        .sidebar a {
            display: none;
        }

        .close-btn {
            display: none;
        }

        /* OVERLAY */
        .overlay {
            display: none;
        }

        .overlay.active {
            display: none;
        }

        /* MAIN */
        main {
            flex: 1;
            padding: 2rem;
            width: 100%;
            max-width: 1400px;
            margin: auto;
        }

        /* FOOTER */
        footer {
            text-align: center;
            padding: 2rem;
            background: #fff;
            border-top: 2px solid #ABC28B;
            margin-top: auto;
        }

        /* MOBILE */
        @media (max-width: 768px) {
            nav {
                padding: 0.75rem;
            }

            nav ul {
                flex-wrap: wrap;
                gap: 0.25rem;
            }

            .nav-left {
                flex-wrap: wrap;
                gap: 0.25rem;
                width: 100%;
            }

            .nav-left a {
                padding: 0.4rem 0.6rem;
                font-size: 0.85rem;
                flex: 1;
                min-width: 80px;
                text-align: center;
            }

            .nav-right {
                width: 100%;
                margin-left: 0;
                display: flex;
                justify-content: flex-end;
                gap: 0.5rem;
                margin-top: 0.5rem;
            }

            .nav-right button {
                padding: 0.4rem 0.8rem !important;
                font-size: 0.85rem;
            }

            main {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <nav>
        <ul>
            <li class="nav-left">
                @if(session('user_role') === 'admin')
                    <a href="{{ route('dashboard') }}" @class(['active' => request()->is('dashboard')])>DASHBOARD</a>
                    <a href="{{ route('students.index') }}" @class(['active' => request()->is('students*')])>STUDENTS</a>
                    <a href="{{ route('teachers.index') }}" @class(['active' => request()->is('teachers*')])>TEACHERS</a>
                    <a href="{{ route('courses.index') }}" @class(['active' => request()->is('courses*')])>DEGREE</a>
                    <a href="{{ route('posts.index') }}" @class(['active' => request()->is('posts*')])>POSTS</a>
                    <a href="{{ route('profiles.index') }}" @class(['active' => request()->is('profiles*')])>PROFILES</a>
                @elseif(session('user_role') === 'teacher')
                    <a href="{{ route('dashboard') }}" @class(['active' => request()->is('dashboard')])>DASHBOARD</a>
                    <a href="{{ route('students.index') }}" @class(['active' => request()->is('students*')])>STUDENTS</a>
                    <a href="{{ route('teachers.index') }}" @class(['active' => request()->is('teachers*')])>TEACHERS</a>
                    <a href="{{ route('courses.index') }}" @class(['active' => request()->is('courses*')])>DEGREE</a>
                    <a href="{{ route('posts.index') }}" @class(['active' => request()->is('posts*')])>POSTS</a>
                    <a href="{{ route('profiles.index') }}" @class(['active' => request()->is('profiles*')])>PROFILES</a>
                    <a href="{{ route('password.change.form') }}" @class(['active' => request()->is('user-page')])>CHANGE PASSWORD</a>
                @endif
            </li>

            <li class="nav-right">
                <form action="{{ route('logout') }}" method="POST" id="logoutForm" style="display: inline;">
                    @csrf
                    <button type="button" onclick="showLogoutModal()" style="
                        background: linear-gradient(135deg, #ABC28B, #90A854);
                        border: none;
                        color: #fff;
                        padding: 0.75rem 1.5rem;
                        border-radius: 8px;
                        cursor: pointer;
                        font-weight: 700;
                        font-size: 0.95rem;
                        transition: all 0.3s ease;
                        box-shadow: 0 4px 8px rgba(171, 194, 139, 0.3);
                        text-transform: uppercase;
                        letter-spacing: 0.5px;
                    " onmouseover="
                        this.style.transform='translateY(-2px)';
                        this.style.boxShadow='0 6px 12px rgba(171, 194, 139, 0.4)';
                        this.style.background='linear-gradient(135deg, #90A854, #7a8f47)';
                    " onmouseout="
                        this.style.transform='translateY(0)';
                        this.style.boxShadow='0 4px 8px rgba(171, 194, 139, 0.3)';
                        this.style.background='linear-gradient(135deg, #ABC28B, #90A854)';
                    ">LOGOUT</button>
                </form>
            </li>
        </ul>
    </nav>

    <!-- Logout Confirmation Modal -->
    <div id="logoutModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
        <div style="background: #fff; border-radius: 16px; max-width: 450px; width: 90%; box-shadow: 0 10px 25px rgba(0,0,0,0.3);">
            <div style="background: linear-gradient(135deg, #ABC28B 0%, #90A854 100%); padding: 2rem; color: #fff; border-radius: 16px 16px 0 0;">
                <h2 style="margin: 0; font-size: 1.5rem;"> Confirm Logout</h2>
            </div>
            <div style="padding: 2rem;">
                <p style="margin: 0; color: #333; font-size: 1.1rem; line-height: 1.6;">Are you sure you want to logout?</p>
            </div>
            <div style="padding: 1rem 2rem 2rem; display: flex; gap: 1rem; justify-content: flex-end;">
                <button onclick="closeLogoutModal()" style="padding: 0.75rem 1.5rem; background: #e5e7eb; color: #374151; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">Cancel</button>
                <button onclick="confirmLogout()" style="padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #ABC28B, #90A854); color: #fff; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">Logout</button>
            </div>
        </div>
    </div>

    <main>
        @yield('content')
    </main>

    <footer>
        <p>&copy; 2026 MICHELLE R CARINO</p>
    </footer>

    <script>
        // Navigation bar is now always visible - no sidebar toggle needed
        
        function showLogoutModal() {
            document.getElementById('logoutModal').style.display = 'flex';
        }
        
        function closeLogoutModal() {
            document.getElementById('logoutModal').style.display = 'none';
        }
        
        function confirmLogout() {
            document.getElementById('logoutForm').submit();
        }
        
        // Close modal when clicking outside
        document.getElementById('logoutModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeLogoutModal();
            }
        });
    </script>

    <!-- Custom JS -->
    <script src="{{ asset('js/app.js') }}"></script>

</body>
</html>