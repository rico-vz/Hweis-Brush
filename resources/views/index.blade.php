<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>🟢 Hwei's Brush</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">

</head>

<body class="font-sans antialiased bg-neutral-900">
    {{-- Profile Info --}}
    <div class="flex bg-neutral-800 max-w-[18rem] rounded-xl my-2 mx-2 p-2 border border-neutral-700 shadow-md">
        <div class="text-left flex flex-row">
            <img src="https://wsrv.nl/?url=https://raw.communitydragon.org/latest/plugins/rcp-be-lol-game-data/global/default/v1/profile-icons/{{ $summonerInfo['profileIconId'] }}.jpg&w=300&output=webp&q=100&il"
                alt="Hwei's Brush" class="w-16 h-16 mx-auto rounded-md border border-neutral-700/75" />
            <div class="flex flex-col ml-2">
                <div class=" font-medium text-neutral-100 mb-1">{{ $summonerInfo['gameName'] }}</div>
                <div class="text-sm  text-neutral-100">Level {{ $summonerInfo['summonerLevel'] }}</div>
                <div class="w-full bg-neutral-700 rounded-full h-1.5 mt-1">
                    <div class="bg-purple-600 h-1.5 rounded-full"
                        style="width: {{ $summonerInfo['percentCompleteForNextLevel'] }}%"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Background Selector --}}
    <div class="ml-2 mt-1" x-data="{ openChampion: null }">
        <div id="championScroller" class="overflow-y-auto pl-2 rounded-md inline-block h-[84vh]">
            @foreach ($championSkins as $champion => $championSkin)
                <div class="relative mb-2 w-[18rem]">
                    <button
                        @click="openChampion = openChampion === '{{ $champion }}' ? null : '{{ $champion }}'"
                        class="flex items-center justify-center h-10 w-[17rem] bg-neutral-800 rounded-md border border-neutral-700 shadow-md py-2 px-2">
                        <span class="text-neutral-100">{{ $champion }}</span>
                    </button>
                    <div id="skinWrapper" x-show="openChampion === '{{ $champion }}'" x-transition x-cloak
                        class="fixed top-[0rem] left-[19rem] max-h-[96.75vh] z-10 mt-2 py-2 mr-2 bg-neutral-800 rounded-xl border border-neutral-700 shadow-md grid grid-cols-4 gap-4 px-4 overflow-y-auto">
                        @foreach ($championSkin as $skin)
                            <button @click="fetch('{{ route('set-background', ['skinId' => $skin['skinId']]) }}')"
                                class="block text-neutral-100 hover:bg-neutral-700 p-3 rounded-2xl">
                                <img class="rounded-xl" src="{{ $skin['splashUrl'] }}" />
                                <span class="ml-1">{{ $skin['name'] }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</body>

</html>
