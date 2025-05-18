<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ISHKEL TECH ENTERPRISE - @yield('title')</title>
    <!-- yeild description and keywords -->
    <meta name="description" content="@yield('description')">
    <meta name="keywords" content="@yield('keywords')">
    <meta name="author" content="ISHKEL TECH ENTERPRISE">
    <meta name="robots" content="index, follow">
    <meta name="theme-color" content="#059669">
    <!-- add fovicon from public folder -->
    <link rel="icon" href="{{ asset('favicon_io/favicon.ico') }}" type="image/png">
    <link rel="apple-touch-icon" href="{{ asset('favicon_io/apple-touch-icon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon_io/favicon.ico') }}" type="image/png">

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon_io/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href=" {{ asset('') }} ">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon_io/favicon-16x16.png')}}">
    <link rel="manifest" href="favicon_io/site.webmanifest">
    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    @stack('styles')
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .navbar-link {
            position: relative;
        }
        .navbar-link:after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: #059669;
            transition: width 0.3s ease;
        }
        .navbar-link:hover:after {
            width: 100%;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="flex items-center">
                        <span class="text-green-700 font-bold text-2xl">ISHKEL TECH</span>
                    </a>
                </div>
                
                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ url('/') }}" class="navbar-link text-gray-700 hover:text-green-700 px-3 py-2 text-sm font-medium @if(request()->is('/')) text-green-700 @endif">
                        Home
                    </a>
                    <a href="{{ route('about') }}" class="navbar-link text-gray-700 hover:text-green-700 px-3 py-2 text-sm font-medium @if(request()->is('about')) text-green-700 @endif">
                        About
                    </a>
                    <a href="{{ route('services') }}" class="navbar-link text-gray-700 hover:text-green-700 px-3 py-2 text-sm font-medium @if(request()->is('services')) text-green-700 @endif">
                        Services
                    </a>
                    <a href="#contact" class="bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700 transition duration-300">
                        Contact
                    </a> 
                </div>
                
                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button type="button" class="mobile-menu-button inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:text-green-700 focus:outline-none">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div class="mobile-menu hidden md:hidden">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-white">
                <a href="{{ url('/') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-green-700 @if(request()->is('/')) bg-green-50 text-green-700 @endif">
                    Home
                </a>
                <a href="{{ route('about') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-green-700 @if(request()->is('about')) bg-green-50 text-green-700 @endif">
                    About
                </a>
                <a href="{{ route('services') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-green-700 @if(request()->is('services')) bg-green-50 text-green-700 @endif">
                    Services
                </a>
                <a href="#contact" class="block px-3 py-2 rounded-md text-base font-medium text-white bg-green-600 hover:bg-green-700">
                    Contact
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white pt-12 pb-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Company Info -->
                <div>
                    <h3 class="text-xl font-bold mb-4">ISHKEL TECH ENTERPRISE</h3>
                    <p class="text-gray-400 mb-4">Lusaka | Zambia</p>
                    <p class="text-gray-400">Professional services for generators and heavy equipment.</p>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ url('/') }}" class="text-gray-400 hover:text-white transition duration-300">Home</a></li>
                        <li><a href="{{ route('about') }}" class="text-gray-400 hover:text-white transition duration-300">About Us</a></li>
                        <li><a href="{{ route('services') }}" class="text-gray-400 hover:text-white transition duration-300">Our Services</a></li>
                        <li><a href="#contact" class="text-gray-400 hover:text-white transition duration-300">Contact</a></li>
                    </ul>
                </div>
                
                <!-- Contact Info -->
                <div id='contact' >
                    <h3 class="text-lg font-semibold mb-4">Contact Us</h3>
                    <ul class="space-y-3 text-gray-400">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-3"></i>
                            <span>164/40 kALUSHA Bwalya Road</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-phone-alt mt-1 mr-3"></i>
                            <span>+260974642435</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-envelope mt-1 mr-3"></i>
                            <span>info@ishkeltech.com</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-700 mt-8 pt-6 text-center text-gray-400 text-sm">
                <p>&copy; {{ date('Y') }} ISHKEL TECH ENTERPRISE. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Mobile menu toggle
        document.querySelector('.mobile-menu-button').addEventListener('click', function() {
            document.querySelector('.mobile-menu').classList.toggle('hidden');
        });
        
        // Close mobile menu when clicking a link
        document.querySelectorAll('.mobile-menu a').forEach(link => {
            link.addEventListener('click', () => {
                document.querySelector('.mobile-menu').classList.add('hidden');
            });
        });
    </script>
    
    @yield('scripts')
</body>
</html>