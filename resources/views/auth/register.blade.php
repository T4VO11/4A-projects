<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Registrarse - Viajes Increíbles</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        .register-background-gradient {
            background: linear-gradient(to right bottom, #6366f1, #3b82f6, #0ea5e9); 
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        .custom-input {
            border-color: #d1d5db; 
            border-radius: 0.375rem; 
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); 
        }
        .custom-input:focus {
            border-color: #6366f1; 
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.5); 
            outline: 2px solid transparent;
            outline-offset: 2px;
        }
    </style>
</head>
<body class="font-sans text-gray-900 antialiased">
    <div class="register-background-gradient"></div>

    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative z-0">
        <div>
            <a href="/">
                {{-- <x-application-logo class="w-20 h-20 fill-current text-gray-500" /> --}}
                <img src="{{ asset('img/1.jpg') }}" alt="Logo de Agencia" class="w-20 h-20 rounded-full shadow-lg">
            </a>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white dark:bg-gray-800 shadow-xl overflow-hidden sm:rounded-lg">
            <h2 class="text-2xl font-bold text-center text-gray-900 dark:text-white mb-6">Crear Cuenta</h2>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-4">
                    <x-input-label for="name" :value="__('Name')" class="text-gray-700 dark:text-gray-300" />
                    <x-text-input id="name" class="block mt-1 w-full custom-input" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-500" />
                </div>

                <div class="mb-4">
                    <x-input-label for="email" :value="__('Email')" class="text-gray-700 dark:text-gray-300" />
                    <x-text-input id="email" class="block mt-1 w-full custom-input" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
                </div>

                <div class="mb-4">
                    <x-input-label for="password" :value="__('Password')" class="text-gray-700 dark:text-gray-300" />
                    <x-text-input id="password" class="block mt-1 w-full custom-input"
                                    type="password"
                                    name="password"
                                    required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500" />
                </div>

                <div class="mb-4">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-gray-700 dark:text-gray-300" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full custom-input"
                                    type="password"
                                    name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-500" />
                </div>

                <div class="flex items-center justify-end mt-6">
                    <a class="underline text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-200 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out" href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>

                    <x-primary-button class="ms-4 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>

                {{-- Registro con Google --}}
                <div class="flex items-center justify-center mt-6">
                    <a href="/google-auth/redirect" class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 transition duration-150 ease-in-out">
                        <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path fill="#4285F4" d="M22.000 12.000c0-0.781-0.063-1.531-0.188-2.266L12 12.000V15.547L17.766 18.000C16.594 20.328 14.078 22.000 12 22.000c-3.328 0-6.000-2.672-6.000-6.000 0-3.328 2.672-6.000 6.000-6.000 1.766 0 3.328 0.781 4.453 1.953L16.297 6.641C14.766 5.172 12.906 4.313 12 4.313c-4.453 0-8.000 3.547-8.000 8.000 0 4.453 3.547 8.000 8.000 8.000 3.906 0 7.172-2.734 7.906-6.422H12.000V12.000z"/>
                            <path fill="#34A853" d="M12 22.000c-2.438 0-4.609-1.047-6.000-2.703l-1.078 1.078C6.391 21.000 9.047 22.000 12 22.000z"/>
                            <path fill="#FBBC04" d="M4.000 12.000c0-1.781 0.672-3.406 1.781-4.656l-1.078-1.078C3.156 7.422 2.000 9.516 2.000 12.000c0 2.484 1.156 4.578 2.703 6.094l1.078-1.078C4.672 15.406 4.000 13.781 4.000 12.000z"/>
                            <path fill="#EA4335" d="M22.000 12.000c0-2.484-1.156-4.578-2.703-6.094L18.219 4.828C19.328 6.078 20.000 7.703 20.000 9.484h-2.000c0-1.094-0.422-2.109-1.203-2.891l-1.078-1.078C16.953 4.828 19.609 4.000 22.000 4.000c0 2.484-1.156 4.578-2.703 6.094L18.219 13.172C19.328 14.422 20.000 16.047 20.000 17.828h-2.000c0-1.094-0.422-2.109-1.203-2.891z"/>
                        </svg>
                        Registrarse con Google
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>