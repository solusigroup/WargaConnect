<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pengaturan Kas & Bank') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="max-w-2xl mx-auto bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.bank-settings.store') }}" class="space-y-6">
                        @csrf
                        
                        <div class="border-b pb-4 mb-4">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Rekening Bank Utama</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <x-input-label for="bank_name" :value="__('Nama Bank')" />
                                    <x-text-input id="bank_name" name="bank_name" type="text" class="mt-1 block w-full" :value="old('bank_name', $setting->bank_name ?? 'Bank BCA')" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('bank_name')" />
                                </div>

                                <div>
                                    <x-input-label for="account_number" :value="__('Nomor Rekening')" />
                                    <x-text-input id="account_number" name="account_number" type="text" class="mt-1 block w-full" :value="old('account_number', $setting->account_number ?? '')" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('account_number')" />
                                </div>

                                <div>
                                    <x-input-label for="account_holder" :value="__('Atas Nama')" />
                                    <x-text-input id="account_holder" name="account_holder" type="text" class="mt-1 block w-full" :value="old('account_holder', $setting->account_holder ?? '')" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('account_holder')" />
                                </div>
                            </div>
                        </div>

                        <div class="border-b pb-4 mb-4">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">E-Wallet (Dana)</h3>
                            
                            <div>
                                <x-input-label for="dana_number" :value="__('Nomor HP Dana')" />
                                <x-text-input id="dana_number" name="dana_number" type="text" class="mt-1 block w-full" :value="old('dana_number', $setting->dana_number ?? '')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('dana_number')" />
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Simpan Pengaturan') }}</x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
