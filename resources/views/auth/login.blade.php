<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/assets/img/logo.jpg" type="image/x-icon" />
    <title>AngkorTech Computer | Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">


</head>
<style>
    body {
        background-color: #f0f2f5;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: Arial, sans-serif;
    }

    .main-container {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        max-width: 980px;
        padding: 20px;
    }

    .branding {
        flex: 1;
        padding-right: 32px;
        text-align: left;
    }

    .branding h1 {
        color: #1877f2;
        font-size: 5rem;
        width: 100%;
        font-weight: bolder;
        margin-bottom: 0;
    }

    .branding h2 {
        color: #1877f2;
        font-size: 2.5rem;
        width: 100%;
        font-weight: bolder;
        margin-bottom: 0;
    }

    .branding p {
        font-size: 1.5rem;
        line-height: 1.3;
        max-width: 500px;
    }

    .login-card {
        width: 100%;
        max-width: 400px;
        padding: 30px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
    }

    .form-control {
        height: 45px;
        border-radius: 6px;
    }

    .btn-primary {
        background-color: #1877f2;
        border-color: #1877f2;
    }

    .btn-primary:hover {
        background-color: #145bd1;
    }

    .btn-social {
        width: 100%;
        margin-bottom: 10px;
    }

    .register-link {
        margin-top: 15px;
        font-size: 0.9rem;
    }

    .icon {
        position: absolute;
        top: 50%;
        right: 15px;
        transform: translateY(-50%);
        color: #999;
    }
</style>

<body>
    <div class="main-container">
        <div class="branding me-5">
            <h1>Welcome to </h1>
            <h2>AngkorTech Computer</h2>
            <p class="mt-4">
                Please sign in to continue. If you don't have an account, you can register for one.
            </p>
        </div>
        <div class="login-card text-center">
            <form action="{{ route('login') }}" method="POST" class="text-start position-relative">
                @csrf

                @if ($errors->has('email'))
                    <div class="text-danger mb-2">{{ $errors->first('email') }}</div>
                @elseif (session('success'))
                    <div class="text-success mb-2">{{ session('success') }}</div>
                @endif

                <div class="mb-3 position-relative">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email"
                        required>
                    <i class="fa-solid fa-envelope icon"></i>
                </div>

                <div class="mb-3 position-relative">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password"
                        required>
                    <i class="fa-solid fa-lock icon" id="togglePassword"></i>
                </div>

                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Remember Me</label>
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-2 fw-bold">Log in</button>

                <div class=" d-flex justify-content-between mb-3 ">
                    <a href="http://localhost:8000/auth/google/redirect" class="btn btn-danger btn-social"><i
                            class="fab fa-google"></i>
                        Google</a>

                </div>
            </form>
            <div class="register-link">
                Don’t have an account? <a href="{{ route('register') }}" class="text-primary fw-bold">Register</a>
            </div>
        </div>
    </div>
</body>
<script>
    // Toggle password visibility
    document.addEventListener('DOMContentLoaded', () => {
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('fa-lock');
            this.classList.toggle('fa-unlock');
        });

        const rememberCheckbox = document.getElementById("remember");
        if (localStorage.getItem("rememberMe") === "true") {
            rememberCheckbox.checked = true;
        }

        rememberCheckbox.addEventListener("change", function() {
            localStorage.setItem("rememberMe", rememberCheckbox.checked);
        });
    });
</script>

</html>
