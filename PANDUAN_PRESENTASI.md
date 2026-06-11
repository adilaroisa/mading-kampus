# 📚 Bedah Kode Mading Kampus (Bahan Presentasi)

Dokumen ini berisi rangkuman teknis tentang fitur-fitur utama di aplikasi Mading Kampus berserta **lokasi file aslinya**. Sangat cocok digunakan sebagai bahan contekan saat presentasi.

---

## 1. Fitur Komentar (Relasi: One-to-Many)

Fitur komentar saling balas-balasan menggunakan relasi **One-to-Many** (Satu ke Banyak), didukung oleh teknik **Self-Referencing** (berelasi dengan dirinya sendiri).

> [!NOTE]  
> **Mengapa One-to-Many?**
> Secara logika, satu Artikel bisa menampung Banyak Komentar. Namun, satu data Komentar spesifik hanya akan menempel di Satu Artikel saja. Karena itulah ini murni One-to-Many.

**Lokasi File & Kodenya:**
1. **User ke Komentar:** Satu User bisa membuat Banyak Komentar.  
   📍 File: `app/Models/User.php` (Baris 18)  
   💻 Kode: `return $this->hasMany(Comment::class);`
2. **Artikel ke Komentar:** Satu Artikel bisa memiliki Banyak Komentar.  
   📍 File: `app/Models/Article.php` (Baris 19)  
   💻 Kode: `return $this->hasMany(Comment::class);`
3. **Komentar Induk ke Balasan (Self-Referencing):** Satu Komentar bisa membalas Komentar lain tanpa batas.  
   📍 File: `app/Models/Comment.php` (Baris 31-35)  
   💻 Kode: `return $this->hasMany(Comment::class, 'parent_id');`
4. **Tampilan Balasan Bertingkat (Frontend):**  
   📍 File: `resources/views/articles/show.blade.php` (Sistem menggunakan perulangan `foreach` bertingkat).

### 💡 Bagaimana Cara Kerja Sistem Balas-balasan Komentar?

Untuk membuat sistem saling membalas komentar, aplikasi ini menggunakan trik logika yang disebut **Parent-Child** (Induk dan Anak).

1. **Rahasia di Database (Kolom `parent_id`):**
   Di dalam tabel komentar, terdapat satu kolom khusus bernama `parent_id`.
   - Jika pengguna menulis **Komentar Utama**, nilai `parent_id` dibiarkan *Kosong (NULL)*.
   - Tapi jika pengguna **Membalas** komentar orang lain, maka nilai `parent_id` akan diisi dengan *Nomor ID dari komentar yang dibalas*.
   📍 File: `database/migrations/..._create_comments_table.php`

2. **Proses Penyimpanan (Backend):**
   Saat tombol "Balas" ditekan, formulir secara otomatis mengirimkan identitas komentar utama (`parent_id`) ke server untuk direkam ke database.
   📍 File: `app/Http/Controllers/ArticleController.php` (Baris 79, Fungsi `storeComment`)
   💻 Kode: `'parent_id' => $request->parent_id`

3. **Cara Menampilkannya ke Layar (Frontend):**
   Sistem memanggil data komentar ke layar menggunakan *Double Looping* (Perulangan Ganda).
   - *Looping Pertama:* Mengambil semua Komentar Utama (yang `parent_id`-nya kosong).
   - *Looping Kedua:* Tepat di bawah setiap komentar utama, sistem memanggil anak-anaknya (balasannya) dengan kode memanggil `$comment->replies`.
   📍 File: `resources/views/articles/show.blade.php`

---

## 2. Fitur Bookmark (Relasi: Many-to-Many)

Aplikasi ini menggunakan relasi tingkat lanjut yaitu **Many-to-Many** pada fitur Bookmark (Simpan Artikel).

> [!TIP]  
> **Mengapa Many-to-Many?**
> - **Satu User** bisa menyimpan **Banyak Artikel**.
> - **Satu Artikel** bisa disimpan oleh **Banyak User**.

**Lokasi File & Kodenya:**
📍 File: `app/Models/User.php` (Baris 19)  
💻 Kode: `return $this->belongsToMany(Article::class, 'bookmarks', 'user_id', 'article_id');`

---

## 3. Fitur Pin (Sematkan Artikel)

Fitur ini bekerja secara harmonis di dua sisi (Backend dan Frontend):

1. **Sisi Backend (Pengatur Urutan):**  
   Bertugas menarik artikel dari database dan memaksa artikel ber-Pin ke urutan paling atas.  
   📍 File: `app/Http/Controllers/ArticleController.php` (Baris 28)  
   💻 Kode: `$articles = $query->orderByDesc('is_pinned')->latest()->paginate(9);`

2. **Sisi Frontend (Penampil Ikon Paku):**  
   Bertugas melukiskan ikon transparan berbentuk paku yang miring 45 derajat pada pojok gambar.  
   📍 File: `resources/views/welcome.blade.php` (Baris 42-45)  
   💻 Kode: `@if($article->is_pinned) ... @endif`

---

## 4. Fitur Maksimal Upload Gambar (Max 2MB)

Terdapat fitur pengamanan (Validation) untuk mencegah *upload* foto yang terlalu besar.

> [!IMPORTANT]  
> **Cara Kerjanya:** Saat Admin menyimpan gambar, sistem akan mencegatnya. Kode `max:2048` mengharuskan gambar tidak boleh lebih berat dari 2048 KB (2MB). Jika melebihi batas, gambar langsung ditolak otomatis.

**Lokasi File & Kodenya:**  
📍 File: `app/Http/Controllers/AdminArticleController.php` (Baris 49)  
💻 Kode: `'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',`

---

## 5. Fitur Lupa Password (Kirim Email Otomatis)

Fitur ini bertugas mengirimkan "Surat Penyelamat" berupa link untuk mengatur ulang password langsung ke kotak masuk (Inbox) email pengguna secara nyata.

> [!NOTE]  
> **Bagaimana Cara Kerjanya?**
> Aplikasi kita bertindak layaknya "Kantor Pos". Saat pengguna meminta reset password, sistem (Laravel) akan membuatkan sebuah "Kunci Rahasia" (Token Unik) yang sifatnya acak dan memiliki batas waktu kedaluwarsa. 
> Sistem kemudian merangkai Kunci Rahasia tersebut menjadi sebuah Link URL, dan menyuruh Server Pengirim Email asli milik Google (Google SMTP) untuk mengantarkan Link URL tersebut langsung ke alamat email tujuan pengguna.

**Di Mana Pengaturan dan Lokasi Kodenya Berada?**

1. **Jantung Pengaturan (Koneksi ke Google Gmail):**  
   Agar aplikasi kita diizinkan menyuruh Server Google, kita menaruh kredensial rahasia (Alamat Gmail kita dan *App Password* khusus dari Google) di dalam file inti aplikasi.  
   📍 File: `.env` (Cari tulisan `MAIL_HOST` dan `MAIL_USERNAME`)  
   💻 Kode: `MAIL_HOST=smtp.gmail.com`

2. **Otak Penggeraknya (Backend):**  
   Saat pengguna mengetikkan emailnya lalu menekan tombol "Kirim", data tersebut akan ditangkap oleh file pengontrol (Controller) ini. Controller inilah yang memanggil alat `Password::sendResetLink()` bawaan sistem Laravel untuk menciptakan Token unik lalu mengirimkan emailnya saat itu juga.  
   📍 File: `app/Http/Controllers/Auth/PasswordResetLinkController.php` (Baris 38)  
   💻 Kode: `$status = Password::sendResetLink($request->only('email'));`

---

# 🔥 BONUS: "Pertanyaan Jebakan" Asdos Saat Ujian & Jawabannya

## 1. "Gimana caranya membedakan Admin dan User biasa? Kenapa User biasa nggak bisa masuk halaman kelola artikel?"
**Jawab:** "Aplikasi ini menggunakan sistem **Role-Based Access Control (Kolom Role)** dan dijaga oleh satpam bernama **Middleware**."
- **Cara Kerja:** Di tabel `users`, kita punya kolom `role` (isinya 'admin' atau 'user'). Di file Pengatur Rute (Routes), rute khusus admin dibungkus menggunakan *Middleware*, sehingga siapa pun yang bukan admin akan langsung dicegat dan ditendang kembali ke halaman utama (Error 403 Forbidden).
- 📍 File Rute: `routes/web.php` (Cari pembungkus `Route::middleware(['auth', 'admin'])`)
- 📍 File Middleware: `bootstrap/app.php` (Atau Middleware khusus admin jika dibuat terpisah).
- 📍 File Tampilan: `resources/views/layouts/navigation.blade.php` (Kode `@if(auth()->user()->role === 'admin')` untuk menyembunyikan tombol dashboard).

## 2. "Gimana caranya Artikel Pengumuman bisa otomatis hilang dari beranda kalau sudah kadaluarsa?"
**Jawab:** "Kita tidak menggunakan sistem hapus otomatis, melainkan menggunakan logika **Penyaringan Database (Database Query Filter)** secara *Real-time*."
- **Cara Kerja:** Daripada repot membuat program yang jalan tiap hari untuk menghapus data, kita cukup menambahkan syarat (kondisi) saat web meminta data artikel ke database: *"Tolong tampilkan artikel yang kolom `expires_at`-nya kosong (selamanya), ATAU yang tanggal kadaluarsanya masih lebih besar dari waktu saat ini (`> now()`)."*
- 📍 File: `app/Http/Controllers/ArticleController.php` (Baris 24-25)
- 💻 Kode: `$q->whereNull('expires_at')->orWhere('expires_at', '>', now());`

## 3. "Website kamu aman nggak dari serangan Hacker yang ngirim kode jahat (XSS) di kolom komentar?"
**Jawab:** "100% Sangat Aman, Kak! Karena Laravel memiliki sistem perlindungan XSS bawaan yang canggih."
- **Cara Kerja:** Saat kami menampilkan teks komentar ke layar, kami menggunakan penulisan kurung kurawal ganda `{{ $comment->body }}`. Dengan penulisan ini, Laravel secara otomatis akan "mensterilkan" (Escape) semua script Javascript atau HTML jahat menjadi teks biasa, sehingga mustahil script tersebut meledak/dieksekusi oleh *browser*.
- 📍 File: `resources/views/articles/show.blade.php` 

## 4. "Kenapa link URL artikelnya nggak pakai nomor ID (contoh: `/artikel/5`), tapi pakai judul (contoh: `/artikel/lomba-17-an`)?"
**Jawab:** "Supaya website kita terlihat profesional dan bagus di mata Google (SEO Friendly). Teknik ini disebut **Slug Generation**."
- **Cara Kerja:** Saat admin mengetik judul artikel, *Controller* akan menggunakan alat bawaan Laravel yaitu `Str::slug()` untuk mengubah spasi menjadi tanda strip (`-`) dan menghilangkan huruf besar. Agar URL-nya tidak bentrok jika ada judul yang sama, kita menyisipkan angka *ID Artikel* atau *Time* di belakangnya.
- 📍 File: `app/Http/Controllers/AdminArticleController.php` (Baris 63 & 106)
- 💻 Kode: `'slug' => Str::slug($request->title) . '-' . time(),`

## 5. "Kamu pakai framework Laravel kan? Apa buktinya website ini terlindungi dari pemalsuan form (Serangan CSRF)?"
**Jawab:** "Buktinya ada di setiap formulir (Form Login, Komentar, Buat Artikel) kami, Kak."
- **Cara Kerja:** Di dalam setiap tag `<form>`, kami wajib menyisipkan token rahasia menggunakan sintaks `@csrf`. Token ini adalah kode unik yang dicocokkan antara server dan browser. Jika ada hacker yang mencoba membuat formulir palsu dari web lain, server akan menolaknya dengan error *419 Page Expired* karena token rahasianya tidak cocok!
- 📍 File: Semua file `.blade.php` yang memiliki formulir (Contoh: `resources/views/articles/show.blade.php`).
- 💻 Kode: `@csrf`