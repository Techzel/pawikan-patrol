<?php $__env->startSection('title', 'Edit Report'); ?>
<?php $__env->startSection('container-class', 'max-w-4xl'); ?>

<?php $__env->startSection('content'); ?>
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-white mb-2 cinzel-heading">
                            <i class="fas fa-edit mr-3 text-ocean-400"></i>Edit Report
                        </h1>
                        <p class="text-gray-300 cinzel-text">Update your patrol report details</p>
                    </div>
                    <a href="<?php echo e(route('patroller.reports.show', $report)); ?>" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors cinzel-text">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Report
                    </a>
                </div>
            </div>

            <!-- Error Messages -->
            <?php if($errors->any()): ?>
                <div class="mb-6 glass-dark border-l-4 border-red-500 p-4 rounded">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-400"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-100 cinzel-text">Please correct the following errors:</h3>
                            <ul class="mt-2 text-sm text-red-100 list-disc list-inside cinzel-text">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Edit Form -->
            <form method="POST" action="<?php echo e(route('patroller.reports.update', $report)); ?>" enctype="multipart/form-data" class="space-y-6">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <!-- Basic Information -->
                <div class="glass-dark rounded-xl p-6 border border-ocean-500/20">
                    <h3 class="text-lg font-semibold text-white mb-6 cinzel-subheading">
                        <i class="fas fa-info-circle mr-2 text-ocean-400"></i>Basic Information
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Report Type -->
                        <div>
                            <label for="report_type" class="block text-sm font-medium text-gray-300 mb-2 cinzel-text">Report Type *</label>
                            <select name="report_type" id="report_type" required class="w-full bg-white/10 border border-ocean-500/30 rounded-lg px-3 py-2 text-white focus:ring-2 focus:ring-ocean-500 focus:border-transparent cinzel-text">
                                <option value="">Select Type</option>
                                <option value="incident" <?php echo e(old('report_type', $report->report_type) == 'incident' ? 'selected' : ''); ?>>Incident</option>
                                <option value="observation" <?php echo e(old('report_type', $report->report_type) == 'observation' ? 'selected' : ''); ?>>Observation</option>
                                <option value="maintenance" <?php echo e(old('report_type', $report->report_type) == 'maintenance' ? 'selected' : ''); ?>>Maintenance</option>
                                <option value="emergency" <?php echo e(old('report_type', $report->report_type) == 'emergency' ? 'selected' : ''); ?>>Emergency</option>
                            </select>
                        </div>

                        <!-- Priority -->
                        <div>
                            <label for="priority" class="block text-sm font-medium text-gray-300 mb-2 cinzel-text">Priority *</label>
                            <select name="priority" id="priority" required class="w-full bg-white/10 border border-ocean-500/30 rounded-lg px-3 py-2 text-white focus:ring-2 focus:ring-ocean-500 focus:border-transparent cinzel-text">
                                <option value="">Select Priority</option>
                                <option value="low" <?php echo e(old('priority', $report->priority) == 'low' ? 'selected' : ''); ?>>Low</option>
                                <option value="medium" <?php echo e(old('priority', $report->priority) == 'medium' ? 'selected' : ''); ?>>Medium</option>
                                <option value="high" <?php echo e(old('priority', $report->priority) == 'high' ? 'selected' : ''); ?>>High</option>
                                <option value="critical" <?php echo e(old('priority', $report->priority) == 'critical' ? 'selected' : ''); ?>>Critical</option>
                            </select>
                        </div>
                    </div>

                    <!-- Title -->
                    <div class="mt-6">
                        <label for="title" class="block text-sm font-medium text-gray-300 mb-2 cinzel-text">Report Title *</label>
                        <input type="text" name="title" id="title" value="<?php echo e(old('title', $report->title)); ?>" required maxlength="255" class="w-full bg-white/10 border border-ocean-500/30 rounded-lg px-3 py-2 text-white focus:ring-2 focus:ring-ocean-500 focus:border-transparent cinzel-text" placeholder="Brief title describing the report">
                    </div>

                    <!-- Description -->
                    <div class="mt-6">
                        <label for="description" class="block text-sm font-medium text-gray-300 mb-2 cinzel-text">Description *</label>
                        <textarea name="description" id="description" rows="4" required minlength="10" class="w-full bg-white/10 border border-ocean-500/30 rounded-lg px-3 py-2 text-white focus:ring-2 focus:ring-ocean-500 focus:border-transparent cinzel-text" placeholder="Detailed description of the incident, observation, or maintenance issue"><?php echo e(old('description', $report->description)); ?></textarea>
                    </div>
                </div>

                <!-- Location Information -->
                <div class="glass-dark rounded-xl p-6 border border-ocean-500/20">
                    <h3 class="text-lg font-semibold text-white mb-6 cinzel-subheading">
                        <i class="fas fa-map-marker-alt mr-2 text-ocean-400"></i>Location Information
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Location -->
                        <div class="md:col-span-1">
                            <label for="location" class="block text-sm font-medium text-gray-300 mb-2 cinzel-text">Location *</label>
                            <input type="text" name="location" id="location" value="<?php echo e(old('location', $report->location)); ?>" required maxlength="255" class="w-full bg-white/10 border border-ocean-500/30 rounded-lg px-3 py-2 text-white focus:ring-2 focus:ring-ocean-500 focus:border-transparent cinzel-text" placeholder="e.g., Dahican Beach, Section A">
                        </div>

                        <!-- Latitude -->
                        <div>
                            <label for="latitude" class="block text-sm font-medium text-gray-300 mb-2 cinzel-text">Latitude</label>
                            <input type="number" name="latitude" id="latitude" value="<?php echo e(old('latitude', $report->latitude)); ?>" step="0.000001" min="-90" max="90" class="w-full bg-white/10 border border-ocean-500/30 rounded-lg px-3 py-2 text-white focus:ring-2 focus:ring-ocean-500 focus:border-transparent cinzel-text" placeholder="e.g., 7.123456">
                        </div>

                        <!-- Longitude -->
                        <div>
                            <label for="longitude" class="block text-sm font-medium text-gray-300 mb-2 cinzel-text">Longitude</label>
                            <input type="number" name="longitude" id="longitude" value="<?php echo e(old('longitude', $report->longitude)); ?>" step="0.000001" min="-180" max="180" class="w-full bg-white/10 border border-ocean-500/30 rounded-lg px-3 py-2 text-white focus:ring-2 focus:ring-ocean-500 focus:border-transparent cinzel-text" placeholder="e.g., 126.123456">
                        </div>
                    </div>

                    <!-- Get Current Location Button -->
                    <div class="mt-4">
                        <button type="button" id="getCurrentLocation" class="bg-ocean-500 hover:bg-ocean-600 text-white px-4 py-2 rounded-lg font-medium transition-colors cinzel-text">
                            <i class="fas fa-crosshairs mr-2"></i>Get Current Location
                        </button>
                    </div>
                </div>

                <!-- Turtle Information -->
                <div class="glass-dark rounded-xl p-6 border border-ocean-500/20">
                    <h3 class="text-lg font-semibold text-white mb-6 cinzel-subheading">
                        <i class="fas fa-turtle mr-2 text-ocean-400"></i>Turtle Information (Optional)
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Turtle Count -->
                        <div>
                            <label for="turtle_count" class="block text-sm font-medium text-gray-300 mb-2 cinzel-text">Turtle Count</label>
                            <input type="number" name="turtle_count" id="turtle_count" value="<?php echo e(old('turtle_count', $report->turtle_count)); ?>" min="0" class="w-full bg-white/10 border border-ocean-500/30 rounded-lg px-3 py-2 text-white focus:ring-2 focus:ring-ocean-500 focus:border-transparent cinzel-text" placeholder="Number of turtles">
                        </div>

                        <!-- Turtle Species -->
                        <div>
                            <label for="turtle_species" class="block text-sm font-medium text-gray-300 mb-2 cinzel-text">Species</label>
                            <input type="text" name="turtle_species" id="turtle_species" value="<?php echo e(old('turtle_species', $report->turtle_species)); ?>" maxlength="255" class="w-full bg-white/10 border border-ocean-500/30 rounded-lg px-3 py-2 text-white focus:ring-2 focus:ring-ocean-500 focus:border-transparent cinzel-text" placeholder="e.g., Olive Ridley">
                        </div>

                        <!-- Turtle Condition -->
                        <div>
                            <label for="turtle_condition" class="block text-sm font-medium text-gray-300 mb-2 cinzel-text">Condition</label>
                            <select name="turtle_condition" id="turtle_condition" class="w-full bg-white/10 border border-ocean-500/30 rounded-lg px-3 py-2 text-white focus:ring-2 focus:ring-ocean-500 focus:border-transparent cinzel-text">
                                <option value="">Select Condition</option>
                                <option value="healthy" <?php echo e(old('turtle_condition', $report->turtle_condition) == 'healthy' ? 'selected' : ''); ?>>Healthy</option>
                                <option value="injured" <?php echo e(old('turtle_condition', $report->turtle_condition) == 'injured' ? 'selected' : ''); ?>>Injured</option>
                                <option value="dead" <?php echo e(old('turtle_condition', $report->turtle_condition) == 'dead' ? 'selected' : ''); ?>>Dead</option>
                                <option value="unknown" <?php echo e(old('turtle_condition', $report->turtle_condition) == 'unknown' ? 'selected' : ''); ?>>Unknown</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="glass-dark rounded-xl p-6 border border-ocean-500/20">
                    <h3 class="text-lg font-semibold text-white mb-6 cinzel-subheading">
                        <i class="fas fa-clipboard-list mr-2 text-ocean-400"></i>Additional Information
                    </h3>
                    
                    <!-- Weather Conditions -->
                    <div class="mb-6">
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


                    <!-- Incident Date/Time -->
                    <div class="mb-6">
                        <label for="incident_datetime" class="block text-sm font-medium text-gray-300 mb-2 cinzel-text">Incident Date & Time</label>
                        <input type="datetime-local" name="incident_datetime" id="incident_datetime" value="<?php echo e(old('incident_datetime', $report->incident_datetime ? $report->incident_datetime->format('Y-m-d\TH:i') : '')); ?>" class="w-full bg-white/10 border border-ocean-500/30 rounded-lg px-3 py-2 text-white focus:ring-2 focus:ring-ocean-500 focus:border-transparent cinzel-text">
                    </div>

                    <!-- Requires Follow-up -->
                    <div class="flex items-center">
                        <input type="checkbox" name="requires_followup" id="requires_followup" value="1" <?php echo e(old('requires_followup', $report->requires_followup) ? 'checked' : ''); ?> class="h-4 w-4 text-ocean-500 focus:ring-ocean-500 border-ocean-300 rounded">
                        <label for="requires_followup" class="ml-2 block text-sm text-gray-300 cinzel-text">This report requires follow-up action</label>
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
document.getElementById('getCurrentLocation').addEventListener('click', function() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            document.getElementById('latitude').value = position.coords.latitude.toFixed(6);
            document.getElementById('longitude').value = position.coords.longitude.toFixed(6);
        }, function(error) {
            alert('Error getting location: ' + error.message);
        });
    } else {
        alert('Geolocation is not supported by this browser.');
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.patroller', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Rayver\Desktop\pawikan-patrol\my_app\resources\views/patroller/reports/edit.blade.php ENDPATH**/ ?>