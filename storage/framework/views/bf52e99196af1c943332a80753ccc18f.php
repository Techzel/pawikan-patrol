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
<div class="<?php echo e($isPatrollerOrAdmin ? '' : 'pt-20'); ?>">
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
                    <p class="text-green-400 font-bold uppercase tracking-widest text-sm" style="font-family: 'Poppins', sans-serif;">Locating Patrol Reports...</p>
                </div>
            </div>

            <!-- Analytics Toggle Button -->
            <?php if(isset($stats)): ?>
            <button id="analytics-toggle" class="absolute top-4 right-4 bg-emerald-600 hover:bg-emerald-500 text-white rounded-lg p-2 shadow-lg transition-all duration-300 flex items-center group overflow-hidden hover:scale-105 active:scale-95 shadow-emerald-500/10 hover:shadow-emerald-500/20" style="z-index: 900;" title="Report Summary">
                <span class="text-lg group-hover:scale-110 transition-transform flex-shrink-0">📊</span>
                <span class="max-w-0 group-hover:max-w-xs opacity-0 group-hover:opacity-100 transition-all duration-500 ease-in-out whitespace-nowrap ml-0 group-hover:ml-2 font-bold text-sm">Report Summary</span>
            </button>

            <!-- Analytics Dashboard Panel -->
            <div id="analytics-panel" class="absolute top-4 right-4 w-96 max-h-[calc(100%-2rem)] transform translate-x-[120%] transition-all duration-500 cubic-bezier(0.4, 0, 0.2, 1) bg-slate-900/95 backdrop-blur-xl border border-white/10 rounded-2xl shadow-2xl shadow-black/50 overflow-hidden flex flex-col" style="z-index: 950;">
                
                <!-- Decorative Top Gradient -->
                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-emerald-500 via-teal-400 to-cyan-500"></div>

                <!-- Header -->
                <div class="p-5 flex items-center justify-between border-b border-white/5 bg-white/5 backdrop-blur-sm flex-shrink-0 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/10 to-transparent pointer-events-none"></div>
                    <div class="flex items-center gap-3 relative z-10">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center shadow-lg shadow-emerald-500/20">
                            <span class="text-xl">📊</span>
                        </div>
                        <div>
                            <h3 class="text-white font-bold text-lg tracking-tight" style="font-family: 'Poppins', sans-serif;">Report Summary</h3>
                            <p class="text-emerald-400/80 text-xs font-medium uppercase tracking-wider"><?php echo e($stats['last_updated']); ?></p>
                        </div>
                    </div>
                    <button id="close-analytics" class="relative z-10 text-slate-400 hover:text-white hover:bg-white/10 rounded-lg p-2 transition-all duration-300 group">
                        <svg class="w-5 h-5 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="p-5 space-y-6 flex-1 overflow-y-auto min-h-0 custom-scrollbar">
                    
                    <!-- Quick Stats Grid -->
                    <div class="grid grid-cols-2 gap-3">
                        <?php $__currentLoopData = [
                            ['label' => 'This Week', 'value' => $stats['weekly'], 'icon' => '📅'],
                            ['label' => 'This Month', 'value' => $stats['monthly'], 'icon' => '🗓️'],
                            ['label' => 'This Year', 'value' => $stats['yearly'], 'icon' => '📆'],
                            ['label' => 'All Time', 'value' => $stats['total'], 'icon' => '📚']
                        ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="bg-white/5 hover:bg-emerald-500/10 border border-white/5 hover:border-emerald-500/40 rounded-2xl p-4 transition-all duration-300 hover:-translate-y-1 hover:scale-[1.03] hover:shadow-[0_20px_40px_rgba(0,0,0,0.3),0_0_20px_rgba(16,185,129,0.2)] group relative overflow-hidden cursor-pointer">
                            <div class="absolute -right-4 -top-4 text-6xl opacity-5 group-hover:opacity-10 transition-opacity rotate-12 select-none">
                                <?php echo e($stat['icon']); ?>

                            </div>
                            <div class="text-slate-400 text-xs font-medium uppercase tracking-wider mb-1 flex items-center gap-2 group-hover:text-emerald-300 transition-colors">
                                <?php echo e($stat['label']); ?>

                            </div>
                            <div class="flex items-baseline gap-1">
                                <span class="text-3xl font-bold bg-gradient-to-r from-white to-slate-400 group-hover:from-white group-hover:to-emerald-400 bg-clip-text text-transparent counter-up transition-all duration-500" data-target="<?php echo e($stat['value']); ?>">0</span>
                                <span class="text-xs text-emerald-500 font-medium group-hover:text-emerald-400 transition-colors">reports</span>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <!-- 6-Month Trend Chart -->
                    <?php if(!empty($stats['monthly_trend'])): ?>
                    <div class="bg-white/5 border border-white/5 rounded-2xl p-5 relative overflow-visible group/chart">
                        <div class="flex items-center justify-between mb-6">
                            <h4 class="text-white font-semibold text-sm flex items-center gap-2">
                                <span class="text-emerald-400">📈</span> Activity Trend
                            </h4>
                            <div class="flex items-center gap-2">
                                <span class="text-[10px] text-slate-400 bg-white/5 px-2 py-1 rounded-full border border-white/5">
                                    Last 6 Months
                                </span>
                            </div>
                        </div>
                        
                        <div class="relative h-32 w-full mb-2">
                            <?php
                                $trend = $stats['monthly_trend'];
                                $max = max(array_column($trend, 'count')) ?: 1;
                                $count = count($trend);
                                
                                // Calculate points for 100x100 coordinate system
                                // Y-axis: Map 0..max to 90..10 (leaving 10% bottom, 10% top padding)
                                $points = [];
                                foreach($trend as $i => $data) {
                                    $x = $count > 1 ? $i * (100 / ($count - 1)) : 50;
                                    $y = 90 - (($data['count'] / $max) * 70); 
                                    $points[] = ['x' => $x, 'y' => $y, 'data' => $data];
                                }
                                
                                // Build SVG Path
                                $d = "M " . $points[0]['x'] . " " . $points[0]['y'];
                                foreach($points as $i => $p) {
                                    if($i > 0) $d .= " L " . $p['x'] . " " . $p['y'];
                                }
                                
                                // Close the path for the area fill
                                $areaD = $d . " L " . $points[$count-1]['x'] . " 100 L " . $points[0]['x'] . " 100 Z";
                            ?>
                            
                            <!-- SVG Graph -->
                            <svg class="absolute inset-0 w-full h-full overflow-visible" preserveAspectRatio="none" viewBox="0 0 100 100">
                                <defs>
                                    <linearGradient id="graphGradient" x1="0" x2="0" y1="0" y2="1">
                                        <stop offset="0%" stop-color="#10b981" stop-opacity="0.3"/>
                                        <stop offset="100%" stop-color="#10b981" stop-opacity="0"/>
                                    </linearGradient>
                                </defs>
                                
                                <!-- Connection Lines (Grid) -->
                                <line x1="0" y1="90" x2="100" y2="90" stroke="white" stroke-opacity="0.05" vector-effect="non-scaling-stroke" stroke-dasharray="4 4" />
                                <line x1="0" y1="20" x2="100" y2="20" stroke="white" stroke-opacity="0.05" vector-effect="non-scaling-stroke" stroke-dasharray="4 4" />
                                
                                <!-- Area Fill -->
                                <path d="<?php echo e($areaD); ?>" fill="url(#graphGradient)" stroke="none" vector-effect="non-scaling-stroke"/>
                                
                                <!-- Line Path -->
                                <path d="<?php echo e($d); ?>" fill="none" stroke="#10b981" stroke-width="2" vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" class="drop-shadow-lg"/>
                            </svg>
                            
                            <!-- Interactive Points Overlay -->
                            <div class="absolute inset-0 w-full h-full">
                                <?php $__currentLoopData = $points; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $point): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="absolute group/point z-10" style="left: <?php echo e($point['x']); ?>%; top: <?php echo e($point['y']); ?>%; transform: translate(-50%, -50%);">
                                        <!-- Hover Target Area -->
                                        <div class="w-8 h-8 -m-4 bg-transparent absolute cursor-pointer"></div>
                                        
                                        <!-- Dot -->
                                        <div class="w-2.5 h-2.5 bg-slate-900 border-2 border-emerald-500 rounded-full shadow-lg shadow-emerald-500/50 group-hover/point:scale-150 group-hover/point:bg-emerald-500 group-hover/point:border-white transition-all duration-200 pointer-events-none"></div>
                                        
                                        <!-- Tooltip -->
                                        <div class="absolute bottom-full mb-3 left-1/2 -translate-x-1/2 bg-slate-800/95 backdrop-blur-md border border-white/10 rounded-lg py-2 px-3 shadow-xl opacity-0 translate-y-2 group-hover/point:opacity-100 group-hover/point:translate-y-0 transition-all duration-200 pointer-events-none min-w-[100px] z-50">
                                            <div class="flex flex-col items-center gap-0.5">
                                                <span class="text-emerald-400 text-[10px] font-bold uppercase tracking-wider"><?php echo e($point['data']['month']); ?></span>
                                                <span class="text-white text-sm font-bold"><?php echo e($point['data']['count']); ?> Reports</span>
                                            </div>
                                            <!-- Arrow -->
                                            <div class="absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-slate-800/95"></div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            
                            <!-- X Axis Labels -->
                            <div class="absolute top-full left-0 w-full flex justify-between text-[10px] text-slate-500 font-medium pt-2">
                                 <?php $__currentLoopData = $points; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $point): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span style="position: absolute; left: <?php echo e($point['x']); ?>%; transform: translateX(-50%); white-space: nowrap;">
                                        <?php echo e($point['data']['month']); ?>

                                    </span>
                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                        <div class="h-4"></div> <!-- Spacer for labels -->
                    </div>
                    <?php endif; ?>

                    <!-- Visual Breakdown Sections Grid -->
                    <div class="space-y-6">
                        
                        <!-- Reporters Summary -->
                         <?php if(!empty($stats['top_reporters'])): ?>
                         <div class="space-y-3">
                             <h4 class="text-slate-400 text-xs font-bold uppercase tracking-widest flex items-center gap-2 pl-1">
                                 <span>👥</span> Top Contributors
                             </h4>
                             <div class="bg-white/5 border border-white/5 rounded-2xl overflow-hidden divide-y divide-white/5">
                                 <?php $__currentLoopData = $stats['top_reporters']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reporter => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                     <?php
                                         $isMe = auth()->check() && auth()->user()->name === $reporter;
                                         // Calculate percentage relative to max
                                         $maxReports = max($stats['top_reporters']);
                                         $percent = ($count / $maxReports) * 100;
                                     ?>
                                     <div class="p-3 <?php echo e($isMe ? 'bg-emerald-500/10' : 'hover:bg-white/5'); ?> transition-colors relative group">
                                         <!-- Background Progress Bar -->
                                         <div class="absolute inset-y-0 left-0 bg-emerald-500/5 transition-all duration-1000 ease-out" style="width: <?php echo e($percent); ?>%"></div>
                                         
                                         <div class="relative flex items-center justify-between z-10">
                                             <div class="flex items-center gap-3">
                                                 <div class="w-8 h-8 rounded-full <?php echo e($isMe ? 'bg-emerald-500 text-white' : 'bg-slate-700 text-slate-300'); ?> flex items-center justify-center text-xs font-bold ring-2 <?php echo e($isMe ? 'ring-emerald-500/30' : 'ring-white/5'); ?>">
                                                     <?php echo e(substr($reporter, 0, 1)); ?>

                                                 </div>
                                                 <div class="flex flex-col">
                                                     <span class="text-xs font-bold <?php echo e($isMe ? 'text-emerald-400' : 'text-white'); ?>">
                                                         <?php echo e($isMe ? 'You' : ($reporter ?: 'Unknown')); ?>

                                                     </span>
                                                     <span class="text-[10px] text-slate-500 font-medium">Patroller</span>
                                                 </div>
                                             </div>
                                             <div class="flex flex-col items-end">
                                                 <span class="text-emerald-400 text-sm font-bold"><?php echo e($count); ?></span>
                                                 <span class="text-[10px] text-slate-500">published</span>
                                             </div>
                                         </div>
                                     </div>
                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                             </div>
                         </div>
                         <?php endif; ?>

                        <!-- Combined Species and Type Grid -->
                        <div class="grid grid-cols-1 gap-6">
                            
                            <!-- Species Distribution -->
                            <?php if(!empty($stats['species'])): ?>
                            <div class="space-y-3">
                                <h4 class="text-slate-400 text-xs font-bold uppercase tracking-widest flex items-center gap-2 pl-1">
                                    <span>🦎</span> Species Stats
                                </h4>
                                <div class="bg-white/5 border border-white/5 rounded-2xl p-4 space-y-4">
                                    <?php $totalSpecies = array_sum($stats['species']); ?>
                                    <?php $__currentLoopData = $stats['species']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $species => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $name = ucwords(str_replace('_', ' ', $species ?: 'Unknown'));
                                            $percent = $totalSpecies > 0 ? ($count / $totalSpecies) * 100 : 0;
                                        ?>
                                        <div class="space-y-1 group">
                                            <div class="flex justify-between text-xs">
                                                <span class="text-slate-300 font-medium group-hover:text-white transition-colors"><?php echo e($name); ?></span>
                                                <span class="text-white font-bold"><?php echo e($count); ?></span>
                                            </div>
                                            <div class="w-full h-2 bg-slate-700/50 rounded-full overflow-hidden">
                                                <div class="h-full bg-gradient-to-r from-emerald-500 to-teal-400 rounded-full animate-progress" style="width: <?php echo e($percent); ?>%"></div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                            <?php endif; ?>

                             <!-- Priority Levels -->
                             <?php if(!empty($stats['priorities'])): ?>
                             <div class="space-y-3">
                                 <h4 class="text-slate-400 text-xs font-bold uppercase tracking-widest flex items-center gap-2 pl-1">
                                     <span>⚡</span> Priority Overview
                                 </h4>
                                 <div class="bg-white/5 border border-white/5 rounded-2xl p-4">
                                    <div class="flex flex-wrap gap-2">
                                        <?php $__currentLoopData = $stats['priorities']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $priority => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $normalizedPriority = strtolower($priority ?: 'unknown');
                                                $styles = match($normalizedPriority) {
                                                    'high', 'critical' => ['bg' => 'bg-red-500/20', 'text' => 'text-red-300', 'border' => 'border-red-500/30', 'dot' => 'bg-red-500'],
                                                    'medium' => ['bg' => 'bg-amber-500/20', 'text' => 'text-amber-300', 'border' => 'border-amber-500/30', 'dot' => 'bg-amber-500'],
                                                    'low' => ['bg' => 'bg-emerald-500/20', 'text' => 'text-emerald-300', 'border' => 'border-emerald-500/30', 'dot' => 'bg-emerald-500'],
                                                    default => ['bg' => 'bg-slate-500/20', 'text' => 'text-slate-300', 'border' => 'border-slate-500/30', 'dot' => 'bg-slate-500']
                                                };
                                            ?>
                                            <div class="flex-1 min-w-[100px] flex items-center justify-between <?php echo e($styles['bg']); ?> border <?php echo e($styles['border']); ?> rounded-xl px-3 py-2 transition-transform hover:scale-105">
                                                <div class="flex items-center gap-2">
                                                    <div class="w-2 h-2 rounded-full <?php echo e($styles['dot']); ?> animate-pulse"></div>
                                                    <span class="<?php echo e($styles['text']); ?> text-xs font-bold uppercase tracking-wider"><?php echo e($priority); ?></span>
                                                </div>
                                                <span class="text-white font-bold text-sm"><?php echo e($count); ?></span>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                 </div>
                             </div>
                             <?php endif; ?>

                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="text-center pt-4 pb-2">
                        <p class="text-[10px] text-slate-500 font-mono">DAHICAN PAWIKAN PATROL SYSTEM v2.0</p>
                    </div>

                </div>
            </div>
            <?php endif; ?>


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
                    <div class="flex flex-col items-center justify-center h-64 text-center px-4">
                        <div class="w-16 h-16 bg-green-500/10 rounded-full flex items-center justify-center mb-4 animate-pulse">
                            <span class="text-2xl">🐢</span>
                        </div>
                        <p class="text-green-300 font-bold mb-1">Select a Report Marker</p>
                        <p class="text-gray-400 text-xs">Click on any marker on the map to view the full report details and evidence.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<style>
#map {
    background: #1f2937;
    width: 100% !important;
    min-height: 500px;
}

#particles {
    display: none !important;
}

.leaflet-container {
    background: #1f2937 !important;
}

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
    font-family: 'Poppins', sans-serif !important;
    letter-spacing: 0.01em;
}

/* Animation for Analytics Panel */
@keyframes slideInFade {
    0% { opacity: 0; transform: translateY(-20px) scale(0.95); }
    100% { opacity: 1; transform: translateY(0) scale(1); }
}

@keyframes bounce-in {
    0% { transform: scale(0.8); opacity: 0; }
    50% { transform: scale(1.05); opacity: 1; }
    100% { transform: scale(1); }
}

.animate-bounce-in {
    animation: bounce-in 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
}

@keyframes width-grow {
    0% { width: 0; }
}
.animate-progress {
    animation: width-grow 1.5s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
}
.font-poppins {
    font-family: 'Poppins', sans-serif;
}

/* Analytics Panel Scrollbar */
#analytics-panel::-webkit-scrollbar,
#analytics-panel .overflow-y-auto::-webkit-scrollbar,
.custom-scrollbar::-webkit-scrollbar {
    width: 6px;
}

#analytics-panel::-webkit-scrollbar-track,
#analytics-panel .overflow-y-auto::-webkit-scrollbar-track,
.custom-scrollbar::-webkit-scrollbar-track {
    background: rgba(51, 65, 85, 0.3);
    border-radius: 3px;
}

#analytics-panel::-webkit-scrollbar-thumb,
#analytics-panel .overflow-y-auto::-webkit-scrollbar-thumb,
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: rgba(100, 116, 139, 0.6);
    border-radius: 3px;
}

#analytics-panel::-webkit-scrollbar-thumb:hover,
#analytics-panel .overflow-y-auto::-webkit-scrollbar-thumb:hover,
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: rgba(148, 163, 184, 0.8);
}

/* Smooth transitions for analytics panel */
#analytics-panel {
    transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Ensure progress bars animate smoothly */
.animate-progress {
    transition: width 1.5s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Custom Tooltip Styling */
.leaflet-tooltip.custom-tooltip {
    background: transparent !important;
    border: none !important;
    box-shadow: none !important;
    padding: 0 !important;
}

.leaflet-tooltip-top:before {
    border-top-color: rgba(15, 23, 42, 0.95) !important;
}
</style>

<script>
    (function() {
        const validatedReports = <?php echo json_encode($validatedReports, 15, 512) ?>;
        const HATCHERY_COORDS = [6.923881032515973, 126.28094149117992];
        const CUSTOM_MARKER_ICON = "<?php echo e(asset('img/marker.png')); ?>";
        let mapInstance = null;

        function animateCounters() {
            setTimeout(() => {
                const counters = document.querySelectorAll('.counter-up');
                counters.forEach(counter => {
                    const target = +counter.getAttribute('data-target');
                    if(target === 0) { counter.textContent = '0'; return; }
                    
                    const duration = 2000; 
                    const increment = target / (duration / 16);
                    
                    let current = 0;
                    const updateCount = () => {
                        current += increment;
                        if (current < target) {
                            counter.textContent = Math.ceil(current);
                            requestAnimationFrame(updateCount);
                        } else {
                            counter.textContent = target;
                        }
                    };
                    updateCount();
                });
            }, 300);
        }

        // Analytics Panel Toggle
        const analyticsToggle = document.getElementById('analytics-toggle');
        const analyticsPanel = document.getElementById('analytics-panel');
        const closeAnalytics = document.getElementById('close-analytics');

        if (analyticsToggle && analyticsPanel) {
            analyticsToggle.addEventListener('click', function() {
                analyticsPanel.classList.remove('translate-x-[120%]');
                analyticsPanel.classList.add('translate-x-0');
                analyticsToggle.style.display = 'none';
                // Trigger counter animations when panel opens
                setTimeout(animateCounters, 300);
            });
        }

        if (closeAnalytics && analyticsPanel && analyticsToggle) {
            closeAnalytics.addEventListener('click', function() {
                analyticsPanel.classList.add('translate-x-[120%]');
                analyticsPanel.classList.remove('translate-x-0');
                analyticsToggle.style.display = 'flex';
            });
        }

        // Trigger animations on load
        if (document.readyState === 'complete') {
            // Don't auto-animate on load, only when panel is opened
        } else {
            window.addEventListener('load', function() {
                // Don't auto-animate on load
            });
        }
        document.addEventListener('turbo:load', function() {
            // Reinitialize toggle listeners after Turbo navigation
            const toggle = document.getElementById('analytics-toggle');
            const panel = document.getElementById('analytics-panel');
            const close = document.getElementById('close-analytics');
            
            if (toggle && panel) {
                toggle.addEventListener('click', function() {
                    panel.classList.remove('translate-x-[120%]');
                    panel.classList.add('translate-x-0');
                    toggle.style.display = 'none';
                    setTimeout(animateCounters, 300);
                });
            }
            
            if (close && panel && toggle) {
                close.addEventListener('click', function() {
                    panel.classList.add('translate-x-[120%]');
                    panel.classList.remove('translate-x-0');
                    toggle.style.display = 'flex';
                });
            }
        });

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
                iconSize: [64, 64],
                iconAnchor: [32, 64],
                popupAnchor: [0, -60],
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

            // Cleanup existing instance if any
            if (mapInstance) {
                mapInstance.remove();
                mapInstance = null;
            }

            try {
                // Initialize map with a default view first
                mapInstance = L.map('map', {
                    center: HATCHERY_COORDS,
                    zoom: 14,
                    zoomControl: true,
                    // Prevent tile repeating strip issue
                    worldCopyJump: true,
                    maxBounds: [[6.893881, 126.250941], [6.953881, 126.310941]]
                });

                const googleHybrid = L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}', {
                    maxZoom: 20,
                    subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
                    attribution: '© Google Maps'
                }).addTo(mapInstance);

                // Add Fullscreen control if plugin exists
                if (L.Control.Fullscreen) {
                    new L.Control.Fullscreen({ position: 'topleft' }).addTo(mapInstance);
                }

                // Initial size calculation
                mapInstance.invalidateSize();

                if (window.L.MarkerClusterGroup) {
                    const markerCluster = L.markerClusterGroup({
                        showCoverageOnHover: false,
                        zoomToBoundsOnClick: true,
                        spiderfyOnMaxZoom: true
                    });
                    
                    const urlParams = new URLSearchParams(window.location.search);
                    const targetLat = parseFloat(urlParams.get('lat'));
                    const targetLng = parseFloat(urlParams.get('lng'));
                    const isIsolatedView = !isNaN(targetLat) && !isNaN(targetLng);

                    validatedReports.forEach(report => {
                        if (report.latitude && report.longitude) {
                            const reportLat = parseFloat(report.latitude);
                            const reportLng = parseFloat(report.longitude);

                            // If in isolated view, skip reports that don't match the target coordinates
                            if (isIsolatedView) {
                                if (Math.abs(reportLat - targetLat) > 0.0001 || 
                                    Math.abs(reportLng - targetLng) > 0.0001) {
                                    return;
                                }
                            }

                            const marker = L.marker([report.latitude, report.longitude], { 
                                icon: createIcon(),
                                title: 'Patrol Report: ' + (report.title || 'Untitled')
                            });
                            
                            // Add a hover tooltip as an indicator
                            marker.bindTooltip(`
                                <div class="px-2 py-1 bg-slate-900 text-white rounded shadow-lg border border-emerald-500/30">
                                    <div class="text-[10px] font-bold text-emerald-400 uppercase tracking-tighter">Patrol Report</div>
                                    <div class="text-xs font-bold">${report.title || 'Untitled'}</div>
                                    <div class="text-[9px] text-gray-400 mt-1 italic">Click to view details</div>
                                </div>
                            `, {
                                direction: 'top',
                                offset: [0, -60],
                                opacity: 0.9,
                                className: 'custom-tooltip'
                            });

                            marker.on('click', () => {
                                // Close analytics panel when clicking a marker
                                const analyticsPanel = document.getElementById('analytics-panel');
                                const analyticsToggle = document.getElementById('analytics-toggle');
                                if (analyticsPanel && analyticsToggle) {
                                    analyticsPanel.classList.add('translate-x-[120%]');
                                    analyticsPanel.classList.remove('translate-x-0');
                                    analyticsToggle.style.display = 'flex';
                                }
                                showReportInSidebar(report);
                            });
                            markerCluster.addLayer(marker);
                        }
                    });
                    
                    mapInstance.addLayer(markerCluster);
                    
                    // Crucial: Only fit bounds after a short delay to ensure DOM is settled
                    setTimeout(() => {
                        mapInstance.invalidateSize();
                        
                        // Check for lat/lng query parameters
                        const urlParams = new URLSearchParams(window.location.search);
                        const lat = parseFloat(urlParams.get('lat'));
                        const lng = parseFloat(urlParams.get('lng'));

                        if (!isNaN(lat) && !isNaN(lng)) {
                            mapInstance.setView([lat, lng], 18);
                            
                            // Try to find the specific report to show in sidebar
                            const report = validatedReports.find(r => 
                                Math.abs(parseFloat(r.latitude) - lat) < 0.0001 && 
                                Math.abs(parseFloat(r.longitude) - lng) < 0.0001
                            );
                            if (report) showReportInSidebar(report);
                        } else if (markerCluster.getLayers().length > 0) {
                            mapInstance.fitBounds(markerCluster.getBounds().pad(0.1));
                        } else {
                            mapInstance.setView(HATCHERY_COORDS, 14);
                        }
                        hideLoading();
                    }, 250);
                } else {
                    setTimeout(() => {
                        mapInstance.invalidateSize();
                        mapInstance.setView(HATCHERY_COORDS, 14);
                        hideLoading();
                    }, 250);
                }

                const closeBtn = document.getElementById('close-sidebar');
                if (closeBtn) closeBtn.onclick = window.closeSidebar;

            } catch (error) {
                console.error('Leaflet Init Error:', error);
                hideLoading();
            }
        }

        document.addEventListener('turbo:load', function() {
            if (document.getElementById('map')) {
                // Use requestAnimationFrame to ensure the container is rendered
                requestAnimationFrame(() => {
                    setTimeout(initializeMap, 100);
                });
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