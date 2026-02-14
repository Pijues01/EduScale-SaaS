<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <label for="unique_id">Login ID</label>
        <input type="text" name="unique_id" required>

        <label for="password">Password</label>
        <input type="password" name="password" required>

        <button type="submit">Login</button>
    </form>
    @if ($errors->any())
        <p>{{ $errors->first() }}</p>
    @endif
    <p>Don't have an account? <a href="{{ route('register') }}">Register here</a></p>

</body>
</html>
