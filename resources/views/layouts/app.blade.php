<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Sistem Penggajian Guru' }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-slate-100 text-slate-900">
    <div class="max-w-6xl mx-auto p-6">
        <header class="mb-8">
            <h1 class="text-3xl font-semibold">{{ $title ?? 'Sistem Penggajian Guru' }}</h1>
            @auth
                <div class="mt-2 text-sm text-slate-600">
                    Login sebagai {{ auth()->user()->name }} ({{ auth()->user()->role }})
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-blue-600">Logout</button>
                    </form>
                </div>
            @endauth
        </header>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>
</body>
</html>
