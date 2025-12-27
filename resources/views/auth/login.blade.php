<x-guest-layout>
    <!-- Hero Section -->
    <div class="flex flex-col items-center text-center space-y-5 pt-4">
        <!-- App Logo / Icon -->
        <div class="h-20 w-20 rounded-3xl bg-primary/10 dark:bg-primary/20 flex items-center justify-center text-primary mb-2 shadow-sm ring-1 ring-primary/20">
            <span class="material-symbols-outlined text-[40px]">apartment</span>
        </div>
        <div class="space-y-2">
            <h1 class="text-[#0d141b] dark:text-white tracking-tight text-[32px] font-bold leading-tight">
                Selamat Datang<br/>Warga RT 35
            </h1>
            <p class="text-[#4c739a] dark:text-slate-400 text-base font-normal leading-normal">
                Kelola iuran dan info warga dengan mudah.
            </p>
        </div>
    </div>

    <!-- Segmented Control (Tabs) -->
    <div class="w-full mt-8">
        <div class="grid grid-cols-2 p-1.5 bg-[#e7edf3] dark:bg-[#1e2936] rounded-xl">
            <!-- Tab: Masuk (Active) -->
            <label class="cursor-pointer relative">
                <input checked class="peer sr-only" type="radio" name="auth_mode" value="login" disabled />
                <div class="z-10 relative flex items-center justify-center py-2.5 text-sm font-semibold rounded-lg transition-all duration-200 text-[#0d141b] dark:text-white">
                    Masuk
                </div>
                <div class="absolute inset-0 bg-white dark:bg-slate-700 rounded-lg shadow-sm transform scale-100 opacity-100 transition-all duration-200"></div>
            </label>
            <!-- Tab: Daftar (Link) -->
            <a href="{{ route('register') }}" class="cursor-pointer relative block">
                <div class="z-10 relative flex items-center justify-center py-2.5 text-sm font-semibold rounded-lg transition-all duration-200 text-[#4c739a] dark:text-slate-400 hover:text-[#0d141b] dark:hover:text-white">
                    Daftar
                </div>
            </a>
        </div>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Input Form -->
    <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-5 mt-6">
        @csrf

        <!-- Email Address -->
        <div class="space-y-1.5">
            <label class="block text-base font-medium text-[#0d141b] dark:text-slate-200 pb-1" for="email">
                Email
            </label>
            <div class="relative group">
                <input id="email" class="block w-full h-14 rounded-xl border border-[#cfdbe7] dark:border-slate-700 bg-white dark:bg-[#1A2633] text-[#0d141b] dark:text-white placeholder:text-[#4c739a] dark:placeholder:text-slate-500 focus:border-primary focus:ring-0 focus:outline-none px-4 text-base transition-colors"
                                type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="contoh@email.com" />
                <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-[#4c739a]">
                    <span class="material-symbols-outlined text-[24px]">mail</span>
                </div>
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="space-y-1.5">
            <div class="flex justify-between items-center pb-1">
                <label class="block text-base font-medium text-[#0d141b] dark:text-slate-200" for="password">
                    Kata Sandi
                </label>
            </div>
            <div class="relative group">
                <input id="password" class="block w-full h-14 rounded-xl border border-[#cfdbe7] dark:border-slate-700 bg-white dark:bg-[#1A2633] text-[#0d141b] dark:text-white placeholder:text-[#4c739a] dark:placeholder:text-slate-500 focus:border-primary focus:ring-0 focus:outline-none pl-4 pr-12 text-base transition-colors"
                                type="password" name="password" required autocomplete="current-password" placeholder="Masukkan kata sandi" />
                <button type="button" onclick="const p = document.getElementById('password'); p.type = p.type === 'password' ? 'text' : 'password';" class="absolute inset-y-0 right-0 flex items-center pr-4 text-[#4c739a] hover:text-slate-600 dark:hover:text-slate-300 focus:outline-none">
                    <span class="material-symbols-outlined text-[24px]">visibility</span>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
            
            <!-- Forgot Password Link -->
            <div class="flex justify-end pt-1">
                @if (Route::has('password.request'))
                    <a class="text-sm font-medium text-primary hover:text-blue-600 dark:hover:text-blue-400 transition-colors" href="{{ route('password.request') }}">
                        Lupa Kata Sandi?
                    </a>
                @endif
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-3 pt-3">
            <button class="flex-1 h-14 bg-primary hover:bg-blue-600 text-white font-bold rounded-xl shadow-[0_4px_10px_rgba(19,127,236,0.3)] active:scale-[0.98] transition-all flex items-center justify-center gap-2 text-base" type="submit">
                <span>Masuk Sekarang</span>
                <span class="material-symbols-outlined text-[20px]">login</span>
            </button>
            <!-- Biometric Button (Visual Only) -->
            <button aria-label="Biometric Login" class="h-14 w-14 flex flex-shrink-0 items-center justify-center bg-white dark:bg-[#1A2633] border border-[#cfdbe7] dark:border-slate-700 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors text-primary active:scale-[0.95]" type="button">
                <span class="material-symbols-outlined text-[28px]">fingerprint</span>
            </button>
        </div>
    </form>

    <!-- Divider -->
    <div class="relative flex py-2 items-center mt-6">
        <div class="flex-grow border-t border-[#cfdbe7] dark:border-slate-700"></div>
        <span class="flex-shrink-0 mx-4 text-xs font-semibold text-[#4c739a] uppercase tracking-wide">Atau masuk dengan</span>
        <div class="flex-grow border-t border-[#cfdbe7] dark:border-slate-700"></div>
    </div>

    <!-- Social Login Buttons -->
    <div class="grid grid-cols-2 gap-4 mt-2">
        <button class="flex items-center justify-center gap-2.5 h-12 bg-white dark:bg-[#1A2633] border border-[#cfdbe7] dark:border-slate-700 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors active:scale-[0.98]">
            <!-- Google Color Indicator -->
            <div class="w-5 h-5 rounded-full bg-gradient-to-tr from-blue-500 via-red-500 to-yellow-500 flex items-center justify-center">
                <div class="w-2.5 h-2.5 bg-white dark:bg-[#1A2633] rounded-full"></div>
            </div>
            <span class="text-sm font-semibold text-[#0d141b] dark:text-white">Google</span>
        </button>
        <button class="flex items-center justify-center gap-2.5 h-12 bg-[#0d141b] dark:bg-white border border-transparent rounded-xl hover:opacity-90 transition-opacity active:scale-[0.98]">
            <span class="material-symbols-outlined text-[22px] text-white dark:text-black">ios</span>
            <span class="text-sm font-semibold text-white dark:text-black">Apple</span>
        </button>
    </div>

    <!-- Footer Legal Text -->
    <div class="text-center mt-6 pb-6">
        <p class="text-xs text-[#4c739a] dark:text-slate-400">
            Dengan mendaftar, Anda menyetujui<br/>
            <a class="text-primary font-medium hover:underline" href="#">Syarat &amp; Ketentuan</a> kami.
        </p>
    </div>
</x-guest-layout>
