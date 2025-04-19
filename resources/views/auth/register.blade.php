<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-cover bg-center px-4 py-8"
         style="background-image: url('{{ asset('storage/images/a489ff86c6cc2b817e36759eec53ca23.jpg') }}');">
        <div class="w-full max-w-md bg-white bg-opacity-30 backdrop-blur-lg shadow-xl rounded-lg border border-white/20 p-6 text-white">

            <div class="text-center mb-6">
                <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="mx-auto h-10 w-auto text-green-300">
                    <path d="M24 6L42 16V38L24 48L6 38V16L24 6Z" fill="currentColor" opacity="0.6"/>
                    <path d="M24 10L38 18V36L24 44L10 36V18L24 10Z" fill="currentColor" opacity="0.4"/>
                    <path d="M24 14L34 20V34L24 40L14 34V20L24 14Z" fill="white" opacity="0.3"/>
                </svg>
                <h1 class="text-2xl font-bold mt-2 drop-shadow-md">Inscription</h1>
                <p class="text-sm text-green-200 italic mt-1">Rejoignez notre communauté littéraire</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-3">
                @csrf

                <div>
                    <label for="photo" class="block mb-1 text-white text-xs font-medium">Photo (facultatif)</label>
                    <input id="photo" type="file" name="photo" class="w-full p-2 bg-white/10 rounded-md shadow-sm text-white placeholder-gray-300 focus:ring-2 focus:ring-green-300 text-xs" accept="image/*">
                    <x-input-error :messages="$errors->get('photo')" class="mt-1 text-red-400 text-xs" />
                </div>

                <div>
                    <label for="name" class="block mb-1 text-white text-xs font-medium">Nom</label>
                    <x-text-input id="name" type="text" name="name" class="w-full p-2 bg-white/10 rounded-md shadow-sm text-white placeholder-gray-300 focus:ring-2 focus:ring-green-300" placeholder="Votre nom" :value="old('name')" required autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-1 text-red-400 text-xs" />
                </div>

                <div>
                    <label for="prenom" class="block mb-1 text-white text-xs font-medium">Prénom</label>
                    <x-text-input id="prenom" type="text" name="prenom" class="w-full p-2 bg-white/10 rounded-md shadow-sm text-white placeholder-gray-300 focus:ring-2 focus:ring-green-300" placeholder="Votre prénom" :value="old('prenom')" required />
                    <x-input-error :messages="$errors->get('prenom')" class="mt-1 text-red-400 text-xs" />
                </div>

                <div>
                    <label for="email" class="block mb-1 text-white text-xs font-medium">Adresse e-mail</label>
                    <x-text-input id="email" type="email" name="email" class="w-full p-2 bg-white/10 rounded-md shadow-sm text-white placeholder-gray-300 focus:ring-2 focus:ring-green-300" placeholder="votre@email.com" :value="old('email')" required />
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-red-400 text-xs" />
                </div>

                <div>
                    <label for="password" class="block mb-1 text-white text-xs font-medium">Mot de passe</label>
                    <x-text-input id="password" type="password" name="password" class="w-full p-2 bg-white/10 rounded-md shadow-sm text-white placeholder-gray-300 focus:ring-2 focus:ring-green-300" placeholder="Mot de passe" required />
                    <x-input-error :messages="$errors->get('password')" class="mt-1 text-red-400 text-xs" />
                </div>

                <div>
                    <label for="password_confirmation" class="block mb-1 text-white text-xs font-medium">Confirmer le mot de passe</label>
                    <x-text-input id="password_confirmation" type="password" name="password_confirmation" class="w-full p-2 bg-white/10 rounded-md shadow-sm text-white placeholder-gray-300 focus:ring-2 focus:ring-green-300" placeholder="Confirmer le mot de passe" required />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-red-400 text-xs" />
                </div>

                <div>
                    <x-primary-button class="w-full bg-green-400 hover:bg-green-500 text-gray-900 font-semibold py-2 rounded-md transition-all focus:ring-2 focus:ring-green-300">
                        S'inscrire
                    </x-primary-button>
                </div>

                <div class="text-center mt-3 text-xs text-white">
                    Déjà un compte ?
                    <a href="{{ route('login') }}" class="text-green-200 underline hover:text-green-300">Se connecter</a>
                </div>
            </form>

        </div>
    </div>
</x-guest-layout>
