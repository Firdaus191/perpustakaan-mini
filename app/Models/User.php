<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Field yang boleh diisi massal
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * Field yang disembunyikan
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function booted(): void
    {
        // Email syncing to Anggota has been removed as users table is the single source of truth
    }

    public function anggota()
    {
        return $this->hasOne(Anggota::class);
    }

    /**
     * Mengecek status sanksi user berdasarkan keterlambatan pengembalian buku dan denda.
     * Mengembalikan array dengan key 'status' dan 'hari'.
     * status: 'active', 'suspended' (> 7 hari), 'frozen' (> 30 hari).
     */
    public function cekStatusSanksi()
    {
        if ($this->role === 'admin') {
            return ['status' => 'active', 'hari' => 0];
        }

        if (!$this->anggota) {
            return ['status' => 'active', 'hari' => 0];
        }

        // --- UPDATE DENDA DINAMIS SEBELUM PENGECEKAN ---
        // Karena fungsi ini dipanggil pada setiap request via Middleware,
        // denda user akan selalu update (real-time) di UI web.
        \App\Models\Peminjaman::updateDendaAnggota($this->anggota->id);

        // Cari tunggakan paling lama yang BENAR-BENAR belum dibayar.
        // Tidak peduli apakah buku masih dipinjam, menunggu pengembalian, atau sudah kembali.
        $tunggakanTerlama = \App\Models\Peminjaman::where('anggota_id', $this->anggota->id)
            ->whereIn('status_denda', ['belum_bayar', 'menunggu_konfirmasi'])
            ->where('denda', '>', 0)
            ->orderBy('tanggal_kembali', 'asc')
            ->first();

        if ($tunggakanTerlama) {
            $jatuhTempo = \Carbon\Carbon::parse($tunggakanTerlama->tanggal_kembali)->startOfDay();
            $hariTerlambat = (int) abs($jatuhTempo->diffInDays(now()->startOfDay()));
            
            // Jika sudah upload bukti tapi belum dikonfirmasi admin,
            // cegah user agar tidak dibekukan (logout paksa), cukup suspend saja
            // agar mereka masih bisa melihat pesan "Menunggu Verifikasi"
            if ($tunggakanTerlama->status_denda === 'menunggu_konfirmasi') {
                return ['status' => 'suspended', 'hari' => $hariTerlambat];
            }

            if ($hariTerlambat > 30) {
                return ['status' => 'frozen', 'hari' => $hariTerlambat];
            } elseif ($hariTerlambat > 7) {
                return ['status' => 'suspended', 'hari' => $hariTerlambat];
            }
        }

        return ['status' => 'active', 'hari' => 0];
    }
}
