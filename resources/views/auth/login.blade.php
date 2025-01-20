<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="icon" href="/assets/img/logostore2.png" type="image/x-icon" width="100%">
    <title> Clothes Store | Login Page</title>
</head>

<body>
    <div class="container" style="padding-top: 100px">
        <div class="d-flex justify-content-center align-items-center p-2">
            <img src="/assets/img/logostore1.png" alt="" width="14%">

        </div>

        <div class="d-flex justify-content-center align-items-center">

            <div class="card shadow rounded-2  text-center  text-light bg-dark" style="width: 400px; padding: 20px">
                <div class="card-body">
                    <h3 class="fw-bold">Login</h3>
                    <span>Please login to start your system</span>
                    <form action="{{ route('login') }}" method="POST">
                        @csrf

                        @if ($errors->has('email'))
                            <label class="text-danger mt-1">{{ $errors->first('email') }}</label>
                        @elseif (session('success'))
                            <label class="text-success mt-1">{{ session('success') }}</label>
                        @endif

                        <div class="form-group mt-4 position-relative">
                            <input type="email" class="form-control rounded-3  text-light bg-dark" id="email"
                                placeholder="Email" name="email" required>
                            <div
                                class="icon position-absolute top-0  end-0 bottom-0 m-auto d-flex justify-content-center align-items-center p-3">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                        </div>

                        <div class="form-group mt-4 position-relative">
                            <input type="password" class="form-control rounded-3 text-light bg-dark" id="password"
                                placeholder="Password" name="password" required>
                            <div
                                class="icon position-absolute top-0 end-0 bottom-0 m-auto d-flex justify-content-center align-items-center p-3">
                                <i class="fa-solid fa-lock" id="togglePassword"></i>
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <div class="row d-flex justify-content-center align-items-center">
                                <div class="col-6 pe-4 ">
                                    <input type="checkbox" id="remember" name="remember" class="form-check-input p-2">
                                    <label for="remember" class="form-check-label ">Remember Me</label>
                                </div>
                                <div class="col-6">
                                    <button type="submit"
                                        class="btn btn-warning rounded-5  mt-2  fw-bold float-end w-75">Login</button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</body>
<style>
    body {
        background-image: url("/assets/img/bg.jpg");
        background-repeat: no-repeat;
        background-size: cover;
        background-attachment: fixed;
        background-position: center;
        backdrop-filter: blur(3px);
        height: 100vh;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function(e) {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            this.classList.toggle('fa-lock');
            this.classList.toggle('fa-unlock');
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        const rememberCheckbox = document.getElementById("remember");

        // Load saved checkbox state on page load
        if (localStorage.getItem("rememberMe") === "true") {
            rememberCheckbox.checked = true;
        }

        // Save checkbox state to localStorage when toggled
        rememberCheckbox.addEventListener("change", function() {
            localStorage.setItem("rememberMe", rememberCheckbox.checked);
        });
    });
</script>

</html>
