<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
     body {
        background-color: #f8f9fa;
    }

    .center {
        margin: 20px auto; /* Add margin */
        max-width: 500px; /* Limit the maximum width of the form */
    }

    .border-rounded {
        border-radius: 10px;
    }

    .password-toggle {
        cursor: pointer;
    }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="w-100 w-md-50 border rounded px-3 py-3 center">
            <h1 class="text-center mb-4">Login</h1>
            <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>
            <form action="" method="POST">
                <?php echo csrf_field(); ?>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" value="<?php echo e(old('email')); ?>" name="email" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" name="password" class="form-control">
                        <button type="button" class="btn btn-outline-secondary" id="passwordToggle">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>
                <div class="mb-3 d-grid">
                    <button name="submit" type="submit" class="btn btn-primary">Login</button>
                </div>
            </form>
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
<?php /**PATH C:\Skripsi\kost-skripsi\resources\views/login.blade.php ENDPATH**/ ?>