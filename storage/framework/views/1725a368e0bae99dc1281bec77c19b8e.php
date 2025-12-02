<?php $__env->startSection('title', 'Edit Report'); ?>
<?php $__env->startSection('container-class', 'max-w-4xl'); ?>

<?php $__env->startPush('styles'); ?>
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
    
    /* Text inputs and textareas */
    input.form-input,
    textarea.form-input {
        background-color: #1f2937 !important;
        color: #f3f4f6 !important;
        border: 1px solid #4b5563 !important;
        border-radius: 0.375rem !important;
        padding: 0.5rem 0.75rem !important;
    }
    
    input.form-input:focus,
    textarea.form-input:focus {
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2) !important;
        outline: none !important;
    }
    
    /* Hover states */
    select.form-input:hover,
    input.form-input:hover,
    textarea.form-input:hover {
        border-color: #6b7280 !important;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // Get current location for coordinates with HIGH ACCURACY GPS
    function getCurrentLocation() {
        const locationButton = document.getElementById('gps-location-btn');
        const latitudeInput = document.getElementById('latitude');
        const longitudeInput = document.getElementById('longitude');
        
        if (!navigator.geolocation) {
            alert('❌ Geolocation is not supported by your browser.\n\nPlease enter coordinates manually or use a device with GPS capability.');
            return;
        }

        // Show loading state
        const originalButtonHTML = locationButton.innerHTML;
        locationButton.disabled = true;
        locationButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i>Acquiring GPS Signal...';
        locationButton.classList.add('opacity-75');
        
        // Remove any existing accuracy message
        const existingAccuracyMsg = document.getElementById('accuracy-message');
        if (existingAccuracyMsg) {
            existingAccuracyMsg.remove();
        }

        // HIGH ACCURACY GPS OPTIONS - Critical for precise marker placement
        const options = {
            enableHighAccuracy: true,  // ✅ FORCE GPS usage (not WiFi/cell tower triangulation)
            timeout: 15000,            // Wait up to 15 seconds for GPS lock
            maximumAge: 0              // Don't use cached position - get fresh GPS data
        };

        console.log('🛰️ Requesting high-accuracy GPS position...');

        navigator.geolocation.getCurrentPosition(
            function(position) {
                // ✅ SUCCESS - GPS lock acquired
                const lat = position.coords.latitude.toFixed(6);
                const lng = position.coords.longitude.toFixed(6);
                const accuracy = position.coords.accuracy; // Accuracy radius in meters
                
                console.log('✅ GPS Position acquired:', {
                    latitude: lat,
                    longitude: lng,
                    accuracy: accuracy + 'm',
                    altitude: position.coords.altitude,
                    speed: position.coords.speed
                });
                
                latitudeInput.value = lat;
                longitudeInput.value = lng;
                
                // Reset button with success state
                locationButton.disabled = false;
                locationButton.classList.remove('opacity-75');
                locationButton.innerHTML = '<i class="fas fa-check-circle mr-1"></i>GPS Lock Acquired!';
                locationButton.classList.add('bg-green-600');
                
                setTimeout(() => {
                    locationButton.innerHTML = originalButtonHTML;
                    locationButton.classList.remove('bg-green-600');
                }, 3000);
                
                // Show detailed accuracy information
                const accuracyMessage = document.createElement('div');
                accuracyMessage.id = 'accuracy-message';
                accuracyMessage.className = 'mt-2 p-2 rounded-lg text-xs cinzel-text border';
                
                let accuracyLevel = '';
                let accuracyIcon = '';
                let accuracyColor = '';
                let accuracyAdvice = '';
                
                if (accuracy <= 5) {
                    accuracyLevel = 'EXCELLENT';
                    accuracyIcon = 'fa-check-double';
                    accuracyColor = 'bg-green-500/20 border-green-500/50 text-green-300';
                    accuracyAdvice = 'Perfect for precise mapping!';
                } else if (accuracy <= 10) {
                    accuracyLevel = 'VERY GOOD';
                    accuracyIcon = 'fa-check-circle';
                    accuracyColor = 'bg-green-500/20 border-green-500/50 text-green-300';
                    accuracyAdvice = 'Great GPS signal quality.';
                } else if (accuracy <= 20) {
                    accuracyLevel = 'GOOD';
                    accuracyIcon = 'fa-check';
                    accuracyColor = 'bg-blue-500/20 border-blue-500/50 text-blue-300';
                    accuracyAdvice = 'Suitable for most mapping needs.';
                } else if (accuracy <= 50) {
                    accuracyLevel = 'FAIR';
                    accuracyIcon = 'fa-info-circle';
                    accuracyColor = 'bg-yellow-500/20 border-yellow-500/50 text-yellow-300';
                    accuracyAdvice = 'Consider waiting for better signal.';
                } else if (accuracy <= 100) {
                    accuracyLevel = 'MODERATE';
                    accuracyIcon = 'fa-exclamation-triangle';
                    accuracyColor = 'bg-orange-500/20 border-orange-500/50 text-orange-300';
                    accuracyAdvice = 'Move to open area for better accuracy.';
                } else {
                    accuracyLevel = 'LOW';
                    accuracyIcon = 'fa-exclamation-circle';
                    accuracyColor = 'bg-red-500/20 border-red-500/50 text-red-300';
                    accuracyAdvice = '⚠️ Go outdoors for GPS signal. Current accuracy may be insufficient.';
                }
                
                accuracyMessage.className += ' ' + accuracyColor;
                accuracyMessage.innerHTML = `
                    <div class="flex items-start gap-2">
                        <i class="fas ${accuracyIcon} mt-0.5"></i>
                        <div class="flex-1">
                            <div class="font-semibold">${accuracyLevel} GPS Accuracy: ±${Math.round(accuracy)} meters</div>
                            <div class="text-xs opacity-90 mt-1">${accuracyAdvice}</div>
                        </div>
                    </div>
                `;
                
                locationButton.parentNode.appendChild(accuracyMessage);
            },
            function(error) {
                // ❌ ERROR - GPS acquisition failed
                locationButton.disabled = false;
                locationButton.classList.remove('opacity-75');
                locationButton.innerHTML = originalButtonHTML;
                
                let errorTitle = '';
                let errorMessage = '';
                let errorAdvice = '';
                
                console.error('❌ GPS Error:', error);
                
                switch(error.code) {
                    case error.PERMISSION_DENIED:
                        errorTitle = '🚫 Location Permission Denied';
                        errorMessage = 'You need to allow location access for GPS positioning.';
                        errorAdvice = '\n\n📱 How to fix:\n• Go to browser settings\n• Enable location permissions for this site\n• Refresh the page and try again';
                        break;
                    case error.POSITION_UNAVAILABLE:
                        errorTitle = '📡 GPS Signal Unavailable';
                        errorMessage = 'Cannot determine your position. GPS signal not found.';
                        errorAdvice = '\n\n🛰️ Try:\n• Move to an outdoor location\n• Ensure GPS is enabled on your device\n• Check if location services are turned on';
                        break;
                    case error.TIMEOUT:
                        errorTitle = '⏱️ GPS Timeout';
                        errorMessage = 'GPS signal acquisition took too long (15 seconds).';
                        errorAdvice = '\n\n🔄 Solutions:\n• Move to an area with clear sky view\n• Wait a moment and try again\n• Ensure GPS is enabled on your device';
                        break;
                    default:
                        errorTitle = '❌ Unknown GPS Error';
                        errorMessage = 'An unexpected error occurred while getting GPS position.';
                        errorAdvice = '\n\nPlease enter coordinates manually.';
                }
                
                alert(errorTitle + '\n\n' + errorMessage + errorAdvice);
            },
            options
        );
    }

    // Add button to get current location and toggle egg count field
    document.addEventListener('DOMContentLoaded', function() {
        const latitudeInput = document.getElementById('latitude');
        
        // Create GPS button
        const locationButton = document.createElement('button');
        locationButton.type = 'button';
        locationButton.id = 'gps-location-btn';
        locationButton.className = 'mt-2 px-4 py-2 bg-ocean-600 hover:bg-ocean-700 text-white text-sm rounded-lg cinzel-text transition-all duration-200 flex items-center gap-2';
        locationButton.innerHTML = '<i class="fas fa-satellite-dish"></i><span>Get GPS Coordinates</span>';
        locationButton.addEventListener('click', getCurrentLocation);
        
        // Add GPS info tip
        const gpsInfo = document.createElement('div');
        gpsInfo.className = 'mt-2 p-2 bg-blue-500/10 border border-blue-500/30 rounded-lg text-xs text-blue-300 cinzel-text';
        gpsInfo.innerHTML = `
            <div class="flex items-start gap-2">
                <i class="fas fa-info-circle mt-0.5"></i>
                <div>
                    <strong>GPS Tips for Best Accuracy:</strong>
                    <ul class="mt-1 space-y-0.5 ml-4 list-disc">
                        <li>Enable GPS/Location Services on your device</li>
                        <li>Move to an outdoor location with clear sky view</li>
                        <li>Wait 5-10 seconds for GPS to acquire satellites</li>
                        <li>Avoid tall buildings, dense forests, or indoor areas</li>
                    </ul>
                </div>
            </div>
        `;
        
        latitudeInput.parentNode.appendChild(locationButton);
        latitudeInput.parentNode.appendChild(gpsInfo);

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
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center mb-4">
                    <a href="<?php echo e(route('patroller.reports.show', $report)); ?>" class="text-ocean-400 hover:text-ocean-300 mr-4">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <h1 class="text-3xl font-bold text-white cinzel-heading">
                        <i class="fas fa-edit mr-3 text-ocean-400"></i>Edit Report
                    </h1>
                </div>
                <p class="text-gray-300 cinzel-text">Update your patrol report details.</p>
            </div>

            <!-- Error Messages -->
            <?php if($errors->any()): ?>
                <div class="mb-6 glass-morphism border-l-4 border-red-500 p-4 rounded">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-400"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-red-100 font-medium cinzel-text">Please correct the following errors:</h3>
                            <ul class="mt-2 text-red-200 text-sm list-disc list-inside cinzel-text">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Report Form -->
            <?php (
                $reportTypeOptions = collect(\App\Models\PatrolReport::getReportTypeOptions())
                    ->except(['hatchling', 'hazard'])
                    ->map(function ($label, $value) {
                        return $value === 'rescue'
                            ? 'Rescue / Threat & Hazard'
                            : $label;
                    })
                    ->toArray()
            ); ?>
            <form action="<?php echo e(route('patroller.reports.update', $report)); ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                
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
                                <?php $__currentLoopData = $reportTypeOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($value); ?>" <?php echo e(old('report_type', $report->report_type) == $value ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <!-- Priority -->
                        <div>
                            <label for="priority" class="block text-sm font-medium text-gray-300 mb-2 cinzel-text">Priority Level *</label>
                            <select id="priority" name="priority" required class="form-input w-full px-3 py-2 rounded-md cinzel-text">
                                <option value="">Select priority</option>
                                <option value="low" <?php echo e(old('priority', $report->priority) == 'low' ? 'selected' : ''); ?>>Low</option>
                                <option value="medium" <?php echo e(old('priority', $report->priority) == 'medium' ? 'selected' : ''); ?>>Medium</option>
                                <option value="high" <?php echo e(old('priority', $report->priority) == 'high' ? 'selected' : ''); ?>>High</option>
                                <option value="critical" <?php echo e(old('priority', $report->priority) == 'critical' ? 'selected' : ''); ?>>Critical</option>
                            </select>
                        </div>

                        <!-- Title -->
                        <div class="md:col-span-2">
                            <label for="title" class="block text-sm font-medium text-gray-300 mb-2 cinzel-text">Report Title *</label>
                            <input type="text" id="title" name="title" value="<?php echo e(old('title', $report->title)); ?>" required 
                                   class="form-input w-full px-3 py-2 rounded-md cinzel-text" 
                                   placeholder="Brief description of the report">
                        </div>

                        <!-- Location -->
                        <div class="md:col-span-2">
                            <label for="location" class="block text-sm font-medium text-gray-300 mb-2 cinzel-text">Location *</label>
                            <input type="text" id="location" name="location" value="<?php echo e(old('location', $report->location)); ?>" required 
                                   class="form-input w-full px-3 py-2 rounded-md cinzel-text" 
                                   placeholder="Specific location or area">
                        </div>

                        <!-- Coordinates -->
                        <div>
                            <label for="latitude" class="block text-sm font-medium text-gray-300 mb-2 cinzel-text">Latitude</label>
                            <input type="number" id="latitude" name="latitude" value="<?php echo e(old('latitude', $report->latitude)); ?>" 
                                   step="0.000001" class="form-input w-full px-3 py-2 rounded-md cinzel-text" 
                                   placeholder="e.g., 6.9363">
                        </div>

                        <div>
                            <label for="longitude" class="block text-sm font-medium text-gray-300 mb-2 cinzel-text">Longitude</label>
                            <input type="number" id="longitude" name="longitude" value="<?php echo e(old('longitude', $report->longitude)); ?>" 
                                   step="0.000001" class="form-input w-full px-3 py-2 rounded-md cinzel-text" 
                                   placeholder="e.g., 126.2742">
                        </div>

                        <!-- Incident Date/Time -->
                        <div class="md:col-span-2">
                            <label for="incident_datetime" class="block text-sm font-medium text-gray-300 mb-2 cinzel-text">Incident Date & Time</label>
                            <input type="datetime-local" id="incident_datetime" name="incident_datetime" 
                                   value="<?php echo e(old('incident_datetime', $report->incident_datetime ? $report->incident_datetime->format('Y-m-d\TH:i') : '')); ?>" 
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
                            <input type="number" id="turtle_count" name="turtle_count" value="<?php echo e(old('turtle_count', $report->turtle_count)); ?>" 
                                   min="0" class="form-input w-full px-3 py-2 rounded-md cinzel-text" 
                                   placeholder="0">
                        </div>

                        <!-- Nesting Egg Count (Nesting Only) -->
                        <div id="egg-count-wrapper" class="col-span-1 <?php echo e(old('report_type', $report->report_type) === 'nesting' ? '' : 'hidden'); ?>">
                            <label for="egg_count" class="block text-sm font-medium text-gray-300 mb-2 cinzel-text">Egg Count (Nesting Only)</label>
                            <input type="number" id="egg_count" name="egg_count" value="<?php echo e(old('egg_count', $report->egg_count)); ?>"
                                   min="0" class="form-input w-full px-3 py-2 rounded-md cinzel-text"
                                   placeholder="Approx. number of eggs">
                            <p class="text-xs text-gray-400 mt-1 cinzel-text">Visible only for nesting reports.</p>
                        </div>

                        <!-- Turtle Species -->
                        <div>
                            <label for="turtle_species" class="block text-sm font-medium text-gray-300 mb-2 cinzel-text">Species</label>
                            <select id="turtle_species" name="turtle_species" class="form-input w-full px-3 py-2 rounded-md cinzel-text">
                                <option value="">Select species</option>
                                <option value="olive_ridley" <?php echo e(old('turtle_species', $report->turtle_species) == 'olive_ridley' ? 'selected' : ''); ?>>Olive Ridley</option>
                                <option value="green_sea_turtle" <?php echo e(old('turtle_species', $report->turtle_species) == 'green_sea_turtle' ? 'selected' : ''); ?>>Green Sea Turtle</option>
                                <option value="hawksbill" <?php echo e(old('turtle_species', $report->turtle_species) == 'hawksbill' ? 'selected' : ''); ?>>Hawksbill</option>
                                <option value="leatherback" <?php echo e(old('turtle_species', $report->turtle_species) == 'leatherback' ? 'selected' : ''); ?>>Leatherback</option>
                                <option value="loggerhead" <?php echo e(old('turtle_species', $report->turtle_species) == 'loggerhead' ? 'selected' : ''); ?>>Loggerhead</option>
                            </select>
                        </div>

                        <!-- Turtle Gender -->
                        <div>
                            <label for="gender" class="block text-sm font-medium text-gray-300 mb-2 cinzel-text">Turtle Gender</label>
                            <select id="gender" name="gender" class="form-input w-full px-3 py-2 rounded-md cinzel-text">
                                <option value="" <?php echo e(old('gender', $report->gender) == '' ? 'selected' : ''); ?>>Select gender</option>
                                <option value="male" <?php echo e(old('gender', $report->gender) == 'male' ? 'selected' : ''); ?>>Male</option>
                                <option value="female" <?php echo e(old('gender', $report->gender) == 'female' ? 'selected' : ''); ?>>Female</option>
                                <option value="unknown" <?php echo e(old('gender', $report->gender) == 'unknown' ? 'selected' : ''); ?>>Unknown</option>
                            </select>
                        </div>

                        <!-- Turtle Condition -->
                        <div>
                            <label for="turtle_condition" class="block text-sm font-medium text-gray-300 mb-2 cinzel-text">Condition</label>
                            <select id="turtle_condition" name="turtle_condition" class="form-input w-full px-3 py-2 rounded-md cinzel-text">
                                <option value="">Select condition</option>
                                <option value="healthy" <?php echo e(old('turtle_condition', $report->turtle_condition) == 'healthy' ? 'selected' : ''); ?>>Healthy</option>
                                <option value="injured" <?php echo e(old('turtle_condition', $report->turtle_condition) == 'injured' ? 'selected' : ''); ?>>Injured</option>
                                <option value="dead" <?php echo e(old('turtle_condition', $report->turtle_condition) == 'dead' ? 'selected' : ''); ?>>Dead</option>
                                <option value="unknown" <?php echo e(old('turtle_condition', $report->turtle_condition) == 'unknown' ? 'selected' : ''); ?>>Unknown</option>
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
                                      placeholder="Provide a detailed description of what you observed or the incident that occurred"><?php echo e(old('description', $report->description)); ?></textarea>
                        </div>

                        <!-- Weather Conditions -->
                        <div>
                            <label for="weather_conditions" class="block text-sm font-medium text-gray-300 mb-2 cinzel-text">Weather Conditions</label>
                            <select id="weather_conditions" name="weather_conditions" class="form-input w-full px-3 py-2 rounded-md cinzel-text">
                            <option value="" <?php echo e(old('weather_conditions', $report->weather_conditions) == '' ? 'selected' : ''); ?>>Select weather condition</option>
                            <option value="Sunny" <?php echo e(old('weather_conditions', $report->weather_conditions) == 'Sunny' ? 'selected' : ''); ?>>☀️ Sunny</option>
                            <option value="Partly Cloudy" <?php echo e(old('weather_conditions', $report->weather_conditions) == 'Partly Cloudy' ? 'selected' : ''); ?>>⛅ Partly Cloudy</option>
                            <option value="Cloudy" <?php echo e(old('weather_conditions', $report->weather_conditions) == 'Cloudy' ? 'selected' : ''); ?>>☁️ Cloudy</option>
                            <option value="Rainy" <?php echo e(old('weather_conditions', $report->weather_conditions) == 'Rainy' ? 'selected' : ''); ?>>🌧️ Rainy</option>
                            <option value="Stormy" <?php echo e(old('weather_conditions', $report->weather_conditions) == 'Stormy' ? 'selected' : ''); ?>>⛈️ Stormy</option>
                            <option value="Windy" <?php echo e(old('weather_conditions', $report->weather_conditions) == 'Windy' ? 'selected' : ''); ?>>💨 Windy</option>
                            <option value="Foggy" <?php echo e(old('weather_conditions', $report->weather_conditions) == 'Foggy' ? 'selected' : ''); ?>>🌫️ Foggy</option>
                            <option value="Hazy" <?php echo e(old('weather_conditions', $report->weather_conditions) == 'Hazy' ? 'selected' : ''); ?>>😶‍🌫️ Hazy</option>
                            <option value="Clear Night" <?php echo e(old('weather_conditions', $report->weather_conditions) == 'Clear Night' ? 'selected' : ''); ?>>🌙 Clear Night</option>
                            <option value="Other" <?php echo e(old('weather_conditions', $report->weather_conditions) == 'Other' ? 'selected' : ''); ?>>Other (specify in notes)</option>
                        </select>

                    </div>
                </div>

                <!-- Images -->
                <div class="glass-dark rounded-xl p-6 border border-ocean-500/20">
                    <h3 class="text-lg font-semibold text-white mb-6 cinzel-subheading">
                        <i class="fas fa-images mr-2 text-ocean-400"></i>Images
                    </h3>
                    
                    <!-- Current Images -->
                    <?php if($report->images && count($report->images) > 0): ?>
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-300 mb-2 cinzel-text">Current Images</label>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <?php $__currentLoopData = $report->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="relative group">
                                        <img src="<?php echo e(asset('storage/' . $image)); ?>" alt="Report Image" class="w-full h-24 object-cover rounded-lg">
                                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all duration-300 rounded-lg flex items-center justify-center">
                                            <a href="<?php echo e(asset('storage/' . $image)); ?>" target="_blank" class="text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                                <i class="fas fa-expand"></i>
                                            </a>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Add New Images -->
                    <div>
                        <label for="images" class="block text-sm font-medium text-gray-300 mb-2 cinzel-text">Add New Images</label>
                        <input type="file" name="images[]" id="images" multiple accept="image/*" class="w-full bg-white/10 border border-ocean-500/30 rounded-lg px-3 py-2 text-white focus:ring-2 focus:ring-ocean-500 focus:border-transparent cinzel-text">
                        <p class="mt-1 text-sm text-gray-400 cinzel-text">You can select multiple images. Max 2MB per image.</p>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end space-x-4">
                    <a href="<?php echo e(route('patroller.reports.show', $report)); ?>" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-medium transition-colors cinzel-text">
                        Cancel
                    </a>
                    <button type="submit" class="bg-gradient-to-r from-ocean-500 to-ocean-600 hover:from-ocean-600 hover:to-ocean-700 text-white px-6 py-3 rounded-lg font-medium transition-all duration-300 transform hover:scale-105 shadow-lg cinzel-text">
                        <i class="fas fa-save mr-2"></i>Update Report
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Get Current Location functionality
document.getElementById('getCurrentLocation').addEventListener('click', function() {
    const button = this;
    const originalText = button.innerHTML;
    
    // Show loading state
    button.disabled = true;
    button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Getting location...';
    
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            document.getElementById('latitude').value = position.coords.latitude.toFixed(6);
            document.getElementById('longitude').value = position.coords.longitude.toFixed(6);
            
            // Show success feedback
            button.innerHTML = '<i class="fas fa-check mr-2"></i>Location obtained!';
            button.classList.add('bg-green-600');
            
            setTimeout(() => {
                button.innerHTML = originalText;
                button.disabled = false;
                button.classList.remove('bg-green-600');
            }, 2000);
        }, function(error) {
            let errorMessage = 'Error getting location';
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    errorMessage = 'Location permission denied. Please enable location access.';
                    break;
                case error.POSITION_UNAVAILABLE:
                    errorMessage = 'Location information unavailable.';
                    break;
                case error.TIMEOUT:
                    errorMessage = 'Location request timed out.';
                    break;
            }
            alert(errorMessage);
            button.innerHTML = originalText;
            button.disabled = false;
        });
    } else {
        alert('Geolocation is not supported by this browser.');
        button.innerHTML = originalText;
        button.disabled = false;
    }
});

// Toggle egg count field based on report type
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
    // Run on page load to set initial state
    toggleEggCountField();
}

// Form validation
const form = document.querySelector('form');
form.addEventListener('submit', function(e) {
    let isValid = true;
    let errorMessages = [];
    
    // Validate required fields
    const reportType = document.getElementById('report_type').value;
    const priority = document.getElementById('priority').value;
    const title = document.getElementById('title').value.trim();
    const description = document.getElementById('description').value.trim();
    const location = document.getElementById('location').value.trim();
    
    if (!reportType) {
        errorMessages.push('Please select a report type');
        isValid = false;
    }
    
    if (!priority) {
        errorMessages.push('Please select a priority level');
        isValid = false;
    }
    
    if (!title) {
        errorMessages.push('Please enter a report title');
        isValid = false;
    } else if (title.length > 255) {
        errorMessages.push('Report title must not exceed 255 characters');
        isValid = false;
    }
    
    if (!description) {
        errorMessages.push('Please enter a description');
        isValid = false;
    } else if (description.length < 10) {
        errorMessages.push('Description must be at least 10 characters long');
        isValid = false;
    }
    
    if (!location) {
        errorMessages.push('Please enter a location');
        isValid = false;
    }
    
    // Validate coordinates if provided
    const latitude = document.getElementById('latitude').value;
    const longitude = document.getElementById('longitude').value;
    
    if (latitude && (parseFloat(latitude) < -90 || parseFloat(latitude) > 90)) {
        errorMessages.push('Latitude must be between -90 and 90');
        isValid = false;
    }
    
    if (longitude && (parseFloat(longitude) < -180 || parseFloat(longitude) > 180)) {
        errorMessages.push('Longitude must be between -180 and 180');
        isValid = false;
    }
    
    // Validate turtle count if provided
    const turtleCount = document.getElementById('turtle_count').value;
    if (turtleCount && parseInt(turtleCount) < 0) {
        errorMessages.push('Turtle count cannot be negative');
        isValid = false;
    }
    
    // Validate egg count if provided and report type is nesting
    if (reportType === 'nesting' && eggCountInput) {
        const eggCount = eggCountInput.value;
        if (eggCount && parseInt(eggCount) < 0) {
            errorMessages.push('Egg count cannot be negative');
            isValid = false;
        }
    }
    
    // Validate incident datetime if provided
    const incidentDatetime = document.getElementById('incident_datetime').value;
    if (incidentDatetime) {
        const selectedDate = new Date(incidentDatetime);
        const now = new Date();
        if (selectedDate > now) {
            errorMessages.push('Incident date/time cannot be in the future');
            isValid = false;
        }
    }
    
    // Validate images if provided
    const imagesInput = document.getElementById('images');
    if (imagesInput.files.length > 0) {
        const maxSize = 2 * 1024 * 1024; // 2MB
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
        
        for (let i = 0; i < imagesInput.files.length; i++) {
            const file = imagesInput.files[i];
            
            if (!allowedTypes.includes(file.type)) {
                errorMessages.push(`Image ${i + 1}: Only JPEG, PNG, JPG, and GIF files are allowed`);
                isValid = false;
            }
            
            if (file.size > maxSize) {
                errorMessages.push(`Image ${i + 1}: File size must not exceed 2MB`);
                isValid = false;
            }
        }
    }
    
    if (!isValid) {
        e.preventDefault();
        alert('Please correct the following errors:\n\n' + errorMessages.join('\n'));
        
        // Scroll to top to show error messages
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
});

// Real-time character count for description
const descriptionField = document.getElementById('description');
const descriptionLabel = descriptionField.previousElementSibling;

descriptionField.addEventListener('input', function() {
    const length = this.value.length;
    const minLength = 10;
    
    // Remove existing counter if any
    const existingCounter = descriptionLabel.querySelector('.char-counter');
    if (existingCounter) {
        existingCounter.remove();
    }
    
    // Add character counter
    const counter = document.createElement('span');
    counter.className = 'char-counter text-xs ml-2';
    counter.style.color = length < minLength ? '#ef4444' : '#10b981';
    counter.textContent = `(${length} characters${length < minLength ? ', minimum ' + minLength : ''})`;
    descriptionLabel.appendChild(counter);
});

// Real-time character count for title
const titleField = document.getElementById('title');
const titleLabel = titleField.previousElementSibling;

titleField.addEventListener('input', function() {
    const length = this.value.length;
    const maxLength = 255;
    
    // Remove existing counter if any
    const existingCounter = titleLabel.querySelector('.char-counter');
    if (existingCounter) {
        existingCounter.remove();
    }
    
    // Add character counter
    const counter = document.createElement('span');
    counter.className = 'char-counter text-xs ml-2';
    counter.style.color = length > maxLength ? '#ef4444' : '#94a3b8';
    counter.textContent = `(${length}/${maxLength})`;
    titleLabel.appendChild(counter);
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.patroller', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Rayver\Desktop\my_app\resources\views/patroller/reports/edit.blade.php ENDPATH**/ ?>