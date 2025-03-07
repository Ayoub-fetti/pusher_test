<x-app-layout>
    <div class="container mx-auto mt-10 flex justify-center">
        <!-- Main content with posts and user sidebar -->
        <div class="flex w-full justify-center max-w-6xl gap-6">
            <!-- Left side - Posts column -->
            <div class="w-2/3">
                <input type="text" id="searchInput" placeholder="Search posts..." class="w-full p-2 mb-4 border rounded">
                @foreach($posts as $post)
                    <div class="bg-white p-4 rounded-lg shadow-md flex flex-col justify-between mb-6 post" data-post-id="{{ $post->id }}">
                        <div class="flex items-center mb-2">
                            <img src="{{ asset('storage/' . $post->user->profile_picture) }}" alt="Avatar" class="w-10 h-10 rounded-full mr-3">
                            <div>
                                <h4 class="text-lg font-semibold">{{ $post->user->name }}</h4>
                                <p class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <p class="text-gray-800 text-sm post-content">{{ $post->content }}</p>
                        <p class="text-blue-800 text-xs">
                            @foreach($post->hashtags as $hashtag)
                                {{ $hashtag->name }}
                            @endforeach
                        </p>
                        @if($post->image)
                            <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="w-full h-auto mt-2 rounded-lg">
                        @endif
                        <div class="flex items-center justify-between mt-3 text-gray-600 text-sm">
                            <button onclick="toggleLike({{ $post->id }})" class="like-button flex items-center space-x-2 hover:text-blue-600" data-post-id="{{ $post->id }}">
                                <svg class="h-5 w-5 like-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                                <span class="likes-count">{{ $post->likes->count() }}</span>
                                <span>likes</span>
                            </button>

                            <button onclick="toggleCommentSection({{ $post->id }})" class="flex items-center hover:text-blue-600">
                                <i class="far fa-comment text-blue-500 mr-1"></i> Comment <span class="ml-2" id="comment-count-{{ $post->id}}">({{ $post->comments->count() }})</span>
                            </button>
                            <button onclick="sharePost({{ $post->id }})" class="flex items-center hover:text-green-500" data-post-id="{{$post->id}}">
                                <i class="fas fa-share text-green-500 mr-1"></i> Share
                            </button>
                            @if (Auth::id() === $post->user_id)
                                <a href="{{ route('posts.edit', $post->id) }}" class="flex items-center hover:text-orange-500">
                                    <i class="fas fa-pen text-orange-500 mr-1"></i> Edit
                                </a>
                                <form method="POST" action="{{ route('posts.destroy', $post->id) }}" onsubmit="return confirm('Voulez-vous vraiment supprimer ce post ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="flex items-center hover:text-red-600">
                                        <i class="far fa-minus-square text-red-500 mr-1"></i> Supprimer
                                    </button>
                                </form>
                            @endif
                        </div>
                        
                        <!-- Comment Section -->
                        <div id="comment-section-{{ $post->id }}" class="hidden mt-4 border-t pt-4">
                            <!-- Scrollable Comments Container -->
                            <div class="max-h-40 overflow-y-auto mb-4">
                                @foreach($post->comments as $comment)
                                    <div class="flex items-start mb-2">
                                        <img src="{{ asset('storage/' . $comment->user->profile_picture) }}" alt="Avatar" class="w-8 h-8 rounded-full mr-2">
                                        <div>
                                            <p class="text-sm font-semibold">{{ $comment->user->name }}</p>
                                            <p class="text-xs text-gray-600">{{ $comment->content }}</p>
                                            <p class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</p>
                                        </div>
                                        @if($comment->user_id == Auth::id())
                                        <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"><i class="far fa-trash-alt text-red-500 ml-12"></i></button>
                                        </form>
                                    @endif
                                    </div>
                                @endforeach
                            </div>
                            
                            <!-- Comment Input Form -->
                            <form action="{{ route('comments.store', $post->id) }}" method="POST" class="flex">
                                @csrf
                                <input type="text" name="content" placeholder="Write a comment..." class="flex-grow p-2 border rounded-l-lg text-sm">
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-r-lg text-sm">Send</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Right side - Users column -->
            <div class="w-1/3">
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <h3 class="text-lg font-semibold mb-4 border-b pb-2">People you may know</h3>
                    <div class="space-y-4">
                        @foreach ($users as $user)
                            @if($user->id != Auth::id())
                                <div class="p-4 border-b flex items-center">
                                    <img class="w-10 h-10 rounded-full" src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture">
                                    <div class="ml-3">
                                        <h4 class="text-base font-semibold">{{ $user->name }}</h4>
                                    </div>
                                    <div class="ml-auto">
                                        @php
                                            $connectionStatus = auth()->user()->connectionStatus($user->id);
                                        @endphp
                                        @if($connectionStatus == 'pending')
                                        <button class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-yellow-500 to-orange-500 group-hover:from-yellow-500 group-hover:to-orange-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-yellow-200 dark:focus:ring-yellow-800" disabled>
                                            <span class="relative px-2 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-transparent group-hover:dark:bg-transparent">
                                            Pending
                                            </span>
                                        @elseif($connectionStatus == 'accepted')
                                        <button class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-green-500 to-teal-500 group-hover:from-green-500 group-hover:to-teal-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-800" disabled>
                                            <span class="relative px-2 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-transparent group-hover:dark:bg-transparent">
                                            Connected
                                            </span>
                                        </button>
                                        @else
                                            <form action="{{ route('connections.send')}}" method="post">
                                                @csrf
                                                <input type="hidden" name="target_user_id" value="{{ $user->id }}">
                                                <button class="bg-blue-500 text-white px-4 py-1 rounded-lg">+ Connect</button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                
                <!-- Jobs section -->
                <div class="bg-white p-4 rounded-lg shadow-md mt-5">
                    <h3 class="text-lg font-semibold mb-4 border-b pb-2">Latest Jobs</h3>
                    <div class="space-y-4">
                        @forelse ($jobs ?? [] as $job)
                            <div class="p-3 border rounded hover:bg-gray-50 transition">
                                <h4 class="text-base font-semibold">{{ $job->title }}</h4>
                                <div class="text-sm text-gray-600 my-1">{{ $job->company }}</div>
                                <div class="flex items-center text-xs text-gray-500 mb-2">
                                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    {{ $job->location }}
                                </div>
                                <p class="text-xs text-gray-600 line-clamp-2">{{ Str::limit($job->description, 100) }}</p>
                                <div class="mt-2 flex justify-between items-center">
                                    <span class="text-xs text-gray-500">Posted {{ $job->created_at->diffForHumans() }}</span>
                                    <a href="{{ $job->offer_link }}" target="_blank" class="text-blue-500 hover:underline">View details</a>
                                </div>
                            </div>
                        @empty
                            <div class="p-3 text-center text-gray-500">
                                No jobs available at the moment.
                            </div>
                        @endforelse
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- <script>
        // Enable pusher logging for debugging
        Pusher.logToConsole = true;
        
        const pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
            encrypted: true
        });
        
        const channel = pusher.subscribe('jobs');
        
        channel.bind('App\\Events\\JobApplicationCreated', function(data) {
            // Get the job container element
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
                <div class="text-sm text-gray-600 my-1">${data.job.company}</div>
                <div class="flex items-center text-xs text-gray-500 mb-2">
                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    ${data.job.location}
                </div>
                <p class="text-xs text-gray-600 line-clamp-2">${data.job.description.slice(0, 100)}${data.job.description.length > 100 ? '...' : ''}</p>
                <div class="mt-2 flex justify-between items-center">
                    <span class="text-xs text-gray-500">Posted just now</span>
                    <a href="${data.job.offer_link}" target="_blank" class="text-blue-500 hover:underline">View details</a>
                </div>
            `;
            
            // Add the new job to the top of the list
            jobsContainer.prepend(jobElement);
            
            // Show notification (optional)
            showNotification('New job posted', `${data.job.title} at ${data.job.company}`);
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
    </script> --}}
    <script>
        // Enable pusher logging for debugging
        Pusher.logToConsole = true;
        
        const pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
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
</x-app-layout>
