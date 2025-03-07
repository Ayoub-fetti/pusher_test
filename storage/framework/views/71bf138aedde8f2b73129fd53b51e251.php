<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="container mx-auto mt-10 flex justify-center">
        <!-- Main content with posts and user sidebar -->
        <div class="flex w-full justify-center max-w-6xl gap-6">
            <!-- Left side - Posts column -->
            <div class="w-2/3">
                <input type="text" id="searchInput" placeholder="Search posts..." class="w-full p-2 mb-4 border rounded">
                <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-white p-4 rounded-lg shadow-md flex flex-col justify-between mb-6 post" data-post-id="<?php echo e($post->id); ?>">
                        <div class="flex items-center mb-2">
                            <img src="<?php echo e(asset('storage/' . $post->user->profile_picture)); ?>" alt="Avatar" class="w-10 h-10 rounded-full mr-3">
                            <div>
                                <h4 class="text-lg font-semibold"><?php echo e($post->user->name); ?></h4>
                                <p class="text-sm text-gray-500"><?php echo e($post->created_at->diffForHumans()); ?></p>
                            </div>
                        </div>
                        <p class="text-gray-800 text-sm post-content"><?php echo e($post->content); ?></p>
                        <p class="text-blue-800 text-xs">
                            <?php $__currentLoopData = $post->hashtags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hashtag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php echo e($hashtag->name); ?>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </p>
                        <?php if($post->image): ?>
                            <img src="<?php echo e(asset('storage/' . $post->image)); ?>" alt="Post Image" class="w-full h-auto mt-2 rounded-lg">
                        <?php endif; ?>
                        <div class="flex items-center justify-between mt-3 text-gray-600 text-sm">
                            <button onclick="toggleLike(<?php echo e($post->id); ?>)" class="like-button flex items-center space-x-2 hover:text-blue-600" data-post-id="<?php echo e($post->id); ?>">
                                <svg class="h-5 w-5 like-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                                <span class="likes-count"><?php echo e($post->likes->count()); ?></span>
                                <span>likes</span>
                            </button>

                            <button onclick="toggleCommentSection(<?php echo e($post->id); ?>)" class="flex items-center hover:text-blue-600">
                                <i class="far fa-comment text-blue-500 mr-1"></i> Comment <span class="ml-2" id="comment-count-<?php echo e($post->id); ?>">(<?php echo e($post->comments->count()); ?>)</span>
                            </button>
                            <button onclick="sharePost(<?php echo e($post->id); ?>)" class="flex items-center hover:text-green-500" data-post-id="<?php echo e($post->id); ?>">
                                <i class="fas fa-share text-green-500 mr-1"></i> Share
                            </button>
                            <?php if(Auth::id() === $post->user_id): ?>
                                <a href="<?php echo e(route('posts.edit', $post->id)); ?>" class="flex items-center hover:text-orange-500">
                                    <i class="fas fa-pen text-orange-500 mr-1"></i> Edit
                                </a>
                                <form method="POST" action="<?php echo e(route('posts.destroy', $post->id)); ?>" onsubmit="return confirm('Voulez-vous vraiment supprimer ce post ?');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="flex items-center hover:text-red-600">
                                        <i class="far fa-minus-square text-red-500 mr-1"></i> Supprimer
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Comment Section -->
                        <div id="comment-section-<?php echo e($post->id); ?>" class="hidden mt-4 border-t pt-4">
                            <!-- Scrollable Comments Container -->
                            <div class="max-h-40 overflow-y-auto mb-4">
                                <?php $__currentLoopData = $post->comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="flex items-start mb-2">
                                        <img src="<?php echo e(asset('storage/' . $comment->user->profile_picture)); ?>" alt="Avatar" class="w-8 h-8 rounded-full mr-2">
                                        <div>
                                            <p class="text-sm font-semibold"><?php echo e($comment->user->name); ?></p>
                                            <p class="text-xs text-gray-600"><?php echo e($comment->content); ?></p>
                                            <p class="text-xs text-gray-400"><?php echo e($comment->created_at->diffForHumans()); ?></p>
                                        </div>
                                        <?php if($comment->user_id == Auth::id()): ?>
                                        <form action="<?php echo e(route('comments.destroy', $comment->id)); ?>" method="POST" style="display:inline;">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit"><i class="far fa-trash-alt text-red-500 ml-12"></i></button>
                                        </form>
                                    <?php endif; ?>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            
                            <!-- Comment Input Form -->
                            <form action="<?php echo e(route('comments.store', $post->id)); ?>" method="POST" class="flex">
                                <?php echo csrf_field(); ?>
                                <input type="text" name="content" placeholder="Write a comment..." class="flex-grow p-2 border rounded-l-lg text-sm">
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-r-lg text-sm">Send</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            
            <!-- Right side - Users column -->
            <div class="w-1/3">
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <h3 class="text-lg font-semibold mb-4 border-b pb-2">People you may know</h3>
                    <div class="space-y-4">
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($user->id != Auth::id()): ?>
                                <div class="p-4 border-b flex items-center">
                                    <img class="w-10 h-10 rounded-full" src="<?php echo e(asset('storage/' . $user->profile_picture)); ?>" alt="Profile Picture">
                                    <div class="ml-3">
                                        <h4 class="text-base font-semibold"><?php echo e($user->name); ?></h4>
                                    </div>
                                    <div class="ml-auto">
                                        <?php
                                            $connectionStatus = auth()->user()->connectionStatus($user->id);
                                        ?>
                                        <?php if($connectionStatus == 'pending'): ?>
                                        <button class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-yellow-500 to-orange-500 group-hover:from-yellow-500 group-hover:to-orange-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-yellow-200 dark:focus:ring-yellow-800" disabled>
                                            <span class="relative px-2 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-transparent group-hover:dark:bg-transparent">
                                            Pending
                                            </span>
                                        <?php elseif($connectionStatus == 'accepted'): ?>
                                        <button class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-green-500 to-teal-500 group-hover:from-green-500 group-hover:to-teal-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-800" disabled>
                                            <span class="relative px-2 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-transparent group-hover:dark:bg-transparent">
                                            Connected
                                            </span>
                                        </button>
                                        <?php else: ?>
                                            <form action="<?php echo e(route('connections.send')); ?>" method="post">
                                                <?php echo csrf_field(); ?>
                                                <input type="hidden" name="target_user_id" value="<?php echo e($user->id); ?>">
                                                <button class="bg-blue-500 text-white px-4 py-1 rounded-lg">+ Connect</button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                
                <!-- Jobs section -->
                <div class="bg-white p-4 rounded-lg shadow-md mt-5">
                    <h3 class="text-lg font-semibold mb-4 border-b pb-2">Latest Jobs</h3>
                    <div class="space-y-4">
                        <?php $__empty_1 = true; $__currentLoopData = $jobs ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="p-3 border rounded hover:bg-gray-50 transition">
                                <h4 class="text-base font-semibold"><?php echo e($job->title); ?></h4>
                                <div class="text-sm text-gray-600 my-1"><?php echo e($job->company); ?></div>
                                <div class="flex items-center text-xs text-gray-500 mb-2">
                                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <?php echo e($job->location); ?>

                                </div>
                                <p class="text-xs text-gray-600 line-clamp-2"><?php echo e(Str::limit($job->description, 100)); ?></p>
                                <div class="mt-2 flex justify-between items-center">
                                    <span class="text-xs text-gray-500">Posted <?php echo e($job->created_at->diffForHumans()); ?></span>
                                    <a href="<?php echo e($job->offer_link); ?>" target="_blank" class="text-blue-500 hover:underline">View details</a>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="p-3 text-center text-gray-500">
                                No jobs available at the moment.
                            </div>
                        <?php endif; ?>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    <script>
        // Enable pusher logging for debugging
        Pusher.logToConsole = true;
        
        const pusher = new Pusher('<?php echo e(env('PUSHER_APP_KEY')); ?>', {
            cluster: '<?php echo e(env('PUSHER_APP_CLUSTER')); ?>',
            encrypted: true
        });
        
        const channel = pusher.subscribe('jobs');
        
        // Add this debug event listener
        channel.bind('pusher:subscription_succeeded', function() {
            console.log('Successfully subscribed to jobs channel');
        });
        
        channel.bind('App\\Events\\JobApplicationCreated', function(data) {
            console.log('Received job application event:', data);
            
            // Existing code...
            const jobsContainer = document.querySelector('.bg-white.p-4.rounded-lg.shadow-md.mt-5 .space-y-4');
            
            // Check if there are no jobs message
            const noJobsMessage = jobsContainer.querySelector('.text-center.text-gray-500');
            if (noJobsMessage) {
                jobsContainer.innerHTML = ''; // Remove no jobs message
            }
            
            // Create a new job element
            const jobElement = document.createElement('div');
            jobElement.className = 'p-3 border rounded hover:bg-gray-50 transition';
            jobElement.innerHTML = `
                <h4 class="text-base font-semibold">${data.job.title}</h4>
                <div class="text-sm text-gray-600 my-1">${data.job.company_name || data.job.company}</div>
                <div class="flex items-center text-xs text-gray-500 mb-2">
                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    ${data.job.location || 'Remote'}
                </div>
                <p class="text-xs text-gray-600 line-clamp-2">${data.job.description ? data.job.description.slice(0, 100) + (data.job.description.length > 100 ? '...' : '') : 'No description available'}</p>
                <div class="mt-2 flex justify-between items-center">
                    <span class="text-xs text-gray-500">Posted just now</span>
                    <a href="${data.job.offer_link || '#'}" target="_blank" class="text-blue-500 hover:underline">View details</a>
                </div>
            `;
            
            // Add the new job to the top of the list
            jobsContainer.prepend(jobElement);
            
            // Show notification
            showNotification('New job posted', `${data.job.title} at ${data.job.company_name || data.job.company}`);
        });
        
        function showNotification(title, body) {
            if ('Notification' in window) {
                if (Notification.permission === 'granted') {
                    new Notification(title, {body: body});
                } else if (Notification.permission !== 'denied') {
                    Notification.requestPermission().then(permission => {
                        if (permission === 'granted') {
                            new Notification(title, {body: body});
                        }
                    });
                }
            }
        }
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\pusher_test\resources\views/dashboard.blade.php ENDPATH**/ ?>