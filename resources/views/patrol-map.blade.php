@extends(auth()->check() && in_array(auth()->user()->role, ['patroller', 'admin']) ? 'layouts.patroller' : 'layouts.app')

@if(auth()->check() && in_array(auth()->user()->role, ['patroller', 'admin']))
    @section('container-class', 'w-full max-w-none')
@endif

@section('content')
<div id="patrol-map-page">
@php
    $isPatrollerOrAdmin = auth()->check() && in_array(auth()->user()->role, ['patroller', 'admin']);
    $mapHeight = $isPatrollerOrAdmin ? 'calc(100vh - 160px)' : 'calc(100vh - 140px)';
@endphp
<div class="min-h-screen bg-gray-900 {{ $isPatrollerOrAdmin ? '' : 'pt-20' }}">
    <!-- Header -->
    <div class="py-4 mb-4 {{ $isPatrollerOrAdmin ? '' : 'mt-4' }}">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-bold text-green-400 mb-3" style="font-family: 'Poppins', sans-serif;">Pawikan Patrol Map</h1>
        </div>
    </div>

    <!-- Map and Sidebar Container -->
    <div class="flex flex-col lg:flex-row mx-4 mb-4 gap-4">
        <!-- Map Container -->
        <div class="relative flex-1 rounded-lg overflow-hidden shadow-2xl">
            <div id="map" style="height: {{ $mapHeight }}; width: 100%;"></div>
            
            <!-- Loading Overlay -->
            <div id="loading" class="absolute inset-0 bg-black/50 flex items-center justify-center" style="z-index: 1000;">
                <div class="bg-white rounded-lg p-6 text-center">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto mb-4"></div>
                    <p class="text-gray-700">Loading patrol map...</p>
                </div>
            </div>
        </div>

        <!-- Right Sidebar -->
        <div id="report-sidebar" class="w-full lg:w-96 bg-white/10 backdrop-blur-sm rounded-lg shadow-2xl border border-white/20 hidden sidebar-container" style="height: {{ $mapHeight }};">
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

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<!-- Leaflet MarkerCluster CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css" />

<!-- Leaflet Fullscreen Plugin CSS -->
<link rel="stylesheet" href="https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/leaflet.fullscreen.css" />

<!-- Custom CSS for fullscreen control -->
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

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<!-- Leaflet Fullscreen Plugin JS -->
<script src="https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/Leaflet.fullscreen.min.js"></script>

<!-- Leaflet MarkerCluster JS -->
<script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>

<script>
// Patrol reports data from server
const validatedReports = @json($validatedReports);

// Map configuration
const HATCHERY_COORDS = [6.923881032515973, 126.28094149117992];
let map = null;

// Priority colors and single custom icon
const PRIORITY_COLORS = {
    high: '#dc2626',
    medium: '#f59e0b', 
    low: '#16a34a',
    default: '#3b82f6'
};

const CUSTOM_MARKER_ICON = "{{ asset('img/marker.png') }}";

function hideLoading() {
    document.getElementById('loading').style.display = 'none';
}

function showError() {
    document.getElementById('loading').style.display = 'none';
    console.error('Map initialization failed, but continuing without error popup');
}

function createIcon(priority) {
    return L.icon({
        iconUrl: CUSTOM_MARKER_ICON,
        iconSize: [72, 72],
        iconAnchor: [24, 72],
        popupAnchor: [0, -68],
        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
        shadowSize: [41, 41]
    });
}

function createSidebarContent(report) {
    const images = report.images && Array.isArray(report.images) ? report.images : [];
    const imagesHtml = images.length > 0 ? `
        <div class="mb-4">
            <h4 class="font-medium text-white mb-2 text-sm">📸 Report Images</h4>
            <div class="grid grid-cols-2 gap-2">
                ${images.map((image, index) => `
                    <div class="relative group cursor-pointer" onclick="openImageModal('${image}')">
                        <img src="/storage/${image}" alt="Report Image ${index + 1}" 
                             class="w-full h-16 object-cover rounded border border-white/20 hover:border-white/40 transition-all">
                        <div class="absolute inset-0 bg-black/0 hover:bg-black/20 rounded transition-all flex items-center justify-center">
                            <span class="text-white opacity-0 group-hover:opacity-100 text-xs">🔍</span>
                        </div>
                    </div>
                `).join('')}
            </div>
        </div>
    ` : '';

    return `
        <div class="space-y-3" style="font-family: 'Poppins', sans-serif;">
            <!-- Title -->
            <div class="border-b border-white/20 pb-2">
                <h2 class="text-lg font-bold text-white leading-tight">${report.title || 'Patrol Report'}</h2>
                <div class="flex items-center mt-1">
                    <span class="px-2 py-1 rounded-full text-xs font-medium ${getPriorityBadgeClass(report.priority)}">
                        ${(report.priority || 'default').toUpperCase()}
                    </span>
                </div>
            </div>

            ${imagesHtml}

            <!-- Report Details -->
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

                    ${(report.turtle_gender || report.egg_count !== null && report.egg_count !== undefined) ? `
                        <div class="grid grid-cols-2 gap-2">
                            ${report.turtle_gender ? `
                                <div class="bg-white/5 rounded p-2">
                                    <div class="text-green-300 text-xs font-medium">🚻 Gender</div>
                                    <div class="text-white text-sm capitalize">${report.turtle_gender}</div>
                                </div>
                            ` : ''}
                            ${(report.egg_count !== null && report.egg_count !== undefined) ? `
                                <div class="bg-white/5 rounded p-2">
                                    <div class="text-green-300 text-xs font-medium">🥚 Egg Count</div>
                                    <div class="text-white text-sm">${report.egg_count.toLocaleString()}</div>
                                </div>
                            ` : ''}
                        </div>
                    ` : ''}

                    <div class="bg-white/5 rounded p-2">
                        <div class="text-green-300 text-xs font-medium">💊 Condition</div>
                        <div class="text-white text-sm capitalize">${report.turtle_condition || 'Not specified'}</div>
                    </div>

                    ${report.description ? `
                        <div class="bg-white/5 rounded p-2">
                            <div class="text-green-300 text-xs font-medium">📝 Description</div>
                            <div class="text-white text-xs leading-relaxed mt-1">${report.description}</div>
                        </div>
                    ` : ''}

                    <div class="bg-white/5 rounded p-2">
                        <div class="text-green-300 text-xs font-medium">👤 Reported By</div>
                        <div class="text-white text-sm">${report.reported_by || 'Unknown'}</div>
                        ${report.reported_at ? `<div class="text-gray-300 text-xs mt-1">Submitted: ${report.reported_at}</div>` : ''}
                    </div>
                </div>
            </div>
        </div>
    `;
}

function getPriorityBadgeClass(priority) {
    switch(priority) {
        case 'high': return 'bg-red-500/20 text-red-300 border border-red-500/30';
        case 'medium': return 'bg-yellow-500/20 text-yellow-300 border border-yellow-500/30';
        case 'low': return 'bg-green-500/20 text-green-300 border border-green-500/30';
        default: return 'bg-blue-500/20 text-blue-300 border border-blue-500/30';
    }
}

function showReportInSidebar(report) {
    const sidebar = document.getElementById('report-sidebar');
    const content = document.getElementById('sidebar-content');
    
    content.innerHTML = createSidebarContent(report);
    sidebar.classList.remove('hidden');
    
    // Ensure sidebar is visible in fullscreen mode
    const isFullscreen = document.fullscreenElement || document.webkitFullscreenElement || document.mozFullScreenElement || document.msFullscreenElement;
    if (isFullscreen) {
        // Force display and positioning for fullscreen
        sidebar.style.display = 'block';
        sidebar.style.visibility = 'visible';
        sidebar.style.opacity = '1';
        
        // Add a small delay to ensure proper rendering
        setTimeout(() => {
            sidebar.style.transform = 'translateZ(0)';
        }, 50);
    } else {
        // Reset styles for normal mode
        sidebar.style.display = '';
        sidebar.style.visibility = '';
        sidebar.style.opacity = '';
        sidebar.style.transform = '';
    }
}

function closeSidebar() {
    const sidebar = document.getElementById('report-sidebar');
    sidebar.classList.add('hidden');
    
    // Reset all inline styles when closing
    sidebar.style.display = '';
    sidebar.style.visibility = '';
    sidebar.style.opacity = '';
    sidebar.style.transform = '';
}

function openImageModal(imagePath) {
    // Create modal overlay
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 bg-black/80 flex items-center justify-center z-50';
    modal.innerHTML = `
        <div class="relative max-w-4xl max-h-full p-4">
            <img src="/storage/${imagePath}" alt="Report Image" class="max-w-full max-h-full rounded-lg">
            <button onclick="this.parentElement.parentElement.remove()" 
                    class="absolute top-2 right-2 text-white bg-black/50 rounded-full w-8 h-8 flex items-center justify-center hover:bg-black/70">
                ×
            </button>
        </div>
    `;
    
    // Close on click outside
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.remove();
        }
    });
    
    document.body.appendChild(modal);
}

// Fullscreen event handlers
function handleFullscreenEnter() {
    const sidebar = document.getElementById('report-sidebar');
    if (sidebar && !sidebar.classList.contains('hidden')) {
        // Sidebar is visible, ensure it stays visible in fullscreen
        sidebar.style.display = 'block';
        sidebar.style.visibility = 'visible';
        sidebar.style.opacity = '1';
        
        // Add a small delay to ensure fullscreen transition is complete
        setTimeout(() => {
            // Force a repaint to ensure proper positioning
            sidebar.style.transform = 'translateZ(0)';
        }, 100);
    }
}

function handleFullscreenExit() {
    const sidebar = document.getElementById('report-sidebar');
    if (sidebar) {
        // Reset any inline styles that might interfere with normal layout
        sidebar.style.transform = '';
        sidebar.style.visibility = '';
        sidebar.style.opacity = '';
        
        // Ensure sidebar maintains its visibility state
        if (!sidebar.classList.contains('hidden')) {
            sidebar.style.display = 'block';
        } else {
            sidebar.style.display = '';
        }
    }
}

function initializeMap() {
    try {
        console.log('Initializing map...');
        
        // Google Maps Layers
        const googleStreets = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
            attribution: '© Google Maps'
        });

        const googleHybrid = L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
            attribution: '© Google Maps'
        });

        const googleTerrain = L.tileLayer('http://{s}.google.com/vt/lyrs=p&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
            attribution: '© Google Maps'
        });

        // Create map with default satellite layer
        map = L.map('map', {
            center: HATCHERY_COORDS,
            zoom: 14,
            layers: [googleHybrid],
            zoomControl: false,
            maxBounds: [
                [6.893881, 126.250941], // Southwest corner
                [6.953881, 126.310941]  // Northeast corner
            ],
            maxBoundsViscosity: 1.0 // Prevent dragging outside bounds
        });
        
        // Add zoom control to top-left (above fullscreen)
        L.control.zoom({
            position: 'topleft'
        }).addTo(map);

        const baseLayers = {
            "Street": googleStreets,
            "Satelite": googleHybrid,
            "Terrain": googleTerrain
        };
        
        // Add layer control (collapsed for cleaner view)
        L.control.layers(baseLayers, null, {
            position: 'topright',
            collapsed: true
        }).addTo(map);
        
        // Add fullscreen control
        L.control.fullscreen({
            position: 'topleft',
            title: 'Enter fullscreen mode',
            titleCancel: 'Exit fullscreen mode',
            content: null,
            forceSeparateButton: true,
            forcePseudoFullscreen: true,
            fullscreenElement: false
        }).addTo(map);
        
        // Add Dahican area indicator
        const dahicanCircle = L.circle(HATCHERY_COORDS, {
            color: '#2dd4bf',
            fillColor: '#2dd4bf',
            fillOpacity: 0.15,
            radius: 2000, // 2km radius around the hatchery
            weight: 2,
            opacity: 0.6
        }).addTo(map);
        
        // Add patrol report markers
        if (validatedReports && validatedReports.length > 0) {
            console.log(`Adding ${validatedReports.length} patrol reports to map`);

            const markerCluster = L.markerClusterGroup({
                spiderfyOnMaxZoom: true,
                showCoverageOnHover: false,
                maxClusterRadius: 50
            });
            
            validatedReports.forEach(report => {
                if (report.latitude && report.longitude) {
                    const marker = L.marker([report.latitude, report.longitude], {
                        icon: createIcon(report.priority)
                    });
                    
                    marker.on('click', function() {
                        showReportInSidebar(report);
                    });

                    markerCluster.addLayer(marker);
                }
            });

            if (markerCluster.getLayers().length > 0) {
                map.addLayer(markerCluster);
                map.fitBounds(markerCluster.getBounds().pad(0.1));
            } else {
                map.setView(HATCHERY_COORDS, 12);
            }
        } else {
            console.log('No validated reports found, showing default map view');
        }
        
        hideLoading();
        
        // Add sidebar close button event listener
        document.getElementById('close-sidebar').addEventListener('click', closeSidebar);
        
        // Add fullscreen event listeners for sidebar management
        map.on('enterFullscreen', function() {
            console.log('Entered fullscreen mode');
            handleFullscreenEnter();
        });
        
        map.on('exitFullscreen', function() {
            console.log('Exited fullscreen mode');
            handleFullscreenExit();
        });
        
        console.log('Map initialized successfully');
        
        // Force map to render properly
        setTimeout(function() {
            if (map) {
                map.invalidateSize();
                console.log('Map size invalidated for proper rendering');
            }
        }, 250);
        
    } catch (error) {
        console.error('Error initializing map:', error);
        showError();
    }
}

// Initialize when page loads
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, initializing map...');
    // Wait for CSS to load before initializing map
    setTimeout(initializeMap, 500);
});

// Backup initialization
window.addEventListener('load', function() {
    if (!map) {
        console.log('Backup initialization...');
        setTimeout(initializeMap, 1000);
    }
});

// Force map resize after window resize
window.addEventListener('resize', function() {
    if (map) {
        setTimeout(function() {
            map.invalidateSize();
        }, 100);
    }
});
</script>
@endsection
