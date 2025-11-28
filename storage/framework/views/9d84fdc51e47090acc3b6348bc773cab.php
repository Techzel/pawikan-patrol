<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Admin Dashboard'); ?> - Pawikan Patrol</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo e(asset('img/web_lg.png')); ?>">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts - Cinzel -->
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Cinzel', 'Inter', 'system-ui', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'Roboto', 'Helvetica Neue', 'Arial', 'sans-serif'],
                        'cinzel': ['Cinzel', 'serif']
                    }
                }
            }
        }
    </script>
    
    <style>
        :root {
            --font-cinzel: 'Cinzel', serif;
        }
        body {
            font-family: var(--font-cinzel), 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }
        .cinzel-heading {
            font-family: var(--font-cinzel);
            font-weight: 700;
            letter-spacing: 0.05em;
        }
        .cinzel-subheading {
            font-family: var(--font-cinzel);
            font-weight: 600;
            letter-spacing: 0.03em;
        }
        .cinzel-text {
            font-family: var(--font-cinzel);
            font-weight: 400;
            letter-spacing: 0.02em;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        /* Global Cinzel Font Application */
        h1, h2, h3, h4, h5, h6 {
            font-family: var(--font-cinzel);
            font-weight: 600;
            letter-spacing: 0.02em;
        }
        
        .btn, button {
            font-family: var(--font-cinzel);
            font-weight: 500;
            letter-spacing: 0.01em;
        }
        
        .nav-link, .menu-item {
            font-family: var(--font-cinzel);
            font-weight: 400;
            letter-spacing: 0.01em;
        }
        
        label, .form-label {
            font-family: var(--font-cinzel);
            font-weight: 500;
            letter-spacing: 0.01em;
        }
        
        .table th {
            font-family: var(--font-cinzel);
            font-weight: 600;
            letter-spacing: 0.02em;
        }
    </style>
    
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen overflow-hidden">
        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden w-full">
            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto">
                <?php if(session('success')): ?>
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                        <span class="block sm:inline"><?php echo e(session('success')); ?></span>
                        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                            <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <title>Close</title>
                                <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                            </svg>
                        </span>
                    </div>
                <?php endif; ?>
                
                <?php if($errors->any()): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                        <strong class="font-bold">Whoops!</strong>
                        <span class="block sm:inline"> There were some problems with your input.</span>
                        <ul class="mt-2 list-disc list-inside">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>
                
                <?php echo $__env->yieldContent('content'); ?>
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.0.0/dist/cdn.min.js" defer></script>
    
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\Rayver\Desktop\pawikan-patrol\my_app\resources\views/layouts/admin.blade.php ENDPATH**/ ?>