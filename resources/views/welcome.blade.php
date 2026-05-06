<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'LinkForge SaaS') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-white dark:bg-gray-900">
        <header class="fixed w-full z-50">
            <nav class="bg-white border-b border-gray-200 px-4 lg:px-6 py-3 dark:bg-gray-800 dark:border-gray-700">
                <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl">
                    <a href="/" class="flex items-center">
                        <span class="self-center text-2xl font-bold whitespace-nowrap dark:text-white">{{ config('app.name', 'LinkForge') }}</span>
                    </a>
                    <div class="flex items-center lg:order-2">
                        <a href="{{ route('admin.dashboard') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Dashboard</a>
                    </div>
                </div>
            </nav>
        </header>

        <section class="bg-white dark:bg-gray-900 pt-32 pb-16 min-h-screen flex items-center">
            <div class="grid max-w-screen-xl px-4 mx-auto lg:gap-8 xl:gap-0 lg:grid-cols-12">
                <div class="mr-auto place-self-center lg:col-span-7">
                    <h1 class="max-w-2xl mb-6 text-4xl font-extrabold tracking-tight leading-none md:text-5xl xl:text-6xl dark:text-white">The Ultimate Shortlink & Failover System</h1>
                    <p class="max-w-2xl mb-8 font-light text-gray-500 lg:mb-10 md:text-lg lg:text-xl dark:text-gray-400">Control your traffic flow. Create custom shortlinks, track clicks with precise analytics, and set up automatic domain failovers to ensure your users always reach their destination.</p>
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center justify-center px-6 py-3.5 mr-3 text-base font-medium text-center text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900">
                        Get Started Now
                        <svg class="w-5 h-5 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </a>
                </div>
                <div class="hidden lg:mt-0 lg:col-span-5 lg:flex justify-end">
                    <svg class="w-full h-auto text-blue-600 max-w-md" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.213 9.787a3.391 3.391 0 0 0-4.795 0l-3.425 3.426a3.39 3.39 0 0 0 4.795 4.794l.321-.304m-.321-4.49a3.39 3.39 0 0 0 4.795 0l3.424-3.426a3.39 3.39 0 0 0-4.794-4.795l-1.028.961 M12 21a9 9 0 1 1 0-18 9 9 0 0 1 0 18Z"/>
                    </svg>
                </div>
            </div>
        </section>
    </body>
</html>