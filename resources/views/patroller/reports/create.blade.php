@extends('layouts.patroller')

@section('title', 'Submit New Report')
@section('container-class', 'max-w-4xl')

@push('styles')
<style>
    /* Base form input styling - only for dropdowns */
    select.form-input {
        background-color: #1f2937 !important;
        color: #f3f4f6 !important;
        border: 1px solid #4b5563 !important;
        border-radius: 0.375rem !important;
        padding: 0.5rem 2.5rem 0.5rem 0.75rem !important;
        width: 100% !important;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%239ca3af' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e") !important;
        background-position: right 0.5rem center !important;
        background-repeat: no-repeat !important;
        background-size: 1.5em 1.5em !important;
    }
    
    /* Focus state */
    .form-input:focus {
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2) !important;
        outline: none !important;
    }
    
    /* Select dropdown options */
    select.form-input option {
        background-color: #1f2937;
        color: #f3f4f6;
        padding: 0.5rem 1rem;
    }
    
    /* Make sure dropdowns appear above other elements */
    select.form-input {
        z-index: 50;
        position: relative;
    }
    
    /* Style the dropdown arrow */
    select {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }
    
    /* Custom scrollbar for dropdowns */
    select.form-input::-ms-expand {
        display: none;
    }
    
    /* Hover and active states */
    select.form-input:hover {
        border-color: #6b7280 !important;
    }
    
    select.form-input:active {
        border-color: #3b82f6 !important;
    }
    
    /* Fix for Firefox */
    @-moz-document url-prefix() {
        select.form-input {
            color: rgba(0, 0, 0, 0) !important;
            text-shadow: 0 0 0 #f3f4f6 !important;
        }
    }
    
    /* For IE11 */
    @media all and (-ms-high-contrast: none), (-ms-high-contrast: active) {
        select.form-input {
            padding-right: 1rem !important;
            background-image: none !important;
        }
    }
    
    /* Select2 overrides if used */
    .select2-container--default .select2-selection--single,
    .select2-dropdown {
        background-color: #1f2937 !important;
        border-color: #4b5563 !important;
        color: #f3f4f6 !important;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #f3f4f6 !important;
    }
    
    .select2-container--default .select2-results__option {
        background-color: #1f2937;
        color: #f3f4f6;
        padding: 0.5rem 1rem;
    }
    
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #3b82f6 !important;
        color: white !important;
    }
    
    /* Ensure dropdown is visible above other elements */
    .select2-container {
        z-index: 1000;
    }
</style>
@endpush

@push('scripts')
<script>
    // Get current location for coordinates
    function getCurrentLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                document.getElementById('latitude').value = position.coords.latitude.toFixed(6);
                document.getElementById('longitude').value = position.coords.longitude.toFixed(6);
            });
        }
    }

    // Add button to get current location
    document.addEventListener('DOMContentLoaded', function() {
        const latitudeInput = document.getElementById('latitude');
        const locationButton = document.createElement('button');
        locationButton.type = 'button';
        locationButton.className = 'mt-2 px-3 py-1 bg-ocean-600 hover:bg-ocean-700 text-white text-sm rounded cinzel-text';
        locationButton.innerHTML = '<i class="fas fa-map-marker-alt mr-1"></i>Get Current Location';
        locationButton.onclick = getCurrentLocation;
        
        latitudeInput.parentNode.appendChild(locationButton);

        const reportTypeSelect = document.getElementById('report_type');
        const eggCountWrapper = document.getElementById('egg-count-wrapper');
        const eggCountInput = document.getElementById('egg_count');

        function toggleEggCountField() {
            if (!reportTypeSelect || !eggCountWrapper) {
                return;
            }

            const isNesting = reportTypeSelect.value === 'nesting';
            eggCountWrapper.classList.toggle('hidden', !isNesting);

            if (eggCountInput) {
                eggCountInput.disabled = !isNesting;
                if (!isNesting) {
                    eggCountInput.value = '';
                }
            }
        }

        if (reportTypeSelect) {
            reportTypeSelect.addEventListener('change', toggleEggCountField);
            toggleEggCountField();
        }
    });
</script>
@endpush

@section('content')
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center mb-4">
                    <a href="{{ route('patroller.dashboard') }}" class="text-ocean-400 hover:text-ocean-300 mr-4">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <h1 class="text-3xl font-bold text-white cinzel-heading">
                        <i class="fas fa-file-plus mr-3 text-ocean-400"></i>Submit New Report
                    </h1>
                </div>
                <p class="text-gray-300 cinzel-text">Fill out the form below to submit a new patrol report.</p>
            </div>

            <!-- Error Messages -->
            @if($errors->any())
                <div class="mb-6 glass-morphism border-l-4 border-red-500 p-4 rounded">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-400"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-red-100 font-medium cinzel-text">Please correct the following errors:</h3>
                            <ul class="mt-2 text-red-200 text-sm list-disc list-inside cinzel-text">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Report Form -->
            @php(
                $reportTypeOptions = collect(\App\Models\PatrolReport::getReportTypeOptions())
                    ->except(['hatchling', 'hazard'])
                    ->map(function ($label, $value) {
                        return $value === 'rescue'
                            ? 'Rescue / Threat & Hazard'
                            : $label;
                    })
                    ->toArray()
            )
            <form action="{{ route('patroller.reports.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <div class="glass-morphism rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-white mb-6 cinzel-subheading">
                        <i class="fas fa-info-circle mr-2 text-teal-400"></i>Basic Information
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Report Type -->
                        <div>
                            <label for="report_type" class="block text-sm font-medium text-gray-300 mb-2 cinzel-text">Report Type *</label>
                            <select id="report_type" name="report_type" required class="form-input w-full px-3 py-2 rounded-md cinzel-text">
                                <option value="">Select report type</option>
                                @foreach($reportTypeOptions as $value => $label)
                                    <option value="{{ $value }}" {{ old('report_type') == $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Priority -->
                        <div>
                            <label for="priority" class="block text-sm font-medium text-gray-300 mb-2 cinzel-text">Priority Level *</label>
                            <select id="priority" name="priority" required class="form-input w-full px-3 py-2 rounded-md cinzel-text">
                                <option value="">Select priority</option>
                                <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
                                <option value="critical" {{ old('priority') == 'critical' ? 'selected' : '' }}>Critical</option>
                            </select>
                        </div>

                        <!-- Title -->
                        <div class="md:col-span-2">
                            <label for="title" class="block text-sm font-medium text-gray-300 mb-2 cinzel-text">Report Title *</label>
                            <input type="text" id="title" name="title" value="{{ old('title') }}" required 
                                   class="form-input w-full px-3 py-2 rounded-md cinzel-text" 
                                   placeholder="Brief description of the report">
                        </div>

                        <!-- Location -->
                        <div class="md:col-span-2">
                            <label for="location" class="block text-sm font-medium text-gray-300 mb-2 cinzel-text">Location *</label>
                            <input type="text" id="location" name="location" value="{{ old('location') }}" required 
                                   class="form-input w-full px-3 py-2 rounded-md cinzel-text" 
                                   placeholder="Specific location or area">
                        </div>

                        <!-- Coordinates -->
                        <div>
                            <label for="latitude" class="block text-sm font-medium text-gray-300 mb-2 cinzel-text">Latitude</label>
                            <input type="number" id="latitude" name="latitude" value="{{ old('latitude') }}" 
                                   step="0.000001" class="form-input w-full px-3 py-2 rounded-md cinzel-text" 
                                   placeholder="e.g., 6.9363">
                        </div>

                        <div>
                            <label for="longitude" class="block text-sm font-medium text-gray-300 mb-2 cinzel-text">Longitude</label>
                            <input type="number" id="longitude" name="longitude" value="{{ old('longitude') }}" 
                                   step="0.000001" class="form-input w-full px-3 py-2 rounded-md cinzel-text" 
                                   placeholder="e.g., 126.2742">
                        </div>

                        <!-- Incident Date/Time -->
                        <div class="md:col-span-2">
                            <label for="incident_datetime" class="block text-sm font-medium text-gray-300 mb-2 cinzel-text">Incident Date & Time</label>
                            <input type="datetime-local" id="incident_datetime" name="incident_datetime" 
                                   value="{{ old('incident_datetime') }}" 
                                   class="form-input w-full px-3 py-2 rounded-md cinzel-text">
                        </div>
                    </div>
                </div>

                <!-- Turtle Information (if applicable) -->
                <div class="glass-morphism rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-white mb-6 cinzel-subheading">
                        <i class="fas fa-turtle mr-2 text-teal-400"></i>Turtle Information
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Turtle Count -->
                        <div>
                            <label for="turtle_count" class="block text-sm font-medium text-gray-300 mb-2 cinzel-text">Number of Turtles</label>
                            <input type="number" id="turtle_count" name="turtle_count" value="{{ old('turtle_count') }}" 
                                   min="0" class="form-input w-full px-3 py-2 rounded-md cinzel-text" 
                                   placeholder="0">
                        </div>

                        <!-- Nesting Egg Count (Nesting Only) -->
                        <div id="egg-count-wrapper" class="col-span-1 {{ old('report_type') === 'nesting' ? '' : 'hidden' }}">
                            <label for="egg_count" class="block text-sm font-medium text-gray-300 mb-2 cinzel-text">Egg Count (Nesting Only)</label>
                            <input type="number" id="egg_count" name="egg_count" value="{{ old('egg_count') }}"
                                   min="0" class="form-input w-full px-3 py-2 rounded-md cinzel-text"
                                   placeholder="Approx. number of eggs">
                            <p class="text-xs text-gray-400 mt-1 cinzel-text">Visible only for nesting reports.</p>
                        </div>

                        <!-- Turtle Species -->
                        <div>
                            <label for="turtle_species" class="block text-sm font-medium text-gray-300 mb-2 cinzel-text">Species</label>
                            <select id="turtle_species" name="turtle_species" class="form-input w-full px-3 py-2 rounded-md cinzel-text">
                                <option value="">Select species</option>
                                <option value="olive_ridley" {{ old('turtle_species') == 'olive_ridley' ? 'selected' : '' }}>Olive Ridley</option>
                                <option value="green_sea_turtle" {{ old('turtle_species') == 'green_sea_turtle' ? 'selected' : '' }}>Green Sea Turtle</option>
                                <option value="hawksbill" {{ old('turtle_species') == 'hawksbill' ? 'selected' : '' }}>Hawksbill</option>
                                <option value="leatherback" {{ old('turtle_species') == 'leatherback' ? 'selected' : '' }}>Leatherback</option>
                                <option value="loggerhead" {{ old('turtle_species') == 'loggerhead' ? 'selected' : '' }}>Loggerhead</option>
                            </select>
                        </div>

                        <!-- Turtle Gender -->
                        <div>
                            <label for="gender" class="block text-sm font-medium text-gray-300 mb-2 cinzel-text">Turtle Gender</label>
                            <select id="gender" name="gender" class="form-input w-full px-3 py-2 rounded-md cinzel-text">
                                <option value="" {{ old('gender') == '' ? 'selected' : '' }}>Select gender</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="unknown" {{ old('gender') == 'unknown' ? 'selected' : '' }}>Unknown</option>
                            </select>
                        </div>

                        <!-- Turtle Condition -->
                        <div>
                            <label for="turtle_condition" class="block text-sm font-medium text-gray-300 mb-2 cinzel-text">Condition</label>
                            <select id="turtle_condition" name="turtle_condition" class="form-input w-full px-3 py-2 rounded-md cinzel-text">
                                <option value="">Select condition</option>
                                <option value="healthy" {{ old('turtle_condition') == 'healthy' ? 'selected' : '' }}>Healthy</option>
                                <option value="injured" {{ old('turtle_condition') == 'injured' ? 'selected' : '' }}>Injured</option>
                                <option value="dead" {{ old('turtle_condition') == 'dead' ? 'selected' : '' }}>Dead</option>
                                <option value="unknown" {{ old('turtle_condition') == 'unknown' ? 'selected' : '' }}>Unknown</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Detailed Description -->
                <div class="glass-morphism rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-white mb-6 cinzel-subheading">
                        <i class="fas fa-file-text mr-2 text-teal-400"></i>Detailed Information
                    </h3>
                    
                    <div class="space-y-6">
                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-300 mb-2 cinzel-text">Detailed Description *</label>
                            <textarea id="description" name="description" rows="4" required 
                                      class="form-input w-full px-3 py-2 rounded-md cinzel-text" 
                                      placeholder="Provide a detailed description of what you observed or the incident that occurred">{{ old('description') }}</textarea>
                        </div>

                        <!-- Weather Conditions -->
                        <div>
                            <label for="weather_conditions" class="block text-sm font-medium text-gray-300 mb-2 cinzel-text">Weather Conditions</label>
                            <select id="weather_conditions" name="weather_conditions" class="form-input w-full px-3 py-2 rounded-md cinzel-text">
                                <option value="" {{ old('weather_conditions') == '' ? 'selected' : '' }}>Select weather condition</option>
                                <option value="Sunny" {{ old('weather_conditions') == 'Sunny' ? 'selected' : '' }}>☀️ Sunny</option>
                                <option value="Partly Cloudy" {{ old('weather_conditions') == 'Partly Cloudy' ? 'selected' : '' }}>⛅ Partly Cloudy</option>
                                <option value="Cloudy" {{ old('weather_conditions') == 'Cloudy' ? 'selected' : '' }}>☁️ Cloudy</option>
                                <option value="Rainy" {{ old('weather_conditions') == 'Rainy' ? 'selected' : '' }}>🌧️ Rainy</option>
                                <option value="Stormy" {{ old('weather_conditions') == 'Stormy' ? 'selected' : '' }}>⛈️ Stormy</option>
                                <option value="Windy" {{ old('weather_conditions') == 'Windy' ? 'selected' : '' }}>💨 Windy</option>
                                <option value="Foggy" {{ old('weather_conditions') == 'Foggy' ? 'selected' : '' }}>🌫️ Foggy</option>
                                <option value="Hazy" {{ old('weather_conditions') == 'Hazy' ? 'selected' : '' }}>😶‍🌫️ Hazy</option>
                                <option value="Clear Night" {{ old('weather_conditions') == 'Clear Night' ? 'selected' : '' }}>🌙 Clear Night</option>
                                <option value="Other" {{ old('weather_conditions') == 'Other' ? 'selected' : '' }}>Other (specify in notes)</option>
                            </select>
                        </div>

                        <!-- Requires Follow-up -->

                    </div>
                </div>

                <!-- Images -->
                <div class="glass-morphism rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-white mb-6 cinzel-subheading">
                        <i class="fas fa-camera mr-2 text-teal-400"></i>Evidence Photos
                    </h3>
                    
                    <div>
                        <label for="images" class="block text-sm font-medium text-gray-300 mb-2 cinzel-text">Upload Photos</label>
                        <input type="file" id="images" name="images[]" multiple accept="image/*" 
                               class="form-input w-full px-3 py-2 rounded-md cinzel-text">
                        <p class="mt-2 text-sm text-gray-400 cinzel-text">You can upload multiple images. Supported formats: JPEG, PNG, JPG, GIF (max 2MB each)</p>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('patroller.dashboard') }}" 
                       class="px-6 py-3 border border-gray-300 rounded-md text-gray-300 hover:text-white hover:border-white transition duration-300 cinzel-text">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-gradient-to-r from-teal-500 to-blue-600 hover:from-teal-600 hover:to-blue-700 text-white font-bold rounded-md transition duration-300 cinzel-text">
                        <i class="fas fa-paper-plane mr-2"></i>Submit Report
                    </button>
                </div>
            </form>
@endsection
