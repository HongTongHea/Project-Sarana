@extends('website.app')

@section('title', 'About Us')

@section('content')
    <style>
        .section-title {
            color: #000000;
            margin-bottom: 20px;
        }


        .history-section,
        .brand-section,
        .location-section,
        .structure-section,
        .services-section {
            padding: 80px 0;
        }

        .history-section,
        .structure-section {
            background-color: var(--light-color);
        }

        .brand-logo {
            max-width: 300px;
            margin: 0 auto 20px;
            display: block;
        }

        .map-container {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .service-card {
            border: none;
            border-radius: 8px;
            transition: transform 0.3s, box-shadow 0.3s;
            height: 100%;
        }

        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .service-icon {
            font-size: 2.5rem;
            color: #0d6efd;
            margin-bottom: 15px;
        }

        .contact-info {
            list-style: none;
            padding: 0;
        }

        .contact-info li {
            margin-bottom: 10px;
        }

        .contact-info i {
            color: #0d6efd;
            margin-right: 10px;
            width: 20px;
        }

        .timeline {
            position: relative;
            max-width: 1200px;
            margin: 0 auto;
        }

        .timeline::after {
            content: '';
            position: absolute;
            width: 6px;
            background-color: var(--accent-color);
            top: 0;
            bottom: 0;
            left: 50%;
            margin-left: -3px;
        }

        .timeline-item {
            padding: 10px 40px;
            position: relative;
            width: 50%;
            box-sizing: border-box;
        }

        .timeline-item::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            background-color: white;
            border: 4px solid #0d6efd;
            ;
            border-radius: 50%;
            top: 15px;
            right: -13px;
            z-index: 1;
        }

        .left {
            left: 0;
        }

        .right {
            left: 50%;
        }

        .right::after {
            left: -13px;
        }

        .timeline-content {
            padding: 20px 30px;
            background-color: white;
            border-radius: 6px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        @media screen and (max-width: 768px) {
            .timeline::after {
                left: 31px;
            }

            .timeline-item {
                width: 100%;
                padding-left: 70px;
                padding-right: 25px;
            }

            .timeline-item::after {
                left: 21px;
            }

            .right {
                left: 0;
            }

            .img-company {
                width: 100% !important;
            }
        }
    </style>



    <!-- History Section -->
    <section class="history-section">
        <div class="container">
            <div data-aos="fade-down" data-aos-duration="1000">
                <h1 class="section-title mt-5">AngkorTech Computer</h1>
                <p class=" text-center">Our History and About Us</p>
            </div>
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right" data-aos-duration="1000">
                    <img src="{{ asset('assets/img/IMG_6421.jpg') }}" alt="" width="70%"
                        class="img-company mb-4">
                    <p class="mb-4"><strong>AngkorTech Computer </strong>Shop is located in Mondol 1 Village, Svay Dangkum
                        Commune,
                        Siem Reap City, Siem Reap Province, approximately 1.8 kilometers from Build Bright University.
                    </p>
                    <p><strong>AngkorTech Computer </strong> was established and began operations in 2009 with the
                        participation of
                        collaborative partners and several computer shops (Yeum Bunthai).</p>
                </div>
                <div class="col-lg-6" data-aos="fade-left" data-aos-duration="1000">
                    <div class="timeline">
                        <div class="timeline-item left">
                            <div class="timeline-content">
                                <h3>2009</h3>
                                <p>AngkorTech Computer was established with collaborative partners</p>
                            </div>
                        </div>
                        <div class="timeline-item right">
                            <div class="timeline-content">
                                <h3>2012</h3>
                                <p>Expanded product range and services to meet growing customer demands</p>
                            </div>
                        </div>
                        <div class="timeline-item left">
                            <div class="timeline-content">
                                <h3>2018</h3>
                                <p>Introduced security camera installation services</p>
                            </div>
                        </div>
                        <div class="timeline-item right">
                            <div class="timeline-content">
                                <h3>2023</h3>
                                <p>Launched updated website and online support services</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Brand Section -->
    <section class="brand-section">
        <div class="container" data-aos="fade-up" data-aos-duration="1000">
            <h2 class="section-title">Brand Name and Meaning</h2>
            <div class="row">
                <div class="col-md-6 text-center mb-4">
                    <img src="{{ asset('assets/img/logo-Company.png') }}" alt="AngkorTech Logo" class="brand-logo">
                    <p class="text-muted">Source: AngkorTech Computer (2025)</p>
                </div>
                <div class="col-md-6">
                    <p>The name "AngkorTech Computer" has a meaningful origin:</p>
                    <ul>
                        <li><strong>Angkor</strong> refers to the Angkor Wat temple, symbolizing our Cambodian heritage
                            and strength</li>
                        <li><strong>Tech</strong> represents modern technology and our expertise in the latest
                            technological advancements</li>
                    </ul>
                    <p>Together, the name reflects our commitment to combining Cambodian cultural values with
                        cutting-edge technology solutions.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Location Section -->
    <section class="location-section">
        <div class="container" data-aos="fade-down" data-aos-duration="1000">
            <h2 class="section-title">Our Location</h2>
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <p>Based on direct interviews about the location of AngkorTech Computer, it is situated in Mondol 1
                        Village, Svay Dangkum Commune, Siem Reap City, Siem Reap Province.</p>
                    <ul class="contact-info">
                        <li><i class="fas fa-phone"></i> Tel: 063 6666 777</li>
                        <li><i class="fab fa-facebook"></i> Facebook Page: AngkorTech Computer</li>
                        <li><i class="fas fa-globe"></i> Website: https://angkortech.info/</li>
                        <li><i class="fas fa-map-marker-alt"></i> Address: Mondol 1 Village, Svay Dangkum Commune, Siem
                            Reap City</li>
                    </ul>
                </div>
                <div class="col-lg-6">
                    <div class="map-container">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3881.880691252352!2d103.8562508!3d13.357694!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x311017702f759a9f%3A0xc1ee2fc8dfaa442f!2zQW5na29yVGVjaCBDb21wdXRlciDhnqLhnoThn5LhnoLhnprhno_hnrfhnoXhnoDhnrvhn4bhnpbhn5LhnpnhnrzhnpHhn5Dhnpo!5e0!3m2!1sen!2skh!4v1762946724581!5m2!1sen!2skh"
                            width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                    <p class="text-muted mt-2">Source: Google Map (2025)</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Structure Section -->
    <section class="structure-section">
        <div class="container">
            <div class="row" data-aos="fade-up" data-aos-duration="1000">
                <h2 class="section-title">Shop Structure</h2>
                <div class="col-md-8 mx-auto text-center mb-4">
                    <img src="{{ asset('assets/img/Picture1.png') }}" alt="AngkorTech Shop Structure" width="80%">
                    <p class="text-muted mt-2">Source: AngkorTech Computer (2025)</p>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-4 text-center" data-aos="fade-up" data-aos-duration="1000">
                    <i class="fas fa-users service-icon"></i>
                    <h4>Management Team</h4>
                    <p>Experienced professionals overseeing operations and strategic direction</p>
                </div>
                <div class="col-md-4 text-center" data-aos="fade-down" data-aos-duration="1000">
                    <i class="fas fa-tools service-icon"></i>
                    <h4>Technical Department</h4>
                    <p>Skilled technicians providing repair and installation services</p>
                </div>
                <div class="col-md-4 text-center" data-aos="fade-up" data-aos-duration="1000">
                    <i class="fas fa-shopping-cart service-icon"></i>
                    <h4>Sales Team</h4>
                    <p>Knowledgeable staff assisting customers with product selection</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="services-section">
        <div class="container">
            <div data-aos="fade-down" data-aos-duration="1000">
                <h2 class="section-title">Products and Services</h2>
                <p class="mb-5 text-center">AngkorTech Computer provides the following products and services to customers:
                </p>
            </div>

            <div class="row g-4" data-aos="fade-up" data-aos-duration="1000">
                <div class="col-md-6 col-lg-4">
                    <div class="card service-card shadow-sm">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-laptop service-icon"></i>
                            <h5 class="card-title">Computer Sales</h5>
                            <p class="card-text">Laptops, Desktops, Monitors, Printers, Security Cameras, and various
                                accessories</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="card service-card shadow-sm">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-tools service-icon"></i>
                            <h5 class="card-title">Computer Repair</h5>
                            <p class="card-text">Repair and replacement of all types of computer components</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="card service-card shadow-sm">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-print service-icon"></i>
                            <h5 class="card-title">Printer Services</h5>
                            <p class="card-text">Repair and replacement of all types of printer components</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="card service-card shadow-sm">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-download service-icon"></i>
                            <h5 class="card-title">Software Installation</h5>
                            <p class="card-text">Installation of all types of software according to customer
                                requirements</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="card service-card shadow-sm">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-camera service-icon"></i>
                            <h5 class="card-title">Security Camera Installation</h5>
                            <p class="card-text">Professional installation of security camera systems</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="card service-card shadow-sm">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-wifi service-icon"></i>
                            <h5 class="card-title">WiFi Solutions</h5>
                            <p class="card-text">Installation and repair of all types of WiFi equipment</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 mx-auto">
                    <div class="card service-card shadow-sm">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-desktop service-icon"></i>
                            <h5 class="card-title">Custom Desktop Assembly</h5>
                            <p class="card-text">Custom assembly of desktop computers according to customer
                                requirements</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('website.shoppingcart')
@endsection
