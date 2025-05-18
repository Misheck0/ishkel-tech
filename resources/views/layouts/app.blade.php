
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ trim(View::yieldContent('title')) ?: 'ISHKEL TECH ENTERPRISE' }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <!-- ApexCharts CSS (optional) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.26.0/dist/apexcharts.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 font-sans antialiased text-gray-800">
    <div class="min-h-screen flex flex-col">
        <!-- Mobile Header with Hamburger Menu -->
        <header class="bg-green-500 text-white shadow-lg lg:hidden">
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
            <div class="max-w-7xl mx-auto px-6 py-3 flex justify-between items-center bg-green-500 text-white">

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
                    <a href="{{ route('auth.logout') }}" class="text-gray-200 hover:text-white ml-2" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                    </a>
                    <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
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
                <nav class="p-4 h-full overflow-y-auto">
                    <!-- Main Section with dropdown -->
                    <div class="mb-2">
                        <button class="dropdown-toggle w-full flex items-center justify-between px-2 py-2 text-sm font-semibold text-gray-800 rounded-md hover:bg-gray-100 focus:outline-none" data-target="main-dropdown">
                            <div class="flex items-center">
                                <svg class="mr-2 h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                </svg>
                                <span class="uppercase tracking-wider">Main</span>
                            </div>
                            <svg class="dropdown-arrow h-4 w-4 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div id="main-dropdown" class="dropdown-content mt-1 ml-2 pl-2 border-l-2 border-indigo-100">
                            <ul class="space-y-2 py-2">
                                <li>
                                    <a href="{{route('dashboard')}}"
                                    class="flex items-center px-3 py-2 text-sm font-medium rounded-md 
                                    {{ Request::routeIs('dashboard') ? 'text-white bg-green-500' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-100' }} group">
                                        <svg class="mr-3 h-5 w-5 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                        </svg>
                                        Dashboard
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('invoices.search') }}" 
                                       class="flex items-center px-3 py-2 text-sm font-medium rounded-md
                                        {{ Request::routeIs('invoices.search') ? 'text-white bg-green-500' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-100' }} group">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                        Search Invoices
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('invoices.quotations')}}"
                                    class="flex items-center px-3 py-2 text-sm font-medium rounded-md
                                    {{ Request::routeIs('invoices.quotations') ? 'text-white bg-green-500' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-100' }} group">
                                        <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Quotation
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('invoices.index')}}"
                                    class="flex items-center px-3 py-2 text-sm font-medium rounded-md 
                                    {{ Request::routeIs('invoices.index') ? 'text-white bg-green-500' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-100' }} group">
                                        <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Invoices
                                    </a>
                                </li>
                                
                                @if(Auth::user()->role == 'super_admin' || Auth::user()->role == 'IT_manager')
                                <li>
                                    <a href="{{ route('admin.allInvoices') }}"
                                    class="flex items-center px-3 py-2 text-sm font-medium rounded-md 
                                    {{ Request::routeIs('admin.allInvoices') ? 'text-white bg-green-500' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-100' }} group">
                                        <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                        </svg>
                                        All Invoices
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('admin.allCustomers')}}"
                                     class="flex items-center px-3 py-2 text-sm font-medium rounded-md
                                     {{ Request::routeIs('admin.allCustomers') ? 'text-white bg-green-500' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-100' }} group">
                                        <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                        </svg>
                                        Customers
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </div>

                <!-- attendance.index -->
                <div class="mb-2">
                    <button class="dropdown-toggle w-full flex items-center justify-between px-2 py-2 text-sm font-semibold text-gray-800 rounded-md hover:bg-gray-100 focus:outline-none" data-target="attendance-dropdown">
                        <div class="flex items-center">
                            <svg class="mr-2 h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18m-7 5h7"></path>
                            </svg>
                            <span class="uppercase tracking-wider">Attendance</span>
                        </div>
                        <svg class="dropdown-arrow h-4 w-4 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div id="attendance-dropdown" class="dropdown-content mt-1 ml-2 pl-2 border-l-2 border-indigo-100 hidden">
                        <ul class="space-y-2 py-2">
                            <li>
                                <a href="{{ route('attendance.index') }}" 
                                   class="flex items-center px-3 py-2 text-sm font-medium rounded-md 
                                   {{ Request::routeIs('attendance.index') ? 'text-white bg-green-500' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-100' }} group">
                                    <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v4m0 0v4m0-4H8m8 0h4m0 0V8m0 4V8m0 4H8m8 0h4"></path>
                                    </svg>
                                    Daily Attendance
                                </a>
                            </li>
                          
                            <li>
                                <a href="#attendanceChart" 
                                   class="flex items-center px-3 py-2 text-sm font-medium rounded-md
                                   {{ Request::is('reports.attendance#attendanceChart') ? 'text-white bg-green-500' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-100' }} group">
                                    <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                                    </svg>
                                    Attendance Chart
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Expenses Section with dropdown -->
<div class="mb-2">
    <button class="dropdown-toggle w-full flex items-center justify-between px-2 py-2 text-sm font-semibold text-gray-800 rounded-md hover:bg-gray-100 focus:outline-none" data-target="expenses-dropdown">
        <div class="flex items-center">
            <svg class="mr-2 h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
            <span class="uppercase tracking-wider">Expenses</span>
        </div>
        <svg class="dropdown-arrow h-4 w-4 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>
    <div id="expenses-dropdown" class="dropdown-content mt-1 ml-2 pl-2 border-l-2 border-indigo-100 hidden">
        <ul class="space-y-2 py-2">
            <li>
                <a href="{{ route('expenses.index') }}" 
                   class="flex items-center px-3 py-2 text-sm font-medium rounded-md 
                   {{ Request::routeIs('expenses.index') ? 'text-white bg-green-500' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-100' }} group">
                    <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    View Expenses
                </a>
            </li>
          
            <!-- Invoice Orders Section with dropdown -->
            <li>
                <a href="{{ route('invoice.orders.create') }}" 
                   class="flex items-center px-3 py-2 text-sm font-medium rounded-md 
                   {{ Request::routeIs('invoice.orders.create') ? 'text-white bg-green-500' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-100' }} group">
                    <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                     Parts Orders
                </a>
            </li>
         

        </ul>
    </div>
</div>

@if(Auth::user()->role == 'super_admin' || Auth::user()->role == 'IT_manager')
<!-- Reports Section with dropdown -->
<div class="mb-2">
    <button class="dropdown-toggle w-full flex items-center justify-between px-2 py-2 text-sm font-semibold text-gray-800 rounded-md hover:bg-gray-100 focus:outline-none" data-target="reports-dropdown">
        <div class="flex items-center">
            <svg class="mr-2 h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
            <span class="uppercase tracking-wider">Reports</span>
        </div>
        <svg class="dropdown-arrow h-4 w-4 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>
    <div id="reports-dropdown" class="dropdown-content mt-1 ml-2 pl-2 border-l-2 border-indigo-100">
        <ul class="space-y-2 py-2">
            <li>
                <a href="{{route('reports.index')}}"
                 class="flex items-center px-3 py-2 text-sm font-medium rounded-md 
                 {{ Request::routeIs('reports.index') ? 'text-white bg-green-500' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-100' }} group">
                    <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Reports
                </a>
            </li>
            <li>
                <a href="{{route('reports.kpi')}}"
                 class="flex items-center px-3 py-2 text-sm font-medium rounded-md
                {{ Request::routeIs('reports.kpi') ? 'text-white bg-green-500' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-100' }} group">
                    <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m0 0l3-3m-3 3V8m0 4l3-3m0 0l3 3m-3-3V4m0 4l3-3m0 0l3 3m-6 6h6"></path>
                    </svg>
                    KPI Report
                </a>
            </li>
            <li>
                <a href="{{ route('reports.payroll') }}"
                   class="flex items-center px-3 py-2 text-sm font-medium rounded-md
                   {{ Request::routeIs('reports.payroll') ? 'text-white bg-green-500' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-100' }} group">
                    <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Payroll Reports
                </a>
            </li>
            <li>
                <a href="{{ route('reports.expenses') }}" 
                   class="flex items-center px-3 py-2 text-sm font-medium rounded-md
                   {{ Request::is('reports.expenses') ? 'text-white bg-green-500' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-100' }} group">
                    <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                    </svg>
                    Expense Chart
                </a>
            </li>

            <li>
                <a href="{{ route('reports.attendance') }}"
                   class="flex items-center px-3 py-2 text-sm font-medium rounded-md
                   {{ Request::routeIs('reports.attendance') ? 'text-white bg-green-500' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-100' }} group">
                    <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Attendance Reports
                </a>
            </li>
        </ul>
    </div>
</div>
@endif

<!-- Payroll Section with dropdown -->
<div class="mb-2">
    <button class="dropdown-toggle w-full flex items-center justify-between px-2 py-2 text-sm font-semibold text-gray-800 rounded-md hover:bg-gray-100 focus:outline-none" data-target="payroll-dropdown">
        <div class="flex items-center">
            <svg class="mr-2 h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="uppercase tracking-wider">Payroll</span>
        </div>
        <svg class="dropdown-arrow h-4 w-4 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>
    <div id="payroll-dropdown" class="dropdown-content mt-1 ml-2 pl-2 border-l-2 border-indigo-100 hidden">
        <ul class="space-y-2 py-2">
            <li>
                <a href="{{ route('payroll.index') }}" 
                   class="flex items-center px-3 py-2 text-sm font-medium rounded-md 
                   {{ Request::routeIs('payroll.index') ? 'text-white bg-green-500' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-100' }} group">
                    <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Payroll Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('payroll.index') }}#payroll-summary" 
                   class="flex items-center px-3 py-2 text-sm font-medium rounded-md
                   {{ Request::is('payroll#payroll-summary') ? 'text-white bg-green-500' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-100' }} group">
                    <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    Payroll Summary
                </a>
            </li>
            <!--  <li>
                <a href="#t" 
                   class="flex items-center px-3 py-2 text-sm font-medium rounded-md
                   {{ Request::is('payroll#tax-deductions') ? 'text-white bg-green-500' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-100' }} group">
                    <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"></path>
                    </svg>
                    Tax Deductions
                </a>
            </li> -->
        </ul>
    </div>
</div>
                    <!-- Settings Section with dropdown -->
                    <div class="mb-2">
                        <button class="dropdown-toggle w-full flex items-center justify-between px-2 py-2 text-sm font-semibold text-gray-800 rounded-md hover:bg-gray-100 focus:outline-none" data-target="settings-dropdown">
                            <div class="flex items-center">
                                <svg class="mr-2 h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span class="uppercase tracking-wider">Settings</span>
                            </div>
                            <svg class="dropdown-arrow h-4 w-4 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div id="settings-dropdown" class="dropdown-content mt-1 ml-2 pl-2 border-l-2 border-indigo-100">
                            <ul class="space-y-2 py-2">
                                @if(Auth::user()->role == 'super_admin' || Auth::user()->role == 'IT_manager')
                                <li>
                                    <a href="{{route('admin.addUserForm')}}"
                                     class="flex items-center px-3 py-2 text-sm font-medium rounded-md
                                     {{ Request::routeIs('admin.addUserForm') ? 'text-white bg-green-500' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-100' }} group">
                                        <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        Add user
                                    </a>
                                </li>
                                @endif
                                <li>
                                    <a href="{{route('company.profile')}}" 
                                       class="flex items-center px-3 py-2 text-sm font-medium rounded-md 
                                       {{ Request::routeIs('company.profile') ? 'text-white bg-green-500' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-100' }} group">
                                        <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                        Company Settings
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('profile.edit') }}"
                                     class="flex items-center px-3 py-2 text-sm font-medium rounded-md
                                    {{ Request::routeIs('profile.edit') ? 'text-white bg-green-500' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-100' }} group">
                                        <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        Profile
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Logout Button (fixed at bottom) -->
                    <div class="absolute bottom-0 left-0 right-0 p-4 border-t bg-white">
                        <form action="{{ route('auth.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

        document.querySelectorAll('.dropdown-toggle').forEach(button => {
            button.addEventListener('click', () => {
                const target = button.getAttribute('data-target');
                const content = document.getElementById(target);
                content.classList.toggle('hidden');
                button.querySelector('.dropdown-arrow')?.classList.toggle('rotate-180');
            });
        });
    </script>
  
    

    

    @yield('scripts')
</body>
</html>