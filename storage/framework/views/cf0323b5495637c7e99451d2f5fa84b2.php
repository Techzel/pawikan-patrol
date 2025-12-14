<?php $__env->startSection('content'); ?>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Cinzel:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    * {
        font-family: 'Poppins', sans-serif;
        box-sizing: border-box;
    }

    /* Main Container */
    .gallery-wrapper {
        min-height: 100vh;
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
        position: relative;
        overflow: hidden;
    }

    .gallery-wrapper::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: radial-gradient(circle at 20% 50%, rgba(59, 130, 246, 0.1) 0%, transparent 50%),
                    radial-gradient(circle at 80% 80%, rgba(16, 185, 129, 0.1) 0%, transparent 50%);
        pointer-events: none;
    }

    /* Header */
    .gallery-header {
        text-align: center;
        padding: 3rem 1rem 2rem;
        position: relative;
        z-index: 1;
    }

    .gallery-title {
        font-size: clamp(2.5rem, 5.5vw, 3.5rem);
        font-weight: 800;
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 1rem;
        letter-spacing: 0.02em;
    }

    .gallery-subtitle {
        font-size: 1.125rem;
        color: #d1fae5;
        max-width: 600px;
        margin: 0 auto;
        line-height: 1.7;
    }

    /* Card Stack Container */
    .cards-stack {
        position: relative;
        max-width: 1400px;
        margin: 0 auto;
        padding: 2rem 1rem;
        min-height: 750px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Individual Report Card */
    .report-card {
        position: absolute;
        width: 100%;
        max-width: 1300px;
        background: rgba(30, 41, 59, 0.7);
        backdrop-filter: blur(20px);
        border-radius: 24px;
        overflow: hidden;
        border: 1px solid rgba(148, 163, 184, 0.2);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        transition: all 0.6s cubic-bezier(0.25, 1, 0.5, 1);
        opacity: 0;
        transform: scale(0.9);
        pointer-events: none;
        z-index: 1;
    }

    .report-card.active {
        opacity: 1;
        transform: translateX(0) scale(1);
        pointer-events: all;
        z-index: 10;
    }

    .report-card.prev {
        opacity: 0.4;
        transform: translateX(-105%) scale(0.9) skewY(2deg);
        z-index: 5;
        filter: brightness(0.7);
    }

    .report-card.next {
        opacity: 0.4;
        transform: translateX(105%) scale(0.9) skewY(-2deg);
        z-index: 5;
        filter: brightness(0.7);
    }

    /* Card Grid Layout */
    .card-grid {
        display: grid;
        grid-template-columns: 1.2fr 1fr;
        gap: 0;
        min-height: 650px;
    }

    /* Image Gallery Section */
    .image-gallery {
        position: relative;
        background: rgba(0, 0, 0, 0.4);
        display: flex;
        flex-direction: column;
    }

    .main-image-container {
        position: relative;
        flex: 1;
        overflow: hidden;
        cursor: zoom-in;
    }

    .main-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .main-image-container:hover .main-image {
        transform: scale(1.08);
    }

    .image-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.6) 0%, transparent 40%);
        pointer-events: none;
    }

    .image-badge {
        position: absolute;
        top: 1.5rem;
        left: 1.5rem;
        padding: 0.625rem 1.25rem;
        border-radius: 100px;
        font-size: 0.875rem;
        font-weight: 600;
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        z-index: 2;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .badge-nesting { background: rgba(251, 191, 36, 0.25); color: #fbbf24; }
    .badge-rescue { background: rgba(239, 68, 68, 0.25); color: #fca5a5; }
    .badge-sighting { background: rgba(59, 130, 246, 0.25); color: #93c5fd; }
    .badge-threat { background: rgba(239, 68, 68, 0.25); color: #fca5a5; }
    .badge-patrol { background: rgba(34, 197, 94, 0.25); color: #86efac; }
    .badge-hazard { background: rgba(239, 68, 68, 0.25); color: #fca5a5; }
    .badge-stranding { background: rgba(59, 130, 246, 0.25); color: #93c5fd; }
    .badge-hatchling { background: rgba(34, 197, 94, 0.25); color: #86efac; }
    .badge-incident { background: rgba(239, 68, 68, 0.25); color: #fca5a5; }
    .badge-observation { background: rgba(59, 130, 246, 0.25); color: #93c5fd; }
    .badge-maintenance { background: rgba(156, 163, 175, 0.25); color: #d1d5db; }
    .badge-emergency { background: rgba(239, 68, 68, 0.25); color: #fca5a5; }

    .image-counter {
        position: absolute;
        bottom: 1.5rem;
        right: 1.5rem;
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(12px);
        padding: 0.5rem 1rem;
        border-radius: 100px;
        color: white;
        font-size: 0.875rem;
        font-weight: 600;
        z-index: 2;
    }

    /* Thumbnail Strip */
    .thumbnail-strip {
        display: flex;
        gap: 0.75rem;
        padding: 1rem;
        background: rgba(0, 0, 0, 0.3);
        overflow-x: auto;
        scrollbar-width: thin;
        scrollbar-color: rgba(255,255,255,0.3) transparent;
    }

    .thumbnail-strip::-webkit-scrollbar {
        height: 4px;
    }

    .thumbnail-strip::-webkit-scrollbar-track {
        background: transparent;
    }

    .thumbnail-strip::-webkit-scrollbar-thumb {
        background: rgba(255,255,255,0.3);
        border-radius: 2px;
    }

    .thumbnail {
        flex-shrink: 0;
        width: 80px;
        height: 60px;
        border-radius: 8px;
        object-fit: cover;
        cursor: pointer;
        opacity: 0.5;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .thumbnail:hover {
        opacity: 0.8;
        transform: translateY(-2px);
    }

    .thumbnail.active {
        opacity: 1;
        border-color: #60a5fa;
        box-shadow: 0 0 0 2px rgba(96, 165, 250, 0.3);
    }

    /* Details Section */
    .details-section {
        padding: 2.5rem;
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        overflow-y: auto;
        max-height: 650px;
        scrollbar-width: thin;
        scrollbar-color: rgba(148, 163, 184, 0.3) transparent;
    }

    .details-section::-webkit-scrollbar {
        width: 6px;
    }

    .details-section::-webkit-scrollbar-track {
        background: transparent;
    }

    .details-section::-webkit-scrollbar-thumb {
        background: rgba(148, 163, 184, 0.3);
        border-radius: 3px;
    }

    .report-header h2 {
        font-size: 1.875rem;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 0.75rem;
        line-height: 1.3;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }

    .report-description {
        font-size: 1rem;
        color: #d1fae5;
        line-height: 1.7;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }

    .info-block {
        background: rgba(15, 23, 42, 0.5);
        border-radius: 16px;
        padding: 1.5rem;
        border: 1px solid rgba(148, 163, 184, 0.15);
        transition: all 0.3s ease;
    }

    .info-block:hover {
        background: rgba(15, 23, 42, 0.7);
        border-color: rgba(16, 185, 129, 0.4);
        transform: translateX(4px);
    }

    .info-block-title {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #6ee7b7;
        font-weight: 600;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding: 0.75rem 0;
        border-bottom: 1px solid rgba(148, 163, 184, 0.1);
        gap: 1rem;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        font-size: 0.875rem;
        color: #a7f3d0;
        font-weight: 500;
        flex-shrink: 0;
        min-width: 120px;
    }

    .info-value {
        font-size: 0.875rem;
        color: #ffffff;
        font-weight: 600;
        text-align: right;
        word-wrap: break-word;
        overflow-wrap: break-word;
        flex: 1;
    }

    /* Navigation Controls */
    .nav-button {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: rgba(30, 41, 59, 0.8);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(148, 163, 184, 0.3);
        color: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        z-index: 100;
        font-size: 1.5rem;
        user-select: none;
    }

    .nav-button:hover {
        background: rgba(16, 185, 129, 0.3);
        border-color: #10b981;
        transform: translateY(-50%) scale(1.1);
        box-shadow: 0 0 24px rgba(16, 185, 129, 0.4);
    }

    .nav-button:active {
        transform: translateY(-50%) scale(0.95);
    }

    .nav-button.prev {
        left: 1rem;
    }

    .nav-button.next {
        right: 1rem;
    }

    /* Progress Indicators */
    .progress-container {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 2rem;
        margin-top: 2.5rem;
        padding: 0 1rem;
    }

    .progress-dots {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }

    .progress-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: rgba(148, 163, 184, 0.3);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .progress-dot:hover {
        background: rgba(16, 185, 129, 0.6);
        transform: scale(1.2);
    }

    .progress-dot.active {
        width: 32px;
        border-radius: 4px;
        background: linear-gradient(90deg, #10b981 0%, #34d399 100%);
        box-shadow: 0 0 12px rgba(16, 185, 129, 0.5);
    }

    .progress-counter {
        font-size: 1rem;
        color: #d1fae5;
        font-weight: 600;
        min-width: 80px;
        text-align: center;
    }

    /* Lightbox */
    .lightbox {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.95);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(8px);
    }

    .lightbox.active {
        display: flex;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .lightbox-content {
        position: relative;
        max-width: 95vw;
        max-height: 95vh;
    }

    .lightbox-image {
        max-width: 100%;
        max-height: 95vh;
        object-fit: contain;
        border-radius: 12px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.8);
    }

    .lightbox-close {
        position: absolute;
        top: -3rem;
        right: 0;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
        font-size: 2rem;
        width: 48px;
        height: 48px;
        border-radius: 50%;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(12px);
    }

    .lightbox-close:hover {
        background: rgba(239, 68, 68, 0.3);
        border-color: #ef4444;
        transform: rotate(90deg);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 5rem 2rem;
        color: #d1fae5;
    }

    .empty-state-icon {
        font-size: 5rem;
        margin-bottom: 1.5rem;
        opacity: 0.5;
    }

    .empty-state h3 {
        font-size: 1.75rem;
        font-weight: 600;
        color: #ffffff;
        margin-bottom: 0.75rem;
    }

    .empty-state p {
        font-size: 1rem;
        color: #a7f3d0;
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .card-grid {
            grid-template-columns: 1fr;
        }

        .main-image-container {
            min-height: 400px;
        }

        .nav-button.prev {
            left: 0.5rem;
        }

        .nav-button.next {
            right: 0.5rem;
        }
    }

    @media (max-width: 768px) {
        .gallery-header {
            padding: 2rem 1rem 1.5rem;
        }

        .cards-stack {
            padding: 1rem;
            min-height: 600px;
        }

        .details-section {
            padding: 1.5rem;
        }

        .report-header h2 {
            font-size: 1.5rem;
        }

        .main-image-container {
            min-height: 300px;
        }

        .nav-button {
            width: 44px;
            height: 44px;
            font-size: 1.25rem;
        }

        .thumbnail {
            width: 60px;
            height: 45px;
        }
    }

    /* Touch Swipe Indicator */
    .swipe-hint {
        position: absolute;
        bottom: 2rem;
        left: 50%;
        transform: translateX(-50%);
        color: rgba(148, 163, 184, 0.6);
        font-size: 0.875rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        animation: bounce 2s infinite;
        pointer-events: none;
    }

    @keyframes bounce {
        0%, 100% { transform: translateX(-50%) translateY(0); }
        50% { transform: translateX(-50%) translateY(-8px); }
    }

    @media (min-width: 1024px) {
        .swipe-hint {
            display: none;
        }
    }
</style>

<?php
    $isPatrollerOrAdmin = auth()->check() && in_array(auth()->user()->role, ['patroller', 'admin']);
?>

<div class="gallery-wrapper <?php echo e($isPatrollerOrAdmin ? 'pt-20' : 'pt-24'); ?>">
    <!-- Header -->
    <div class="gallery-header">
        <h1 class="gallery-title">Patrol Report Gallery</h1>
        <p class="gallery-subtitle">
            Explore detailed patrol reports and sightings from our conservation efforts
        </p>
    </div>

    <!-- Cards Stack Container -->
    <div class="cards-stack">
        <?php $__empty_1 = true; $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="report-card <?php echo e($index === 0 ? 'active' : ($index === 1 ? 'next' : '')); ?>" 
                 id="card-<?php echo e($index); ?>" 
                 data-index="<?php echo e($index); ?>">
                
                <div class="card-grid">
                    <!-- Image Gallery Section -->
                    <div class="image-gallery">
                        <!-- Main Image Container -->
                        <div class="main-image-container" onclick="openLightbox('<?php echo e(count($report['images']) > 0 ? asset('storage/' . $report['images'][0]) : ''); ?>')">
                            <?php if(count($report['images']) > 0): ?>
                                <img src="<?php echo e(asset('storage/' . $report['images'][0])); ?>" 
                                     alt="<?php echo e($report['title']); ?>" 
                                     class="main-image" 
                                     id="main-image-<?php echo e($index); ?>">
                                <div class="image-overlay"></div>
                                <div class="image-badge badge-<?php echo e(strtolower($report['report_type'])); ?>">
                                    <span><?php echo e(ucfirst($report['report_type'])); ?></span>
                                </div>
                                <div class="image-counter">
                                    <span id="image-counter-<?php echo e($index); ?>">1</span> / <?php echo e(count($report['images'])); ?>

                                </div>
                            <?php else: ?>
                                <div style="display: flex; align-items: center; justify-content: center; height: 100%; background: rgba(0,0,0,0.5);">
                                    <span style="color: #64748b; font-size: 1.125rem;">No Image Available</span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Thumbnail Strip -->
                        <?php if(count($report['images']) > 1): ?>
                            <div class="thumbnail-strip">
                                <?php $__currentLoopData = $report['images']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $imgIndex => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <img src="<?php echo e(asset('storage/' . $image)); ?>" 
                                         alt="Thumbnail <?php echo e($imgIndex + 1); ?>" 
                                         class="thumbnail <?php echo e($imgIndex === 0 ? 'active' : ''); ?>"
                                         onclick="changeMainImage(<?php echo e($index); ?>, <?php echo e($imgIndex); ?>, '<?php echo e(asset('storage/' . $image)); ?>')">
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Details Section -->
                    <div class="details-section">
                        <!-- Report Header -->
                        <div class="report-header">
                            <h2><?php echo e($report['title']); ?></h2>
                            <p class="report-description"><?php echo e($report['description']); ?></p>
                        </div>

                        <!-- Basic Information Block -->
                        <div class="info-block">
                            <div class="info-block-title">
                                <span>📋</span> Basic Information
                            </div>
                            
                            <div class="info-row">
                                <span class="info-label">📍 Location</span>
                                <span class="info-value"><?php echo e($report['location']); ?></span>
                            </div>
                            
                            <div class="info-row">
                                <span class="info-label">📅 Report Date</span>
                                <span class="info-value"><?php echo e($report['reported_at']); ?></span>
                            </div>
                            
                            <?php if($report['incident_datetime']): ?>
                                <div class="info-row">
                                    <span class="info-label">🕐 Incident Time</span>
                                    <span class="info-value"><?php echo e($report['incident_datetime']); ?></span>
                                </div>
                            <?php endif; ?>
                            
                            <div class="info-row">
                                <span class="info-label">👤 Reported By</span>
                                <span class="info-value"><?php echo e($report['reported_by']); ?></span>
                            </div>
                            
                            <?php if($report['weather_conditions']): ?>
                                <div class="info-row">
                                    <span class="info-label">🌤️ Weather</span>
                                    <span class="info-value"><?php echo e($report['weather_conditions']); ?></span>
                                </div>
                            <?php endif; ?>

                            <?php if($report['priority']): ?>
                                <div class="info-row">
                                    <span class="info-label">⚡ Priority</span>
                                    <span class="info-value"><?php echo e(ucfirst($report['priority'])); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Turtle Details Block -->
                        <?php if($report['turtle_species'] || $report['turtle_gender'] || $report['turtle_count'] || $report['egg_count'] || $report['turtle_condition']): ?>
                            <div class="info-block">
                                <div class="info-block-title">
                                    <span>🐢</span> Turtle Details
                                </div>
                                
                                <?php if($report['turtle_species']): ?>
                                    <div class="info-row">
                                        <span class="info-label">Species</span>
                                        <span class="info-value"><?php echo e($report['turtle_species']); ?></span>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if($report['turtle_gender']): ?>
                                    <div class="info-row">
                                        <span class="info-label">Gender</span>
                                        <span class="info-value"><?php echo e(ucfirst($report['turtle_gender'])); ?></span>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if($report['turtle_count']): ?>
                                    <div class="info-row">
                                        <span class="info-label">Count</span>
                                        <span class="info-value"><?php echo e($report['turtle_count']); ?></span>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if($report['egg_count']): ?>
                                    <div class="info-row">
                                        <span class="info-label">🥚 Egg Count</span>
                                        <span class="info-value"><?php echo e($report['egg_count']); ?></span>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if($report['turtle_condition']): ?>
                                    <div class="info-row">
                                        <span class="info-label">❤️ Condition</span>
                                        <span class="info-value"><?php echo e(ucfirst($report['turtle_condition'])); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <!-- Location Coordinates Block -->
                        <?php if($report['latitude'] && $report['longitude']): ?>
                            <div class="info-block">
                                <div class="info-block-title">
                                    <span>🗺️</span> Coordinates
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Latitude</span>
                                    <span class="info-value" style="font-family: 'Courier New', monospace;"><?php echo e($report['latitude']); ?></span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Longitude</span>
                                    <span class="info-value" style="font-family: 'Courier New', monospace;"><?php echo e($report['longitude']); ?></span>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Additional Notes Block -->
                        <?php if($report['additional_notes']): ?>
                            <div class="info-block">
                                <div class="info-block-title">
                                    <span>📝</span> Additional Notes
                                </div>
                                <p style="color: #cbd5e1; font-size: 0.875rem; line-height: 1.6; margin: 0;">
                                    <?php echo e($report['additional_notes']); ?>

                                </p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="empty-state">
                <div class="empty-state-icon">📸</div>
                <h3>No reports available yet</h3>
                <p>Check back soon for patrol reports with images</p>
            </div>
        <?php endif; ?>

        <!-- Navigation Buttons -->
        <?php if(count($reports) > 1): ?>
            <button class="nav-button prev" onclick="previousSlide()" aria-label="Previous slide">‹</button>
            <button class="nav-button next" onclick="nextSlide()" aria-label="Next slide">›</button>
            
            <!-- Swipe Hint for Mobile -->
            <div class="swipe-hint">
                <span>←</span> Swipe <span>→</span>
            </div>
        <?php endif; ?>
    </div>

    <!-- Progress Indicators -->
    <?php if(count($reports) > 0): ?>
        <div class="progress-container">
            <div class="progress-counter" id="progress-counter">
                1 / <?php echo e(count($reports)); ?>

            </div>
            
            <?php if(count($reports) > 1): ?>
                <div class="progress-dots" id="progress-dots">
                    <?php $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="progress-dot <?php echo e($index === 0 ? 'active' : ''); ?>" 
                             onclick="showSlide(<?php echo e($index); ?>)"
                             data-index="<?php echo e($index); ?>"></div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- Lightbox -->
    <div id="lightbox" class="lightbox" onclick="closeLightbox()">
        <div class="lightbox-content">
            <button class="lightbox-close" onclick="event.stopPropagation(); closeLightbox();" aria-label="Close lightbox">×</button>
            <img id="lightbox-image" class="lightbox-image" src="" alt="Full size image" onclick="event.stopPropagation()">
        </div>
    </div>
</div>

<script>
    // Carousel State
    let currentSlide = 0;
    const cards = document.querySelectorAll('.report-card');
    const progressDots = document.querySelectorAll('.progress-dot');
    const totalSlides = cards.length;
    let autoSwipeInterval;
    const AUTO_SWIPE_DELAY = 3000; // 3 seconds

    // Touch/Swipe Variables
    let touchStartX = 0;
    let touchEndX = 0;
    let isDragging = false;

    // Initialize Carousel
    function initCarousel() {
        if (totalSlides > 0) {
            showSlide(0);
            setupTouchEvents();
            startAutoSwipe();
        }
    }

    // Show Specific Slide
    function showSlide(index) {
        if (index < 0 || index >= totalSlides) return;

        // Remove all states
        cards.forEach((card, i) => {
            card.classList.remove('active', 'prev', 'next');
            
            // Set appropriate state
            if (i === index) {
                card.classList.add('active');
            } else if (i === (index - 1 + totalSlides) % totalSlides) {
                card.classList.add('prev');
            } else if (i === (index + 1) % totalSlides) {
                card.classList.add('next');
            }
        });

        // Update progress dots
        progressDots.forEach((dot, i) => {
            dot.classList.toggle('active', i === index);
        });

        // Update counter
        currentSlide = index;
        updateCounter();
        
        // Reset timer when manually changing slides
        resetAutoSwipe();
    }

    // Navigate to Next Slide
    function nextSlide() {
        const nextIndex = (currentSlide + 1) % totalSlides;
        showSlide(nextIndex);
    }

    // Navigate to Previous Slide
    function previousSlide() {
        const prevIndex = (currentSlide - 1 + totalSlides) % totalSlides;
        showSlide(prevIndex);
    }

    // Update Progress Counter
    function updateCounter() {
        const counter = document.getElementById('progress-counter');
        if (counter) {
            counter.textContent = `${currentSlide + 1} / ${totalSlides}`;
        }
    }

    // Change Main Image (Thumbnail Click)
    function changeMainImage(cardIndex, imageIndex, imageSrc) {
        const mainImage = document.getElementById(`main-image-${cardIndex}`);
        const imageCounter = document.getElementById(`image-counter-${cardIndex}`);
        const card = document.getElementById(`card-${cardIndex}`);
        
        if (!card) return;
        
        const thumbnails = card.querySelectorAll('.thumbnail');
        
        // Update main image
        if (mainImage) {
            mainImage.style.opacity = '0';
            setTimeout(() => {
                mainImage.src = imageSrc;
                mainImage.style.opacity = '1';
            }, 150);
        }
        
        // Update counter
        if (imageCounter) {
            imageCounter.textContent = imageIndex + 1;
        }
        
        // Update active thumbnail
        thumbnails.forEach((thumb, idx) => {
            thumb.classList.toggle('active', idx === imageIndex);
        });
    }

    // Setup Touch/Swipe Events
    function setupTouchEvents() {
        const cardsStack = document.querySelector('.cards-stack');
        if (!cardsStack) return;

        cardsStack.addEventListener('touchstart', handleTouchStart, { passive: true });
        cardsStack.addEventListener('touchmove', handleTouchMove, { passive: true });
        cardsStack.addEventListener('touchend', handleTouchEnd, { passive: true });

        // Mouse events for desktop dragging
        cardsStack.addEventListener('mousedown', handleMouseDown);
        cardsStack.addEventListener('mousemove', handleMouseMove);
        cardsStack.addEventListener('mouseup', handleMouseUp);
        cardsStack.addEventListener('mouseleave', handleMouseUp);
    }

    // Touch Handlers
    function handleTouchStart(e) {
        touchStartX = e.changedTouches[0].screenX;
        isDragging = true;
    }

    function handleTouchMove(e) {
        if (!isDragging) return;
        touchEndX = e.changedTouches[0].screenX;
    }

    function handleTouchEnd() {
        if (!isDragging) return;
        isDragging = false;
        handleSwipe();
    }

    // Mouse Handlers
    function handleMouseDown(e) {
        // Don't interfere with thumbnail clicks
        if (e.target.classList.contains('thumbnail') || 
            e.target.classList.contains('nav-button') ||
            e.target.classList.contains('progress-dot')) {
            return;
        }
        
        touchStartX = e.screenX;
        isDragging = true;
        e.preventDefault();
    }

    function handleMouseMove(e) {
        if (!isDragging) return;
        touchEndX = e.screenX;
    }

    function handleMouseUp() {
        if (!isDragging) return;
        isDragging = false;
        handleSwipe();
    }

    // Handle Swipe Gesture
    function handleSwipe() {
        const swipeThreshold = 50;
        const diff = touchStartX - touchEndX;

        if (Math.abs(diff) > swipeThreshold) {
            if (diff > 0) {
                // Swiped left - next slide
                nextSlide();
            } else {
                // Swiped right - previous slide
                previousSlide();
            }
        }

        // Reset
        touchStartX = 0;
        touchEndX = 0;
    }

    // Keyboard Navigation
    document.addEventListener('keydown', (e) => {
        // Don't interfere with lightbox
        if (document.getElementById('lightbox').classList.contains('active')) {
            return;
        }

        if (e.key === 'ArrowLeft') {
            previousSlide();
        } else if (e.key === 'ArrowRight') {
            nextSlide();
        } else if (e.key >= '1' && e.key <= '9') {
            const index = parseInt(e.key) - 1;
            if (index < totalSlides) {
                showSlide(index);
            }
        }
    });

    // Lightbox Functions
    function openLightbox(imageSrc) {
        if (!imageSrc) return;
        
        const lightbox = document.getElementById('lightbox');
        const lightboxImage = document.getElementById('lightbox-image');
        
        if (lightbox && lightboxImage) {
            lightboxImage.src = imageSrc;
            lightbox.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeLightbox() {
        const lightbox = document.getElementById('lightbox');
        if (lightbox) {
            lightbox.classList.remove('active');
            document.body.style.overflow = 'auto';
        }
    }

    // Close lightbox on Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeLightbox();
        }
    });

    // Initialize on DOM Load
    document.addEventListener('DOMContentLoaded', initCarousel);

    // Add smooth transition to main images
    document.addEventListener('DOMContentLoaded', () => {
        const mainImages = document.querySelectorAll('.main-image');
        mainImages.forEach(img => {
            img.style.transition = 'opacity 0.3s ease';
        });
    });

    // Auto Swipe Functions
    function startAutoSwipe() {
        if (totalSlides <= 1) return;
        
        stopAutoSwipe();
        autoSwipeInterval = setInterval(() => {
            nextSlide();
        }, AUTO_SWIPE_DELAY);
    }

    function stopAutoSwipe() {
        if (autoSwipeInterval) {
            clearInterval(autoSwipeInterval);
            autoSwipeInterval = null;
        }
    }

    function resetAutoSwipe() {
        stopAutoSwipe();
        startAutoSwipe();
    }

    // Stop auto swipe on interaction
    document.addEventListener('DOMContentLoaded', () => {
        const carouselContainer = document.querySelector('.carousel-container');
        if (carouselContainer) {
            carouselContainer.addEventListener('mouseenter', stopAutoSwipe);
            carouselContainer.addEventListener('mouseleave', startAutoSwipe);
            
            // Also handle touch events to pause
            carouselContainer.addEventListener('touchstart', stopAutoSwipe, { passive: true });
            carouselContainer.addEventListener('touchend', startAutoSwipe, { passive: true });
        }
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make(auth()->check() && in_array(auth()->user()->role, ['patroller', 'admin']) ? 'layouts.patroller' : 'layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Rayver\Desktop\my_app\resources\views/patrol-map-gallery.blade.php ENDPATH**/ ?>