<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{'linkdev'}}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
        <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
        <!-- Add this in your head section -->
<script src="https://js.pusher.com/8.0/pusher.min.js"></script>


        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
                {{-- <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}
            </main>
        </div>

        
        
        <script>
            function updateSelectedSkills() {
                let select = document.getElementById('skills');
                let selectedSkillsContainer = document.getElementById('selectedSkills');
                
                // Efface l'affichage précédent
                selectedSkillsContainer.innerHTML = '';
                
                // Ajoute les compétences sélectionnées sous forme de badges
                for (let option of select.selectedOptions) {
                    let skillBadge = document.createElement('span');
                    skillBadge.textContent = option.text;
                    skillBadge.classList.add('px-2', 'py-1', 'bg-blue-500', 'text-white', 'rounded-lg', 'text-sm');
                    selectedSkillsContainer.appendChild(skillBadge);
                }
            }
        
            // Initialiser l'affichage des compétences sélectionnées lors du chargement de la page
            document.addEventListener('DOMContentLoaded', function() {
                updateSelectedSkills();
            });
        </script>
        <script>
            // Function to toggle comment section
            function toggleCommentSection(postId) {
                const commentSection = document.getElementById(`comment-section-${postId}`);
                commentSection.classList.toggle('hidden');
            }
        </script>
        


        {{-- fonction pour like  --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
                    document.querySelectorAll('.like-button').forEach(button => {
                        const postId = button.dataset.postId;
                        checkLikeStatus(postId);
                    });
                });
                async function toggleLike(postId) {
    try {
        const response = await fetch(`/posts/${postId}/like`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        });
        
        const data = await response.json();
        console.log(data);
        if (data.success) {
            const button = document.querySelector(`.like-button[data-post-id="${postId}"]`);
            const icon = button.querySelector('.like-icon');
            const count = button.querySelector('.likes-count');
            
            // Update like count
            count.textContent = data.likesCount;
            
            // Update icon state
            if (data.isLiked) {
                icon.style.fill = 'currentColor';
            } else {
                icon.style.fill = 'none';
            }
        }
    } catch (error) {
        console.error('Error toggling like:', error);
    }
}
        async function checkLikeStatus(postId) {
            try {
                const response = await fetch(`/posts/${postId}/check-like`);
                const data = await response.json();
                
                const button = document.querySelector(`.like-button[data-post-id="${postId}"]`);
                const icon = button.querySelector('.like-icon');
                
                if (data.isLiked) {
                    icon.style.fill = 'currentColor';
                }
            } catch (error) {
                console.error('Error checking like status:', error);
            }
        }
    </script>

  {{-- fonction pour partager un post  --}}
    <script>
                    function sharePost(postId) {
                    const post = document.querySelector(`.post[data-post-id="${postId}"]`);
                    const postContent = post.querySelector('.post-content').textContent;
                    const postUrl = window.location.href + `#post-${postId}`;

                    if (navigator.share) {
                        navigator.share({
                            title: 'Check out this post!',
                            text: postContent,
                            url: postUrl
                        }).then(() => {
                            console.log('Post shared successfully');
                        }).catch((error) => {
                            console.error('Error sharing post:', error);
                        });
                    } else {
                        alert('Web Share API is not supported in your browser.');
                    }
                }
    </script>

            {{-- fonction pour recherche input --}}
        <script>
            document.getElementById('searchInput').addEventListener('keyup', function() {
                const searchValue = this.value.toLowerCase();
                const posts = document.querySelectorAll('.post'); 
                
                posts.forEach(post => {
                    const postContent = post.querySelector('.post-content').textContent.toLowerCase();
                    const userName = post.querySelector('h4').textContent.toLowerCase();
                    const hashtags = post.querySelector('p.text-blue-800')?.textContent.toLowerCase() || '';
                    
                    // Search in content, username, and hashtags
                    if (postContent.includes(searchValue) || 
                        userName.includes(searchValue) || 
                        hashtags.includes(searchValue)) {
                        post.style.display = '';
                    } else {
                        post.style.display = 'none';
                    }
                });
            });
        </script>
    </body>
</html>
