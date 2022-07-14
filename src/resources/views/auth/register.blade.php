<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Last Name -->
            <div class="mt-4">
                <x-label for="last_name" value="Фамилия" />

                <x-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')" required autofocus />
            </div>

            <!-- First Name -->
            <div class="mt-4">
                <x-label for="name" value="Имя" />

                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required/>
            </div>

            <!-- Middle Name -->
            <div class="mt-4">
                <x-label for="middle_name" value="Отчество" />

                <x-input id="middle_name" class="block mt-1 w-full" type="text" name="middle_name" :value="old('middle_name')"/>
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            <!-- Phone Number -->
            <div class="mt-4">
                <x-label for="phone" value="Номер телефона" />

                <x-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required />
            </div>

            <!-- Company -->
            <div class="mt-4">
                <x-label for="company" value="Название компании" />

                <x-input id="company" class="block mt-1 w-full" type="text" name="company" :value="old('company')" required />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" value="Повторите пароль" />

                <x-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    Уже зарегистрированы?
                </a>

                <x-button class="ml-4">
                    Регистрация
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
