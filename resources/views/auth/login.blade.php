@extends('..layouts.guest')

@section('content')
<div class="min-h-screen flex flex-col justify-center bg-gray-50 py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <!-- Header Section -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold text-gray-900">
                
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                ISHKET TECH ENTERPRISE
            </p>
        </div>

        <!-- Login Card -->
        <div class="bg-white py-8 px-4 shadow rounded-lg sm:px-10">
            <form class="space-y-6" method="POST" action="{{ route('auth.login') }}">
                @csrf

                <!-- Email Input -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        Email Address
                    </label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" autocomplete="email" required
                               class="appearance-none block w-full px-3 py-2 border border-gray-300
                                      rounded-md shadow-sm placeholder-gray-400 focus:outline-none
                                      focus:ring-blue-500 focus:border-blue-500 sm:text-sm
                                      @error('email') border-red-500 @enderror"
                               value="{{ old('email') }}">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Password Input -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        Password
                    </label>
                    <div class="mt-1">
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                               class="appearance-none block w-full px-3 py-2 border border-gray-300
                                      rounded-md shadow-sm placeholder-gray-400 focus:outline-none
                                      focus:ring-blue-500 focus:border-blue-500 sm:text-sm
                                      @error('password') border-red-500 @enderror">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Remember & Forgot Password -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember" type="checkbox"
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-900">
                            Remember me
                        </label>
                    </div>

                    <div class="text-sm">
                        <a href="#" class="font-medium text-blue-600 hover:text-blue-500">
                            Forgot password?
                        </a>
                    </div>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit"
                            class="w-full flex justify-center py-2 px-4 border border-transparent
                                   rounded-md shadow-sm text-sm font-medium text-white bg-blue-600
                                   hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2
                                   focus:ring-blue-500 transition-colors duration-200">
                        Login
                    </button>
                </div>

          
            </form>
        </div>

        <!-- Security Badges -->
        <div class="mt-8 text-center">
            <div class="inline-flex items-center space-x-4">
                <svg class="h-6 w-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="text-sm text-gray-600">256-bit SSL encryption</span>
            </div>
        </div>
    </div>
</div>
@endsection