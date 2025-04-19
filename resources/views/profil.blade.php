@extends('layouts.app')

@section('content')
    <div class="bg-gradient-to-br from-blue-100 to-blue-200 dark:bg-gradient-to-br dark:from-blue-900 dark:to-blue-800 py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow overflow-hidden rounded-lg">
                <div class="px-4 py-5 sm:px-6 flex items-center space-x-8">
                    {{-- Grande Photo de Profil à Gauche --}}
                    <div class="shrink-0">
                        @if (Auth::user()->photo)
                            <img class="h-24 w-24 rounded-full object-cover shadow-md border-2 border-blue-300 dark:border-blue-600" src="{{ asset('storage/' . Auth::user()->photo) }}" alt="{{ Auth::user()->name }}" />
                        @else
                            <div class="h-24 w-24 rounded-full bg-blue-500 dark:bg-blue-600 flex items-center justify-center shadow-md">
                                <span class="text-3xl font-semibold text-white">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                            </div>
                        @endif
                    </div>
                    {{-- Informations Utilisateur --}}
                    <div>
                        <h3 class="text-xl leading-6 font-medium text-gray-900 dark:text-gray-100">
                            {{ Auth::user()->prenom }} {{ Auth::user()->name }}
                        </h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            {{ __('Informations du compte') }}
                        </p>
                    </div>
                </div>
                <div class="border-t border-gray-200 dark:border-gray-700">
                    <dl class="divide-y divide-gray-200 dark:divide-gray-700">
                        <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                {{ __('Email') }}
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">
                                {{ Auth::user()->email }}
                            </dd>
                        </div>
                        <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                {{ __('Rôle') }}
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2 capitalize">
                                {{ Auth::user()->role }}
                            </dd>
                        </div>
                        <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                {{ __('Téléphone') }}
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">
                                {{ Auth::user()->telephone }}
                            </dd>
                        </div>
                        <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                {{ __('Adresse') }}
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">
                                {{ Auth::user()->adresse }}
                            </dd>
                        </div>
                        <div class="px-4 py-5 sm:px-6 flex justify-end">
                            <a href="{{ route('profile2.modifier') }}" class="inline-flex items-center px-4 py-2 bg-blue-500 dark:bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest shadow-sm hover:bg-blue-700 dark:hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Modifier le Profil') }}
                            </a>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
@endsection
