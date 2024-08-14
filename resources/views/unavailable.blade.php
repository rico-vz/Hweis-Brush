<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>🟡 Hwei's Brush</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preload" href="{{ asset('/assets/fonts/Beaufort.woff2') }}" as="font" type="font/woff2" crossorigin>

    <link rel="stylesheet" href="{{ asset('assets/css/unavailable.css') }}">

</head>

<body class="antialiased bg-slate-950 ">
    <div class="wrapper ">
        <div id="exitPopup">
            <div class="decal"></div>
            <div class="title">Couldn't detect client</div>
            <div class="desc">Make sure you have the LoL Client open and try again.</div>
            <div class="btn-group">
                <button class="btn" onclick="location.reload()">Try Again</button>
            </div>
        </div>
    </div>
</body>

</html>
