<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Maintenance</title>

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #112C01, #677C56);
            min-height: 100vh;
            color: #fff;
            text-align: center;
            
            display: flex;
            justify-content: center;
            align-items: flex-start; /* IMPORTANT FIX */
            padding: 40px 15px; /* prevents cut */
        }

        .box {
            background: rgba(255,255,255,0.1);
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            max-width: 600px;
        }

        .box img {
         width: 100%;
         max-width: 450px;
         height: auto;
         object-fit: contain;
         border-radius: 10px;
         margin-bottom: 20px;
        }

        h1 {
            font-size: 32px;
            margin-bottom: 10px;
            color: #ABC28B;
        }

        p {
            font-size: 16px;
            opacity: 0.9;
            color: #e0e0e0;
        }

        h6 {
            color: #d0d0d0;
            font-size: 14px;
            margin-top: 15px;
        }

        h6 a {
            color: #ABC28B;
            text-decoration: none;
            font-weight: 500;
        }

        h6 a:hover {
            color: #fff;
            text-decoration: underline;
        }

        .spinner {
            margin: 20px auto;
            width: 50px;
            height: 50px;
            border: 5px solid rgba(255,255,255,0.3);
            border-top: 5px solid #ABC28B;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: #ABC28B;
            color: #112C01;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .btn:hover {
            background: #fff;
            color: #112C01;
            box-shadow: 0 5px 15px rgba(171, 194, 139, 0.4);
        }
    </style>
</head>

<body>

<div class="box">

    <img src="{{ asset('images/down.jpg') }}" alt="Maintenance Image">

    <h1>🔧 System Under Maintenance</h1>

    <div class="spinner"></div>

    <p>
        We are currently performing scheduled maintenance.<br>
        Please check back later. Thank you for your patience.
    </p>

    <h6>
        If you need immediate assistance, please contact our support team.<br>
        Email: <a href="mailto:michellecarino@gmail.com">michellecarino@gmail.com</a><br>
        Phone: (123) 456-7890
    </h6>


    <a href="{{ url('/students') }}" class="btn">Go Back Home</a>

</div>

</body>
</html>