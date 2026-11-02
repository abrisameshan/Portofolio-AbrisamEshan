<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title inertia>{{ config('app.name', 'Abrisam Portfolio') }}</title>

        <!-- Google Fonts: Inter & JetBrains Mono -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Theme Initialization Script -->
        <script>
            (function() {
                try {
                    const savedTheme = localStorage.getItem('theme');
                    if (savedTheme === 'light') {
                        document.documentElement.classList.remove('dark');
                    } else {
                        document.documentElement.classList.add('dark');
                    }
                } catch (e) {}
            })();
        </script>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @inertiaHead
    </head>
    <body class="bg-[#fafafa] dark:bg-[#09090b] text-neutral-900 dark:text-neutral-100 font-sans antialiased selection:bg-neutral-800 selection:text-white dark:selection:bg-neutral-200 dark:selection:text-neutral-950 min-h-screen">
        @inertia
    </body>
</html>
