<x-guest-layout>
    <div class="mb-10">
        <h2 class="font-heading font-black text-5xl text-black tracking-tighter mb-2">JOIN THE CLUB.</h2>
        <p class="font-medium text-gray-500 text-lg">Create your account and start riding.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div class="group">
            <label for="name" class="block font-bold text-xs uppercase tracking-wider text-gray-500 mb-2 group-focus-within:text-black transition-colors">Full Name</label>
            <input id="name" class="block w-full px-4 py-4 bg-gray-50 border-2 border-transparent rounded-xl text-black font-bold placeholder-gray-300 focus:bg-white focus:border-black focus:ring-0 transition-all duration-300" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="e.g. Maverick Vinales" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="group">
            <label for="email" class="block font-bold text-xs uppercase tracking-wider text-gray-500 mb-2 group-focus-within:text-black transition-colors">Email Address</label>
            <input id="email" class="block w-full px-4 py-4 bg-gray-50 border-2 border-transparent rounded-xl text-black font-bold placeholder-gray-300 focus:bg-white focus:border-black focus:ring-0 transition-all duration-300" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="you@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="group">
            <label for="password" class="block font-bold text-xs uppercase tracking-wider text-gray-500 mb-2 group-focus-within:text-black transition-colors">Password</label>
            <div class="relative">
                <input id="password" class="block w-full px-4 py-4 bg-gray-50 border-2 border-transparent rounded-xl text-black font-bold placeholder-gray-300 focus:bg-white focus:border-black focus:ring-0 transition-all duration-300"
                                type="password"
                                name="password"
                                required autocomplete="new-password" placeholder="••••••••" />
                <button type="button" onclick="togglePasswordVisibility('password')" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-black transition-colors">
                    <i class="far fa-eye text-lg"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="group">
            <label for="password_confirmation" class="block font-bold text-xs uppercase tracking-wider text-gray-500 mb-2 group-focus-within:text-black transition-colors">Confirm Password</label>
            <div class="relative">
                <input id="password_confirmation" class="block w-full px-4 py-4 bg-gray-50 border-2 border-transparent rounded-xl text-black font-bold placeholder-gray-300 focus:bg-white focus:border-black focus:ring-0 transition-all duration-300"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
                <button type="button" onclick="togglePasswordVisibility('password_confirmation')" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-black transition-colors">
                    <i class="far fa-eye text-lg"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="pt-4">
            <button class="w-full py-4 bg-black text-white font-black text-lg tracking-widest uppercase rounded-xl hover:bg-gray-900 hover:shadow-[0px_10px_20px_rgba(0,0,0,0.2)] hover:-translate-y-1 transition-all duration-300 active:translate-y-0 active:shadow-none">
                REGISTER ACCOUNT
            </button>
        </div>

        <div class="text-center mt-6">
            <p class="text-sm font-medium text-gray-500">
                Already have an account? 
                <a href="{{ route('login') }}" class="font-black text-black underline decoration-2 underline-offset-4 hover:decoration-indigo-500 transition-all">
                    LOGIN HERE
                </a>
            </p>
        </div>
    </form>

    <script>
        function togglePasswordVisibility(id) {
            const input = document.getElementById(id);
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    </script>
</x-guest-layout>
