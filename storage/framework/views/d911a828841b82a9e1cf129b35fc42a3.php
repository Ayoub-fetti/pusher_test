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
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold">
                    <?php
                        $otherUser = $conversation->users->where('id', '!=', auth()->id())->first();
                    ?>
                    <?php echo e($otherUser ? $otherUser->name : 'Group Conversation'); ?>

                </h3>
                <a href="<?php echo e(route('conversations.index')); ?>" class="text-blue-500 hover:underline">Back to Conversations</a>
            </div>
            
            <div id="messages-container" class="space-y-4 max-h-96 overflow-y-auto mb-4 p-4 border rounded-lg">
                <?php $__currentLoopData = $conversation->messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex <?php echo e($message->user_id === auth()->id() ? 'justify-end' : 'justify-start'); ?>">
                        <div class="<?php echo e($message->user_id === auth()->id() ? 'bg-blue-100' : 'bg-gray-100'); ?> p-3 rounded-lg max-w-3/4">
                            <p class="text-sm font-semibold"><?php echo e($message->user->name); ?></p>
                            <p><?php echo e($message->body); ?></p>
                            <p class="text-xs text-gray-500 mt-1"><?php echo e($message->created_at->format('M d, H:i')); ?></p>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                
            </div>
            
            <form action="<?php echo e(route('messages.store', $conversation)); ?>" method="POST" id="message-form">
                <?php echo csrf_field(); ?>
                <div class="flex">
                    <input type="text" name="body" id="message-input" placeholder="Type your message..." 
                           class="flex-grow p-2 border rounded-l-lg focus:outline-none focus:ring focus:border-blue-300" required>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-r-lg">Send</button>
                </div>
            </form>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
    <script>
        // Scroll to bottom of messages container
        const messagesContainer = document.getElementById('messages-container');
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
        
        // For Pusher implementation (Step 5)
    </script>
    <script>
        // Listen for new messages
            window.Echo.private('conversation.<?php echo e($conversation->id); ?>')
                .listen('MessageSent', (data) => {
                    // Create new message element
                    const messageDiv = document.createElement('div');
                    messageDiv.className = `flex ${data.user.id === <?php echo e(auth()->id()); ?> ? 'justify-end' : 'justify-start'}`;
                    
                    const messageContent = document.createElement('div');
                    messageContent.className = `${data.user.id === <?php echo e(auth()->id()); ?> ? 'bg-blue-100' : 'bg-gray-100'} p-3 rounded-lg max-w-3/4`;
                    
                    const userName = document.createElement('p');
                    userName.className = 'text-sm font-semibold';
                    userName.textContent = data.user.name;
                    
                    const messageBody = document.createElement('p');
                    messageBody.textContent = data.message.body;
                    
                    const messageTime = document.createElement('p');
                    messageTime.className = 'text-xs text-gray-500 mt-1';
                    messageTime.textContent = data.message.created_at;
                    
                    // Append all elements
                    messageContent.appendChild(userName);
                    messageContent.appendChild(messageBody);
                    messageContent.appendChild(messageTime);
                    messageDiv.appendChild(messageContent);
                    
                    // Add to container
                    document.getElementById('messages-container').appendChild(messageDiv);
                    
                    // Scroll to bottom
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                });

            // Clear input field after submission
            document.getElementById('message-form').addEventListener('submit', function() {
                setTimeout(() => {
                    document.getElementById('message-input').value = '';
                }, 10);
            });
    </script>
    <?php $__env->stopPush(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\pusher_test\resources\views/conversations/show.blade.php ENDPATH**/ ?>