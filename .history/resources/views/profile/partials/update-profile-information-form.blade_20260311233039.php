<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Informasi Profil') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update data diri, foto profil, dan CV Anda untuk keperluan melamar kerja.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('put')

        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <div>
            <x-input-label for="foto" :value="__('Foto Profil')" />
            <input id="foto" name="foto" type="file" class="mt-1 block w-full border border-gray-300 rounded p-1.5" />
            @if($user->foto)
                <div class="mt-2">
                    <p class="text-xs text-gray-500">Foto Saat Ini:</p>
                    <img src="{{ asset('storage/' . $user->foto) }}" class="w-16 h-16 rounded object-cover mt-1">
                </div>
            @endif
        </div>

        <div>
            <x-input-label for="file_cv" :value="__('CV (PDF) - Wajib')" />
            <input id="file_cv" name="file_cv" type="file" accept="application/pdf" class="mt-1 block w-full border border-gray-300 rounded p-1.5" />
            @if($user->file_cv)
                <p class="text-sm text-green-600 mt-1">✅ CV sudah ada. <a href="{{ asset('storage/' . $user->file_cv) }}" target="_blank" class="underline font-bold">Lihat CV</a></p>
            @else
                <p class="text-sm text-red-500 mt-1">❌ Belum upload CV</p>
            @endif
        </div>

        <div>
            <x-input-label for="no_hp" :value="__('No HP / WA')" />
            <x-text-input id="no_hp" name="no_hp" type="text" class="mt-1 block w-full" :value="old('no_hp', $user->no_hp)" />
        </div>

        <div>
            <x-input-label for="alamat" :value="__('Alamat')" />
            <textarea name="alamat" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" rows="2">{{ old('alamat', $user->alamat) }}</textarea>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>