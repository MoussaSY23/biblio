@extends('layouts.app')

@section('content')
    <div class="py-5 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                    {{ __('Tableau de Bord') }}
                </h2>
                <h1 class="text-2xl font-semibold text-indigo-600 mb-2">
                    Bienvenue, Mr/Mme {{ Auth::user()->prenom }} {{ Auth::user()->nom }} ! 👋
                </h1>
                <p class="text-gray-600 mb-6">
                    Explorez les dernières nouveautés et découvrez les fonctionnalités de votre tableau de bord.
                </p>

                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">📚 Nouveautés et Livres Populaires</h3>
                    <div class="overflow-x-auto">
                        <div class="inline-flex space-x-4">
                            @foreach($livres as $livre)
                                <div class="min-w-[200px] border rounded-md p-3 shadow-sm">
                                    <img src="{{ asset('storage/' . $livre->image) }}" alt="{{ $livre->titre }}" class="w-full h-32 object-cover rounded-md mb-2">
                                    <h4 class="text-sm font-semibold text-gray-700 truncate">{{ $livre->titre }}</h4>
                                    <p class="text-xs text-gray-500 truncate">✍️ {{ $livre->auteur }}</p>
                                    <p class="text-sm font-semibold text-green-600">{{ $livre->prix }} €</p>
                                    <a href="{{ route('livres.show', $livre) }}" class="inline-block mt-2 text-indigo-500 hover:text-indigo-700 text-xs">Voir le détail</a>
                                </div>
                            @endforeach
                            @if(count($livres) < 3)
                                @for ($i = 0; $i < (3 - count($livres)); $i++)
                                    <div class="min-w-[200px] border rounded-md p-3 shadow-sm">
                                        <img src="{{ asset('storage/images/placeholder-book.png') }}" alt="Livre Placeholder {{ $i + 1 }}" class="w-full h-32 object-cover rounded-md mb-2">
                                        <h4 class="text-sm font-semibold text-gray-700 truncate">Titre Placeholder {{ $i + 1 }}</h4>
                                        <p class="text-xs text-gray-500 truncate">✍️ Auteur Placeholder</p>
                                        <p class="text-sm font-semibold text-green-600">-- €</p>
                                        <a href="#" class="inline-block mt-2 text-indigo-500 hover:text-indigo-700 text-xs">Voir le détail</a>
                                    </div>
                                @endfor
                            @endif
                        </div>
                    </div>
                    <p class="mt-2 text-sm text-gray-500">
                        <a href="{{ route('livres.index') }}" class="text-indigo-500 hover:text-indigo-700">Découvrir tous les livres <svg class="w-4 h-4 inline-block ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg></a>
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <div class="flex items-center">
                                <div class="mr-4">
                                    <svg class="w-8 h-8 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.523 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5S19.832 5.477 21 6.253v13c-1.168-.777-2.754-1.253-4.5-1.253s-3.332.477-4.5 1.253V6.253z"></path></svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Derniers Arrivages</h3>
                                    <p class="text-sm text-gray-500">Ne manquez pas les nouveaux titres ajoutés à notre collection.</p>
                                    <a href="{{ route('livres.index') }}" class="inline-flex items-center mt-2 text-indigo-500 hover:text-indigo-700">
                                        Voir les nouveautés
                                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <div class="flex items-center">
                                <div class="mr-4">
                                    <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Vos Commandes</h3>
                                    <p class="text-sm text-gray-500">Suivez l'état de vos commandes et consultez votre historique.</p>
                                    <a href="{{ route('commandes.index') }}" class="inline-flex items-center mt-2 text-green-500 hover:text-green-700">
                                        Voir vos commandes
                                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(Auth::user()->role == 'gestionnaire')
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-gray-900">
                                <div class="flex items-center">
                                    <div class="mr-4">
                                        <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-2m3-4v-2M5 16.5c0-.828-.567-1.5-1.268-1.5S3.732 15.672 3.732 16.5m16.5-2c0 .828.567 1.5 1.268 1.5s1.268-.672 1.268-1.5m-16-2a5.005 5.005 0 019.8-4.5M7 16.5v-2m-3 4v-2M10 14.5a5.005 5.005 0 01-9.8 4.5M17 14.5v-2m3 4v-2M9 10.5a3.005 3.005 0 015.8-2.5M12 12h.01M15 10.5a3.005 3.005 0 01-5.8 2.5M16.5 6.5c0-.827-.567-1.5-1.268-1.5S13.732 5.673 13.732 6.5m-13 0C0 7.327.567 8 1.268 8s1.268-.673 1.268-1.5m16 0c0 .827-.567 1.5-1.268 1.5s-1.268-.673-1.268-1.5M3 8v10.5a3 3 0 003 3h12a3 3 0 003-3V8m-16 0h18m-12.317 3.17A5.002 5.002 0 0112 9c0-.69.118-1.354.317-2.005m-5.58 9.83A5.002 5.002 0 017 15c0 .69-.118 1.354-.317 2.005m9.16-6.83A3.003 3.003 0 0115 12c0 .382.063.75.166 1.107M7.082 9.107A3.003 3.003 0 019 12c0-.382-.063-.75-.166-1.107m0 5.786A3.003 3.003 0 017 15c0 .382.063.75.166 1.107m5.58-9.83A5.002 5.002 0 0117 9c0 .69.118 1.354.317 2.005"></svg>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">Statistiques Rapides</h3>
                                        <p class="text-sm text-gray-500">Aperçu des commandes récentes et des informations clés.</p>
                                        <a href="{{ route('statistiques.index') }}" class="inline-flex items-center mt-2 text-yellow-500 hover:text-yellow-700">
                                            Voir les statistiques
                                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
