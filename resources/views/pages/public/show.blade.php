<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>CRM - Page Publique</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@700;800&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('public/lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('public/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('public/css/style.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container-xxl bg-white p-0">
        <!-- Spinner Start -->
        <div id="spinner"
            class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Navbar Start -->
        <div class="container-fluid nav-bar bg-transparent">
            <nav class="navbar navbar-expand-lg bg-white navbar-light py-0 px-4">
                <a href="#" id="back">
                    <i class="fa fa-solid fa-arrow-left text-primary me-2"></i>
                </a>
                <a href="{{route('public')}}" class="navbar-brand d-flex align-items-center text-center">
                    <div class="icon p-2 me-2">
                        <img class="img-fluid" src="{{ asset('static/logo.gif') }}" alt="Icon"
                            style="width: 30px; height: 30px;">
                    </div>
                    <h1 class="m-0 text-primary">CRM</h1>
                </a>
                <button type="button" class="navbar-toggler" data-bs-toggle="collapse"
                    data-bs-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto">
                        {{-- <a href="index.html" class="nav-item nav-link">Home</a>
                        <a href="about.html" class="nav-item nav-link">About</a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle active"
                                data-bs-toggle="dropdown">Property</a>
                            <div class="dropdown-menu rounded-0 m-0">
                                <a href="property-list.html" class="dropdown-item active">Property List</a>
                                <a href="property-type.html" class="dropdown-item">Property Type</a>
                                <a href="property-agent.html" class="dropdown-item">Property Agent</a>
                            </div>
                        </div>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                            <div class="dropdown-menu rounded-0 m-0">
                                <a href="testimonial.html" class="dropdown-item">Testimonial</a>
                                <a href="404.html" class="dropdown-item">404 Error</a>
                            </div>
                        </div>
                        <a href="contact.html" class="nav-item nav-link">Contact</a> --}}
                    </div>
                    <a href="#footer" class="btn btn-primary px-3 d-none d-lg-flex">Nous Contacter</a>
                </div>
            </nav>
        </div>
        <!-- Navbar End -->


        <!-- Header Start -->
        <div class="container-fluid header bg-white p-0">
            <div class="row g-0 align-items-center flex-column-reverse flex-md-row">
                <div class="col-md-6 p-5 mt-lg-5">
                    <h1 class="display-5 animated fadeIn mb-4">
                        @if ($appart->type == 0)
                            Commerce
                        @endif
                        @if ($appart->type == 1)
                            Duplex
                        @endif
                        @if ($appart->type == 2)
                            Duplex - 1
                        @endif
                        @if ($appart->type == 3)
                            S+1
                        @endif
                        @if ($appart->type == 4)
                            S+2
                        @endif
                        @if ($appart->type == 5)
                            S+3
                        @endifà
                        <span class="text-primary">
                            {{ $appart->etage->building->name }}</span>
                    </h1>
                    <h3> <i class="fa fa-solid fa-coins text-primary me-2"></i>{{$appart->price}} TND</h3>
                    <h5><i class="fa fa-map-marker-alt text-primary me-2"></i>{{ $appart->etage->building->address }}</h5>
                    <h5><i class="fa fa-ruler-combined text-primary me-2"></i>{{ $appart->surface }} m²</h5>
                    <p class="animated fadeIn mb-4 pb-2">{{$appart->comments}}</p>

                </div>
                <div class="col-md-6 animated fadeIn">
                    <div class="owl-carousel header-carousel">
                        @forelse ($appart->image as $img )
                        <div class="owl-carousel-item">
                            <img class="img-fluid" style="width: 900px; object-fit: contain;"
                                src="{{ asset($img->path) }}" alt="">
                        </div>
                        @empty
                        <div class="owl-carousel-item">
                            <img class="img-fluid" style="width: 900px; object-fit: contain;"
                                src="{{ asset('public/img/carousel-1.jpg') }}" alt="">
                        </div>
                        @endforelse
                        
                    </div>

                </div>

            </div>
        </div>
        <!-- Header End -->




        <!-- Footer Start -->
        <div id="footer" class="container-fluid bg-dark text-white-50 footer pt-5 mt-5 wow fadeIn"
            data-wow-delay="0.1s">
            <div class="container py-5">
                <div class="row g-5">
                    <div class="col-lg-3 col-md-6">
                        <h5 class="text-white mb-4">Nous contacter</h5>
                        <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>Adresse</p>
                        <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+012 345 67890</p>
                        <p class="mb-2"><i class="fa fa-envelope me-3"></i>info@example.com</p>
                        <div class="d-flex pt-2">
                            <a class="btn btn-outline-light btn-social" href=""><i
                                    class="fab fa-twitter"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i
                                    class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i
                                    class="fab fa-youtube"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i
                                    class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-10">
                        <h5 class="text-white mb-4">Photo Gallery</h5>
                        <div class="row g-2 pt-2">
                            <div class="col-4">
                                <img class="img-fluid rounded bg-light p-1" src="img/property-1.jpg" alt="">
                            </div>
                            <div class="col-4">
                                <img class="img-fluid rounded bg-light p-1" src="img/property-2.jpg" alt="">
                            </div>
                            <div class="col-4">
                                <img class="img-fluid rounded bg-light p-1" src="img/property-3.jpg" alt="">
                            </div>
                            <div class="col-4">
                                <img class="img-fluid rounded bg-light p-1" src="img/property-4.jpg" alt="">
                            </div>
                            <div class="col-4">
                                <img class="img-fluid rounded bg-light p-1" src="img/property-5.jpg" alt="">
                            </div>
                            <div class="col-4">
                                <img class="img-fluid rounded bg-light p-1" src="img/property-6.jpg" alt="">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="container">
                <div class="copyright">
                    <div class="row">
                        <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                            &copy; <a class="border-bottom" href="https://mrtech.tn/">MRTech Solutions</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('public/lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('public/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('public/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('public/lib/owlcarousel/owl.carousel.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('public/js/main.js') }}"></script>
    <script>
        function back() {
            window.history.back();
        }
        $(document).ready(function() {
            $('#back').click(function() {
                back();
            });
        });
    </script>
</body>

</html>
