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
            <input required class="input" type="email" name="email" id="email" placeholder="E-mail"
                :value="old('email')" autofocus>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />

            <!-- Password -->
            <input required class="input" type="password" name="password" id="password" placeholder="Password">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />

            <!-- Remember Me & Forgot Password -->
            <div class="flex justify-between mt-2 items-center text-sm text-gray-600">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="remember"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                    <span class="ml-2">Remember me</span>
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="underline text-blue-600 hover:text-blue-800">Forgot
                        Password?</a>
                @endif
            </div>

            <!-- Submit Button -->
            <input class="login-button mt-6" type="submit" value="Login SIPANDA">
        </form>

        <!-- Info Box untuk yang belum punya akun -->
        <div class="info-box">
            <div class="info-icon">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="info-content">
                <h3 class="info-title">Belum punya akun?</h3>
                <p class="info-text">
                    Sistem login ini khusus untuk pengguna terdaftar. Jika Anda belum memiliki akun,
                    silakan hubungi <strong>Administrator</strong> untuk membuatkan akun baru.
                </p>
                <div class="info-contact">
                    <div class="contact-item">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <span>Hubungi Admin</span>
                    </div>
                    <div class="contact-item">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span>admin@iaitasik.ac.id</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background: 
                /* Multiple geometric shapes dengan opacity lebih tinggi */
                url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><polygon fill="%230ea5e9" fill-opacity="0.08" points="0,1000 1000,0 1000,1000"/></svg>'),
                url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><circle fill="%230ea5e9" fill-opacity="0.06" cx="200" cy="200" r="120"/></svg>'),
                url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><rect fill="%230ea5e9" fill-opacity="0.05" x="700" y="700" width="180" height="180" rx="15"/></svg>'),
                url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><polygon fill="%233b82f6" fill-opacity="0.04" points="300,100 500,300 300,500 100,300"/></svg>'),
                /* Gradient background yang lebih kuat */
                linear-gradient(135deg, #dbeafe 0%, #e0f2fe 30%, #f0f9ff 70%, #e0f7fa 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            position: relative;
        }

        /* Efek overlay biru tambahan */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 30%, rgba(59, 130, 246, 0.15) 0%, transparent 40%),
                radial-gradient(circle at 80% 70%, rgba(14, 165, 233, 0.12) 0%, transparent 40%);
            z-index: -1;
        }

        /* Container dengan backdrop filter untuk efek glass */
        .container {
            max-width: 400px;
            background: rgba(255, 255, 255, 0.92);
            border-radius: 40px;
            padding: 25px 35px;
            border: 5px solid rgba(255, 255, 255, 0.8);
            box-shadow: 
                rgba(133, 189, 215, 0.88) 0px 30px 30px -20px,
                rgba(14, 165, 233, 0.2) 0px 0px 40px 0px;
            margin: 20px auto;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            position: relative;
            overflow: hidden;
        }

        /* Efek highlight biru di container */
        .container::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(14, 165, 233, 0.1) 0%, transparent 70%);
            z-index: -1;
        }

        /* Heading */
        .heading {
            text-align: center;
            font-weight: 900;
            font-size: 30px;
            color: rgb(71, 71, 71);
            margin-bottom: 20px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        /* Form Inputs */
        .form .input {
            width: 100%;
            background: rgba(255, 255, 255, 0.95);
            border: none;
            padding: 15px 20px;
            border-radius: 20px;
            margin-top: 15px;
            box-shadow: 
                rgba(207, 240, 255, 0.8) 0px 10px 10px -5px,
                rgba(14, 165, 233, 0.1) 0px 0px 10px 0px;
            border-inline: 2px solid transparent;
            transition: all 0.3s ease;
            backdrop-filter: blur(5px);
        }

        .form .input::placeholder {
            color: rgb(170, 170, 170);
        }

        .form .input:focus {
            outline: none;
            border-inline: 2px solid #0ea5e9;
            box-shadow: 
                rgba(207, 240, 255, 0.8) 0px 10px 15px -5px,
                rgba(14, 165, 233, 0.2) 0px 0px 15px 0px;
            background: white;
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
            box-shadow: 
                rgba(133, 189, 215, 0.88) 0px 20px 10px -15px,
                rgba(14, 165, 233, 0.3) 0px 0px 20px 0px;
            border: none;
            transition: all 0.2s ease-in-out;
            position: relative;
            overflow: hidden;
        }

        .form .login-button:hover {
            transform: scale(1.03);
            box-shadow: 
                rgba(133, 189, 215, 0.88) 0px 23px 10px -20px,
                rgba(14, 165, 233, 0.4) 0px 0px 25px 0px;
        }

        .form .login-button:active {
            transform: scale(0.95);
            box-shadow: 
                rgba(133, 189, 215, 0.88) 0px 15px 10px -10px,
                rgba(14, 165, 233, 0.2) 0px 0px 15px 0px;
        }

        /* Info Box Styling - Enhanced */
        .info-box {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            border: 2px solid #bae6fd;
            border-radius: 16px;
            padding: 16px;
            margin-top: 20px;
            display: flex;
            gap: 12px;
            align-items: flex-start;
            box-shadow: 
                0 4px 12px rgba(186, 230, 253, 0.3),
                0 0 0 1px rgba(14, 165, 233, 0.1);
            position: relative;
            overflow: hidden;
        }

        .info-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #0ea5e9, #3b82f6);
        }

        .info-icon {
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
            color: white;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 8px rgba(14, 165, 233, 0.3);
        }

        .info-content {
            flex: 1;
        }

        .info-title {
            font-weight: 700;
            color: #0369a1;
            font-size: 14px;
            margin-bottom: 6px;
        }

        .info-text {
            color: #475569;
            font-size: 12px;
            line-height: 1.4;
            margin-bottom: 10px;
        }

        .info-contact {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #64748b;
            font-size: 11px;
        }

        .contact-item svg {
            color: #0ea5e9;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .container {
                margin: 10px;
                padding: 20px 25px;
            }

            .info-box {
                flex-direction: column;
                text-align: center;
            }

            .info-icon {
                align-self: center;
            }
        }
    </style>
</x-guest-layout>