<x-guest-layout>
    <!-- Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-10">
        <h2 class="font-heading font-black text-5xl text-black tracking-tighter mb-2">WELCOME BACK.</h2>
        <p class="font-medium text-gray-500 text-lg">Ready to start your engine?</p>
    </div>

    <!-- Email Login Panel -->

    <div id="manualPanel" class="mb-8 animate-fade-in-up">
        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <!-- Email -->
            <div class="group">
                <label for="customer_email" class="block font-bold text-xs uppercase tracking-wider text-gray-500 mb-2 group-focus-within:text-black transition-colors">Email Address</label>
                <input id="customer_email" class="block w-full px-4 py-4 bg-gray-50 border-2 border-transparent rounded-xl text-black font-bold placeholder-gray-300 focus:bg-white focus:border-black focus:ring-0 transition-all duration-300" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="you@example.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="group">
                <div class="flex justify-between items-center mb-2">
                    <label for="customer_password" class="block font-bold text-xs uppercase tracking-wider text-gray-500 group-focus-within:text-black transition-colors">Password</label>
                    @if (Route::has('password.request'))
                        <a class="text-xs font-bold text-indigo-600 hover:underline" href="{{ route('password.request') }}">FORGOT?</a>
                    @endif
                </div>
                <div class="relative">
                    <input id="customer_password" class="block w-full px-4 py-4 bg-gray-50 border-2 border-transparent rounded-xl text-black font-bold placeholder-gray-300 focus:bg-white focus:border-black focus:ring-0 transition-all duration-300"
                                    type="password"
                                    name="password"
                                    required autocomplete="current-password" placeholder="••••••••" />
                    <button type="button" onclick="togglePasswordVisibility('customer_password')" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-black transition-colors">
                        <i class="far fa-eye text-lg"></i>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember -->
            <div class="flex items-center mb-4">
                <input id="customer_remember" type="checkbox" class="w-5 h-5 rounded border-2 border-gray-300 text-black focus:ring-black transition-colors" name="remember">
                <label for="customer_remember" class="ms-3 text-sm font-bold text-gray-600">Keep me logged in</label>
            </div>

            <button class="w-full py-4 bg-black text-white font-black text-lg tracking-widest uppercase rounded-xl hover:bg-gray-900 hover:shadow-[0px_10px_20px_rgba(0,0,0,0.2)] hover:-translate-y-1 transition-all duration-300 active:translate-y-0 active:shadow-none">
                LOGIN NOW
            </button>
        </form>
    </div>

    <!-- Staff Toggle -->
    <div class="pt-6 border-t border-dashed border-gray-200">
        <button onclick="toggleAdminLogin()" class="w-full flex justify-between items-center py-3 px-4 rounded-xl hover:bg-gray-50 transition-colors group">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 group-hover:bg-black group-hover:text-white transition-all duration-300">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <div class="text-left">
                    <p class="font-bold text-sm text-gray-900">Staff Access</p>
                    <p class="text-xs text-gray-500">Admin & Managers only</p>
                </div>
            </div>
            <i class="fas fa-chevron-right text-gray-300 group-hover:translate-x-1 transition-transform duration-300" id="adminToggleIcon"></i>
        </button>

        <!-- Hidden Admin Form -->
        <div id="adminLoginForm" class="hidden mt-4 bg-gray-50 p-6 rounded-2xl border border-gray-200 animate-fade-in-down">
            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block font-bold text-xs uppercase mb-1">Staff Email</label>
                    <input class="w-full p-3 rounded-lg border border-gray-300 focus:border-black focus:ring-0" type="email" name="email" placeholder="admin@secondcycle.id" required />
                </div>
                <div>
                    <label class="block font-bold text-xs uppercase mb-1">Password</label>
                    <input class="w-full p-3 rounded-lg border border-gray-300 focus:border-black focus:ring-0" type="password" name="password" required />
                </div>
                <button class="w-full py-3 bg-gray-900 text-white font-bold rounded-lg hover:bg-black">AUTHENTICATE</button>
            </form>
        </div>
    </div>

    <!-- Register Link -->
    @if (Route::has('register'))
        <div class="text-center mt-8">
            <p class="text-sm font-medium text-gray-500">
                New to SecondCycle? 
                <a href="{{ route('register') }}" class="font-black text-black underline decoration-2 underline-offset-4 hover:decoration-indigo-500 transition-all">
                    CREATE ACCOUNT
                </a>
            </p>
        </div>
    @endif

    <script>
        function toggleAdminLogin() {
            const form = document.getElementById('adminLoginForm');
            const icon = document.getElementById('adminToggleIcon');
            
            if (form.classList.contains('hidden')) {
                form.classList.remove('hidden');
                icon.classList.add('rotate-90');
                setTimeout(() => form.scrollIntoView({ behavior: 'smooth', block: 'nearest' }), 100);
            } else {
                form.classList.add('hidden');
                icon.classList.remove('rotate-90');
            }
        }

        function togglePasswordVisibility(id) {
            const input = document.getElementById(id);
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    </script>

    <style>
        .animate-fade-in-up { animation: fadeInUp 0.4s cubic-bezier(0.16, 1, 0.3, 1); }
        .animate-fade-in-down { animation: fadeInDown 0.4s cubic-bezier(0.16, 1, 0.3, 1); }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeInDown { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</x-guest-layout>
