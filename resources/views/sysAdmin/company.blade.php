@extends('layouts.SysAdmin.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Companies Management</h2>
        <button onclick="showCreateCompanyForm()" 
                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
            <svg class="-ml-1 mr-2 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"/>
            </svg>
            Create New Company
        </button>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Address
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            TPIN
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Email
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Phone
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($companies as $company)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $company->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $company->address }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $company->tpin }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $company->email ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $company->number ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-2">
                                <a href="{{ route('companies.show', $company->id) }}" 
                                   class="text-indigo-600 hover:text-indigo-900">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                                <form method="POST" action="{{ route('companies.destroy', $company->id) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Are you sure you want to delete this company?')" 
                                            class="text-red-600 hover:text-red-900">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                            No companies found. Click "Create New Company" to add one.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<div id="createCompanyFormTemplate" class="hidden">
    <form id="createCompanyForm" action="{{ route('companies.store') }}" method="POST" class="space-y-6">
        @csrf
        <div class="space-y-6 bg-white px-4 py-5 sm:p-6 rounded-lg shadow">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Company Information</h3>
            
            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                <!-- Company Name -->
                <div class="sm:col-span-6">
                    <label for="company_name" class="block text-sm font-medium text-gray-700">Company Name <span class="text-red-500">*</span></label>
                    <div class="mt-1">
                        <input type="text" id="company_name" name="name" required 
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2 px-3 border
                               @error('name') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                               value="{{ old('name') }}">
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
    
                <!-- Address -->
                <div class="sm:col-span-6">
                    <label for="address" class="block text-sm font-medium text-gray-700">Address <span class="text-red-500">*</span></label>
                    <div class="mt-1">
                        <input type="text" id="address" name="address" required 
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2 px-3 border
                               @error('address') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                               value="{{ old('address') }}">
                        @error('address')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
    
                <!-- Email -->
                <div class="sm:col-span-6">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <div class="mt-1">
                        <input type="email" id="email" name="email" 
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2 px-3 border
                               @error('email') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                               value="{{ old('email') }}">
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
    
                <!-- Phone Number -->
                <div class="sm:col-span-6">
                    <label for="number" class="block text-sm font-medium text-gray-700">Phone Number</label>
                    <div class="mt-1">
                        <input type="tel" id="number" name="number" 
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2 px-3 border
                               @error('number') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                               value="{{ old('number') }}">
                        @error('number')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
    
                <!-- TPIN -->
                <div class="sm:col-span-6">
                    <label for="tpin" class="block text-sm font-medium text-gray-700">TPIN <span class="text-red-500">*</span></label>
                    <div class="mt-1">
                        <input type="text" id="tpin" name="tpin" required 
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2 px-3 border
                               @error('tpin') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                               value="{{ old('tpin') }}">
                        @error('tpin')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    
    </form>
</div>
@section('scripts')
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// Function to show the create company form in a modal
function showCreateCompanyForm() {
    Swal.fire({
        title: 'Create New Company',
        html: document.getElementById('createCompanyFormTemplate').innerHTML,
        showCancelButton: true,
        confirmButtonText: 'Save Company',
        cancelButtonText: 'Cancel',
        focusConfirm: false,
        showLoaderOnConfirm: true,
        preConfirm: () => {
            // Get the form inside SweetAlert
            const form = document.querySelector('.swal2-container #createCompanyForm');
            const formData = new FormData(form);
            
            return fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw err; });
                }
                return response.json();
            })
            .catch(error => {
                // Handle validation errors
                if (error.errors) {
                    let errorMessages = [];
                    for (let field in error.errors) {
                        errorMessages.push(error.errors[field][0]);
                    }
                    Swal.showValidationMessage(errorMessages.join('<br>'));
                } else {
                    Swal.showValidationMessage(
                        `Request failed: ${error.message || error}`
                    );
                }
            });
        },
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire(
                'Created!',
                'The company has been created.',
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