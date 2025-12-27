<x-guest-layout>
    <!-- Hero Section -->
    <div class="flex flex-col items-center text-center space-y-5 pt-4">
        <!-- App Logo / Icon -->
        <div class="h-20 w-20 rounded-3xl bg-primary/10 dark:bg-primary/20 flex items-center justify-center text-primary mb-2 shadow-sm ring-1 ring-primary/20">
            <span class="material-symbols-outlined text-[40px]">apartment</span>
        </div>
        <div class="space-y-2">
            <h1 class="text-[#0d141b] dark:text-white tracking-tight text-[32px] font-bold leading-tight">
                Bergabung<br/>Warga RT 35
            </h1>
            <p class="text-[#4c739a] dark:text-slate-400 text-base font-normal leading-normal">
                Daftarkan diri Anda untuk akses layanan penuh.
            </p>
        </div>
    </div>

    <!-- Segmented Control (Tabs) -->
    <div class="w-full mt-8">
        <div class="grid grid-cols-2 p-1.5 bg-[#e7edf3] dark:bg-[#1e2936] rounded-xl">
            <!-- Tab: Masuk (Link) -->
            <a href="{{ route('login') }}" class="cursor-pointer relative block">
                <div class="z-10 relative flex items-center justify-center py-2.5 text-sm font-semibold rounded-lg transition-all duration-200 text-[#4c739a] dark:text-slate-400 hover:text-[#0d141b] dark:hover:text-white">
                    Masuk
                </div>
            </a>
            <!-- Tab: Daftar (Active) -->
            <label class="cursor-pointer relative">
                <input checked class="peer sr-only" type="radio" name="auth_mode" value="register" disabled />
                <div class="z-10 relative flex items-center justify-center py-2.5 text-sm font-semibold rounded-lg transition-all duration-200 text-[#0d141b] dark:text-white">
                    Daftar
                </div>
                <div class="absolute inset-0 bg-white dark:bg-slate-700 rounded-lg shadow-sm transform scale-100 opacity-100 transition-all duration-200"></div>
            </label>
        </div>
    </div>

    <!-- Input Form -->
    <form method="POST" action="{{ route('register') }}" class="flex flex-col gap-5 mt-6">
        @csrf

        <!-- Name -->
        <div class="space-y-1.5">
            <label class="block text-base font-medium text-[#0d141b] dark:text-slate-200 pb-1" for="name">
                Nama Lengkap
            </label>
            <div class="relative group">
                <input id="name" class="block w-full h-14 rounded-xl border border-[#cfdbe7] dark:border-slate-700 bg-white dark:bg-[#1A2633] text-[#0d141b] dark:text-white placeholder:text-[#4c739a] dark:placeholder:text-slate-500 focus:border-primary focus:ring-0 focus:outline-none px-4 text-base transition-colors"
                                type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Nama sesuai KTP" />
                <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-[#4c739a]">
                    <span class="material-symbols-outlined text-[24px]">person</span>
                </div>
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="space-y-1.5">
            <label class="block text-base font-medium text-[#0d141b] dark:text-slate-200 pb-1" for="email">
                Email
            </label>
            <div class="relative group">
                <input id="email" class="block w-full h-14 rounded-xl border border-[#cfdbe7] dark:border-slate-700 bg-white dark:bg-[#1A2633] text-[#0d141b] dark:text-white placeholder:text-[#4c739a] dark:placeholder:text-slate-500 focus:border-primary focus:ring-0 focus:outline-none px-4 text-base transition-colors"
                                type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="contoh@email.com" />
                <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-[#4c739a]">
                    <span class="material-symbols-outlined text-[24px]">mail</span>
                </div>
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- NIK -->
        <div class="space-y-1.5">
            <label class="block text-base font-medium text-[#0d141b] dark:text-slate-200 pb-1" for="nik">
                NIK (Nomor Induk Kependudukan)
            </label>
            <div class="relative group">
                <input id="nik" class="block w-full h-14 rounded-xl border border-[#cfdbe7] dark:border-slate-700 bg-white dark:bg-[#1A2633] text-[#0d141b] dark:text-white placeholder:text-[#4c739a] dark:placeholder:text-slate-500 focus:border-primary focus:ring-0 focus:outline-none px-4 text-base transition-colors"
                                type="text" name="nik" :value="old('nik')" required placeholder="16 digit NIK" maxlength="16" pattern="\d{16}" title="NIK harus 16 digit angka" />
                <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-[#4c739a]">
                    <span class="material-symbols-outlined text-[24px]">badge</span>
                </div>
            </div>
            <x-input-error :messages="$errors->get('nik')" class="mt-2" />
        </div>
        
        <!-- KK Number -->
        <div class="space-y-1.5">
            <label class="block text-base font-medium text-[#0d141b] dark:text-slate-200 pb-1" for="no_kk">
                No. Kartu Keluarga (KK)
            </label>
            <div class="relative group">
                <input id="no_kk" class="block w-full h-14 rounded-xl border border-[#cfdbe7] dark:border-slate-700 bg-white dark:bg-[#1A2633] text-[#0d141b] dark:text-white placeholder:text-[#4c739a] dark:placeholder:text-slate-500 focus:border-primary focus:ring-0 focus:outline-none px-4 text-base transition-colors"
                                type="text" name="no_kk" :value="old('no_kk')" required placeholder="16 digit No. KK" maxlength="16" pattern="\d{16}" title="No. KK harus 16 digit angka" />
                <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-[#4c739a]">
                    <span class="material-symbols-outlined text-[24px]">contact_mail</span>
                </div>
            </div>
            <x-input-error :messages="$errors->get('no_kk')" class="mt-2" />
        </div>

        <!-- Birth Details Grid -->
        <div class="grid grid-cols-2 gap-4">
            <div class="space-y-1.5">
                <label class="block text-base font-medium text-[#0d141b] dark:text-slate-200 pb-1" for="tempat_lahir">
                    Tempat Lahir
                </label>
                <input id="tempat_lahir" class="block w-full h-14 rounded-xl border border-[#cfdbe7] dark:border-slate-700 bg-white dark:bg-[#1A2633] text-[#0d141b] dark:text-white placeholder:text-[#4c739a] dark:placeholder:text-slate-500 focus:border-primary focus:ring-0 focus:outline-none px-4 text-base transition-colors"
                                type="text" name="tempat_lahir" :value="old('tempat_lahir')" required placeholder="Kota Lahir" />
                <x-input-error :messages="$errors->get('tempat_lahir')" class="mt-2" />
            </div>
            <div class="space-y-1.5">
                <label class="block text-base font-medium text-[#0d141b] dark:text-slate-200 pb-1" for="tanggal_lahir">
                    Tanggal Lahir
                </label>
                <input id="tanggal_lahir" class="block w-full h-14 rounded-xl border border-[#cfdbe7] dark:border-slate-700 bg-white dark:bg-[#1A2633] text-[#0d141b] dark:text-white placeholder:text-[#4c739a] dark:placeholder:text-slate-500 focus:border-primary focus:ring-0 focus:outline-none px-4 text-base transition-colors"
                                type="date" name="tanggal_lahir" :value="old('tanggal_lahir')" required />
                <x-input-error :messages="$errors->get('tanggal_lahir')" class="mt-2" />
            </div>
        </div>
        
        <!-- Address & House Number Grid -->
        <div class="grid grid-cols-3 gap-4">
             <!-- Address -->
            <div class="col-span-2 space-y-1.5">
                <label class="block text-base font-medium text-[#0d141b] dark:text-slate-200 pb-1" for="alamat_rumah">
                    Alamat / Jalan
                </label>
                <div class="relative group">
                    <input id="alamat_rumah" class="block w-full h-14 rounded-xl border border-[#cfdbe7] dark:border-slate-700 bg-white dark:bg-[#1A2633] text-[#0d141b] dark:text-white placeholder:text-[#4c739a] dark:placeholder:text-slate-500 focus:border-primary focus:ring-0 focus:outline-none px-4 text-base transition-colors"
                                    type="text" name="alamat_rumah" :value="old('alamat_rumah')" required placeholder="Jl. Merpati..." />
                </div>
                <x-input-error :messages="$errors->get('alamat_rumah')" class="mt-2" />
            </div>
             <!-- House Number -->
             <div class="space-y-1.5">
                <label class="block text-base font-medium text-[#0d141b] dark:text-slate-200 pb-1" for="house_number">
                    No. Rumah
                </label>
                <div class="relative group">
                    <!-- Note: house_number is not in Warga table explicitly but useful for address. We will append it to address or keep it? User migrations showed 'alamat_rumah'. I will concat them in controller. -->
                    <input id="house_number" class="block w-full h-14 rounded-xl border border-[#cfdbe7] dark:border-slate-700 bg-white dark:bg-[#1A2633] text-[#0d141b] dark:text-white placeholder:text-[#4c739a] dark:placeholder:text-slate-500 focus:border-primary focus:ring-0 focus:outline-none px-4 text-base transition-colors"
                                    type="text" name="house_number" :value="old('house_number')" required placeholder="A1/10" />
                </div>
                <x-input-error :messages="$errors->get('house_number')" class="mt-2" />
            </div>
        </div>

        <!-- Family Members Section (Alpine.js) -->
        <div x-data="{ members: [] }" class="space-y-4">
            <div class="flex justify-between items-center border-t border-gray-200 dark:border-gray-700 pt-6">
                <h3 class="text-lg font-bold text-[#0d141b] dark:text-white">Anggota Keluarga</h3>
                <button type="button" @click="members.push({id: Date.now()})" class="text-sm font-semibold text-primary hover:underline flex items-center gap-1">
                    <span class="material-symbols-outlined text-[20px]">add_circle</span>
                    Tambah Anggota
                </button>
            </div>

            <template x-for="(member, index) in members" :key="member.id">
                <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-xl border border-gray-200 dark:border-gray-700 relative group animate-fade-in-down">
                    <button type="button" @click="members = members.filter(m => m.id !== member.id)" class="absolute top-2 right-2 text-gray-400 hover:text-red-500">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                    
                    <div class="grid grid-cols-1 gap-4">
                        <input type="text" :name="'family_members['+index+'][nama_lengkap]'" placeholder="Nama Lengkap" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-sm" required>
                        <div class="grid grid-cols-2 gap-4">
                            <input type="text" :name="'family_members['+index+'][nik]'" placeholder="NIK (16 digit)" maxlength="16" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-sm" required>
                            <select :name="'family_members['+index+'][hubungan_keluarga]'" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-sm" required>
                                <option value="" disabled selected>Hubungan</option>
                                <option value="Istri">Istri</option>
                                <option value="Suami">Suami</option>
                                <option value="Anak">Anak</option>
                                <option value="Orang Tua">Orang Tua</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <input type="text" :name="'family_members['+index+'][tempat_lahir]'" placeholder="Tempat Lahir" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-sm" required>
                            <input type="date" :name="'family_members['+index+'][tanggal_lahir]'" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-sm" required>
                        </div>
                    </div>
                </div>
            </template>
            
            <div x-show="members.length === 0" class="text-center py-4 bg-gray-50 dark:bg-gray-800 rounded-xl border border-dashed border-gray-300 dark:border-gray-700">
                <p class="text-sm text-gray-500">Belum ada anggota keluarga ditambahkan.</p>
            </div>
        </div>

        <!-- Password -->
        <div class="space-y-1.5 pt-4">
            <label class="block text-base font-medium text-[#0d141b] dark:text-slate-200 pb-1" for="password">
                Kata Sandi
            </label>
            <div class="relative group">
                <input id="password" class="block w-full h-14 rounded-xl border border-[#cfdbe7] dark:border-slate-700 bg-white dark:bg-[#1A2633] text-[#0d141b] dark:text-white placeholder:text-[#4c739a] dark:placeholder:text-slate-500 focus:border-primary focus:ring-0 focus:outline-none pl-4 pr-12 text-base transition-colors"
                                type="password" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter" />
                <button type="button" onclick="const p = document.getElementById('password'); p.type = p.type === 'password' ? 'text' : 'password';" class="absolute inset-y-0 right-0 flex items-center pr-4 text-[#4c739a] hover:text-slate-600 dark:hover:text-slate-300 focus:outline-none">
                    <span class="material-symbols-outlined text-[24px]">visibility</span>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="space-y-1.5">
            <label class="block text-base font-medium text-[#0d141b] dark:text-slate-200 pb-1" for="password_confirmation">
                Konfirmasi Kata Sandi
            </label>
            <div class="relative group">
                <input id="password_confirmation" class="block w-full h-14 rounded-xl border border-[#cfdbe7] dark:border-slate-700 bg-white dark:bg-[#1A2633] text-[#0d141b] dark:text-white placeholder:text-[#4c739a] dark:placeholder:text-slate-500 focus:border-primary focus:ring-0 focus:outline-none pl-4 pr-12 text-base transition-colors"
                                type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi kata sandi" />
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Action Buttons -->
        <div class="pt-3">
            <button class="w-full h-14 bg-primary hover:bg-blue-600 text-white font-bold rounded-xl shadow-[0_4px_10px_rgba(19,127,236,0.3)] active:scale-[0.98] transition-all flex items-center justify-center gap-2 text-base" type="submit">
                <span>Daftar & Verifikasi</span>
                <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
            </button>
        </div>
    </form>

    <!-- Footer Legal Text -->
    <div class="text-center mt-6 pb-6">
        <p class="text-xs text-[#4c739a] dark:text-slate-400">
            Sudah punya akun?
            <a class="text-primary font-medium hover:underline" href="{{ route('login') }}">Masuk di sini</a>.
        </p>
    </div>
</x-guest-layout>
<script>
    // Simple numeric input enforcement for NIK
    document.getElementById('nik').addEventListener('input', function (e) {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
</script>
