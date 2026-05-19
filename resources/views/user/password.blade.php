<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #112C01, #677C56);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .card {
            background: #fff;
            border-radius: 16px;
            padding: 2.5rem;
            width: 100%;
            max-width: 480px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.2);
        }

        .card-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .card-header h1 {
            color: #112C01;
            font-size: 1.8rem;
            font-weight: 700;
        }

        .card-header p {
            color: #677C56;
            margin-top: 0.5rem;
            font-size: 0.95rem;
        }

        .alert-info {
            background: #f0fdf4;
            border-left: 4px solid #ABC28B;
            color: #112C01;
            padding: 0.85rem 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }

        .alert-success {
            background: #dcfce7;
            border-left: 4px solid #22c55e;
            color: #166534;
            padding: 0.85rem 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }

        .alert-danger {
            background: #fee2e2;
            border-left: 4px solid #ef4444;
            color: #991b1b;
            padding: 0.85rem 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }

        .alert-danger ul { margin-left: 1.2rem; }

        .form-group { margin-bottom: 1.4rem; }

        .form-group label {
            display: block;
            color: #112C01;
            font-weight: 600;
            margin-bottom: 0.4rem;
            font-size: 0.9rem;
        }

        .input-wrap { position: relative; }

        .input-wrap input {
            width: 100%;
            padding: 0.75rem 2.8rem 0.75rem 0.85rem;
            border: 2px solid #e0e7d8;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.2s;
        }

        .input-wrap input:focus {
            outline: none;
            border-color: #ABC28B;
            box-shadow: 0 0 0 3px rgba(171,194,139,0.25);
        }

        .input-wrap input:disabled {
            background: #f3f4f6;
            cursor: not-allowed;
        }

        .toggle-btn {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1.1rem;
            color: #677C56;
        }

        .field-error {
            color: #ef4444;
            font-size: 0.82rem;
            margin-top: 0.3rem;
            display: block;
        }

        .btn-submit {
            width: 100%;
            padding: 0.85rem;
            background: linear-gradient(135deg, #112C01, #ABC28B);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            margin-top: 0.5rem;
            transition: opacity 0.2s;
        }

        .btn-submit:hover { opacity: 0.9; }

        .btn-submit:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .logout-link {
            display: block;
            text-align: center;
            margin-top: 1.2rem;
            color: #677C56;
            font-size: 0.88rem;
            text-decoration: none;
        }

        .logout-link:hover { text-decoration: underline; }

        .success-note {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            padding: 1rem;
            border-radius: 8px;
            margin-top: 1.5rem;
            text-align: center;
            color: #166534;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="card-header">
            <h1>🔒 Change Password</h1>
            
        </div>

        @if(session('info'))
            <div class="alert-info">{{ session('info') }}</div>
        @endif

        @if(session('success'))
            <div class="alert-success">✓ {{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(!session('success') || strpos(session('success'), 'Welcome') !== false)
        <form method="POST" action="{{ route('password.change.update') }}">
            @csrf

            <div class="form-group">
                <label for="old_password">Old Password</label>
                <div class="input-wrap">
                    <input type="password" name="old_password" id="old_password" placeholder="Enter your old password" required>
                    <button type="button" class="toggle-btn" onclick="toggleField('old_password', this)">👁</button>
                </div>
                @error('old_password')
                    <span class="field-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="new_password">New Password</label>
                <div class="input-wrap">
                    <input type="password" name="new_password" id="new_password" placeholder="Enter your new password" required>
                    <button type="button" class="toggle-btn" onclick="toggleField('new_password', this)">👁</button>
                </div>
                @error('new_password')
                    <span class="field-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="new_password_confirmation">Confirm New Password</label>
                <div class="input-wrap">
                    <input type="password" name="new_password_confirmation" id="new_password_confirmation" placeholder="Confirm your new password" required>
                    <button type="button" class="toggle-btn" onclick="toggleField('new_password_confirmation', this)">👁</button>
                </div>
            </div>

            <button type="submit" class="btn-submit">Save Changes</button>
        </form>
        @endif

        @if(session('success') && strpos(session('success'), 'Password changed') !== false)
            <div class="success-note">
                Your password has been changed successfully. You can now close this page or log out.
            </div>
        @endif

        <form action="{{ route('logout') }}" method="POST" style="text-align:center; margin-top:1rem;">
            @csrf
            <button type="submit" style="background:none; border:none; color:#677C56; font-size:0.88rem; cursor:pointer; text-decoration:underline;">
                Logout
            </button>
        </form>
    </div>

    <script>
        function toggleField(id, btn) {
            const input = document.getElementById(id);
            if (input.type === 'password') {
                input.type = 'text';
                btn.textContent = '🙈';
            } else {
                input.type = 'password';
                btn.textContent = '👁';
            }
        }
    </script>
</body>
</html>

