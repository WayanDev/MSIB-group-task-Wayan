@extends('layout.appadmin')

@section('content')

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .container {
            text-align: center;
            animation: fadeIn 1s ease;
        }

        h1 {
            font-size: 48px;
            color: #333;
            margin-bottom: 20px;
        }

        p {
            font-size: 20px;
            color: #666;
            margin-bottom: 30px;
        }

        .lock-icon {
            width: 200px;
            height: 200px;
            background-color: #f76b1c;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            margin-bottom: 30px;
        }

        .lock-icon:before {
            content: "🔒";
            font-size: 100px;
            width: 200px;
            height: 150px;
            border-radius: 50%;
        }

        @keyframes rotate {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .btn-back {
            display: inline-block;
            background-color: #f76b1c;
            color: #fff;
            padding: 10px 20px;
            border-radius: 4px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .btn-back:hover {
            background-color: #e65200;
        }
    </style>
    <div class="container">
        <h1>Access Denied</h1>
        <div class="lock-icon"></div>
        <p>You don't have permission to access this page.</p>
    </div>
@endsection