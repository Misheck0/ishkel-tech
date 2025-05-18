<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ trim(View::yieldContent('title')) ?: 'ISHKEL TECH ENTERPRISE' }} </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Font Awesome for icons (optional) -->
    <!-- Font Awesome -->
<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
<!-- ApexCharts CSS (optional) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.26.0/dist/apexcharts.min.css">
<script src="https://cdn.tailwindcss.com"></script>

<body class="bg-gray-50 font-sans antialiased text-gray-800">
    <div class="min-h-screen flex flex-col">
        <!-- Mobile Header with Hamburger Menu -->
        <header class="bg-indigo-700 text-white shadow-lg lg:hidden">
            <div class="flex justify-between items-center px-4 py-3">
                <div class="flex items-center">
                    <button id="mobile-menu-button" class="mr-4 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <h1 class="text-lg font-bold">ISHKEL TECH</h1>
                </div>
                <div class="flex items-center">
                    <span class="text-sm mr-2">{{ Auth::user()->name ?? 'Guest' }}</span>
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'U') }}&background=random" 
                         class="w-8 h-8 rounded-full" alt="Profile">
                </div>
            </div>
        </header>

        <!-- Desktop Header -->
        <header class="bg-indigo-700 text-white shadow-lg hidden lg:block">
            <div class="max-w-7xl mx-auto px-6 py-3 flex justify-between items-center">
                <h1 class="text-xl font-bold flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                   {{ Auth::user()->company->company_name ?? ' ISHKEL TECH ENTERPRISES' }}
                </h1>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <button class="text-gray-200 hover:text-white focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                        </button>
                        <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
                    </div>
                    <div class="flex items-center">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'U') }}&background=random" 
                             class="w-8 h-8 rounded-full mr-2" alt="Profile">
                        <span class="text-sm">{{ Auth::user()->name ?? 'Guest' }}</span>
                    </div>
                    <a href="" class="text-gray-200 hover:text-white ml-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </header>

        <!-- Main Content with Sidebar -->
        <div class="flex flex-1 overflow-hidden">
            <!-- Mobile Sidebar (Hidden by default) -->
            <aside id="mobile-sidebar" class="fixed inset-y-0 left-0 w-64 bg-white shadow-lg transform -translate-x-full lg:relative lg:translate-x-0 z-50 transition duration-200 ease-in-out">
                <div class="flex items-center justify-between p-4 border-b lg:hidden">
                    <h2 class="text-lg font-semibold text-gray-800">Menu</h2>
                    <button id="close-mobile-menu" class="text-gray-500 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <nav class="p-4">
                    <div class="mb-6">
                        <h3 class="text-xs uppercase font-semibold text-gray-500 tracking-wider mb-3">Main</h3>
                        <ul class="space-y-2">
                            <li>
                                <a href="{{route('dashboard')}}"
                                class="flex items-center px-3 py-2 text-sm font-medium rounded-md 
    {{ Request::routeIs('dashboard') ? 'text-white bg-indigo-800' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-100' }} group">
                                    <svg class="mr-3 h-5 w-5 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                    </svg>
                                    Dashboard
                                </a>
                            </li>
                            <li> 
                                <a href="{{ route('invoices.search') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-700 hover:bg-gray-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    Search Invoices
                                </a>
                            </li>
                            <!-- Add Quotation Link quotation.create -->
                            <li>
                                <a href="{{route('invoices.quotations')}}"
                                class="flex items-center px-3 py-2 text-sm font-medium rounded-md
    {{ Request::routeIs('invoices.quotations') ? 'text-white bg-indigo-800' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-100' }} group">
                                    <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Quotation
                                </a>
                            </li>
                            <li>
                                <a href="{{route('invoices.index')}}"
                                class="flex items-center px-3 py-2 text-sm font-medium rounded-md 
    {{ Request::routeIs('invoices.index') ? 'text-white bg-indigo-800' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-100' }} group">
                                    <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Invoices
                                </a>
                            
                            </li>
                            @if(Auth::user()->role == 'super_admin' || Auth::user()->role == 'IT_manager')
                            <li>
                                <!-- All Invoices Link -->
                                <a href="{{ route('admin.allInvoices') }}"
                                class="flex items-center px-3 py-2 text-sm font-medium rounded-md 
    {{ Request::routeIs('admin.allInvoices') ? 'text-white bg-indigo-800' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-100' }} group">
                                    <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    All Invoices
                                </a>
                            </li>


                            <li>
                                <a href="{{route('admin.allCustomers')}}" 
                                class="flex items-center px-3 py-2 text-sm font-medium rounded-md 
                                {{ Request::routeIs('admin.allCustomers') ? 'text-white bg-indigo-800' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-100' }} group">
                                   
                                    <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                    Customers
                                </a>
                            </li>
                            @endif
                          
                        </ul>
                    </div>
                    <div class="mb-6">
                        <h3 class="text-xs uppercase font-semibold text-gray-500 tracking-wider mb-3">Reports</h3>
                        <ul class="space-y-2">
                            <li>
                                <a href="{{route('reports.index')}}" 
                                class="flex items-center px-3 py-2 text-sm font-medium rounded-md 
    {{ Request::routeIs('reports.index') ? 'text-white bg-indigo-800' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-100' }} group">
                                    <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                    Reports
                                </a>
                            </li>
                         <!-- kpi report -->
                            <li>
                                <a href="{{route('reports.kpi')}}" 
                                class="flex items-center px-3 py-2 text-sm font-medium rounded-md
                                {{ Request::routeIs('reports.kpi') ? 'text-white bg-indigo-800' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-100' }} group">
                                    <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m0 0l3-3m-3 3V8m0 4l3-3m0 0l3 3m-3-3V4m0 4l3-3m0 0l3 3m-6 6h6"></path>
                                    </svg>
                                    KPI Report
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div>
                    
                        <h3 class="text-xs uppercase font-semibold text-gray-500 tracking-wider mb-3">Settings</h3>
                        <ul class="space-y-2">
                            @if(Auth::user()->role == 'super_admin' || Auth::user()->role == 'IT_manager')
                            <li>
                                <a href="{{route('admin.addUserForm')}}" 
                                class="flex items-center px-3 py-2 text-sm font-medium rounded-md 
                                {{ Request::routeIs('admin.addUserForm') ? 'text-white bg-indigo-800' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-100' }} group">
                                    <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Add user
                                </a>
                            </li>
                                @endif
                            <li>
                                <a href="{{route('company.profile')}}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-700 hover:text-gray-900 hover:bg-gray-100 group">
                                    <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Company Settings
                                </a>
                            </li>
                            <!-- add profile link -->
                            <li>
                                <a href="{{ route('profile.edit') }}" 
                                class="flex items-center px-3 py-2 text-sm font-medium rounded-md
                                {{ Request::routeIs('profile.edit') ? 'text-white bg-indigo-800' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-100' }} group">
                                    <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 4h2a2 2 0 012 2v2m0 0h-2m0 0V4m0 2l-6.293 6.293a1 1 0 01-.707.293H8a2 2 0 00-2 2v4a2 2 0 002 2h4a1 1 0 01.707.293L16.414 20H18a2 2 0 002-2v-4a1 1 0 01.293-.707L20.414 10z"></path>
                                    </svg>
                                    Profile
                                </a>
                            </li>

                        </ul>
                    </div>
                    
                    <div class="mt-6">
                      <form action="{{ route('auth.logout') }}" method="POST">
                          @csrf
                          <button type="submit" class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-700 hover:text-gray-900 hover:bg-gray-100 group">
                              <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                              </svg>
                              Logout
                          </button>
                      </form>
                  </div>


                </nav>
            </aside>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto p-4 lg:p-6 bg-gray-50">
                <!-- Page Title -->
                <div class="mb-6 flex justify-between items-center">
                    <h2 class="text-2xl font-bold text-gray-800">@yield('title')</h2>
                    @yield('actions')
                </div>

                <!-- Content -->
                <div class="bg-white rounded-lg shadow-sm p-4 lg:p-6">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Mobile Menu Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const closeMobileMenu = document.getElementById('close-mobile-menu');
            const mobileSidebar = document.getElementById('mobile-sidebar');
            
            mobileMenuButton.addEventListener('click', function() {
                mobileSidebar.classList.remove('-translate-x-full');
            });
            
            closeMobileMenu.addEventListener('click', function() {
                mobileSidebar.classList.add('-translate-x-full');
            });
            
            // Close sidebar when clicking outside
            document.addEventListener('click', function(event) {
                const isClickInside = mobileSidebar.contains(event.target) || mobileMenuButton.contains(event.target);
                if (!isClickInside && !mobileSidebar.classList.contains('-translate-x-full')) {
                    mobileSidebar.classList.add('-translate-x-full');
                }
            });
        });
    </script>

    @yield('scripts')
</body>
</html>