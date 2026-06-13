<x-layout>

    <h1 class="mb-8 text-6xl font-bold">
        
    </h1>

    <div class="mx-auto max-w-5xl rounded-2xl bg-white p-10 shadow">

        <form action="{{route('register')}}" method="POST">

            @csrf

            {{-- Username --}}
            <div class="mb-6">
                <label for="username" class="mb-2 block text-xl">Ім'я</label>

                <input
                    type="text"
                    id="username"
                    name="username"
                    class="w-full rounded-xl border border-gray-400 px-5 py-2 text-xl"
                    value="{{old('username')}}"
                    @error('username') ring-red-500 @enderror
                >
                @error('username')
                    <p class="error">{{$message}}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div class="mb-6">
                <label for="email" class="mb-2 block text-xl">Email</label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    class="w-full rounded-xl border border-gray-400 px-5 py-2 text-xl"
                    value="{{old('email')}}"
                    @error('email') ring-red-500 @enderror
                >
                @error('email')
                    <p class="error">{{$message}}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div class="mb-6">
                <label for="password" class="mb-2 block text-xl">Пароль</label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    class="w-full rounded-xl border border-gray-400 px-5 py-2 text-xl"
                    value="{{old('password')}}"
                    @error('password') ring-red-500 @enderror
                >
                @error('password')
                    <p class="error">{{$message}}</p>
                @enderror
            </div>

            {{-- Confirm Password --}}
            <div class="mb-8">
                <label for="password_confirmation" class="mb-2 block text-xl">Підтвердження паролю</label>

                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    class="w-full rounded-xl border border-gray-400 px-5 py-2 text-xl"
                    value="{{old('password_confirmation')}}"
                    @error('password_confirmation') ring-red-500 @enderror
                >
                @error('password_confirmation')
                    <p class="error">{{$message}}</p>
                @enderror
            </div>

            <button
                type="submit"
                class="w-full rounded-xl bg-slate-900 py-3 text-xl text-white"
            >
                Зареєструватись
            </button>

        </form>

    </div>

</x-layout>