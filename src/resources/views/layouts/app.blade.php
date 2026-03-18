<!DOCTYPE html>
<html lang="ja">

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
            <a href="{{ route('products.index') }}" class="brand-logo">mogitate</a>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

</body>

</html>