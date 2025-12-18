<?php if(auth()->check() && in_array(auth()->user()->role, ['patroller', 'admin'])): ?>
    <?php $__env->startSection('container-class', 'w-full max-w-none'); ?>
<?php endif; ?>

<?php $__env->startSection('bodyClass', 'map-page'); ?>

<?php $__env->startSection('content'); ?>
<div id="patrol-map-page">
<?php
    $isPatrollerOrAdmin = auth()->check() && in_array(auth()->user()->role, ['patroller', 'admin']);
    $mapHeight = $isPatrollerOrAdmin ? 'calc(100vh - 160px)' : 'calc(100vh - 140px)';
?>
<div class="min-h-screen bg-gray-900 <?php echo e($isPatrollerOrAdmin ? '' : 'pt-20'); ?>">
    <!-- Header -->
    <div class="py-4 mb-4 <?php echo e($isPatrollerOrAdmin ? '' : 'mt-4'); ?>">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-bold text-green-400 mb-3" style="font-family: 'Poppins', sans-serif;">Pawikan Patrol Map</h1>
        </div>
    </div>

    <!-- Map and Sidebar Container -->
    <div class="flex flex-col lg:flex-row mx-4 mb-4 gap-4">
        <!-- Map Container -->
        <div class="relative flex-1 rounded-lg overflow-hidden shadow-2xl">
            <div id="map" style="height: <?php echo e($mapHeight); ?>; width: 100%;"></div>
            
            <!-- Loading Overlay -->
            <div id="loading" class="absolute inset-0 bg-slate-900/95 backdrop-blur-md flex items-center justify-center transition-opacity duration-500" style="z-index: 1000;">
                <div class="text-center">
                    <div class="animate-spin rounded-full h-16 w-16 border-4 border-green-500 border-t-transparent mx-auto mb-4"></div>
                    <p class="text-green-400 font-bold uppercase tracking-widest text-sm" style="font-family: 'Cinzel', serif;">Locating Patrol Reports...</p>
                </div>
            </div>
        </div>

        <!-- Right Sidebar -->
        <div id="report-sidebar" class="w-full lg:w-96 bg-white/10 backdrop-blur-sm rounded-lg shadow-2xl border border-white/20 hidden sidebar-container" style="height: <?php echo e($mapHeight); ?>;">
            <div class="p-4 h-full overflow-y-auto">
                <!-- Close Button -->
                <div class="flex justify-between items-center mb-3">
                    <h3 class="text-lg font-bold text-green-400">Report Details</h3>
                    <button id="close-sidebar" class="text-white hover:text-red-400 text-xl font-bold px-2 py-1 rounded hover:bg-red-500/20 transition-colors">&times;</button>
                </div>
                
                <!-- Report Content -->
                <div id="sidebar-content" class="text-white">
                    <p class="text-gray-300">Click on a report marker to view details</p>
                </div>
            </div>
        </div>
    </div>

</div>

<style>
.leaflet-control-fullscreen {
    background-color: white;
    border: 2px solid rgba(0,0,0,0.2);
    border-radius: 4px;
    box-shadow: 0 1px 5px rgba(0,0,0,0.4);
    margin-top: 10px !important;
}

.leaflet-control-fullscreen a {
    background-color: white;
    color: #333;
    font-size: 18px;
    line-height: 30px;
    text-align: center;
    text-decoration: none;
    display: block;
    width: 30px;
    height: 30px;
}

.leaflet-control-fullscreen a:hover {
    background-color: #f4f4f4;
    color: #000;
}

.leaflet-control-fullscreen-button:before {
    content: "⛶";
    font-size: 16px;
}

.leaflet-control-fullscreen-button.leaflet-fullscreen-on:before {
    content: "⛷";
}

/* Layer control styling */
.leaflet-control-layers {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.leaflet-control-layers-toggle {
    background-color: white;
    border-radius: 6px;
    width: 32px !important;
    height: 32px !important;
    background-size: 20px 20px !important;
}

/* Fullscreen sidebar support */
.leaflet-fullscreen-on .sidebar-container {
    position: fixed !important;
    top: 20px !important;
    right: 20px !important;
    width: 400px !important;
    height: calc(100vh - 40px) !important;
    z-index: 10000 !important;
    max-height: calc(100vh - 40px) !important;
    background: rgba(0, 0, 0, 0.85) !important;
    backdrop-filter: blur(15px) !important;
    border: 2px solid rgba(255, 255, 255, 0.3) !important;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5) !important;
    display: block !important;
    visibility: visible !important;
    opacity: 1 !important;
}

/* Ensure sidebar is visible when not hidden in fullscreen */
.leaflet-fullscreen-on .sidebar-container:not(.hidden) {
    display: block !important;
    visibility: visible !important;
    opacity: 1 !important;
}

.leaflet-fullscreen-on .sidebar-container .p-4 {
    padding: 1.5rem !important;
}

/* Responsive fullscreen sidebar */
@media (max-width: 768px) {
    .leaflet-fullscreen-on .sidebar-container {
        width: calc(100vw - 40px) !important;
        height: 50vh !important;
        top: auto !important;
        bottom: 20px !important;
        max-height: 50vh !important;
    }
}

/* Enhanced sidebar styling */
.sidebar-container {
    transition: all 0.3s ease-in-out;
}

.sidebar-container:not(.hidden) {
    animation: slideIn 0.3s ease-out;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateX(100%);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* Fullscreen map container adjustments */
.leaflet-fullscreen-on {
    background: #1e293b !important;
}

/* Better scrollbar for sidebar */
.sidebar-container .overflow-y-auto::-webkit-scrollbar {
    width: 6px;
}

.sidebar-container .overflow-y-auto::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 3px;
}

.sidebar-container .overflow-y-auto::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.3);
    border-radius: 3px;
}

.sidebar-container .overflow-y-auto::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.5);
}

/* Enforce Poppins for report details sidebar */
#sidebar-content,
#sidebar-content * {
    font-family: 'Poppins', sans-serif !important;
    letter-spacing: 0.01em;
}
</style>

<script>
    (function() {
        const validatedReports = <?php echo json_encode($validatedReports, 15, 512) ?>;
        const HATCHERY_COORDS = [6.923881032515973, 126.28094149117992];
        const CUSTOM_MARKER_ICON = "<?php echo e(asset('img/marker.png')); ?>";
        let mapInstance = null;

        function hideLoading() {
            const loading = document.getElementById('loading');
            if (loading) {
                loading.style.opacity = '0';
                setTimeout(() => {
                    loading.style.display = 'none';
                }, 500);
            }
        }

        function createIcon() {
            return L.icon({
                iconUrl: CUSTOM_MARKER_ICON,
                iconSize: [72, 72],
                iconAnchor: [24, 72],
                popupAnchor: [0, -68],
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
                shadowSize: [41, 41]
            });
        }

        function getPriorityBadgeClass(priority) {
            switch(priority) {
                case 'high': return 'bg-red-500/20 text-red-300 border border-red-500/30';
                case 'medium': return 'bg-yellow-500/20 text-yellow-300 border border-yellow-500/30';
                case 'low': return 'bg-green-500/20 text-green-300 border border-green-500/30';
                default: return 'bg-blue-500/20 text-blue-300 border border-blue-500/30';
            }
        }

        function createSidebarContent(report) {
            const images = report.images && Array.isArray(report.images) ? report.images : [];
            const imagesHtml = images.length > 0 ? `
                <div class="mb-4">
                    <h4 class="font-medium text-white mb-2 text-sm">📸 Report Images</h4>
                    <div class="grid grid-cols-2 gap-2">
                        ${images.map((image, index) => {
                            const imgSrc = image.startsWith('data:') ? image : '/storage/' + image;
                            return `
                                <div class="relative group cursor-pointer" onclick="openImageModal('${image}')">
                                    <img src="${imgSrc}" alt="Report Image ${index + 1}" 
                                         class="w-full h-16 object-cover rounded border border-white/20 hover:border-white/40 transition-all">
                                    <div class="absolute inset-0 bg-black/0 hover:bg-black/20 rounded transition-all flex items-center justify-center">
                                        <span class="text-white opacity-0 group-hover:opacity-100 text-xs">🔍</span>
                                    </div>
                                </div>
                            `;
                        }).join('')}
                    </div>
                </div>
            ` : '';

            return `
                <div class="space-y-3" style="font-family: 'Poppins', sans-serif;">
                    <div class="border-b border-white/20 pb-2">
                        <h2 class="text-lg font-bold text-white leading-tight">${report.title || 'Patrol Report'}</h2>
                        <div class="flex items-center mt-1">
                            <span class="px-2 py-1 rounded-full text-xs font-medium ${getPriorityBadgeClass(report.priority)}">
                                ${(report.priority || 'default').toUpperCase()}
                            </span>
                        </div>
                    </div>
                    ${imagesHtml}
                    <div class="space-y-2">
                        <div class="grid grid-cols-1 gap-2">
                            <div class="bg-white/5 rounded p-2">
                                <div class="text-green-300 text-xs font-medium">📍 Location</div>
                                <div class="text-white text-sm">${report.location || 'Not specified'}</div>
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div class="bg-white/5 rounded p-2">
                                    <div class="text-green-300 text-xs font-medium">📋 Type</div>
                                    <div class="text-white text-sm capitalize">${report.report_type || 'Not specified'}</div>
                                </div>
                                <div class="bg-white/5 rounded p-2">
                                    <div class="text-green-300 text-xs font-medium">📅 Date</div>
                                    <div class="text-white text-xs">${report.incident_datetime || 'Not specified'}</div>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div class="bg-white/5 rounded p-2">
                                    <div class="text-green-300 text-xs font-medium">🐢 Species</div>
                                    <div class="text-white text-sm capitalize">${(report.turtle_species || 'Not specified').replace('_', ' ')}</div>
                                </div>
                                <div class="bg-white/5 rounded p-2">
                                    <div class="text-green-300 text-xs font-medium">🔢 Count</div>
                                    <div class="text-white text-sm">${report.turtle_count || 'Unknown'}</div>
                                </div>
                            </div>
                            <div class="bg-white/5 rounded p-2">
                                <div class="text-green-300 text-xs font-medium">👤 Reported By</div>
                                <div class="text-white text-sm">${report.reported_by || 'Unknown'}</div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }

        window.openImageModal = function(imagePath) {
            const imgSrc = imagePath.startsWith('data:') ? imagePath : '/storage/' + imagePath;
            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 bg-black/80 flex items-center justify-center z-[10001]';
            modal.innerHTML = `
                <div class="relative max-w-4xl max-h-full p-4">
                    <img src="${imgSrc}" alt="Report Image" class="max-w-full max-h-full rounded-lg">
                    <button onclick="this.parentElement.parentElement.remove()" 
                            class="absolute top-2 right-2 text-white bg-black/50 rounded-full w-8 h-8 flex items-center justify-center hover:bg-black/70">
                        ×
                    </button>
                </div>
            `;
            modal.onclick = (e) => { if(e.target === modal) modal.remove(); };
            document.body.appendChild(modal);
        };

        function showReportInSidebar(report) {
            const sidebar = document.getElementById('report-sidebar');
            const content = document.getElementById('sidebar-content');
            if (content) content.innerHTML = createSidebarContent(report);
            if (sidebar) sidebar.classList.remove('hidden');
        }

        window.closeSidebar = function() {
            const sidebar = document.getElementById('report-sidebar');
            if (sidebar) sidebar.classList.add('hidden');
        };

        function initializeMap() {
            const mapContainer = document.getElementById('map');
            if (!mapContainer || !window.L) return;

            // Cleanup existing instance
            if (mapInstance) {
                mapInstance.remove();
                mapInstance = null;
            }

            try {
                const googleHybrid = L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}', {
                    maxZoom: 20,
                    subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
                    attribution: '© Google Maps'
                });

                mapInstance = L.map('map', {
                    center: HATCHERY_COORDS,
                    zoom: 14,
                    layers: [googleHybrid],
                    zoomControl: true,
                    maxBounds: [[6.893881, 126.250941], [6.953881, 126.310941]]
                });

                // Hide loading overlay as map is now initialized
                hideLoading();

                if (window.L.MarkerClusterGroup) {
                    const markerCluster = L.markerClusterGroup();
                    validatedReports.forEach(report => {
                        if (report.latitude && report.longitude) {
                            const marker = L.marker([report.latitude, report.longitude], { icon: createIcon() });
                            marker.on('click', () => showReportInSidebar(report));
                            markerCluster.addLayer(marker);
                        }
                    });
                    mapInstance.addLayer(markerCluster);
                    if (markerCluster.getLayers().length > 0) {
                        mapInstance.fitBounds(markerCluster.getBounds().pad(0.1));
                    }
                }

                const closeBtn = document.getElementById('close-sidebar');
                if (closeBtn) closeBtn.onclick = window.closeSidebar;

                // Add Fullscreen control if plugin exists
                if (L.Control.Fullscreen) {
                    new L.Control.Fullscreen({ position: 'topleft' }).addTo(mapInstance);
                }

                // Force resize check
                setTimeout(() => mapInstance.invalidateSize(), 50);

            } catch (error) {
                console.error('Leaflet Init Error:', error);
                hideLoading();
            }
        }

        document.addEventListener('turbo:load', function() {
            if (document.getElementById('map')) {
                // Initialize map immediately for better performance
                initializeMap();
            }
        });
        
        // Handle window resize
        window.addEventListener('resize', () => {
            if (mapInstance) mapInstance.invalidateSize();
        });
    })();
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make(auth()->check() && in_array(auth()->user()->role, ['patroller', 'admin']) ? 'layouts.patroller' : 'layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Rayver\Desktop\my_app\resources\views/patrol-map.blade.php ENDPATH**/ ?>