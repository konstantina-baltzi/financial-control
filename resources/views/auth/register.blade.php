<!DOCTYPE html>
<html lang="el">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Εγγραφή - Financial Control</title>
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

                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-gray-900">Δημιουργία Λογαριασμού</h2>
                    <p class="text-gray-600 mt-2">Συμπληρώστε τα στοιχεία σας για να ξεκινήσετε.</p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700">Όνομα / Ψευδώνυμο</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                            class="block mt-1 w-full p-3 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        @if ($errors->has('name'))
                        <p class="text-red-500 text-xs mt-1">{{ $errors->first('name') }}</p>
                        @endif
                    </div>

                    <div class="mt-5">
                        <label for="email" class="block text-sm font-semibold text-gray-700">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                            class="block mt-1 w-full p-3 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        @if ($errors->has('email'))
                        <p class="text-red-500 text-xs mt-1">{{ $errors->first('email') }}</p>
                        @endif
                    </div>

                    <div class="mt-5">
                        <label for="password" class="block text-sm font-semibold text-gray-700">Κωδικός Πρόσβασης</label>
                        <input id="password" type="password" name="password" required autocomplete="new-password"
                            class="block mt-1 w-full p-3 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        @if ($errors->has('password'))
                        <p class="text-red-500 text-xs mt-1">{{ $errors->first('password') }}</p>
                        @endif
                    </div>

                    <div class="mt-5">
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700">Επιβεβαίωση Κωδικού</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                            class="block mt-1 w-full p-3 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        @if ($errors->has('password_confirmation'))
                        <p class="text-red-500 text-xs mt-1">{{ $errors->first('password_confirmation') }}</p>
                        @endif
                    </div>

                    <div class="flex items-center justify-between mt-6">
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 focus:outline-none" href="{{ route('login') }}">
                            Έχετε ήδη λογαριασμό;
                        </a>

                        <button type="submit" class="ms-3 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-md transition duration-150 ease-in-out shadow-md cursor-pointer">
                            Εγγραφή
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </div>

</body>

</html>