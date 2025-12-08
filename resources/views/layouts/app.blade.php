<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Supermarket</title>

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Alpine.js --}}
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    {{-- Feather Icons --}}
    <script src="https://unpkg.com/feather-icons"></script>

    <style>
        .sidebar-expanded {
            width: 256px;
        }

        .sidebar-collapsed {
            width: 72px;
        }

        .sidebar-transition {
            transition: width 0.25s ease;
        }
    </style>
</head>

<body class="bg-gray-100">
    @yield('content')
</body>

</html>
