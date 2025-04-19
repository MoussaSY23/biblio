@extends('layouts.app')

@section('content')
    <div class="py-12 bg-gray-100 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <h1 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">{{ __('Modifier le Profil') }}</h1>

                    <form method="POST" action="{{ route('profile3.mettreAjour') }}" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Nom') }}</label>
                            <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500" />
                            @error('name')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="prenom" class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Prénom') }}</label>
                            <input id="prenom" type="text" name="prenom" value="{{ old('prenom', $user->prenom) }}" required class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500" />
                            @error('prenom')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Email') }}</label>
                            <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="username" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500" />
                            @error('email')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="telephone" class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Téléphone') }}</label>
                            <input id="telephone" type="text" name="telephone" value="{{ old('telephone', $user->telephone) }}" required class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500" />
                            @error('telephone')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="adresse" class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Adresse') }}</label>
                            <input id="adresse" type="text" name="adresse" value="{{ old('adresse', $user->adresse) }}" required class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500" />
                            @error('adresse')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="photo" class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Photo de Profil (Optionnel)') }}</label>
                            <input id="photo" type="file" name="photo" accept="image/*" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500" />
                            @error('photo')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                            @if ($user->photo)
                                <img src="{{ asset('storage/' . $user->photo) }}" alt="Photo de profil actuelle" class="mt-2 rounded-full h-16 w-16 object-cover">
                            @endif
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-500 dark:bg-blue-700 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-100 uppercase tracking-widest hover:bg-blue-700 dark:hover:bg-blue-500 focus:bg-blue-700 dark:focus:bg-blue-500 active:bg-blue-900 dark:active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                {{ __('Enregistrer') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
