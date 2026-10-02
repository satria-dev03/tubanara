<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $content->title }} - TUBANARA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-sans text-slate-900">

    <!-- Navbar -->
    <nav class="bg-blue-900 text-white shadow-md py-4 px-6 flex justify-between items-center">
        <a href="/" class="font-bold text-lg flex items-center gap-2">
            🏛️ TUBANARA
        </a>
        <a href="/" class="text-xs bg-blue-800 hover:bg-blue-700 px-3 py-1.5 rounded-lg">← Kembali ke Beranda</a>
    </nav>

    <main class="max-w-4xl mx-auto px-4 py-8">
        <!-- Detail Konten -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden p-6 md:p-8">
            <div class="flex gap-2 mb-3">
                <span class="bg-blue-100 text-blue-800 text-xs px-2.5 py-1 rounded-full font-semibold">{{ $content->category }}</span>
                <span class="bg-emerald-100 text-emerald-800 text-xs px-2.5 py-1 rounded-full font-semibold">{{ $content->subject }} (Kelas {{ $content->grade }})</span>
            </div>

            <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 mb-4">{{ $content->title }}</h1>

            <div class="text-sm text-slate-600 mb-6 pb-4 border-b border-slate-100 flex flex-wrap justify-between items-center">
                <div>
                    <p class="font-semibold text-slate-800">{{ $content->teacher_name }}</p>
                    <p class="text-xs text-slate-500">{{ $content->school_name }} (Kec. {{ $content->district_name }})</p>
                </div>
                <div class="text-xs text-slate-500 mt-2 sm:mt-0">
                    👁️ {{ $content->views }} x dilihat • ❤️ {{ $content->likes()->count() }} Suka
                </div>
            </div>

            @if($content->cover)
                <img src="{{ asset('storage/' . $content->cover) }}" alt="{{ $content->title }}" class="w-full h-72 object-cover rounded-xl mb-6 shadow-inner">
            @endif

            <div class="prose max-w-none text-slate-700 text-sm leading-relaxed mb-8">
                <p class="whitespace-pre-line">{{ $content->description }}</p>
            </div>

            <div class="flex items-center gap-4">
                <a href="{{ $content->file_url }}" target="_blank" class="bg-blue-900 hover:bg-blue-800 text-white px-6 py-2.5 rounded-xl text-sm font-semibold shadow transition flex items-center gap-2">
                    📂 Buka / Unduh Berkas Karya
                </a>
            </div>
        </div>

        <!-- Kolom Komentar -->
        <div class="mt-8 bg-white rounded-2xl shadow-sm border border-slate-200 p-6 md:p-8">
            <h3 class="text-lg font-bold text-slate-800 mb-6">Diskusi & Komentar ({{ $content->comments()->count() }})</h3>

            <!-- Form Kirim Komentar -->
            @auth
                <form action="/contents/{{ $content->id }}/comments" method="POST" class="mb-8">
                    @csrf
                    <textarea name="body" rows="3" class="w-full border border-slate-300 rounded-xl p-3 text-sm focus:ring-2 focus:ring-blue-900 focus:outline-none" placeholder="Tulis apresiasi, pertanyaan, atau masukan untuk karya ini..." required></textarea>
                    <div class="flex justify-end mt-2">
                        <button type="submit" class="bg-blue-900 hover:bg-blue-800 text-white px-5 py-2 rounded-xl text-xs font-semibold shadow transition">Kirim Komentar</button>
                    </div>
                </form>
            @else
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 text-center text-sm text-slate-600 mb-8">
                    Silakan <a href="{{ route('login') }}" class="text-blue-600 font-bold underline">Masuk / Login</a> terlebih dahulu untuk ikut menulis komentar.
                </div>
            @endauth

            <!-- Daftar Komentar -->
            <div class="space-y-4">
                @forelse($content->comments as $comment)
                    <div class="bg-slate-50 border border-slate-100 rounded-xl p-4">
                        <div class="flex justify-between items-center mb-2">
                            <span class="font-semibold text-xs text-slate-800">{{ $comment->user->name ?? 'Guru' }}</span>
                            <span class="text-[10px] text-slate-400">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-xs md:text-sm text-slate-700 whitespace-pre-line">{{ $comment->body }}</p>
                    </div>
                @empty
                    <p class="text-center text-slate-400 text-xs py-6">Belum ada komentar. Jadilah yang pertama memberikan masukan!</p>
                @endforelse
            </div>
        </div>
    </main>

</body>
</html>