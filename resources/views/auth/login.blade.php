<x-guest-layout>
    <!-- Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-10">
        <h2 class="font-heading font-black text-5xl text-black tracking-tighter mb-2">WELCOME BACK.</h2>
        <p class="font-medium text-gray-500 text-lg">Ready to start your engine?</p>
    </div>

    <!-- Tabs -->
    <div class="mb-8 p-1 bg-gray-100 rounded-2xl flex">
        <button type="button" onclick="switchTab('google')" id="googleTab" class="w-1/2 py-3 rounded-xl font-bold text-sm transition-all duration-300 bg-white shadow-md text-black transform hover:scale-105 z-10">
            <i class="fab fa-google mr-2"></i> GOOGLE
        </button>
        <button type="button" onclick="switchTab('manual')" id="manualTab" class="w-1/2 py-3 rounded-xl font-bold text-sm text-gray-400 hover:text-black transition-all duration-300">
            <i class="fas fa-envelope mr-2"></i> EMAIL
        </button>
    </div>

    <!-- Google Panel -->
    <div id="googlePanel" class="mb-8 animate-fade-in-up">
        <a href="{{ route('google.redirect') }}" class="group relative w-full flex justify-center items-center px-6 py-4 border-2 border-black bg-white rounded-2xl font-bold text-lg text-black transition-all duration-300 hover:bg-black hover:text-white hover:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] active:translate-x-[2px] active:translate-y-[2px] active:shadow-none">
            <svg class="w-6 h-6 mr-3 transition-colors group-hover:fill-white" viewBox="0 0 24 24">
                <path fill="#000000" class="group-hover:fill-white" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                <path fill="#000000" class="group-hover:fill-white" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                <path fill="#000000" class="group-hover:fill-white" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                <path fill="#000000" class="group-hover:fill-white" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
            </svg>
            CONTINUE WITH GOOGLE
        </a>
        
        <div class="relative my-8">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t-2 border-gray-100"></div>
            </div>
            <div class="relative flex justify-center text-xs font-black tracking-widest">
                <span class="bg-white px-4 text-gray-300">OR STAFF ACCESS</span>
            </div>
        </div>
    </div>

    <!-- Manual Panel -->
    <div id="manualPanel" class="hidden mb-8 animate-fade-in-up">
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

        function switchTab(tab) {
            const googleTab = document.getElementById('googleTab');
            const manualTab = document.getElementById('manualTab');
            const googlePanel = document.getElementById('googlePanel');
            const manualPanel = document.getElementById('manualPanel');
            
            const activeClass = "w-1/2 py-3 rounded-xl font-bold text-sm transition-all duration-300 bg-white shadow-md text-black transform hover:scale-105 z-10";
            const inactiveClass = "w-1/2 py-3 rounded-xl font-bold text-sm text-gray-400 hover:text-black transition-all duration-300";

            if (tab === 'google') {
                googleTab.className = activeClass;
                manualTab.className = inactiveClass;
                googlePanel.classList.remove('hidden');
                manualPanel.classList.add('hidden');
            } else {
                manualTab.className = activeClass;
                googleTab.className = inactiveClass;
                manualPanel.classList.remove('hidden');
                googlePanel.classList.add('hidden');
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
