<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authorize App - OAuth Server</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-900 text-white h-screen flex items-center justify-center">
    <div class="w-full max-w-md bg-gray-800 rounded-xl shadow-2xl p-8 border border-gray-700">
        <h2 class="text-2xl font-bold text-center mb-6 text-indigo-400">Authorize {{ $client->name }}</h2>

        <p class="mb-6 text-gray-300 text-center">
            <strong>{{ $client->name }}</strong> is requesting permission to access your account.
        </p>

        <!-- Scopes list could go here -->

        <form method="POST" action="{{ route('passport.authorizations.approve') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="state" value="{{ $request->state }}">
            <input type="hidden" name="client_id" value="{{ $client->id }}">
            <input type="hidden" name="auth_token" value="{{ $authToken }}">

            <div class="flex justify-between space-x-4">
                <button type="submit"
                    class="w-1/2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-lg shadow-lg transition duration-200">
                    Authorize
                </button>
                <!-- Deny button technically needs a separate form or handling, but for now we focus on Authorize -->
            </div>
        </form>
        <div class="mt-4">
            <form method="POST" action="{{ route('passport.authorizations.deny') }}">
                @csrf
                @method('DELETE')
                <input type="hidden" name="state" value="{{ $request->state }}">
                <input type="hidden" name="client_id" value="{{ $client->id }}">
                <input type="hidden" name="auth_token" value="{{ $authToken }}">
                <button type="submit"
                    class="w-full bg-red-600/20 hover:bg-red-600/30 text-red-500 border border-red-500/50 font-bold py-3 rounded-lg transition duration-200">
                    Deny
                </button>
            </form>
        </div>
    </div>
</body>

</html>