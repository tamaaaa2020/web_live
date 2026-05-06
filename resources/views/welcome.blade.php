<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} - Ultimate Shortlink System</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-white text-slate-900 antialiased selection:bg-blue-600 selection:text-white">
    <!-- Navbar -->
    <nav class="fixed w-full z-50 bg-white/80 backdrop-blur-md border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-white font-black shadow-lg shadow-blue-500/20">L</div>
                <span class="text-2xl font-black tracking-tighter text-slate-900 uppercase italic">{{ config('app.name') }}</span>
            </div>
            <div class="flex items-center gap-8">
                <a href="{{ route('login') }}" class="text-sm font-bold text-slate-500 hover:text-slate-900 transition-colors">Sign In</a>
                <a href="{{ route('admin.dashboard') }}" class="bg-slate-900 text-white px-6 py-3 rounded-2xl text-sm font-bold hover:bg-slate-800 transition-all shadow-xl shadow-slate-900/10">
                    Dashboard
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <main class="relative pt-40 pb-24 overflow-hidden">
        <!-- Decoration -->
        <div class="absolute top-0 right-0 -z-10 w-1/2 h-full bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-blue-50/50 via-transparent to-transparent"></div>
        
        <div class="max-w-7xl mx-auto px-6 text-center lg:text-left grid lg:grid-cols-2 items-center gap-20">
            <div>
                <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-[0.2em] bg-blue-50 text-blue-600 border border-blue-100 mb-8">
                    Next-Gen Shortlink Platform
                </span>
                <h1 class="text-6xl lg:text-7xl font-[900] text-slate-900 leading-[1.1] tracking-tight mb-8">
                    Smart Links for <span class="text-blue-600 italic">Serious</span> Business.
                </h1>
                <p class="text-xl text-slate-500 font-medium leading-relaxed mb-12 max-w-xl mx-auto lg:mx-0">
                    Control your traffic with precision. Automatic multi-domain failover, deep analytics, and lightning-fast redirects.
                </p>
                <div class="flex flex-col sm:flex-row items-center gap-4 justify-center lg:justify-start">
                    <a href="{{ route('admin.dashboard') }}" class="w-full sm:w-auto bg-blue-600 text-white px-10 py-5 rounded-[2rem] text-lg font-black hover:bg-blue-700 transition-all shadow-2xl shadow-blue-500/40 active:scale-[0.98]">
                        Start For Free
                    </a>
                    <a href="#features" class="w-full sm:w-auto px-10 py-5 text-slate-400 font-bold hover:text-slate-900 transition-colors">
                        Explore Features &rarr;
                    </a>
                </div>
                
                <div class="mt-16 flex items-center gap-8 justify-center lg:justify-start grayscale opacity-40">
                    <span class="font-black text-2xl tracking-tighter uppercase italic">Google</span>
                    <span class="font-black text-2xl tracking-tighter uppercase italic">Meta</span>
                    <span class="font-black text-2xl tracking-tighter uppercase italic">Amazon</span>
                </div>
            </div>

            <div class="relative">
                <div class="absolute -inset-4 bg-blue-100/50 rounded-[3rem] blur-3xl -z-10"></div>
                <div class="bg-white border border-slate-100 p-4 rounded-[2.5rem] shadow-2xl">
                    <div class="bg-slate-50 rounded-[2rem] p-8 aspect-[4/3] flex flex-col justify-center items-center text-center">
                        <div class="w-20 h-20 bg-white rounded-3xl shadow-lg flex items-center justify-center mb-6">
                            <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <h3 class="text-2xl font-black text-slate-900 mb-2">301 Redirects</h3>
                        <p class="text-slate-400 font-medium">Ultra-low latency globally.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="py-12 border-t border-slate-50">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-slate-900 rounded-lg flex items-center justify-center text-white font-black text-sm">L</div>
                <span class="text-sm font-black text-slate-900 uppercase tracking-wider italic">{{ config('app.name') }}</span>
            </div>
            <p class="text-sm font-bold text-slate-300 uppercase tracking-widest">
                &copy; {{ date('Y') }} ALL RIGHTS RESERVED
            </p>
        </div>
    </footer>
</body>
</html>