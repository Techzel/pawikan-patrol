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
            font-family: 'Cinzel', serif !important;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div id="landing-page">
    <!-- Hero Section with Carousel -->
    <section class="min-h-screen flex items-center justify-center relative px-4 pt-4" id="hero">
        <div class="max-w-6xl w-full mx-auto z-10">
            <div class="carousel relative overflow-hidden rounded-2xl">
                <div class="carousel-track">
                    <div class="carousel-slide">
                        <img src="<?php echo e(asset('img/carousel_1.jpg')); ?>" alt="Sea Turtle Swimming" class="rounded-2xl shadow-2xl">
                    </div>
                    <div class="carousel-slide">
                        <img src="<?php echo e(asset('img/carousel_2.jpg')); ?>" alt="Sea Turtle Nesting" class="rounded-2xl shadow-2xl">
                    </div>
                    <div class="carousel-slide">
                        <img src="<?php echo e(asset('img/carousel_1.jpg')); ?>" alt="Baby Sea Turtles" class="rounded-2xl shadow-2xl">
                    </div>
                    <div class="carousel-slide">
                        <img src="<?php echo e(asset('img/carousel_2.jpg')); ?>" alt="Pawikan Patrol Team" class="rounded-2xl shadow-2xl">
                    </div>
                </div>
                
                <!-- Carousel Controls -->
                <button class="carousel-control prev absolute left-4 top-1/2 transform -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white p-2 rounded-full transition-all duration-300 z-10">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                <button class="carousel-control next absolute right-4 top-1/2 transform -translate-y-1/2 bg-black/50 hover:b    g-black/70 text-white p-2 rounded-full transition-all duration-300 z-10">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
                
                <!-- Carousel Indicators -->
                <div class="carousel-indicators absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                    <button class="carousel-indicator w-2 h-2 bg-white/50 hover:bg-white/80 rounded-full transition-all duration-300" data-slide="0"></button>
                    <button class="carousel-indicator w-2 h-2 bg-white/50 hover:bg-white/80 rounded-full transition-all duration-300" data-slide="1"></button>
                    <button class="carousel-indicator w-2 h-2 bg-white/50 hover:bg-white/80 rounded-full transition-all duration-300" data-slide="2"></button>
                    <button class="carousel-indicator w-2 h-2 bg-white/50 hover:bg-white/80 rounded-full transition-all duration-300" data-slide="3"></button>
                </div>
            </div>
        </div>

        <script>
        window.addEventListener('load', function initCarousel() {
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
    <section class="py-20 px-4 bg-gradient-to-br from-deep-900/50 to-ocean-900/30" id="sanctuary">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-5xl font-bold text-center mb-12 text-ocean-400">Pawikan Patrol Sanctuary</h2>
            
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="glass-dark rounded-3xl p-8 transform hover:scale-105 transition-all duration-500 shadow-2xl border border-ocean-500/30">
                    <h3 class="text-3xl font-bold mb-6 text-ocean-300">Our Mission</h3>
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
                    <img src="<?php echo e(asset('img/carousel_2.jpg')); ?>" alt="Pawikan Patrol Sanctuary" class="rounded-2xl shadow-2xl w-full h-96 object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent rounded-2xl"></div>
                    <div class="absolute bottom-6 left-6 right-6">
                        <div class="glass-dark rounded-xl p-4">
                            <h4 class="text-xl font-bold mb-2 text-ocean-300">Location: Dahican, City of Mati</h4>
                            <p class="text-gray-300">A pristine 7-kilometer beach known for its sea turtle nesting grounds</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Sanctuary Features -->
            <div class="grid md:grid-cols-3 gap-8 mt-16">
                <div class="glass-dark rounded-2xl p-6 transform hover:scale-105 transition-all duration-300 border-l-4 border-ocean-500">
                    <div class="text-4xl mb-4">🏖️</div>
                    <h3 class="text-xl font-bold mb-3 text-ocean-300">Nesting Protection</h3>
                    <p class="text-gray-300">24/7 monitoring and protection of sea turtle nesting sites along Dahican beach</p>
                </div>
                
                <div class="glass-dark rounded-2xl p-6 transform hover:scale-105 transition-all duration-300 border-l-4 border-green-500">
                    <div class="text-4xl mb-4">🏥</div>
                    <h3 class="text-xl font-bold mb-3 text-green-300">Rescue Center</h3>
                    <p class="text-gray-300">Medical care and rehabilitation for injured and sick sea turtles</p>
                </div>
                
                <div class="glass-dark rounded-2xl p-6 transform hover:scale-105 transition-all duration-300 border-l-4 border-blue-500">
                    <div class="text-4xl mb-4">🎓</div>
                    <h3 class="text-xl font-bold mb-3 text-blue-300">Education</h3>
                    <p class="text-gray-300">Community outreach and educational programs about marine conservation</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Vision Section -->
    <section class="py-20 px-4 bg-gradient-to-br from-ocean-900/20 to-deep-900/50 fade-in-up visible" id="vision">
        <div class="max-w-6xl mx-auto text-center">
            <h2 class="text-5xl font-bold mb-12 text-ocean-400">Vission and Mission</h2>
            
            <div class="grid md:grid-cols-2 gap-12 items-start">
                <div class="glass-dark rounded-3xl p-8 transform hover:scale-105 transition-all duration-500 shadow-2xl border border-ocean-500/30">
                    <h3 class="text-3xl font-bold mb-6 text-ocean-300">Our Vision</h3>
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
                
                <div class="glass-dark rounded-3xl p-8 transform hover:scale-105 transition-all duration-500 shadow-2xl border border-green-500/30">
                    <h3 class="text-3xl font-bold mb-6 text-green-300">Our Goals</h3>
                    <ul class="text-left space-y-3 text-gray-300">
                        <li class="flex items-start gap-3">
                            <span class="text-green-400 mt-1">✓</span>
                            <span>Protect 100% of nesting sites in Dahican</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-green-400 mt-1">✓</span>
                            <span>Release 10,000+ hatchlings annually</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-green-400 mt-1">✓</span>
                            <span>Establish a marine protected area</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-green-400 mt-1">✓</span>
                            <span>Educate 50,000+ community members</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-green-400 mt-1">✓</span>
                            <span>Create sustainable eco-tourism programs</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Lifecycle Section -->
    <section class="py-20 px-4 bg-gradient-to-br from-deep-900/50 to-ocean-900/30 fade-in-up visible" id="lifecycle">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-5xl font-bold text-center mb-12 text-ocean-400">The Journey of Life</h2>
            
            <!-- Enhanced Lifecycle Timeline -->
            <div class="relative">
                <!-- Animated Timeline -->
                <div class="absolute left-1/2 transform -translate-x-1/2 w-2 h-full bg-gradient-to-b from-ocean-400 via-ocean-500 to-ocean-600 rounded-full shadow-lg">
                    <div class="absolute inset-0 bg-gradient-to-b from-transparent via-white/20 to-transparent animate-pulse"></div>
                </div>
                
                <div class="space-y-20">
                    <!-- Stage 1: Nesting -->
                    <div class="relative flex items-center">
                        <div class="w-1/2 text-right pr-12">
                            <div class="glass-dark rounded-3xl p-8 transform hover:scale-105 transition-all duration-500 shadow-2xl border border-ocean-500/30">
                                <div class="flex items-center gap-4 mb-4">
                                    <span class="text-4xl">🥚</span>
                                    <h3 class="text-3xl font-bold text-ocean-300">1. Nesting</h3>
                                </div>
                                <p class="text-gray-300 mb-4">
                                    Female sea turtles return to the same beach where they were born to lay their eggs. 
                                    They emerge from the ocean at night, dig deep nests in the sand, and deposit 
                                    50-200 eggs in a single clutch.
                                </p>
                                <div class="text-sm text-gray-400">
                                    <strong>Season:</strong> November to March<br>
                                    <strong>Duration:</strong> 2-3 hours per nest
                                </div>
                            </div>
                        </div>
                        <div class="absolute left-1/2 transform -translate-x-1/2 w-6 h-6 bg-ocean-500 rounded-full border-4 border-white shadow-lg z-10"></div>
                        <div class="w-1/2 pl-12"></div>
                    </div>

                    <!-- Stage 2: Incubation -->
                    <div class="relative flex items-center">
                        <div class="w-1/2 pr-12"></div>
                        <div class="absolute left-1/2 transform -translate-x-1/2 w-6 h-6 bg-green-500 rounded-full border-4 border-white shadow-lg z-10"></div>
                        <div class="w-1/2 text-left pl-12">
                            <div class="glass-dark rounded-3xl p-8 transform hover:scale-105 transition-all duration-500 shadow-2xl border border-green-500/30">
                                <div class="flex items-center gap-4 mb-4">
                                    <span class="text-4xl">🌡️</span>
                                    <h3 class="text-3xl font-bold text-green-300">2. Incubation</h3>
                                </div>
                                <p class="text-gray-300 mb-4">
                                    The eggs incubate in the warm sand for 45-70 days. The temperature of the nest 
                                    determines the sex of the hatchlings - warmer temperatures produce females, 
                                    while cooler temperatures produce males.
                                </p>
                                <div class="text-sm text-gray-400">
                                    <strong>Temperature:</strong> 29-30°C optimal<br>
                                    <strong>Success Rate:</strong> 80-90% in protected nests
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Stage 3: Hatching -->
                    <div class="relative flex items-center">
                        <div class="w-1/2 text-right pr-12">
                            <div class="glass-dark rounded-3xl p-8 transform hover:scale-105 transition-all duration-500 shadow-2xl border border-yellow-500/30">
                                <div class="flex items-center gap-4 mb-4">
                                    <span class="text-4xl">🐣</span>
                                    <h3 class="text-3xl font-bold text-yellow-300">3. Hatching</h3>
                                </div>
                                <p class="text-gray-300 mb-4">
                                    After incubation, the hatchlings emerge together in a group. They use their 
                                    temporary egg tooth to break through the shell and work together to dig 
                                    their way to the surface.
                                </p>
                                <div class="text-sm text-gray-400">
                                    <strong>Emergence:</strong> Usually at night<br>
                                    <strong>Group Size:</strong> 50-200 hatchlings
                                </div>
                            </div>
                        </div>
                        <div class="absolute left-1/2 transform -translate-x-1/2 w-6 h-6 bg-yellow-500 rounded-full border-4 border-white shadow-lg z-10"></div>
                        <div class="w-1/2 pl-12"></div>
                    </div>

                    <!-- Stage 4: The Lost Years -->
                    <div class="relative flex items-center">
                        <div class="w-1/2 pr-12"></div>
                        <div class="absolute left-1/2 transform -translate-x-1/2 w-6 h-6 bg-blue-500 rounded-full border-4 border-white shadow-lg z-10"></div>
                        <div class="w-1/2 text-left pl-12">
                            <div class="glass-dark rounded-3xl p-8 transform hover:scale-105 transition-all duration-500 shadow-2xl border border-blue-500/30">
                                <div class="flex items-center gap-4 mb-4">
                                    <span class="text-4xl">🌊</span>
                                    <h3 class="text-3xl font-bold text-blue-300">4. The Lost Years</h3>
                                </div>
                                <p class="text-gray-300 mb-4">
                                    Once in the ocean, hatchlings enter a mysterious phase called "the lost years." 
                                    They drift with ocean currents, feeding on plankton and small organisms, growing 
                                    rapidly in the open ocean.
                                </p>
                                <div class="text-sm text-gray-400">
                                    <strong>Duration:</strong> 1-10 years<br>
                                    <strong>Location:</strong> Open ocean currents
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Stage 5: Adulthood -->
                    <div class="relative flex items-center">
                        <div class="w-1/2 text-right pr-12">
                            <div class="glass-dark rounded-3xl p-8 transform hover:scale-105 transition-all duration-500 shadow-2xl border border-purple-500/30">
                                <div class="flex items-center gap-4 mb-4">
                                    <span class="text-4xl">🐢</span>
                                    <h3 class="text-3xl font-bold text-purple-300">5. Adulthood</h3>
                                </div>
                                <p class="text-gray-300 mb-4">
                                    After the lost years, juvenile turtles move to coastal feeding grounds where 
                                    they mature into adults. They reach sexual maturity at 20-50 years old and 
                                    begin the cycle anew by returning to nest.
                                </p>
                                <div class="text-sm text-gray-400">
                                    <strong>Maturity:</strong> 20-50 years<br>
                                    <strong>Lifespan:</strong> 50-100+ years
                                </div>
                            </div>
                        </div>
                        <div class="absolute left-1/2 transform -translate-x-1/2 w-6 h-6 bg-purple-500 rounded-full border-4 border-white shadow-lg z-10"></div>
                        <div class="w-1/2 pl-12"></div>
                    </div>
                </div>
            </div>
            
            <!-- Lifecycle Statistics -->
            <div class="mt-20 text-center">
                <div class="glass-dark rounded-3xl p-10 max-w-6xl mx-auto shadow-2xl border border-ocean-500/30">
                    <h3 class="text-3xl font-bold mb-8 text-ocean-300">Conservation Impact</h3>
                    <div class="grid md:grid-cols-4 gap-8">
                        <div class="text-center">
                            <div class="text-4xl font-bold text-ocean-400 mb-2">10,000+</div>
                            <div class="text-gray-300">Hatchlings Released</div>
                        </div>
                        <div class="text-center">
                            <div class="text-4xl font-bold text-green-400 mb-2">500+</div>
                            <div class="text-gray-300">Nests Protected</div>
                        </div>
                        <div class="text-center">
                            <div class="text-4xl font-bold text-yellow-400 mb-2">50+</div>
                            <div class="text-gray-300">Turtles Rescued</div>
                        </div>
                        <div class="text-center">
                            <div class="text-4xl font-bold text-blue-400 mb-2">15+</div>
                            <div class="text-gray-300">Years of Conservation</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Threats Section -->
    <section class="py-20 px-4 bg-gradient-to-br from-red-900/20 to-deep-900/50 fade-in-up visible" id="threats">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-5xl font-bold text-center mb-12 text-red-400">Threats to Sea Turtles</h2>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Plastic Pollution -->
                <div class="glass-dark rounded-2xl p-6 transform hover:scale-105 transition-all duration-300 border-l-4 border-red-500">
                    <div class="text-5xl mb-4">🗑️</div>
                    <h3 class="text-2xl font-bold mb-3 text-red-400">Plastic Pollution</h3>
                    <p class="text-gray-300 mb-4">Sea turtles often mistake plastic bags for jellyfish, their primary food source, leading to internal injuries and death.</p>
                    <ul class="text-sm text-gray-400 space-y-1">
                        <li>• Ingestion of plastic debris</li>
                        <li>• Entanglement in fishing gear</li>
                        <li>• Habitat degradation</li>
                    </ul>
                </div>
                
                <!-- Climate Change -->
                <div class="glass-dark rounded-2xl p-6 transform hover:scale-105 transition-all duration-300 border-l-4 border-orange-500">
                    <div class="text-5xl mb-4">🌡️</div>
                    <h3 class="text-2xl font-bold mb-3 text-orange-400">Climate Change</h3>
                    <p class="text-gray-300 mb-4">Rising temperatures affect nesting beaches and skew sex ratios, while sea level rise threatens nesting habitats.</p>
                    <ul class="text-sm text-gray-400 space-y-1">
                        <li>• Altered sex ratios</li>
                        <li>• Nest flooding</li>
                        <li>• Ocean acidification</li>
                    </ul>
                </div>
                
                <!-- Poaching -->
                <div class="glass-dark rounded-2xl p-6 transform hover:scale-105 transition-all duration-300 border-l-4 border-purple-500">
                    <div class="text-5xl mb-4">🎣</div>
                    <h3 class="text-2xl font-bold mb-3 text-purple-400">Poaching</h3>
                    <p class="text-gray-300 mb-4">Despite legal protection, sea turtles are still hunted for their meat, eggs, shells, and leather in many regions.</p>
                    <ul class="text-sm text-gray-400 space-y-1">
                        <li>• Egg collection</li>
                        <li>• Illegal fishing</li>
                        <li>• Shell trade</li>
                    </ul>
                </div>
                
                <!-- Coastal Development -->
                <div class="glass-dark rounded-2xl p-6 transform hover:scale-105 transition-all duration-300 border-l-4 border-yellow-500">
                    <div class="text-5xl mb-4">🏗️</div>
                    <h3 class="text-2xl font-bold mb-3 text-yellow-400">Coastal Development</h3>
                    <p class="text-gray-300 mb-4">Beach development and artificial lighting disrupt nesting behavior and disorient hatchlings.</p>
                    <ul class="text-sm text-gray-400 space-y-1">
                        <li>• Habitat loss</li>
                        <li>• Artificial lighting</li>
                        <li>• Beach erosion</li>
                    </ul>
                </div>
                
                <!-- Fishing Bycatch -->
                <div class="glass-dark rounded-2xl p-6 transform hover:scale-105 transition-all duration-300 border-l-4 border-blue-500">
                    <div class="text-5xl mb-4">🎣</div>
                    <h3 class="text-2xl font-bold mb-3 text-blue-400">Fishing Bycatch</h3>
                    <p class="text-gray-300 mb-4">Millions of sea turtles are accidentally caught in fishing gear each year, causing injury or death.</p>
                    <ul class="text-sm text-gray-400 space-y-1">
                        <li>• Gillnet entanglement</li>
                        <li>• Longline fishing</li>
                        <li>• Trawler nets</li>
                    </ul>
                </div>
                
                <!-- Pollution -->
                <div class="glass-dark rounded-2xl p-6 transform hover:scale-105 transition-all duration-300 border-l-4 border-green-500">
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
                <div class="glass-dark rounded-2xl p-8 max-w-4xl mx-auto">
                    <h3 class="text-3xl font-bold mb-6 text-green-400">Success Stories</h3>
                    <div class="grid md:grid-cols-2 gap-8">
                        <div class="text-left">
                            <h4 class="text-xl font-bold mb-3 text-ocean-300">Nesting Site Recovery</h4>
                            <p class="text-gray-300">Through our protection efforts, nesting success rates have increased from 40% to 85% in protected areas.</p>
                        </div>
                        <div class="text-left">
                            <h4 class="text-xl font-bold mb-3 text-ocean-300">Community Engagement</h4>
                            <p class="text-gray-300">Local communities now actively participate in conservation, reporting nesting activities and protecting nests.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Species Section -->
    <section class="py-20 px-4 fade-in-up visible" id="species">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-5xl font-bold text-center mb-12 text-ocean-400">Species Found in Dahican</h2>
            
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Green Sea Turtle -->
                <div class="glass-dark rounded-2xl p-6 transform hover:scale-105 transition-all duration-300 border-l-4 border-green-500">
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
                        <p><strong>Status:</strong> <span class="text-red-400">Endangered</span></p>
                        <p class="text-sm">Named for their green fat tissue, these turtles are the most common species in Dahican.</p>
                    </div>
                </div>
                
                <!-- Hawksbill Sea Turtle -->
                <div class="glass-dark rounded-2xl p-6 transform hover:scale-105 transition-all duration-300 border-l-4 border-yellow-500">
                    <div class="text-center mb-6">
                        <div class="relative inline-block group">
                            <div class="species-image-container relative w-36 h-36 mx-auto mb-4">
                                <img src="<?php echo e(asset('img/hawksbill-sea-turtle.png')); ?>" alt="Hawksbill Sea Turtle" class="species-image w-36 h-36 rounded-full object-cover border-4 border-yellow-500/30 absolute top-0 left-0 transition-opacity duration-300 ease-in-out group-hover:opacity-0">
                                <img src="<?php echo e(asset('img/baby-hawksbillturtle.png')); ?>" alt="Baby Hawksbill Sea Turtle" class="species-image-hover w-36 h-36 rounded-full object-cover border-4 border-yellow-500/30 absolute top-0 left-0 transition-opacity duration-300 ease-in-out opacity-0 group-hover:opacity-100">
                            </div>
                            <div class="absolute -bottom-2 -right-2 bg-yellow-500 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold">2</div>
                        </div>
                        <h3 class="text-2xl font-bold text-yellow-400">Hawksbill Turtle</h3>
                        <p class="text-gray-400 italic">Eretmochelys imbricata</p>
                        <div class="species-description mt-3 relative h-12">
                            <p class="text-sm text-gray-300 transition-opacity duration-300 ease-in-out absolute top-0 left-0 w-full group-hover:opacity-0">Recognizable by their distinctive hawk-like beak and beautiful patterned shells.</p>
                            <p class="text-sm text-yellow-300 transition-opacity duration-300 ease-in-out opacity-0 absolute top-0 left-0 w-full group-hover:opacity-100">Baby hawksbills are born with intricate shell patterns that will become more defined as they mature.</p>
                        </div>
                    </div>
                    <div class="space-y-3 text-gray-300">
                        <p><strong>Size:</strong> Up to 1 meter</p>
                        <p><strong>Weight:</strong> Up to 80 kg</p>
                        <p><strong>Diet:</strong> Sponges, jellyfish</p>
                        <p><strong>Status:</strong> <span class="text-red-400">Critically Endangered</span></p>
                        <p class="text-sm">Known for their beautiful shell pattern, they play a crucial role in coral reef ecosystems.</p>
                    </div>
                </div>
                
                <!-- Olive Ridley Sea Turtle -->
                <div class="glass-dark rounded-2xl p-6 transform hover:scale-105 transition-all duration-300 border-l-4 border-blue-500">
                    <div class="text-center mb-6">
                        <div class="relative inline-block group">
                            <div class="species-image-container relative w-36 h-36 mx-auto mb-4">
                                <img src="<?php echo e(asset('img/olive-sea-turtle.png')); ?>" alt="Olive Ridley Sea Turtle" class="species-image w-36 h-36 rounded-full object-cover border-4 border-blue-500/30 absolute top-0 left-0 transition-opacity duration-300 ease-in-out group-hover:opacity-0">
                                <img src="<?php echo e(asset('img/baby-olive-turtle.png')); ?>" alt="Baby Olive Ridley Sea Turtle" class="species-image-hover w-36 h-36 rounded-full object-cover border-4 border-blue-500/30 absolute top-0 left-0 transition-opacity duration-300 ease-in-out opacity-0 group-hover:opacity-100">
                            </div>
                            <div class="absolute -bottom-2 -right-2 bg-blue-500 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold">3</div>
                        </div>
                        <h3 class="text-2xl font-bold text-blue-400">Olive Ridley</h3>
                        <p class="text-gray-400 italic">Lepidochelys olivacea</p>
                        <div class="species-description mt-3 relative h-12">
                            <p class="text-sm text-gray-300 transition-opacity duration-300 ease-in-out absolute top-0 left-0 w-full group-hover:opacity-0">Known for mass nesting events called arribadas, where thousands come ashore simultaneously.</p>
                            <p class="text-sm text-blue-300 transition-opacity duration-300 ease-in-out opacity-0 absolute top-0 left-0 w-full group-hover:opacity-100">Baby olive ridleys emerge in coordinated groups during arribadas, increasing their survival chances.</p>
                        </div>
                    </div>
                    <div class="space-y-3 text-gray-300">
                        <p><strong>Size:</strong> Up to 70 cm</p>
                        <p><strong>Weight:</strong> Up to 45 kg</p>
                        <p><strong>Diet:</strong> Crabs, shrimp, jellyfish</p>
                        <p><strong>Status:</strong> <span class="text-orange-400">Vulnerable</span></p>
                        <p class="text-sm">The smallest sea turtle species, known for their mass nesting events called arribadas.</p>
                    </div>
                </div>
            </div>

            <!-- Conservation Status -->
            <div class="mt-16 text-center">
                <div class="glass-dark rounded-2xl p-8 max-w-4xl mx-auto">
                    <h3 class="text-3xl font-bold mb-6 text-ocean-300">Conservation Status</h3>
                    <div class="grid md:grid-cols-3 gap-6">
                        <div class="text-center">
                            <div class="w-16 h-16 bg-red-500 rounded-full mx-auto mb-3 flex items-center justify-center">
                                <span class="text-white font-bold text-xl">!</span>
                            </div>
                            <h4 class="font-bold text-red-400 mb-2">Critically Endangered</h4>
                            <p class="text-sm text-gray-300">Extremely high risk of extinction</p>
                        </div>
                        <div class="text-center">
                            <div class="w-16 h-16 bg-orange-500 rounded-full mx-auto mb-3 flex items-center justify-center">
                                <span class="text-white font-bold text-xl">⚠</span>
                            </div>
                            <h4 class="font-bold text-orange-400 mb-2">Endangered</h4>
                            <p class="text-sm text-gray-300">High risk of extinction</p>
                        </div>
                        <div class="text-center">
                            <div class="w-16 h-16 bg-yellow-500 rounded-full mx-auto mb-3 flex items-center justify-center">
                                <span class="text-white font-bold text-xl">⚡</span>
                            </div>
                            <h4 class="font-bold text-yellow-400 mb-2">Vulnerable</h4>
                            <p class="text-sm text-gray-300">High risk of endangerment</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Guidelines Section -->
    <section class="py-20 px-4 bg-gradient-to-br from-ocean-900/20 to-deep-900/50 fade-in-up visible" id="guidelines">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-5xl font-bold text-center mb-12 text-ocean-400">Conservation Guidelines</h2>
            
            <div class="grid md:grid-cols-2 gap-12">
                <!-- Beach Guidelines -->
                <div class="glass-dark rounded-2xl p-8">
                    <h3 class="text-2xl font-bold mb-6 text-ocean-300">Beach Guidelines</h3>
                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <span class="text-yellow-400 mt-1">🚫</span>
                            <div>
                                <h4 class="font-bold text-yellow-400">No Flash Photography</h4>
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
                            <span class="text-blue-400 mt-1">👥</span>
                            <div>
                                <h4 class="font-bold text-blue-400">Maintain Distance</h4>
                                <p class="text-gray-300 text-sm">Stay at least 10 meters away from nesting turtles and hatchlings</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="text-purple-400 mt-1">🗑️</span>
                            <div>
                                <h4 class="font-bold text-purple-400">Leave No Trace</h4>
                                <p class="text-gray-300 text-sm">Take all trash with you and leave the beach clean</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="text-red-400 mt-1">🏖️</span>
                            <div>
                                <h4 class="font-bold text-red-400">Fill Beach Holes</h4>
                                <p class="text-gray-300 text-sm">Fill any holes you dig to prevent hatchlings from getting trapped</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Observer Guidelines -->
                <div class="glass-dark rounded-2xl p-8">
                    <h3 class="text-2xl font-bold mb-6 text-ocean-300">Observer Guidelines</h3>
                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <span class="text-yellow-400 mt-1">👁️</span>
                            <div>
                                <h4 class="font-bold text-yellow-400">Watch from Behind</h4>
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
                            <span class="text-blue-400 mt-1">📱</span>
                            <div>
                                <h4 class="font-bold text-blue-400">No Screen Lights</h4>
                                <p class="text-gray-300 text-sm">Turn off phone screens and other electronic devices</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="text-purple-400 mt-1">🚶</span>
                            <div>
                                <h4 class="font-bold text-purple-400">Move Carefully</h4>
                                <p class="text-gray-300 text-sm">Walk slowly and avoid sudden movements</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="text-red-400 mt-1">📸</span>
                            <div>
                                <h4 class="font-bold text-red-400">No Selfies</h4>
                                <p class="text-gray-300 text-sm">Never approach turtles for photos or selfies</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Emergency Contacts -->
            <div class="mt-12 text-center">
                <div class="glass-dark rounded-2xl p-6 inline-block">
                    <h3 class="text-xl font-bold mb-4 text-red-400">Emergency Contacts</h3>
                    <div class="space-y-2 text-gray-300">
                        <p><strong>Pawikan Patrol Hotline:</strong> +63 912 345 6789</p>
                        <p><strong>Local DENR Office:</strong> +63 923 456 7890</p>
                        <p><strong>Coast Guard:</strong> +63 934 567 8901</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How to Help Section -->
    <section class="py-20 px-4 bg-gradient-to-br from-green-900/20 to-deep-900/50 fade-in-up visible" id="help">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-5xl font-bold text-center mb-12 text-green-400">How You Can Help</h2>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Volunteer -->
                <div class="glass-dark rounded-2xl p-6 transform hover:scale-105 transition-all duration-300 border-l-4 border-green-500">
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
                <div class="glass-dark rounded-2xl p-6 transform hover:scale-105 transition-all duration-300 border-l-4 border-blue-500">
                    <div class="text-5xl mb-4">💝</div>
                    <h3 class="text-2xl font-bold mb-3 text-blue-400">Donate</h3>
                    <p class="text-gray-300 mb-4">Support our conservation work through financial contributions. Your donation helps us protect nesting sites, rescue turtles, and fund research.</p>
                    <ul class="text-sm text-gray-400 space-y-2 mb-4">
                        <li>• Nest protection equipment</li>
                        <li>• Medical supplies for rescue</li>
                        <li>• Educational materials</li>
                        <li>• Research and monitoring</li>
                    </ul>
                </div>
                
                <!-- Spread Awareness -->
                <div class="glass-dark rounded-2xl p-6 transform hover:scale-105 transition-all duration-300 border-l-4 border-purple-500">
                    <div class="text-5xl mb-4">📢</div>
                    <h3 class="text-2xl font-bold mb-3 text-purple-400">Spread Awareness</h3>
                    <p class="text-gray-300 mb-4">Help us educate others about sea turtle conservation. Share information, organize events, and advocate for marine protection policies.</p>
                    <ul class="text-sm text-gray-400 space-y-2 mb-4">
                        <li>• Share on social media</li>
                        <li>• Organize awareness events</li>
                        <li>• Educate your community</li>
                        <li>• Support conservation policies</li>
                    </ul>
                </div>
                
                <!-- Adopt a Turtle -->
                <div class="glass-dark rounded-2xl p-6 transform hover:scale-105 transition-all duration-300 border-l-4 border-yellow-500">
                    <div class="text-5xl mb-4">🐢</div>
                    <h3 class="text-2xl font-bold mb-3 text-yellow-400">Adopt a Turtle</h3>
                    <p class="text-gray-300 mb-4">Symbolically adopt a sea turtle and receive updates on its journey. Your adoption helps fund our conservation programs.</p>
                    <ul class="text-sm text-gray-400 space-y-2 mb-4">
                        <li>• Adoption certificate</li>
                        <li>• Regular updates</li>
                        <li>• Turtle tracking information</li>
                        <li>• Conservation impact report</li>
                    </ul>
                </div>
                
                <!-- Eco-Tourism -->
                <div class="glass-dark rounded-2xl p-6 transform hover:scale-105 transition-all duration-300 border-l-4 border-ocean-500">
                    <div class="text-5xl mb-4">🏖️</div>
                    <h3 class="text-2xl font-bold mb-3 text-ocean-400">Eco-Tourism</h3>
                    <p class="text-gray-300 mb-4">Visit our sanctuary and experience responsible eco-tourism. Your visit supports local communities and conservation efforts.</p>
                    <ul class="text-sm text-gray-400 space-y-2 mb-4">
                        <li>• Guided sanctuary tours</li>
                        <li>• Educational programs</li>
                        <li>• Hatchling release events</li>
                        <li>• Local community support</li>
                    </ul>
                </div>
                
                <!-- Reduce Plastic -->
                <div class="glass-dark rounded-2xl p-6 transform hover:scale-105 transition-all duration-300 border-l-4 border-red-500">
                    <div class="text-5xl mb-4">♻️</div>
                    <h3 class="text-2xl font-bold mb-3 text-red-400">Reduce Plastic</h3>
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
                <div class="glass-dark rounded-2xl p-8 max-w-4xl mx-auto">
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
            <div class="grid md:grid-cols-3 gap-8 mb-8">
                <!-- Organization Info -->
                <div class="col-span-1">
                    <div class="flex items-center mb-4">
                        <img src="<?php echo e(asset('img/web_lg.png')); ?>" alt="Pawikan Patrol Logo" class="w-12 h-12 mr-3">
                        <h3 class="text-2xl font-bold text-ocean-400">Pawikan Patrol</h3>
                    </div>
                    <p class="text-gray-400 mb-4">Dedicated to the conservation and protection of sea turtles in Dahican, City of Mati, Davao Oriental.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-ocean-400 transition-colors duration-300">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-ocean-400 transition-colors duration-300">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-ocean-400 transition-colors duration-300">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zM5.838 12a6.162 6.162 0 1112.324 0 6.162 6.162 0 01-12.324 0zM12 16a4 4 0 110-8 4 4 0 010 8zm4.965-10.405a1.44 1.44 0 112.881.001 1.44 1.44 0 01-2.881-.001z"/></svg>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-span-1">
                    <h4 class="text-lg font-semibold mb-4 text-ocean-400">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="#hero" class="text-gray-400 hover:text-ocean-400 transition-colors duration-300">Home</a></li>
                        <li><a href="#about" class="text-gray-400 hover:text-ocean-400 transition-colors duration-300">About Us</a></li>
                        <li><a href="#species" class="text-gray-400 hover:text-ocean-400 transition-colors duration-300">Species</a></li>
                        <li><a href="#threats" class="text-gray-400 hover:text-ocean-400 transition-colors duration-300">Threats</a></li>
                        <li><a href="#help" class="text-gray-400 hover:text-ocean-400 transition-colors duration-300">How to Help</a></li>
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
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3 text-ocean-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <span class="text-gray-400">info@pawikanpatrol.org</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="border-t border-gray-800 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="text-gray-400 text-sm mb-4 md:mb-0">
                        &copy; 2025 Pawikan Patrol. All rights reserved. | City of Mati – Dahican, est. 2020
                    </div>
                    <div class="flex space-x-6 text-sm">
                        <a href="#" class="text-gray-400 hover:text-ocean-400 transition-colors duration-300">Privacy Policy</a>
                        <a href="#" class="text-gray-400 hover:text-ocean-400 transition-colors duration-300">Terms of Service</a>
                        <a href="#" class="text-gray-400 hover:text-ocean-400 transition-colors duration-300">Cookie Policy</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Rayver\Desktop\pawikan-patrol\my_app\resources\views/LandingPage.blade.php ENDPATH**/ ?>