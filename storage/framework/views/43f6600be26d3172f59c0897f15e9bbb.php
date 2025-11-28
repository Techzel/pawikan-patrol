

<?php $__env->startSection('bodyClass', '3d-explorer-page'); ?>

<?php $__env->startPush('styles'); ?>
<style>
#explorer-container {
    position: fixed;
    top: 80px;
    left: 0;
    right: 0;
    bottom: 0;
    background: radial-gradient(circle at top, #102a43, #020617 70%);
    z-index: 1;
    padding: 2.5rem;
    overflow-y: auto;
}
.page-header {
    text-align: center;
    margin-bottom: 3rem;
    padding-bottom: 2rem;
    border-bottom: 2px solid rgba(45, 212, 191, 0.2);
}
.page-title {
    font-size: 3rem;
    font-weight: 800;
    background: linear-gradient(135deg, #2dd4bf 0%, #5eead4 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 0.5rem;
}
.page-subtitle {
    font-size: 1.1rem;
    color: #94a3b8;
}
.models-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 2.5rem;
    max-width: 1400px;
    margin: 0 auto;
    padding-bottom: 2rem;
}
.model-card {
    background: rgba(255, 255, 255, 0.03);
    border-radius: 1.5rem;
    padding: 1.5rem;
    border: 1px solid rgba(255, 255, 255, 0.1);
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}
.model-card:nth-child(3) {
    grid-column: 1 / -1;
    justify-self: center;
    width: calc(50% - 1.25rem);
}
.model-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 25px 50px -12px rgba(45, 212, 191, 0.4);
    border-color: rgba(45, 212, 191, 0.3);
}
.model-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #2dd4bf;
    margin-bottom: 1rem;
    text-align: center;
}
.sketchfab-wrapper {
    width: 100%;
    aspect-ratio: 16/9;
    background: #000;
    border-radius: 1rem;
    overflow: hidden;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.5);
}
.sketchfab-wrapper iframe {
    width: 100%;
    height: 100%;
    border: none;
}
@media (max-width: 768px) {
    #explorer-container { top: 64px; padding: 1.5rem; }
    .page-title { font-size: 2rem; }
    .models-grid { grid-template-columns: 1fr; gap: 1.5rem; }
    .model-card:nth-child(3) {
        grid-column: auto;
        width: auto;
        justify-self: auto;
    }
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div id="explorer-container">
    <div class="page-header">
        <h1 class="page-title">Species Found in Dahican</h1>
        <p class="page-subtitle">Explore 3D models of sea turtles</p>
    </div>

    <div class="models-grid">
        <div class="model-card">
            <h3 class="model-title">Green Sea Turtle</h3>
            <div class="sketchfab-wrapper">
                <iframe title="Green Sea Turtle" frameborder="0" allowfullscreen mozallowfullscreen="true" webkitallowfullscreen="true"
                        allow="autoplay; fullscreen; xr-spatial-tracking" xr-spatial-tracking execution-while-out-of-viewport
                        execution-while-not-rendered web-share
                        src="https://sketchfab.com/models/bd232baa31cd4d64b2637556a8daa69b/embed?autostart=1&preload=1&ui_controls=1&ui_infos=0&ui_inspector=0&ui_stop=0&ui_watermark=0">
                </iframe>
            </div>
        </div>

        <div class="model-card">
            <h3 class="model-title">Hawksbill Turtle</h3>
            <div class="sketchfab-wrapper">
                <iframe title="Hawksbill Turtle" frameborder="0" allowfullscreen mozallowfullscreen="true" webkitallowfullscreen="true"
                        allow="autoplay; fullscreen; xr-spatial-tracking" xr-spatial-tracking execution-while-out-of-viewport
                        execution-while-not-rendered web-share
                        src="https://sketchfab.com/models/0c0316cbed524374ab219f6d94b105c9/embed?autostart=1&preload=1&ui_controls=1&ui_infos=0&ui_inspector=0&ui_stop=0&ui_watermark=0">
                </iframe>
            </div>
        </div>

        <div class="model-card">
            <h3 class="model-title">Olive Ridley Turtle</h3>
            <div class="sketchfab-embed-wrapper sketchfab-wrapper">
                <iframe title="Olive Ridley" frameborder="0" allowfullscreen mozallowfullscreen="true" webkitallowfullscreen="true" 
                        allow="autoplay; fullscreen; xr-spatial-tracking" xr-spatial-tracking execution-while-out-of-viewport 
                        execution-while-not-rendered web-share 
                        src="https://sketchfab.com/models/acbe292c128246ed8e532bfd9e646a03/embed?autostart=1&preload=1&ui_controls=1&ui_infos=0&ui_inspector=0&ui_stop=0&ui_watermark=0">
                </iframe>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Rayver\Desktop\pawikan-patrol\my_app\resources\views/3d-explorer.blade.php ENDPATH**/ ?>