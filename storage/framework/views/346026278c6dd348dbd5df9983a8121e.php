<!-- filepath: /c:/laragon/www/LinkDev/resources/views/notification.blade.php -->
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
    <div class="py-12 max-w-4xl mx-auto">
        <h2 class="text-xl font-semibold mb-4">Notifications</h2>
        <div class="bg-white shadow-md rounded-lg p-6">
            <?php if($receivedConnections->isEmpty() && $notifications->whereNull('read_at')->isEmpty()): ?>
                <p class="text-gray-500 text-center">No notifications available.</p>
            <?php else: ?>
                <!-- Combined notifications list -->
                <div class="space-y-4">
                    <!-- Connection requests -->
                    <?php $__currentLoopData = $receivedConnections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $connection): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-center justify-between border-b pb-4">
                            <div class="flex items-center gap-3">
                                <img class="w-12 h-12 rounded-full" src="<?php echo e(asset('storage/' . $connection->sourceUser->profile_picture)); ?>" alt="Profile Picture">
                                <p class="text-gray-800"><span class="font-semibold"><?php echo e($connection->sourceUser->name); ?></span> wants to connect with you.</p>
                            </div>
                            <div class="flex gap-2">
                                <form action="<?php echo e(route('connections.accept')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="connection_id" value="<?php echo e($connection->id); ?>">
                                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Accept</button>
                                </form>
                                <form action="<?php echo e(route('connections.reject')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="connection_id" value="<?php echo e($connection->id); ?>">
                                    <button type="submit" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400">Reject</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <!-- Likes and Comments notifications - Only unread -->
                    <?php $__currentLoopData = $notifications->whereNull('read_at'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-center justify-between border-b pb-4">
                            <div class="flex items-center gap-3">
                                <?php if(isset($notification->data['user_image'])): ?>
                                    <img class="w-12 h-12 rounded-full" src="<?php echo e(asset('storage/' . $notification->data['user_image'])); ?>" alt="Profile Picture">
                                <?php else: ?>
                                    <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if($notification->type === 'App\Notifications\PostLiked'): ?>
                                    <p class="text-gray-800"><span class="font-semibold"><?php echo e($notification->data['message']); ?></span></p>
                                <?php elseif($notification->type === 'App\Notifications\CommentNofication'): ?>
                                    <p class="text-gray-800"><span class="font-semibold"><?php echo e($notification->data['message']); ?></span></p>
                                <?php else: ?>
                                    <p class="text-gray-800"><?php echo e($notification->data['message']); ?></p>
                                <?php endif; ?>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-xs text-gray-500"><?php echo e($notification->created_at->diffForHumans()); ?></span>
                                <form action="<?php echo e(route('notifications.markAsRead', $notification->id)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="text-gray-400 hover:text-gray-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\pusher_test\resources\views/notification.blade.php ENDPATH**/ ?>