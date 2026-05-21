@extends('format.layout')

@section('title')
    LOGIN
@endsection

@section('content')
<style>
    /* HIDE NAVBAR */
    nav {
        display: none !important;
    }

    /* BACKGROUND DESIGN */
    body {
    background: linear-gradient(135deg, #ABC28B, #ffffff);
}

.background-design {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: radial-gradient(circle at top left, rgba(17,44,1,0.15), transparent 40%),
                radial-gradient(circle at bottom right, rgba(171,194,139,0.20), transparent 40%);
    z-index: -1;
}

    /* CENTER EVERYTHING */
    .center-wrapper {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        text-align: center;
    }

    /* HEADER */
    .page-header {
        margin-bottom: 30px;
    }

  .page-header h1 {
    color: #112C01;
}

.page-header p {
    color: #1d1e1b;
}

    /* FORM CONTAINER */
    .form-container {
        width: 100%;
        max-width: 500px;
        background: #ffffff;
        padding: 2.5rem;
        border-radius: 16px;
         box-shadow: 0 0 0 3px rgba(171,194,139,0.3);
        text-align: left;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        color: #112C01;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .form-group .required {
        color: #112C01;
    }

    .form-group input {
        width: 100%;
        padding: 0.9rem;
        border: 2px solid #e0e7d8;
        border-radius: 10px;
        font-size: 1rem;
        transition: 0.2s;
        box-sizing: border-box;
    }

    /* Hide browser's default password reveal button */
    input[type="password"]::-ms-reveal,
    input[type="password"]::-ms-clear {
        display: none;
    }

    input[type="password"]::-webkit-credentials-auto-fill-button,
    input[type="password"]::-webkit-contacts-auto-fill-button {
        visibility: hidden;
        display: none !important;
        pointer-events: none;
        height: 0;
        width: 0;
        margin: 0;
    }

    .form-group input:focus {
        border-color:  #ABC28B;
        outline: none;
         box-shadow: 0 0 0 3px rgba(171,194,139,0.3);
    }

    /* PASSWORD WRAPPER */
    .password-wrapper {
        position: relative;
        width: 100%;
    }

    .password-wrapper input {
        padding-right: 40px;
    }

    .toggle-password {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #112C01;
        user-select: none;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }

    .toggle-password:hover {
        color: #ABC28B;
    }

    .toggle-password svg {
        width: 20px;
        height: 20px;
    }

    /* BUTTONS */
    .button-group {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        margin-top: 2rem;
    }

    .btn-submit {
        padding: 0.85rem 2rem;
         background: linear-gradient(135deg, #112C01, #ABC28B);;
        color: #fff;
        border: none;
        border-radius: 10px;
        font-size: 1.05rem;
        font-weight: 600;
        cursor: pointer;
        box-shadow: 0 6px 12px rgba(17,44,1,0.3);
        transition: 0.3s;
        width: 100%;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 18px rgba(17,44,1,0.4);
    }

    .btn-link {
        text-align: center;
        color: #112C01;
        text-decoration: none;
        font-weight: 600;
        transition: 0.2s;
    }

    .btn-link:hover {
       color: #ABC28B;
        text-decoration: underline;
    }

    /* ERROR MESSAGE */
    .error-message {
        width: 100%;
        padding: 1.5rem;
        background-color: #f0f7ea;
        border-left: 5px solid #112C01;
        border-radius: 8px;
        margin-bottom: 2rem;
        color: #7f1d1d;
    }

    .error-message h3 {
        margin-top: 0;
         color: #112C01;
    }

    .error-message ul {
        margin: 1rem 0;
        padding-left: 1.5rem;
    }

    .error-message li {
        margin: 0.5rem 0;
        font-weight: 500;
    }
</style>

<div class="background-design"></div>

<div class="center-wrapper">
    <div class="page-header">
        <h1>LOGIN</h1>
        <p>Welcome to my page !</p>
    </div>

    @if($errors->any())
    <div class="error-message">
        <h3>Login Failed</h3>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('login.submit') }}" method="POST" class="form-container" autocomplete="off" novalidate>
        @csrf
        
        <div class="form-group">
            <label for="email">EMAIL <span class="required"></span></label>
            <input type="email" name="email" id="email" placeholder="Enter your email" required autocomplete="off" readonly onfocus="this.removeAttribute('readonly')">
            @error('email')
                <small style="color: #112C01; display: block; margin-top: 0.25rem;">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">PASSWORD <span class="required"></span></label>
            <div class="password-wrapper">
                <input type="password" name="password" id="password" placeholder="Enter your password" required autocomplete="new-password" readonly onfocus="this.removeAttribute('readonly')">
                <span class="toggle-password" onclick="togglePassword('password')" id="toggleBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                </span>
            </div>
        </div>

        <div class="button-group">
            <button type="submit" class="btn-submit">Login</button>
        </div>
    </form>
</div>





<script>
    // Clear form fields on page load and prevent autofill
    window.addEventListener('load', function() {
        const emailField = document.getElementById('email');
        const passwordField = document.getElementById('password');
        
        emailField.value = '';
        passwordField.value = '';
        
        // Prevent autofill
        emailField.setAttribute('autocomplete', 'off');
        passwordField.setAttribute('autocomplete', 'new-password');
    });

    
    // Clear on focus
    document.getElementById('email').addEventListener('focus', function() {
        this.value = '';
    });

    document.getElementById('password').addEventListener('focus', function() {
        this.value = '';
    });

    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        
        if (field.type === 'password') {
            field.type = 'text';
        } else {
            field.type = 'password';
        }
    }
</script>

@endsection
