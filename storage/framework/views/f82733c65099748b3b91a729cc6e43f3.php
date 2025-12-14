<?php $__env->startSection('title', 'Submit New Report'); ?>
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

    /* Map Modal Styles */
    #gps-map-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.8);
        z-index: 9999;
        backdrop-filter: blur(5px);
    }

    #gps-map-modal.active {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .map-modal-content {
        background: #1f2937;
        border-radius: 16px;
        padding: 24px;
        max-width: 800px;
        width: 90%;
        max-height: 90vh;
        overflow: auto;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        border: 1px solid rgba(16, 185, 129, 0.3);
    }

    #gps-map {
        width: 100%;
        height: 400px;
        border-radius: 12px;
        margin-top: 16px;
        border: 2px solid rgba(16, 185, 129, 0.3);
    }

    .leaflet-popup-content-wrapper {
        background: #1f2937;
        color: #f3f4f6;
        border: 1px solid rgba(16, 185, 129, 0.5);
    }

    .leaflet-popup-tip {
        background: #1f2937;
    }
</style>

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    // Get current location for coordinates with HIGH ACCURACY GPS
    let gpsMap = null;
    let gpsMarker = null;

    function showMapModal(lat, lng, accuracy) {
        const modal = document.getElementById('gps-map-modal');
        modal.classList.add('active');
        
        // Initialize map if not already done
        setTimeout(() => {
            if (!gpsMap) {
                gpsMap = L.map('gps-map').setView([lat, lng], 16);
                
                // Add OpenStreetMap tiles
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors',
                    maxZoom: 19
                }).addTo(gpsMap);
            } else {
                gpsMap.setView([lat, lng], 16);
            }
            
            // Remove old marker if exists
            if (gpsMarker) {
                gpsMap.removeLayer(gpsMarker);
            }
            
            // Add marker with custom green icon
            const greenIcon = L.icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });
            
            gpsMarker = L.marker([lat, lng], { icon: greenIcon }).addTo(gpsMap);
            
            // Add popup with coordinates
            gpsMarker.bindPopup(`
                <div style="font-family: 'Poppins', sans-serif; padding: 8px;">
                    <strong style="color: #10b981; font-size: 14px;">📍 GPS Location Acquired</strong><br>
                    <div style="margin-top: 8px; font-size: 12px;">
                        <strong>Latitude:</strong> ${lat}°<br>
                        <strong>Longitude:</strong> ${lng}°<br>
                        <strong>Accuracy:</strong> ±${accuracy.toFixed(1)}m
                    </div>
                </div>
            `).openPopup();
            
            // Add accuracy circle
            L.circle([lat, lng], {
                color: '#10b981',
                fillColor: '#10b981',
                fillOpacity: 0.1,
                radius: accuracy
            }).addTo(gpsMap);
            
            // Invalidate size to fix display issues
            setTimeout(() => gpsMap.invalidateSize(), 100);
        }, 100);
    }

    function closeMapModal() {
        const modal = document.getElementById('gps-map-modal');
        modal.classList.remove('active');
    }

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
                
                // Show map modal with the acquired location
                showMapModal(parseFloat(lat), parseFloat(lng), accuracy);
                
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
                let accuracyClass = '';
                let accuracyIcon = '';
                let accuracyAdvice = '';
                
                if (accuracy <= 5) {
                    accuracyLevel = 'Excellent';
                    accuracyClass = 'bg-green-50 border-green-300 text-green-800';
                    accuracyIcon = '🎯';
                    accuracyAdvice = 'Sub-5m accuracy! Perfect for precise mapping.';
                } else if (accuracy <= 10) {
                    accuracyLevel = 'Very Good';
                    accuracyClass = 'bg-blue-50 border-blue-300 text-blue-800';
                    accuracyIcon = '✅';
                    accuracyAdvice = 'Great accuracy for patrol reports.';
                } else if (accuracy <= 20) {
                    accuracyLevel = 'Good';
                    accuracyClass = 'bg-yellow-50 border-yellow-300 text-yellow-800';
                    accuracyIcon = '⚠️';
                    accuracyAdvice = 'Acceptable. For better accuracy, move to an open area.';
                } else if (accuracy <= 50) {
                    accuracyLevel = 'Fair';
                    accuracyClass = 'bg-orange-50 border-orange-300 text-orange-800';
                    accuracyIcon = '📍';
                    accuracyAdvice = 'Moderate accuracy. Consider retrying outdoors for better precision.';
                } else {
                    accuracyLevel = 'Low';
                    accuracyClass = 'bg-red-50 border-red-300 text-red-800';
                    accuracyIcon = '❌';
                    accuracyAdvice = 'Low accuracy detected. Please move outdoors with clear sky view and retry.';
                }
                
                accuracyMessage.className += ' ' + accuracyClass;
                accuracyMessage.innerHTML = `
                    <div class="flex items-start">
                        <span class="text-lg mr-2">${accuracyIcon}</span>
                        <div class="flex-1">
                            <div class="font-bold mb-1">GPS Accuracy: ${accuracyLevel} (±${accuracy.toFixed(1)}m)</div>
                            <div class="text-xs opacity-90">${accuracyAdvice}</div>
                        </div>
                    </div>
                `;
                
                latitudeInput.parentNode.appendChild(accuracyMessage);
                
                // Auto-remove accuracy message after 10 seconds
                setTimeout(() => {
                    if (accuracyMessage && accuracyMessage.parentNode) {
                        accuracyMessage.remove();
                    }
                }, 10000);
            },
            function(error) {
                // ❌ ERROR - GPS acquisition failed
                locationButton.disabled = false;
                locationButton.classList.remove('opacity-75');
                locationButton.innerHTML = originalButtonHTML;
                
                let errorMessage = '';
                switch(error.code) {
                    case error.PERMISSION_DENIED:
                        errorMessage = "❌ GPS Permission Denied\n\nPlease enable location services in your browser settings:\n\n1. Click the lock icon in the address bar\n2. Allow location access for this site\n3. Refresh the page and try again";
                        break;
                    case error.POSITION_UNAVAILABLE:
                        errorMessage = "❌ GPS Position Unavailable\n\nCannot determine your location. Please ensure:\n\n• You are outdoors or near a window\n• GPS is enabled on your device\n• Location services are allowed for this website\n• Your device has GPS capability";
                        break;
                    case error.TIMEOUT:
                        errorMessage = "⏱️ GPS Timeout\n\nGPS signal acquisition took too long.\n\nTips for better GPS signal:\n• Move to an area with clear sky view\n• Ensure GPS/Location is enabled on your device\n• Wait a moment for GPS to initialize, then try again\n• If indoors, move closer to a window";
                        break;
                    default:
                        errorMessage = "❌ GPS Error\n\nAn unknown error occurred while getting your location.\n\nPlease try again or enter coordinates manually.";
                }
                
                alert(errorMessage);
                console.error('GPS Error:', error);
            },
            options
        );
    }

    // Add button to get current location
    document.addEventListener('DOMContentLoaded', function() {
        const latitudeInput = document.getElementById('latitude');
        
        // Create GPS button
        const locationButton = document.createElement('button');
        locationButton.type = 'button';
        locationButton.id = 'gps-location-btn';
        locationButton.className = 'mt-2 px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-sm rounded-lg cinzel-text transition-all duration-200 flex items-center gap-2';
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
                    <a href="<?php echo e(route('patroller.dashboard')); ?>" class="text-green-400 hover:text-green-300 mr-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                    <h1 class="text-3xl font-bold text-white" style="font-family: 'Poppins', sans-serif;">
                        <svg class="w-8 h-8 inline-block mr-3 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>Submit New Report
                    </h1>
                </div>
                <p class="text-gray-300" style="font-family: 'Poppins', sans-serif;">Fill out the form below to submit a new patrol report.</p>
            </div>

            <!-- Error Messages -->
            <?php if($errors->any()): ?>
                <div class="mb-6 glass-morphism border-l-4 border-red-500 p-4 rounded">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-red-100 font-medium" style="font-family: 'Poppins', sans-serif;">Please correct the following errors:</h3>
                            <ul class="mt-2 text-red-200 text-sm list-disc list-inside" style="font-family: 'Poppins', sans-serif;">
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
            <form action="<?php echo e(route('patroller.reports.store')); ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
                <?php echo csrf_field(); ?>
                
                <div class="glass-morphism rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-white mb-6" style="font-family: 'Poppins', sans-serif;">
                        <svg class="w-5 h-5 inline-block mr-2 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>Basic Information
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Report Type -->
                        <div>
                            <label for="report_type" class="block text-sm font-medium text-gray-300 mb-2" style="font-family: 'Poppins', sans-serif;">Report Type *</label>
                            <select id="report_type" name="report_type" required class="form-input w-full px-3 py-2 rounded-md" style="font-family: 'Poppins', sans-serif;">
                                <option value="">Select report type</option>
                                <?php $__currentLoopData = $reportTypeOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($value); ?>" <?php echo e(old('report_type') == $value ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <!-- Priority -->
                        <div>
                            <label for="priority" class="block text-sm font-medium text-gray-300 mb-2" style="font-family: 'Poppins', sans-serif;">Priority Level *</label>
                            <select id="priority" name="priority" required class="form-input w-full px-3 py-2 rounded-md" style="font-family: 'Poppins', sans-serif;">
                                <option value="">Select priority</option>
                                <option value="low" <?php echo e(old('priority') == 'low' ? 'selected' : ''); ?>>Low</option>
                                <option value="medium" <?php echo e(old('priority') == 'medium' ? 'selected' : ''); ?>>Medium</option>
                                <option value="high" <?php echo e(old('priority') == 'high' ? 'selected' : ''); ?>>High</option>
                                <option value="critical" <?php echo e(old('priority') == 'critical' ? 'selected' : ''); ?>>Critical</option>
                            </select>
                        </div>

                        <!-- Title -->
                        <div class="md:col-span-2">
                            <label for="title" class="block text-sm font-medium text-gray-300 mb-2" style="font-family: 'Poppins', sans-serif;">Report Title *</label>
                            <input type="text" id="title" name="title" value="<?php echo e(old('title')); ?>" required 
                                   class="form-input w-full px-3 py-2 rounded-md" style="font-family: 'Poppins', sans-serif;" 
                                   placeholder="Brief description of the report">
                        </div>

                        <!-- Location -->
                        <div class="md:col-span-2">
                            <label for="location" class="block text-sm font-medium text-gray-300 mb-2" style="font-family: 'Poppins', sans-serif;">Location *</label>
                            <input type="text" id="location" name="location" value="<?php echo e(old('location')); ?>" required 
                                   class="form-input w-full px-3 py-2 rounded-md" style="font-family: 'Poppins', sans-serif;" 
                                   placeholder="Specific location or area">
                        </div>

                        <!-- Coordinates -->
                        <div>
                            <label for="latitude" class="block text-sm font-medium text-gray-300 mb-2" style="font-family: 'Poppins', sans-serif;">Latitude</label>
                            <input type="number" id="latitude" name="latitude" value="<?php echo e(old('latitude')); ?>" 
                                   step="0.000001" class="form-input w-full px-3 py-2 rounded-md" style="font-family: 'Poppins', sans-serif;" 
                                   placeholder="e.g., 6.9363">
                        </div>

                        <div>
                            <label for="longitude" class="block text-sm font-medium text-gray-300 mb-2" style="font-family: 'Poppins', sans-serif;">Longitude</label>
                            <input type="number" id="longitude" name="longitude" value="<?php echo e(old('longitude')); ?>" 
                                   step="0.000001" class="form-input w-full px-3 py-2 rounded-md" style="font-family: 'Poppins', sans-serif;" 
                                   placeholder="e.g., 126.2742">
                        </div>

                        <!-- Incident Date/Time -->
                        <div class="md:col-span-2">
                            <label for="incident_datetime" class="block text-sm font-medium text-gray-300 mb-2" style="font-family: 'Poppins', sans-serif;">Incident Date & Time</label>
                            <input type="datetime-local" id="incident_datetime" name="incident_datetime" 
                                   value="<?php echo e(old('incident_datetime')); ?>" 
                                   class="form-input w-full px-3 py-2 rounded-md" style="font-family: 'Poppins', sans-serif;">
                        </div>
                    </div>
                </div>

                <!-- Turtle Information (if applicable) -->
                <div class="glass-morphism rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-white mb-6" style="font-family: 'Poppins', sans-serif;">
                        <svg class="w-5 h-5 inline-block mr-2 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                        </svg>Turtle Information
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Turtle Count -->
                        <div>
                            <label for="turtle_count" class="block text-sm font-medium text-gray-300 mb-2" style="font-family: 'Poppins', sans-serif;">Number of Turtles</label>
                            <input type="number" id="turtle_count" name="turtle_count" value="<?php echo e(old('turtle_count')); ?>" 
                                   min="0" class="form-input w-full px-3 py-2 rounded-md" style="font-family: 'Poppins', sans-serif;" 
                                   placeholder="0">
                        </div>

                        <!-- Nesting Egg Count (Nesting Only) -->
                        <div id="egg-count-wrapper" class="col-span-1 <?php echo e(old('report_type') === 'nesting' ? '' : 'hidden'); ?>">
                            <label for="egg_count" class="block text-sm font-medium text-gray-300 mb-2" style="font-family: 'Poppins', sans-serif;">Egg Count (Nesting Only)</label>
                            <input type="number" id="egg_count" name="egg_count" value="<?php echo e(old('egg_count')); ?>"
                                   min="0" class="form-input w-full px-3 py-2 rounded-md" style="font-family: 'Poppins', sans-serif;"
                                   placeholder="Approx. number of eggs">
                            <p class="text-xs text-gray-400 mt-1" style="font-family: 'Poppins', sans-serif;">Visible only for nesting reports.</p>
                        </div>

                        <!-- Turtle Species -->
                        <div>
                            <label for="turtle_species" class="block text-sm font-medium text-gray-300 mb-2" style="font-family: 'Poppins', sans-serif;">Species</label>
                            <select id="turtle_species" name="turtle_species" class="form-input w-full px-3 py-2 rounded-md" style="font-family: 'Poppins', sans-serif;">
                                <option value="">Select species</option>
                                <option value="olive_ridley" <?php echo e(old('turtle_species') == 'olive_ridley' ? 'selected' : ''); ?>>Olive Ridley</option>
                                <option value="green_sea_turtle" <?php echo e(old('turtle_species') == 'green_sea_turtle' ? 'selected' : ''); ?>>Green Sea Turtle</option>
                                <option value="hawksbill" <?php echo e(old('turtle_species') == 'hawksbill' ? 'selected' : ''); ?>>Hawksbill</option>
                                <option value="leatherback" <?php echo e(old('turtle_species') == 'leatherback' ? 'selected' : ''); ?>>Leatherback</option>
                                <option value="loggerhead" <?php echo e(old('turtle_species') == 'loggerhead' ? 'selected' : ''); ?>>Loggerhead</option>
                            </select>
                        </div>

                        <!-- Turtle Gender -->
                        <div>
                            <label for="gender" class="block text-sm font-medium text-gray-300 mb-2" style="font-family: 'Poppins', sans-serif;">Turtle Gender</label>
                            <select id="gender" name="gender" class="form-input w-full px-3 py-2 rounded-md" style="font-family: 'Poppins', sans-serif;">
                                <option value="" <?php echo e(old('gender') == '' ? 'selected' : ''); ?>>Select gender</option>
                                <option value="male" <?php echo e(old('gender') == 'male' ? 'selected' : ''); ?>>Male</option>
                                <option value="female" <?php echo e(old('gender') == 'female' ? 'selected' : ''); ?>>Female</option>
                                <option value="unknown" <?php echo e(old('gender') == 'unknown' ? 'selected' : ''); ?>>Unknown</option>
                            </select>
                        </div>

                        <!-- Turtle Condition -->
                        <div>
                            <label for="turtle_condition" class="block text-sm font-medium text-gray-300 mb-2" style="font-family: 'Poppins', sans-serif;">Condition</label>
                            <select id="turtle_condition" name="turtle_condition" class="form-input w-full px-3 py-2 rounded-md" style="font-family: 'Poppins', sans-serif;">
                                <option value="">Select condition</option>
                                <option value="healthy" <?php echo e(old('turtle_condition') == 'healthy' ? 'selected' : ''); ?>>Healthy</option>
                                <option value="injured" <?php echo e(old('turtle_condition') == 'injured' ? 'selected' : ''); ?>>Injured</option>
                                <option value="dead" <?php echo e(old('turtle_condition') == 'dead' ? 'selected' : ''); ?>>Dead</option>
                                <option value="unknown" <?php echo e(old('turtle_condition') == 'unknown' ? 'selected' : ''); ?>>Unknown</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Detailed Description -->
                <div class="glass-morphism rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-white mb-6" style="font-family: 'Poppins', sans-serif;">
                        <svg class="w-5 h-5 inline-block mr-2 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                        </svg>Detailed Information
                    </h3>
                    
                    <div class="space-y-6">
                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-300 mb-2" style="font-family: 'Poppins', sans-serif;">Detailed Description *</label>
                            <textarea id="description" name="description" rows="4" required 
                                      class="form-input w-full px-3 py-2 rounded-md" style="font-family: 'Poppins', sans-serif;" 
                                      placeholder="Provide a detailed description of what you observed or the incident that occurred"><?php echo e(old('description')); ?></textarea>
                        </div>

                        <!-- Weather Conditions -->
                        <div>
                            <label for="weather_conditions" class="block text-sm font-medium text-gray-300 mb-2" style="font-family: 'Poppins', sans-serif;">Weather Conditions</label>
                            <select id="weather_conditions" name="weather_conditions" class="form-input w-full px-3 py-2 rounded-md" style="font-family: 'Poppins', sans-serif;">
                                <option value="" <?php echo e(old('weather_conditions') == '' ? 'selected' : ''); ?>>Select weather condition</option>
                                <option value="Sunny" <?php echo e(old('weather_conditions') == 'Sunny' ? 'selected' : ''); ?>>☀️ Sunny</option>
                                <option value="Partly Cloudy" <?php echo e(old('weather_conditions') == 'Partly Cloudy' ? 'selected' : ''); ?>>⛅ Partly Cloudy</option>
                                <option value="Cloudy" <?php echo e(old('weather_conditions') == 'Cloudy' ? 'selected' : ''); ?>>☁️ Cloudy</option>
                                <option value="Rainy" <?php echo e(old('weather_conditions') == 'Rainy' ? 'selected' : ''); ?>>🌧️ Rainy</option>
                                <option value="Stormy" <?php echo e(old('weather_conditions') == 'Stormy' ? 'selected' : ''); ?>>⛈️ Stormy</option>
                                <option value="Windy" <?php echo e(old('weather_conditions') == 'Windy' ? 'selected' : ''); ?>>💨 Windy</option>
                                <option value="Foggy" <?php echo e(old('weather_conditions') == 'Foggy' ? 'selected' : ''); ?>>🌫️ Foggy</option>
                                <option value="Hazy" <?php echo e(old('weather_conditions') == 'Hazy' ? 'selected' : ''); ?>>😶‍🌫️ Hazy</option>
                                <option value="Clear Night" <?php echo e(old('weather_conditions') == 'Clear Night' ? 'selected' : ''); ?>>🌙 Clear Night</option>
                                <option value="Other" <?php echo e(old('weather_conditions') == 'Other' ? 'selected' : ''); ?>>Other (specify in notes)</option>
                            </select>
                        </div>

                        <!-- Requires Follow-up -->

                    </div>
                </div>

                <!-- Images -->
                <div class="glass-morphism rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-white mb-6" style="font-family: 'Poppins', sans-serif;">
                        <svg class="w-5 h-5 inline-block mr-2 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                        </svg>Evidence Photos
                    </h3>
                    
                    <div>
                        <label for="images" class="block text-sm font-medium text-gray-300 mb-2" style="font-family: 'Poppins', sans-serif;">Upload Photos</label>
                        <input type="file" id="images" name="images[]" multiple accept="image/*" 
                               class="form-input w-full px-3 py-2 rounded-md" style="font-family: 'Poppins', sans-serif;">
                        <p class="mt-2 text-sm text-gray-400" style="font-family: 'Poppins', sans-serif;">You can upload multiple images. Supported formats: JPEG, PNG, JPG, GIF (max 2MB each)</p>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end space-x-4">
                    <a href="<?php echo e(route('patroller.dashboard')); ?>" 
                       class="px-6 py-3 border border-gray-300 rounded-md text-gray-300 hover:text-white hover:border-white transition duration-300" style="font-family: 'Poppins', sans-serif;">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold rounded-md transition duration-300" style="font-family: 'Poppins', sans-serif;">
                        <svg class="w-5 h-5 inline-block mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"/>
                        </svg>Submit Report
                    </button>
                </div>
            </form>

            <!-- GPS Map Modal -->
            <div id="gps-map-modal">
                <div class="map-modal-content">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-bold text-white flex items-center gap-2" style="font-family: 'Poppins', sans-serif;">
                            <i class="fas fa-map-marked-alt text-green-400"></i>
                            GPS Location Preview
                        </h3>
                        <button onclick="closeMapModal()" class="text-gray-400 hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    <p class="text-gray-300 text-sm mb-2" style="font-family: 'Poppins', sans-serif;">
                        <i class="fas fa-info-circle text-blue-400"></i>
                        This map shows your acquired GPS coordinates. The green marker indicates your exact location, and the circle shows the accuracy radius.
                    </p>
                    <div id="gps-map"></div>
                    <div class="mt-4 flex justify-end">
                        <button onclick="closeMapModal()" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors" style="font-family: 'Poppins', sans-serif;">
                            <i class="fas fa-check mr-2"></i>Confirm Location
                        </button>
                    </div>
                </div>
            </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.patroller', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Rayver\Desktop\my_app\resources\views/patroller/reports/create.blade.php ENDPATH**/ ?>