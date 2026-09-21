<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Artikel's free-text `kategori` column becomes a proper FK to
     * kategori_artikels, so Reza can manage categories (and their
     * /artikel/kategori/{slug} pages) from Filament without touching code.
     * Existing distinct category strings are turned into KategoriArtikel
     * records and backfilled before the old column is dropped.
     */
    public function up(): void
    {
        Schema::table('artikels', function (Blueprint $table) {
            $table->foreignId('kategori_id')->nullable()->after('konten')->constrained('kategori_artikels')->nullOnDelete();
        });

        $distinctKategori = DB::table('artikels')
            ->whereNotNull('kategori')
            ->where('kategori', '!=', '')
            ->distinct()
            ->pluck('kategori');

        foreach ($distinctKategori as $nama) {
            $slug = Str::slug($nama);

            $kategoriId = DB::table('kategori_artikels')->where('slug', $slug)->value('id');

            if (! $kategoriId) {
                $kategoriId = DB::table('kategori_artikels')->insertGetId([
                    'nama' => $nama,
                    'slug' => $slug,
                    'urutan' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::table('artikels')->where('kategori', $nama)->update(['kategori_id' => $kategoriId]);
        }

        Schema::table('artikels', function (Blueprint $table) {
            $table->dropColumn('kategori');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('artikels', function (Blueprint $table) {
            $table->string('kategori')->nullable();
        });

        DB::table('artikels')->update([
            'kategori' => DB::raw('(select nama from kategori_artikels where kategori_artikels.id = artikels.kategori_id)'),
        ]);

        Schema::table('artikels', function (Blueprint $table) {
            $table->dropConstrainedForeignId('kategori_id');
        });
    }
};
