<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>
        @if (!empty($title))
            {{ $title }}
        @else
            Học laravel
        @endif
    </title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <link href="{{ asset('/assets/admin/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/admin/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/admin/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/admin/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/admin/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/admin/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('/assets/fonts/font-awesome/font-awesome.min.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('/assets/css/nice-select.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/css/toast.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('/assets/admin/css/style.css') }}" rel="stylesheet">
    @yield('css')
</head>

<body>
    <div id="main-spinner">
        <div class="loader">
            <div class="loader__icon">
                <i class='bx bx-loader-circle'></i>
            </div>
        </div>
    </div>

    @include('admin.partials.header')
    @include('admin.partials.sidebar')


    <main id="main" class="main">

        <x-bread-crumb :title="$title"/>

        @yield('content')

    </main><!-- End #main -->
    @csrf
    @include('admin.partials.footer')
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>
    <div id="toasts"></div>
    @include('admin.partials.modal-confirm')

    <script src="{{ asset('/assets/admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('/assets/js/dselect.js') }}"></script>
    <script src="{{ asset('/assets/js/nice-select.js') }}"></script>
    <script src="{{ asset('/assets/admin/vendor/quill/quill.min.js') }}"></script>
    <script src="{{ asset('/assets/js/toast.js') }}"></script>
    <script src="{{ asset('/assets/js/validator.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('/assets/admin/js/main.js') }}"></script>
    <script src="{{ asset('/assets/js/global.js') }}"></script>
    @yield('js')
</body>

</html>
