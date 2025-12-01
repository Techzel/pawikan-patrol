

<?php $__env->startSection('content'); ?>
<style>
    /* Cinzel Font */
    .cinzel-heading {
        font-family: 'Cinzel', serif;
        font-weight: 700;
        letter-spacing: 0.05em;
    }
    
    .cinzel-subheading {
        font-family: 'Cinzel', serif;
        font-weight: 600;
        letter-spacing: 0.03em;
    }
    
    .cinzel-text {
        font-family: 'Cinzel', serif;
        font-weight: 400;
        letter-spacing: 0.02em;
    }

    /* Glass Morphism */
    .glass {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .glass-dark {
        background: rgba(15, 23, 42, 0.7);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(20, 184, 166, 0.2);
    }

    /* Professional Report Cards */
    .featured-report {
        margin-bottom: 3rem;
        max-width: 1100px;
        margin-left: auto;
        margin-right: auto;
        position: relative;
        z-index: 10;
    }

    .report-header {
        display: grid;
        grid-template-columns: auto 1fr;
        gap: 1.5rem;
        align-items: start;
        padding: 2rem;
        background: linear-gradient(135deg, rgba(20, 184, 166, 0.1), rgba(6, 182, 212, 0.05));
        border-bottom: 2px solid rgba(20, 184, 166, 0.2);
    }

    .report-content {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
        padding: 2rem;
    }

    .report-section {
        background: rgba(15, 23, 42, 0.4);
        border-radius: 1rem;
        padding: 1.5rem;
        border: 1px solid rgba(20, 184, 166, 0.15);
    }

    .report-section-title {
        font-size: 0.875rem;
        font-weight: 700;
        color: #14b8a6;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid rgba(20, 184, 166, 0.2);
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        font-size: 0.813rem;
        color: #94a3b8;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .info-value {
        font-size: 0.875rem;
        color: #ffffff;
        font-weight: 600;
        text-align: right;
    }

    .images-section {
        grid-column: 1 / -1;
    }

    .notes-section {
        grid-column: 1 / -1;
        background: rgba(20, 184, 166, 0.05);
        border-left: 3px solid #14b8a6;
    }

    /* Accordion/Dropdown Styles */
    .accordion-toggle {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem 1.5rem;
        background: rgba(20, 184, 166, 0.1);
        border: none;
        border-radius: 0.75rem;
        color: #14b8a6;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-bottom: 0;
        font-size: 0.95rem;
    }

    .accordion-toggle:hover {
        background: rgba(20, 184, 166, 0.2);
        transform: translateX(5px);
    }

    .accordion-toggle .icon {
        transition: transform 0.3s ease;
        font-size: 1.25rem;
    }

    .accordion-toggle.active .icon {
        transform: rotate(180deg);
    }

    .accordion-content {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.4s ease, opacity 0.3s ease;
        opacity: 0;
    }

    .accordion-content.active {
        max-height: 3000px;
        opacity: 1;
    }

    .report-details-wrapper {
        padding: 0 1.5rem 1.5rem 1.5rem;
    }

    @media (max-width: 768px) {
        .report-content {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        
        .report-header {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
    }

    /* Compact Image Grid */
    .compact-image-grid {
        display: grid;
        gap: 0.75rem;
    }

    .compact-image-grid.single {
        grid-template-columns: 1fr;
    }

    .compact-image-grid.double {
        grid-template-columns: repeat(2, 1fr);
    }

    .compact-image-grid.triple {
        grid-template-columns: repeat(3, 1fr);
    }

    .compact-image {
        height: 250px;
        border-radius: 1rem;
        overflow: hidden;
    }

    /* Cute Badge */
    .cute-number {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, rgba(20, 184, 166, 0.3), rgba(6, 182, 212, 0.3));
        border: 2px solid rgba(20, 184, 166, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: bold;
    }

    /* Lightbox */
    .lightbox {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.95);
        z-index: 9999;
        animation: fadeIn 0.3s ease;
    }

    .lightbox.active {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 80px 0 40px;
        box-sizing: border-box;
    }

    .lightbox-content {
        width: min(700px, 80vw);
        max-height: 80vh;
        position: relative;
        animation: zoomIn 0.3s ease;
    }

    .lightbox-image {
        width: 100%;
        height: auto;
        max-height: 75vh;
        object-fit: contain;
        border-radius: 1rem;
        margin: 0 auto;
        display: block;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes zoomIn {
        from { transform: scale(0.8); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }

    /* Filter Buttons */
    .filter-btn {
        transition: all 0.3s ease;
    }

    .filter-btn.active {
        background: linear-gradient(135deg, rgba(20, 184, 166, 0.4), rgba(13, 148, 136, 0.3));
        border-color: rgba(20, 184, 166, 0.6);
        box-shadow: 0 0 20px rgba(20, 184, 166, 0.3);
    }

    /* Badge Styles */
    .badge {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .badge-nesting { background: rgba(251, 191, 36, 0.2); color: #fbbf24; border: 1px solid rgba(251, 191, 36, 0.3); }
    .badge-rescue { background: rgba(239, 68, 68, 0.2); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.3); }
    .badge-sighting { background: rgba(59, 130, 246, 0.2); color: #3b82f6; border: 1px solid rgba(59, 130, 246, 0.3); }
    .badge-threat { background: rgba(239, 68, 68, 0.2); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.3); }
    .badge-patrol { background: rgba(34, 197, 94, 0.2); color: #22c55e; border: 1px solid rgba(34, 197, 94, 0.3); }
    .badge-hazard { background: rgba(239, 68, 68, 0.2); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.3); }
    .badge-stranding { background: rgba(59, 130, 246, 0.2); color: #3b82f6; border: 1px solid rgba(59, 130, 246, 0.3); }
    .badge-hatchling { background: rgba(34, 197, 94, 0.2); color: #22c55e; border: 1px solid rgba(34, 197, 94, 0.3); }
    .badge-incident { background: rgba(239, 68, 68, 0.2); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.3); }
    .badge-observation { background: rgba(59, 130, 246, 0.2); color: #3b82f6; border: 1px solid rgba(59, 130, 246, 0.3); }
    .badge-maintenance { background: rgba(156, 163, 175, 0.2); color: #9ca3af; border: 1px solid rgba(156, 163, 175, 0.3); }
    .badge-emergency { background: rgba(239, 68, 68, 0.2); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.3); }
    .badge-high { background: rgba(239, 68, 68, 0.2); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.3); }
    .badge-medium { background: rgba(251, 191, 36, 0.2); color: #fbbf24; border: 1px solid rgba(251, 191, 36, 0.3); }
    .badge-low { background: rgba(34, 197, 94, 0.2); color: #22c55e; border: 1px solid rgba(34, 197, 94, 0.3); }

    /* Pulse Animation for New Badge */
    .pulse-badge {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.05); opacity: 0.8; }
    }

    /* Bouncing Icon */
    .bounce-icon {
        animation: bounce 2s infinite;
    }

    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
        40% { transform: translateY(-10px); }
        60% { transform: translateY(-5px); }
    }

    /* Ocean Particles Background */
    .ocean-particles {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 0;
        overflow: hidden;
    }

    .particle {
        position: absolute;
        background: radial-gradient(circle, rgba(20, 184, 166, 0.4), transparent);
        border-radius: 50%;
        animation: floatParticle linear infinite;
        opacity: 0.6;
    }

    @keyframes floatParticle {
        0% {
            transform: translateY(100vh) translateX(0) scale(0);
            opacity: 0;
        }
        10% {
            opacity: 0.6;
        }
        90% {
            opacity: 0.6;
        }
        100% {
            transform: translateY(-100px) translateX(var(--drift)) scale(1);
            opacity: 0;
        }
    }

    /* Animated Wave Background */
    .wave-bg {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 200px;
        pointer-events: none;
        z-index: 0;
        opacity: 0.3;
    }

    .wave {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 200%;
        height: 100%;
        background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1200 120'%3E%3Cpath d='M0,60 C300,100 600,20 900,60 C1200,100 1500,20 1800,60 L1800,120 L0,120 Z' fill='rgba(20,184,166,0.2)'/%3E%3C/svg%3E");
        background-size: 50% 100%;
        animation: wave 15s linear infinite;
    }

    .wave:nth-child(2) {
        animation: wave 20s linear infinite reverse;
        opacity: 0.5;
    }

    @keyframes wave {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }

    /* Neon Glow Text */
    .neon-text {
        text-shadow: 
            0 0 10px rgba(20, 184, 166, 0.8),
            0 0 20px rgba(20, 184, 166, 0.6),
            0 0 30px rgba(20, 184, 166, 0.4),
            0 0 40px rgba(20, 184, 166, 0.2);
        animation: neonPulse 2s ease-in-out infinite;
    }

    @keyframes neonPulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.8; }
    }
</style>

<div class="min-h-screen bg-gradient-to-br from-deep-900 via-deep-800 to-ocean-900 text-white pt-24 pb-16" style="position: relative;">
    <!-- Ocean Particles Background -->
    <div class="ocean-particles" id="oceanParticles"></div>
    
    <!-- Animated Wave Background -->
    <div class="wave-bg">
        <div class="wave"></div>
        <div class="wave"></div>
    </div>

    <!-- Hero Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10 mb-12" style="position: relative; z-index: 10;">
        <div class="text-center mb-12">
            <h1 class="text-5xl md:text-6xl font-bold text-ocean-300 mb-4 cinzel-heading neon-text">
                Patrol Report Gallery
            </h1>
            <p class="text-xl text-gray-300 max-w-3xl mx-auto cinzel-text">
                Explore the incredible conservation efforts captured by our dedicated patrollers. Each image tells a story of protection, rescue, and hope for our marine turtles.
            </p>
        </div>

        <?php
            $availableTypes = collect($reports)->pluck('report_type')->filter()->unique()->values();
            $typeLabels = [
                'hazard' => 'Threat / Hazard',
                'stranding' => 'Stranding',
                'rescue' => 'Rescue & Rehab',
                'nesting' => 'Nesting Activity',
                'hatchling' => 'Hatchling Release',
                'sighting' => 'Wildlife Sighting',
                'incident' => 'Incident Report',
                'observation' => 'Observation',
                'maintenance' => 'Maintenance',
                'emergency' => 'Emergency'
            ];
            $typeIcons = [
                'hazard' => '⚠️',
                'stranding' => '🏖️',
                'rescue' => '🛟',
                'nesting' => '🥚',
                'hatchling' => '🐣',
                'sighting' => '👁️',
                'incident' => '🚨',
                'observation' => '🔎',
                'maintenance' => '🛠️',
                'emergency' => '🚑'
            ];
        ?>

        <!-- Filter Buttons -->
        <div class="flex flex-wrap justify-center gap-3">
            <button class="filter-btn active glass-dark px-6 py-3 rounded-full text-sm font-semibold cinzel-text hover:bg-ocean-600/20 transition-all" data-filter="all">
                🌊 All Reports
            </button>
            <?php $__currentLoopData = $availableTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $label = $typeLabels[$type] ?? \Illuminate\Support\Str::headline($type);
                    $icon = $typeIcons[$type] ?? '📌';
                ?>
                <button class="filter-btn glass-dark px-6 py-3 rounded-full text-sm font-semibold cinzel-text hover:bg-ocean-600/20 transition-all" data-filter="<?php echo e($type); ?>">
                    <?php echo e($icon); ?> <?php echo e($label); ?>

                </button>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    <!-- Featured Reports -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <?php $__empty_1 = true; $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="featured-report glass-dark rounded-2xl overflow-hidden gallery-item"
                 data-type="<?php echo e(strtolower($report['report_type'])); ?>">
                
                <!-- Professional Header -->
                <div class="report-header">
                    <div class="cute-number bounce-icon cinzel-heading text-ocean-300">
                        <?php echo e($index + 1); ?>

                    </div>
                    
                    <div>
                        <div class="flex items-center gap-2 mb-2 flex-wrap">
                            <span class="badge badge-<?php echo e(strtolower($report['report_type'])); ?> text-xs">
                                <?php echo e($typeIcons[$report['report_type']] ?? '📌'); ?> <?php echo e(ucfirst($report['report_type'])); ?>

                            </span>
                            <?php if($index === 0): ?>
                                <span class="badge bg-gradient-to-r from-yellow-500/20 to-orange-500/20 text-yellow-400 border-yellow-500/30 pulse-badge text-xs">
                                    ⭐ Latest
                                </span>
                            <?php endif; ?>
                            <?php if($report['priority']): ?>
                                <span class="badge badge-<?php echo e(strtolower($report['priority'])); ?> text-xs">
                                    <?php echo e(ucfirst($report['priority'])); ?> Priority
                                </span>
                            <?php endif; ?>
                        </div>
                        <h2 class="text-2xl font-bold text-white cinzel-heading mb-2">
                            <?php echo e($report['title']); ?>

                        </h2>
                        <p class="text-gray-300 text-sm cinzel-text leading-relaxed">
                            <?php echo e($report['description']); ?>

                        </p>
                    </div>
                </div>

                <!-- Images Section (Full Width) -->
                <?php if(!empty($report['images'])): ?>
                    <div class="p-6 bg-gradient-to-b from-ocean-900/20 to-transparent">
                        <?php
                            $imageCount = count($report['images']);
                            $gridClass = $imageCount === 1 ? 'single' : ($imageCount === 2 ? 'double' : 'triple');
                        ?>
                        <div class="compact-image-grid <?php echo e($gridClass); ?>">
                            <?php $__currentLoopData = $report['images']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $imageIndex => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="compact-image relative cursor-pointer group" 
                                     onclick="openLightbox('<?php echo e(asset('storage/' . $image)); ?>', <?php echo e(json_encode($report)); ?>)">
                                    <img src="<?php echo e(asset('storage/' . $image)); ?>" 
                                         alt="<?php echo e($report['title']); ?>" 
                                         class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                        <span class="text-white text-4xl bounce-icon">🔍</span>
                                    </div>
                                    <div class="absolute top-3 right-3 bg-black/70 backdrop-blur-sm px-3 py-1.5 rounded-full text-white text-xs font-semibold">
                                        <?php echo e($imageIndex + 1); ?> / <?php echo e($imageCount); ?>

                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Accordion Toggle Button -->
                <div class="px-6 pb-6">
                    <button class="accordion-toggle cinzel-text" onclick="toggleAccordion(this)">
                        <span>📊 View Full Report Details</span>
                        <span class="icon">▼</span>
                    </button>

                    <!-- Report Content Grid (Collapsible) -->
                    <div class="accordion-content">
                        <div class="report-details-wrapper">
                            <div class="report-content">
                                <!-- Basic Information -->
                                <div class="report-section">
                                    <h3 class="report-section-title cinzel-subheading">
                                        <span>📋</span> Basic Information
                                    </h3>
                                    
                                    <div class="info-row">
                                        <span class="info-label cinzel-text">📍 Location</span>
                                        <span class="info-value cinzel-text"><?php echo e($report['location']); ?></span>
                                    </div>
                                    
                                    <div class="info-row">
                                        <span class="info-label cinzel-text">📅 Report Date</span>
                                        <span class="info-value cinzel-text"><?php echo e($report['reported_at']); ?></span>
                                    </div>
                                    
                                    <?php if($report['incident_datetime']): ?>
                                        <div class="info-row">
                                            <span class="info-label cinzel-text">🕐 Incident Time</span>
                                            <span class="info-value cinzel-text"><?php echo e($report['incident_datetime']); ?></span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="info-row">
                                        <span class="info-label cinzel-text">👤 Reported By</span>
                                        <span class="info-value cinzel-text"><?php echo e($report['reported_by']); ?></span>
                                    </div>
                                    
                                    <?php if($report['weather_conditions']): ?>
                                        <div class="info-row">
                                            <span class="info-label cinzel-text">🌤️ Weather</span>
                                            <span class="info-value cinzel-text"><?php echo e($report['weather_conditions']); ?></span>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Turtle Details -->
                                <?php if($report['turtle_species'] || $report['turtle_gender'] || $report['turtle_count'] || $report['egg_count'] || $report['turtle_condition']): ?>
                                    <div class="report-section">
                                        <h3 class="report-section-title cinzel-subheading">
                                            <span>🐢</span> Turtle Details
                                        </h3>
                                        
                                        <?php if($report['turtle_species']): ?>
                                            <div class="info-row">
                                                <span class="info-label cinzel-text">Species</span>
                                                <span class="info-value cinzel-text"><?php echo e($report['turtle_species']); ?></span>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if($report['turtle_gender']): ?>
                                            <div class="info-row">
                                                <span class="info-label cinzel-text">Gender</span>
                                                <span class="info-value cinzel-text"><?php echo e(ucfirst($report['turtle_gender'])); ?></span>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if($report['turtle_count']): ?>
                                            <div class="info-row">
                                                <span class="info-label cinzel-text">Count</span>
                                                <span class="info-value cinzel-text"><?php echo e($report['turtle_count']); ?></span>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if($report['egg_count']): ?>
                                            <div class="info-row">
                                                <span class="info-label cinzel-text">🥚 Egg Count</span>
                                                <span class="info-value cinzel-text"><?php echo e($report['egg_count']); ?></span>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if($report['turtle_condition']): ?>
                                            <div class="info-row">
                                                <span class="info-label cinzel-text">❤️ Condition</span>
                                                <span class="info-value cinzel-text">
                                                    <span class="px-2 py-1 rounded-full text-xs font-semibold
                                                        <?php echo e($report['turtle_condition'] === 'healthy' ? 'bg-green-500/20 text-green-400' : ''); ?>

                                                        <?php echo e($report['turtle_condition'] === 'injured' ? 'bg-red-500/20 text-red-400' : ''); ?>

                                                        <?php echo e($report['turtle_condition'] === 'sick' ? 'bg-yellow-500/20 text-yellow-400' : ''); ?>">
                                                        <?php echo e(ucfirst($report['turtle_condition'])); ?>

                                                    </span>
                                                </span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>

                                <!-- Location Coordinates (if available) -->
                                <?php if($report['latitude'] && $report['longitude']): ?>
                                    <div class="report-section" style="grid-column: 1 / -1;">
                                        <h3 class="report-section-title cinzel-subheading">
                                            <span>🗺️</span> Geographic Coordinates
                                        </h3>
                                        <div class="info-row">
                                            <span class="info-label cinzel-text">Latitude</span>
                                            <span class="info-value cinzel-text font-mono"><?php echo e($report['latitude']); ?></span>
                                        </div>
                                        <div class="info-row">
                                            <span class="info-label cinzel-text">Longitude</span>
                                            <span class="info-value cinzel-text font-mono"><?php echo e($report['longitude']); ?></span>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <!-- Additional Notes -->
                                <?php if($report['additional_notes']): ?>
                                    <div class="report-section notes-section">
                                        <h3 class="report-section-title cinzel-subheading">
                                            <span>📝</span> Additional Notes
                                        </h3>
                                        <p class="text-gray-300 text-sm cinzel-text leading-relaxed"><?php echo e($report['additional_notes']); ?></p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="text-center py-20">
                <div class="text-6xl mb-4">📸</div>
                <h3 class="text-2xl font-bold text-gray-400 mb-2 cinzel-subheading">No reports available yet</h3>
                <p class="text-gray-500 cinzel-text">Check back soon for patrol reports with images</p>
            </div>
        <?php endif; ?>

        <div id="gallery-empty-state" class="hidden text-center py-16">
            <div class="text-5xl mb-3">🔍</div>
            <h3 class="text-2xl font-bold text-gray-300 mb-2 cinzel-subheading">No reports match this filter</h3>
            <p class="text-gray-400 cinzel-text">Try selecting a different report type to continue exploring.</p>
        </div>
    </div>

    <!-- Lightbox -->
    <div id="lightbox" class="lightbox">
        <button onclick="closeLightbox()" class="absolute top-6 right-6 text-white text-4xl hover:text-ocean-400 transition-colors z-10">
            ×
        </button>
        <button onclick="previousImage()" class="absolute left-6 top-1/2 transform -translate-y-1/2 text-white text-4xl hover:text-ocean-400 transition-colors z-10">
            ‹
        </button>
        <button onclick="nextImage()" class="absolute right-6 top-1/2 transform -translate-y-1/2 text-white text-4xl hover:text-ocean-400 transition-colors z-10">
            ›
        </button>
        <div class="lightbox-content">
            <img id="lightbox-image" class="lightbox-image" src="" alt="">
        </div>
    </div>
</div>

<script>
    // Accordion Toggle Function
    function toggleAccordion(button) {
        const content = button.nextElementSibling;
        const isActive = content.classList.contains('active');
        
        // Toggle active state
        button.classList.toggle('active');
        content.classList.toggle('active');
        
        // Update button text
        const textSpan = button.querySelector('span:first-child');
        if (isActive) {
            textSpan.textContent = '📊 View Full Report Details';
        } else {
            textSpan.textContent = '📊 Hide Report Details';
        }
    }

    // Create ocean particles
    function createParticles() {
        const container = document.getElementById('oceanParticles');
        const particleCount = 30;
        
        for (let i = 0; i < particleCount; i++) {
            const particle = document.createElement('div');
            particle.className = 'particle';
            
            const size = Math.random() * 30 + 10;
            const startX = Math.random() * 100;
            const drift = (Math.random() - 0.5) * 200;
            const duration = Math.random() * 10 + 15;
            const delay = Math.random() * 5;
            
            particle.style.width = `${size}px`;
            particle.style.height = `${size}px`;
            particle.style.left = `${startX}%`;
            particle.style.setProperty('--drift', `${drift}px`);
            particle.style.animationDuration = `${duration}s`;
            particle.style.animationDelay = `${delay}s`;
            
            container.appendChild(particle);
        }
    }

    // Filter functionality
    const filterButtons = document.querySelectorAll('.filter-btn');
    const galleryItems = document.querySelectorAll('.gallery-item');
    const emptyState = document.getElementById('gallery-empty-state');

    filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            const filter = (button.dataset.filter || 'all').toLowerCase();
            
            // Update active button
            filterButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');
            
            // Filter items
            let visibleCount = 0;
            galleryItems.forEach(item => {
                const itemType = (item.dataset.type || '').toLowerCase();
                if (filter === 'all' || itemType === filter) {
                    item.style.display = 'block';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });
            
            // Show/hide empty state
            if (emptyState) {
                emptyState.classList.toggle('hidden', visibleCount > 0);
            }
        });
    });

    // Lightbox functionality
    let currentReport = null;
    let currentImageIndex = 0;
    let currentImages = [];

    function openLightbox(imageSrc, report) {
        currentReport = report;
        currentImages = report.images.map(img => '<?php echo e(asset("storage")); ?>/' + img);
        currentImageIndex = currentImages.indexOf(imageSrc);
        
        showLightboxImage();
        document.getElementById('lightbox').classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        document.getElementById('lightbox').classList.remove('active');
        document.body.style.overflow = 'auto';
    }

    function showLightboxImage() {
        document.getElementById('lightbox-image').src = currentImages[currentImageIndex];
    }

    function previousImage() {
        currentImageIndex = (currentImageIndex - 1 + currentImages.length) % currentImages.length;
        showLightboxImage();
    }

    function nextImage() {
        currentImageIndex = (currentImageIndex + 1) % currentImages.length;
        showLightboxImage();
    }

    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
        if (document.getElementById('lightbox').classList.contains('active')) {
            if (e.key === 'Escape') closeLightbox();
            if (e.key === 'ArrowLeft') previousImage();
            if (e.key === 'ArrowRight') nextImage();
        }
    });

    // Close lightbox on background click
    document.getElementById('lightbox').addEventListener('click', (e) => {
        if (e.target.id === 'lightbox') {
            closeLightbox();
        }
    });

    // Initialize particles on page load
    window.addEventListener('load', () => {
        createParticles();
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Rayver\Desktop\my_app\resources\views/patrol-map-gallery.blade.php ENDPATH**/ ?>