<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjamen';

    protected $fillable = [
        'anggota_id',
        'buku_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
        'denda',
        'bukti_pembayaran',
        'tanggal_dikembalikan',
        'status_denda'
    ];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }

    /**
     * Memperbarui denda secara dinamis untuk anggota tertentu
     * 
     * @param int $anggota_id
     */
    public static function updateDendaAnggota(int $anggota_id)
    {
        $hariIni = \Carbon\Carbon::now()->startOfDay();

        // Menghitung selisih hari secara langsung dan update massal tanpa perulangan PHP
        // PENTING: Hanya update record yang belum upload bukti pembayaran
        // Jangan timpa status 'menunggu_konfirmasi' atau 'lunas'
        self::where('anggota_id', $anggota_id)
            ->where('status', 'dipinjam')
            ->whereDate('tanggal_kembali', '<', $hariIni)
            ->whereIn('status_denda', ['tidak_ada', 'belum_bayar'])
            ->update([
                'denda' => \Illuminate\Support\Facades\DB::raw("DATEDIFF('" . $hariIni->toDateString() . "', tanggal_kembali) * 2000"),
                'status_denda' => 'belum_bayar'
            ]);
    }
}
