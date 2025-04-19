@php
    use Illuminate\Support\Str;
@endphp

    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Catalogue - Bibliothèque en ligne</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            line-height: 1.6;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Merriweather', serif;
            font-weight: 700;
            color: #2d3748; /* Dark gray */
        }
        .book-card {
            transition: transform 0.2s ease-in-out;
        }
        .book-card:hover {
            transform: scale(1.03);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        .btn-primary-custom {
            background-color: #64748b; /* Slate-600 */
            color: #f9f9f9;
            transition: background-color 0.2s ease-in-out;
        }
        .btn-primary-custom:hover {
            background-color: #4a5568; /* Slate-700 */
        }
        .btn-secondary-custom {
            background-color: #cbd5e0; /* Blue-gray-300 */
            color: #2d3748;
            transition: background-color 0.2s ease-in-out;
        }
        .btn-secondary-custom:hover {
            background-color: #a0aec0; /* Blue-gray-400 */
        }
        .text-accent {
            color: #4338ca; /* Indigo-700 */
        }
        .text-muted-custom {
            color: #718096; /* Gray-500 */
        }
        .border-accent {
            border-color: #4338ca;
        }
    </style>
</head>
<body class="bg-gray-100 dark:bg-gray-900 dark:text-gray-200">
<header class="bg-white dark:bg-gray-800 shadow">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold">📚 Ma Bibliothèque</h1>
        <nav class="space-x-4">
            <a href="{{ url('/') }}" class="hover:underline">Accueil</a>
            <a href="{{ route('catalogue') }}" class="hover:underline">Catalogue</a>

            @auth
                <a href="{{ url('/dashboard') }}" class="hover:underline">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="hover:underline">Connexion</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="hover:underline">Inscription</a>
                @endif
            @endauth
        </nav>
    </div>
</header>

<main class="py-10">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-center text-indigo-700 mb-4">✨ Nos Auteurs Vedettes et Leurs Œuvres</h2>
            <p class="text-center text-gray-500 dark:text-gray-400 max-w-3xl mx-auto">
                Plongez dans l'univers littéraire de nos auteurs les plus acclamés. Chaque section met en lumière un auteur et une sélection de ses livres captivants. Découvrez de nouvelles histoires et des voix uniques.
            </p>
        </div>

        <div class="space-y-12">
            @foreach ($livresParAuteur as $auteur => $livresDeLAuteur)
                <section class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                    <div class="px-6 py-8">
                        <h3 class="text-2xl font-semibold text-indigo-700 mb-4 border-b-2 border-indigo-700 pb-2">{{ $auteur }}</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-6">
                            @foreach($livresDeLAuteur as $livre)
                                <div class="book-card bg-gray-50 dark:bg-gray-700 rounded-md shadow-md overflow-hidden">
                                    <div class="aspect-w-2 aspect-h-3">
                                        <img src="{{ asset('storage/' . $livre->image) }}" alt="{{ $livre->titre }}" class="w-full h-full object-cover rounded-t-md">
                                    </div>
                                    <div class="p-4">
                                        <h5 class="text-lg font-semibold text-gray-800 dark:text-gray-100 truncate">{{ $livre->titre }}</h5>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 truncate">✍️ {{ $auteur }}</p>
                                        <p class="text-sm text-gray-700 dark:text-gray-300 mt-2">{{ Str::limit($livre->description, 80) }}</p>
                                        <div class="mt-3 flex justify-between items-center">
                                            <a href="{{ route('livres.show', $livre->id) }}" class="text-indigo-700 hover:underline text-sm font-medium">👁 Voir</a>
                                            @auth
                                                @if(Auth::user()->role == 'gestionnaire')
                                                    <div class="flex space-x-2">
                                                        <a href="{{ route('livres.edit', $livre->id) }}" class="text-yellow-500 hover:underline text-sm">✏️ Modifier</a>
                                                        <form action="{{ route('livres.destroy', $livre->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-500 hover:underline text-sm">🗑 Supprimer</button>
                                                        </form>
                                                    </div>
                                                @endif
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            @endforeach
        </div>
    </div>
</main>

<footer class="bg-white dark:bg-gray-800 text-center py-6 shadow-inner mt-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <p class="text-sm text-gray-600 dark:text-gray-400">
            © 2025 Sunu Bibliothèque. Tous droits réservés.
        </p>
    </div>
</footer>
</body>
</html>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Optional: Initialize any JavaScript components here
    });
</script>
