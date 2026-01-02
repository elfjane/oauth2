<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - OAuth Server</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>

<body class="bg-gray-900 text-white min-h-screen">
    <nav class="bg-gray-800 border-b border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 text-indigo-500 font-bold text-xl">
                        OAuth Server
                    </div>
                </div>
                <div class="md:block">
                    <div class="ml-4 flex items-center md:ml-6">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="bg-gray-700 hover:bg-gray-600 text-white px-3 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <header class="bg-gray-800 shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold leading-tight text-white">
                Dashboard
            </h1>
        </div>
    </header>

    <main>
        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="px-4 py-6 sm:px-0">
                <div
                    class="border-4 border-dashed border-gray-700 rounded-lg h-96 p-8 flex flex-col justify-center items-center">
                    <div
                        class="bg-gray-800 p-8 rounded-xl shadow-lg border border-gray-700 max-w-sm w-full text-center">
                        <div
                            class="h-20 w-20 rounded-full bg-indigo-600 flex items-center justify-center mx-auto mb-4 text-3xl font-bold">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <h2 class="text-2xl font-bold text-white mb-2">{{ Auth::user()->name }}</h2>
                        <p class="text-gray-400 mb-6">{{ Auth::user()->email }}</p>

                        <div class="border-t border-gray-700 pt-4">
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-500/10 text-green-400">
                                Active Session
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>