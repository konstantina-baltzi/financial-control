<!DOCTYPE html>
<html lang="el">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Σύνδεση - Financial Control</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans antialiased">

    <div class="flex min-h-screen">

        <div class="hidden md:flex md:w-1/2 bg-cover bg-center"
            style="background-image: url('{{ asset('images/bills_img.jpg') }}');">
            <div class="flex items-center h-full w-full bg-blue-900 bg-opacity-50 p-12">
                <div>
                    <h2 class="text-5xl font-bold text-white mb-4">Financial Control</h2>
                    <p class="text-xl text-blue-100 max-w-md">Διαχειριστείτε τους λογαριασμούς και τα έξοδά σας έξυπνα, εύκολα και με πλήρη έλεγχο.</p>
                </div>
            </div>
        </div>

        <div class="w-full md:w-1/2 flex items-center justify-center bg-white p-8 sm:p-12 lg:p-16">
            <div class="w-full max-w-md">

                @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
                @endif

                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-gray-900">Καλώς ορίσατε!</h2>
                    <p class="text-gray-600 mt-2">Συνδεθείτε στον λογαριασμό σας για να συνεχίσετε.</p>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                            class="block mt-1 w-full p-3 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        @if ($errors->has('email'))
                        <p class="text-red-500 text-xs mt-1">{{ $errors->first('email') }}</p>
                        @endif
                    </div>

                    <div class="mt-5">
                        <label for="password" class="block text-sm font-semibold text-gray-700">Κωδικός Πρόσβασης</label>
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                            class="block mt-1 w-full p-3 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        @if ($errors->has('password'))
                        <p class="text-red-500 text-xs mt-1">{{ $errors->first('password') }}</p>
                        @endif
                    </div>

                    <div class="block mt-4">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer">
                            <input id="remember_me" type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                            <span class="ms-2 text-sm text-gray-600">Να με θυμάσαι</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-between mt-6">
                        @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 focus:outline-none" href="{{ route('password.request') }}">
                            Ξέχασες τον κωδικό σου;
                        </a>
                        @endif

                        <button type="submit" class="ms-3 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-md transition duration-150 ease-in-out shadow-md cursor-pointer">
                            Σύνδεση
                        </button>
                    </div>
                </form>

                <div class="mt-8 text-center border-t border-gray-100 pt-6">
                    <p class="text-sm text-gray-600">
                        Δεν έχετε λογαριασμό;
                        <a href="{{ route('register') }}" class="text-blue-600 hover:underline font-semibold">Δημιουργήστε έναν εδώ</a>
                    </p>
                </div>

            </div>
        </div>

    </div>

</body>

</html>