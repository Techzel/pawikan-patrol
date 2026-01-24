

<?php $__env->startSection('title', 'Content Management - DENR Admin'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    /* Reusing Admin Dashboard styles */
    #admin-content,
    #admin-content * {
        font-family: 'Poppins', sans-serif !important;
        letter-spacing: 0.01em;
    }

    #admin-content .section-heading {
        font-weight: 700;
        letter-spacing: 0.02em;
        text-transform: uppercase;
    }

    .body-text {
        font-weight: 400;
        letter-spacing: 0.01em;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-fadeIn {
        animation: fadeIn 0.5s ease-out forwards;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div id="admin-content" class="min-h-screen bg-gray-900 pt-20">
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-12 pb-12 relative z-10">
        <!-- Alert Messages -->
        <?php if(session('success')): ?>
            <div class="mb-6 p-4 bg-green-500/20 border border-green-500/50 rounded-xl text-green-100 text-sm backdrop-blur-sm flex items-center shadow-lg animate-fadeIn">
                <svg class="w-5 h-5 mr-3 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="font-medium font-poppins"><?php echo e(session('success')); ?></span>
            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="mb-6 p-4 bg-red-500/20 border border-red-500/50 rounded-xl text-red-100 text-sm backdrop-blur-sm flex items-center shadow-lg animate-fadeIn">
                <svg class="w-5 h-5 mr-3 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="font-medium font-poppins"><?php echo e(session('error')); ?></span>
            </div>
        <?php endif; ?>
        
        <?php if($errors->any()): ?>
            <div class="mb-6 p-4 bg-red-500/20 border border-red-500/50 rounded-xl text-red-100 text-sm backdrop-blur-sm shadow-lg animate-fadeIn">
                <div class="flex items-center mb-2">
                    <svg class="w-5 h-5 mr-3 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <span class="font-bold font-poppins">Validation Errors</span>
                </div>
                <ul class="list-disc list-inside ml-8 space-y-1">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Header -->
        <header class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-white mb-2 section-heading">Content Management</h1>
                    <p class="text-gray-400 body-text">Manage website resources and downloadable content</p>
                </div>
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="flex items-center px-4 py-2 bg-gray-800 hover:bg-gray-700 text-gray-300 rounded-lg transition-colors border border-gray-700">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg> Back to Dashboard
                </a>
            </div>
        </header>

        <!-- Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Upload New Resource -->
            <div class="bg-white/10 backdrop-blur-md rounded-xl border border-white/20 overflow-hidden h-fit">
                <div class="p-6 border-b border-white/10 bg-gradient-to-r from-blue-900/40 to-transparent">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-blue-500/20 rounded-lg flex items-center justify-center border border-blue-500/30">
                            <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-white section-heading">Upload Resource</h2>
                            <p class="text-gray-400 text-sm body-text">Add new PDF storytelling modules</p>
                        </div>
                    </div>
                </div>
                
                <div class="p-6">
                    <form action="<?php echo e(route('admin.content.storytelling.upload')); ?>" method="POST" enctype="multipart/form-data" class="space-y-4">
                        <?php echo csrf_field(); ?>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Resource File (PDF)</label>
                            <div class="relative">
                                <input type="file" name="module_file" accept=".pdf" required
                                    class="block w-full text-sm text-gray-400
                                    file:mr-4 file:py-2.5 file:px-4
                                    file:rounded-lg file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-blue-600 file:text-white
                                    file:cursor-pointer hover:file:bg-blue-700
                                    bg-gray-800 border border-gray-700 rounded-lg cursor-pointer focus:outline-none">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Display Name (Optional)</label>
                            <input type="text" name="custom_name" placeholder="Leave blank to use filename"
                                class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <p class="mt-1 text-xs text-gray-500">This name will be used for the file.</p>
                        </div>
                        
                        <div class="pt-2">
                            <button type="submit" class="w-full px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors shadow-lg hover:shadow-blue-600/20 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                <span>Add Resource</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Existing Resources List -->
            <div class="bg-white/10 backdrop-blur-md rounded-xl border border-white/20 overflow-hidden">
                <div class="p-6 border-b border-white/10 bg-gradient-to-r from-emerald-900/40 to-transparent">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-emerald-500/20 rounded-lg flex items-center justify-center border border-emerald-500/30">
                            <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-white section-heading">Current Resources</h2>
                            <p class="text-gray-400 text-sm body-text">Manage available downloads</p>
                        </div>
                    </div>
                </div>
                
                <div class="p-6">
                    <?php if(count($files) > 0): ?>
                        <div class="space-y-4">
                            <?php $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="bg-gray-800/50 border border-gray-700 rounded-lg p-4 flex items-center justify-between group hover:border-blue-500/30 transition-colors">
                                    <div class="flex items-center gap-4 overflow-hidden">
                                        <div class="w-10 h-10 bg-red-500/10 rounded-lg flex-shrink-0 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                        </div>
                                        <div class="min-w-0">
                                            <h4 class="text-white font-medium truncate" title="<?php echo e($file['name']); ?>">
                                                <?php echo e($file['name']); ?>

                                            </h4>
                                            <div class="flex text-xs text-gray-500 gap-3">
                                                <span><?php echo e(number_format($file['size'] / 1024, 1)); ?> KB</span>
                                                <span>•</span>
                                                <span><?php echo e(date('M d, Y', $file['last_modified'])); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center gap-2">
                                        <a href="<?php echo e($file['url']); ?>" target="_blank" class="p-2 text-gray-400 hover:text-blue-400 bg-gray-700/50 hover:bg-gray-700 rounded-lg transition-colors" title="View">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </a>
                                        
                                        <button onclick="confirmDelete('<?php echo e($file['path']); ?>', '<?php echo e($file['name']); ?>')" class="p-2 text-gray-400 hover:text-red-400 bg-gray-700/50 hover:bg-gray-700 rounded-lg transition-colors" title="Delete">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-12">
                            <div class="w-16 h-16 bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-400 mb-2">No Resources Found</h3>
                            <p class="text-gray-500 text-sm max-w-xs mx-auto">Upload PDF files to make them available for download on the landing page.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-50">
        <div class="bg-gray-800 border border-white/10 rounded-xl p-6 max-w-md w-full mx-4 shadow-2xl transform transition-all scale-100">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 bg-red-500/10 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-white">Delete Resource?</h3>
                    <p class="text-gray-400 text-sm">This action cannot be undone.</p>
                </div>
            </div>
            
            <p class="text-gray-300 mb-6 text-sm">
                Are you sure you want to delete <span id="deleteFileName" class="font-semibold text-white"></span>? This will remove it from the download list immediately.
            </p>
            
            <div class="flex justify-end gap-3">
                <button onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg text-sm font-medium transition-colors">
                    Cancel
                </button>
                <form id="deleteForm" action="<?php echo e(route('admin.content.storytelling.delete')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <input type="hidden" name="file_path" id="deleteFilePath">
                    <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-500 text-white rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        Delete Resource
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(path, name) {
        document.getElementById('deleteFilePath').value = path;
        document.getElementById('deleteFileName').textContent = name;
        document.getElementById('deleteModal').classList.remove('hidden');
        document.getElementById('deleteModal').classList.add('flex');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        document.getElementById('deleteModal').classList.remove('flex');
    }
    
    // Close on click outside
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeDeleteModal();
        }
    });
    
    // Close on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeDeleteModal();
        }
    });
</script>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Rayver\Desktop\my_app\resources\views/admin/content.blade.php ENDPATH**/ ?>