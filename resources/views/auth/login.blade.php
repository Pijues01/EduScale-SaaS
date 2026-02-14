<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #959595, #253e6b);
        }

        .container {
            width: 100%;
            max-width: 380px;
            padding: 20px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .container h3 {
            color: #fff;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .input-group {
            margin-bottom: 15px;
            text-align: left;
        }

        .input-group label {
            display: block;
            color: #fff;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .input-group input {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
        }

        .input-group input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .input-group input:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.3);
        }

        .btn {
            width: 100%;
            padding: 10px;
            background: #ff9800;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            color: #fff;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn:hover {
            background: #e68900;
        }

        .links {
            margin-top: 15px;
        }

        .links a {
            color: #fff;
            font-size: 14px;
            text-decoration: underline;
        }

        .error {
            color: #e9ff2f;
            font-size: 14px;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h3>Login</h3>
         @if ($errors->any())
            <p class="error">{{ $errors->first() }}</p>
        @endif
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="input-group">
                <label for="unique_id">Login ID</label>
                <input type="text" name="unique_id" id="unique_id" placeholder="Enter Your ID" autocomplete="off" />
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Enter Password" autocomplete="off" />
            </div>
            <button type="submit" class="btn">Login Now</button>
        </form>
        <div class="links">
            <a href="{{ route('home') }}">Go Home</a>
        </div>
    </div>
</body>

</html>
