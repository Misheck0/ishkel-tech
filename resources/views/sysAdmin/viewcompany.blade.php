@extends('..layouts.SysAdmin.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Company Details: {{ $company->name }}</h2>
        
        <div class="mb-6">
            <p class="text-gray-700"><strong class="text-gray-900">Address:</strong> {{ $company->address }}</p>
            <p class="text-gray-700"><strong class="text-gray-900">TPIN:</strong> {{ $company->tpin }}</p>
        </div>

        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold text-gray-800">Users</h3>
            <button onclick="openAddUserModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition duration-200">
                Add User
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($company->users as $user)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $user->role == 'super_admin' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                                {{ $user->role }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add User Modal (will be shown by SweetAlert) -->
<div id="addUserForm" class="hidden">
    <form id="userForm" method="POST" action="{{ route('admin.users.store') }}" class="space-y-4">
        @csrf
        <input type="hidden" name="company_id" value="{{ $company->id }}">
        
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
            <input type="text" name="name" id="name" required 
                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
        </div>
        
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
            <input type="email" name="email" id="email" required 
                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
        </div>
        
        <div>
            <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
            <select name="role" id="role" required 
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                <option value="">Select Role</option>
                <option value="super_admin">Super Admin</option>
                <option value="employee">Employee</option>
            </select>
        </div>
    </form>
</div>

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function openAddUserModal() {
        Swal.fire({
            title: 'Add New User',
            html: document.getElementById('addUserForm').innerHTML,
            showCancelButton: true,
            confirmButtonText: 'Add User',
            cancelButtonText: 'Cancel',
            focusConfirm: false,
            preConfirm: () => {
                const form = document.getElementById('userForm');
              const popup = Swal.getPopup();
    const name = popup.querySelector('#name').value;
    const email = popup.querySelector('#email').value;
    const role = popup.querySelector('#role').value;
    const company_id = '{{ $company->id }}';
             
    const formData = new FormData();
    formData.append('name', name);
    formData.append('email', email);
    formData.append('role', role);
    formData.append('company_id', company_id);

              return fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => {
        if (!response.ok) {
            return response.json().then(err => {
                throw new Error(Object.values(err.errors).flat().join('\n'));
            });
        }
        return response.json();
    })
    .catch(error => {
        Swal.showValidationMessage(
            `Request failed: ${error.message}`
        );
    });
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    'Success!',
                    'User has been added.',
                    'success'
                ).then(() => {
                    window.location.reload();
                });
            }
        });
    }
</script>
@endsection
@endsection