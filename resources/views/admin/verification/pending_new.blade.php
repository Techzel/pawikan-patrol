@extends('layouts.admin')

@section('title', 'Pending Verifications')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900 pt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-white cinzel-heading">Pending Verifications</h1>
                <p class="mt-1 text-sm text-gray-400 cinzel-text">Review and manage user verification requests</p>
            </div>
        </div>

        <div class="bg-white/5 backdrop-blur-lg rounded-xl border border-white/10 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-white/10 bg-white/5">
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider cinzel-subheading">User</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider cinzel-subheading hidden md:table-cell">Email</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider cinzel-subheading hidden sm:table-cell">Status</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-gray-300 uppercase tracking-wider cinzel-subheading">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($users as $user)
                            <tr class="hover:bg-white/5 transition-colors">
                                <!-- User Column -->
                                <td class="px-4 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full" src="{{ $user->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&color=FFFFFF&background=0EA5E9' }}" alt="{{ $user->name }}">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-white cinzel-text">{{ $user->name }}</div>
                                            <div class="text-xs text-gray-400 md:hidden">{{ $user->email }}</div>
                                            <div class="text-xs text-gray-500 sm:hidden mt-1">
                                                @if($user->verification_status === 'pending')
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-500/20 text-yellow-300">
                                                        Pending
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                
                                <!-- Email Column (hidden on mobile) -->
                                <td class="px-4 py-4 text-sm text-gray-300 hidden md:table-cell">
                                    {{ $user->email }}
                                </td>
                                
                                <!-- Status Column (hidden on small screens) -->
                                <td class="px-4 py-4 hidden sm:table-cell">
                                    @if($user->verification_status === 'pending')
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-500/20 text-yellow-300 border border-yellow-500/30">
                                            Pending
                                        </span>
                                    @endif
                                </td>
                                
                                <!-- Actions Column -->
                                <td class="px-4 py-4 text-right">
                                    <div class="flex items-center justify-end space-x-2">
                                        <!-- View Button -->
                                        <button onclick="viewUserDetails({{ $user->id }})" 
                                                class="p-2 text-gray-400 hover:text-blue-400 hover:bg-blue-500/10 rounded-lg transition-colors"
                                                title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        
                                        <!-- Approve Button -->
                                        <button onclick="approveUser({{ $user->id }})" 
                                                class="p-2 text-gray-400 hover:text-green-400 hover:bg-green-500/10 rounded-lg transition-colors"
                                                title="Approve">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        
                                        <!-- Reject Button -->
                                        <button onclick="rejectUser({{ $user->id }})" 
                                                class="p-2 text-gray-400 hover:text-red-400 hover:bg-red-500/10 rounded-lg transition-colors"
                                                title="Reject">
                                            <i class="fas fa-times"></i>
                                        </button>
                                        
                                        <!-- Edit Button (visible on larger screens) -->
                                        <button onclick="window.location.href='/admin/verification/{{ $user->id }}/edit'" 
                                                class="p-2 text-gray-400 hover:text-blue-400 hover:bg-blue-500/10 rounded-lg transition-colors hidden md:inline-flex"
                                                title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        
                                        <!-- Mobile Dropdown (visible only on small screens) -->
                                        <div class="relative md:hidden">
                                            <button type="button" 
                                                    class="p-2 text-gray-400 hover:text-white hover:bg-gray-700 rounded-lg focus:outline-none"
                                                    onclick="toggleDropdown(this)">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <div class="hidden absolute right-0 mt-2 w-40 bg-gray-800 rounded-md shadow-lg py-1 z-10">
                                                <a href="/admin/verification/{{ $user->id }}/edit" 
                                                   class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white">
                                                    <i class="fas fa-edit mr-2"></i> Edit
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class="fas fa-inbox text-gray-600 text-5xl mb-4"></i>
                                        <p class="text-gray-400 text-lg cinzel-text">No pending verifications</p>
                                        <p class="text-gray-500 text-sm mt-2 cinzel-text">New verification requests will appear here</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="fixed z-10 inset-0 overflow-y-auto hidden" id="rejectModal">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-900/80 backdrop-blur-sm"></div>
        </div>
        
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        
        <div class="inline-block align-bottom bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="rejectForm">
                @csrf
                <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <i class="fas fa-exclamation text-red-600"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-white" id="modal-title">
                                Reject Verification
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-300">
                                    Please provide a reason for rejecting this verification request.
                                </p>
                                <div class="mt-4">
                                    <label for="reject_reason" class="block text-sm font-medium text-gray-300">Reason</label>
                                    <textarea id="reject_reason" name="reason" rows="3" class="mt-1 block w-full bg-gray-700 border border-gray-600 rounded-md text-gray-200 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-700/50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse rounded-b-lg">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Reject
                    </button>
                    <button type="button" onclick="document.getElementById('rejectModal').classList.add('hidden')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-600 shadow-sm px-4 py-2 bg-gray-700 text-base font-medium text-gray-300 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View User Modal -->
<div class="fixed z-10 inset-0 overflow-y-auto hidden" id="userDetailsModal">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-900/80 backdrop-blur-sm"></div>
        </div>
        
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        
        <div class="inline-block align-bottom bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
            <div class="px-4 pt-5 pb-4 sm:p-6">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                        <div class="flex justify-between items-start">
                            <h3 class="text-lg leading-6 font-medium text-white" id="modal-title">
                                User Details
                            </h3>
                            <button type="button" onclick="document.getElementById('userDetailsModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-300 focus:outline-none">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="mt-4" id="userDetailsContent">
                            <!-- User details will be loaded here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Toggle dropdown menu
    function toggleDropdown(button) {
        const dropdown = button.nextElementSibling;
        dropdown.classList.toggle('hidden');
        
        // Close other dropdowns
        document.querySelectorAll('.relative .hidden').forEach(el => {
            if (el !== dropdown) {
                el.classList.add('hidden');
            }
        });
    }

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.relative')) {
            document.querySelectorAll('.relative .hidden').forEach(el => {
                el.classList.add('hidden');
            });
        }
    });

    // View user details
    function viewUserDetails(userId) {
        // Show loading state
        const content = document.getElementById('userDetailsContent');
        content.innerHTML = `
            <div class="flex justify-center py-8">
                <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-blue-500"></div>
            </div>
        `;
        
        // Show modal
        document.getElementById('userDetailsModal').classList.remove('hidden');
        
        // Fetch user details
        fetch(`/admin/users/${userId}`)
            .then(response => response.json())
            .then(user => {
                // Format the user details
                content.innerHTML = `
                    <div class="space-y-4">
                        <div class="flex items-center space-x-4">
                            <img class="h-16 w-16 rounded-full" src="${user.profile_photo_url || 'https://ui-avatars.com/api/?name=' + encodeURIComponent(user.name) + '&color=FFFFFF&background=0EA5E9'}" alt="${user.name}">
                            <div>
                                <h4 class="text-lg font-medium text-white">${user.name}</h4>
                                <p class="text-gray-400">${user.email}</p>
                                <p class="text-sm text-gray-500">Member since ${new Date(user.created_at).toLocaleDateString()}</p>
                            </div>
                        </div>
                        
                        <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <p class="text-sm text-gray-400">Verification Status</p>
                                <p class="text-white">
                                    ${user.verification_status === 'pending' ? 
                                        '<span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-500/20 text-yellow-300">Pending</span>' : 
                                        user.verification_status === 'approved' ?
                                        '<span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-500/20 text-green-300">Approved</span>' :
                                        '<span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-500/20 text-red-300">Rejected</span>'
                                    }
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-400">Last Updated</p>
                                <p class="text-white">${new Date(user.updated_at).toLocaleString()}</p>
                            </div>
                        </div>
                        
                        ${user.verification_data ? `
                            <div class="mt-6">
                                <h5 class="text-sm font-medium text-gray-400 mb-2">Verification Documents</h5>
                                <div class="space-y-2">
                                    ${user.verification_data.documents ? Object.entries(user.verification_data.documents).map(([key, url]) => `
                                        <a href="${url}" target="_blank" class="flex items-center text-blue-400 hover:text-blue-300 text-sm">
                                            <i class="fas fa-file-pdf mr-2"></i> ${key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase())}
                                            <i class="fas fa-external-link-alt ml-1 text-xs"></i>
                                        </a>
                                    `).join('') : '<p class="text-gray-400 text-sm">No documents uploaded.</p>'}
                                </div>
                            </div>
                        ` : ''}
                        
                        <div class="pt-4 mt-6 border-t border-gray-700">
                            <div class="flex justify-end space-x-3">
                                <button type="button" onclick="approveUser(${user.id})" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    <i class="fas fa-check mr-2"></i> Approve
                                </button>
                                <button type="button" onclick="rejectUser(${user.id})" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    <i class="fas fa-times mr-2"></i> Reject
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            })
            .catch(error => {
                console.error('Error fetching user details:', error);
                content.innerHTML = `
                    <div class="text-center py-8">
                        <i class="fas fa-exclamation-circle text-red-500 text-4xl mb-3"></i>
                        <p class="text-red-400">Failed to load user details. Please try again.</p>
                        <button onclick="viewUserDetails(${userId})" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            <i class="fas fa-sync-alt mr-2"></i> Retry
                        </button>
                    </div>
                `;
            });
    }

    // Approve user
    function approveUser(userId) {
        if (confirm('Are you sure you want to approve this user?')) {
            fetch(`/admin/verification/${userId}/approve`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                } else {
                    alert('Failed to approve user: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to approve user. Please try again.');
            });
        }
    }

    // Reject user
    let currentRejectUserId = null;
    
    function rejectUser(userId) {
        currentRejectUserId = userId;
        document.getElementById('rejectModal').classList.remove('hidden');
    }

    // Handle reject form submission
    document.getElementById('rejectForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (!currentRejectUserId) return;
        
        const formData = new FormData(this);
        
        fetch(`/admin/verification/${currentRejectUserId}/reject`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                alert('Failed to reject user: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to reject user. Please try again.');
        });
    });
</script>
@endpush
