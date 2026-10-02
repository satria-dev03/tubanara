<?php

use App\Models\Content;
use App\Models\Like;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Beranda (Bisa diakses publik tanpa login)
Route::get('/', function (Request $request) {
    $query = Content::query();

    // Filter berdasarkan Pencarian (Search)
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%")
              ->orWhere('teacher_name', 'like', "%{$search}%")
              ->orWhere('subject', 'like', "%{$search}%");
        });
    }

    // Filter berdasarkan Kategori
    if ($request->filled('category')) {
        if ($request->category == 'Video') {
            // Mencakup KASUS APAPUN yang mengandung kata 'Video' (Video Pembelajaran, Video Branding Sekolah, dll)
            $query->where('category', 'like', '%Video%');
        } else {
            $query->where('category', $request->category);
        }
    }

    $contents = $query->latest()->get();

    return view('welcome', compact('contents'));
});
// Buka Halaman Detail Karya & Tambah Views
Route::get('/contents/{id}', function ($id) {
    $content = Content::findOrFail($id);
    $content->increment('views'); // Menambah +1 ke kolom views

    return view('show', compact('content'));
});
// Route Khusus Pengguna yang Sudah LOGIN
Route::middleware(['auth'])->group(function () {
    
    // Tampilan Form Upload
    Route::get('/upload', function () {
        return view('upload');
    });
// Toggle Like (Suka / Batal Suka)
    Route::post('/contents/{id}/like', function ($id) {
        $content = Content::findOrFail($id);
        $userId = Auth::id();

        $like = Like::where('content_id', $content->id)
                    ->where('user_id', $userId)
                    ->first();

        if ($like) {
            $like->delete();
        } else {
            Like::create([
                'user_id' => $userId,
                'content_id' => $content->id,
            ]);
        }

        return back();
    });
    // Simpan Komentar Baru
    Route::post('/contents/{id}/comments', function ($id, Request $request) {
        $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'content_id' => $id,
            'body' => $request->body,
        ]);

        return back()->with('success', 'Komentar berhasil dikirim!');
    });
    // Simpan Karya Baru
    Route::post('/upload', function (Request $request) {
    $request->validate([
    'title'        => 'required|string|max:255',
    'category'     => 'required|string',
    'subject'      => 'required|string',
    'grade'        => 'required|string',
    'teacher_name' => 'required|string',
    'school_name'  => 'required|string',
    'district_name'=> 'required|string',
    'description'  => 'required|string',
   'file' => 'nullable|file', // <-- Hapus komentar "// <-- Hapus aturan max dan mimes sementara"
    'video_url'    => 'nullable|url',
]);

    $finalUrl = null;

    if ($request->hasFile('file') && $request->file('file')->isValid()) {
        $path = $request->file('file')->store('files', 'public');
        $finalUrl = asset('storage/' . $path);
    } elseif ($request->filled('video_url')) {
        $finalUrl = $request->video_url;
    }
// Logika Simpan Cover / Thumbnail
    $coverPath = null;
    if ($request->hasFile('cover') && $request->file('cover')->isValid()) {
        $coverPath = $request->file('cover')->store('covers', 'public');
    }
    \App\Models\Content::create([
        'user_id'       => auth()->id(),
        'cover'         => $coverPath,
        'title'         => $request->title,
        'slug'          => Str::slug($request->title) . '-' . time(),
        'category'      => $request->category,
        'subject'       => $request->subject,
        'grade'         => $request->grade,
        'teacher_name'  => $request->teacher_name,
        'school_name'   => $request->school_name,
        'district_name' => $request->district_name,
        'description'   => $request->description,
        'file_url'      => $finalUrl,
    ]);

    return redirect('/')->with('success', 'Karya berhasil diunggah!');
});
   // Form Edit Karya
Route::get('/contents/{id}/edit', function ($id) {
    $content = Content::findOrFail($id); // <-- BARIS INI WAJIB ADA

    // Proteksi: Cek pemilik karya
    if ($content->user_id !== Auth::id()) {
        abort(403, 'Anda tidak memiliki hak untuk mengedit karya ini.');
    }

    return view('edit', compact('content'));
});

    // Update Karya
    Route::put('/contents/{id}', function (Request $request, $id) {
        $content = Content::findOrFail($id);

        if ($content->user_id !== Auth::id()) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'subject' => 'required|string',
            'grade' => 'required|string',
            'teacher_name' => 'required|string',
            'school_name' => 'required|string',
            'district_name' => 'required|string',
            'description' => 'required|string',
           'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png,zip,rar|max:51200',
            'video_url' => 'nullable|url',
        ]);

        $finalUrl = $content->file_url;
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $path = $request->file('file')->store('files', 'public');
            $finalUrl = asset('storage/' . $path);
        } elseif ($request->filled('video_url')) {
            $finalUrl = $request->video_url;
        }
        $coverPath = $content->cover; // Tetap pakai cover lama jika user tidak upload gambar baru
    if ($request->hasFile('cover') && $request->file('cover')->isValid()) {
        $coverPath = $request->file('cover')->store('covers', 'public');
    }
        $content->update([
            'title' => $request->title,
            'cover'         => $coverPath,
            'description' => $request->description,
            'category' => $request->category,
            'subject' => $request->subject,
            'grade' => $request->grade,
            'teacher_name' => $request->teacher_name,
            'school_name' => $request->school_name,
            'district_name' => $request->district_name,
            'file_url' => $finalUrl,
        ]);

        return redirect('/')->with('success', 'Karya berhasil diperbarui!');
    });

    // Hapus Karya
    Route::delete('/contents/{id}', function ($id) {
        $content = Content::findOrFail($id);

        if ($content->user_id !== Auth::id()) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        $content->delete();

        return redirect('/')->with('success', 'Karya berhasil dihapus!');
    });
});

require __DIR__.'/auth.php';
Route::get('/dashboard', function () {
    return redirect('/');
})->name('dashboard');