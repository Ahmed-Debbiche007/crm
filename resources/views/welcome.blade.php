<!doctype html>

<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>CRM - @yield('title')</title>
    <!-- CSS files -->
    <link href="{{ asset('dist/css/tabler.min.css?1684106062') }}" rel="stylesheet" />
    <link href="{{ asset('dist/css/tabler-flags.min.css?1684106062') }}" rel="stylesheet" />
    <link href="{{ asset('dist/css/tabler-payments.min.css?1684106062') }}" rel="stylesheet" />
    <link href="{{ asset('dist/css/tabler-vendors.min.css?1684106062') }}" rel="stylesheet" />
    <link href="{{ asset('dist/css/demo.min.css?1684106062') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset("dist/js/datatables.net-bs5/css/dataTables.bootstrap5.min.css")}}">
    <link rel="stylesheet" href="{{ asset('dist/js/filepond/filepond.css') }}">
    <link rel="icon" href="{{ asset('static/favicon.ico') }}" type="image/x-icon">
    <link rel="stylesheet"
        href="{{ asset('dist/js/filepond-plugin-image-preview/filepond-plugin-image-preview.css') }}">
    <link rel="stylesheet"
        href="{{ asset('dist/js/filepond-plugin-get-file/filepond-plugin-get-file.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/js/toastify-js/src/toastify.css') }}">
    @yield('styles')
    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }
    </style>
    @laravelPWA
</head>

<body>
    <script src="{{ asset('dist/js/demo-theme.min.js?1684106062') }}"></script>
    <div class="page">
        @include('partials.navbar') 
        @include('partials.sidebar')
        <!-- Navbar -->
       
        <div class="page-wrapper">
            @yield('content')
            @include('partials.footer')
        </div>
    </div>
    <script src="{{ asset('dist/js/jquery.min.js') }}"></script>
    <!-- Libs JS -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="{{asset('dist/libs/apexcharts/dist/apexcharts.min.js?1684106062')}}" defer></script>
    <script src="{{asset('dist/libs/jsvectormap/dist/js/jsvectormap.min.js?1684106062')}}" defer></script>
    <script src="{{asset('dist/libs/jsvectormap/dist/maps/world.js?1684106062')}}" defer></script>
    <script src="{{asset('dist/libs/jsvectormap/dist/maps/world-merc.js?1684106062')}}" defer></script>
    <!-- Tabler Core -->
    <script src="{{asset('dist/js/tabler.min.js?1684106062')}}" defer></script>
    <script src="{{asset('dist/js/demo.min.js?1684106062')}}" defer></script>
    <script src="{{ asset('dist/js/intDark.js') }}"></script>
    <script
        src="{{ asset('dist/js/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js') }}">
    </script>
    <script
        src="{{ asset('dist/js/filepond-plugin-file-validate-type/filepond-plugin-file-validate-type.min.js') }}">
    </script>
    <script src="{{ asset('dist/js/filepond-plugin-image-crop/filepond-plugin-image-crop.min.js') }}"></script>
    <script
        src="{{ asset('dist/js/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js') }}">
    </script>
    <script src="{{ asset('dist/js/filepond-plugin-image-filter/filepond-plugin-image-filter.min.js') }}"></script>
    <script src="{{ asset('dist/js/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js') }}">
    </script>
    <script src="{{ asset('dist/js/filepond-plugin-image-resize/filepond-plugin-image-resize.min.js') }}"></script>
    <script src="{{ asset('dist/js/filepond-plugin-get-file/filepond-plugin-get-file.js') }}"></script>
    <script src="{{ asset('dist/js/filepond/filepond.js') }}"></script>
    <script src="{{ asset('dist/js/toastify-js/src/toastify.js') }}"></script>
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
        <script src="{{ asset('dist/js/toastify-js/src/toastify.js') }}"></script>
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
