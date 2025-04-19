<nav x-data="{ open: false }" class="bg-gray-900 text-white shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-indigo-300 hover:text-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <x-application-logo class="block h-9 w-auto fill-current" />
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white hover:text-indigo-300 focus:outline-none focus:text-indigo-300 transition duration-150 ease-in-out no-underline hover:underline focus:underline">
                        {{ __('Tableau de bord') }}
                    </x-nav-link>

                    <x-nav-link :href="route('livres.index')" :active="request()->routeIs('livres.index')" class="text-white hover:text-indigo-300 focus:outline-none focus:text-indigo-300 transition duration-150 ease-in-out no-underline hover:underline focus:underline">
                        {{ __('Livres') }}
                    </x-nav-link>

                    <x-nav-link :href="route('commandes.index')" :active="request()->routeIs('commandes.index')" class="text-white hover:text-indigo-300 focus:outline-none focus:text-indigo-300 transition duration-150 ease-in-out no-underline hover:underline focus:underline">
                        {{ __('Commandes') }}
                    </x-nav-link>

                    @if(Auth::user()->role == 'gestionnaire')
                        <x-nav-link :href="route('clients.index')" :active="request()->routeIs('clients.index')" class="text-white hover:text-indigo-300 focus:outline-none focus:text-indigo-300 transition duration-150 ease-in-out no-underline hover:underline focus:underline">
                            {{ __('Clients') }}
                        </x-nav-link>
                    @endif

                    @if(Auth::user()->role == 'gestionnaire')
                        <x-nav-link :href="route('paiements.index')" :active="request()->routeIs('paiements.index')" class="text-white hover:text-indigo-300 focus:outline-none focus:text-indigo-300 transition duration-150 ease-in-out no-underline hover:underline focus:underline">
                            {{ __('Paiements') }}
                        </x-nav-link>

                        <x-nav-link :href="route('statistiques.index')" :active="request()->routeIs('statistiques.index')" class="text-white hover:text-indigo-300 focus:outline-none focus:text-indigo-300 transition duration-150 ease-in-out no-underline hover:underline focus:underline">
                            {{ __('Statistiques') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-gray-800 hover:bg-gray-700 focus:outline-none transition ease-in-out duration-150 no-underline">
                            <div class="shrink-0 mr-2">
                                @if (Auth::user()->photo)
                                    <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('storage/' . Auth::user()->photo) }}" alt="{{ Auth::user()->name }}" />
                                @else
                                    <div class="h-8 w-8 rounded-full bg-gray-600 flex items-center justify-center">
                                        <span class="text-sm font-semibold text-white">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                                    </div>
                                @endif
                            </div>
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.afficher')" class="text-gray-800 hover:bg-gray-100 no-underline hover:underline focus:underline">
                            {{ __('Profil') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-gray-800 hover:bg-gray-100 no-underline hover:underline focus:underline">
                                {{ __('Se déconnecter') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-indigo-300 hover:bg-gray-800 focus:outline-none focus:bg-gray-800 focus:text-indigo-300 transition duration-150 ease-in-out no-underline">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-gray-800">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white hover:bg-gray-700 focus:outline-none focus:text-indigo-300 no-underline hover:underline focus:underline">
                {{ __('Tableau de bord') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('livres.index')" :active="request()->routeIs('livres.index')" class="text-white hover:bg-gray-700 focus:outline-none focus:text-indigo-300 no-underline hover:underline focus:underline">
                {{ __('Livres') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('commandes.index')" :active="request()->routeIs('commandes.index')" class="text-white hover:bg-gray-700 focus:outline-none focus:text-indigo-300 no-underline hover:underline focus:underline">
                {{ __('Commandes') }}
            </x-responsive-nav-link>

            @if(Auth::user()->role == 'gestionnaire')
                <x-responsive-nav-link :href="route('clients.index')" :active="request()->routeIs('clients.index')" class="text-white hover:bg-gray-700 focus:outline-none focus:text-indigo-300 no-underline hover:underline focus:underline">
                    {{ __('Clients') }}
                </x-responsive-nav-link>
            @endif

            @if(Auth::user()->role == 'gestionnaire')
                <x-responsive-nav-link :href="route('paiements.index')" :active="request()->routeIs('paiements.index')" class="text-white hover:bg-gray-700 focus:outline-none focus:text-indigo-300 no-underline hover:underline focus:underline">
                    {{ __('Paiements') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('statistiques.index')" :active="request()->routeIs('statistiques.index')" class="text-white hover:bg-gray-700 focus:outline-none focus:text-indigo-300 no-underline hover:underline focus:underline">
                    {{ __('Statistiques') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <div class="pt-4 pb-1 border-t border-gray-700">
            <div class="px-4 flex items-center space-x-2 no-underline">
                <div class="shrink-0">
                    @if (Auth::user()->photo)
                        <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . Auth::user()->photo) }}" alt="{{ Auth::user()->name }}" />
                    @else
                        <div class="h-10 w-10 rounded-full bg-gray-600 flex items-center justify-center">
                            <span class="text-sm font-semibold text-white">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                        </div>
                    @endif
                </div>
                <div>
                    <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-300">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.afficher')" class="text-white hover:bg-gray-700 focus:outline-none focus:text-indigo-300 no-underline hover:underline focus:underline">
                    {{ __('Profil') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-white hover:bg-gray-700 focus:outline-none focus:text-indigo-300 no-underline hover:underline focus:underline">
                        {{ __('Se déconnecter') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
