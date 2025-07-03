@extends('layouts.app')
<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Información del Perfil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Actualiza la información de perfil de tu cuenta y dirección de correo electrónico.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        {{-- Campo de Nombre --}}
        <div>
            <x-input-label for="name" :value="__('Nombre')" />
            <input id="name" name="name" type="text" 
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 mt-1 block" 
                   value="{{ old('name', $user->name) }}" 
                   required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        {{-- Campo de Email --}}
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <input id="email" name="email" type="email" 
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 mt-1 block" 
                   value="{{ old('email', $user->email) }}" 
                   required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Tu dirección de correo electrónico no ha sido verificada.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Haz clic aquí para volver a enviar el correo de verificación.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('Un nuevo enlace de verificación ha sido enviado a tu dirección de correo electrónico.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        {{-- NUEVOS CAMPOS PERSONALIZADOS --}}
        <div>
            <x-input-label for="apellidoPat" :value="__('Apellido Paterno')" />
            <input id="apellidoPat" name="apellidoPat" type="text" 
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 mt-1 block" 
                   value="{{ old('apellidoPat', $user->apellidoPat) }}" 
                   autocomplete="family-name" />
            <x-input-error class="mt-2" :messages="$errors->get('apellidoPat')" />
        </div>

        <div>
            <x-input-label for="apellidoMat" :value="__('Apellido Materno')" />
            <input id="apellidoMat" name="apellidoMat" type="text" 
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 mt-1 block" 
                   value="{{ old('apellidoMat', $user->apellidoMat) }}" 
                   autocomplete="additional-name" />
            <x-input-error class="mt-2" :messages="$errors->get('apellidoMat')" />
        </div>

        <div>
            <x-input-label for="direccion" :value="__('Dirección')" />
            <input id="direccion" name="direccion" type="text" 
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 mt-1 block" 
                   value="{{ old('direccion', $user->direccion) }}" 
                   autocomplete="street-address" />
            <x-input-error class="mt-2" :messages="$errors->get('direccion')" />
        </div>

        <div>
            <x-input-label for="telefono" :value="__('Teléfono')" />
            <input id="telefono" name="telefono" type="text" 
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 mt-1 block" 
                   value="{{ old('telefono', $user->telefono) }}" 
                   autocomplete="tel" />
            <x-input-error class="mt-2" :messages="$errors->get('telefono')" />
        </div>
        {{-- FIN DE NUEVOS CAMPOS --}}


        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Guardar') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Guardado.') }}</p>
            @endif
        </div>
    </form>
</section>