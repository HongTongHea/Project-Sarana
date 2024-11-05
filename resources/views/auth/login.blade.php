<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="icon" href="/assets/img/logo.png" type="image/x-icon" width="100%">
    <title>Login Page</title>
</head>

<body style="background-color: #fff5f5d8">

    <div class="container" style="padding-top: 100px">
        <div class="d-flex justify-content-center align-items-center p-0">
            <img src="/assets/img/logo2.png" alt="" width="14%">
         
        </div>

        <div class="d-flex justify-content-center align-items-center">

            <div class="card shadow rounded-0 bg-dark text-white text-center" style="width: 400px; padding: 20px">
                <div class="card-body">
                    <h3>Login</h3>
                    <span>Please login to start your system</span>
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        @if ($errors->has('email'))
                            <label class="text-danger mt-1">{{ $errors->first('email') }}</label>
                        @elseif (session('success'))
                            <label class="text-success mt-1">{{ session('success') }}</label>
                        @endif

                        <div class="form-group mt-4 position-relative">
                            <input type="email" class="form-control  bg-dark text-white rounded-0" id="email"
                                placeholder="Email" name="email" required>
                            <div
                                class="icon position-absolute top-0  end-0 bottom-0 m-auto d-flex justify-content-center align-items-center p-3">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                        </div>
                        <div class="form-group mt-4 position-relative">
                            <input type="password" class="form-control  bg-dark text-white rounded-0" id="password"
                                placeholder="Password" name="password" required>
                            <div
                                class="icon position-absolute top-0  end-0 bottom-0 m-auto d-flex justify-content-center align-items-center p-3">
                                <i class="fa-solid fa-lock"></i>
                            </div>
                        </div>
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary rounded-0 w-100 mt-2 ">Login</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>

</body>

</html>
