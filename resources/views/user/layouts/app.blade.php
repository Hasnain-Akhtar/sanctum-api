<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Default Title')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    
    <!-- Custom CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @stack('styles') <!-- Additional styles -->

    <style>
        /* Remove default margin and padding */
        html, body {
            margin: 0;
            padding: 0;
        }

        /* Shimmering effect */
        @keyframes shimmer {
            0% {
                background-position: -1000px 0;
            }
            100% {
                background-position: 1000px 0;
            }
        }

        .shimmer {
            display: inline-block;
            position: relative;
            background: linear-gradient(90deg, rgba(255, 255, 255, 0) 25%, rgba(255, 255, 255, 0.2) 50%, rgba(255, 255, 255, 0) 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite linear;
        }
    </style>
</head>
<body>
    <div>
        <!-- Navigation Bar -->
        @include('user.components.navbar')

        <!-- Main Content -->
        <main>
            @yield('content')
        </main>

        <!-- Footer -->
        @include('user.components.footer')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts') <!-- Additional scripts -->
</body>
</html>
