@extends('website.app')

@section('title', 'Contact Us')

@section('content')
    <div class="container  mt-5" style="margin-top: 100px !important; margin-bottom: 50px !important;">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <!-- Header Section -->
                <div class="text-center mb-5">
                    <h1 class="fw-bold mb-3 text-uppercase" style="font-size: 2.5rem;">Get in touch</h1>
                    <p class="text-muted mb-0 mx-auto" style="max-width: 600px;">
                        We'd love to hear from you! Whether you have a question about features.
                        pricing, or simply want to say hello, our friendly team is here to help.
                    </p>
                </div>

                <div class="row">
                    <!-- Left Side - Contact Information -->
                    <div class="col-lg-6 col-md-6 mb-5">
                        <!-- Address Office -->
                        <div class="mb-4">
                            <h3 class="fw-bold mb-3"><i class="fas fa-map-marker-alt me-2 text-p"></i>Angkor
                                Tech
                                Computer Office</h3>
                            <p class="text-muted mb-0">
                                Mondul 1 Village, Sangkat Svay Dangkum, Siem Reap City
                            </p>
                        </div>

                        <div class="mb-4">
                            <h3 class="fw-bold mb-3"> <i class="fas fa-clock me-2"></i>Open Time</h3>
                            <p class="text-muted mb-0">
                                Monday - Friday: 8:00 AM - 5:00 PM <br>
                                Saturday - Sunday: 9:00 AM - 1:00 PM
                            </p>
                        </div>
                        <!-- Phone Section -->
                        <div class="mb-4">
                            <h3 class="fw-bold mb-3"><i class="fas fa-phone me-2"></i>Phone</h3>
                            <p class="text-muted mb-0">
                                Tel: 063 6666 777
                            </p>
                        </div>

                        <!-- Email Section -->
                        <div class="mb-4">
                            <h3 class="fw-bold mb-3"> <i class="fas fa-envelope me-2"></i>Email</h3>
                            <p class="text-muted mb-1">info@angkortechcomputer.com</p>
                        </div>


                        <div class="mb-5">
                            <h3 class="fw-bold mb-3">Follow Our Social Media</h3>
                            <a href="#" class="text-white me-3"> <i class="fa-brands fa-facebook fa-2x"
                                    style="color: #3b5998;"></i></a>
                            <a href="#" class="text-white me-3"><i class="fa-brands fa-telegram fa-2x "
                                    style="color: #1da1f2;"></i></a>
                            <a href="#" class="text-white me-3"><i class="fa-brands fa-instagram fa-2x "
                                    style="color: #e1306c;"></i></a>
                            <a href="#" class="text-white me-3"> <i class="fa-brands fa-youtube fa-2x"
                                    style="color: #0077b5;"></i></a>
                            <a href="#" class="text-white me-3"><i class="fa-brands fa-tiktok fa-2x "
                                    style="color: #e1306c;"></i></a>
                        </div>


                    </div>

                    <!-- Right Side - Contact Form -->
                    <div class="col-lg-6 col-md-6">
                        <div class="card">
                            <div class="card-body p-4">
                                <form method="POST" action="{{ route('contact.store') }}" class="bg-white p-0">
                                    @csrf
                                    @if (session('success'))
                                        <div class="alert alert-success alert-dismissible fade show mb-4">
                                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                        </div>
                                    @endif

                                    @if ($errors->any())
                                        <div class="alert alert-danger alert-dismissible fade show mb-4">
                                            <i class="fas fa-exclamation-circle"></i> Please fill in all required fields
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                        </div>
                                    @endif

                                    <!-- Name Fields Row -->
                                    <div class="mb-4">
                                        <label class="form-label d-block mb-2 fw-bold">Your Name</label>
                                        <input type="text"
                                            class="form-control form-control-lg border rounded-3 px-3 @error('name') is-invalid @enderror"
                                            name="name" value="{{ old('name') }}" placeholder="Type your full name">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Email Field -->
                                    <div class="mb-4">
                                        <label class="form-label  d-block mb-2 fw-bold">Email</label>
                                        <input type="email"
                                            class="form-control form-control-lg border rounded-3 px-3 @error('email') is-invalid @enderror"
                                            name="email" value="{{ old('email') }}" placeholder="Type email">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Phone Number Field -->
                                    <div class="mb-4">
                                        <label class="form-label  d-block mb-2 fw-bold">Phone number</label>
                                        <input type="tel"
                                            class="form-control form-control-lg border rounded-3 px-3 @error('phone_number') is-invalid @enderror"
                                            name="phone_number" value="{{ old('phone_number') }}"
                                            placeholder="Type phone number">
                                        @error('phone_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Message Field -->
                                    <div class="mb-4">
                                        <label class="form-label  d-block mb-2 fw-bold">Message</label>
                                        <textarea class="form-control border rounded-3 px-3 @error('message') is-invalid @enderror" name="message"
                                            rows="4" placeholder="Type message">{{ old('message') }}</textarea>
                                        @error('message')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!-- Submit Button -->
                                    <div class="mt-4">
                                        <button type="submit" class="btn btn-primary btn-lg px-2 py-2 w-100 fw-bold">
                                            Send
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="mb-5 mt-5">
                        <div style="height: 300px; ; border-radius: 5px; overflow: hidden;">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3881.880691252352!2d103.8562508!3d13.357694!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x311017702f759a9f%3A0xc1ee2fc8dfaa442f!2zQW5na29yVGVjaCBDb21wdXRlciDhnqLhnoThn5LhnoLhnprhno_hnrfhnoXhnoDhnrvhn4bhnpbhn5LhnpnhnrzhnpHhn5Dhnpo!5e0!3m2!1sen!2skh!4v1762946724581!5m2!1sen!2skh"
                                width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .form-control {
            font-size: 1rem;
            padding: 0.75rem 1rem;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #2c3e50;
            box-shadow: 0 0 0 0.2rem rgba(44, 62, 80, 0.1);
        }

        .form-control-lg {
            padding: 0.75rem 1rem;
        }

        .btn-dark {
            background-color: #2c3e50;
            border: none;
            border-radius: 0.5rem;
            font-weight: 600;
            padding: 0.75rem 2rem;
            transition: all 0.3s ease;
        }

        .btn-dark:hover {
            background-color: #1a252f;
            transform: translateY(-1px);
        }

        .form-label {
            font-size: 0.9rem;
            font-weight: 500;
        }

        h3 {
            font-size: 1.2rem;
            font-weight: 700;
        }

        @media (max-width: 768px) {
            .container {
                padding: 0 15px;
            }

            h1 {
                font-size: 2rem !important;
            }
        }
    </style>
@endsection
