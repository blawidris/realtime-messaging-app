<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>{{ $pageTitle ?? 'Onboarding' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <link
        href="https://cdn.quilljs.com/1.3.7/quill.snow.css"
        rel="stylesheet" />


    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>


    <!-- Tailwind Config (optional) -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#407BFF',
                        secondary: '#475569',
                        muted: "#8E939C",
                        black: "#1A1A1A",
                        danger: "#DD0000"
                    },
                    fontFamily: {
                        vietnam: ["Be Vietnam Pro", "sans-serif"],
                    },
                }
            }
        }
    </script>

    <!-- Custom CSS (optional) -->
    <style>
        * {
            font-family: "Be Vietnam Pro", sans-serif;
            font-size: 1rem;
        }

        .starry-background {
            background-image:url('{{ asset("images/noisebg.png") }}');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center center;
        }
    </style>
    @stack('styles')

    {{-- Livewire styles (enable later) --}}
    {{-- @livewireStyles --}}
</head>

<body class="bg-white font-vietnam text-sm antialiased">

    <main class="min-h-screen">

        <div class="flex min-h-screen">
            @isset($sidebar)
            <!-- <aside class="hidden lg:flex w-1/2 starry-background text-white p-12 flex-col justify-between relative overflow-hidden"> -->
            {{ $sidebar }}
            <!-- </aside> -->
            @endisset


            {{-- Main Content --}}

            {{ $slot }}
        </div>



    </main>

    <script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>


    {{-- Custom JS injected per page --}}

    <script>
        function quillEditor() {
            return {
                quill: null,
                aboutLength: 0,

                init() {
                    this.quill = new Quill('#quill-editor', {
                        theme: 'snow',
                        placeholder: 'Enter Text Here...',
                        modules: {
                            toolbar: [
                                ['bold', 'italic', 'underline'],
                                [{
                                    list: 'ordered'
                                }, {
                                    list: 'bullet'
                                }],
                                ['clean'],
                            ],
                        },
                    });

                    // Sync content to hidden input
                    this.quill.on('text-change', () => {
                        const html = this.quill.root.innerHTML;
                        const text = this.quill.getText().trim();

                        this.aboutLength = text.length;
                        this.$refs.bio.value = html;
                    });
                },
            };
        }
    </script>
    @stack('scripts')

    {{-- Livewire scripts (enable later) --}}
    {{-- @livewireScripts --}}
</body>

</html>