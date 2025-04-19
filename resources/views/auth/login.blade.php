<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-cover bg-center px-4 py-8"
         style="background-image: url('{{ asset('storage/images/Voitures-Fond-decran-dordinateur-portable.png') }}');">
        <div class="w-full max-w-md bg-white bg-opacity-30 backdrop-blur-md shadow-xl rounded-xl border border-gray-300/30 p-8 text-white">

            <div class="text-center mb-6">
                <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-auto text-indigo-300">
                    <path d="M32 4L56 18V46L32 60L8 46V18L32 4Z" fill="currentColor" opacity="0.5"/>
                    <path d="M32 8L52 20V44L32 56L12 44V20L32 8Z" fill="currentColor" opacity="0.3"/>
                    <path d="M32 12L48 22V42L32 52L16 42V22L32 12Z" fill="currentColor" opacity="0.2"/>
                    <path d="M32 16L44 24V40L32 48L20 40V24L32 16Z" fill="white" opacity="0.1"/>
                </svg>
                <h1 class="text-2xl font-bold mt-2 text-white">Bienvenue</h1>
                <p class="text-sm text-indigo-200 italic mt-1">Votre espace de lecture personnalisé</p>
            </div>

            <x-auth-session-status class="mb-4 text-green-300" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="block mb-1 text-indigo-100 text-sm font-medium">Adresse e-mail</label>
                    <x-text-input id="email" type="email" name="email"
                                  class="block w-full rounded-md p-3 bg-white/20 border-indigo-100 text-white shadow-sm focus:ring-2 focus:ring-indigo-300"
                                  placeholder="votre@email.com"
                                  :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-red-400 text-sm" />
                </div>

                <div>
                    <label for="password" class="block mb-1 text-indigo-100 text-sm font-medium">Mot de passe</label>
                    <x-text-input id="password" type="password" name="password"
                                  class="block w-full rounded-md p-3 bg-white/20 border-indigo-100 text-white shadow-sm focus:ring-2 focus:ring-indigo-300"
                                  placeholder="Votre mot de passe"
                                  required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-1 text-red-400 text-sm" />
                </div>

                <div class="flex items-center justify-between text-sm text-gray-300">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="mr-2 rounded border-gray-400 text-indigo-300 focus:ring-indigo-300">
                        Se souvenir de moi
                    </label>
                    @if (Route::has('password.request'))
                        <a class="text-indigo-200 hover:underline" href="{{ route('password.request') }}">
                            Mot de passe oublié ?
                        </a>
                    @endif
                </div>

                <div>
                    <x-primary-button class="w-full bg-indigo-400 hover:bg-indigo-500 text-white font-semibold py-3 rounded-md transition-all focus:ring-2 focus:ring-indigo-300">
                        Se connecter
                    </x-primary-button>
                </div>
            </form>

            <div class="text-center mt-6 text-sm text-gray-300">
                Pas encore de compte ?
                <a href="{{ route('register') }}" class="text-indigo-200 underline hover:text-indigo-300">Créer un compte</a>
            </div>

        </div>
    </div>
</x-guest-layout>
