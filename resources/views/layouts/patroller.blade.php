<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Patroller Dashboard') - Pawikan Patrol</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/lg.png') }}">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com/3.4.1"></script>
    
    <!-- Hotwire Turbo -->
    <script src="https://unpkg.com/@hotwired/turbo@7.3.0/dist/turbo.es2017-umd.js"></script>

    <!-- External Asset CDNs (Persistent for Turbo) -->
    <script src="https://static.sketchfab.com/api/sketchfab-viewer-1.12.1.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css" />
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/leaflet.fullscreen.css" />
    <script src="https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/Leaflet.fullscreen.min.js"></script>

    <!-- Tailwind Configuration -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        ocean: {
                            50: '#f0fdfa',
                            100: '#ccfbf1',
                            200: '#99f6e4',
                            300: '#5eead4',
                            400: '#2dd4bf',
                            500: '#14b8a6',
                            600: '#0d9488',
                            700: '#0f766e',
                            800: '#115e59',
                            900: '#134e4a',
                        },
                        deep: {
                            50: '#f8fafc',
                            100: '#f1f5f9',
                            200: '#e2e8f0',
                            300: '#cbd5e1',
                            400: '#94a3b8',
                            500: '#64748b',
                            600: '#475569',
                            700: '#334155',
                            800: '#1e293b',
                            900: '#0f172a',
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- Custom Styles -->
    <style>
        /* Cinzel font classes */
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

        /* Glass morphism effects */
        .glass-dark {
            background: rgba(15, 76, 117, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(45, 212, 191, 0.3);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        .glass-morphism {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        /* Form inputs */
        .form-input {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            font-family: 'Cinzel', serif;
        }

        .form-input:focus {
            outline: none;
            border-color: #2dd4bf;
            box-shadow: 0 0 0 3px rgba(45, 212, 191, 0.1);
        }

        .form-input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        /* Custom scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 3px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: linear-gradient(to bottom, #2dd4bf, #14b8a6);
            border-radius: 3px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(to bottom, #14b8a6, #0d9488);
        }

        /* Navigation styles */
        nav.fixed {
            position: fixed !important;
            z-index: 99999 !important;
        }

        /* Hide Turbo Progress Bar */
        .turbo-progress-bar {
            visibility: hidden !important;
            display: none !important;
        }

        /* Page Loading Overlay */
        #page-loader {
            position: fixed;
            top: 5rem; /* Height of the navigation (h-20 = 5rem) */
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(8px);
            z-index: 99998;
            display: none;
            justify-content: center;
            align-items: center;
            transition: opacity 0.3s ease;
        }

        #page-loader.active {
            display: flex;
            animation: fadeIn 0.2s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .loader-content {
            text-align: center;
        }

        .loader-spinner {
            width: 60px;
            height: 60px;
            border: 4px solid rgba(45, 212, 191, 0.1);
            border-left-color: #2dd4bf;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 1.5rem;
            box-shadow: 0 0 20px rgba(45, 212, 191, 0.2);
        }

        .loader-text {
            font-family: 'Cinzel', serif !important;
            color: #2dd4bf;
            font-size: 1.1rem;
            font-weight: 600;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            animation: pulse 1.5s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        @keyframes pulse {
            0%, 100% { opacity: 0.6; }
            50% { opacity: 1; }
        }
    </style>

    @stack('styles')
</head>
<body class="bg-gray-900 min-h-screen font-['Poppins'] text-white" style="background-color: #111827;">
    <!-- Navigation -->
    @include('patroller.navigation')

    <!-- Main Content -->
    <div class="relative z-0 pt-28 pb-12 px-4 sm:px-6 lg:px-8">
        <div class="@yield('container-class', 'max-w-7xl') mx-auto">
            @yield('content')
        </div>
    </div>

    <!-- Page Loader -->
    <div id="page-loader">
        <div class="loader-content">
            <div class="loader-spinner"></div>
            <div class="loader-text">Loading Patrol...</div>
        </div>
    </div>

    @stack('scripts')

    <script>
        document.addEventListener("turbo:before-visit", function() {
            document.getElementById("page-loader").classList.add("active");
        });

        document.addEventListener("turbo:submit-start", function() {
            document.getElementById("page-loader").classList.add("active");
        });

        document.addEventListener("turbo:load", function() {
            // Add a small delay for smoother transition
            setTimeout(() => {
                document.getElementById("page-loader").classList.remove("active");
            }, 300);
        });

        // Handle case where user clicks back button or navigation is cancelled
        document.addEventListener("turbo:render", function() {
            // Keep loader active if it's already there, load will hide it
        });
        
        document.addEventListener("turbo:request-end", function() {
            // In case of error, still remove loader
        });
    </script>

</body>
</html>
