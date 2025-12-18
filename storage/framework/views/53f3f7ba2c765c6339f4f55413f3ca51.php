<?php $__env->startSection('bodyClass', '3d-explorer-page'); ?>

<?php $__env->startPush('styles'); ?>
<style>
#explorer-container {
    position: fixed;
    top: 80px;
    left: 0;
    right: 0;
    bottom: 0;
    background: #111827;
    z-index: 1;
    padding: 2.5rem;
    overflow-y: auto;
    font-family: 'Poppins', sans-serif;
}
.page-header {
    text-align: center;
    margin-bottom: 3rem;
    padding-bottom: 2rem;
    border-bottom: 2px solid rgba(74, 222, 128, 0.3);
}
.page-title {
    font-size: 2.5rem;
    font-weight: 800;
    color: #4ade80;
    margin-bottom: 0.5rem;
    font-family: 'Poppins', sans-serif;
}
.page-subtitle {
    font-size: 1.1rem;
    color: #d1d5db;
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
    border: 1px solid rgba(74, 222, 128, 0.3);
    backdrop-filter: blur(10px);
}
.model-card:nth-child(3) {
    grid-column: 1 / -1;
    justify-self: center;
    width: calc(50% - 1.25rem);
}
.model-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #4ade80;
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
<style>
/* Vertical Anatomy Menu Styles */
.sketchfab-wrapper {
    position: relative;
    overflow: hidden; 
}

.anatomy-menu {
    position: absolute;
    top: 50%;
    left: 20px;
    transform: translateY(-50%);
    display: flex;
    flex-direction: column;
    gap: 0; /* Removed gap completely for tighter stacking */
    z-index: 50;
    width: 220px;
    background: transparent;
    border-radius: 0;
    padding: 0;
    backdrop-filter: none;
    border: none;
}

.anatomy-menu-title {
    color: #4ade80; 
    font-family: 'Poppins', sans-serif; 
    font-weight: 700; 
    margin-bottom: 0.25rem; /* Reduced margin */
    font-size: 1.1rem;
    padding-left: 12px;
    text-shadow: 0 2px 4px rgba(0,0,0,0.8);
}

.anatomy-menu-item {
    position: relative;
    color: #fff;
    font-family: 'Poppins', sans-serif;
    font-weight: 500;
    font-size: 0.95rem; /* Slightly smaller font */
    padding: 4px 12px; /* Reduced padding */
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s ease;
    background: transparent;
    border-left: 3px solid transparent;
    text-shadow: 0 2px 4px rgba(0,0,0,0.8);
}

.anatomy-menu-item:hover {
    color: #4ade80;
    background: rgba(0, 0, 0, 0.2); /* Subtle hover bg for better hit area */
    transform: translateX(4px);
    pointer-events: all;
    cursor: pointer;
}

.anatomy-menu-item.active {
    color: #4ade80;
    background: rgba(0, 0, 0, 0.3); /* Subtle active bg */
    border-left-color: #4ade80;
    font-weight: 700;
    box-shadow: none; /* Removed box shadow */
}

/* Scanner Reticle / Detection Indicator */
.scanner-reticle {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) scale(0.9);
    width: 250px;
    height: 250px;
    pointer-events: none;
    z-index: 15;
    opacity: 0;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.scanner-reticle.active {
    opacity: 1;
    transform: translate(-50%, -50%) scale(1);
    animation: reticlePulse 2s infinite ease-in-out;
}

.reticle-corner {
    position: absolute;
    width: 30px;
    height: 30px;
    border: 2px solid #4ade80;
    box-shadow: 0 0 10px rgba(74, 222, 128, 0.5);
}

.top-left { top: 0; left: 0; border-right: none; border-bottom: none; }
.top-right { top: 0; right: 0; border-left: none; border-bottom: none; }
.bottom-left { bottom: 0; left: 0; border-right: none; border-top: none; }
.bottom-right { bottom: 0; right: 0; border-left: none; border-top: none; }

.scanner-label {
    position: absolute;
    bottom: -30px;
    left: 50%;
    transform: translateX(-50%);
    color: #4ade80;
    font-family: 'Courier New', monospace; /* Tech feel */
    font-weight: 700;
    font-size: 0.9rem;
    letter-spacing: 2px;
    text-shadow: 0 0 5px rgba(74, 222, 128, 0.8);
    background: rgba(0, 20, 0, 0.6);
    padding: 2px 8px;
    border-radius: 4px;
    white-space: nowrap;
}

@keyframes reticlePulse {
    0% { box-shadow: inset 0 0 0 rgba(74, 222, 128, 0); }
    50% { box-shadow: inset 0 0 20px rgba(74, 222, 128, 0.1); }
    100% { box-shadow: inset 0 0 0 rgba(74, 222, 128, 0); }
}

/* Connector Lines - Hidden as requested */
.connector-line {
    display: none; 
}

.anatomy-desc-popover {
    position: absolute;
    background: rgba(17, 24, 39, 0.9);
    backdrop-filter: blur(8px);
    border: 1px solid #4ade80;
    border-radius: 12px;
    padding: 15px;
    color: #fff;
    font-size: 0.95rem;
    line-height: 1.5;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
    z-index: 30;
    box-shadow: 0 10px 30px rgba(0,0,0,0.5);
    font-family: 'Poppins', sans-serif;
}

.anatomy-desc-popover.active {
    opacity: 1;
    visibility: visible;
}

@media (max-width: 768px) {
    /* Wrapped Menu at Bottom */
    /* Mobile Layout Refactoring: Labels below model */
    .sketchfab-wrapper {
        display: flex;
        flex-direction: column;
        height: auto !important;
        aspect-ratio: auto !important;
        background: #000;
    }

    .sketchfab-wrapper iframe {
        order: 1;
        position: relative;
        height: 350px !important; /* Fixed height for 3D view */
        width: 100%;
        aspect-ratio: unset;
    }

    .anatomy-menu {
        position: relative; /* Move out of overlay */
        order: 2; /* Place below iframe */
        top: auto;
        bottom: auto;
        left: auto;
        right: auto;
        width: 100%;
        height: auto;
        transform: none;
        
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        
        padding: 12px 8px;
        gap: 8px;
        background: #111827; /* Dark background to match page flow */
        border-top: 1px solid rgba(74, 222, 128, 0.2);
        z-index: 25;
    }
    
    .anatomy-menu::-webkit-scrollbar {
        display: none;
    }

    .anatomy-menu-item {
        flex: 0 0 auto;
        font-size: 0.7rem;    /* Smaller font */
        padding: 4px 10px;    /* Compact padding */
        background: rgba(17, 24, 39, 0.85);
        border-radius: 6px;   /* Rounded rect instead of pill for better stacking */
        border-left: none;
        border: 1px solid rgba(74, 222, 128, 0.3);
        margin: 0;
        white-space: nowrap;
        text-shadow: none;
    }
    
    .anatomy-menu-item:hover {
        transform: none;
    }
    
    .anatomy-menu-item.active {
        background: #4ade80;
        color: #064e3b;
        font-weight: bold;
        border-color: #4ade80;
    }
    
    /* Optional: Hide longer text description on mobile if overlapping? */
    /* .label-text span { display: none; } */
    
    .connector-line {
        display: none;
    }
    
    .sketchfab-wrapper {
        border-radius: 12px;
    }
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div id="explorer-container">
    <div class="page-header">
        <h1 class="page-title">Species Found in Dahican</h1>
        <p class="page-subtitle">Explore 3D models of sea turtles with interactive anatomical labels</p>
    </div>

    <div class="models-grid">
        <div class="model-card">
            <h3 class="model-title">Green Sea Turtle <span style="font-style: italic; font-size: 0.9em; color: #86efac;">(Chelonia mydas)</span></h3>
            
            <div class="sketchfab-wrapper" style="position: relative;">
                <!-- Vertical Anatomy Menu (Left Side) -->
                <div class="anatomy-menu">
                    
                    <div class="anatomy-menu-item" onclick="activatePart('Head', this)">
                        <span class="label-text">Head</span>
                        <!-- Line will be positioned dynamically or fixed via CSS classes -->
                        <div class="connector-line line-head"></div>
                    </div>

                    <div class="anatomy-menu-item" onclick="activatePart('Eye', this)">
                        <span class="label-text">Eye</span>
                        <div class="connector-line line-eye"></div>
                    </div>

                    <div class="anatomy-menu-item" onclick="activatePart('Carapace', this)">
                        <span class="label-text">Carapace (Shell)</span>
                        <div class="connector-line line-carapace"></div>
                    </div>

                    <div class="anatomy-menu-item" onclick="activatePart('Tail', this)">
                        <span class="label-text">Tail</span>
                        <div class="connector-line line-tail"></div>
                    </div>

                    <div class="anatomy-menu-item" onclick="activatePart('Plastron', this)">
                        <span class="label-text">Plastron (Underside)</span>
                        <div class="connector-line line-plastron"></div>
                    </div>

                    <div class="anatomy-menu-item" onclick="activatePart('Flipper', this)">
                        <span class="label-text">Flipper (Forelimb)</span>
                        <div class="connector-line line-flipper"></div>
                    </div>
                </div>
                


                <iframe id="green-turtle-iframe" title="Green Sea Turtle" frameborder="0" allowfullscreen mozallowfullscreen="true" webkitallowfullscreen="true"
                        allow="autoplay; fullscreen; xr-spatial-tracking" xr-spatial-tracking execution-while-out-of-viewport
                        execution-while-not-rendered web-share
                        src="https://sketchfab.com/models/422f77a6fba64e7e8969984e552f111a/embed?autostart=1&preload=1&ui_controls=1&ui_infos=0&ui_inspector=0&ui_stop=0&ui_watermark=0">
                </iframe>
            </div>
            
            <!-- Description Display -->
            <div id="description-display" style="background: rgba(74, 222, 128, 0.05); border: 1px solid rgba(74, 222, 128, 0.2); border-radius: 12px; padding: 20px; margin-top: 20px; min-height: 80px;">
                <p id="description-text" style="color: #d1d5db; font-size: 14px; line-height: 1.7; font-family: 'Poppins', sans-serif; margin: 0;">Click on a body part to learn more about it.</p>
            </div>

        </div>

        <div class="model-card">
            <h3 class="model-title">Hawksbill Turtle <span style="font-style: italic; font-size: 0.9em; color: #86efac;">(Eretmochelys imbricata)</span></h3>
            
            <div class="sketchfab-wrapper" style="position: relative;">
                <!-- Vertical Anatomy Menu (Left Side) -->
                <div class="anatomy-menu">
                    
                    <div class="anatomy-menu-item" onclick="activatePartHawksbill('Head', this)">
                        <span class="label-text">Head</span>
                        <div class="connector-line line-head"></div>
                    </div>

                    <div class="anatomy-menu-item" onclick="activatePartHawksbill('Eye', this)">
                        <span class="label-text">Eye</span>
                        <div class="connector-line line-eye"></div>
                    </div>

                    <div class="anatomy-menu-item" onclick="activatePartHawksbill('Carapace', this)">
                        <span class="label-text">Carapace (Shell)</span>
                        <div class="connector-line line-carapace"></div>
                    </div>

                    <div class="anatomy-menu-item" onclick="activatePartHawksbill('Tail', this)">
                        <span class="label-text">Tail</span>
                        <div class="connector-line line-tail"></div>
                    </div>

                    <div class="anatomy-menu-item" onclick="activatePartHawksbill('Plastron', this)">
                        <span class="label-text">Plastron (Underside)</span>
                        <div class="connector-line line-plastron"></div>
                    </div>

                    <div class="anatomy-menu-item" onclick="activatePartHawksbill('Flipper', this)">
                        <span class="label-text">Flipper (Forelimb)</span>
                        <div class="connector-line line-flipper"></div>
                    </div>
                </div>

                <iframe id="hawksbill-turtle-iframe" title="Hawksbill Turtle" frameborder="0" allowfullscreen mozallowfullscreen="true" webkitallowfullscreen="true"
                        allow="autoplay; fullscreen; xr-spatial-tracking" xr-spatial-tracking execution-while-out-of-viewport
                        execution-while-not-rendered web-share
                        src="https://sketchfab.com/models/0c0316cbed524374ab219f6d94b105c9/embed?autostart=1&preload=1&ui_controls=1&ui_infos=0&ui_inspector=0&ui_stop=0&ui_watermark=0">
                </iframe>
            </div>
            
            <!-- Description Display -->
            <div id="description-display-hawksbill" style="background: rgba(74, 222, 128, 0.05); border: 1px solid rgba(74, 222, 128, 0.2); border-radius: 12px; padding: 20px; margin-top: 20px; min-height: 80px;">
                <p id="description-text-hawksbill" style="color: #d1d5db; font-size: 14px; line-height: 1.7; font-family: 'Poppins', sans-serif; margin: 0;">Click on a body part to learn more about it.</p>
            </div>

        </div>

        <div class="model-card">
            <h3 class="model-title">Olive Ridley Turtle <span style="font-style: italic; font-size: 0.9em; color: #86efac;">(Lepidochelys olivacea)</span></h3>
            
            <div class="sketchfab-embed-wrapper sketchfab-wrapper" style="position: relative;">
                <!-- Vertical Anatomy Menu (Left Side) -->
                <div class="anatomy-menu">
                    
                    <div class="anatomy-menu-item" onclick="activatePartOlive('Head', this)">
                        <span class="label-text">Head</span>
                        <div class="connector-line line-head"></div>
                    </div>

                    <div class="anatomy-menu-item" onclick="activatePartOlive('Eye', this)">
                        <span class="label-text">Eye</span>
                        <div class="connector-line line-eye"></div>
                    </div>

                    <div class="anatomy-menu-item" onclick="activatePartOlive('Carapace', this)">
                        <span class="label-text">Carapace (Shell)</span>
                        <div class="connector-line line-carapace"></div>
                    </div>

                    <div class="anatomy-menu-item" onclick="activatePartOlive('Tail', this)">
                        <span class="label-text">Tail</span>
                        <div class="connector-line line-tail"></div>
                    </div>

                    <div class="anatomy-menu-item" onclick="activatePartOlive('Plastron', this)">
                        <span class="label-text">Plastron (Underside)</span>
                        <div class="connector-line line-plastron"></div>
                    </div>

                    <div class="anatomy-menu-item" onclick="activatePartOlive('Flipper', this)">
                        <span class="label-text">Flipper (Forelimb)</span>
                        <div class="connector-line line-flipper"></div>
                    </div>
                </div>

                <iframe id="olive-ridley-iframe" title="Olive Ridley" frameborder="0" allowfullscreen mozallowfullscreen="true" webkitallowfullscreen="true" 
                        allow="autoplay; fullscreen; xr-spatial-tracking" xr-spatial-tracking execution-while-out-of-viewport 
                        execution-while-not-rendered web-share 
                        src="https://sketchfab.com/models/acbe292c128246ed8e532bfd9e646a03/embed?autostart=1&preload=1&ui_controls=1&ui_infos=0&ui_inspector=0&ui_stop=0&ui_watermark=0">
                </iframe>
            </div>
            
            <!-- Description Display -->
            <div id="description-display-olive" style="background: rgba(74, 222, 128, 0.05); border: 1px solid rgba(74, 222, 128, 0.2); border-radius: 12px; padding: 20px; margin-top: 20px; min-height: 80px;">
                <p id="description-text-olive" style="color: #d1d5db; font-size: 14px; line-height: 1.7; font-family: 'Poppins', sans-serif; margin: 0;">Click on a body part to learn more about it.</p>
            </div>

        </div>
    </div>
</div>

<script>
    (function() {
        let greenTurtleApi = null;
        let hawksbillTurtleApi = null;
        let oliveRidleyApi = null;
        
        const cameraCoordinatesGreen = {
            'Head': { position: [0.25, 0.35, 0.35], target: [0.2, 0.0, 0.0] },
            'Eye': { position: [0.24, -0.11, 0.1], target: [0.2, 0.05, 0.0] },
            'Carapace': { position: [0.0, 0.05, 1.0], target: [0.0, 0.0, 0.0] },
            'Tail': { position: [-1.2, 0.3, 0.0], target: [-0.4, 0.05, 0.0] },
            'Plastron': { position: [0.0, 0.0, -0.7], target: [0.0, 0.0, 0.0] },
            'Flipper': { position: [0.6, -0.3, 0.6], target: [0.0, 0.0, 0.0] }
        };

        const cameraCoordinatesHawksbill = {
            'Head': { position: [0.7, -0.13, 0.12], target: [0.1, 0.0, 0.0] },
            'Eye': { position: [0.7, -0.13, 0.12], target: [0.15, 0.05, 0.0] },
            'Carapace': { position: [0.0, 0.1, 1.1], target: [0.0, 0.0, 0.0] },
            'Tail': { position: [-1.1, 0.3, 0.0], target: [-0.3, 0.0, 0.0] },
            'Plastron': { position: [0.0, 0.0, -0.7], target: [0.0, 0.0, 0.0] },
            'Flipper': { position: [0.5, -0.2, 0.7], target: [0.2, -0.1, 0.1] }
        };

        const cameraCoordinatesOlive = {
            'Head': { position: [0.5, -0.45, 0.25], target: [0.15, 0.0, 0.0] },
            'Eye': { position: [0.6, -0.45, 0.12], target: [0.15, 0.05, 0.0] },
            'Carapace': { position: [0.0, 0.05, 1.0], target: [0.0, 0.0, 0.0] },
            'Tail': { position: [-1.2, 0.3, 0.0], target: [-0.3, 0.0, 0.0] },
            'Plastron': { position: [0.0, 0.0, -0.7], target: [0.0, 0.0, 0.0] },
            'Flipper': { position: [0.6, -0.3, 0.6], target: [0.2, -0.2, 0.1] }
        };

        const partDescriptions = {
            'Head': 'The rounded, blunt head houses the brain and sensory organs with powerful jaws adapted for herbivorous feeding, excellent underwater vision, and the ability to detect Earth\'s magnetic field for navigation to Dahican\'s nesting beaches.',
            'Eye': 'Large eyes with special salt glands provide color vision both underwater and on land, helping green sea turtles navigate Dahican\'s waters while removing excess salt from seawater.',
            'Carapace': 'The smooth, heart-shaped upper shell is typically olive to brown with radiating patterns, made of bone covered by keratin scutes, measuring 3-4 feet in length and providing protection from predators.',
            'Tail': 'The relatively short tail aids in steering while swimming and is notably longer and thicker in males (extending beyond the carapace) for use during mating, serving as a key identifier of gender.',
            'Plastron': 'The yellowish-white lower shell provides crucial underside protection, is slightly concave in males and flat in females, and connects to the carapace by a bridge to create a protective box for vital organs.',
            'Flipper': 'The long, paddle-like front flippers are the primary means of propulsion enabling speeds up to 35 mph, each featuring a single claw used for feeding and climbing onto Dahican\'s beaches during nesting season.'
        };

        const partDescriptionsHawksbill = {
            'Head': 'The narrow, pointed head features a distinctive hawk-like beak perfectly adapted for reaching into crevices to feed on sponges, with excellent vision for navigating complex coral reef environments in Dahican waters.',
            'Eye': 'Sharp eyes with protective eyelids and salt-excreting glands enable the Hawksbill to hunt for sponges in reef crevices while efficiently removing excess salt from their specialized diet.',
            'Carapace': 'The beautiful amber and brown patterned shell features overlapping scutes creating the prized "tortoiseshell" appearance, measuring 2-3 feet in length with serrated rear edges for protection.',
            'Tail': 'The short tail is proportionally smaller than other species, with males having longer tails extending beyond the carapace for reproduction, also aiding in precise maneuvering through coral formations.',
            'Plastron': 'The pale yellow plastron provides underside protection and is slightly concave in males for mating, connected to the ornate carapace by a flexible bridge allowing some movement.',
            'Flipper': 'Two claws on each front flipper distinguish Hawksbills from other species, providing excellent grip for climbing rocky surfaces and manipulating sponges during feeding in Dahican\'s coral reefs.'
        };

        const partDescriptionsOlive = {
            'Head': 'The rounded head is proportionally large for their small body size, equipped with powerful jaws for their omnivorous diet and excellent sensory capabilities for detecting prey and navigating to Dahican\'s nesting beaches during arribadas.',
            'Eye': 'Large, expressive eyes with specialized glands efficiently remove salt while providing keen vision for hunting diverse prey including jellyfish, crabs, and fish in Dahican\'s coastal waters.',
            'Carapace': 'The distinctive olive-green heart-shaped shell measures 2-2.5 feet with 5-9 pairs of costal scutes (more than other species), providing lightweight protection perfect for their active lifestyle and mass nesting events.',
            'Tail': 'The relatively short tail serves multiple functions in swimming agility and reproduction, with males having noticeably longer tails for mating during the spectacular arribada nesting events at Dahican.',
            'Plastron': 'The yellowish plastron is flat in females and slightly concave in males, providing essential protection while being lightweight enough for the smallest sea turtle species to navigate efficiently.',
            'Flipper': 'Compact, paddle-shaped flippers with typically one or two claws enable both powerful swimming for long migrations and precise digging during arribadas when thousands nest simultaneously on Dahican beaches.'
        };

        function initExplorers() {
            const greenIframe = document.getElementById('green-turtle-iframe');
            if (greenIframe && window.Sketchfab) {
                const client = new Sketchfab(greenIframe);
                client.init('422f77a6fba64e7e8969984e552f111a', {
                    success: function(api) { greenTurtleApi = api; api.start(); },
                    error: function() { console.error('Sketchfab Error'); },
                    autostart: 1, preload: 1, ui_controls: 1, ui_infos: 0, ui_watermark: 0
                });
            }

            const hawksbillIframe = document.getElementById('hawksbill-turtle-iframe');
            if (hawksbillIframe && window.Sketchfab) {
                const client = new Sketchfab(hawksbillIframe);
                client.init('0c0316cbed524374ab219f6d94b105c9', {
                    success: function(api) { hawksbillTurtleApi = api; api.start(); },
                    error: function() { console.error('Hawksbill Error'); },
                    autostart: 1, preload: 1, ui_controls: 1, ui_infos: 0, ui_watermark: 0
                });
            }

            const oliveIframe = document.getElementById('olive-ridley-iframe');
            if (oliveIframe && window.Sketchfab) {
                const client = new Sketchfab(oliveIframe);
                client.init('acbe292c128246ed8e532bfd9e646a03', {
                    success: function(api) { oliveRidleyApi = api; api.start(); },
                    error: function() { console.error('Olive Ridley Error'); },
                    autostart: 1, preload: 1, ui_controls: 1, ui_infos: 0, ui_watermark: 0
                });
            }
        }

        window.activatePart = function(partName, element) {
            if (greenTurtleApi && cameraCoordinatesGreen[partName]) {
                const coords = cameraCoordinatesGreen[partName];
                greenTurtleApi.setCameraLookAt(coords.position, coords.target, 2.0);
            }
            document.querySelectorAll('.anatomy-menu-item').forEach(item => item.classList.remove('active'));
            if (element) element.classList.add('active');
            const descriptionText = document.getElementById('description-text');
            if (descriptionText && partDescriptions[partName]) descriptionText.textContent = partDescriptions[partName];
        };

        window.activatePartHawksbill = function(partName, element) {
            if (hawksbillTurtleApi && cameraCoordinatesHawksbill[partName]) {
                const coords = cameraCoordinatesHawksbill[partName];
                hawksbillTurtleApi.setCameraLookAt(coords.position, coords.target, 2.0);
            }
            const menuItems = element.closest('.anatomy-menu').querySelectorAll('.anatomy-menu-item');
            menuItems.forEach(item => item.classList.remove('active'));
            if (element) element.classList.add('active');
            const descriptionText = document.getElementById('description-text-hawksbill');
            if (descriptionText && partDescriptionsHawksbill[partName]) descriptionText.textContent = partDescriptionsHawksbill[partName];
        };

        window.activatePartOlive = function(partName, element) {
            if (oliveRidleyApi && cameraCoordinatesOlive[partName]) {
                const coords = cameraCoordinatesOlive[partName];
                oliveRidleyApi.setCameraLookAt(coords.position, coords.target, 2.0);
            }
            const menuItems = element.closest('.anatomy-menu').querySelectorAll('.anatomy-menu-item');
            menuItems.forEach(item => item.classList.remove('active'));
            if (element) element.classList.add('active');
            const descriptionText = document.getElementById('description-text-olive');
            if (descriptionText && partDescriptionsOlive[partName]) descriptionText.textContent = partDescriptionsOlive[partName];
        };

        // Turbo Load Listener
        document.addEventListener('turbo:load', function() {
            if (document.getElementById('green-turtle-iframe')) {
                initExplorers();
            }
        });
    })();
</script>




</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Rayver\Desktop\my_app\resources\views/3d-explorer.blade.php ENDPATH**/ ?>