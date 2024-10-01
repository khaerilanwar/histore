<!DOCTYPE html>
<html lang="en">

<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Toko Berkah Jaya</title>
    <link rel="shortcut icon" href="{{ asset('logo.ico') }}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
</head>

<body class="font-poppins bg-gray-200">

    <div class="antialiased">

        <!-- Header Nav -->
        <x-cashier.header></x-cashier.header>

        <!-- Sidebar -->
        <x-cashier.sidebar></x-cashier.sidebar>

        <main class="px-5 lg:p-10 lg:ml-64 h-auto py-20 md:py-10">
            <h1 class="font-semibold text-xl mb-6 md:mt-8">{{ $title }}</h1>
            @session('error')
                <x-alert type="error">{{ $value }}</x-alert>
            @endsession

            @session('success')
                <x-alert type="success">{{ $value }}</x-alert>
            @endsession
            {{ $slot }}
        </main>
    </div>

    <script>
        const pesanAlerts = document.querySelectorAll('.alert')
        pesanAlerts.forEach((alertMsg) => {
            setTimeout(() => {
                alertMsg.classList.add('hidden')
            }, 2000)
        })
    </script>

    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('js/sweet-alert.js') }}" type="module"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>
