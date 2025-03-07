<x-app-layout>
  
    <div class="mt-10 mr-20 ml-20 bg-white shadow-lg rounded-lg overflow-hidden">
        <!-- Cover Photo -->
        
        <div class="relative h-48 bg-gray-300">
            <img class="w-full h-full object-cover" src="{{ asset('storage/' . $user->cover) }}" alt="Cover Photo">
            
        </div>


        
        <!-- Profile Info -->
        <div class="p-8">
            <div class="flex items-center">
                <img class="w-16 h-16 rounded-full border-4 border-white -mt-12" src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture">
                <div class="ml-4">
                    <h2 class="text-2xl font-bold">{{ $user->name }}</h2>
                    <p class="text-gray-600">{{ $user->bio }}</p>
                </div>
            </div>
        </div>
        
        <!-- Contact & Links -->
        <div class="p-6 border-t">
            <p><a href="#" class="hover:font-bold"> <i class="fas fa-envelope text-yellow-600 mr-2 "></i>{{ $user->email }}</a></p>
            @if($user->website)
                <p><a href="{{ $user->website }}" class="hover:font-bold"> <i class="fas fa-globe-africa text-blue-500 mr-2"></i>Website</a></p>
            @endif
            @if($user->github_url)
                <p><a href="{{ $user->github_url }}" class="hover:font-bold"><i class="fab fa-github mr-2"></i>GitHub</a></p>
            @endif
            @if($user->linkedin_url)
                <p><a href="{{ $user->linkedin_url }}" class="hover:font-bold"> <i class="fab fa-linkedin mr-2 text-blue-500"></i>LinkedIn</a></p>
            @endif
        </div>
    </div>
    <div class="mt-2 mb-2 mr-20 ml-20 bg-white shadow-lg rounded-lg overflow-hidden">
        <!-- Skills Section -->
        <div class="p-6">
            <h3 class="text-xl font-bold mb-4">Skills</h3>
            <div class="flex flex-wrap">
                @foreach($user->skills as $skill)
                    <span class="bg-blue-100 text-blue-800 text-sm font-semibold mr-2 mb-2 px-4 py-2 rounded-full">{{ $skill->name }}</span>
                @endforeach
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
                        <a href="{{ route('projects.create') }}" class=" text-green-500 rounded-lg hover:text-green-600 font-bold">Add Project</a>
                        <div class="mt-2">
                            @foreach($projects as $project)
                                <div class="mb-4">
                                    <h4 class="text-lg font-semibold">{{ $project->title }}</h4>
                                    <p>{{ $project->description }}</p>
                                    <a href="{{ $project->repo_link }}" target="_blank" class="text-blue-500">Repository Link</a>
                                </div>
                                <form action="{{ route('projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this certification?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"><i class="fas fa-trash-alt text-red-500"></i></button>
                                </form>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        
            <div class="w-1/3 bg-white p-4">
                @foreach ($users as $user)
                    <div class="p-4 border-b flex items-center">
                        <img class="w-12 h-12 rounded-full" src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture">
                        <div class="ml-4">
                            <h4 class="text-lg font-semibold">{{ $user->name }}</h4>
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
                            </button>
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
                @endforeach
            </div>
        </div>

        
    </div>
    <div class="mt-2 mb-2 mr-20 ml-20 bg-white shadow-lg rounded-lg overflow-hidden">
        <!-- certifications Section -->
        <div class="mt-2 mb-2 bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="p-6">
                <h3 class="text-xl font-bold mb-1"> Your Certifications <span></span></h3>
                <a href="{{ route('certifications.create') }}" class=" text-green-500 rounded-lg hover:text-green-600 font-bold">Add Certifications</a>
                <div class="mt-2">
                    @foreach($certifications as $certification)
                        <div class="mb-4">
                            <h4 class="text-lg font-semibold">{{ $certification->title }}</h4>
                            <p class="text-gray-500 text-xs">{{$certification->certification_date}}</p>
                            <p>{{ $certification->description }}</p>
                            <a href="{{ $certification->certification_link }}" target="_blank" class="text-blue-500">Certification Link</a>
                        </div>
                        <form action="{{ route('certifications.destroy', $certification->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this certification?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"><i class="fas fa-trash-alt text-red-500"></i></button>
                        </form>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="mt-2 mb-2 mr-20 ml-20 bg-white shadow-lg rounded-lg overflow-hidden">
        <!-- Jobs Section -->
        <div class="mt-2 mb-2 bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="p-6">
                <h3 class="text-xl font-bold mb-1">Your Jobs <span></span></h3>
                <a href="{{ route('Job_offers.create') }}" class=" text-green-500 rounded-lg hover:text-green-600 font-bold">Add Jobs</a>
                <div class="mt-2">
                    @foreach($job_offers as $job)
                        <div class="mb-4">
                            <h4 class="text-lg font-semibold">{{ $job->title }}</h4>
                        <p class="text-gray-600">{{ $job->company_name }}</p>
                        <p class="text-gray-500 text-xs">{{ $job->contract_type }} | {{ $job->location }}</p>
                        {{-- <p class="text-gray-500 text-xs">Posted: {{ $job->date_published->format('Y-m-d') }}</p>  --}}
                        <p class="text-gray-500 text-xs">Posted: {{ \Carbon\Carbon::parse($job->date_published)->format('Y-m-d') }}</p> 
                        <p class="mt-2">{{ $job->description }}</p>
                        @if($job->offer_link)
                            <a href="{{ $job->offer_link }}" target="_blank" class="text-blue-500 hover:underline">View details</a>
                        @endif
                        </div>
                        <div class="flex gap-3 ml-2">
                            <form action="{{ route('Job_offers.destroy', $job->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this offer?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"><i class="fas fa-trash-alt text-red-500"></i></button>
                            </form>
                            <form action="{{ route('Job_offers.edit', $job->id) }}" method="GET">
                                @csrf
                                <button type="submit"><i class="fas fa-pen text-orange-500"></i></button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    
    <div class="mt-2 mb-2 mr-20 ml-20 bg-white shadow-lg rounded-lg overflow-hidden">
        <!--posts Section -->
        <div class="mt-4 mb-4 bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="p-6">
                <h3 class="text-xl font-bold mb-4">Your Posts</h3>
                <a href="{{ route('posts.create') }}" class="text-green-500 hover:text-green-600 font-bold">➕ Ajouter un Post</a>
                
                <div class="mt-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($posts as $post)
                        <div class="bg-white p-4 rounded-lg shadow-md flex flex-col justify-between">
                            <!-- Header du post -->
                            <div>
                                <div class="flex items-center mb-2">
                                    <img src="{{ asset('storage/' . $post->user->profile_picture) }}" alt="Avatar" class="w-10 h-10 rounded-full mr-3">
                                    <div>
                                        <h4 class="text-lg font-semibold">{{ $post->user->name }}</h4>
                                        <p class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                
                                <!-- Contenu du post -->
                                <p class="text-gray-800">{{ $post->content }}</p>
                                <p class="text-blue-800 text-sm">
                                    @foreach($post->hashtags as $hashtag)
                                        {{ $hashtag->name }}
                                    @endforeach
                                </p>
                                
                                @if($post->image)
                                    <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="w-80 h-auto mt-2 rounded-lg">
                                @endif
                            </div>
        
                            <!-- Boutons d'interaction -->
                            <div class="flex items-center justify-center gap-6 mt-3 text-gray-600">

                                <a href="{{route('posts.edit',$post->id) }}" class="flex items-center hover:text-orange-500">
                                    <i class="fas fa-pen text-orange-500 mr-1"></i> Edit
                                </a>
                                
                                <!-- Bouton de suppression -->
                                <form method="POST" action="{{ route('posts.destroy', $post->id) }}" onsubmit="return confirm('Voulez-vous vraiment supprimer ce post ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="flex items-center hover:text-red-600">
                                        <i class="far fa-minus-square text-red-500 mr-1"></i> Supprimer
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
   
     

</x-app-layout>