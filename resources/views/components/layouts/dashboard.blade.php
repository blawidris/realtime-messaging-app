<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>{{ $pageTitle ?? 'Onboarding' }}</title>

    <!-- Fonts / Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- Tailwind Custom Config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#407BFF',
                        secondary: '#475569',
                        muted: "#8E939C",
                        black: "#1A1A1A",
                        danger: "#DD0000",
                        "light-blue": "#EDF6FF",
                        "primary-dark": "#2246EF"
                    },
                    fontFamily: {
                        vietnam: ["Be Vietnam Pro", "sans-serif"],
                    },
                }
            }
        }
    </script>

    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>


    @stack('styles')
</head>

<body class="bg-[#FAFAFA] font-vietnam text-sm antialiased">

    <div class="sm:h-screen sm:flex basis-full grow sm:overflow-hidden">

        {{-- Sidebar --}}
        @include("components.app-sidebar")

        {{-- Main Content Wrapper --}}
        <main id="content" class="transition-all duration-300 flex-1 h-full sm:grow overflow-y-auto scrollbar-thin flex flex-col">

            {{-- Header with Breadcrumbs --}}
            <x-breadcrumbs :title="$title" />

            {{-- Page Content --}}
            <div class="px-4 sm:p-8">
                <h1 class="text-3xl font-medium text-black mb-10">{{ $title }}</h1>

                {{ $slot }}
            </div>

        </main>

    </div>

    {{-- Page Specific JS --}}
    @stack('scripts')

</body>

</html>