<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <title>@yield('title') | CutCode</title>
    <meta name="description" content="Видеокурс по изучению принципов программирования">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#1E1F43">
    <meta name="msapplication-TileColor" content="#1E1F43">
    <meta name="theme-color" content="#1E1F43">

    @vite(['resources/css/app.css', 'resources/sass/main.sass', 'resources/js/app.js'])
</head>

<body>
    @if ($flash = flash()->get())
        <x-flash :flash="$flash"/>
    @endif
    <main class="md:min-h-screen md:flex md:items-center md:justify-center py-16 lg:py-20">
        <div class="container">

            <div class="text-center">
                <a href="{{route('home')}}" class="inline-block" rel="home">
                    <img src="/logo.svg" class="w-[148px] md:w-[201px] h-[36px] md:h-[50px]" alt="CutCode">
                </a>
            </div>

            @yield('content')

        </div>
    </main>
</body>

</html>
