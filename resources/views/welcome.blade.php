<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TUBANARA - Ruang Karya Digital Guru Tuban</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800 font-sans">

    <!-- Header Navbar -->
    <header class="bg-blue-900 text-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <a href="/" class="flex items-center gap-3">
                <img src="{{ asset('logo-tubankab.png') }}" alt="Logo Tuban Kab" class="h-10 w-auto rounded-lg" />
                <div>
                    <h1 class="text-xl font-bold tracking-tight">TUBANARA</h1>
                    <p class="text-xs text-blue-200">Ruang Karya Digital Guru Tuban</p>
                </div>
            </a>
            <div class="flex items-center gap-3">
    @auth
        <!-- Jika Sudah Login -->
        <a href="/upload" class="text-xs bg-emerald-500 hover:bg-emerald-600 text-white font-semibold px-3 py-2 rounded-lg transition">
            + Unggah Karya
        </a>
        <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button type="submit" class="text-xs bg-red-500/20 hover:bg-red-500/30 text-red-200 border border-red-500/30 px-3 py-2 rounded-lg font-semibold transition">
                Keluar
            </button>
        </form>
    @else
        <!-- Jika Belum Login -->
        <a href="/login" class="text-xs text-blue-200 hover:text-white font-semibold px-2">
    Masuk
</a>>
        <a href="/register" class="text-xs bg-emerald-500 hover:bg-emerald-600 text-white font-semibold px-3 py-1.5 rounded-lg shadow">
    Daftar
</a>
    @endauth
</div>
    </header>
    @if(session('success'))
<div class="max-w-7xl mx-auto px-4 pt-6">
    <div class="bg-emerald-100 border border-emerald-400 text-emerald-800 px-4 py-3 rounded-lg text-sm font-medium">
        {{ session('success') }}
    </div>
</div>
@endif
    <!-- Hero Section dengan Form Pencarian -->
    <section class="bg-gradient-to-b from-blue-900 via-blue-800 to-slate-900 text-white py-16 px-4 text-center">
        <div class="max-w-3xl mx-auto">
            <h2 class="text-3xl sm:text-4xl font-extrabold mb-3">“Dari Guru Tuban, untuk Pendidikan Indonesia.”</h2>
            <p class="text-blue-200 text-base sm:text-lg mb-8">Platform repositori dan ekosistem berbagi konten digital pendidikan SD se-Kabupaten Tuban.</p>
            
            <form action="/" method="GET" class="bg-white p-2 rounded-xl shadow-2xl flex flex-col sm:flex-row gap-2 max-w-2xl mx-auto">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari karya, guru, atau mata pelajaran..." class="w-full px-4 py-3 rounded-lg text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-600">
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-6 py-3 rounded-lg transition">Cari</button>
            </form>
        </div>
    </section>

    <!-- Main Content & Filter Kategori -->
    <main class="max-w-7xl mx-auto px-4 py-12">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h3 class="text-2xl font-bold text-slate-900">Karya Guru Tuban</h3>
                <p class="text-slate-500 text-sm">
                    @if(request('search'))
                        Menampilkan hasil pencarian untuk: <span class="font-bold text-blue-600">"{{ request('search') }}"</span>
                    @else
                        Konten dari database yang terverifikasi dan siap digunakan.
                    @endif
                </p>
            </div>

            <!-- Tombol Filter Kategori -->
            <!-- Tombol Filter Kategori -->
<div class="flex flex-wrap gap-2">
    <a href="/" class="px-3 py-1.5 rounded-lg text-xs font-semibold {{ !request('category') ? 'bg-blue-900 text-white' : 'bg-slate-200 text-slate-700' }}">Semua</a>
    <a href="/?category=Media Pembelajaran" class="px-3 py-1.5 rounded-lg text-xs font-semibold {{ request('category') == 'Media Pembelajaran' ? 'bg-blue-900 text-white' : 'bg-slate-200 text-slate-700' }}">Media</a>
    <a href="/?category=LKPD" class="px-3 py-1.5 rounded-lg text-xs font-semibold {{ request('category') == 'LKPD' ? 'bg-blue-900 text-white' : 'bg-slate-200 text-slate-700' }}">LKPD</a>
    <a href="/?category=Modul" class="px-3 py-1.5 rounded-lg text-xs font-semibold {{ request('category') == 'Modul' ? 'bg-blue-900 text-white' : 'bg-slate-200 text-slate-700' }}">Modul</a>
    <a href="/?category=Video Pembelajaran" class="px-3 py-1.5 rounded-lg text-xs font-semibold {{ request('category') == 'Video Pembelajaran' ? 'bg-blue-900 text-white' : 'bg-slate-200 text-slate-700' }}">Video</a>
</div>
        </div>

        <!-- Grid Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($contents as $item)
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-md transition flex flex-col justify-between">
                @if($item->cover)
    <img src="{{ asset('storage/' . $item->cover) }}" alt="{{ $item->title }}" class="w-full h-48 object-cover">
@endif
            <div class="p-6">
                    <div class="flex justify-between items-start mb-3">
                        <span class="bg-blue-100 text-blue-800 text-xs px-2.5 py-1 rounded-full font-semibold">{{ $item->category }}</span>
                        <span class="text-xs font-medium text-slate-500 bg-slate-100 px-2 py-0.5 rounded">{{ $item->grade }}</span>
                    </div>
                    <h4 class="text-lg font-bold text-slate-900 mb-2 hover:text-blue-600 transition cursor-pointer">{{ $item->title }}</h4>
                    <p class="text-slate-600 text-sm mb-4 line-clamp-3">{{ $item->description }}</p>
                </div>
                
                <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                    <div>
                        <p class="font-semibold text-slate-700">{{ $item->teacher_name }}</p>
                        <p>{{ $item->school_name }} (Kec. {{ $item->district_name }})</p>
                    </div>
                    <<div class="text-right flex flex-col items-end gap-1.5">
    <span class="inline-block bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded text-xs font-semibold">
        {{ $item->subject }}
    </span>
    
    <div class="flex items-center gap-3 mt-1">
        <!-- Views -->
        <span class="text-xs text-slate-500 font-medium flex items-center gap-1">
            👁️ {{ $item->views ?? 0 }}
        </span>

        <!-- Tombol Like -->
        @auth
            <form action="/contents/{{ $item->id }}/like" method="POST" class="inline">
                @csrf
                <button type="submit" class="text-xs font-medium flex items-center gap-1 transition-transform active:scale-125">
                    @if($item->isLikedBy(auth()->user()))
                        <span class="text-red-500">❤️</span>
                    @else
                        <span class="text-slate-400 hover:text-red-400">🤍</span>
                    @endif
                    <span class="{{ $item->isLikedBy(auth()->user()) ? 'text-red-600 font-bold' : 'text-slate-500' }}">
                        {{ $item->likes()->count() }}
                    </span>
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" title="Login untuk menyukai" class="text-xs text-slate-500 font-medium flex items-center gap-1">
                🤍 {{ $item->likes()->count() }}
            </a>
        @endauth
    </div>
</div>
                </div>
                <!-- Tombol Buka/Lihat File -->
@if($item->file_url)
<div class="px-6 py-3 bg-white border-t border-slate-100">
    <a href="/contents/{{ $item->id }}" class="inline-flex items-center justify-center w-full px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-lg shadow-sm transition">
        📂 Lihat / Buka Karya
    </a>
</div>
@endif
                <!-- Tombol Edit & Hapus (Hanya muncul untuk pemilik karya) -->
@auth
    @if(Auth::id() === $item->user_id)
        <div class="px-6 py-3 bg-slate-100/70 border-t border-slate-200 flex items-center justify-end gap-3 text-xs">
            <a href="/contents/{{ $item->id }}/edit" class="text-blue-600 hover:text-blue-800 font-semibold flex items-center gap-1">
                ✏️ Edit
            </a>
            <form action="/contents/{{ $item->id }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus karya ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 hover:text-red-700 font-semibold flex items-center gap-1">
                    🗑️ Hapus
                </button>
            </form>
        </div>
    @endif
@endauth
            </div>
            @empty
            <div class="col-span-full text-center py-12 text-slate-500">
                Tidak ditemukan karya yang sesuai dengan pencarian/filter.
            </div>
            @endforelse
        </div>
    </main>

</body>
</html>