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

    /* Map Modal Styles - FULLSCREEN */
    #gps-map-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.95);
        z-index: 100000;
        backdrop-filter: blur(5px);
    }

    #gps-map-modal.active {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
    }

    .map-modal-content {
        background: #1f2937;
        border-radius: 0;
        padding: 24px;
        width: 100%;
        height: 100%;
        max-width: 100%;
        max-height: 100%;
        overflow: hidden;
        box-shadow: none;
        border: none;
        display: flex;
        flex-direction: column;
    }

    #gps-map {
        width: 100%;
        flex: 1;
        border-radius: 12px;
        margin-top: 16px;
        border: 2px solid rgba(20, 184, 166, 0.3);
        min-height: 0;
    }

    .leaflet-popup-content-wrapper {
        background: #1f2937;
        color: #f3f4f6;
        border: 1px solid rgba(20, 184, 166, 0.5);
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
    // Interactive GPS Map with Click-to-Mark functionality
    let gpsMap = null;
    let gpsMarker = null;
    let accuracyCircle = null;

    // Custom marker icon
    const greenIcon = L.icon({
        iconUrl: "<?php echo e(asset('img/marker.png')); ?>",
        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
        iconSize: [80, 80], 
        iconAnchor: [40, 80], // Bottom center
        popupAnchor: [0, -80],
        shadowSize: [41, 41]
    });

    // Simplified marker update for manual selection
    function updateMarkerPosition(lat, lng, accuracy = 10, source = 'manual') {
        const latitudeInput = document.getElementById('latitude');
        const longitudeInput = document.getElementById('longitude');
        const btn = document.getElementById('map-trigger-btn');
        
        // Update input fields
        latitudeInput.value = lat.toFixed(6);
        longitudeInput.value = lng.toFixed(6);
        
        // Update Button Text to 'View Map Location'
        if (btn) {
           btn.innerHTML = '<i class="fas fa-map-marked-alt text-lg"></i><span>View Map Location</span>';
        }

        const cancelBtn = document.getElementById('cancel-location-btn');
        if (cancelBtn) {
            cancelBtn.classList.remove('hidden');
        }

        // Remove old marker and circle if exists
        if (gpsMarker) {
            gpsMap.removeLayer(gpsMarker);
        }
        if (accuracyCircle) {
            gpsMap.removeLayer(accuracyCircle);
        }
        
        // Add new marker
        gpsMarker = L.marker([lat, lng], { 
            icon: greenIcon,
            draggable: true  // Make marker draggable
        }).addTo(gpsMap);
        
        // Update coordinates when marker is dragged
        gpsMarker.on('dragend', function(e) {
            const position = e.target.getLatLng();
            updateMarkerPosition(position.lat, position.lng, 10, 'drag');
        });
        
        // Add popup with coordinates
        gpsMarker.bindPopup(`
            <div style="font-family: 'Poppins', sans-serif; padding: 8px;">
                <strong style="color: #14b8a6; font-size: 14px;">📍 Location Selected</strong><br>
                <div style="margin-top: 8px; font-size: 12px;">
                    <strong>Latitude:</strong> ${lat.toFixed(6)}°<br>
                    <strong>Longitude:</strong> ${lng.toFixed(6)}°<br>
                    <em>Drag marker to adjust location</em>
                </div>
            </div>
        `).openPopup();
        
        // Add accuracy circle (fixed size for manual visual)
        accuracyCircle = L.circle([lat, lng], {
            color: '#14b8a6',
            fillColor: '#14b8a6',
            fillOpacity: 0.1,
            radius: 20 // Fixed radius for visual consistency
        }).addTo(gpsMap);
    }
    
    // Check initial state
    function initMapButtonState() {
        const latitudeInput = document.getElementById('latitude');
        const longitudeInput = document.getElementById('longitude');
        const btn = document.getElementById('map-trigger-btn');
        const cancelBtn = document.getElementById('cancel-location-btn');
        
        if (latitudeInput && longitudeInput && btn && latitudeInput.value && longitudeInput.value) {
             btn.innerHTML = '<i class="fas fa-map-marked-alt text-lg"></i><span>View Map Location</span>';
             if (cancelBtn) cancelBtn.classList.remove('hidden');
        }
    }

    // New Clear Location function
    function clearLocation() {
        const latitudeInput = document.getElementById('latitude');
        const longitudeInput = document.getElementById('longitude');
        const btn = document.getElementById('map-trigger-btn');
        const cancelBtn = document.getElementById('cancel-location-btn');
        
        latitudeInput.value = '';
        longitudeInput.value = '';
        
        if (btn) {
            btn.innerHTML = '<i class="fas fa-map-marker-alt text-lg"></i><span>Get Location on Map</span>';
        }
        
        if (cancelBtn) {
            cancelBtn.classList.add('hidden');
        }
        
        // Reset map markers if they exist
        if (gpsMarker && gpsMap) {
            gpsMap.removeLayer(gpsMarker);
            gpsMarker = null;
        }
        if (accuracyCircle && gpsMap) {
            gpsMap.removeLayer(accuracyCircle);
            accuracyCircle = null;
        }
    }

    function showMapModal(lat, lng, accuracy = 10, source = 'manual') {
        const modal = document.getElementById('gps-map-modal');
        modal.classList.add('active');
        
        // Initialize map if not already done
        setTimeout(() => {
            if (!gpsMap) {
                // Default to Dahican Beach area if no coordinates provided
                const defaultLat = lat || 6.9363;
                const defaultLng = lng || 126.2742;
                
                gpsMap = L.map('gps-map').setView([defaultLat, defaultLng], 17);
                
                // Define Google Map Layers
                
                // Google Streets (Standard Map)
                const googleStreets = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                    maxZoom: 20,
                    subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
                    attribution: '© Google Maps'
                });

                // Google Hybrid (Satellite + Labels) - PREFERRED
                const googleHybrid = L.tileLayer('http://{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
                    maxZoom: 20,
                    subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
                    attribution: '© Google Maps'
                });

                // Add default layer (Google Hybrid)
                googleHybrid.addTo(gpsMap);

                // Add Layer Control
                const baseMaps = {
                    "Google Satellite": googleHybrid,
                    "Google Streets": googleStreets
                };
                
                L.control.layers(baseMaps, null, { position: 'topright' }).addTo(gpsMap);
                
                // Add click event to map - users can click to set coordinates
                gpsMap.on('click', function(e) {
                    updateMarkerPosition(e.latlng.lat, e.latlng.lng, 10, 'click');
                });
            } else {
                gpsMap.setView([lat, lng], 17);
            }
            
            // Add or update marker
            if (lat && lng) {
                updateMarkerPosition(lat, lng, accuracy, source);
            }
            
            // Invalidate size to fix display issues
            setTimeout(() => {
                gpsMap.invalidateSize();
                if (lat && lng) {
                    gpsMap.panTo([lat, lng]);
                }
            }, 100);
        }, 100);
    }

    function closeMapModal() {
        const modal = document.getElementById('gps-map-modal');
        modal.classList.remove('active');
        
        // Remove any lingering overlays/notifications
        const overlays = document.querySelectorAll('#gps-loading-overlay, [style*="position: absolute"][style*="z-index: 10001"]');
        overlays.forEach(overlay => overlay.remove());
    }
    
    // Close modal with ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('gps-map-modal');
            if (modal && modal.classList.contains('active')) {
                closeMapModal();
            }
        }
    });

    // Helper for high accuracy location
    function getHighAccuracyLocation(onSuccess, onError) {
        if (!navigator.geolocation) {
            onError(new Error("Geolocation not supported"));
            return;
        }

        const options = {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 0
        };

        // Try getting a quick fix first, but fallback to watch if needed? 
        // Actually, just going straight for watchPosition is often better for "high accuracy" on moving/mobile devices
        // because it allows the GPS radio to warm up. 
        // But for a simple button click "get location", we'll do a robust single-attempt structure.
        
        let positionFound = false;
        
        // We'll use getCurrentPosition but with a longer timeout and high accuracy
        navigator.geolocation.getCurrentPosition(
            (pos) => {
                positionFound = true;
                onSuccess(pos);
            },
            (err) => {
                if (!positionFound) onError(err);
            },
            options
        );
    }

    // Open map manually for coordinate selection - FOCUSED ON USER LOCATION OR DAHICAN
    function openMapManually() {
        const latitudeInput = document.getElementById('latitude');
        const longitudeInput = document.getElementById('longitude');
        const btn = document.getElementById('map-trigger-btn');
        
        // Default Dahican coordinates
        const DAHICAN_LAT = 6.9363;
        const DAHICAN_LNG = 126.2742;

        // Check if values exist
        if (latitudeInput.value && longitudeInput.value) {
            // "Viewer Mode" - Just show the existing location
            showMapModal(parseFloat(latitudeInput.value), parseFloat(longitudeInput.value), 10, 'manual');
            return;
        }

        // "Locator Mode" - No location set, so we Find User First
        // Step 1: Get the location (with UI feedback)
        
        const originalContent = btn.innerHTML;
        btn.disabled = true;
        btn.classList.add('opacity-75', 'cursor-not-allowed');
        btn.innerHTML = '<i class="fas fa-circle-notch fa-spin text-lg"></i><span>Locating (High Accuracy)...</span>';

        // Use a smarter geolocation call
        const locationTimeout = setTimeout(() => {
            // If it takes too long (>10s), we might want to fallback or just let it keep trying?
            // For now, relies on the geolocation API's own timeout (10s)
        }, 10000);

        navigator.geolocation.getCurrentPosition(
            (position) => {
                clearTimeout(locationTimeout);
                
                // Success
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                const accuracy = position.coords.accuracy;
                
                // Check if accuracy is acceptable (e.g. < 50 meters)
                // If not, we could warn, but for now we just show it.
                
                resetButton();
                showMapModal(lat, lng, accuracy, 'gps');
                
                // Show a toast or small message if accuracy is poor (>100m)
                if (accuracy > 100) {
                   // Optional: Add warning
                   console.log("Location accuracy is poor: " + accuracy + "m");
                }
            },
            (error) => {
                clearTimeout(locationTimeout);
                // Error / Fallback
                console.error("Location access denied or failed", error);
                resetButton();
                
                // Fallback to Dahican but maybe show an alert?
                 alert("Could not get precise location. Opening map at default location.");
                showMapModal(DAHICAN_LAT, DAHICAN_LNG, 10, 'manual');
            },
            {
                enableHighAccuracy: true,
                timeout: 15000,    // Increased timeout to 15s for better chance of GPS lock
                maximumAge: 0      // Force fresh reading
            }
        );

        function resetButton() {
            btn.innerHTML = originalContent;
            btn.disabled = false;
            btn.classList.remove('opacity-75', 'cursor-not-allowed');
        }
    }

    // Geolocation function
    function locateUser() {
        if (!navigator.geolocation) {
            alert("Geolocation is not supported by your browser");
            return;
        }

        const btn = document.getElementById('locate-me-btn');
        const originalContent = btn ? btn.innerHTML : '';
        
        if (btn) {
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Locating...';
            btn.disabled = true;
            btn.classList.add('opacity-75', 'cursor-not-allowed');
        }

        navigator.geolocation.getCurrentPosition(
            (position) => {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                const accuracy = position.coords.accuracy;

                updateMarkerPosition(lat, lng, accuracy, 'gps');
                
                if (gpsMap) {
                    gpsMap.setView([lat, lng], 18);
                    
                    // Add a accuracy circle that fades out
                    const paramCircle = L.circle([lat, lng], {
                        radius: accuracy,
                        color: '#14b8a6',
                        fillColor: '#14b8a6',
                        fillOpacity: 0.2,
                        weight: 1
                    }).addTo(gpsMap);
                    
                    // Zoom to the accuracy circle bounds
                    // gpsMap.fitBounds(paramCircle.getBounds());
                }
                
                if (btn) {
                    btn.innerHTML = originalContent;
                    btn.disabled = false;
                    btn.classList.remove('opacity-75', 'cursor-not-allowed');
                }
            },
            (error) => {
                console.error("Error getting location", error);
                if (btn) {
                    const originalClass = btn.className;
                    btn.innerHTML = '<i class="fas fa-exclamation-circle mr-2"></i>Failed';
                    btn.classList.remove('from-blue-500', 'to-blue-600');
                    btn.classList.add('bg-red-500');
                    
                    setTimeout(() => {
                        btn.innerHTML = originalContent;
                        btn.disabled = false;
                        btn.className = originalClass; // Restore original classes
                        btn.classList.remove('opacity-75', 'cursor-not-allowed');
                    }, 3000);
                }
            },
            {
                enableHighAccuracy: true,
                timeout: 15000,
                maximumAge: 0
            }
        );
    }

    // Character counters
    function initCharCounters() {
        const descriptionField = document.getElementById('description');
        if (descriptionField) {
            const descriptionLabel = descriptionField.previousElementSibling;
            
            const updateDescCounter = function() {
                const length = this.value.length;
                const minLength = 10;
                const existingCounter = descriptionLabel.querySelector('.char-counter');
                if (existingCounter) existingCounter.remove();
                
                const counter = document.createElement('span');
                counter.className = 'char-counter text-xs ml-2';
                counter.style.color = length < minLength ? '#ef4444' : '#14b8a6';
                counter.textContent = `(${length} characters${length < minLength ? ', minimum ' + minLength : ''})`;
                descriptionLabel.appendChild(counter);
            };
            descriptionField.addEventListener('input', updateDescCounter);
            updateDescCounter.call(descriptionField);
        }

        const titleField = document.getElementById('title');
        if (titleField) {
            const titleLabel = titleField.previousElementSibling;
            
            const updateTitleCounter = function() {
                const length = this.value.length;
                const maxLength = 255;
                const existingCounter = titleLabel.querySelector('.char-counter');
                if (existingCounter) existingCounter.remove();
                
                const counter = document.createElement('span');
                counter.className = 'char-counter text-xs ml-2';
                counter.style.color = length > maxLength ? '#ef4444' : '#94a3b8';
                counter.textContent = `(${length}/${maxLength})`;
                titleLabel.appendChild(counter);
            };
            titleField.addEventListener('input', updateTitleCounter);
            updateTitleCounter.call(titleField);
        }
    }

    // Initialize dynamic behaviors
    function initGPSUI() {
        const reportTypeSelect = document.getElementById('report_type');
        if (reportTypeSelect) {
            reportTypeSelect.onchange = toggleEggCountField;
            toggleEggCountField();
        }

        initCharCounters();
        initMapButtonState();
    }

    // Toggle egg count field based on report type
    function toggleEggCountField() {
        const reportTypeSelect = document.getElementById('report_type');
        const eggCountWrapper = document.getElementById('egg-count-wrapper');
        const eggCountInput = document.getElementById('egg_count');

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

    // Attach listeners on both standard and Turbo loads
    document.addEventListener('DOMContentLoaded', initGPSUI);
    document.addEventListener('turbo:load', initGPSUI);
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center mb-4">
                    <a href="<?php echo e(route('patroller.dashboard')); ?>" class="text-ocean-400 hover:text-ocean-300 mr-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                    <h1 class="text-3xl font-bold text-white" style="font-family: 'Poppins', sans-serif;">
                        <svg class="w-8 h-8 inline-block mr-3 text-ocean-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                        <svg class="w-5 h-5 inline-block mr-2 text-ocean-400" fill="currentColor" viewBox="0 0 20 20">
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
                                   step="0.000001" class="form-input w-full px-3 py-2 rounded-md bg-gray-800/50 cursor-not-allowed" style="font-family: 'Poppins', sans-serif;" 
                                   placeholder="e.g., 6.9363" readonly>
                        </div>

                        <div>
                            <label for="longitude" class="block text-sm font-medium text-gray-300 mb-2" style="font-family: 'Poppins', sans-serif;">Longitude</label>
                            <input type="number" id="longitude" name="longitude" value="<?php echo e(old('longitude')); ?>" 
                                   step="0.000001" class="form-input w-full px-3 py-2 rounded-md bg-gray-800/50 cursor-not-allowed" style="font-family: 'Poppins', sans-serif;" 
                                   placeholder="e.g., 126.2742" readonly>
                        </div>

                        <!-- Location Selector - Clean & Professional -->
                        <div class="md:col-span-2 space-y-3">
                            <button id="map-trigger-btn" type="button" onclick="openMapManually()" class="w-full px-6 py-3 bg-gradient-to-r from-ocean-500 to-ocean-600 hover:from-ocean-600 hover:to-ocean-700 text-white rounded-lg transition-all duration-200 flex items-center justify-center gap-2 shadow-lg hover:shadow-ocean-500/30 active:scale-[0.98] font-semibold" style="font-family: 'Poppins', sans-serif;">
                                <i class="fas fa-map-marker-alt text-lg"></i>
                                <span>Get Location on Map</span>
                            </button>

                            <button id="cancel-location-btn" type="button" onclick="clearLocation()" class="w-full px-6 py-2 bg-red-500/10 border border-red-500/30 text-red-100 hover:bg-red-500 hover:text-white rounded-lg transition-all duration-200 flex items-center justify-center gap-2 font-medium hidden" style="font-family: 'Poppins', sans-serif;">
                                <i class="fas fa-times"></i>
                                <span>Cancel</span>
                            </button>
                            
                            <p class="mt-2 text-xs text-gray-400 text-center" style="font-family: 'Poppins', sans-serif;">
                                Opens map. If no location is set, we'll try to find you automatically.
                            </p>
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
                        <svg class="w-5 h-5 inline-block mr-2 text-ocean-400" fill="currentColor" viewBox="0 0 20 20">
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
                        <svg class="w-5 h-5 inline-block mr-2 text-ocean-400" fill="currentColor" viewBox="0 0 20 20">
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
                        <svg class="w-5 h-5 inline-block mr-2 text-ocean-400" fill="currentColor" viewBox="0 0 20 20">
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
                       class="px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white rounded-md font-medium transition duration-300" style="font-family: 'Poppins', sans-serif;">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-gradient-to-r from-ocean-500 to-ocean-600 hover:from-ocean-600 hover:to-ocean-700 text-white font-bold rounded-md transition duration-300" style="font-family: 'Poppins', sans-serif;">
                        <svg class="w-5 h-5 inline-block mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"/>
                        </svg>Submit Report
                    </button>
                </div>
            </form>

            <!-- GPS Map Modal - FULLSCREEN & PROFESSIONAL -->
            <div id="gps-map-modal">
                <div class="map-modal-content">
                    <!-- Header -->
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-2xl font-bold text-white flex items-center gap-3" style="font-family: 'Poppins', sans-serif;">
                                <i class="fas fa-map-marker-alt text-ocean-400"></i>
                                Select Report Location
                            </h3>
                            <p class="text-sm text-gray-400 mt-1" style="font-family: 'Poppins', sans-serif;">
                                Click or drag marker to set exact coordinates
                            </p>
                        </div>
                        <button onclick="closeMapModal()" class="text-gray-400 hover:text-white transition-colors p-2 hover:bg-gray-700/50 rounded-lg">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Map Container -->
                    <div id="gps-map" style="position: relative;"></div>
                    
                    <!-- Footer Actions -->
                    <div class="mt-4 flex justify-between items-center gap-3">
                        <div class="text-sm text-gray-400 flex items-center gap-2" style="font-family: 'Poppins', sans-serif;">
                            <i class="fas fa-info-circle text-ocean-400"></i>
                            <span>Press <kbd class="px-2 py-1 bg-gray-700 rounded text-xs font-mono">ESC</kbd> to close</span>
                        </div>
                        <div class="flex gap-2">
                            <button id="locate-me-btn" type="button" onclick="locateUser()" class="px-4 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-lg transition-all shadow-lg flex items-center font-medium mr-2" style="font-family: 'Poppins', sans-serif;">
                                <i class="fas fa-location-arrow mr-2"></i> Locate Me
                            </button>
                            <button onclick="closeMapModal()" class="px-6 py-2.5 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors font-medium" style="font-family: 'Poppins', sans-serif;">
                                Cancel
                            </button>
                            <button onclick="closeMapModal()" class="px-8 py-2.5 bg-gradient-to-r from-ocean-500 to-ocean-600 hover:from-ocean-600 hover:to-ocean-700 text-white rounded-lg transition-colors font-semibold shadow-lg" style="font-family: 'Poppins', sans-serif;">
                                <i class="fas fa-check mr-2"></i>Confirm Location
                            </button>
                        </div>
                    </div>
                </div>
            </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.patroller', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Rayver\Desktop\my_app\resources\views/patroller/reports/create.blade.php ENDPATH**/ ?>