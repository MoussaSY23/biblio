<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bibliothèque en ligne</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Merriweather:wght@400;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.7;
        }
        h1, h2, h3 {
            font-family: 'Merriweather', serif;
            font-weight: 700;
            color: #2d3748;
        }
        .hero {
            background-size: cover;
            background-position: center;
            color: white;
            text-align: center;
            padding: 120px 0;
        }
        .btn-primary {
            background-color: #4338ca;
            color: white;
            padding: 12px 30px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #3730a3;
        }
        .section {
            padding: 80px 0;
            text-align: center;
        }
        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 40px;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 dark:bg-gray-900 dark:text-white">

<!-- Navbar -->
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

<!-- Section Héros -->
<div class="hero bg-indigo-700 text-white">
    <div class="hero-content max-w-3xl mx-auto">
        <h1 class="hero-title text-4xl md:text-5xl font-bold mb-6">Plongez dans un Monde de Livres</h1>
        <p class="hero-subtitle text-xl mb-8">Votre destination en ligne pour découvrir des histoires captivantes et des connaissances enrichissantes.</p>
        <a href="{{ route('catalogue') }}" class="btn-primary">Explorer le Catalogue</a>
    </div>
</div>

<!-- Dernières parutions -->
<section class="section">
    <h2 class="section-title">Nos Dernières Parutions</h2>
    <div class="featured-books grid grid-cols-1 md:grid-cols-3 gap-6 max-w-6xl mx-auto">
        @if ($livres->count() > 0)
            @foreach ($livres->take(3) as $livre)
                <div class="book-card bg-white dark:bg-gray-800 rounded-lg shadow p-4 text-center">
                    @if ($livre->image)
                        <img src="{{ asset('storage/' . $livre->image) }}" alt="{{ $livre->titre }}" class="mx-auto mb-3 w-[150px] h-auto rounded">
                    @else
                        <img src="{{ asset('images/default-book.png') }}" alt="Image par défaut" class="mx-auto mb-3 w-[150px] h-auto rounded">
                    @endif
                    <h3 class="book-title text-lg font-semibold">{{ $livre->titre }}</h3>
                    <p class="book-author text-sm text-gray-500 dark:text-gray-400">{{ $livre->auteur }}</p>
                    <a href="{{ route('livres.show', $livre->id) }}" class="btn-primary mt-4 inline-block">Voir le Détail</a>
                </div>
            @endforeach
        @else
            <p class="text-gray-600 dark:text-gray-400">Aucun livre disponible pour le moment.</p>
        @endif
    </div>

    @if ($livres->count() > 3)
        <div class="text-center mt-8">
            <a href="{{ route('catalogue') }}" class="btn-primary">Voir Plus de Livres</a>
        </div>
    @endif
</section>

<!-- Pourquoi choisir -->
<section class="section bg-gray-100 dark:bg-gray-800">
    <h2 class="section-title">Pourquoi Choisir Notre Bibliothèque ?</h2>
    <div class="max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8">
        <div>
            <h3 class="font-semibold text-lg mb-2">Vaste Sélection</h3>
            <p class="text-gray-700 dark:text-gray-300">Découvrez des milliers de titres dans tous les genres imaginables.</p>
        </div>
        <div>
            <h3 class="font-semibold text-lg mb-2">Facilité d'Achat</h3>
            <p class="text-gray-700 dark:text-gray-300">Parcourez, sélectionnez et achetez vos livres préférés en quelques clics.</p>
        </div>
        <div>
            <h3 class="font-semibold text-lg mb-2">Livraison Rapide</h3>
            <p class="text-gray-700 dark:text-gray-300">Recevez vos commandes rapidement et en parfait état.</p>
        </div>
        <div>
            <h3 class="font-semibold text-lg mb-2">Support Client</h3>
            <p class="text-gray-700 dark:text-gray-300">Notre équipe est là pour vous aider à chaque étape.</p>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="mt-20 py-6 text-center text-sm text-gray-500 dark:text-gray-400">
    &copy; {{ date('Y') }} Ma Bibliothèque. Tous droits réservés. | <a href="#">Politique de Confidentialité</a> | <a href="#">Conditions d'Utilisation</a>
</footer>

</body>
</html>
