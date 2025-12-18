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
            <div class="mt-4 md:mt-0">
                <a href="{{ route('admin.verification.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Dashboard
                </a>
            </div>
        </div>

        <div class="bg-white/5 backdrop-blur-lg rounded-xl border border-white/10 overflow-hidden shadow-2xl">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-white/10 bg-white/5">
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider cinzel-subheading">User</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider cinzel-subheading hidden md:table-cell">Email</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider cinzel-subheading hidden sm:table-cell">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-300 uppercase tracking-wider cinzel-subheading">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($pendingUsers as $user)
                            <tr class="hover:bg-white/5 transition-colors">
                                <!-- User Column -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full border border-blue-500/30" src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&color=FFFFFF&background=3b82f6" alt="{{ $user->name }}">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-white">{{ $user->name }}</div>
                                            <div class="text-xs text-gray-400 md:hidden">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                
                                <!-- Email Column -->
                                <td class="px-6 py-4 text-sm text-gray-300 hidden md:table-cell">
                                    {{ $user->email }}
                                </td>
                                
                                <!-- Status Column -->
                                <td class="px-6 py-4 hidden sm:table-cell">
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">
                                        <i class="fas fa-clock mr-1"></i> Pending
                                    </span>
                                </td>
                                
                                <!-- Actions Column -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center space-x-2">
                                        <!-- View Button -->
                                        <button onclick="viewUserDetails('{{ $user->id }}')" 
                                                class="action-btn p-2 bg-blue-500/20 text-blue-400 border border-blue-500/30 hover:bg-blue-500/30 rounded-lg transition-all"
                                                id="viewBtn{{ $user->id }}"
                                                title="View Details">
                                            <i class="fas fa-eye" id="viewIcon{{ $user->id }}"></i>
                                            <i class="fas fa-spinner fa-spin hidden" id="viewSpinner{{ $user->id }}"></i>
                                        </button>
                                        
                                        <!-- Approve Button -->
                                        <button onclick="approveUser('{{ $user->id }}')" 
                                                class="p-2 bg-green-500/20 text-green-400 border border-green-500/30 hover:bg-green-500/30 rounded-lg transition-all"
                                                title="Approve">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        
                                        <!-- Reject Button -->
                                        <button onclick="rejectUser('{{ $user->id }}')" 
                                                class="p-2 bg-red-500/20 text-red-400 border border-red-500/30 hover:bg-red-500/30 rounded-lg transition-all"
                                                title="Reject">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class="fas fa-inbox text-gray-600 text-5xl mb-4"></i>
                                        <p class="text-gray-400 text-lg">No pending verifications found</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($pendingUsers->hasPages())
                <div class="px-6 py-4 bg-white/5 border-t border-white/10">
                    {{ $pendingUsers->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 bg-black/80 hidden items-center justify-center z-50 p-4">
    <div class="bg-slate-800 rounded-xl border border-red-500/30 w-full max-w-md mx-auto shadow-2xl">
        <form id="rejectForm" method="POST">
            @csrf
            @method('PUT')
            <div class="p-6">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0 w-12 h-12 bg-red-500/20 rounded-full flex items-center justify-center">
                        <i class="fas fa-times-circle text-red-400 text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-white">Reject Verification</h3>
                        <p class="text-gray-300 mt-2">Please provide a reason for rejecting this user's verification request.</p>
                        
                        <div class="mt-4">
                            <label for="reject_reason" class="block text-sm font-medium text-gray-300 mb-2">Reason</label>
                            <textarea id="reject_reason" name="notes" rows="3" required minlength="10"
                                     class="w-full bg-slate-700 border border-slate-600 rounded-lg text-white p-3 focus:ring-red-500 focus:border-red-500"
                                     placeholder="Minimum 10 characters..."></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-slate-900/50 px-6 py-4 flex justify-end gap-3 rounded-b-xl border-t border-white/5">
                <button type="button" onclick="document.getElementById('rejectModal').classList.add('hidden')"
                        class="px-4 py-2 text-sm font-medium text-gray-300 hover:text-white transition-colors">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-bold transition-all">
                    Reject User
                </button>
            </div>
        </form>
    </div>
</div>

<!-- User Details Modal -->
<div id="userDetailsModal" class="fixed inset-0 bg-black/80 hidden items-center justify-center z-50 p-4">
    <div class="bg-slate-800 rounded-xl border border-blue-500/30 w-full max-w-2xl mx-auto shadow-2xl">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-white cinzel-heading">User Details</h3>
                <button onclick="document.getElementById('userDetailsModal').classList.add('hidden')" class="text-gray-400 hover:text-white transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div id="userDetailsContent" class="min-h-[200px]">
                <!-- Loaded via AJAX -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function setLoadingState(userId, isLoading) {
        const btn = document.getElementById(`viewBtn${userId}`);
        const icon = document.getElementById(`viewIcon${userId}`);
        const spinner = document.getElementById(`viewSpinner${userId}`);
        if (!btn || !icon || !spinner) return;
        
        if (isLoading) {
            btn.disabled = true;
            icon.classList.add('hidden');
            spinner.classList.remove('hidden');
        } else {
            btn.disabled = false;
            icon.classList.remove('hidden');
            spinner.classList.add('hidden');
        }
    }

    function viewUserDetails(userId) {
        const content = document.getElementById('userDetailsContent');
        content.innerHTML = `
            <div class="flex flex-col items-center justify-center py-12">
                <div class="animate-spin rounded-full h-12 w-12 border-4 border-blue-500 border-t-transparent shadow-lg shadow-blue-500/20"></div>
                <p class="mt-4 text-blue-400 font-medium">Loading user data...</p>
            </div>
        `;
        
        document.getElementById('userDetailsModal').classList.remove('hidden');
        document.getElementById('userDetailsModal').classList.add('flex');
        setLoadingState(userId, true);
        
        fetch(`/api/users/${userId}?t=${new Date().getTime()}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(user => {
            content.innerHTML = `
                <div class="space-y-6">
                    <div class="flex items-center gap-6 p-4 bg-blue-500/10 rounded-xl border border-blue-500/20">
                        <img class="h-20 w-20 rounded-full border-2 border-blue-400" src="https://ui-avatars.com/api/?name=${encodeURIComponent(user.name)}&color=FFFFFF&background=3b82f6" alt="${user.name}">
                        <div>
                            <h4 class="text-2xl font-bold text-white">${user.name}</h4>
                            <p class="text-blue-300">${user.email}</p>
                            <span class="mt-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">
                                ${user.verification_status}
                            </span>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="p-4 bg-slate-700/50 rounded-lg">
                            <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Registration Date</p>
                            <p class="text-white">${user.created_at}</p>
                        </div>
                        <div class="p-4 bg-slate-700/50 rounded-lg">
                            <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">User ID</p>
                            <p class="text-white">#${user.id}</p>
                        </div>
                    </div>
                </div>
            `;
        })
        .catch(error => {
            console.error('Error:', error);
            content.innerHTML = `
                <div class="text-center py-8">
                    <div class="w-16 h-16 bg-red-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-exclamation-triangle text-red-400 text-2xl"></i>
                    </div>
                    <p class="text-white font-medium">Failed to load user details</p>
                    <p class="text-gray-400 text-sm mt-1">Please try again later.</p>
                </div>
            `;
        })
        .finally(() => {
            setLoadingState(userId, false);
        });
    }

    function approveUser(userId) {
        if (confirm('Are you sure you want to approve this user?')) {
            const url = "{{ route('admin.verification.approve', ['id' => ':id']) }}".replace(':id', userId);
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = url;
            
            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = '{{ csrf_token() }}';
            
            const method = document.createElement('input');
            method.type = 'hidden';
            method.name = '_method';
            method.value = 'PUT';
            
            form.appendChild(csrf);
            form.appendChild(method);
            document.body.appendChild(form);
            form.submit();
        }
    }

    function rejectUser(userId) {
        const form = document.getElementById('rejectForm');
        form.action = "{{ route('admin.verification.reject', ['id' => ':id']) }}".replace(':id', userId);
        document.getElementById('rejectModal').classList.remove('hidden');
        document.getElementById('rejectModal').classList.add('flex');
    }
</script>
@endpush
