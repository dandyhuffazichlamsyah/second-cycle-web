<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SecondCycle') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
        
        <!-- Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            heading: ['Montserrat', 'sans-serif'],
                            body: ['Poppins', 'sans-serif'],
                        }
                    }
                }
            }
        </script>

        <style>
            .font-heading { font-family: 'Montserrat', sans-serif; }
            .font-body { font-family: 'Poppins', sans-serif; }
            
            .animate-blob {
                animation: blob 7s infinite;
            }
            .animation-delay-2000 {
                animation-delay: 2s;
            }
            .animation-delay-4000 {
                animation-delay: 4s;
            }
            @keyframes blob {
                0% { transform: translate(0px, 0px) scale(1); }
                33% { transform: translate(30px, -50px) scale(1.1); }
                66% { transform: translate(-20px, 20px) scale(0.9); }
                100% { transform: translate(0px, 0px) scale(1); }
            }
            
            /* Custom Scrollbar */
            ::-webkit-scrollbar {
                width: 8px;
            }
            ::-webkit-scrollbar-track {
                background: #f1f1f1; 
            }
            ::-webkit-scrollbar-thumb {
                background: #cbd5e0; 
                border-radius: 4px;
            }
            ::-webkit-scrollbar-thumb:hover {
                background: #a0aec0; 
            }
        </style>
    </head>
    <body class="font-body text-gray-900 antialiased bg-white overflow-x-hidden">
        <div class="min-h-screen w-full flex flex-col lg:flex-row">
            
            <!-- Left Side: Visual Experience (Desktop) -->
            <div class="hidden lg:flex lg:w-[55%] relative bg-black text-white overflow-hidden flex-col justify-between p-12">
                <!-- Dynamic Background -->
                <div class="absolute inset-0 z-0">
                    <img src="{{ asset('images/hero-motor.png') }}" class="object-cover w-full h-full opacity-50 grayscale mix-blend-overlay hover:scale-105 transition-transform duration-[20s]" alt="Background">
                    <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-black/40"></div>
                </div>

                <!-- Floating Shapes -->
                <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-indigo-600 rounded-full mix-blend-screen filter blur-3xl opacity-30 animate-blob z-0"></div>
                <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-fuchsia-600 rounded-full mix-blend-screen filter blur-3xl opacity-30 animate-blob animation-delay-2000 z-0"></div>

                <!-- Brand Top -->
                <div class="relative z-10">
                    <a href="/" class="inline-flex items-center gap-3 group">
                        <div class="bg-white text-black p-2 rounded-lg group-hover:rotate-12 transition-transform duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <span class="font-heading font-black text-2xl tracking-tighter uppercase group-hover:tracking-widest transition-all duration-300">SecondCycle</span>
                    </a>
                </div>

                <!-- Main Message -->
                <div class="relative z-10 my-auto">
                    <h1 class="font-heading font-black text-7xl leading-[0.9] tracking-tighter mb-6">
                        RIDE<br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-fuchsia-400">THE FUTURE</span><br>
                        TODAY.
                    </h1>
                    <p class="text-xl font-light text-gray-300 max-w-md border-l-4 border-indigo-500 pl-6 py-2">
                        Platform jual beli motor bekas paling hype se-Indonesia. Aman, Cepat, dan Transparan.
                    </p>
                </div>

                <!-- Footer Info -->
                <div class="relative z-10 flex justify-between items-end border-t border-white/10 pt-8">
                    <div>
                        <p class="text-sm font-bold text-indigo-400 mb-1">TRUSTED BY</p>
                        <div class="flex -space-x-3">
                            <img class="w-10 h-10 rounded-full border-2 border-black" src="https://ui-avatars.com/api/?name=A&background=random" alt="">
                            <img class="w-10 h-10 rounded-full border-2 border-black" src="https://ui-avatars.com/api/?name=B&background=random" alt="">
                            <img class="w-10 h-10 rounded-full border-2 border-black" src="https://ui-avatars.com/api/?name=C&background=random" alt="">
                            <div class="w-10 h-10 rounded-full border-2 border-black bg-white text-black flex items-center justify-center text-xs font-bold">+2k</div>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-6xl font-heading font-black text-white/10">2024</p>
                    </div>
                </div>
            </div>

            <!-- Right Side: Content (Form) -->
            <div class="w-full lg:w-[45%] flex flex-col justify-center items-center p-6 lg:p-12 bg-white relative">
                <!-- Mobile Brand -->
                <div class="lg:hidden w-full mb-8 flex justify-between items-center">
                    <a href="/" class="font-heading font-black text-2xl tracking-tighter uppercase">SecondCycle</a>
                    <a href="/" class="text-sm font-bold underline decoration-2 underline-offset-4">Back to Home</a>
                </div>

                <div class="w-full max-w-md relative z-10">
                    {{ $slot }}
                </div>

                <!-- Decoration -->
                <div class="absolute bottom-0 right-0 p-12 hidden lg:block opacity-50 pointer-events-none">
                     <svg width="100" height="100" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="2" cy="2" r="2" fill="#E5E7EB"/>
                        <circle cx="26" cy="2" r="2" fill="#E5E7EB"/>
                        <circle cx="50" cy="2" r="2" fill="#E5E7EB"/>
                        <circle cx="74" cy="2" r="2" fill="#E5E7EB"/>
                        <circle cx="98" cy="2" r="2" fill="#E5E7EB"/>
                        <circle cx="2" cy="26" r="2" fill="#E5E7EB"/>
                        <circle cx="26" cy="26" r="2" fill="#E5E7EB"/>
                        <circle cx="50" cy="26" r="2" fill="#E5E7EB"/>
                        <circle cx="74" cy="26" r="2" fill="#E5E7EB"/>
                        <circle cx="98" cy="26" r="2" fill="#E5E7EB"/>
                        <circle cx="2" cy="50" r="2" fill="#E5E7EB"/>
                        <circle cx="26" cy="50" r="2" fill="#E5E7EB"/>
                        <circle cx="50" cy="50" r="2" fill="#E5E7EB"/>
                        <circle cx="74" cy="50" r="2" fill="#E5E7EB"/>
                        <circle cx="98" cy="50" r="2" fill="#E5E7EB"/>
                    </svg>
                </div>
            </div>
        </div>
    </body>
</html>
