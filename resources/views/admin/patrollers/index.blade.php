@extends('layouts.app')

@section('title', 'Patroller Management')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Patroller Management</h1>
        <p class="text-gray-600">Manage and monitor all patroller accounts</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Patrollers</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $patrollers->total() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Active</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $patrollers->where('is_active', true)->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">On Leave</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $patrollers->where('is_active', false)->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Impact</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $patrollers->sum('total_conservation_impact') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Bar -->
    <div class="bg-white rounded-lg shadow mb-6 p-4">
        <div class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
            <div class="flex space-x-4">
                <a href="{{ route('admin.patrollers.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add New Patroller
                </a>
                
                <button onclick="toggleBulkActions()" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                    </svg>
                    Bulk Actions
                </button>
            </div>

            <!-- Bulk Actions (Hidden by default) -->
            <div id="bulkActions" class="hidden flex space-x-2">
                <form action="{{ route('admin.patrollers.bulk-activate') }}" method="POST" class="inline">
                    @csrf
                    <input type="hidden" name="patroller_ids" id="bulkActivateIds">
                    <button type="submit" class="inline-flex items-center px-3 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm">
                        Activate
                    </button>
                </form>
                
                <form action="{{ route('admin.patrollers.bulk-deactivate') }}" method="POST" class="inline">
                    @csrf
                    <input type="hidden" name="patroller_ids" id="bulkDeactivateIds">
                    <button type="submit" class="inline-flex items-center px-3 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors text-sm">
                        Deactivate
                    </button>
                </form>
                
                <form action="{{ route('admin.patrollers.bulk-delete') }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete the selected patrollers? This action cannot be undone.')">
                    @csrf
                    <input type="hidden" name="patroller_ids" id="bulkDeleteIds">
                    <button type="submit" class="inline-flex items-center px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors text-sm">
                        Delete
                    </button>
                </form>
            </div>

            <div class="flex space-x-4">
                <div class="relative">
                    <input type="text" placeholder="Search patrollers..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                
                <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                    <option value="on_leave">On Leave</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Patrollers Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <input type="checkbox" id="selectAll" onchange="toggleSelectAll()" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Patroller</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Badge Number</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Department</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Performance</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Impact</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($patrollers as $patroller)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="checkbox" class="patroller-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500" value="{{ $patroller->id }}" onchange="updateBulkActionIds()">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full" src="{{ $patroller->profile_photo_url ?: 'https://ui-avatars.com/api/?name=' . urlencode($patroller->name) . '&color=7C3AED&background=F3E8FF' }}" alt="{{ $patroller->name }}">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $patroller->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $patroller->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $patroller->badge_number ?: 'Not Assigned' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $patroller->patrollerProfile->department ?? 'Unassigned' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($patroller->is_active)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Inactive</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                @if ($patroller->patrollerProfile && $patroller->patrollerProfile->performance_rating)
                                    <div class="flex items-center">
                                        <span class="text-sm font-medium">{{ number_format($patroller->patrollerProfile->performance_rating, 1) }}</span>
                                        <span class="text-xs text-gray-500 ml-1">/5.0</span>
                                    </div>
                                @else
                                    <span class="text-sm text-gray-500">Not Rated</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <div class="text-sm">{{ $patroller->total_conservation_impact }}</div>
                                <div class="text-xs text-gray-500">{{ $patroller->patroller_rank }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.patrollers.profile', $patroller->id) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                    <a href="{{ route('admin.patrollers.edit', $patroller->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    <form action="{{ route('admin.patrollers.destroy', $patroller->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this patroller? This action cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">
                                No patrollers found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
            <div class="flex-1 flex justify-between sm:hidden">
                @if ($patrollers->onFirstPage())
                    <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-gray-50 cursor-not-allowed">
                        Previous
                    </span>
                @else
                    <a href="{{ $patrollers->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Previous
                    </a>
                @endif

                @if ($patrollers->hasMorePages())
                    <a href="{{ $patrollers->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Next
                    </a>
                @else
                    <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-gray-50 cursor-not-allowed">
                        Next
                    </span>
                @endif
            </div>
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-gray-700">
                        Showing <span class="font-medium">{{ $patrollers->firstItem() }}</span> to <span class="font-medium">{{ $patrollers->lastItem() }}</span> of <span class="font-medium">{{ $patrollers->total() }}</span> results
                    </p>
                </div>
                <div>
                    {{ $patrollers->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleBulkActions() {
    const bulkActions = document.getElementById('bulkActions');
    bulkActions.classList.toggle('hidden');
}

function toggleSelectAll() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.patroller-checkbox');
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAll.checked;
    });
    
    updateBulkActionIds();
}

function updateBulkActionIds() {
    const selectedIds = Array.from(document.querySelectorAll('.patroller-checkbox:checked'))
        .map(checkbox => checkbox.value);
    
    document.getElementById('bulkActivateIds').value = selectedIds.join(',');
    document.getElementById('bulkDeactivateIds').value = selectedIds.join(',');
    document.getElementById('bulkDeleteIds').value = selectedIds.join(',');
}
</script>
@endsection
