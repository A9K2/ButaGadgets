<x-layout>

    <h1 class="mb-8 text-6xl font-bold">
        
    </h1>

    <div class="mx-auto max-w-5xl rounded-2xl bg-white p-10 shadow">

        <form action="{{route('login')}}" method="POST">

            @csrf

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
                <label for="password" class="mb-2 block text-xl">Password</label>

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
            <div>
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Remember me</label>

                @error('failed')
                    <p class="error">{{$message}}</p>
                @enderror
            </div>
            <button
                type="submit"
                class="w-full rounded-xl bg-slate-900 py-3 text-xl text-white"
            >
                Login
            </button>

        </form>

    </div>

</x-layout>