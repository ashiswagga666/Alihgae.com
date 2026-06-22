<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Tambah kolom ke companies
        Schema::table('companies', function (Blueprint $table) {
            if (!Schema::hasColumn('companies', 'address')) $table->string('address')->nullable();
            if (!Schema::hasColumn('companies', 'phone')) $table->string('phone')->nullable();
            if (!Schema::hasColumn('companies', 'email')) $table->string('email')->nullable();
            if (!Schema::hasColumn('companies', 'logo')) $table->string('logo')->nullable();
            if (!Schema::hasColumn('companies', 'city')) $table->string('city')->nullable()->default('Denpasar');
            if (!Schema::hasColumn('companies', 'employee_count')) $table->string('employee_count')->nullable();
            if (!Schema::hasColumn('companies', 'founded_year')) $table->integer('founded_year')->nullable();
        });

        // Tambah kolom ke lamarans
        Schema::table('lamarans', function (Blueprint $table) {
            if (!Schema::hasColumn('lamarans', 'cv_path')) $table->string('cv_path')->nullable();
            if (!Schema::hasColumn('lamarans', 'surat_pengantar_path')) $table->string('surat_pengantar_path')->nullable();
            if (!Schema::hasColumn('lamarans', 'portofolio_path')) $table->string('portofolio_path')->nullable();
            if (!Schema::hasColumn('lamarans', 'nama_lowongan')) $table->string('nama_lowongan')->nullable();
            if (!Schema::hasColumn('lamarans', 'nama_perusahaan')) $table->string('nama_perusahaan')->nullable();
        });

        // Tambah kolom ke job_seeker_profiles
        Schema::table('job_seeker_profiles', function (Blueprint $table) {
            if (!Schema::hasColumn('job_seeker_profiles', 'photo')) $table->string('photo')->nullable();
            if (!Schema::hasColumn('job_seeker_profiles', 'about')) $table->text('about')->nullable();
            if (!Schema::hasColumn('job_seeker_profiles', 'desired_position')) $table->string('desired_position')->nullable();
            if (!Schema::hasColumn('job_seeker_profiles', 'surat_pengantar_path')) $table->string('surat_pengantar_path')->nullable();
        });

        // Tabel berita
        if (!Schema::hasTable('berita')) {
            Schema::create('berita', function (Blueprint $table) {
                $table->id();
                $table->string('judul');
                $table->string('slug')->unique();
                $table->text('konten');
                $table->string('thumbnail')->nullable();
                $table->string('kategori')->default('umum');
                $table->enum('status', ['draft', 'published', 'pending'])->default('draft');
                $table->unsignedBigInteger('author_id');
                $table->unsignedBigInteger('company_id')->nullable(); // kalau dari perusahaan
                $table->decimal('harga_sponsor', 10, 2)->nullable(); // nominal sponsor
                $table->boolean('is_sponsored')->default(false);
                $table->timestamp('published_at')->nullable();
                $table->integer('views')->default(0);
                $table->timestamps();
            });
        }

        // Tabel pengaturan situs
        if (!Schema::hasTable('site_settings')) {
            Schema::create('site_settings', function (Blueprint $table) {
                $table->id();
                $table->string('key')->unique();
                $table->text('value')->nullable();
                $table->timestamps();
            });
        }

        // Tabel request berita sponsor dari perusahaan
        if (!Schema::hasTable('berita_requests')) {
            Schema::create('berita_requests', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('company_id');
                $table->string('judul');
                $table->text('konten');
                $table->string('thumbnail')->nullable();
                $table->decimal('nominal', 10, 2)->default(500000);
                $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
                $table->text('catatan_admin')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void {}
};
