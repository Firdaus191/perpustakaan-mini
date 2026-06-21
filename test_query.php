<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$anggota_id = 4; // Kurnia
$peminjamanTerlama = \App\Models\Peminjaman::where('anggota_id', $anggota_id)
    ->where('status', 'dipinjam')
    ->where('tanggal_kembali', '<', now()->toDateString())
    ->whereNull('bukti_pembayaran')
    ->orderBy('tanggal_kembali', 'asc')
    ->first();

if ($peminjamanTerlama) {
    $jatuhTempo = \Carbon\Carbon::parse($peminjamanTerlama->tanggal_kembali)->startOfDay();
    $hariTerlambat = (int) $jatuhTempo->diffInDays(now()->startOfDay());
    echo "Hari Terlambat (diffInDays): " . abs($hariTerlambat) . "\n";
}
