<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Public information and community services from eBarangay.">
        <title>@yield('title', 'eBarangay')</title>
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body>
        <header class="site-header">
            <a class="brand" href="{{ route('home') }}" aria-label="eBarangay home">
                <span class="brand-mark" aria-hidden="true">e</span>
                <span>eBarangay</span>
            </a>
            <nav class="site-nav" aria-label="Main navigation">
                <a class="nav-link" href="{{ route('home') }}" @if (request()->routeIs('home')) aria-current="page" @endif>Home</a>
                <a class="nav-link" href="{{ route('about') }}" @if (request()->routeIs('about')) aria-current="page" @endif>About</a>
                <a class="nav-link" href="{{ route('faq') }}" @if (request()->routeIs('faq')) aria-current="page" @endif>FAQ</a>
                <a class="nav-action" href="{{ route('faq') }}">Find answers</a>
            </nav>
        </header>

        <main>
            @yield('content')
        </main>

        <footer class="site-footer">
            <div class="footer-inner content-width">
                <p>eBarangay <span aria-hidden="true">/</span> Public information for the community</p>
                <p class="footer-credit">
                    Representative hall photo by
                    <a href="https://commons.wikimedia.org/wiki/User:Ahri.boy" rel="noopener noreferrer">Ahri.boy</a>,
                    <a href="https://creativecommons.org/licenses/by/4.0/">CC BY 4.0</a>.
                    <a href="https://commons.wikimedia.org/wiki/File:Barangay_Hall_of_Baybay,_Alubijid.jpg" rel="noopener noreferrer">Source</a>.
                </p>
            </div>
        </footer>
    </body>
</html>