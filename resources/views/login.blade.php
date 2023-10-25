<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie-edge">
    <title>Login</title>
    <!-- Link to your CSS file -->
    <link href="{{ asset('css/style2.css') }}" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="images/logo.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="centered-content">
        <div class="form-container">
            <div class="col">
                <div class="d-flex justify-content-center">
                    <img src="{{ asset('images/logoNR.jpg') }}" alt="Logo" class="logo">
                </div>
            </div>
            <div class="col">
                <div class="center">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="" method="POST">
                        @csrf
                            <b><h4 style="text-align: center;font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;margin-bottom: 30px">Member Login</h4></b>
                        <div class="form-group">
                            <input type="email" value="{{ old('email') }}" name="email" class="form-control" placeholder="Email" style="max-width: 100%;">
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <input type="password" name="password" class="form-control" placeholder="Password" style="max-width: 100%;">
                                <button type="button" class="btn btn-outline-secondary" id="passwordToggle">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="login-button">
                            <button name="submit" type="submit" class="btn btn-primary">Login</button>
                        </div>
                        <p class="bottom-link text-center">Jika belum punya akun, <a href="{{ route('register') }}">segera daftar</a></p>
                        </div>
                    </form>
            </div>
        </div>
    </div>
    <script>
         document.getElementById("passwordToggle").addEventListener("click", function () {
            var passwordInput = document.querySelector("input[name='password']");
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
            } else {
                passwordInput.type = "password";
            }
        });
    </script>
</body>
</html>
