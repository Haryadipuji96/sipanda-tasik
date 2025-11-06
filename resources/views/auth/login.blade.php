<x-guest-layout>
    <div class="container">
        <!-- Logo -->
        <div class="text-center mb-4">
            <img src="{{ asset('images/Logo-IAIT.png') }}" alt="Logo SIPANDA" class="mx-auto w-24 h-24">
        </div>

        <div class="heading">Login SIPANDA</div>

        <form method="POST" action="{{ route('login') }}" class="form">
            @csrf

            <!-- Email -->
            <input required class="input" type="email" name="email" id="email" placeholder="E-mail" :value="old('email')" autofocus>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />

            <!-- Password -->
            <input required class="input" type="password" name="password" id="password" placeholder="Password">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />

            <!-- Remember Me & Forgot Password -->
            <div class="flex justify-between mt-2 items-center text-sm text-gray-600">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="remember" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                    <span class="ml-2">Remember me</span>
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="underline text-blue-600 hover:text-blue-800">Forgot Password?</a>
                @endif
            </div>

            <!-- Submit Button -->
            <input class="login-button mt-6" type="submit" value="Login SIPANDA">
        </form>
    </div>

    <style>
        /* Container */
        .container {
            max-width: 350px;
            background: linear-gradient(0deg, #fff 0%, #f4f7fb 100%);
            border-radius: 40px;
            padding: 25px 35px;
            border: 5px solid #fff;
            box-shadow: rgba(133, 189, 215, 0.88) 0px 30px 30px -20px;
            margin: 20px auto;
        }

        /* Heading */
        .heading {
            text-align: center;
            font-weight: 900;
            font-size: 30px;
            color: rgb(71, 71, 71);
            margin-bottom: 20px;
        }

        /* Form Inputs */
        .form .input {
            width: 100%;
            background: white;
            border: none;
            padding: 15px 20px;
            border-radius: 20px;
            margin-top: 15px;
            box-shadow: #cff0ff 0px 10px 10px -5px;
            border-inline: 2px solid transparent;
        }

        .form .input::placeholder {
            color: rgb(170, 170, 170);
        }

        .form .input:focus {
            outline: none;
            border-inline: 2px solid #12B1D1;
        }

        /* Login Button */
        .form .login-button {
            display: block;
            width: 100%;
            font-weight: bold;
            background: linear-gradient(45deg, rgb(16, 137, 211) 0%, rgb(18, 177, 209) 100%);
            color: white;
            padding-block: 15px;
            margin: 20px auto;
            border-radius: 20px;
            box-shadow: rgba(133, 189, 215, 0.88) 0px 20px 10px -15px;
            border: none;
            transition: all 0.2s ease-in-out;
        }

        .form .login-button:hover {
            transform: scale(1.03);
            box-shadow: rgba(133, 189, 215, 0.88) 0px 23px 10px -20px;
        }

        .form .login-button:active {
            transform: scale(0.95);
            box-shadow: rgba(133, 189, 215, 0.88) 0px 15px 10px -10px;
        }
    </style>
</x-guest-layout>
