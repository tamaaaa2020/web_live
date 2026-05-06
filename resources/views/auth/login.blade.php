<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - {{ config('app.name') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-slate-50 antialiased selection:bg-blue-100 selection:text-blue-900">
    <div class="min-h-screen flex flex-col justify-center items-center p-6 relative overflow-hidden">
        <!-- Background Decoration -->
        <div class="absolute inset-0 z-0 bg-[radial-gradient(circle_at_top_right,_var(--tw-gradient-stops))] from-blue-100/40 via-transparent to-transparent"></div>
        <div class="absolute bottom-0 left-0 z-0 w-full h-1/2 bg-[radial-gradient(circle_at_bottom_left,_var(--tw-gradient-stops))] from-indigo-100/30 via-transparent to-transparent"></div>
        
        <div class="relative z-10 w-full max-w-[440px]">
            <!-- Logo Area -->
            <div class="text-center mb-12">
                <div class="w-14 h-14 bg-blue-600 rounded-2xl flex items-center justify-center text-white text-2xl font-black shadow-xl shadow-blue-500/30 mx-auto mb-6">L</div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ config('app.name') }}</h1>
                <p class="mt-3 text-slate-500 font-medium">Please sign in to access your dashboard.</p>
            </div>

            <!-- Login Card -->
            <div class="bg-white p-10 rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.04)] border border-slate-100/80">
                @if ($errors->any())
                    <div class="mb-8 p-4 bg-red-50 rounded-2xl border border-red-100 text-sm text-red-600 font-medium">
                        @foreach ($errors->all() as $error)
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                {{ $error }}
                            </div>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('login.post') }}" class="space-y-6">
                    @csrf
                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 px-1">Email Address</label>
                        <input id="email" name="email" type="email" required value="{{ old('email') }}" 
                            class="block w-full rounded-2xl border-slate-100 bg-slate-50/50 px-5 py-4 text-slate-900 text-sm font-medium focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all placeholder:text-slate-400" placeholder="admin@example.com">
                    </div>

                    <div>
                        <label for="password" class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 px-1">Password</label>
                        <input id="password" name="password" type="password" required 
                            class="block w-full rounded-2xl border-slate-100 bg-slate-50/50 px-5 py-4 text-slate-900 text-sm font-medium focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all placeholder:text-slate-400" placeholder="••••••••">
                    </div>

                    <div class="flex items-center">
                        <label class="flex items-center cursor-pointer group">
                            <input id="remember" name="remember" type="checkbox" class="w-5 h-5 rounded-lg border-slate-200 text-blue-600 focus:ring-blue-500/20 transition-all cursor-pointer">
                            <span class="ml-3 text-sm font-semibold text-slate-500 group-hover:text-slate-900 transition-colors">Remember me</span>
                        </label>
                    </div>

                    <button type="submit" class="w-full bg-slate-900 text-white py-4 rounded-2xl text-sm font-bold hover:bg-slate-800 transition-all shadow-lg shadow-slate-900/10 active:scale-[0.98]">
                        Sign in to Dashboard
                    </button>
                </form>
            </div>
            
            <p class="mt-10 text-center text-xs font-bold text-slate-300 uppercase tracking-[0.2em]">
                &copy; {{ date('Y') }} {{ config('app.name') }}
            </p>
        </div>
    </div>
</body>
</html>