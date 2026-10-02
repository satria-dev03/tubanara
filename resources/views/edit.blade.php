<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Karya - TUBANARA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-800 font-sans min-h-screen py-10">

    <div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-md border border-slate-200">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Edit Karya Digital</h1>
                <p class="text-slate-500 text-sm">Perbarui informasi karya yang sudah kamu unggah.</p>
            </div>
            <a href="/" class="text-xs bg-slate-100 hover:bg-slate-200 text-slate-700 px-3 py-2 rounded-lg font-semibold transition">
                ← Kembali
            </a>
        </div>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-300 text-red-800 rounded-lg text-sm">
                <p class="font-bold mb-1">Gagal memperbarui karya:</p>
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

       <form action="/contents/{{ $content->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Judul Karya</label>
                <input type="text" name="title" value="{{ old('title', $content->title) }}" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:outline-none">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Kategori</label>
                    <select name="category" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                        <option value="Media Pembelajaran" {{ $content->category == 'Media Pembelajaran' ? 'selected' : '' }}>Media Pembelajaran</option>
                        <option value="LKPD" {{ $content->category == 'LKPD' ? 'selected' : '' }}>LKPD</option>
                        <option value="Modul" {{ $content->category == 'Modul' ? 'selected' : '' }}>Modul</option>
                        <option value="Video Pembelajaran" {{ $content->category == 'Video Pembelajaran' ? 'selected' : '' }}>Video Pembelajaran</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Mata Pelajaran</label>
                    <input type="text" name="subject" value="{{ old('subject', $content->subject) }}" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Kelas</label>
                    <select name="grade" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                        @for ($i = 1; $i <= 6; $i++)
                            <option value="Kelas {{ $i }}" {{ $content->grade == "Kelas $i" ? 'selected' : '' }}>Kelas {{ $i }}</option>
                        @endfor
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nama Guru</label>
                    <input type="text" name="teacher_name" value="{{ old('teacher_name', $content->teacher_name) }}" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nama Sekolah</label>
                    <input type="text" name="school_name" value="{{ old('school_name', $content->school_name) }}" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Kecamatan</label>
                    <input type="text" name="district_name" value="{{ old('district_name', $content->district_name) }}" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi Karya</label>
                <textarea name="description" rows="4" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:outline-none">{{ old('description', $content->description) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Ganti Berkas Karya (Opsional)</label>
                <input type="file" name="file" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                <p class="text-xs text-slate-400 mt-1">Kosongkan jika tidak ingin mengganti file lama.</p>
            </div>

            <!-- Input Link Video / Tautan Luar -->
<div class="mb-4">
    <label class="block text-sm font-semibold text-slate-700 mb-1">
        Link Video / Tautan Luar (Khusus Video / Canva / Google Drive)
    </label>
    <input type="url" name="video_url" value="{{ old('video_url', Str::contains($content->file_url, 'storage/') ? '' : $content->file_url) }}" 
           class="w-full px-4 py-2.5 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-blue-900 focus:outline-none" 
           placeholder="https://youtube.com/watch?v=... atau https://canva.com/...">
    <p class="text-xs text-slate-500 mt-1">*Isi link ini jika karya berupa tautan eksternal (mengabaikan file unggahan).</p>
</div>

<!-- Input Cover / Sampul Karya (Opsional) -->
<div class="mb-6">
    <label class="block text-sm font-semibold text-slate-700 mb-1">
        Ganti Cover / Sampul Karya (Opsional)
    </label>
    <input type="file" name="cover" accept="image/*" 
           class="w-full px-4 py-2 rounded-lg border border-slate-300 text-sm bg-white file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
    <p class="text-xs text-slate-500 mt-1">*Kosongkan jika tidak ingin mengganti cover lama.</p>
</div>

            <div class="pt-4 flex justify-end gap-3">
                <a href="/" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-semibold transition">Batal</a>
                <button type="submit" class="px-5 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg text-sm font-semibold transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>

</body>
</html>