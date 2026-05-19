<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background-color:#ffe6f0;
            font-family:'Segoe UI', sans-serif;
            margin:0;

            /* sticky footer layout */
            display:flex;
            flex-direction:column;
            min-height:100vh;
        }

        /* Navbar */
        .navbar{
            background-color:#ff4da6;
        }

        .navbar-brand{
            font-weight:bold;
            color:white !important;
        }

        .navbar-nav{
            margin-left:auto;
        }

        .nav-link{
            color:white !important;
            font-weight:600;
            margin-left:15px;
        }

        .nav-link:hover{
            background-color:#ff80bf;
            border-radius:6px;
        }

        /* Main Content */
        .main-content{
            background:white;
            padding:30px;
            border-radius:15px;
            margin-top:30px;
            box-shadow:0 5px 15px rgba(0,0,0,0.1);
        }

        /* makes content push footer down */
        .content-wrapper{
            flex:1;
        }

        /* Footer */
        footer{
            background-color:#ff4da6;
            color:white;
        }

    </style>

</head>

<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="/">🌸 Student Dashboard</a>

        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="/">Home</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="/students">Students</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="/about">About</a>
            </li>
        </ul>
    </div>
</nav>

<!-- Main Content -->
<div class="container content-wrapper">
    <div class="main-content">
        @yield('content')
    </div>
</div>

<!-- Footer -->
<footer class="text-center p-3">
    Student Management Dashboard © 2026
</footer>

</body>
</html>