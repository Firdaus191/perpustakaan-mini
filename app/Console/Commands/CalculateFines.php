<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

#[Signature('app:calculate-fines')]
#[Description('Hitung denda secara massal untuk peminjaman yang terlambat')]
class CalculateFines extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai kalkulasi denda...');

        $hariIni = Carbon::now()->startOfDay();

        $peminjamanTerlambat = Peminjaman::where('status', 'dipinjam')
            ->whereDate('tanggal_kembali', '<', $hariIni)
            ->get();

        if ($peminjamanTerlambat->isEmpty()) {
            $this->warn('Tidak ada peminjaman yang terlambat hari ini.');
            return;
        }

        $this->info('Total data terlambat ditemukan: ' . $peminjamanTerlambat->count());

        $jumlahDiupdate = 0;

        DB::transaction(function () use ($peminjamanTerlambat, $hariIni, &$jumlahDiupdate) {
            foreach ($peminjamanTerlambat as $trx) {
                $jatuhTempo = Carbon::parse($trx->tanggal_kembali)->startOfDay();
                $telatHari = $jatuhTempo->diffInDays($hariIni);
                $denda = $telatHari * 2000;

                $trx->update(['denda' => $denda]);
                
                // Cek suspend/freeze user
                $user = $trx->anggota->user ?? null;
                if ($user && $user->status_akun !== 'frozen') {
                    if ($telatHari >= 30) {
                        $user->update(['status_akun' => 'frozen']);
                    } elseif ($telatHari > 7) {
                        $user->update(['status_akun' => 'suspended']);
                    }
                }
                
                $this->info("ID Peminjaman: {$trx->id} | Terlambat: {$telatHari} Hari | Nilai Denda Baru: {$denda}");
                
                $jumlahDiupdate++;
            }
        });

        $this->info("Kalkulasi selesai. Total {$jumlahDiupdate} transaksi denda diperbarui.");
    }
}
