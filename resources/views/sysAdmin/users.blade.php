@extends('..layouts.SysAdmin.app')

@section('title', 'User Management')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">User Management</h1>
        <a href="#" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg shadow flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Add New User
        </a>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Login</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                    <span class="text-blue-600 font-medium">
                                        {{ substr($user->name, 0, 2) }}
                                    </span>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                    <div class="text-sm text-gray-500">ID: {{ $user->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $user->email }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $user->role == 'admin' ? 'bg-purple-100 text-purple-800' : 
                                   ($user->role == 'employer' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $user->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($user->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($user->last_login_at)->diffForHumans() ?? 'Never' }}

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button onclick="viewUser({{ json_encode($user) }})" class="text-blue-600 hover:text-blue-900 mr-3">View</button>
                            @if($user->status == 'active')
                                <button onclick="revokeUser({{ $user->id }})" class="text-yellow-600 hover:text-yellow-900 mr-3">Revoke</button>
                            @else
                                <button onclick="activateUser({{ $user->id }})" class="text-green-600 hover:text-green-900 mr-3">Activate</button>
                            @endif
                            <button onclick="confirmDelete({{ $user->id }})" class="text-red-600 hover:text-red-900">Delete</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($users->hasPages())
        <div class="bg-gray-50 px-6 py-3 border-t border-gray-200">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function viewUser(user) {
        Swal.fire({
            title: 'User Details',
            html: `
                <div class="text-left space-y-4">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0 h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center">
                            <span class="text-blue-600 font-medium text-lg">${user.name.substring(0, 2)}</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium">${user.name}</h3>
                            <p class="text-gray-500">${user.email}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Role</p>
                            <p class="font-medium">${user.role}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Status</p>
                            <p class="font-medium">${user.status}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Last Login</p>
                            <p class="font-medium">${user.last_login_at ? '${new Date(user.last_login_at).toLocaleString()}' : 'Never'}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Created</p>
                            <p class="font-medium">${new Date(user.created_at).toLocaleDateString()}</p>
                        </div>
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Change Email',
            cancelButtonText: 'Reset Password',
            showDenyButton: true,
            denyButtonText: 'Close',
            focusConfirm: false,
            customClass: {
                confirmButton: 'bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md mr-2',
                cancelButton: 'bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md mr-2',
                denyButton: 'bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded-md'
            },
            buttonsStyling: false,
            preConfirm: () => {
                return changeEmail(user.id);
            },
            preDeny: () => {
                return true; // Just close
            }
        }).then((result) => {
            if (result.isDismissed && result.dismiss === Swal.DismissReason.cancel) {
                resetPassword(user.id);
            }
        });
    }

    function changeEmail(userId) {
        Swal.fire({
            title: 'Change Email',
            input: 'email',
            inputLabel: 'New Email Address',
            inputPlaceholder: 'Enter new email address',
            showCancelButton: true,
            confirmButtonText: 'Update',
            showLoaderOnConfirm: true,
            preConfirm: (email) => {
                return fetch(`/admin/users/${userId}/change-email`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ email: email })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(response.statusText);
                    }
                    return response.json();
                })
                .catch(error => {
                    Swal.showValidationMessage(
                        `Request failed: ${error}`
                    );
                });
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    'Success!',
                    'Email address has been updated.',
                    'success'
                ).then(() => {
                    window.location.reload();
                });
            }
        });
    }

    function resetPassword(userId) {
        Swal.fire({
            title: 'Reset Password',
            text: "Are you sure you want to reset this user's password? They will receive an email with instructions.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, reset it!'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/admin/users/${userId}/reset-password`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    Swal.fire(
                        'Success!',
                        'Password reset email has been sent.',
                        'success'
                    );
                })
                .catch(error => {
                    Swal.fire(
                        'Error!',
                        'Failed to reset password.',
                        'error'
                    );
                });
            }
        });
    }

    function revokeUser(userId) {
        Swal.fire({
            title: 'Revoke Access',
            text: "Are you sure you want to revoke this user's access?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, revoke it!'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/admin/users/${userId}/revoke`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    Swal.fire(
                        'Revoked!',
                        'User access has been revoked.',
                        'success'
                    ).then(() => {
                        window.location.reload();
                    });
                })
                .catch(error => {
                    Swal.fire(
                        'Error!',
                        'Failed to revoke access.',
                        'error'
                    );
                });
            }
        });
    }

    function activateUser(userId) {
        Swal.fire({
            title: 'Activate User',
            text: "Are you sure you want to activate this user?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, activate!'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/admin/users/${userId}/activate`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    Swal.fire(
                        'Activated!',
                        'User has been activated.',
                        'success'
                    ).then(() => {
                        window.location.reload();
                    });
                })
                .catch(error => {
                    Swal.fire(
                        'Error!',
                        'Failed to activate user.',
                        'error'
                    );
                });
            }
        });
    }

    function confirmDelete(userId) {
        Swal.fire({
            title: 'Delete User',
            text: "Are you sure you want to permanently delete this user? This cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/admin/users/${userId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    Swal.fire(
                        'Deleted!',
                        'User has been deleted.',
                        'success'
                    ).then(() => {
                        window.location.reload();
                    });
                })
                .catch(error => {
                    Swal.fire(
                        'Error!',
                        'Failed to delete user.',
                        'error'
                    );
                });
            }
        });
    }
</script>
@endsection
@endsection