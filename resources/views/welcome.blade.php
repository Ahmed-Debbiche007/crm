<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>CRM - @yield('title')</title>
    <!-- loader-->

    <!--favicon-->
    <link rel="icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon">

    <!-- simplebar CSS-->
    <link href="{{ asset('assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
    <!-- Bootstrap core CSS-->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/bootstrap-dark.min.css') }}" rel="stylesheet" />
    <!-- animate CSS-->
    <link href="{{ asset('assets/css/animate.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons CSS-->
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css" />
    <!-- Sidebar CSS-->
    <link href="{{ asset('assets/css/sidebar-menu.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/sidebar-menu-dark.css') }}" rel="stylesheet" />
    <!-- Custom Style-->
    <link href="{{ asset('assets/css/app-style.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/app-style-dark.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/simple-datatables/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/filepond/filepond.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/vendors/filepond-plugin-image-preview/filepond-plugin-image-preview.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/vendors/filepond-plugin-get-file/dist/filepond-plugin-get-file.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/toastify-js/src/toastify.css') }}">
    @yield('styles')

</head>

<body class="bg-theme">

    <script src="{{ asset('assets/js/initTheme.js') }}"></script>
    <div id="wrapper">


        @include('partials.sidebar')

        @include('partials.navbar')


        <div class="clearfix"></div>

        @yield('content')

        <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>


        @include('partials.footer')
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>

    <!-- simplebar js -->
    <script src="{{ asset('assets/plugins/simplebar/js/simplebar.js') }}"></script>
    <!-- sidebar-menu js -->
    <script src="{{ asset('assets/js/sidebar-menu.js') }}"></script>
    <!-- loader scripts -->

    <!-- Custom scripts -->
    <script src="{{ asset('assets/js/app-script.js') }}"></script>
    <script src="{{ asset('assets/js/themeToggle.js') }}"></script>
    <!-- Chart js -->

    <script src="{{ asset('assets/plugins/Chart.js/Chart.min.js') }}"></script>

    <!-- Index js -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="{{ asset('assets/js/index.js') }}"></script>
    <script src="{{ asset('assets/js/feather-icons/feather.min.js') }}"></script>
    <script
        src="{{ asset('assets/vendors/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js') }}">
    </script>
    <script
        src="{{ asset('assets/vendors/filepond-plugin-file-validate-type/filepond-plugin-file-validate-type.min.js') }}">
    </script>
    <script src="{{ asset('assets/vendors/filepond-plugin-image-crop/filepond-plugin-image-crop.min.js') }}"></script>
    <script
        src="{{ asset('assets/vendors/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js') }}">
    </script>
    <script src="{{ asset('assets/vendors/filepond-plugin-image-filter/filepond-plugin-image-filter.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js') }}">
    </script>
    <script src="{{ asset('assets/vendors/filepond-plugin-image-resize/filepond-plugin-image-resize.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/filepond-plugin-get-file/filepond-plugin-get-file.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/filepond/filepond.js') }}"></script>
    <script src="{{ asset('assets/vendors/toastify-js/src/toastify.js') }}"></script>
    <script>
        FilePond.registerPlugin(
            FilePondPluginImagePreview,
            FilePondPluginImageCrop,
            FilePondPluginImageExifOrientation,
            FilePondPluginImageFilter,
            FilePondPluginImageResize,
            FilePondPluginFileValidateSize,
            FilePondPluginFileValidateType,
            FilePondPluginGetFile
        );
    </script>
    @if (session('success'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Toastify({
                    text: "{{ session('success') }}",
                    duration: 3000,
                    close: true,
                    gravity: "bottom",
                    position: "right",
                    backgroundColor: "#4fbe87",
                }).showToast()
            });
        </script>
    @endif

    @if (isset($errors) && count($errors) > 0)
        <script src="{{ asset('assets/extensions/toastify-js/src/toastify.js') }}"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const errors = @json($errors->all());
                errors.forEach((error) => {
                    Toastify({
                        text: error,
                        duration: 3000,
                        close: true,
                        gravity: "bottom",
                        position: "left",
                        backgroundColor: "red",
                    }).showToast()
                })
            });
        </script>
    @endif
    @yield('scripts')


</body>

</html>
