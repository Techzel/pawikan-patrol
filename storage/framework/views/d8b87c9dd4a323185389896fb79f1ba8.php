<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900 pt-20">
    <!-- Header -->
    <div class="py-8 mb-8 mt-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-5xl font-bold text-white mb-4">📸 Gallery Reports</h1>
            <p class="text-blue-100 text-xl">Explore verified patrol reports with stunning visuals</p>
            <div class="flex items-center justify-center gap-4 mt-6">
                <div class="flex items-center gap-2 text-ocean-400">
                    <span class="animate-pulse">✅</span>
                    <span class="text-sm font-medium">Verified Reports</span>
                </div>
                <div class="w-1 h-1 bg-ocean-400 rounded-full"></div>
                <div class="flex items-center gap-2 text-ocean-400">
                    <span class="animate-bounce-slow">📷</span>
                    <span class="text-sm font-medium">Visual Documentation</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter and Stats Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-8">
        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <!-- Stats -->
                <div class="flex items-center gap-6">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-white" id="total-reports"><?php echo e(count($galleryReports)); ?></div>
                        <div class="text-sm text-blue-200">Total Reports</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green-400" id="total-images">0</div>
                        <div class="text-sm text-blue-200">Total Images</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-ocean-400" id="species-count">0</div>
                        <div class="text-sm text-blue-200">Species Found</div>
                    </div>
                </div>

                <!-- Filters -->
                <div class="flex flex-wrap gap-2">
                    <button class="filter-btn active" data-filter="all">
                        <span>🌊</span> All Reports
                    </button>
                    <button class="filter-btn" data-filter="incident">
                        <span>⚠️</span> Incidents
                    </button>
                    <button class="filter-btn" data-filter="sighting">
                        <span>👁️</span> Sightings
                    </button>
                    <button class="filter-btn" data-filter="nesting">
                        <span>🥚</span> Nesting
                    </button>
                    <button class="filter-btn" data-filter="rescue">
                        <span>🛟</span> Rescue
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Gallery Grid -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-8">
        <div id="gallery-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <?php $__currentLoopData = $galleryReports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="gallery-card" 
                 data-type="<?php echo e($report['report_type']); ?>" 
                 data-species="<?php echo e($report['turtle_species'] ?? 'unknown'); ?>"
                 data-priority="<?php echo e($report['priority']); ?>"
                 onclick="openReportModal(<?php echo e(json_encode($report)); ?>)">
                
                <!-- Image Container -->
                <div class="relative overflow-hidden rounded-t-2xl aspect-square bg-gradient-to-br from-ocean-600 to-blue-800">
                    <?php if(!empty($report['images']) && count($report['images']) > 0): ?>
                        <img src="<?php echo e(asset('storage/' . $report['images'][0])); ?>" 
                             alt="<?php echo e($report['title']); ?>" 
                             class="w-full h-full object-cover transition-transform duration-500 hover:scale-110"
                             loading="lazy">
                        
                        <?php if(count($report['images']) > 1): ?>
                            <div class="absolute top-3 right-3 bg-black/70 backdrop-blur-sm text-white px-2 py-1 rounded-full text-xs font-medium">
                                +<?php echo e(count($report['images']) - 1); ?> more
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center text-white/50">
                            <span class="text-4xl">📷</span>
                        </div>
                    <?php endif; ?>

                    <!-- Priority Badge -->
                    <div class="absolute top-3 left-3">
                        <span class="priority-badge priority-<?php echo e($report['priority']); ?>">
                            <?php echo e(strtoupper($report['priority'])); ?>

                        </span>
                    </div>

                    <!-- Verification Badge -->
                    <?php if($report['evidence_verified'] && $report['location_verified']): ?>
                        <div class="absolute bottom-3 right-3 bg-green-500/90 backdrop-blur-sm text-white px-2 py-1 rounded-full text-xs font-medium flex items-center gap-1">
                            <span>✓</span> Verified
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Card Content -->
                <div class="bg-white/10 backdrop-blur-sm rounded-b-2xl p-4 border-x border-b border-white/20">
                    <h3 class="text-lg font-bold text-white mb-2 line-clamp-2"><?php echo e($report['title']); ?></h3>
                    
                    <div class="space-y-2 mb-3">
                        <div class="flex items-center gap-2 text-sm text-blue-200">
                            <span>📍</span>
                            <span class="truncate"><?php echo e($report['location']); ?></span>
                        </div>
                        
                        <?php if($report['turtle_species']): ?>
                            <div class="flex items-center gap-2 text-sm text-green-300">
                                <span>🐢</span>
                                <span><?php echo e(ucwords(str_replace('_', ' ', $report['turtle_species']))); ?></span>
                            </div>
                        <?php endif; ?>
                        
                        <div class="flex items-center gap-2 text-sm text-gray-300">
                            <span>📅</span>
                            <span><?php echo e($report['reported_at']); ?></span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="text-xs text-blue-200">
                            By <?php echo e($report['reported_by']); ?>

                        </div>
                        <div class="report-type-badge type-<?php echo e($report['report_type']); ?>">
                            <?php echo e(ucfirst($report['report_type'])); ?>

                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <!-- Empty State -->
        <div id="empty-state" class="hidden text-center py-16">
            <div class="text-6xl mb-4">🔍</div>
            <h3 class="text-2xl font-bold text-white mb-2">No reports found</h3>
            <p class="text-blue-200">Try adjusting your filters to see more results.</p>
        </div>
    </div>
</div>

<!-- Report Detail Modal -->
<div id="report-modal" class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 hidden items-center justify-center p-4" style="display: none;">
    <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl max-w-4xl w-full max-h-[90vh] overflow-hidden border border-white/20">
        <!-- Modal Header -->
        <div class="flex items-center justify-between p-6 border-b border-white/20">
            <h2 id="modal-title" class="text-2xl font-bold text-white"></h2>
            <button onclick="closeReportModal()" class="text-white hover:text-red-400 text-2xl font-bold px-3 py-1 rounded hover:bg-red-500/20 transition-colors">
                &times;
            </button>
        </div>

        <!-- Modal Content -->
        <div class="flex flex-col lg:flex-row max-h-[calc(90vh-80px)]">
            <!-- Image Gallery -->
            <div class="lg:w-1/2 bg-black">
                <div id="modal-image-container" class="relative h-64 lg:h-full">
                    <!-- Images will be inserted here -->
                </div>
            </div>

            <!-- Report Details -->
            <div class="lg:w-1/2 p-6 overflow-y-auto">
                <div id="modal-content" class="space-y-4">
                    <!-- Content will be inserted here -->
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Gallery Card Styles */
.gallery-card {
    @apply cursor-pointer transform transition-all duration-300 hover:scale-105 hover:shadow-2xl;
    animation: fadeInUp 0.6s ease-out;
}

.gallery-card:hover {
    box-shadow: 0 20px 40px rgba(6, 182, 212, 0.3);
}

/* Priority Badges */
.priority-badge {
    @apply px-2 py-1 rounded-full text-xs font-bold backdrop-blur-sm;
}

.priority-high {
    @apply bg-red-500/90 text-white;
}

.priority-medium {
    @apply bg-orange-500/90 text-white;
}

.priority-low {
    @apply bg-green-500/90 text-white;
}

.priority-default {
    @apply bg-blue-500/90 text-white;
}

/* Report Type Badges */
.report-type-badge {
    @apply px-2 py-1 rounded-full text-xs font-medium;
}

.type-incident {
    @apply bg-red-500/20 text-red-300 border border-red-500/30;
}

.type-sighting {
    @apply bg-blue-500/20 text-blue-300 border border-blue-500/30;
}

.type-nesting {
    @apply bg-green-500/20 text-green-300 border border-green-500/30;
}

.type-rescue {
    @apply bg-orange-500/20 text-orange-300 border border-orange-500/30;
}

/* Filter Buttons */
.filter-btn {
    @apply px-4 py-2 rounded-lg bg-white/10 text-white border border-white/20 transition-all duration-300 hover:bg-white/20 flex items-center gap-2 text-sm font-medium;
}

.filter-btn.active {
    @apply bg-ocean-500/30 border-ocean-400/50 text-ocean-300;
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-bounce-slow {
    animation: bounce 2s infinite;
}

/* Line clamp utility */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Image Gallery Styles */
.image-nav-btn {
    @apply absolute top-1/2 transform -translate-y-1/2 bg-black/50 text-white p-2 rounded-full hover:bg-black/70 transition-colors z-10;
}

.image-indicators {
    @apply absolute bottom-4 left-1/2 transform -translate-x-1/2 flex gap-2;
}

.image-indicator {
    @apply w-2 h-2 rounded-full bg-white/50 cursor-pointer transition-colors;
}

.image-indicator.active {
    @apply bg-white;
}
</style>

<script>
// Gallery data
const galleryReports = <?php echo json_encode($galleryReports, 15, 512) ?>;
let filteredReports = [...galleryReports];

// Initialize gallery
document.addEventListener('DOMContentLoaded', function() {
    updateStats();
    setupFilters();
    
    // Add staggered animation to cards
    const cards = document.querySelectorAll('.gallery-card');
    cards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
    });
});

// Update statistics
function updateStats() {
    const totalImages = galleryReports.reduce((sum, report) => sum + (report.images ? report.images.length : 0), 0);
    const uniqueSpecies = new Set(galleryReports.map(report => report.turtle_species).filter(Boolean)).size;
    
    document.getElementById('total-images').textContent = totalImages;
    document.getElementById('species-count').textContent = uniqueSpecies;
}

// Setup filter functionality
function setupFilters() {
    const filterBtns = document.querySelectorAll('.filter-btn');
    
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Update active state
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            // Filter reports
            const filter = this.dataset.filter;
            filterReports(filter);
        });
    });
}

// Filter reports
function filterReports(filter) {
    const cards = document.querySelectorAll('.gallery-card');
    const emptyState = document.getElementById('empty-state');
    let visibleCount = 0;
    
    cards.forEach(card => {
        const shouldShow = filter === 'all' || card.dataset.type === filter;
        
        if (shouldShow) {
            card.style.display = 'block';
            card.style.animation = 'fadeInUp 0.6s ease-out';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });
    
    // Show/hide empty state
    if (visibleCount === 0) {
        emptyState.classList.remove('hidden');
    } else {
        emptyState.classList.add('hidden');
    }
    
    // Update total count
    document.getElementById('total-reports').textContent = visibleCount;
}

// Open report modal
function openReportModal(report) {
    const modal = document.getElementById('report-modal');
    const title = document.getElementById('modal-title');
    const imageContainer = document.getElementById('modal-image-container');
    const content = document.getElementById('modal-content');
    
    // Set title
    title.textContent = report.title;
    
    // Create image gallery
    if (report.images && report.images.length > 0) {
        imageContainer.innerHTML = createImageGallery(report.images);
    } else {
        imageContainer.innerHTML = `
            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-ocean-600 to-blue-800">
                <span class="text-6xl text-white/50">📷</span>
            </div>
        `;
    }
    
    // Create content
    content.innerHTML = createModalContent(report);
    
    // Show modal
    modal.style.display = 'flex';
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

// Close report modal
function closeReportModal() {
    const modal = document.getElementById('report-modal');
    modal.style.display = 'none';
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Create image gallery
function createImageGallery(images) {
    if (images.length === 1) {
        return `<img src="/storage/${images[0]}" alt="Report Image" class="w-full h-full object-cover">`;
    }
    
    let html = `
        <div class="relative w-full h-full">
            <div class="image-slider w-full h-full overflow-hidden">
    `;
    
    images.forEach((image, index) => {
        html += `
            <img src="/storage/${image}" 
                 alt="Report Image ${index + 1}" 
                 class="w-full h-full object-cover absolute inset-0 transition-opacity duration-300 ${index === 0 ? 'opacity-100' : 'opacity-0'}"
                 data-index="${index}">
        `;
    });
    
    if (images.length > 1) {
        html += `
            </div>
            <button class="image-nav-btn left-4" onclick="previousImage()">‹</button>
            <button class="image-nav-btn right-4" onclick="nextImage()">›</button>
            <div class="image-indicators">
        `;
        
        images.forEach((_, index) => {
            html += `<div class="image-indicator ${index === 0 ? 'active' : ''}" onclick="goToImage(${index})"></div>`;
        });
        
        html += '</div>';
    }
    
    html += '</div>';
    return html;
}

// Image navigation
let currentImageIndex = 0;
let totalImages = 0;

function previousImage() {
    const images = document.querySelectorAll('.image-slider img');
    totalImages = images.length;
    
    images[currentImageIndex].classList.remove('opacity-100');
    images[currentImageIndex].classList.add('opacity-0');
    
    currentImageIndex = (currentImageIndex - 1 + totalImages) % totalImages;
    
    images[currentImageIndex].classList.remove('opacity-0');
    images[currentImageIndex].classList.add('opacity-100');
    
    updateImageIndicators();
}

function nextImage() {
    const images = document.querySelectorAll('.image-slider img');
    totalImages = images.length;
    
    images[currentImageIndex].classList.remove('opacity-100');
    images[currentImageIndex].classList.add('opacity-0');
    
    currentImageIndex = (currentImageIndex + 1) % totalImages;
    
    images[currentImageIndex].classList.remove('opacity-0');
    images[currentImageIndex].classList.add('opacity-100');
    
    updateImageIndicators();
}

function goToImage(index) {
    const images = document.querySelectorAll('.image-slider img');
    
    images[currentImageIndex].classList.remove('opacity-100');
    images[currentImageIndex].classList.add('opacity-0');
    
    currentImageIndex = index;
    
    images[currentImageIndex].classList.remove('opacity-0');
    images[currentImageIndex].classList.add('opacity-100');
    
    updateImageIndicators();
}

function updateImageIndicators() {
    const indicators = document.querySelectorAll('.image-indicator');
    indicators.forEach((indicator, index) => {
        if (index === currentImageIndex) {
            indicator.classList.add('active');
        } else {
            indicator.classList.remove('active');
        }
    });
}

// Create modal content
function createModalContent(report) {
    return `
        <div class="space-y-4">
            <!-- Priority and Type -->
            <div class="flex items-center gap-3">
                <span class="priority-badge priority-${report.priority}">
                    ${report.priority.toUpperCase()} PRIORITY
                </span>
                <span class="report-type-badge type-${report.report_type}">
                    ${report.report_type.toUpperCase()}
                </span>
            </div>

            <!-- Description -->
            <div class="bg-white/5 rounded-lg p-4">
                <h4 class="text-white font-semibold mb-2">📝 Description</h4>
                <p class="text-gray-300">${report.description || 'No description provided'}</p>
            </div>

            <!-- Location and Date -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-white/5 rounded-lg p-4">
                    <h4 class="text-white font-semibold mb-2">📍 Location</h4>
                    <p class="text-gray-300">${report.location}</p>
                    ${report.latitude && report.longitude ? `
                        <p class="text-xs text-blue-300 mt-1">
                            ${report.latitude}°N, ${report.longitude}°E
                        </p>
                    ` : ''}
                </div>
                
                <div class="bg-white/5 rounded-lg p-4">
                    <h4 class="text-white font-semibold mb-2">📅 Date Reported</h4>
                    <p class="text-gray-300">${report.reported_at}</p>
                    <p class="text-xs text-blue-300 mt-1">By ${report.reported_by}</p>
                </div>
            </div>

            ${report.turtle_species || report.turtle_count || report.turtle_condition ? `
                <!-- Turtle Information -->
                <div class="bg-white/5 rounded-lg p-4">
                    <h4 class="text-white font-semibold mb-3">🐢 Turtle Information</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        ${report.turtle_species ? `
                            <div>
                                <div class="text-xs text-blue-300 mb-1">Species</div>
                                <div class="text-white">${report.turtle_species.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase())}</div>
                            </div>
                        ` : ''}
                        ${report.turtle_count ? `
                            <div>
                                <div class="text-xs text-blue-300 mb-1">Count</div>
                                <div class="text-white">${report.turtle_count}</div>
                            </div>
                        ` : ''}
                        ${report.turtle_condition ? `
                            <div>
                                <div class="text-xs text-blue-300 mb-1">Condition</div>
                                <div class="text-white">${report.turtle_condition.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase())}</div>
                            </div>
                        ` : ''}
                    </div>
                </div>
            ` : ''}

            ${report.weather_conditions ? `
                <!-- Weather Conditions -->
                <div class="bg-white/5 rounded-lg p-4">
                    <h4 class="text-white font-semibold mb-2">🌤️ Weather Conditions</h4>
                    <p class="text-gray-300">${report.weather_conditions}</p>
                </div>
            ` : ''}

            ${report.immediate_actions ? `
                <!-- Immediate Actions -->
                <div class="bg-white/5 rounded-lg p-4">
                    <h4 class="text-white font-semibold mb-2">⚡ Immediate Actions Taken</h4>
                    <p class="text-gray-300">${report.immediate_actions}</p>
                </div>
            ` : ''}

            ${report.recommendations ? `
                <!-- Recommendations -->
                <div class="bg-white/5 rounded-lg p-4">
                    <h4 class="text-white font-semibold mb-2">💡 Recommendations</h4>
                    <p class="text-gray-300">${report.recommendations}</p>
                </div>
            ` : ''}

            <!-- Verification Status -->
            <div class="bg-white/5 rounded-lg p-4">
                <h4 class="text-white font-semibold mb-3">✅ Verification Status</h4>
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2">
                        <span class="${report.evidence_verified ? 'text-green-400' : 'text-gray-400'}">
                            ${report.evidence_verified ? '✅' : '❌'}
                        </span>
                        <span class="text-sm text-gray-300">Evidence Verified</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="${report.location_verified ? 'text-green-400' : 'text-gray-400'}">
                            ${report.location_verified ? '✅' : '❌'}
                        </span>
                        <span class="text-sm text-gray-300">Location Verified</span>
                    </div>
                </div>
            </div>
        </div>
    `;
}

// Close modal on escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeReportModal();
    }
});

// Close modal on backdrop click
document.getElementById('report-modal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeReportModal();
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Rayver\Desktop\pawikan-patrol\my_app\resources\views/gallery-reports.blade.php ENDPATH**/ ?>