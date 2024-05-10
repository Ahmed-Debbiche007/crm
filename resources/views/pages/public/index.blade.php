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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('public/lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('dist/css/hotspot/hotspot-public.css') }}" rel="stylesheet" />
    <link href="{{ asset('dist/css/hotspot/style-public.css') }}" rel="stylesheet" />
    @laravelPWA
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
                <a href="{{ route('public', $residence->id) }}"
                    class="navbar-brand d-flex align-items-center text-center">
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

        <!-- Search Start -->
        <div class="container-fluid bg-primary mb-5 wow fadeIn" data-wow-delay="0.1s" style="padding: 35px;">
            <div class="container">
                <div class="row g-2">
                    <div class="col-md-10">
                        <div class="row g-2">
                            <div class="col-md-4">
                                <select class="form-select border-0 py-3">
                                    <option selected>Résidence</option>
                                    <option value="1">Property Type 1</option>
                                    <option value="2">Property Type 2</option>
                                    <option value="3">Property Type 3</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select class="form-select border-0 py-3">
                                    <option selected>Type d'appartement</option>
                                    <option value="1">Property Type 1</option>
                                    <option value="2">Property Type 2</option>
                                    <option value="3">Property Type 3</option>
                                </select>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-dark border-0 w-100 py-3">Search</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Search End -->


        <!-- Property List Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="row g-0 gx-5 align-items-end">
                    <div class="col-lg-6">
                        <div class="text-start mx-auto mb-5 wow slideInLeft" data-wow-delay="0.1s">
                            <h1 class="mb-3">Appartements </h1>
                            <p>Eirmod sed ipsum dolor sit rebum labore magna erat. Tempor ut dolore lorem kasd vero
                                ipsum sit eirmod sit diam justo sed rebum.</p>
                        </div>
                    </div>
                    {{-- <div class="col-lg-6 text-start text-lg-end wow slideInRight" data-wow-delay="0.1s">
                        <ul class="nav nav-pills d-inline-flex justify-content-end mb-5">
                            <li class="nav-item me-2">
                                <a class="btn btn-outline-primary active" data-bs-toggle="pill"
                                    href="#tab-1">Featured</a>
                            </li>
                            <li class="nav-item me-2">
                                <a class="btn btn-outline-primary" data-bs-toggle="pill" href="#tab-2">For Sell</a>
                            </li>
                            <li class="nav-item me-0">
                                <a class="btn btn-outline-primary" data-bs-toggle="pill" href="#tab-3">For Rent</a>
                            </li>
                        </ul>
                    </div> --}}
                </div>
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane fade show p-0 active">
                        <div class="d-flex flex-column g-4">
                            @foreach ($residence->etage as $etage)
                                <h3>Etage: {{ $etage->name }}</h3>
                                <main class="main_plan" style="display: block;" id="main_plan_{{ $etage->id }}">

                                </main>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- Property List End -->




        <!-- Footer Start -->
        <div id="footer" class="container-fluid bg-dark text-white-50 footer pt-5 mt-5 wow fadeIn"
            data-wow-delay="0.1s">
            <div class="container py-5">
                <div class="row g-5">
                    <div class="col-lg-3 col-md-6">
                        <h5 class="text-white mb-4">Nous contacter</h5>
                        <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>{{ $residence->address }}</p>
                        <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+012 345 67890</p>
                        <p class="mb-2"><i class="fa fa-envelope me-3"></i>info@example.com</p>
                        {{-- <div class="d-flex pt-2">
                            <a class="btn btn-outline-light btn-social" href=""><i
                                    class="fab fa-twitter"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i
                                    class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i
                                    class="fab fa-youtube"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i
                                    class="fab fa-linkedin-in"></i></a>
                        </div> --}}
                    </div>

                    <div class="col-lg-6 col-md-10">
                        <h5 class="text-white mb-4">Photo Gallery</h5>
                        <div class="row g-2 pt-2">
                            @php $count = 0; @endphp
                            @foreach ($residence->image as $img)
                                @if ($count < 6)
                                    <div class="col-4">
                                        <img class="img-fluid rounded bg-light p-1"
                                            style="height: 200px; object-fit: contain;" src="{{ asset($img->path) }}"
                                            alt="">
                                    </div>
                                @endif
                                @php $count++; @endphp
                            @endforeach
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
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('public/lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('public/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('public/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('public/lib/owlcarousel/owl.carousel.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('public/js/main.js') }}"></script>
    <script>
        const mains = document.querySelectorAll('.main_plan');
        mains.forEach(main => {
            let url = "{{ route('public.etages.get', 5) }}".replace('5', main.id.split('_')[2]);
            axios.get(url).then((response) => {
                const etage = response.data;
                const ratio = etage.wplan / etage.hplan
                main.style.width = '1000px';
                main.style.height = (1000 / ratio) + 'px';
                const div = document.createElement('div');
                div.classList.add('containerD');
                const wid = 1000;
                const path = "{{ asset('favicon.ico') }}".replace("favicon.ico", etage.plan)
                div.setAttribute('style', "background-image: url('" + path + "'); height: " + wid / ratio +
                    "px; width: " + wid + "px;");
                etage.appart.forEach((ap) => {
                    if (ap.bs == 0) {
                        const appart = document.createElement('div');
                        appart.classList.add('hotspot');
                        const styleAp = 'top: ' + ap.y + '%; left: ' + ap.x + '%;';
                        appart.setAttribute('style', styleAp);
                        let statut = "A vendre";
                        let color = "#005841";
                        switch (ap.type) {
                            case 0:
                                statut = "Commerce";
                                break;
                            case 1:
                                statut = "Duplex";
                                break;
                            case 2:
                                statut = "Duplex - 1";
                                break;
                            case 3:
                                statut = "S+1";
                                break;
                            case 4:
                                statut = "S+2";
                                break;
                            case 5:
                                statut = "S+3";
                                break;
                            case 6:
                                statut = "Triplex";
                                break;
                            default:
                                break;
                        }
                        const link = "{{ route('public.show', 5) }}".replace('5', ap.id);
                        const ht = document.createElement('div');
                        ht.classList.add('icon');
                        ht.classList.add('hotspot');
                        ht.setAttribute('style', 'background-color: ' + color + ';');
                        ht.innerHTML = "+";
                        ht.addEventListener('click', function() {
                            var parent = this.parentElement;
                            parent.classList.toggle('open');
                            parent.setAttribute('style', parent.getAttribute('style') +
                                'background-color: ' + color +
                                '; color:black; ');
                            var hotspots = document.querySelectorAll('.hotspot.open');
                            hotspots.forEach(function(hotspot) {
                                if (hotspot !== parent) {
                                    hotspot.classList.remove('open');
                                }
                            });
                        });
                        const content = document.createElement('div');
                        content.classList.add('content');
                        content.setAttribute('style', 'background-color: ' + color + ';');
                        content.innerHTML = '<a href=' + link +
                            ' class="fs-3 fw-bolder text-decoration-underline" style="color: white">' +
                            ap.name +
                            '</a><p style="color: white">' + statut +
                            '</p>';

                        const divText = document.createElement('div');
                        let t = ap.y - 10;
                        let l = ap.x - 10;
                        t += 10;
                        l += 12;
                        divText.setAttribute('style', 'top: ' + t + '%; left: ' + l +
                            '%; background-color: ' +
                            color + '; ');
                        divText.innerHTML = '<div>' + ap.name + '</div>';
                        divText.classList.add('hotspot-label');
                        div.appendChild(divText);
                        appart.appendChild(ht);
                        appart.appendChild(content);
                        div.appendChild(appart);
                    }
                })

                main.appendChild(div);

            })
        });
    </script>
</body>

</html>
