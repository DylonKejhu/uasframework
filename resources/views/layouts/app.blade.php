<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ParamFresh - @yield('title')</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'emerald-primary': '#10b981',
                        'emerald-dark': '#065f46',
                        'emerald-light': '#d1fae5',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-emerald-light min-h-screen antialiased">
    <!-- Sidebar -->
    @yield('sidebar')

    <!-- Main Content -->
    <main class="flex-1">
        @yield('content')
    </main>
</body>
</html>