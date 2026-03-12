<x-app-layout>
    <div class="py-10 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-lg shadow-sm flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-lg shadow-sm flex items-center">
                     <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if(Auth::user()->role === 'admin')
                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-gray-800">Selamat Datang, Admin!</h2>
                    <p class="text-gray-500 mt-1">Ringkasan aktivitas BKK hari ini.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center hover:shadow-md transition">
                        <div class="p-4 rounded-xl bg-blue-50 text-blue-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-gray-500 text-sm font-medium">Total Lowongan</h4>
                            <p class="text-2xl font-bold text-gray-800">{{ \App\Models\Loker::count() }}</p>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center hover:shadow-md transition">
                        <div class="p-4 rounded-xl bg-purple-50 text-purple-600">
                             <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-gray-500 text-sm font-medium">Total Pelamar</h4>
                            <p class="text-2xl font-bold text-gray-800">{{ \App\Models\Lamaran::count() }}</p>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center hover:shadow-md transition">
                        <div class="p-4 rounded-xl bg-green-50 text-green-600">
                             <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-gray-500 text-sm font-medium">Diterima Kerja</h4>
                            <p class="text-2xl font-bold text-gray-800">{{ \App\Models\Lamaran::where('status', 'diterima')->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Aksi Cepat</h3>
                    <div class="flex gap-3">
                        <a href="{{ route('admin.loker.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                            + Tambah Loker
                        </a>
                        <a href="{{ route('admin.pelamar.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                            Lihat Semua Pelamar
                        </a>
                    </div>
                </div>

            @else
                <div class="text-center mb-10">
                    <h1 class="text-3xl md:text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-700 to-cyan-500 mb-2">
                        Temukan Karir Impianmu
                    </h1>
                    <p class="text-gray-500">Jelajahi lowongan kerja terbaru khusus alumni SMK.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @forelse($lokers as $loker)
                    <div class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col h-full">
                        
                        <div class="relative h-48 w-full bg-gray-100 overflow-hidden">
                            @if($loker->poster)
                                <img src="{{ asset('storage/' . $loker->poster) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200 text-gray-400">
                                    <svg class="w-12 h-12 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                            <div class="absolute top-3 right-3 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-xs font-bold text-green-600 shadow-sm">
                                ACTIVE
                            </div>
                        </div>

                        <div class="p-6 flex-1 flex flex-col">
                            <div class="mb-4">
                                <h3 class="text-xl font-bold text-gray-900 leading-tight group-hover:text-blue-600 transition">{{ $loker->judul }}</h3>
                                <p class="text-sm font-medium text-gray-500 mt-1 flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    {{ $loker->perusahaan }}
                                </p>
                            </div>
                            
                            <div class="space-y-2 mb-6">
                                <div class="flex items-center text-sm text-gray-600 bg-gray-50 p-2 rounded">
                                    <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    {{ Str::limit($loker->lokasi, 25) }}
                                </div>
                                <div class="flex items-center text-sm text-gray-600 bg-gray-50 p-2 rounded">
                                    <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ $loker->gaji }}
                                </div>
                            </div>

                            @if(Auth::user()->role === 'alumni')
                            <div class="py-12 bg-white mt-8 border-t">
                                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Riwayat Lamaran Saya</h2>
                                    
                                    @php
                                        $myLamarans = \App\Models\Lamaran::with('loker')->where('user_id', Auth::id())->latest()->get();
                                    @endphp

                                    @if($myLamarans->isEmpty())
                                        <p class="text-gray-500">Anda belum melamar pekerjaan apapun.</p>
                                    @else
                                        <div class="grid grid-cols-1 gap-6">
                                            @foreach($myLamarans as $item)
                                            <div class="border rounded-lg p-6 shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center 
                                                {{ $item->status == 'interview' ? 'bg-blue-50 border-blue-200' : 'bg-white' }}">
                                                
                                                <div>
                                                    <h3 class="text-xl font-bold text-gray-900">{{ $item->loker->judul }}</h3>
                                                    <p class="text-gray-600">{{ $item->loker->perusahaan }}</p>
                                                    <p class="text-xs text-gray-400 mt-1">Dilamar pada: {{ \Carbon\Carbon::parse($item->tanggal_melamar)->format('d M Y') }}</p>
                                                </div>

                                                <div class="mt-4 md:mt-0 text-right">
                                                    <span class="px-3 py-1 rounded-full text-sm font-bold uppercase
                                                        {{ $item->status == 'interview' ? 'bg-blue-100 text-blue-800' : 
                                                        ($item->status == 'diterima' ? 'bg-green-100 text-green-800' : 
                                                        ($item->status == 'ditolak' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) }}">
                                                        {{ $item->status }}
                                                    </span>
                                                </div>
                                            </div>

                                            @if($item->status == 'interview')
                                            <div class="mt-0 ml-4 mr-4 p-4 bg-white border border-blue-200 rounded-b-lg shadow-inner -mt-2">
                                                <h4 class="font-bold text-blue-800 flex items-center">
                                                    🔔 Panggilan Interview!
                                                </h4>
                                                <div class="mt-2 text-sm text-gray-700 grid grid-cols-1 md:grid-cols-2 gap-4">
                                                    <div>
                                                        <p class="font-semibold">📅 Tanggal & Waktu:</p>
                                                        <p>{{ \Carbon\Carbon::parse($item->tgl_interview)->format('l, d F Y - H:i') }} WIB</p>
                                                    </div>
                                                    <div>
                                                        <p class="font-semibold">📍 Lokasi / Link:</p>
                                                        <p class="whitespace-pre-line">{{ $item->lokasi_interview }}</p>
                                                    </div>
                                                </div>
                                                @if($item->pesan_admin)
                                                    <div class="mt-3 pt-3 border-t border-gray-100 text-sm text-gray-600 italic">
                                                        "{{ $item->pesan_admin }}"
                                                    </div>
                                                @endif
                                            </div>
                                            @endif

                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @endif

                            <div class="mt-auto">
                                <a href="{{ route('loker.show', $loker->id) }}" class="block w-full text-center py-3 rounded-lg bg-gray-900 text-white font-semibold hover:bg-blue-600 hover:shadow-lg transition-all duration-300">
                                    Lihat Detail & Lamar
                                </a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-3 text-center py-16 bg-white rounded-2xl border border-dashed border-gray-300">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada lowongan</h3>
                        <p class="mt-1 text-sm text-gray-500">Silakan cek kembali nanti.</p>
                    </div>
                    @endforelse
                </div>
            @endif
        </div>
    </div>
</x-app-layout>