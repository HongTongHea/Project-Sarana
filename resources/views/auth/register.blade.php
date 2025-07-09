<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/assets/img/logo.jpg" type="image/x-icon" />
    <title>AngkorTech Computer | Register</title>
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
                Please sign up to create a new account. If you already have an account, you can sign in instead.
            </p>
        </div>

        <div class="login-card text-center">
            <form action="{{ route('register') }}" method="POST" class="text-start position-relative">
                @csrf

                @if ($errors->any())
                    <div class="text-danger mb-2">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-3 position-relative">
                    <input type="text" class="form-control" id="name" name="name" placeholder="Username"
                        required>
                    <i class="fa-solid fa-user icon"></i>
                </div>

                <div class="mb-3 position-relative">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email"
                        required>
                    <i class="fa-solid fa-envelope icon"></i>
                </div>

                <div class="mb-3 position-relative">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password"
                        required>
                    <i class="fa-solid fa-lock icon toggle-password" data-target="password"></i>
                </div>
                <div class="mb-3 position-relative">
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                        placeholder="Confirm Password" required>
                    <i class="fa-solid fa-lock icon toggle-password" data-target="password_confirmation"></i>
                </div>

                <button type="submit" class="btn btn-primary w-100 fw-bold">Register</button>

                <div class="d-flex justify-content-between mt-2 mb-3">
                    <a href="http://localhost:8000/auth/google/redirect" class="btn btn-danger w-100 btn-social">
                        <i class="fab fa-google"></i> Google
                    </a>
                </div>
            </form>

            <div class="register-link mt-3">
                Already have an account? <a href="{{ route('login') }}" class="text-primary fw-bold">Log in</a>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Select all toggle password icons
            const toggleIcons = document.querySelectorAll('.toggle-password');

            // Add click event to each icon
            toggleIcons.forEach(icon => {
                icon.addEventListener('click', function() {
                    // Get the target input field
                    const targetId = this.getAttribute('data-target');
                    const passwordInput = document.getElementById(targetId);

                    // Toggle the input type
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' :
                        'password';
                    passwordInput.setAttribute('type', type);

                    // Toggle the icon
                    this.classList.toggle('fa-lock');
                    this.classList.toggle('fa-unlock');
                });
            });
        });
    </script>
</body>

</html>
