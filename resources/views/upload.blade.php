<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Karya - TUBANARA</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800 font-sans">

    <!-- Header Navbar -->
    <header class="bg-blue-900 text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <a href="/" class="flex items-center gap-3">
                <div class="w-10 h-10 bg-emerald-500 rounded-lg flex items-center justify-center font-bold text-xl shadow">T</div>
                <div>
                    <h1 class="text-xl font-bold tracking-tight">TUBANARA</h1>
                    <p class="text-xs text-blue-200">Ruang Karya Digital Guru Tuban</p>
                </div>
            </a>
            <a href="/" class="text-xs bg-slate-700 hover:bg-slate-600 px-3 py-2 rounded-lg font-medium">← Kembali ke Beranda</a>
        </div>
    </header>

    <!-- Form Section -->
    <main class="max-w-3xl mx-auto px-4 py-10">
        <div class="bg-white p-8 rounded-xl shadow-sm border border-slate-200">
            <h2 class="text-2xl font-bold text-slate-900 mb-1">Unggah Karya Digital Baru</h2>
            <p class="text-slate-500 text-sm mb-6">Bagikan bahan ajar, modul, atau media pembelajaran kamu untuk guru se-Kabupaten Tuban.</p>

            <!-- Menampilkan Pesan Error jika Upload Gagal -->
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-300 rounded-lg text-red-700 text-sm">
                    <p class="font-bold mb-1">Gagal mengunggah karya:</p>
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="/upload" method="POST" enctype="multipart/form-data">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Judul Karya</label>
                    <input type="text" name="title" required value="{{ old('title') }}" placeholder="Contoh: Modul Ajar IPAS Kelas 4 Bab 2" class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Kategori</label>
                        <select name="category" required class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-600">
                            <option value="Media Pembelajaran">Media Pembelajaran</option>
                            <option value="LKPD">LKPD</option>
                            <option value="Modul">Modul</option>
                            <option value="Video Pembelajaran">Video Pembelajaran</option>
                            <option value="Video Branding Sekolah">Video Branding Sekolah</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Mata Pelajaran</label>
                        <input type="text" name="subject" required value="{{ old('subject') }}" placeholder="IPAS / Matematika / dll" class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Kelas</label>
                        <select name="grade" required class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-600">
                            <option value="Kelas 1">Kelas 1</option>
                            <option value="Kelas 2">Kelas 2</option>
                            <option value="Kelas 3">Kelas 3</option>
                            <option value="Kelas 4">Kelas 4</option>
                            <option value="Kelas 5">Kelas 5</option>
                            <option value="Kelas 6">Kelas 6</option>
                            <option value="Kelas 6">Umum</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Guru</label>
                        <input type="text" name="teacher_name" required value="{{ old('teacher_name') }}" placeholder="Nama & Gelar" class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Sekolah</label>
                        <input type="text" name="school_name" required value="{{ old('school_name') }}" placeholder="SDN ..." class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Kecamatan</label>
                        <input type="text" name="district_name" required value="{{ old('district_name') }}" placeholder="Nama Kecamatan" class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-600">
               
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Deskripsi Karya</label>
                    <textarea name="description" rows="4" required placeholder="Jelaskan secara singkat mengenai karya ini..." class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-600">{{ old('description') }}</textarea>
                </div>

                <!-- Upload File Dokumen/Gambar -->
<div>
    <label class="block text-sm font-semibold text-slate-700 mb-1">Upload Berkas/File (PDF, Word, Excel, JPG, PNG)</label>
    <input type="file" name="file" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
</div>
<!-- Input Cover / Thumbnail Opsional -->
        <div class="mb-5">
            <label class="block text-sm font-semibold text-slate-700 mb-1">
                Cover / Thumbnail Karya <span class="text-xs text-slate-400 font-normal">(Opsional)</span>
            </label>
            <input type="file" name="cover" accept="image/*" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
            <p class="text-xs text-slate-500 mt-1">*Gambar sampul untuk tampilan kartu depan (PNG, JPG, WEBP maks 2MB)</p>
        </div>
<!-- Input Link khusus Video / Drive -->
<div>
    <label class="block text-sm font-semibold text-slate-700 mb-1">Link Video / Tautan Luar (Khusus Video YouTube, Drive, dll)</label>
    <input type="url" name="video_url" value="{{ old('video_url') }}" placeholder="https://youtube.com/watch?v=... atau https://drive.google.com/..." class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-600">
    <p class="text-xs text-slate-500 mt-1">*Isi kolom ini jika karya berupa Video atau file tersimpan di Google Drive / YouTube.</p>
</div>
                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 rounded-lg transition">Simpan & Publikasikan Karya</button>
            </form>
        </div>
    </main>

</body>
</html>