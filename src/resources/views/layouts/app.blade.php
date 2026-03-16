<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- CSSの読み込みを追加 --}}
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <title>@yield('title') | mogitate</title>
</head>

<body>
    <header>
        <nav>
            <a href="{{ route('products.index')}}">もぎたて (ホーム)</a>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <p>&copy; 2026 mogitate</p>
    </footer>
</body>

</html>