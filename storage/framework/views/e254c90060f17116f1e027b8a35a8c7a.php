<?php $__env->startPush('styles'); ?>
    <style>
        #landing-page p,
        #landing-page li,
        #landing-page .text-sm,
        #landing-page .text-base,
        #landing-page .body-copy,
        #landing-page .description-text,
        #landing-page span.description-text,
        #landing-page .stat-value .subtext {
            font-family: 'Poppins', sans-serif !important;
            letter-spacing: 0.01em;
            font-weight: 300;
            font-size: 0.95rem;
        }

        #landing-page h1,
        #landing-page h2,
        #landing-page h3,
        #landing-page h4,
        #landing-page h5,
        #landing-page h6 {
            font-family: 'Poppins', sans-serif !important;
        }
        
        /* Adjust heading sizes */
        #landing-page h1 {
            font-size: 2.5rem !important;
            font-weight: 600 !important;
        }
        
        #landing-page h2 {
            font-size: 2.25rem !important;
            font-weight: 600 !important;
        }
        
        #landing-page h3 {
            font-size: 1.5rem !important;
            font-weight: 500 !important;
        }
        
        #landing-page h4 {
            font-size: 1.25rem !important;
            font-weight: 500 !important;
        }
        
        @media (max-width: 768px) {
            #landing-page h1 {
                font-size: 2rem !important;
            }
            
            #landing-page h2 {
                font-size: 1.85rem !important;
            }
            
            #landing-page h3 {
                font-size: 1.25rem !important;
            }
        }

        #landing-page .carousel {
            height: clamp(300px, 80vh, 600px);
            width: 100%;
            margin-left: auto;
            margin-right: auto;
            border-radius: 0 !important;
            position: relative;
            overflow: hidden;
        }

        #landing-page .carousel-track {
            display: flex;
            height: 100%;
            width: 100%;
        }

        #landing-page .carousel-slide {
            flex: 0 0 100%;
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        #landing-page .carousel-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 0 !important;
            position: relative;
            z-index: 1;
        }

        #landing-page .carousel-slide .slide-overlay {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            background: linear-gradient(180deg, rgba(0, 0, 0, 0.05) 0%, rgba(0, 0, 0, 0.65) 100%);
            color: #fff;
            z-index: 2;
            pointer-events: none;
            text-align: center;
        }

        #landing-page .carousel-slide .slide-overlay h2 {
            font-size: clamp(2rem, 4vw, 3.5rem);
            margin-bottom: 3rem;
        }

        #landing-page .carousel-slide .slide-overlay p {
            max-width: 36rem;
            font-size: clamp(1rem, 2vw, 1.15rem);
            line-height: 1.5;
            font-family: 'Poppins', sans-serif !important;
            letter-spacing: 0.01em;
            font-weight: 300;
        }
        
        /* Carousel heading specific styling */
        #landing-page .slide-overlay h2 {
            font-size: 2.75rem !important;
            font-weight: 700 !important;
        }
        
        @media (max-width: 768px) {
            #landing-page .slide-overlay h2 {
                font-size: 1.75rem !important;
            }
        }

        @keyframes shine {
            100% { transform: translateX(100%); }
        }
        .animate-shine {
            animation: shine 1.5s infinite;
        }
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.02);
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(59, 130, 246, 0.3);
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(59, 130, 246, 0.5);
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<?php
    // Failsafe for missing database table during initial deployment
    $metadata = collect();
    try {
        if (\Illuminate\Support\Facades\Schema::hasTable('resource_metadata')) {
            $metadata = \App\Models\ResourceMetadata::all()->keyBy('filename');
        }
    } catch (\Exception $e) {
        // Table not found or database connection issue - proceed with empty metadata
        \Illuminate\Support\Facades\Log::warning('Resource metadata table not found: ' . $e->getMessage());
    }

    $files = collect(\Illuminate\Support\Facades\Storage::disk('public')->files('resources'))
        ->filter(function ($file) {
            return str_ends_with(strtolower($file), '.pdf');
        })
        ->map(function ($file) use ($metadata) {
            $filename = basename($file);
            $fileMeta = $metadata->get($filename);
            return [
                'name' => $filename,
                'title' => $fileMeta && $fileMeta->title ? $fileMeta->title : $filename,
                'url' => file_exists(public_path('resources/' . $filename)) 
                    ? asset('resources/' . $filename) 
                    : \Illuminate\Support\Facades\Storage::url($file),
                'description' => $fileMeta ? $fileMeta->description : 'No description provided.',
                'published_date' => $fileMeta ? $fileMeta->published_date : date('Y-m-d', \Illuminate\Support\Facades\Storage::disk('public')->lastModified($file))
            ];
        })
        ->values();
?>
<div id="landing-page">
    <!-- Hero Section with Carousel -->
    <section class="min-h-screen flex items-center justify-center relative px-4 pt-4 bg-gray-900" id="hero">
        <div class="max-w-6xl w-full mx-auto z-10">
            <div class="carousel relative overflow-hidden rounded-2xl">
                <div class="carousel-track">
                    <div class="carousel-slide" style="--slide-bg: url('<?php echo e(asset('img/dahican2-view.avif')); ?>');">
                        <img src="<?php echo e(asset('img/dahican2-view.avif')); ?>" alt="Sea Turtle Swimming" class="rounded-2xl shadow-2xl">
                        <div class="slide-overlay">
                            <h2 class="font-bold text-white text-lg">Dahican Marine Turtle</h2>
                            <p class="text-gray-100 text-xs">
                                Experience the magic of Dahican Beach, home to majestic sea turtles. 
                                Here, conservation meets community as we protect these gentle giants and share their remarkable journey 
                                with visitors from around the world.
                            </p>
                        </div>
                    </div>
                    <div class="carousel-slide" style="--slide-bg: url('<?php echo e(asset('img/hatch_1.jpg')); ?>');">
                        <img src="<?php echo e(asset('img/bb-turtle.jpg')); ?>" alt="Sea Turtle Nesting" class="rounded-2xl shadow-2xl">
                        <div class="slide-overlay">
                            <h2 class="font-bold text-white text-lg">Dahican Marine Turtle Species</h2>
                            <p class="text-gray-100 text-xs">
                                According to Dahican locals, three magnificent sea turtle species call these waters home:
                                the Green Sea Turtle, Hawksbill, and Olive Ridley. Each plays a vital role in maintaining
                                the delicate balance of our marine ecosystem.
                            </p>
                        </div>
                    </div>
                    <div class="carousel-slide" style="--slide-bg: url('<?php echo e(asset('img/hatch2.jpg')); ?>');">
                        <img src="<?php echo e(asset('img/hatch3.jpg')); ?>" alt="Baby Sea Turtles" class="rounded-2xl shadow-2xl">
                        <div class="slide-overlay">
                            <h2 class="font-bold text-white text-lg">Dahican Turtle Hatchery</h2>
                            <p class="text-gray-100 text-xs">
                                Our dedicated hatchery protects and nurtures sea turtle nests, ensuring the safe journey 
                                of hatchlings to the ocean. Through careful monitoring and community involvement, 
                                we safeguard the future of these endangered species.
                            </p>
                        </div>
                    </div>
                    <div class="carousel-slide" style="--slide-bg: url('<?php echo e(asset('img/hatch3.jpg')); ?>');">
                        <img src="<?php echo e(asset('img/respect.jpg')); ?>" alt="Pawikan Patrol Team" class="rounded-2xl shadow-2xl">
                        <div class="slide-overlay">
                            <h2 class="font-bold text-white text-lg">Respect & Protect</h2>
                            <p class="text-gray-100 text-xs">
                                Become part of the Pawikan Patrol community and help protect these magnificent creatures. 
                                Together, we can ensure that future generations will continue to marvel at the beauty 
                                and wonder of sea turtles in Dahican.
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Carousel Controls -->
                <!-- Carousel Controls -->
                <button class="carousel-control prev absolute left-4 top-1/2 transform -translate-y-1/2 text-white p-2 rounded-full transition-all duration-300 z-10 hover:scale-110">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                <button class="carousel-control next absolute right-4 top-1/2 transform -translate-y-1/2 text-white p-2 rounded-full transition-all duration-300 z-10 hover:scale-110">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
                
                <!-- Carousel Indicators -->
                <!-- Carousel Indicators -->
                <div class="carousel-indicators absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                    <button class="carousel-indicator w-2 h-2 bg-white/50 hover:bg-white rounded-full transition-all duration-300" data-slide="0"></button>
                    <button class="carousel-indicator w-2 h-2 bg-white/50 hover:bg-white rounded-full transition-all duration-300" data-slide="1"></button>
                    <button class="carousel-indicator w-2 h-2 bg-white/50 hover:bg-white rounded-full transition-all duration-300" data-slide="2"></button>
                    <button class="carousel-indicator w-2 h-2 bg-white/50 hover:bg-white rounded-full transition-all duration-300" data-slide="3"></button>
                </div>
            </div>
        </div>

        <script>
        document.addEventListener('turbo:load', function initCarousel() {
            const carousel = document.querySelector('#hero .carousel');
            if (!carousel) return;
            if (carousel.dataset.initialized === 'true') return;
            carousel.dataset.initialized = 'true';
            
            const track = carousel.querySelector('.carousel-track');
            const slides = carousel.querySelectorAll('.carousel-slide');
            const prevBtn = carousel.querySelector('.carousel-control.prev');
            const nextBtn = carousel.querySelector('.carousel-control.next');
            const indicators = carousel.querySelectorAll('.carousel-indicator');
            
            let currentSlide = 0;
            let isTransitioning = false;
            
            // Clone slides for infinite loop
            const firstSlideClone = slides[0].cloneNode(true);
            const lastSlideClone = slides[slides.length - 1].cloneNode(true);
            track.appendChild(firstSlideClone);
            track.insertBefore(lastSlideClone, slides[0]);
            
            // Update slide count
            const allSlides = track.querySelectorAll('.carousel-slide');
            const totalSlides = allSlides.length;
            
            // Set initial position
            track.style.transform = `translateX(-${100}%)`;
            
            function goToSlide(slideIndex, instant = false) {
                if (isTransitioning) return;
                isTransitioning = true;
                
                currentSlide = slideIndex;
                
                if (instant) {
                    track.style.transition = 'none';
                } else {
                    track.style.transition = 'transform 0.5s ease-in-out';
                }
                
                track.style.transform = `translateX(-${(currentSlide + 1) * 100}%)`;
                
                // Update indicators
                // Update indicators
                indicators.forEach((indicator, index) => {
                    if (index === slideIndex % slides.length) {
                        indicator.classList.add('bg-white');
                        indicator.classList.remove('bg-white/50');
                    } else {
                        indicator.classList.remove('bg-white');
                        indicator.classList.add('bg-white/50');
                    }
                });
                
                // Handle infinite loop
                if (slideIndex === slides.length) {
                    setTimeout(() => {
                        track.style.transition = 'none';
                        track.style.transform = `translateX(-${100}%)`;
                        currentSlide = 0;
                        isTransitioning = false;
                    }, 500);
                } else if (slideIndex === -1) {
                    setTimeout(() => {
                        track.style.transition = 'none';
                        track.style.transform = `translateX(-${slides.length * 100}%)`;
                        currentSlide = slides.length - 1;
                        isTransitioning = false;
                    }, 500);
                } else {
                    setTimeout(() => {
                        isTransitioning = false;
                    }, 500);
                }
            }
            
            // Auto-play
            let autoplayInterval;
            let autoplayTimeout;
            
            function startAutoplay() {
                stopAutoplay();
                autoplayTimeout = setTimeout(() => {
                    goToSlide(currentSlide + 1);
                    startAutoplay(); // Restart the cycle
                }, 3000);
            }
            
            function stopAutoplay() {
                if (autoplayTimeout) {
                    clearTimeout(autoplayTimeout);
                }
                if (autoplayInterval) {
                    clearInterval(autoplayInterval);
                }
            }
            
            // Start autoplay
            startAutoplay();
            
            // Pause on hover
            carousel.addEventListener('mouseenter', () => {
                stopAutoplay();
            });
            
            carousel.addEventListener('mouseleave', () => {
                startAutoplay();
            });
            
            // Navigation controls
            prevBtn.addEventListener('click', () => {
                stopAutoplay();
                goToSlide(currentSlide - 1);
                startAutoplay();
            });
            
            nextBtn.addEventListener('click', () => {
                stopAutoplay();
                goToSlide(currentSlide + 1);
                startAutoplay();
            });
            
            // Indicator controls
            indicators.forEach((indicator, index) => {
                indicator.addEventListener('click', () => {
                    stopAutoplay();
                    goToSlide(index);
                    startAutoplay();
                });
            });
            
            // Touch support
            let startX = 0;
            let endX = 0;
            
            carousel.addEventListener('touchstart', (e) => {
                startX = e.touches[0].clientX;
            });
            
            carousel.addEventListener('touchend', (e) => {
                endX = e.changedTouches[0].clientX;
                const diff = startX - endX;
                
                if (Math.abs(diff) > 50) {
                    if (diff > 0) {
                        goToSlide(currentSlide + 1);
                    } else {
                        goToSlide(currentSlide - 1);
                    }
                }
            });
            
            // Initialize first indicator
            indicators[0].classList.add('bg-white');
            indicators[0].classList.remove('bg-white/50');
        });
        </script>
    </section>

    <!-- Sanctuary Section -->
    <section class="py-20 px-4 bg-gray-800" id="sanctuary">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-5xl font-bold text-center mb-12 text-green-400">Pawikan Patrol Sanctuary</h2>
            
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="bg-gray-800 rounded-3xl p-8 transform hover:scale-105 transition-all duration-500 shadow-lg border border-green-500/30">
                    <h3 class="text-3xl font-bold mb-6 text-green-400">Our Mission</h3>
                    <p class="text-gray-300 mb-4">
                        Pawikan Patrol is dedicated to the conservation and protection of sea turtles in Dahican, 
                        City of Mati Davao Oriental. We work tirelessly to protect nesting sites, rescue injured turtles, 
                        and educate the community about the importance of marine conservation.
                    </p>
                    <p class="text-gray-300">
                        Through our comprehensive conservation programs, we have successfully protected thousands 
                        of sea turtle nests and released hundreds of hatchlings into the ocean.
                    </p>
                </div>
                
                <div class="relative">
                    <img src="<?php echo e(asset('img/hatch3.jpg')); ?>" alt="Pawikan Patrol Sanctuary" class="rounded-2xl shadow-2xl w-full h-96 object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent rounded-2xl"></div>
                    <div class="absolute bottom-6 left-6 right-6">
                        <div class="bg-gray-800/90 rounded-xl p-4">
                            <h4 class="text-xl font-bold mb-2 text-green-400">Location: Dahican, City of Mati</h4>
                            <p class="text-gray-300">A pristine 7-kilometer beach known for its sea turtle nesting grounds</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Sanctuary Features -->
            <div class="grid md:grid-cols-3 gap-8 mt-16">
                <div class="bg-gray-800 rounded-2xl p-6 transform hover:scale-105 transition-all duration-300 border-l-4 border-green-500 shadow-md">
                    <div class="text-4xl mb-4">🏖️</div>
                    <h3 class="text-xl font-bold mb-3 text-green-400">Nesting Protection</h3>
                    <p class="text-gray-300">24/7 monitoring and protection of sea turtle nesting sites along Dahican beach</p>
                </div>
                
                <div class="bg-gray-800 rounded-2xl p-6 transform hover:scale-105 transition-all duration-300 border-l-4 border-green-500 shadow-md">
                    <div class="text-4xl mb-4">🏥</div>
                    <h3 class="text-xl font-bold mb-3 text-green-400">Rescue Center</h3>
                    <p class="text-gray-300">Medical care and rehabilitation for injured and sick sea turtles</p>
                </div>
                
                <div class="bg-gray-800 rounded-2xl p-6 transform hover:scale-105 transition-all duration-300 border-l-4 border-green-500 shadow-md">
                    <div class="text-4xl mb-4">🎓</div>
                    <h3 class="text-xl font-bold mb-3 text-green-400">Education</h3>
                    <p class="text-gray-300">Community outreach and educational programs about marine conservation</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Vision Section -->
    <section class="py-20 px-4 bg-gray-900 fade-in-up visible" id="vision">
        <div class="max-w-6xl mx-auto text-center">
            <h2 class="text-5xl font-bold mb-12 text-green-400">Vision and Goals</h2>
            
            <div class="grid md:grid-cols-2 gap-12 items-start">
                <div class="bg-gray-900 rounded-3xl p-8 transform hover:scale-105 transition-all duration-500 shadow-lg border border-green-500/30">
                    <h3 class="text-3xl font-bold mb-6 text-green-400">Our Vision</h3>
                    <p class="text-gray-300 mb-4">
                        We envision a future where sea turtles thrive in their natural habitat, free from threats 
                        and human interference. Our goal is to create a sustainable environment where these 
                        magnificent creatures can continue their ancient journey for generations to come.
                    </p>
                    <p class="text-gray-300">
                        Through dedicated conservation efforts, community engagement, and scientific research, 
                        we strive to be a beacon of hope for marine conservation in the Philippines.
                    </p>
                </div>
                
                <div class="bg-gray-900 rounded-3xl p-8 transform hover:scale-105 transition-all duration-500 shadow-lg border border-green-500/30">
                    <h3 class="text-3xl font-bold mb-6 text-green-400">Our Goals</h3>
                    <ul class="text-left space-y-3 text-gray-300">
                         <li class="flex items-start gap-3">
                            <span class="text-green-400 mt-1">✓</span>
                            <span>Educate Community Members</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-green-400 mt-1">✓</span>
                            <span>Explore the Species with the 3D Explorer</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-green-400 mt-1">✓</span>
                            <span>Monitor Reported sites using the Patrol Map</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-green-400 mt-1">✓</span>
                            <span>Learn conservation through interactive Games</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Video Showcase Section -->
    <section class="py-20 px-4 bg-gray-800" id="video-showcase">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-5xl font-bold text-center mb-20 text-green-400">Quest for Love: Amihan sa Dahican</h2>
            
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <!-- Video Container -->
                <div class="relative group">
                    <div class="bg-gray-800 rounded-3xl p-4 transform hover:scale-105 transition-all duration-500 shadow-lg border border-green-500/30">
                        <div class="relative rounded-2xl overflow-hidden" style="padding-bottom: 56.25%; height: 0;">
                            <!-- YouTube Video Embed -->
                            <iframe 
                                id="amihan-video"
                                class="absolute top-0 left-0 w-full h-full rounded-xl" 
                                src="https://www.youtube.com/embed/nzKU4c66uP8?enablejsapi=1&origin=<?php echo e(request()->getSchemeAndHttpHost()); ?>" 
                                title="Quest for Love: Amihan sa Dahican" 
                                frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                allowfullscreen
                                loading="lazy"
                            ></iframe>
                        </div>
                        
                        <!-- Video Attribution -->
                        <div class="mt-4 text-center">
                            <p class="text-sm text-gray-400">
                                <span class="text-ocean-300">📹 Video Source:</span> 
                                <a href="https://www.youtube.com/watch?v=nzKU4c66uP8" target="_blank" rel="noopener noreferrer" class="font-semibold text-gray-300 hover:text-ocean-300 transition-colors duration-300">
                                    YouTube - Jebel Musa
                                </a>
                            </p>
                            <p class="text-xs text-gray-500 mt-1">
                                © Amihan sa Dahican People's Organization. All rights reserved.
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Description Container -->
                <div class="bg-gray-800 rounded-3xl p-8 lg:p-10 transform hover:scale-105 transition-all duration-500 shadow-lg border border-green-500/30">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-green-500/20 rounded-full flex items-center justify-center">
                            <span class="text-2xl">🌊</span>
                        </div>
                        <h3 class="text-3xl font-bold text-green-400">Community Conservation</h3>
                    </div>
                    
                    <div class="space-y-4 text-gray-300">
                        <p class="leading-relaxed">
                            Discover the inspiring story of <strong class="text-green-400">Amihan sa Dahican</strong>, 
                            a dedicated People's Organization in Brgy. Dahican, Mati City, Davao Oriental. 
                            This video showcases their unwavering commitment to the protection and conservation 
                            of sea turtles and marine ecosystems.
                        </p>
                        
                        <p class="leading-relaxed">
                            Through community-driven initiatives and passionate advocacy, Amihan sa Dahican 
                            demonstrates how local organizations can make a significant impact in preserving 
                            our natural heritage. Their work embodies the spirit of environmental stewardship 
                            and community collaboration.
                        </p>
                        
                        <div class="pt-4 border-t border-green-500/30 mt-6">
                            <h4 class="text-xl font-bold text-green-400 mb-3">Featured in This Video:</h4>
                            <ul class="space-y-2">
                                <li class="flex items-start gap-3">
                                    <span class="text-green-400 mt-1">✓</span>
                                    <span>Community-based conservation efforts in Dahican</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <span class="text-green-400 mt-1">✓</span>
                                    <span>Local advocacy for sea turtle protection</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <span class="text-green-400 mt-1">✓</span>
                                    <span>Environmental stewardship and education</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <span class="text-green-400 mt-1">✓</span>
                                    <span>Collaborative approach to marine conservation</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Additional Info Banner -->
            <div class="mt-12 text-center">
                <div class="bg-gray-900 rounded-2xl p-6 max-w-4xl mx-auto border border-green-500/30 shadow-lg">
                    <p class="text-gray-300">
                         "Together, communities like Amihan sa Dahican are creating a sustainable 
                            future where sea turtles and marine life can thrive for generations to come."
                    </p>
                </div>
            </div>
        </div>
        
        <!-- YouTube IFrame API Script -->
        <script>
            (function() {
                var player;
                var checkTime;
                var pauseTime = 98;
                var hasPaused = false;

                window.onYouTubeIframeAPIReady = function() {
                    if (player) return;
                    player = new YT.Player('amihan-video', {
                        events: {
                            'onStateChange': onPlayerStateChange
                        }
                    });
                };

                function onPlayerStateChange(event) {
                    if (event.data == YT.PlayerState.PLAYING && !hasPaused) {
                        if (checkTime) clearInterval(checkTime);
                        checkTime = setInterval(function() {
                            if (player && typeof player.getCurrentTime === 'function') {
                                try {
                                    var currentTime = player.getCurrentTime();
                                    if (currentTime >= pauseTime && !hasPaused) {
                                        player.pauseVideo();
                                        hasPaused = true;
                                        clearInterval(checkTime);
                                    }
                                } catch (e) {
                                    clearInterval(checkTime);
                                }
                            } else {
                                clearInterval(checkTime);
                            }
                        }, 500); // Increased interval to reduce noise
                    } else if (event.data == YT.PlayerState.PAUSED || event.data == YT.PlayerState.ENDED) {
                        if (checkTime) clearInterval(checkTime);
                    }
                }

                // Cleanup on navigation
                document.addEventListener('turbo:before-visit', function() {
                    if (checkTime) clearInterval(checkTime);
                    if (player && typeof player.destroy === 'function') {
                        player.destroy();
                    }
                    player = null;
                }, { once: true });
                
                // Ensure API is loaded
                if (typeof YT === 'undefined' || typeof YT.Player === 'undefined') {
                    var tag = document.createElement('script');
                    tag.src = "https://www.youtube.com/iframe_api";
                    var firstScriptTag = document.getElementsByTagName('script')[0];
                    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
                } else {
                    onYouTubeIframeAPIReady();
                }
            })();
        </script>
    </section>

    <!-- Turtle Introduction Section -->
    <section class="py-20 px-4 bg-gray-900 fade-in-up visible" id="turtle-intro">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-5xl font-bold text-center mb-12 text-green-400">Introduction to Sea Turtles</h2>
            
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <!-- Text Content -->
                <div class="bg-gray-800 rounded-3xl p-8 lg:p-10 transform hover:scale-105 transition-all duration-500 shadow-lg border border-green-500/30 order-2 md:order-1">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-green-500/20 rounded-full flex items-center justify-center">
                            <span class="text-2xl">🐢</span>
                        </div>
                        <h3 class="text-3xl font-bold text-green-400">Sea Turtles 101</h3>
                    </div>
                    
                    <div class="space-y-4 text-gray-300">
                        <p class="leading-relaxed">
                             Sea turtles have roamed the Earth's oceans for the last 110 million years. 
                             An ancient lineage of reptiles, they are a fundamental link in marine ecosystems. 
                             <strong class="text-green-400">National Geographic</strong> takes you on a journey to understand 
                             their biology, behavior, and the critical role they play in our oceans.
                        </p>
                        
                        <p class="leading-relaxed">
                            Learn about the seven species of sea turtles, their incredible migration patterns, 
                            and the challenges they face in the modern world.
                        </p>
                        
                        <div class="pt-4 border-t border-green-500/30 mt-6">
                             <h4 class="text-xl font-bold text-green-400 mb-3">Video Highlights:</h4>
                            <ul class="space-y-2">
                                <li class="flex items-start gap-3">
                                    <span class="text-green-400 mt-1">✓</span>
                                    <span>Ancient history and evolution</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <span class="text-green-400 mt-1">✓</span>
                                    <span>Nesting and life cycle overview</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <span class="text-green-400 mt-1">✓</span>
                                    <span>Conservation status and threats</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- Video Content -->
                <div class="relative group order-1 md:order-2">
                    <div class="bg-gray-800 rounded-3xl p-4 transform hover:scale-105 transition-all duration-500 shadow-lg border border-green-500/30">
                        <div class="relative rounded-2xl overflow-hidden" style="padding-bottom: 56.25%; height: 0;">
                            <iframe 
                                class="absolute top-0 left-0 w-full h-full rounded-xl" 
                                src="https://www.youtube.com/embed/5Rmv3nliwCs" 
                                title="Sea Turtles 101 | National Geographic" 
                                frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                allowfullscreen
                                loading="lazy"
                            ></iframe>
                        </div>
                        
                        <!-- Credits -->
                        <div class="mt-4 text-center">
                            <p class="text-sm text-gray-400">
                                <span class="text-ocean-300">📹 Video Source:</span> 
                                <a href="https://www.youtube.com/watch?v=5Rmv3nliwCs" target="_blank" rel="noopener noreferrer" class="font-semibold text-gray-300 hover:text-ocean-300 transition-colors duration-300">
                                    National Geographic
                                </a>
                            </p>
                            <p class="text-xs text-gray-500 mt-1">
                                © National Geographic. All rights reserved.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </section>

    <!-- Threats Section -->
    <section class="py-20 px-4 bg-gray-800 fade-in-up visible" id="threats">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-5xl font-bold text-center mb-12 text-green-400">Threats to Sea Turtles</h2>
            
            <!-- Threats Intro & Video -->
            <div class="grid md:grid-cols-2 gap-12 items-center mb-16">
                <!-- Video Content -->
                <div class="relative group">
                    <div class="bg-gray-900 rounded-3xl p-4 transform hover:scale-105 transition-all duration-500 shadow-lg border border-green-500/30">
                        <div class="relative rounded-2xl overflow-hidden" style="padding-bottom: 56.25%; height: 0;">
                            <iframe 
                                class="absolute top-0 left-0 w-full h-full rounded-xl" 
                                src="https://www.youtube.com/embed/ZaQ_AqiKz-w" 
                                title="How ocean plastic threatens sea turtles" 
                                frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                allowfullscreen
                                loading="lazy"
                            ></iframe>
                        </div>
                        <div class="mt-4 text-center">
                            <p class="text-sm text-gray-400">
                                <span class="text-ocean-300">📹 Video Source:</span> 
                                <a href="https://www.youtube.com/watch?v=ZaQ_AqiKz-w" target="_blank" rel="noopener noreferrer" class="font-semibold text-gray-300 hover:text-ocean-300 transition-colors duration-300">
                                    The Economist
                                </a>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Narrative Text -->
                <div class="bg-gray-900 rounded-3xl p-8 lg:p-10 transform hover:scale-105 transition-all duration-500 shadow-lg border border-green-500/30">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-red-500/20 rounded-full flex items-center justify-center">
                            <span class="text-2xl">⚠️</span>
                        </div>
                        <h3 class="text-3xl font-bold text-red-400">A Perilous Journey</h3>
                    </div>
                    
                    <div class="space-y-4 text-gray-300">
                        <p class="leading-relaxed">
                            It is estimated that only <strong class="text-red-400">1 in 1,000 to 10,000</strong> sea turtle hatchlings 
                            will survive to adulthood. While they have few natural predators once fully grown, 
                            human activity has introduced new, deadly challenges.
                        </p>
                        <p class="leading-relaxed">
                            <strong class="text-green-400">Ocean plastic</strong> is one of the gravest threats. 
                            Turtles often mistake floating debris for food, leading to fatal consequences. 
                            Watch the video to understand how our choices impact their survival.
                        </p>
                        

                    </div>
                </div>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Plastic Pollution -->
                <div class="bg-gray-900 rounded-2xl p-6 transform hover:scale-105 transition-all duration-300 border border-green-500/30 shadow-lg">
                    <div class="text-5xl mb-4">🗑️</div>
                    <h3 class="text-2xl font-bold mb-3 text-green-400">Plastic Pollution</h3>
                    <p class="text-gray-300 mb-4">Sea turtles often mistake plastic bags for jellyfish, their primary food source, leading to internal injuries and death.</p>
                    <ul class="text-sm text-gray-400 space-y-1">
                        <li>• Ingestion of plastic debris</li>
                        <li>• Entanglement in fishing gear</li>
                        <li>• Habitat degradation</li>
                    </ul>
                </div>
                
                <!-- Climate Change -->
                <div class="bg-gray-900 rounded-2xl p-6 transform hover:scale-105 transition-all duration-300 border border-green-500/30 shadow-lg">
                    <div class="text-5xl mb-4">🌡️</div>
                    <h3 class="text-2xl font-bold mb-3 text-green-400">Climate Change</h3>
                    <p class="text-gray-300 mb-4">Rising temperatures affect nesting beaches and skew sex ratios, while sea level rise threatens nesting habitats.</p>
                    <ul class="text-sm text-gray-400 space-y-1">
                        <li>• Altered sex ratios</li>
                        <li>• Nest flooding</li>
                        <li>• Ocean acidification</li>
                    </ul>
                </div>
                
                <!-- Poaching -->
                <div class="bg-gray-900 rounded-2xl p-6 transform hover:scale-105 transition-all duration-300 border border-green-500/30 shadow-lg">
                    <div class="text-5xl mb-4">🎣</div>
                    <h3 class="text-2xl font-bold mb-3 text-green-400">Poaching</h3>
                    <p class="text-gray-300 mb-4">Despite legal protection, sea turtles are still hunted for their meat, eggs, shells, and leather in many regions.</p>
                    <ul class="text-sm text-gray-400 space-y-1">
                        <li>• Egg collection</li>
                        <li>• Illegal fishing</li>
                        <li>• Shell trade</li>
                    </ul>
                </div>
                
                <!-- Coastal Development -->
                <div class="bg-gray-900 rounded-2xl p-6 transform hover:scale-105 transition-all duration-300 border border-green-500/30 shadow-lg">
                    <div class="text-5xl mb-4">🏗️</div>
                    <h3 class="text-2xl font-bold mb-3 text-green-400">Coastal Development</h3>
                    <p class="text-gray-300 mb-4">Beach development and artificial lighting disrupt nesting behavior and disorient hatchlings.</p>
                    <ul class="text-sm text-gray-400 space-y-1">
                        <li>• Habitat loss</li>
                        <li>• Artificial lighting</li>
                        <li>• Beach erosion</li>
                    </ul>
                </div>
                
                <!-- Fishing Bycatch -->
                <div class="bg-gray-900 rounded-2xl p-6 transform hover:scale-105 transition-all duration-300 border border-green-500/30 shadow-lg">
                    <div class="text-5xl mb-4">🎣</div>
                    <h3 class="text-2xl font-bold mb-3 text-green-400">Fishing Bycatch</h3>
                    <p class="text-gray-300 mb-4">Millions of sea turtles are accidentally caught in fishing gear each year, causing injury or death.</p>
                    <ul class="text-sm text-gray-400 space-y-1">
                        <li>• Gillnet entanglement</li>
                        <li>• Longline fishing</li>
                        <li>• Trawler nets</li>
                    </ul>
                </div>
                
                <!-- Pollution -->
                <div class="bg-gray-900 rounded-2xl p-6 transform hover:scale-105 transition-all duration-300 border border-green-500/30 shadow-lg">
                    <div class="text-5xl mb-4">☠️</div>
                    <h3 class="text-2xl font-bold mb-3 text-green-400">Chemical Pollution</h3>
                    <p class="text-gray-300 mb-4">Industrial and agricultural runoff contaminates ocean waters, affecting turtle health and food sources.</p>
                    <ul class="text-sm text-gray-400 space-y-1">
                        <li>• Oil spills</li>
                        <li>• Pesticide runoff</li>
                        <li>• Heavy metals</li>
                    </ul>
                </div>
            </div>
            
            <!-- Conservation Success Stories -->
            <div class="mt-16 text-center">
                <div class="bg-gray-900 rounded-2xl p-8 max-w-4xl mx-auto border border-green-500/30 shadow-lg">
                    <h3 class="text-3xl font-bold mb-6 text-green-400">Success Stories</h3>
                    <div class="grid md:grid-cols-2 gap-8">
                        <div class="text-left">
                            <h4 class="text-xl font-bold mb-3 text-green-400">Nesting Site Recovery</h4>
                            <p class="text-gray-300">Through our protection efforts, nesting success rates have increased from 40% to 85% in protected areas.</p>
                        </div>
                        <div class="text-left">
                            <h4 class="text-xl font-bold mb-3 text-green-400">Community Engagement</h4>
                            <p class="text-gray-300">Local communities now actively participate in conservation, reporting nesting activities and protecting nests.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Lifecycle Section -->
    <section class="py-20 px-4 bg-gray-900 fade-in-up visible" id="lifecycle">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-5xl font-bold text-center mb-12 text-green-400">Pawikan Life Journey</h2>
            
            <!-- Enhanced Lifecycle Timeline -->
            <div class="relative">
                <!-- Animated Timeline (desktop only) -->
                <div class="hidden lg:block absolute left-1/2 transform -translate-x-1/2 w-2 h-full bg-gradient-to-b from-green-500 via-green-600 to-green-700 rounded-full shadow-lg">
                    <div class="absolute inset-0 bg-gradient-to-b from-transparent via-white/20 to-transparent animate-pulse"></div>
                </div>
                
                <div class="space-y-14 lg:space-y-20">
                    <!-- Stage 1: Nesting -->
                    <div class="relative flex flex-col lg:flex-row items-center gap-6">
                        <div class="hidden lg:block absolute left-1/2 transform -translate-x-1/2 w-6 h-6 bg-green-600 rounded-full border-4 border-white shadow-lg z-10"></div>
                        <div class="w-full lg:w-1/2 lg:text-right lg:pr-12">
                            <div class="bg-gray-900 rounded-3xl p-4 lg:p-6 transform hover:scale-105 transition-all duration-500 shadow-lg border border-green-500/30">
                                <div class="flex items-center gap-4 mb-6">
                                    <span class="text-4xl">🥚</span>
                                    <h3 class="text-2xl sm:text-3xl font-bold text-green-400">1. Nesting</h3>
                                </div>
                                <div class="bg-gray-800 rounded-2xl p-6 shadow-xl text-left border-l-8 border-green-500 border-green-500/20">
                                    <p class="text-gray-200 mb-4 text-lg font-medium leading-relaxed">
                                        Mother turtles return to Dahican Beach to lay their eggs, 
                                        continuing an ancient cycle that connects generations of Pawikan.
                                    </p>
                                    <div class="text-sm text-gray-400 space-y-1">
                                        <div class="flex items-center gap-2"><span class="text-green-400">📅</span> <strong class="text-gray-300">Season:</strong> November to March</div>
                                        <div class="flex items-center gap-2"><span class="text-green-400">⏱️</span> <strong class="text-gray-300">Duration:</strong> 2-3 hours per nest</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="hidden lg:block w-1/2 pl-12"></div>
                    </div>

                    <!-- Stage 2: Incubation -->
                    <div class="relative flex flex-col lg:flex-row items-center gap-6">
                        <div class="hidden lg:block w-1/2 pr-12"></div>
                        <div class="hidden lg:block absolute left-1/2 transform -translate-x-1/2 w-6 h-6 bg-green-600 rounded-full border-4 border-white shadow-lg z-10"></div>
                        <div class="w-full lg:w-1/2 lg:pl-12">
                            <div class="bg-gray-900 rounded-3xl p-4 lg:p-6 transform hover:scale-105 transition-all duration-500 shadow-lg border border-green-500/30">
                                <div class="flex items-center gap-4 mb-6">
                                    <span class="text-4xl">🌡️</span>
                                    <h3 class="text-2xl sm:text-3xl font-bold text-green-400">2. Incubation</h3>
                                </div>
                                <div class="bg-gray-800 rounded-2xl p-6 shadow-xl text-left border-l-8 border-green-500 border-green-500/20">
                                    <p class="text-gray-200 mb-4 text-lg font-medium leading-relaxed">
                                        Eggs incubate in warm sand for 45-70 days, with temperature 
                                        determining the hatchlings' gender - warmer for females, cooler for males.
                                    </p>
                                    <div class="text-sm text-gray-400 space-y-1">
                                        <div class="flex items-center gap-2"><span class="text-green-400">🌡️</span> <strong class="text-gray-300">Temperature:</strong> 29-30°C optimal</div>
                                        <div class="flex items-center gap-2"><span class="text-green-400">📈</span> <strong class="text-gray-300">Success Rate:</strong> 80-90% in protected nests</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Stage 3: Hatching -->
                    <div class="relative flex flex-col lg:flex-row items-center gap-6">
                        <div class="hidden lg:block absolute left-1/2 transform -translate-x-1/2 w-6 h-6 bg-green-600 rounded-full border-4 border-white shadow-lg z-10"></div>
                        <div class="w-full lg:w-1/2 lg:text-right lg:pr-12">
                            <div class="bg-gray-900 rounded-3xl p-4 lg:p-6 transform hover:scale-105 transition-all duration-500 shadow-lg border border-green-500/30">
                                <div class="flex items-center gap-4 mb-6">
                                    <span class="text-4xl">🐣</span>
                                    <h3 class="text-2xl sm:text-3xl font-bold text-green-400">3. Hatching</h3>
                                </div>
                                <div class="bg-gray-800 rounded-2xl p-6 shadow-xl text-left border-l-8 border-green-500 border-green-500/20">
                                    <p class="text-gray-200 mb-4 text-lg font-medium leading-relaxed">
                                        Hatchlings emerge together at night, using their egg tooth 
                                        to break shells and dig their way to the surface as a team.
                                    </p>
                                    <div class="text-sm text-gray-400 space-y-1">
                                        <div class="flex items-center gap-2"><span class="text-green-400">🌙</span> <strong class="text-gray-300">Emergence:</strong> Usually at night</div>
                                        <div class="flex items-center gap-2"><span class="text-green-400">👥</span> <strong class="text-gray-300">Group Size:</strong> 50-200 hatchlings</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="hidden lg:block w-1/2 pl-12"></div>
                    </div>

                    <!-- Stage 4: The Lost Years -->
                    <div class="relative flex flex-col lg:flex-row items-center gap-6">
                        <div class="hidden lg:block w-1/2 pr-12"></div>
                        <div class="hidden lg:block absolute left-1/2 transform -translate-x-1/2 w-6 h-6 bg-green-600 rounded-full border-4 border-white shadow-lg z-10"></div>
                        <div class="w-full lg:w-1/2 lg:pl-12">
                            <div class="bg-gray-900 rounded-3xl p-4 lg:p-6 transform hover:scale-105 transition-all duration-500 shadow-lg border border-green-500/30">
                                <div class="flex items-center gap-4 mb-6">
                                    <span class="text-4xl">🌊</span>
                                    <h3 class="text-2xl sm:text-3xl font-bold text-green-400">4. Oceanic Voyage</h3>
                                </div>
                                <div class="bg-gray-800 rounded-2xl p-6 shadow-xl text-left border-l-8 border-green-500 border-green-500/20">
                                    <p class="text-gray-200 mb-4 text-lg font-medium leading-relaxed">
                                        Young turtles drift with ocean currents for 1-10 years, 
                                        feeding on plankton and growing rapidly in the open sea.
                                    </p>
                                    <div class="text-sm text-gray-400 space-y-1">
                                        <div class="flex items-center gap-2"><span class="text-green-400">⌛</span> <strong class="text-gray-300">Duration:</strong> 1-10 years</div>
                                        <div class="flex items-center gap-2"><span class="text-green-400">🌍</span> <strong class="text-gray-300">Location:</strong> Open ocean currents</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Stage 5: Adulthood -->
                    <div class="relative flex flex-col lg:flex-row items-center gap-6">
                        <div class="hidden lg:block absolute left-1/2 transform -translate-x-1/2 w-6 h-6 bg-green-600 rounded-full border-4 border-white shadow-lg z-10"></div>
                        <div class="w-full lg:w-1/2 lg:text-right lg:pr-12">
                            <div class="bg-gray-900 rounded-3xl p-4 lg:p-6 transform hover:scale-105 transition-all duration-500 shadow-lg border border-green-500/30">
                                <div class="flex items-center gap-4 mb-6">
                                    <span class="text-4xl">🐢</span>
                                    <h3 class="text-2xl sm:text-3xl font-bold text-green-400">5. Adulthood</h3>
                                </div>
                                <div class="bg-gray-800 rounded-2xl p-6 shadow-xl text-left border-l-8 border-green-500 border-green-500/20">
                                    <p class="text-gray-200 mb-4 text-lg font-medium leading-relaxed">
                                        Mature turtles return to coastal waters at 20-50 years old, 
                                        ready to nest and continue the ancient cycle of life.
                                    </p>
                                    <div class="text-sm text-gray-400 space-y-1">
                                        <div class="flex items-center gap-2"><span class="text-green-400">🐢</span> <strong class="text-gray-300">Maturity:</strong> 20-50 years</div>
                                        <div class="flex items-center gap-2"><span class="text-green-400">🔄</span> <strong class="text-gray-300">Lifespan:</strong> 50-100+ years</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="hidden lg:block w-1/2 pl-12"></div>
                    </div>
                </div>
            </div>
            
            <!-- Conservation Impact Text -->
            <div class="mt-20 text-center">
                <div class="bg-gray-900 rounded-3xl p-10 max-w-6xl mx-auto shadow-2xl border border-green-500/30">
                    <h3 class="text-3xl font-bold mb-8 text-green-400">Protecting the Pawikan Journey</h3>
                    <p class="text-gray-300 text-lg leading-relaxed max-w-4xl mx-auto">
                        Every Pawikan's life journey begins with a fragile nest on sandy shores. 
                        Our conservation work ensures these ancient mariners can safely complete their cycle 
                        from nesting mothers to ocean-adventuring hatchlings, and finally to returning adults 
                        that will continue this sacred journey for generations to come.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Species Section -->
    <section class="py-20 px-4 bg-gray-800 fade-in-up visible" id="species">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-5xl font-bold text-center mb-12 text-green-400">Species Found in Dahican</h2>
            
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Green Sea Turtle -->
                <div class="bg-gray-800 rounded-2xl p-6 transform hover:scale-105 transition-all duration-300 border border-green-500/30 shadow-lg">
                    <div class="text-center mb-6">
                        <div class="relative inline-block group">
                            <div class="species-image-container relative w-36 h-36 mx-auto mb-4">
                                <img src="<?php echo e(asset('img/green-sea-turtle.png')); ?>" alt="Green Sea Turtle" class="species-image w-36 h-36 rounded-full object-cover border-4 border-green-500/30 absolute top-0 left-0 transition-opacity duration-300 ease-in-out group-hover:opacity-0">
                                <img src="<?php echo e(asset('img/baby-green-turtle.png')); ?>" alt="Baby Green Sea Turtle" class="species-image-hover w-36 h-36 rounded-full object-cover border-4 border-green-500/30 absolute top-0 left-0 transition-opacity duration-300 ease-in-out opacity-0 group-hover:opacity-100">
                            </div>
                            <div class="absolute -bottom-2 -right-2 bg-green-500 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold">1</div>
                        </div>
                        <h3 class="text-2xl font-bold text-green-400">Green Sea Turtle</h3>
                        <p class="text-gray-400 italic">Chelonia mydas</p>
                        <div class="species-description mt-3 relative h-12">
                            <p class="text-sm text-gray-300 transition-opacity duration-300 ease-in-out absolute top-0 left-0 w-full group-hover:opacity-0">Named for their green fat tissue, these turtles are the most common species in Dahican.</p>
                            <p class="text-sm text-green-300 transition-opacity duration-300 ease-in-out opacity-0 absolute top-0 left-0 w-full group-hover:opacity-100">Baby green turtles hatch from eggs and instinctively crawl to the sea, beginning their incredible ocean journey.</p>
                        </div>
                    </div>
                    <div class="space-y-3 text-gray-300">
                        <p><strong>Size:</strong> Up to 1.5 meters</p>
                        <p><strong>Weight:</strong> Up to 200 kg</p>
                        <p><strong>Diet:</strong> Herbivorous (seagrass, algae)</p>
                        <p><strong>Status:</strong> <span class="text-green-300">Endangered</span></p>
                        <p class="text-sm">Named for their green fat tissue, these turtles are the most common species in Dahican.</p>
                    </div>
                </div>
                
                <!-- Hawksbill Sea Turtle -->
                <div class="bg-gray-800 rounded-2xl p-6 transform hover:scale-105 transition-all duration-300 border border-green-500/30 shadow-lg">
                    <div class="text-center mb-6">
                        <div class="relative inline-block group">
                            <div class="species-image-container relative w-36 h-36 mx-auto mb-4">
                                <img src="<?php echo e(asset('img/hawksbill-sea-turtle.png')); ?>" alt="Hawksbill Sea Turtle" class="species-image w-36 h-36 rounded-full object-cover border-4 border-green-500/30 absolute top-0 left-0 transition-opacity duration-300 ease-in-out group-hover:opacity-0">
                                <img src="<?php echo e(asset('img/baby-hawksbillturtle.png')); ?>" alt="Baby Hawksbill Sea Turtle" class="species-image-hover w-36 h-36 rounded-full object-cover border-4 border-green-500/30 absolute top-0 left-0 transition-opacity duration-300 ease-in-out opacity-0 group-hover:opacity-100">
                            </div>
                            <div class="absolute -bottom-2 -right-2 bg-green-500 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold">2</div>
                        </div>
                        <h3 class="text-2xl font-bold text-green-400">Hawksbill Turtle</h3>
                        <p class="text-gray-400 italic">Eretmochelys imbricata</p>
                        <div class="species-description mt-3 relative h-12">
                            <p class="text-sm text-gray-300 transition-opacity duration-300 ease-in-out absolute top-0 left-0 w-full group-hover:opacity-0">Recognizable by their distinctive hawk-like beak and beautiful patterned shells.</p>
                            <p class="text-sm text-green-300 transition-opacity duration-300 ease-in-out opacity-0 absolute top-0 left-0 w-full group-hover:opacity-100">Baby hawksbills are born with intricate shell patterns that will become more defined as they mature.</p>
                        </div>
                    </div>
                    <div class="space-y-3 text-gray-300">
                        <p><strong>Size:</strong> Up to 1 meter</p>
                        <p><strong>Weight:</strong> Up to 80 kg</p>
                        <p><strong>Diet:</strong> Sponges, jellyfish</p>
                        <p><strong>Status:</strong> <span class="text-green-300">Critically Endangered</span></p>
                        <p class="text-sm">Known for their beautiful shell pattern, they play a crucial role in coral reef ecosystems.</p>
                    </div>
                </div>
                
                <!-- Olive Ridley Sea Turtle -->
                <div class="bg-gray-800 rounded-2xl p-6 transform hover:scale-105 transition-all duration-300 border border-green-500/30 shadow-lg">
                    <div class="text-center mb-6">
                        <div class="relative inline-block group">
                            <div class="species-image-container relative w-36 h-36 mx-auto mb-4">
                                <img src="<?php echo e(asset('img/olive-sea-turtle.png')); ?>" alt="Olive Ridley Sea Turtle" class="species-image w-36 h-36 rounded-full object-cover border-4 border-green-500/30 absolute top-0 left-0 transition-opacity duration-300 ease-in-out group-hover:opacity-0">
                                <img src="<?php echo e(asset('img/baby-olive-turtle.png')); ?>" alt="Baby Olive Ridley Sea Turtle" class="species-image-hover w-36 h-36 rounded-full object-cover border-4 border-green-500/30 absolute top-0 left-0 transition-opacity duration-300 ease-in-out opacity-0 group-hover:opacity-100">
                            </div>
                            <div class="absolute -bottom-2 -right-2 bg-green-500 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold">3</div>
                        </div>
                        <h3 class="text-2xl font-bold text-green-400">Olive Ridley</h3>
                        <p class="text-gray-400 italic">Lepidochelys olivacea</p>
                        <div class="species-description mt-3 relative h-12">
                            <p class="text-sm text-gray-300 transition-opacity duration-300 ease-in-out absolute top-0 left-0 w-full group-hover:opacity-0">Known for mass nesting events called arribadas, where thousands come ashore simultaneously.</p>
                            <p class="text-sm text-green-300 transition-opacity duration-300 ease-in-out opacity-0 absolute top-0 left-0 w-full group-hover:opacity-100">Baby olive ridleys emerge in coordinated groups during arribadas, increasing their survival chances.</p>
                        </div>
                    </div>
                    <div class="space-y-3 text-gray-300">
                        <p><strong>Size:</strong> Up to 70 cm</p>
                        <p><strong>Weight:</strong> Up to 45 kg</p>
                        <p><strong>Diet:</strong> Crabs, shrimp, jellyfish</p>
                        <p><strong>Status:</strong> <span class="text-green-300">Vulnerable</span></p>
                        <p class="text-sm">The smallest sea turtle species, known for their mass nesting events called arribadas.</p>
                    </div>
                </div>
            </div>

            <!-- Conservation Status -->
            <div class="mt-16 text-center">
                <div class="bg-gray-800 rounded-2xl p-8 max-w-4xl mx-auto border border-green-500/30 shadow-lg">
                    <h3 class="text-3xl font-bold mb-6 text-green-400">Conservation Status</h3>
                    <div class="grid md:grid-cols-3 gap-6">
                        <div class="text-center">
                            <div class="w-16 h-16 bg-green-600 rounded-full mx-auto mb-3 flex items-center justify-center">
                                <span class="text-white font-bold text-xl">!</span>
                            </div>
                            <h4 class="font-bold text-green-400 mb-2">Critically Endangered</h4>
                            <p class="text-sm text-gray-300">Extremely high risk of extinction</p>
                        </div>
                        <div class="text-center">
                            <div class="w-16 h-16 bg-green-600 rounded-full mx-auto mb-3 flex items-center justify-center">
                                <span class="text-white font-bold text-xl">⚠</span>
                            </div>
                            <h4 class="font-bold text-green-400 mb-2">Endangered</h4>
                            <p class="text-sm text-gray-300">High risk of extinction</p>
                        </div>
                        <div class="text-center">
                            <div class="w-16 h-16 bg-green-600 rounded-full mx-auto mb-3 flex items-center justify-center">
                                <span class="text-white font-bold text-xl">⚡</span>
                            </div>
                            <h4 class="font-bold text-green-400 mb-2">Vulnerable</h4>
                            <p class="text-sm text-gray-300">High risk of endangerment</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Guidelines Section -->
    <section class="py-20 px-4 bg-gray-900 fade-in-up visible" id="guidelines">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-5xl font-bold text-center mb-12 text-green-400">Conservation Guidelines</h2>
            
            <div class="grid md:grid-cols-2 gap-12">
                <!-- Beach Guidelines -->
                <div class="bg-gray-900 rounded-2xl p-8 border border-green-500/30 shadow-lg">
                    <h3 class="text-2xl font-bold mb-6 text-green-400">Beach Guidelines</h3>
                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <span class="text-green-400 mt-1">🚫</span>
                            <div>
                                <h4 class="font-bold text-green-400">No Flash Photography</h4>
                                <p class="text-gray-300 text-sm">Avoid using flash lights or cameras near nesting turtles and hatchlings</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="text-green-400 mt-1">🤫</span>
                            <div>
                                <h4 class="font-bold text-green-400">Keep Noise Levels Low</h4>
                                <p class="text-gray-300 text-sm">Speak softly and avoid sudden movements near turtles</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="text-green-400 mt-1">👥</span>
                            <div>
                                <h4 class="font-bold text-green-400">Maintain Distance</h4>
                                <p class="text-gray-300 text-sm">Stay at least 10 meters away from nesting turtles and hatchlings</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="text-green-400 mt-1">🗑️</span>
                            <div>
                                <h4 class="font-bold text-green-400">Leave No Trace</h4>
                                <p class="text-gray-300 text-sm">Take all trash with you and leave the beach clean</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="text-green-400 mt-1">🏖️</span>
                            <div>
                                <h4 class="font-bold text-green-400">Fill Beach Holes</h4>
                                <p class="text-gray-300 text-sm">Fill any holes you dig to prevent hatchlings from getting trapped</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Observer Guidelines -->
                <div class="bg-gray-900 rounded-2xl p-8 border border-green-500/30 shadow-lg">
                    <h3 class="text-2xl font-bold mb-6 text-green-400">Observer Guidelines</h3>
                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <span class="text-green-400 mt-1">👁️</span>
                            <div>
                                <h4 class="font-bold text-green-400">Watch from Behind</h4>
                                <p class="text-gray-300 text-sm">Position yourself behind the turtle to avoid blocking her path</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="text-green-400 mt-1">⏰</span>
                            <div>
                                <h4 class="font-bold text-green-400">Be Patient</h4>
                                <p class="text-gray-300 text-sm">Nesting can take 2-3 hours, remain quiet and still</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="text-green-400 mt-1">📱</span>
                            <div>
                                <h4 class="font-bold text-green-400">No Screen Lights</h4>
                                <p class="text-gray-300 text-sm">Turn off phone screens and other electronic devices</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="text-green-400 mt-1">🚶</span>
                            <div>
                                <h4 class="font-bold text-green-400">Move Carefully</h4>
                                <p class="text-gray-300 text-sm">Walk slowly and avoid sudden movements</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="text-green-400 mt-1">📸</span>
                            <div>
                                <h4 class="font-bold text-green-400">No Selfies</h4>
                                <p class="text-gray-300 text-sm">Never approach turtles for photos or selfies</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Conservation Message -->
            <div class="mt-12 text-center">
                <div class="bg-gray-900 rounded-2xl p-6 inline-block border border-green-500/30 shadow-lg">
                    <p class="text-xl text-white font-semibold">
                        🌊 Every small action counts — together, we can protect our sea turtles for generations to come! 
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- DOs and DON'Ts Section -->
    <section class="py-20 px-4 bg-gray-800 fade-in-up visible" id="dos-donts">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-5xl font-bold text-center mb-12 text-green-400">DOs and DON'Ts</h2>  
            <div class="grid md:grid-cols-2 gap-8">
                <!-- DOs Column -->
                <div class="bg-gray-800 rounded-3xl p-8 border border-green-500/30 shadow-lg">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center">
                            <span class="text-2xl">✓</span>
                        </div>
                        <h3 class="text-3xl font-bold text-green-400">DO</h3>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="flex items-start gap-3 p-4 bg-green-500/10 rounded-xl border border-green-500/20 hover:bg-green-500/20 transition-all duration-300">
                            <span class="text-green-400 text-xl mt-1">✓</span>
                            <div>
                                <h4 class="font-bold text-green-300 mb-1">Observe from a Distance</h4>
                                <p class="text-gray-300 text-sm">Maintain at least 10 meters (33 feet) away from nesting turtles and hatchlings to avoid disturbing them.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-3 p-4 bg-green-500/10 rounded-xl border border-green-500/20 hover:bg-green-500/20 transition-all duration-300">
                            <span class="text-green-400 text-xl mt-1">✓</span>
                            <div>
                                <h4 class="font-bold text-green-300 mb-1">Use Red Lights Only</h4>
                                <p class="text-gray-300 text-sm">If you need light at night, use red-filtered flashlights which don't disturb turtles.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-3 p-4 bg-green-500/10 rounded-xl border border-green-500/20 hover:bg-green-500/20 transition-all duration-300">
                            <span class="text-green-400 text-xl mt-1">✓</span>
                            <div>
                                <h4 class="font-bold text-green-300 mb-1">Report Sightings</h4>
                                <p class="text-gray-300 text-sm">Contact Pawikan Patrol immediately if you spot nesting turtles or injured animals.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-3 p-4 bg-green-500/10 rounded-xl border border-green-500/20 hover:bg-green-500/20 transition-all duration-300">
                            <span class="text-green-400 text-xl mt-1">✓</span>
                            <div>
                                <h4 class="font-bold text-green-300 mb-1">Keep the Beach Clean</h4>
                                <p class="text-gray-300 text-sm">Always take your trash with you and participate in beach cleanup activities.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-3 p-4 bg-green-500/10 rounded-xl border border-green-500/20 hover:bg-green-500/20 transition-all duration-300">
                            <span class="text-green-400 text-xl mt-1">✓</span>
                            <div>
                                <h4 class="font-bold text-green-300 mb-1">Stay Quiet and Calm</h4>
                                <p class="text-gray-300 text-sm">Speak in low voices and move slowly to avoid startling the turtles.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-3 p-4 bg-green-500/10 rounded-xl border border-green-500/20 hover:bg-green-500/20 transition-all duration-300">
                            <span class="text-green-400 text-xl mt-1">✓</span>
                            <div>
                                <h4 class="font-bold text-green-300 mb-1">Follow Guide Instructions</h4>
                                <p class="text-gray-300 text-sm">Always listen to and follow the instructions of authorized Pawikan Patrol guides.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-3 p-4 bg-green-500/10 rounded-xl border border-green-500/20 hover:bg-green-500/20 transition-all duration-300">
                            <span class="text-green-400 text-xl mt-1">✓</span>
                            <div>
                                <h4 class="font-bold text-green-300 mb-1">Fill in Beach Holes</h4>
                                <p class="text-gray-300 text-sm">Fill any holes or sandcastles before leaving to prevent hatchlings from getting trapped.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-3 p-4 bg-green-500/10 rounded-xl border border-green-500/20 hover:bg-green-500/20 transition-all duration-300">
                            <span class="text-green-400 text-xl mt-1">✓</span>
                            <div>
                                <h4 class="font-bold text-green-300 mb-1">Educate Others</h4>
                                <p class="text-gray-300 text-sm">Share conservation knowledge with friends and family to spread awareness.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- DON'Ts Column -->
                <div class="bg-gray-800 rounded-3xl p-8 border border-white/30 shadow-lg">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-gray-700 rounded-full flex items-center justify-center">
                            <span class="text-2xl text-white">✗</span>
                        </div>
                        <h3 class="text-3xl font-bold text-white">DON'T</h3>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="flex items-start gap-3 p-4 bg-white/10 rounded-xl border border-white/20 hover:bg-white/20 transition-all duration-300">
                            <span class="text-white text-xl mt-1">✗</span>
                            <div>
                                <h4 class="font-bold text-white mb-1">Don't Touch or Ride Turtles</h4>
                                <p class="text-gray-300 text-sm">Never touch, ride, or harass sea turtles. This causes stress and can harm them.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-3 p-4 bg-white/10 rounded-xl border border-white/20 hover:bg-white/20 transition-all duration-300">
                            <span class="text-white text-xl mt-1">✗</span>
                            <div>
                                <h4 class="font-bold text-white mb-1">Don't Use Flash Photography</h4>
                                <p class="text-gray-300 text-sm">Flash lights and camera flashes disorient turtles and can cause them to abandon nesting.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-3 p-4 bg-white/10 rounded-xl border border-white/20 hover:bg-white/20 transition-all duration-300">
                            <span class="text-white text-xl mt-1">✗</span>
                            <div>
                                <h4 class="font-bold text-white mb-1">Don't Block Their Path</h4>
                                <p class="text-gray-300 text-sm">Never stand between a turtle and the ocean, or block their nesting path.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-3 p-4 bg-white/10 rounded-xl border border-white/20 hover:bg-white/20 transition-all duration-300">
                            <span class="text-white text-xl mt-1">✗</span>
                            <div>
                                <h4 class="font-bold text-white mb-1">Don't Leave Trash on Beach</h4>
                                <p class="text-gray-300 text-sm">Plastic bags and debris can be mistaken for food and harm or kill turtles.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-3 p-4 bg-white/10 rounded-xl border border-white/20 hover:bg-white/20 transition-all duration-300">
                            <span class="text-white text-xl mt-1">✗</span>
                            <div>
                                <h4 class="font-bold text-white mb-1">Don't Disturb Nests</h4>
                                <p class="text-gray-300 text-sm">Never dig up or disturb turtle nests. This is illegal and harmful to eggs.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-3 p-4 bg-white/10 rounded-xl border border-white/20 hover:bg-white/20 transition-all duration-300">
                            <span class="text-white text-xl mt-1">✗</span>
                            <div>
                                <h4 class="font-bold text-white mb-1">Don't Make Loud Noises</h4>
                                <p class="text-gray-300 text-sm">Loud sounds and sudden movements can scare turtles away from nesting.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-3 p-4 bg-white/10 rounded-xl border border-white/20 hover:bg-white/20 transition-all duration-300">
                            <span class="text-white text-xl mt-1">✗</span>
                            <div>
                                <h4 class="font-bold text-white mb-1">Don't Use White Lights at Night</h4>
                                <p class="text-gray-300 text-sm">White lights confuse hatchlings and lead them away from the ocean.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-3 p-4 bg-white/10 rounded-xl border border-white/20 hover:bg-white/20 transition-all duration-300">
                            <span class="text-white text-xl mt-1">✗</span>
                            <div>
                                <h4 class="font-bold text-white mb-1">Don't Take Selfies with Turtles</h4>
                                <p class="text-gray-300 text-sm">Getting close for photos stresses turtles and interrupts critical behaviors.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Important Notice -->
            <div class="mt-12 text-center">
                <div class="bg-gray-800 rounded-2xl p-8 max-w-4xl mx-auto border border-green-500/30 shadow-lg">
                    <div class="flex items-center justify-center gap-3 mb-4">
                        <span class="text-4xl">⚠️</span>
                        <h3 class="text-2xl font-bold text-green-400">Remember</h3>
                    </div>
                    <p class="text-gray-300 text-lg leading-relaxed">
                        Sea turtles are precious endangered creatures that have survived for millions of years. 
                        Your respectful actions and mindful behavior can help ensure their survival for future generations. 
                        Together, we can make a difference in protecting Dahican's precious marine life.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- How to Help Section -->
    <section class="py-20 px-4 bg-gray-900 fade-in-up visible" id="help">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-5xl font-bold text-center mb-12 text-green-400">How You Can Help</h2>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Volunteer -->
                <div class="bg-gray-900 rounded-2xl p-6 transform hover:scale-105 transition-all duration-300 border border-green-500/30 shadow-lg">
                    <div class="text-5xl mb-4">🤝</div>
                    <h3 class="text-2xl font-bold mb-3 text-green-400">Volunteer</h3>
                    <p class="text-gray-300 mb-4">Join our conservation efforts by volunteering at the sanctuary. Help with nest monitoring, beach cleanups, and educational programs.</p>
                    <ul class="text-sm text-gray-400 space-y-2 mb-4">
                        <li>• Nest monitoring and protection</li>
                        <li>• Beach cleanup activities</li>
                        <li>• Educational outreach programs</li>
                        <li>• Hatchling release assistance</li>
                    </ul>
                </div>
                
                <!-- Donate -->
                <div class="bg-gray-900 rounded-2xl p-6 transform hover:scale-105 transition-all duration-300 border border-green-500/30 shadow-lg">
                    <div class="text-5xl mb-4">💝</div>
                    <h3 class="text-2xl font-bold mb-3 text-green-400">Donate</h3>
                    <p class="text-gray-300 mb-4">Support our conservation work through financial contributions. Your donation helps us protect nesting sites, rescue turtles, and fund research.</p>
                    <ul class="text-sm text-gray-400 space-y-2 mb-4">
                        <li>• Nest protection equipment</li>
                        <li>• Medical supplies for rescue</li>
                        <li>• Educational materials</li>
                        <li>• Research and monitoring</li>
                    </ul>
                </div>
                
                <!-- Spread Awareness -->
                <div class="bg-gray-900 rounded-2xl p-6 transform hover:scale-105 transition-all duration-300 border border-green-500/30 shadow-lg">
                    <div class="text-5xl mb-4">📢</div>
                    <h3 class="text-2xl font-bold mb-3 text-green-400">Spread Awareness</h3>
                    <p class="text-gray-300 mb-4">Help us educate others about sea turtle conservation. Share information, organize events, and advocate for marine protection policies.</p>
                    <ul class="text-sm text-gray-400 space-y-2 mb-4">
                        <li>• Share on social media</li>
                        <li>• Organize awareness events</li>
                        <li>• Educate your community</li>
                        <li>• Support conservation policies</li>
                    </ul>
                </div>
                
                <!-- Beach Cleanup -->
                <div class="bg-gray-900 rounded-2xl p-6 transform hover:scale-105 transition-all duration-300 border border-green-500/30 shadow-lg">
                    <div class="text-5xl mb-4">🏖️</div>
                    <h3 class="text-2xl font-bold mb-3 text-green-400">Beach Cleanup</h3>
                    <p class="text-gray-300 mb-4">Join our regular beach cleanup activities to protect turtle habitats. Remove plastic waste and debris that harm marine life.</p>
                    <ul class="text-sm text-gray-400 space-y-2 mb-4">
                        <li>• Monthly cleanup drives</li>
                        <li>• Plastic waste sorting</li>
                        <li>• Habitat restoration</li>
                        <li>• Marine debris monitoring</li>
                    </ul>
                </div>
                
                <!-- Eco-Tourism -->
                <div class="bg-gray-900 rounded-2xl p-6 transform hover:scale-105 transition-all duration-300 border border-green-500/30 shadow-lg">
                    <div class="text-5xl mb-4">🏖️</div>
                    <h3 class="text-2xl font-bold mb-3 text-green-400">Eco-Tourism</h3>
                    <p class="text-gray-300 mb-4">Visit our sanctuary and experience responsible eco-tourism. Your visit supports local communities and conservation efforts.</p>
                    <ul class="text-sm text-gray-400 space-y-2 mb-4">
                        <li>• Guided sanctuary tours</li>
                        <li>• Educational programs</li>
                        <li>• Hatchling release events</li>
                        <li>• Local community support</li>
                    </ul>
                </div>
                
                <!-- Reduce Plastic -->
                <div class="bg-gray-900 rounded-2xl p-6 transform hover:scale-105 transition-all duration-300 border border-green-500/30 shadow-lg">
                    <div class="text-5xl mb-4">♻️</div>
                    <h3 class="text-2xl font-bold mb-3 text-green-400">Reduce Plastic</h3>
                    <p class="text-gray-300 mb-4">Take action in your daily life to reduce plastic pollution. Every small change makes a big difference.</p>
                    <ul class="text-sm text-gray-400 space-y-2 mb-4">
                        <li>• Use reusable bags and bottles</li>
                        <li>• Avoid single-use plastics</li>
                        <li>• Participate in beach cleanups</li>
                        <li>• Support plastic-free businesses</li>
                    </ul>
                </div>
            </div>

            <div class="mt-16 text-center">
                <div class="bg-gray-900 rounded-2xl p-8 max-w-4xl mx-auto border border-green-500/30 shadow-lg">
                    <h3 class="text-3xl font-bold mb-6 text-green-400">Take Action Today</h3>
                    <p class="text-gray-300 mb-6">
                        Every action counts in the fight to protect sea turtles. Whether you volunteer, donate, 
                        or simply spread awareness, you're making a difference. Together, we can ensure that 
                        future generations will continue to marvel at these ancient mariners.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Professional Footer -->
    <footer class="bg-gradient-to-b from-deep-900 to-black text-white py-12 px-4 border-t border-ocean-500/30">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-3 gap-10 md:gap-12 xl:gap-16 mb-8">
                <!-- Organization Info -->
                <div class="col-span-1">
                    <div class="flex items-center mb-4">
                        <img src="<?php echo e(asset('img/lg.png')); ?>" alt="Pawikan Patrol Logo" class="w-12 h-12 mr-3">
                        <h3 class="text-2xl font-bold text-ocean-400">Pawikan Patrol</h3>
                    </div>
                    <p class="text-gray-400 mb-4">Dedicated to the conservation and protection of sea turtles in Dahican, City of Mati, Davao Oriental.</p>
                    <div class="flex space-x-4"></div>
                </div>

                <!-- Quick Links -->
                <div class="col-span-1 text-left md:text-center">
                    <h4 class="text-lg font-semibold mb-4 text-ocean-400">Quick Links</h4>
                    <ul class="space-y-2 flex flex-col items-start md:items-center">
                        <li><a href="#vision" data-scroll-target="vision" class="text-gray-400 hover:text-ocean-400 transition-colors duration-300">Vision & Mission</a></li>
                        <li><a href="#video-showcase" data-scroll-target="video-showcase" class="text-gray-400 hover:text-ocean-400 transition-colors duration-300">Conservation Video</a></li>
                        <li><a href="#threats" data-scroll-target="threats" class="text-gray-400 hover:text-ocean-400 transition-colors duration-300">Threats</a></li>
                        <li><a href="#lifecycle" data-scroll-target="lifecycle" class="text-gray-400 hover:text-ocean-400 transition-colors duration-300">Life Cycle</a></li>
                        <li><a href="#species" data-scroll-target="species" class="text-gray-400 hover:text-ocean-400 transition-colors duration-300">Species Guide</a></li>
                        <li><a href="#guidelines" data-scroll-target="guidelines" class="text-gray-400 hover:text-ocean-400 transition-colors duration-300">Guidelines</a></li>
                        <li><a href="#dos-donts" data-scroll-target="dos-donts" class="text-gray-400 hover:text-ocean-400 transition-colors duration-300">DOs & DON'Ts</a></li>
                        <li><a href="#help" data-scroll-target="help" class="text-gray-400 hover:text-ocean-400 transition-colors duration-300">How to Help</a></li>
                        <li><a href="#hero" data-scroll-target="hero" class="text-gray-400 hover:text-ocean-400 transition-colors duration-300">Home</a></li>
                    </ul>
                </div>
                
                <!-- Contact Info -->
                <div class="col-span-1">
                    <h4 class="text-lg font-semibold mb-4 text-ocean-400">Contact Us</h4>
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3 text-ocean-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span class="text-gray-400">Dahican, City of Mati, Davao Oriental</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3 text-ocean-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            <span class="text-gray-400">+63 XXX XXX XXXX</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="border-t border-gray-800 pt-8 text-center">
                <div class="text-gray-400 text-sm">
                    &copy; 2025 Pawikan Patrol. All rights reserved. | City of Mati – Dahican, est. 2004
                </div>
            </div>
        </div>
    </footer>
    <!-- PDF Preview Sidebar -->
    <div id="pdfSidebar" class="fixed inset-y-0 right-0 w-full lg:w-[800px] xl:w-[1000px] bg-gray-900 border-l border-white/20 transform translate-x-full transition-transform duration-300 ease-in-out z-[100] shadow-2xl flex flex-col">
        <!-- Sidebar Header -->
        <div class="p-4 border-b border-white/10 flex items-center justify-between bg-gray-800/80 backdrop-blur-md">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-red-500/20 rounded flex items-center justify-center">
                    <span class="text-red-500">📄</span>
                </div>
                <h3 id="pdfSidebarTitle" class="text-white font-bold truncate max-w-[300px] font-poppins">PDF Preview</h3>
            </div>
            <div class="flex items-center gap-2">
                <a id="pdfDownloadLink" href="#" target="_blank" class="p-2 text-gray-400 hover:text-white transition-colors" title="Open in New Tab">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                </a>
                <button onclick="closePdfPreview()" class="p-2 text-gray-400 hover:text-white transition-colors" title="Close">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>

        <!-- Metadata Info -->
        <div id="pdfSidebarMetadata" class="px-6 py-4 bg-gray-800/50 border-b border-white/10">
            <div class="flex items-center gap-2 text-blue-400 text-xs font-bold uppercase tracking-wider mb-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>Resource Details</span>
            </div>
            <p id="pdfSidebarDescription" class="text-gray-300 text-sm italic mb-3 whitespace-pre-wrap"></p>
            <div class="flex items-center gap-2 text-gray-400 text-xs">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <span>Published on: <span id="pdfSidebarDate" class="text-gray-200"></span></span>
            </div>
        </div>
        <!-- Sidebar Content (Iframe) -->
        <div class="flex-1 bg-gray-800 overflow-hidden relative">
            <div id="pdfLoading" class="absolute inset-0 flex items-center justify-center bg-gray-900 z-10">
                <div class="flex flex-col items-center gap-3">
                    <div class="w-10 h-10 border-4 border-blue-500 border-t-transparent rounded-full animate-spin"></div>
                    <p class="text-gray-400 text-sm font-poppins">Loading PDF Content...</p>
                </div>
            </div>
            <iframe id="pdfIframe" src="" class="w-full h-full border-0" onload="document.getElementById('pdfLoading').classList.add('hidden')">
                <p class="text-white p-10 text-center">Your browser does not support iframes. <a id="pdfFallbackLink" href="#" target="_blank" class="text-blue-400 underline">Click here to view the PDF.</a></p>
            </iframe>
        </div>
    </div>

    <!-- Overlay for PDF Sidebar -->
    <div id="pdfOverlay" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden z-[95]" onclick="closePdfPreview()"></div>

    <?php if(count($files) > 0): ?>
    <!-- Floating Educational Resources Widget -->
    <div class="fixed bottom-6 left-6 z-[60] flex flex-col items-start gap-3 pointer-events-none group">
        <!-- Panel -->
        <div id="resource-panel" class="mb-4 w-72 md:w-80 bg-slate-900/95 backdrop-blur-xl border border-white/10 rounded-2xl shadow-2xl overflow-hidden transition-all duration-500 origin-bottom-left scale-0 opacity-0 pointer-events-auto">
            <div class="p-5 border-b border-white/5 bg-gradient-to-r from-blue-600/10 to-emerald-600/10">
                <div class="flex items-center justify-between mb-1">
                    <h3 class="text-white font-bold text-lg flex items-center gap-2">
                        <span class="text-xl">📚</span>
                        Marine Resources
                    </h3>
                    <button onclick="toggleResourcePanel()" class="p-1 hover:bg-white/10 rounded-lg text-white/50 hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <p class="text-blue-200/50 text-[10px] font-medium tracking-wider uppercase">Marine Educational Materials</p>
            </div>
            
            <div class="max-h-[400px] overflow-y-auto p-3 space-y-2 custom-scrollbar">
                <?php $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="group/item relative bg-white/5 hover:bg-blue-600/10 border border-white/10 rounded-xl p-4 transition-all duration-300 cursor-pointer" 
                         onclick="openPdfPreview('<?php echo e($file['url']); ?>', <?php echo e(json_encode($file['title'])); ?>, <?php echo e(json_encode($file['description'])); ?>, '<?php echo e(date('M d, Y', strtotime($file['published_date']))); ?>')">
                        <div class="flex items-center gap-4">
                            <!-- Icon -->
                            <div class="w-12 h-12 bg-blue-500/10 rounded-xl flex items-center justify-center border border-white/5 flex-shrink-0 group-hover/item:scale-110 transition-transform">
                                <span class="text-2xl">📘</span>
                            </div>
                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <h4 class="text-white text-sm font-bold truncate mb-1 group-hover/item:text-blue-300 transition-colors uppercase tracking-tight"><?php echo e($file['title']); ?></h4>
                                <p class="text-gray-400 text-[11px] leading-snug line-clamp-2 mb-2 italic">
                                    <?php echo e($file['description']); ?>

                                </p>
                                <div class="flex items-center gap-3">
                                    <div class="flex items-center gap-1.5 p-1 px-2 bg-blue-500/10 rounded-md border border-blue-500/20 text-blue-400 group-hover/item:bg-blue-500 group-hover/item:text-white transition-all duration-300" title="View Guide">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </div>
                                    <span class="text-[10px] text-gray-500 font-medium">PDF • <?php echo e(date('M Y', strtotime($file['published_date']))); ?></span>
                                </div>
                            </div>
                            <!-- Simple Download -->
                            <a href="<?php echo e($file['url']); ?>" download onclick="event.stopPropagation();" 
                               class="p-2 text-gray-500 hover:text-emerald-400 transition-all hover:scale-110" title="Download">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            
        </div>

        <!-- Floating Button -->
        <div class="flex items-center gap-4 pointer-events-none">
            <button id="resource-fab" onclick="toggleResourcePanel()" class="pointer-events-auto w-14 h-14 bg-gradient-to-br from-blue-600 to-emerald-600 rounded-2xl shadow-2xl flex items-center justify-center text-white border border-white/20 hover:scale-110 active:scale-95 transition-all duration-300 group/fab relative overflow-hidden">
                <!-- Animated background shine -->
                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent -translate-x-full group-hover/fab:animate-shine"></div>
                
                <span class="text-2xl group-hover/fab:rotate-12 transition-transform duration-300">📖</span>
                
                <!-- Pulse effect -->
                <div class="absolute inset-0 rounded-2xl ring-4 ring-blue-500/30 animate-pulse"></div>
            </button>

            <!-- Resource Indicator Label -->
            <div class="pointer-events-auto bg-slate-900/80 backdrop-blur-md border border-white/10 px-4 py-2 rounded-xl shadow-xl transform transition-all duration-500 opacity-0 -translate-l-4 group-hover:opacity-100 group-hover:translate-x-0 flex items-center gap-3">
                <div class="flex flex-col">
                    <span class="text-[10px] font-bold text-blue-400 uppercase tracking-widest leading-none mb-1">Marine Educational</span>
                    <span class="text-xs font-semibold text-white leading-none whitespace-nowrap tracking-tight">Marine Resources & Guides</span>
                </div>
                <div class="w-1.5 h-1.5 bg-emerald-400 rounded-full animate-pulse-slow"></div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // PDF Preview Functions
    function openPdfPreview(url, name, description, date) {
        const sidebar = document.getElementById('pdfSidebar');
        const overlay = document.getElementById('pdfOverlay');
        const iframe = document.getElementById('pdfIframe');
        const title = document.getElementById('pdfSidebarTitle');
        const downloadLink = document.getElementById('pdfDownloadLink');
        const fallbackLink = document.getElementById('pdfFallbackLink');
        const loader = document.getElementById('pdfLoading');
        const descEl = document.getElementById('pdfSidebarDescription');
        const dateEl = document.getElementById('pdfSidebarDate');

        if (!sidebar) return;

        title.textContent = name;
        descEl.textContent = description || 'No description provided.';
        dateEl.textContent = date || 'N/A';
        downloadLink.href = url;
        if (fallbackLink) fallbackLink.href = url;
        loader.classList.remove('hidden');
        iframe.src = url;

        sidebar.classList.remove('translate-x-full');
        overlay.classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Prevent scrolling
    }

    function closePdfPreview() {
        const sidebar = document.getElementById('pdfSidebar');
        const overlay = document.getElementById('pdfOverlay');
        const iframe = document.getElementById('pdfIframe');

        if (!sidebar) return;

        sidebar.classList.add('translate-x-full');
        overlay.classList.add('hidden');
        document.body.style.overflow = ''; // Restore scrolling
        
        // Clear iframe src after transition
        setTimeout(() => {
            iframe.src = '';
        }, 300);
    }

    function toggleResourcePanel() {
        const panel = document.getElementById('resource-panel');
        if (!panel) return;
        const isOpen = !panel.classList.contains('scale-0');
        
        if (isOpen) {
            panel.classList.add('scale-0', 'opacity-0');
            panel.classList.remove('scale-100', 'opacity-100');
        } else {
            panel.classList.remove('scale-0', 'opacity-0');
            panel.classList.add('scale-100', 'opacity-100');
        }
    }

    // Close on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closePdfPreview();
        }
    });

    // Cleanup on Turbo navigation
    document.addEventListener('turbo:before-visit', function() {
        closePdfPreview();
    });

    // Auto-open resource panel on page load
    document.addEventListener('DOMContentLoaded', () => {
        setTimeout(() => {
            const panel = document.getElementById('resource-panel');
            if (panel && panel.classList.contains('scale-0')) {
                toggleResourcePanel();
            }
        }, 800); // Slight delay for better entry feel after main page load
    });

    // Support for Turbo navigation
    document.addEventListener('turbo:render', () => {
        setTimeout(() => {
            const panel = document.getElementById('resource-panel');
            if (panel && panel.classList.contains('scale-0')) {
                toggleResourcePanel();
            }
        }, 500);
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Rayver\Desktop\my_app\resources\views/LandingPage.blade.php ENDPATH**/ ?>