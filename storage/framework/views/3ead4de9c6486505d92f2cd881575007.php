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
    <div class="mt-10 mr-20 ml-20 bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="p-6">
            <h3 class="text-xl font-bold mb-4">My Conversations</h3>
            
            <?php if($conversations->isEmpty()): ?>
                <p class="text-gray-500">You don't have any conversations yet.</p>
            <?php else: ?>
                <div class="space-y-3">
                    <?php $__currentLoopData = $conversations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $conversation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('conversations.show', $conversation)); ?>" class="block p-4 border rounded-lg hover:bg-gray-50">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <?php
                                        $otherUser = $conversation->users->where('id', '!=', auth()->id())->first();
                                    ?>
                                    <div class="flex-shrink-0">
                                        <img src="<?php echo e(asset('storage/' . $otherUser->profile_picture)); ?>" 
                                             class="h-12 w-12 rounded-full object-cover border-2 border-gray-200" 
                                             alt="<?php echo e($otherUser->name); ?>'s profile picture">
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="font-medium text-gray-900">
                                            <?php echo e($otherUser ? $otherUser->name : 'Group Conversation'); ?>

                                        </h4>
                                        <p class="text-sm text-gray-500 truncate">
                                            <?php echo e($conversation->lastMessage ? $conversation->lastMessage->body : 'Start a conversation'); ?>

                                        </p>
                                    </div>
                                </div>
                                <div class="flex flex-col items-end">
                                    <span class="text-xs text-gray-500">
                                        <?php echo e($conversation->updated_at->diffForHumans()); ?>

                                    </span>
                                    <?php
                                        $unreadCount = $conversation->unreadMessagesFor(auth()->user());
                                    ?>
                                    <?php if($unreadCount > 0): ?>
                                        <span class="bg-blue-500 text-white text-xs rounded-full px-2 py-1 mt-1">
                                            <?php echo e($unreadCount); ?>

                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
            
            <div class="mt-6">
                <h4 class="font-medium mb-2">Start a New Conversation</h4>
                <form action="<?php echo e(route('conversations.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="mb-4">
                        <label for="user_id" class="block text-sm font-medium text-gray-700">Select User</label>
                        <select name="user_id" id="user_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            <option value="">Select a user</option>

                            <?php $__currentLoopData = $connectedUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700">Conversation Title (Optional)</label>
                        <input type="text" name="title" id="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Start Conversation</button>
                </form>
            </div>
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
<?php endif; ?><?php /**PATH C:\laragon\www\pusher_test\resources\views/conversations/index.blade.php ENDPATH**/ ?>