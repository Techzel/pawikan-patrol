@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Validate Patrol Report</h2>
            <a href="{{ route('admin.patrol-reports.show', $report->id) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                &larr; Back to Report
            </a>
        </div>

        <!-- Report Summary -->
        <div class="mb-8 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">Report Details</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-300">Report ID</p>
                    <p class="font-medium text-gray-900 dark:text-white">#{{ $report->id }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-300">Submitted By</p>
                    <p class="font-medium text-gray-900 dark:text-white">{{ $report->patroller->name ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-300">Report Type</p>
                    <p class="font-medium text-gray-900 dark:text-white">{{ ucfirst(str_replace('_', ' ', $report->report_type)) }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-300">Status</p>
                    <span class="px-2 py-1 text-xs rounded-full {{ 
                        $report->status === 'validated' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 
                        ($report->status === 'rejected' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : 
                        'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200')
                    }}">
                        {{ ucfirst(str_replace('_', ' ', $report->status)) }}
                    </span>
                </div>
                @if($report->gender)
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-300">Turtle Gender</p>
                        <p class="font-medium text-gray-900 dark:text-white">{{ ucfirst($report->gender) }}</p>
                    </div>
                @endif
                @if($report->egg_count !== null)
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-300">Egg Count</p>
                        <p class="font-medium text-gray-900 dark:text-white">{{ number_format($report->egg_count) }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Validation Form -->
        <form action="{{ route('admin.patrol-reports.validate', $report->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Validation Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Validation Status</label>
                    <select id="status" name="status" required 
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md dark:bg-gray-700 dark:text-white">
                        <option value="" disabled selected>Select validation status</option>
                        <option value="validated" {{ old('status', $report->status) === 'validated' ? 'selected' : '' }}>Validate Report</option>
                        <option value="needs_correction" {{ old('status', $report->status) === 'needs_correction' ? 'selected' : '' }}>Needs Correction</option>
                        <option value="rejected" {{ old('status', $report->status) === 'rejected' ? 'selected' : '' }}>Reject Report</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Validation Notes -->
                <div>
                    <label for="validation_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Validation Notes
                        <span class="text-gray-500 text-xs">(Required for 'Needs Correction' or 'Reject')</span>
                    </label>
                    <textarea id="validation_notes" name="validation_notes" rows="4" 
                              class="mt-1 block w-full shadow-sm sm:text-sm border border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-white"
                              placeholder="Provide details about your validation decision. If corrections are needed, be specific about what needs to be fixed.">{{ old('validation_notes', $report->validation_notes) }}</textarea>
                    @error('validation_notes')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Evidence Check -->
                <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                    <div class="flex items-center">
                        <input id="evidence_verified" name="evidence_verified" type="checkbox" 
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600"
                               {{ old('evidence_verified', $report->evidence_verified) ? 'checked' : '' }}>
                        <label for="evidence_verified" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                            I have verified all attached evidence (photos, documents, etc.)
                        </label>
                    </div>
                    @error('evidence_verified')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Location Verification -->
                <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                    <div class="flex items-center mb-4">
                        <input id="location_verified" name="location_verified" type="checkbox" 
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600"
                               {{ old('location_verified', $report->location_verified) ? 'checked' : '' }}>
                        <label for="location_verified" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                            The reported location has been verified
                        </label>
                    </div>
                    
                    <!-- GPS Coordinates for Map Display -->
                    <div class="mt-4 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                        <h4 class="text-sm font-semibold text-blue-900 dark:text-blue-100 mb-3 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            GPS Coordinates (Required for Map Display)
                        </h4>
                        <p class="text-xs text-blue-700 dark:text-blue-300 mb-3">
                            Add coordinates to display this report on the patrol map. You can use Google Maps to find exact coordinates.
                        </p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="latitude" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Latitude
                                    <span class="text-xs text-gray-500">(e.g., 6.9555)</span>
                                </label>
                                <input type="number" step="0.000001" id="latitude" name="latitude" 
                                       value="{{ old('latitude', $report->latitude) }}"
                                       class="mt-1 block w-full shadow-sm sm:text-sm border border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-white"
                                       placeholder="6.9555">
                                @error('latitude')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="longitude" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Longitude
                                    <span class="text-xs text-gray-500">(e.g., 126.2811)</span>
                                </label>
                                <input type="number" step="0.000001" id="longitude" name="longitude" 
                                       value="{{ old('longitude', $report->longitude) }}"
                                       class="mt-1 block w-full shadow-sm sm:text-sm border border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-white"
                                       placeholder="126.2811">
                                @error('longitude')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        @if($report->location)
                        <p class="mt-2 text-xs text-gray-600 dark:text-gray-400">
                            <strong>Reported Location:</strong> {{ $report->location }}
                        </p>
                        @endif
                    </div>
                    
                    @error('location_verified')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Priority Level -->
                <div>
                    <label for="priority" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Priority Level</label>
                    <select id="priority" name="priority" required
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md dark:bg-gray-700 dark:text-white">
                        <option value="low" {{ old('priority', $report->priority) === 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ old('priority', $report->priority) === 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ old('priority', $report->priority) === 'high' ? 'selected' : '' }}>High</option>
                        <option value="critical" {{ old('priority', $report->priority) === 'critical' ? 'selected' : '' }}>Critical</option>
                    </select>
                    @error('priority')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Follow-up Required -->
                <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                    <div class="flex items-center">
                        <input id="needs_followup" name="needs_followup" type="checkbox" 
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600"
                               {{ old('needs_followup', $report->needs_followup) ? 'checked' : '' }}>
                        <label for="needs_followup" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                            This report requires follow-up action
                        </label>
                    </div>
                    @error('needs_followup')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Follow-up Notes (Conditional) -->
                <div id="followupNotesContainer" class="hidden">
                    <label for="followup_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Follow-up Instructions
                    </label>
                    <textarea id="followup_notes" name="followup_notes" rows="3" 
                              class="mt-1 block w-full shadow-sm sm:text-sm border border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-white"
                              placeholder="Provide specific instructions for the follow-up action.">{{ old('followup_notes', $report->followup_notes) }}</textarea>
                    @error('followup_notes')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Submit Validation
                    </button>
                    <a href="{{ route('admin.patrol-reports.show', $report->id) }}" class="ml-2 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Show/hide follow-up notes based on checkbox
    const needsFollowup = document.getElementById('needs_followup');
    const followupNotesContainer = document.getElementById('followupNotesContainer');
    const followupNotes = document.getElementById('followup_notes');

    function toggleFollowupNotes() {
        if (needsFollowup.checked) {
            followupNotesContainer.classList.remove('hidden');
            followupNotes.required = true;
        } else {
            followupNotesContainer.classList.add('hidden');
            followupNotes.required = false;
        }
    }

    // Initial check
    toggleFollowupNotes();
    
    // Add event listener
    needsFollowup.addEventListener('change', toggleFollowupNotes);

    // Add validation for notes when status is needs_correction or rejected
    const form = document.querySelector('form');
    const statusSelect = document.getElementById('status');
    const validationNotes = document.getElementById('validation_notes');

    form.addEventListener('submit', function(e) {
        const status = statusSelect.value;
        const notes = validationNotes.value.trim();
        
        if ((status === 'needs_correction' || status === 'rejected') && notes === '') {
            e.preventDefault();
            alert('Validation notes are required when status is "Needs Correction" or "Reject".');
            validationNotes.focus();
        }
    });
</script>
@endpush
@endsection
