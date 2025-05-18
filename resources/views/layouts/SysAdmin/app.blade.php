<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT Manager Dashboard</title>
    
    <!-- Tailwind CSS via CDN (recommend using proper build process in production) -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- ApexCharts CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.26.0/dist/apexcharts.min.css">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom Styles (optional) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @stack('styles') <!-- For view-specific styles -->
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-gray-800 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo/Brand -->
                <div class="flex-shrink-0">
                    <span class="text-white font-bold text-xl">IT Manager Dashboard</span>
                </div>
                
                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button type="button" class="text-gray-300 hover:text-white focus:outline-none" aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
                
                <!-- Desktop Menu -->
                <div class="hidden md:block">
                    <div class="ml-4 flex items-center space-x-4">
                        <a href="{{route('sysadmin.index')}}" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                            <i class="fas fa-tachometer-alt mr-1"></i> Dashboard
                        </a>

                        <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                            <i class="fas fa-chart-line mr-1"></i> Reports
                      
                        </a>

                        <!-- audit-trails -->
                        <a href="{{ route('audit-trails.index') }}" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                            <i class="fas fa-history mr-1"></i> Audit Trails
                        </a>

                        <!-- Company -->
                        <a href="{{route('companies.index')}}" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                            <i class="fas fa-building mr-1"></i> Company

                        <!-- User Management-->
                        <a href="{{route('sysadmin.allUsers')}}" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                            <i class="fas fa-users mr-1"></i> Users
                        </a>
                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                           class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                            <i class="fas fa-sign-out-alt mr-1"></i> Logout
                        </a>
                    </div>


                </div>
            </div>
        </div>
        
        <!-- Mobile Menu (hidden by default) -->
        <div class="md:hidden hidden" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="{{route('sysadmin.index')}}" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">
                    <i class="fas fa-tachometer-alt mr-1"></i> Dashboard
                </a>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                   class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">
                    <i class="fas fa-sign-out-alt mr-1"></i> Logout
                </a>
            </div>
        </div>
    </nav>

    <!-- Logout Form (hidden) -->
    <form id="logout-form" action="{{route('auth.logout')}}" method="POST" class="hidden">
        @csrf
    </form>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p>&copy; {{ date('Y') }} Your Company Name | All Rights Reserved</p>
        </div>
    </footer>

    <!-- JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.26.0/dist/apexcharts.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.10.3/dist/cdn.min.js" defer></script>
    
    <!-- Mobile menu toggle script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.querySelector('[aria-controls="mobile-menu"]');
            const mobileMenu = document.getElementById('mobile-menu');
            
            mobileMenuButton.addEventListener('click', function() {
                const expanded = this.getAttribute('aria-expanded') === 'true';
                this.setAttribute('aria-expanded', !expanded);
                mobileMenu.classList.toggle('hidden');
            });
        });
    </script>
    @yield('scripts') <!-- For view-specific scripts -->
     <!-- For view-specific scripts -->
</body>
</html>