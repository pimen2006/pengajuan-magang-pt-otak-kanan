<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Register</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet" />
</head>

<body class="flex font-poppins items-center justify-center min-h-screen bg-gray-100">
    <div class="flex items-center justify-center w-full p-4">
        <div class="w-full max-w-md">
            <div id="back-div" class="bg-gradient-to-r from-blue-500 to-purple-500 rounded-lg p-4">
                <div class="border border-transparent rounded-lg bg-white shadow-md p-6">
                    <h1 class="text-3xl font-bold text-center text-gray-800 mb-4">
                        Register
                    </h1>
                    <form action="{{ route('account.processRegister') }}" method="post" class="space-y-4">
                        @csrf
                        <div>
                            <label for="name" class="text-sm text-gray-700">Nama</label>
                            <input id="name" value="{{ old('name') }}"
                                class="border p-2 w-full rounded-lg @error('name') border-red-500 @enderror"
                                name="name" type="text" placeholder="nama" />
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="email" class="text-sm text-gray-700">Email</label>
                            <input id="email" value="{{ old('email') }}"
                                class="border p-2 w-full rounded-lg @error('email') border-red-500 @enderror"
                                name="email" type="text" placeholder="name@example.com" />
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="password" class="text-sm text-gray-700">Password</label>
                            <input id="password"
                                class="border p-2 w-full rounded-lg @error('password') border-red-500 @enderror"
                                name="password" type="password" placeholder="Password" />
                            @error('password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="password_confirmation" class="text-sm text-gray-700">Confirm Password</label>
                            <input id="password_confirmation"
                                class="border p-2 w-full rounded-lg @error('password_confirmation') border-red-500 @enderror"
                                name="password_confirmation" type="password" placeholder="Confirm Password" />
                            @error('password_confirmation')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <button
                            class="bg-gradient-to-r from-blue-500 to-purple-500 text-white font-semibold p-2 rounded-lg w-full hover:scale-105 transition-transform"
                            type="submit">
                            Register Now
                        </button>
                    </form>
                    <div class="text-center mt-4 text-sm">
                        <h3>
                            Already have an account?
                            <a class="text-blue-500 underline" href="{{ route('account.login') }}">
                                Login
                            </a>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
