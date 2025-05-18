<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Portal - Ishkel Tech</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans">
    <!-- Mobile Menu Button (Hidden on desktop) -->
    <div class="lg:hidden fixed bottom-4 right-4 z-50">
        <button id="mobile-menu-button" class="p-3 bg-blue-600 text-white rounded-full shadow-lg hover:bg-blue-700 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    <!-- Mobile Sidebar (Hidden by default) -->
    <div id="mobile-sidebar" class="lg:hidden fixed inset-0 z-40 bg-gray-900 bg-opacity-50 hidden">
        <div class="fixed inset-y-0 right-0 max-w-xs w-full bg-white shadow-xl">
            <div class="flex items-center justify-between p-4 border-b">
                <h2 class="text-lg font-semibold">Menu</h2>
                <button id="close-mobile-menu" class="text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <nav class="p-4 space-y-2">
                <a href="#" class="block px-3 py-2 rounded-md bg-blue-50 text-blue-700 font-medium">Dashboard</a>
                <a href="#" class="block px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100">My Invoices</a>
                <a href="#" class="block px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100">Payments</a>
                <a href="#" class="block px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100">Profile</a>
                <a href="#" class="block px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100">Support</a>
                <a href="#" class="block px-3 py-2 rounded-md text-red-600 hover:bg-red-50 mt-4">Logout</a>
            </nav>
        </div>
    </div>

    <div class="min-h-screen flex flex-col lg:flex-row">
        <!-- Desktop Sidebar -->
        <aside class="hidden lg:block w-64 bg-white border-r border-gray-200">
            <div class="p-4 border-b">
                <h1 class="text-xl font-bold text-blue-600">Ishkel Tech</h1>
                <p class="text-sm text-gray-500">Customer Portal</p>
            </div>
            <nav class="p-4 space-y-1">
                <div class="mb-6">
                    <h3 class="text-xs uppercase font-semibold text-gray-500 tracking-wider mb-3">Main</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="#" class="flex items-center px-3 py-2 text-sm font-medium rounded-md bg-blue-50 text-blue-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-700 hover:bg-gray-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                My Invoices
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-700 hover:bg-gray-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Payments
                            </a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-xs uppercase font-semibold text-gray-500 tracking-wider mb-3">Account</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="#" class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-700 hover:bg-gray-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Profile
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-700 hover:bg-gray-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Support
                            </a>
                        </li>
                        <li>
                            <form action="{{ route('auth.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-700 hover:text-gray-900 hover:bg-gray-100 group">
                                    <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Top Navigation (Mobile Header) -->
            <header class="lg:hidden bg-white shadow-sm">
                <div class="flex items-center justify-between p-4">
                    <h1 class="text-lg font-semibold text-gray-800">Customer Portal</h1>
                    <div class="flex items-center space-x-2">
                        <button class="p-1 text-gray-500 rounded-full hover:bg-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                        </button>
                        <div class="relative">
                            <button class="flex items-center space-x-2">
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                                    <span class="text-blue-600 font-medium text-sm">CU</span>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Desktop Header -->
            <header class="hidden lg:flex items-center justify-between bg-white shadow-sm px-6 py-3">
                <div class="flex items-center space-x-4">
                    <h2 class="text-lg font-medium text-gray-800">@yield('title', 'Dashboard')</h2>
                </div>
                <div class="flex items-center space-x-6">
                    <button class="text-gray-500 hover:text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </button>
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                            <span class="text-blue-600 font-medium text-sm">CU</span>
                        </div>
                        <span class="text-sm font-medium text-gray-700">Customer</span>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 p-4 lg:p-6 bg-gray-50">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Mobile Menu Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const closeMobileMenu = document.getElementById('close-mobile-menu');
            const mobileSidebar = document.getElementById('mobile-sidebar');
            
            mobileMenuButton.addEventListener('click', function() {
                mobileSidebar.classList.remove('hidden');
            });
            
            closeMobileMenu.addEventListener('click', function() {
                mobileSidebar.classList.add('hidden');
            });
            
            // Close when clicking outside
            mobileSidebar.addEventListener('click', function(e) {
                if (e.target === mobileSidebar) {
                    mobileSidebar.classList.add('hidden');
                }
            });
        });
    </script>
</body>
</html>