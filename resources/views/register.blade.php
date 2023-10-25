<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Daftar Akun</title>
    <!-- Include your CSS links here -->
    <link href="{{ asset('css/style2.css') }}" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="images/logo.png" type="image/x-icon">
    <!-- Add this line to include Bootstrap Icons CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background: linear-gradient(135deg, #3498db, #9b59b6)">
    <div class="centered-content">
        <div class="form-container">
            <div class="col-md-6 d-flex flex-column justify-content-center align-items-center">
                <img src="{{ asset('images/logoNR.jpg') }}" style="width: 120%;" alt="Logo" class="logo">
            </div>
            <div class="col-md-6 d-flex flex-column justify-content-center align-items-center">
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
                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <b><h4 style="text-align: center;font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;margin-bottom: 30px">Registrasi</h4></b>
                        <div class="form-group">
                            <input type="text" value="{{ old('name') }}" name="name"  placeholder="Name"  class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="email" value="{{ old('email') }}" name="email" class="form-control"  placeholder="Email"  style="max-width: 100%;">
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <input type="password" name="password" class="form-control" placeholder="Password" style="max-width: 100%;">
                                <button type="button" class="btn btn-outline-secondary" id="passwordToggle">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password" style="max-width: 100%;">
                                <button type="button" class="btn btn-outline-secondary" id="passwordToggleConfirmation">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>                        
                        <div class="mb-3 d-grid">
                            <button name="submit" type="submit" class="btn btn-primary">Daftar</button>
                        </div>
                    </form>
                </div>
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
    
        document.getElementById("passwordToggleConfirmation").addEventListener("click", function () {
            var passwordConfirmationInput = document.querySelector("input[name='password_confirmation']");
            if (passwordConfirmationInput.type === "password") {
                passwordConfirmationInput.type = "text";
            } else {
                passwordConfirmationInput.type = "password";
            }
        });
    </script>
    
    <!-- Your script for passwordToggle here -->
</body>
</html>
