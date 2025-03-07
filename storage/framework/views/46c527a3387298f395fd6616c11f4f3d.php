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
        <!-- Cover Photo -->
        
        <div class="relative h-48 bg-gray-300">
            <img class="w-full h-full object-cover" src="<?php echo e(asset('storage/' . $user->cover)); ?>" alt="Cover Photo">
            
        </div>


        
        <!-- Profile Info -->
        <div class="p-8">
            <div class="flex items-center">
                <img class="w-16 h-16 rounded-full border-4 border-white -mt-12" src="<?php echo e(asset('storage/' . $user->profile_picture)); ?>" alt="Profile Picture">
                <div class="ml-4">
                    <h2 class="text-2xl font-bold"><?php echo e($user->name); ?></h2>
                    <p class="text-gray-600"><?php echo e($user->bio); ?></p>
                </div>
            </div>
        </div>
        
        <!-- Contact & Links -->
        <div class="p-6 border-t">
            <p><a href="#" class="hover:font-bold"> <i class="fas fa-envelope text-yellow-600 mr-2 "></i><?php echo e($user->email); ?></a></p>
            <?php if($user->website): ?>
                <p><a href="<?php echo e($user->website); ?>" class="hover:font-bold"> <i class="fas fa-globe-africa text-blue-500 mr-2"></i>Website</a></p>
            <?php endif; ?>
            <?php if($user->github_url): ?>
                <p><a href="<?php echo e($user->github_url); ?>" class="hover:font-bold"><i class="fab fa-github mr-2"></i>GitHub</a></p>
            <?php endif; ?>
            <?php if($user->linkedin_url): ?>
                <p><a href="<?php echo e($user->linkedin_url); ?>" class="hover:font-bold"> <i class="fab fa-linkedin mr-2 text-blue-500"></i>LinkedIn</a></p>
            <?php endif; ?>
        </div>
    </div>
    <div class="mt-2 mb-2 mr-20 ml-20 bg-white shadow-lg rounded-lg overflow-hidden">
        <!-- Skills Section -->
        <div class="p-6">
            <h3 class="text-xl font-bold mb-4">Skills</h3>
            <div class="flex flex-wrap">
                <?php $__currentLoopData = $user->skills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <span class="bg-blue-100 text-blue-800 text-sm font-semibold mr-2 mb-2 px-4 py-2 rounded-full"><?php echo e($skill->name); ?></span>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
    <div class="mt-2 mb-2 mr-20 ml-20 bg-gray-300 shadow-lg rounded-lg overflow-hidden">

        <div class="flex gap-x-4">
            <div class="w-2/3 bg-white p-4">
                <!-- Projects Section -->
                <div class="mt-2 mb-2 bg-white shadow-lg rounded-lg overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-1">Your Projects <span></span></h3>
                        <a href="<?php echo e(route('projects.create')); ?>" class=" text-green-500 rounded-lg hover:text-green-600 font-bold">Add Project</a>
                        <div class="mt-2">
                            <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="mb-4">
                                    <h4 class="text-lg font-semibold"><?php echo e($project->title); ?></h4>
                                    <p><?php echo e($project->description); ?></p>
                                    <a href="<?php echo e($project->repo_link); ?>" target="_blank" class="text-blue-500">Repository Link</a>
                                </div>
                                <form action="<?php echo e(route('projects.destroy', $project)); ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this certification?');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit"><i class="fas fa-trash-alt text-red-500"></i></button>
                                </form>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </div>
        
            <div class="w-1/3 bg-white p-4">
                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="p-4 border-b flex items-center">
                        <img class="w-12 h-12 rounded-full" src="<?php echo e(asset('storage/' . $user->profile_picture)); ?>" alt="Profile Picture">
                        <div class="ml-4">
                            <h4 class="text-lg font-semibold"><?php echo e($user->name); ?></h4>
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
                            </button>
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
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        
    </div>
    <div class="mt-2 mb-2 mr-20 ml-20 bg-white shadow-lg rounded-lg overflow-hidden">
        <!-- certifications Section -->
        <div class="mt-2 mb-2 bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="p-6">
                <h3 class="text-xl font-bold mb-1"> Your Certifications <span></span></h3>
                <a href="<?php echo e(route('certifications.create')); ?>" class=" text-green-500 rounded-lg hover:text-green-600 font-bold">Add Certifications</a>
                <div class="mt-2">
                    <?php $__currentLoopData = $certifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $certification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="mb-4">
                            <h4 class="text-lg font-semibold"><?php echo e($certification->title); ?></h4>
                            <p class="text-gray-500 text-xs"><?php echo e($certification->certification_date); ?></p>
                            <p><?php echo e($certification->description); ?></p>
                            <a href="<?php echo e($certification->certification_link); ?>" target="_blank" class="text-blue-500">Certification Link</a>
                        </div>
                        <form action="<?php echo e(route('certifications.destroy', $certification->id)); ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this certification?');">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit"><i class="fas fa-trash-alt text-red-500"></i></button>
                        </form>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-2 mb-2 mr-20 ml-20 bg-white shadow-lg rounded-lg overflow-hidden">
        <!-- Jobs Section -->
        <div class="mt-2 mb-2 bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="p-6">
                <h3 class="text-xl font-bold mb-1">Your Jobs <span></span></h3>
                <a href="<?php echo e(route('Job_offers.create')); ?>" class=" text-green-500 rounded-lg hover:text-green-600 font-bold">Add Jobs</a>
                <div class="mt-2">
                    <?php $__currentLoopData = $job_offers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="mb-4">
                            <h4 class="text-lg font-semibold"><?php echo e($job->title); ?></h4>
                        <p class="text-gray-600"><?php echo e($job->company_name); ?></p>
                        <p class="text-gray-500 text-xs"><?php echo e($job->contract_type); ?> | <?php echo e($job->location); ?></p>
                        
                        <p class="text-gray-500 text-xs">Posted: <?php echo e(\Carbon\Carbon::parse($job->date_published)->format('Y-m-d')); ?></p> 
                        <p class="mt-2"><?php echo e($job->description); ?></p>
                        <?php if($job->offer_link): ?>
                            <a href="<?php echo e($job->offer_link); ?>" target="_blank" class="text-blue-500 hover:underline">View details</a>
                        <?php endif; ?>
                        </div>
                        <div class="flex gap-3 ml-2">
                            <form action="<?php echo e(route('Job_offers.destroy', $job->id)); ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this offer?');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit"><i class="fas fa-trash-alt text-red-500"></i></button>
                            </form>
                            <form action="<?php echo e(route('Job_offers.edit', $job->id)); ?>" method="GET">
                                <?php echo csrf_field(); ?>
                                <button type="submit"><i class="fas fa-pen text-orange-500"></i></button>
                            </form>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>

    
    <div class="mt-2 mb-2 mr-20 ml-20 bg-white shadow-lg rounded-lg overflow-hidden">
        <!--posts Section -->
        <div class="mt-4 mb-4 bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="p-6">
                <h3 class="text-xl font-bold mb-4">Your Posts</h3>
                <a href="<?php echo e(route('posts.create')); ?>" class="text-green-500 hover:text-green-600 font-bold">➕ Ajouter un Post</a>
                
                <div class="mt-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="bg-white p-4 rounded-lg shadow-md flex flex-col justify-between">
                            <!-- Header du post -->
                            <div>
                                <div class="flex items-center mb-2">
                                    <img src="<?php echo e(asset('storage/' . $post->user->profile_picture)); ?>" alt="Avatar" class="w-10 h-10 rounded-full mr-3">
                                    <div>
                                        <h4 class="text-lg font-semibold"><?php echo e($post->user->name); ?></h4>
                                        <p class="text-sm text-gray-500"><?php echo e($post->created_at->diffForHumans()); ?></p>
                                    </div>
                                </div>
                                
                                <!-- Contenu du post -->
                                <p class="text-gray-800"><?php echo e($post->content); ?></p>
                                <p class="text-blue-800 text-sm">
                                    <?php $__currentLoopData = $post->hashtags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hashtag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php echo e($hashtag->name); ?>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </p>
                                
                                <?php if($post->image): ?>
                                    <img src="<?php echo e(asset('storage/' . $post->image)); ?>" alt="Post Image" class="w-80 h-auto mt-2 rounded-lg">
                                <?php endif; ?>
                            </div>
        
                            <!-- Boutons d'interaction -->
                            <div class="flex items-center justify-center gap-6 mt-3 text-gray-600">

                                <a href="<?php echo e(route('posts.edit',$post->id)); ?>" class="flex items-center hover:text-orange-500">
                                    <i class="fas fa-pen text-orange-500 mr-1"></i> Edit
                                </a>
                                
                                <!-- Bouton de suppression -->
                                <form method="POST" action="<?php echo e(route('posts.destroy', $post->id)); ?>" onsubmit="return confirm('Voulez-vous vraiment supprimer ce post ?');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="flex items-center hover:text-red-600">
                                        <i class="far fa-minus-square text-red-500 mr-1"></i> Supprimer
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
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
<?php endif; ?><?php /**PATH C:\laragon\www\pusher_test\resources\views/profile/view.blade.php ENDPATH**/ ?>