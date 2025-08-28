<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>@yield('title')</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="/assets/img/logo.jpg" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />


    <link rel="stylesheet" href="/assets/css/slide.css">
    <!-- Fonts and icons -->
    <script src="/assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: {
                families: ["Public Sans:300,400,500,600,700"]
            },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["/assets/css/fonts.min.css"],
            },
            active: function() {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/assets/css/plugins.min.css" />
    <link rel="stylesheet" href="/assets/css/kaiadmin.min.css" />

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="/assets/css/demo.css" />
</head>

<body>
    <div class="wrapper">
        @php
            // Get the authenticated user from any guard
            $user = null;
            $guards = ['admin', 'manager', 'cashier', 'customer', 'web'];

            foreach ($guards as $guard) {
                if (Auth::guard($guard)->check()) {
                    $user = Auth::guard($guard)->user();
                    break;
                }
            }
        @endphp

        @if ($user && in_array($user->role, ['admin', 'manager', 'cashier']))
            <!-- Sidebar -->
            @include('layouts.sidebar')
            <!-- End Sidebar -->

            <div class="main-panel">
                <!-- Navbar -->
                @include('layouts.navbar')
                <!-- End Navbar -->

                <div class="container">
                    @yield('content')
                </div>

                <!-- Footer -->
                {{-- @include('layouts.footer') --}}
            </div>
        @else
            <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
                <div class="text-center">
                    <h2 class="text-danger">404 | Page Not Found</h2>
                    <p class="mb-4">You do not have permission to access this page.</p>
                    <a href="{{ route('login') }}" class="btn btn-primary">Go Back</a>
                </div>
            </div>
        @endif

        <!-- End Custom template -->
    </div>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!--   Core JS Files   -->
    <script src="/assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="/assets/js/core/popper.min.js"></script>
    <script src="/assets/js/core/bootstrap.min.js"></script>
    <!-- jQuery Scrollbar -->
    <script src="/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

    <!-- jQuery Sparkline -->
    <script src="/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

    <!-- Chart Circle -->
    <script src="/assets/js/plugin/chart-circle/circles.min.js"></script>

    <!-- Datatables -->
    <script src="/assets/js/plugin/datatables/datatables.min.js"></script>

    <!-- Bootstrap Notify -->
    <script src="/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

    <!-- jQuery Vector Maps -->
    <script src="/assets/js/plugin/jsvectormap/jsvectormap.min.js"></script>
    <script src="/assets/js/plugin/jsvectormap/world.js"></script>

    <!-- Sweet Alert -->
    <script src="/assets/js/plugin/sweetalert/sweetalert.min.js"></script>

    <script src="/assets/js/slide.js"></script>

    <!-- Kaiadmin JS -->
    <script src="/assets/js/kaiadmin.min.js"></script>
    <script src="/assets/js/app.js"></script>
    <!-- Kaiadmin DEMO methods, don't include it in your project! -->
    <script src="/assets/js/setting-demo.js"></script>
    <script src="/assets/js/demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="/assets/js/script.js"></script>
    <script>
        AOS.init();
    </script>
    <script>
        let successMessage = @json(session('success'));
        let errorMessage = @json(session('error'));

        function updateDateTime() {
            const now = new Date();

            const options = {
                timeZone: 'Asia/Phnom_Penh',
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: false
            };

            const formatter = new Intl.DateTimeFormat('en-GB', options);
            const parts = formatter.formatToParts(now);

            let date =
                `${parts.find(p => p.type === 'day').value}-${parts.find(p => p.type === 'month').value}-${parts.find(p => p.type === 'year').value}`;
            let time =
                `${parts.find(p => p.type === 'hour').value}:${parts.find(p => p.type === 'minute').value}:${parts.find(p => p.type === 'second').value}`;

            document.getElementById("date").textContent = date;
            document.getElementById("time").textContent = time;
        }

        // Run once and then every second
        updateDateTime();
        setInterval(updateDateTime, 1000);
    </script>

</body>

</html>
