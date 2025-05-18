@extends('layouts.app')
@section('title', 'User Profile')
@section('content')
<div class="max-w-2xl mx-auto py-8">
    <h2 class="text-2xl font-bold mb-6">User Profile</h2>

    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded mb-6">
            {{ session('success') }}
        </div>
    @elseif(session('current_password'))
    <div class="bg-green-100 text-green-700 p-4 rounded mb-6">
        {{ session('current_password') }}
    </div>
    @endif
    <!-- Toggle Buttons -->
    <div class="flex border-b border-gray-200 mb-6">
        <button id="profile-tab" class="px-4 py-2 font-medium text-sm rounded-t-lg border-b-2 border-blue-500 text-blue-600 focus:outline-none">
            Profile Details
        </button>
        <button id="password-tab" class="px-4 py-2 font-medium text-sm rounded-t-lg text-gray-500 hover:text-gray-700 focus:outline-none">
            Change Password
        </button>
    </div>

    <!-- Profile Details Section -->
    <div id="profile-section" class="space-y-6">
        <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                <input type="text" id="name" name="name" value="{{ old('name', auth()->user()->name) }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200">
                @error('name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" id="email" name="email" value="{{ auth()->user()->email }}" readonly
                    class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md shadow-sm cursor-not-allowed">
                <small class="text-gray-500">To change email, contact your IT Manager.</small>
            </div>

            <div class="pt-4">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Update Profile
                </button>
            </div>
        </form>
    </div>

    <!-- Change Password Section (Hidden by default) -->
    <div id="password-section" class="space-y-6 hidden">
        <form action="{{ route('profile.change-password') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                <div class="relative">
                    <input type="password" id="current_password" name="current_password" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 pr-10">
                    <span class="absolute right-3 top-3 cursor-pointer text-gray-600 toggle-password">👁️</span>
                </div>
                @error('current_password')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="new_password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                <div class="relative">
                    <input type="password" id="new_password" name="new_password" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 pr-10">
                    <span class="absolute right-3 top-3 cursor-pointer text-gray-600 toggle-password">👁️</span>
                </div>
                <div id="password-strength" class="text-sm mt-1"></div>
                @error('new_password')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                <div class="relative">
                    <input type="password" id="new_password_confirmation" name="new_password_confirmation" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 pr-10">
                    <span class="absolute right-3 top-3 cursor-pointer text-gray-600 toggle-password">👁️</span>
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" id="password-submit-btn" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Change Password
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Tab switching functionality
    const profileTab = document.getElementById('profile-tab');
    const passwordTab = document.getElementById('password-tab');
    const profileSection = document.getElementById('profile-section');
    const passwordSection = document.getElementById('password-section');

    profileTab.addEventListener('click', function() {
        profileTab.classList.add('border-blue-500', 'text-blue-600');
        profileTab.classList.remove('text-gray-500', 'hover:text-gray-700');
        passwordTab.classList.remove('border-blue-500', 'text-blue-600');
        passwordTab.classList.add('text-gray-500', 'hover:text-gray-700');
        profileSection.classList.remove('hidden');
        passwordSection.classList.add('hidden');
    });

    passwordTab.addEventListener('click', function() {
        passwordTab.classList.add('border-blue-500', 'text-blue-600');
        passwordTab.classList.remove('text-gray-500', 'hover:text-gray-700');
        profileTab.classList.remove('border-blue-500', 'text-blue-600');
        profileTab.classList.add('text-gray-500', 'hover:text-gray-700');
        passwordSection.classList.remove('hidden');
        profileSection.classList.add('hidden');
    });

    // Password visibility toggle
    document.querySelectorAll('.toggle-password').forEach(function(button) {
        button.addEventListener('click', function() {
            const input = this.previousElementSibling;
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
            this.textContent = type === 'password' ? '👁️' : '🙈';
        });
    });

    // Password strength checker
    const newPasswordInput = document.getElementById('new_password');
    const strengthText = document.getElementById('password-strength');
    const passwordSubmitBtn = document.getElementById('password-submit-btn');

    if (newPasswordInput) {
        newPasswordInput.addEventListener('input', function() {
            const password = newPasswordInput.value;
            const strength = checkPasswordStrength(password);

            strengthText.textContent = strength.label;
            strengthText.className = `text-sm mt-1 ${strength.color}`;

            // Disable submit if strength is weak or low
            if (strength.score < 2 && password.length > 0) {
                passwordSubmitBtn.disabled = true;
                passwordSubmitBtn.classList.add('bg-gray-400', 'cursor-not-allowed');
                passwordSubmitBtn.classList.remove('bg-blue-600', 'hover:bg-blue-700');
            } else {
                passwordSubmitBtn.disabled = false;
                passwordSubmitBtn.classList.remove('bg-gray-400', 'cursor-not-allowed');
                passwordSubmitBtn.classList.add('bg-blue-600', 'hover:bg-blue-700');
            }
        });
    }

    function checkPasswordStrength(password) {
        let score = 0;

        if (password.length >= 8) score++;
        if (/[a-z]/.test(password)) score++;
        if (/[A-Z]/.test(password)) score++;
        if (/\d/.test(password)) score++;
        if (/[^a-zA-Z0-9]/.test(password)) score++;

        if (score <= 1) {
            return { label: "Weak - Use at least 8 characters with mix of letters and numbers", color: "text-red-500", score: score };
        } else if (score <= 3) {
            return { label: "Medium - Add uppercase letters or special characters", color: "text-yellow-500", score: score };
        } else {
            return { label: "Strong", color: "text-green-600", score: score };
        }
    }
});
</script>
@endsection