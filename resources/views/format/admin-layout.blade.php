<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Pangasinan State University - Admin Panel">
    <meta name="theme-color" content="#ABC28B">
    <title>@yield('title', 'PSU - Admin Panel')</title>

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

        /* ADMIN HEADER */
        .admin-header {
            background: linear-gradient(135deg, #112C01 0%, #677C56 100%);
            padding: 1.5rem 2rem;
            box-shadow: 0 4px 12px rgba(171, 194, 139, 0.2);
            margin-bottom: 2rem;
            border-radius: 8px;
            border-bottom: 2px solid #ABC28B;
        }

        .admin-header h1 {
            color: #ABC28B;
            font-size: 1.8rem;
            font-weight: 700;
            margin: 0;
        }

        .admin-container {
            max-width: 1400px;
            margin: 0 auto;
            width: 100%;
            padding: 2rem;
        }

        footer {
            text-align: center;
            padding: 2rem;
            color: #ABC28B;
            background: rgba(171, 194, 139, 0.15);
            border-top: 2px solid #ABC28B;
            margin-top: auto;
        }
    </style>
</head>
<body>
    <div class="admin-header">
        <h1>👤 Admin</h1>
    </div>

    <div class="admin-container">
        @yield('content')
    </div>

    <footer>
        <p>&copy; 2026 MICHELLE R. CARINO</p>
    </footer>
</body>
</html>
