<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    // Dashboard User
    public function dashboard()
    {
        $anggota = Auth::user()->anggota;

        $dipinjamCount = 0;
        $jatuhTempoTerdekat = null;
        $totalDibaca = 0;
        $totalTagihanDenda = 0;
        $menungguKonfirmasi = false;
        $peminjamanAktif = collect();

        if ($anggota) {
            // Update denda secara real-time sebelum query dashboard
            Peminjaman::updateDendaAnggota($anggota->id);

            $dipinjamCount = Peminjaman::where('anggota_id', $anggota->id)
                ->whereIn('status', ['booking', 'dipinjam'])
                ->count();

            $peminjamanAktif = Peminjaman::with('buku')
                ->where('anggota_id', $anggota->id)
                ->where(function ($q) {
                    $q->whereIn('status', ['booking', 'dipinjam', 'menunggu_pengembalian'])
                        ->orWhere(function ($sub) {
                            $sub->where('status', 'kembali')
                                ->where('denda', '>', 0);
                        });
                })
                ->orderBy('tanggal_kembali', 'asc')
                ->get();

            $jatuhTempoTerdekat = Peminjaman::where('anggota_id', $anggota->id)
                ->where('status', 'dipinjam')
                ->orderBy('tanggal_kembali', 'asc')
                ->value('tanggal_kembali');

            $totalDibaca = Peminjaman::where('anggota_id', $anggota->id)
                ->where('status', 'kembali')
                ->count();

            // Calculate total tagihan denda
            $totalTagihanDenda = Peminjaman::where('anggota_id', $anggota->id)
                ->whereIn('status', ['dipinjam', 'menunggu_pengembalian', 'kembali'])
                ->whereIn('status_denda', ['belum_bayar', 'menunggu_konfirmasi'])
                ->sum('denda');

            $menungguKonfirmasi = Peminjaman::where('anggota_id', $anggota->id)
                ->where('status_denda', 'menunggu_konfirmasi')
                ->exists();
        }

        $dikecualikan = [];
        if ($anggota) {
            $dikecualikan = Peminjaman::where('anggota_id', $anggota->id)
                ->whereIn('status', ['booking', 'dipinjam'])
                ->pluck('buku_id')
                ->toArray();
        }

        $rekomendasiBuku = Buku::whereNotIn('id', $dikecualikan)
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('user.dashboard', compact(
            'dipinjamCount',
            'jatuhTempoTerdekat',
            'totalTagihanDenda',
            'peminjamanAktif',
            'rekomendasiBuku',
            'menungguKonfirmasi'
        ));
    }

    // Daftar Buku
    public function buku()
    {
        $buku = Buku::with('kategori')->when(request('search'), function ($query) {
            $query->where('judul', 'like', '%' . request('search') . '%');
        })->paginate(12);

        // Cari data anggota berdasarkan user login
        $anggota = Auth::user()->anggota;

        $dipinjam = [];

        if ($anggota) {

            $dipinjam = Peminjaman::where(
                'anggota_id',
                $anggota->id
            )
                ->whereIn('status', ['booking', 'dipinjam'])
                ->pluck('buku_id')
                ->toArray();
        }

        if (request()->ajax()) {
            $html = '';
            foreach ($buku as $index => $item) {
                $no = $buku->firstItem() + $index;
                $coverUrl = $item->cover_image ? (\Illuminate\Support\Str::startsWith($item->cover_image, ['http://', 'https://']) ? $item->cover_image : asset('storage/covers/' . $item->cover_image)) : '';

                $coverHtml = $coverUrl
                    ? '<img src="' . $coverUrl . '" alt="Cover" style="width: 48px; height: 64px; object-fit: cover;" class="w-12 h-16 object-cover rounded shadow-sm">'
                    : '<div style="width: 48px; height: 64px; background: #e2e8f0; display:flex; align-items:center; justify-content:center;" class="rounded shadow-sm text-xs text-gray-500">No Cover</div>';

                if (in_array($item->id, $dipinjam)) {
                    $aksiHtml = '<button class="btn btn-secondary btn-sm" disabled>Sedang Dipinjam</button>';
                } else {
                    $aksiHtml = '<form action="' . route('user.pinjam', $item->id) . '" method="POST" class="d-inline">' . csrf_field() . '<button type="submit" class="btn btn-primary btn-sm">Pinjam</button></form>';
                }

                $html .= '<tr>';
                $html .= '<td>' . $no . '</td>';
                $html .= '<td>' . $coverHtml . '</td>';
                $html .= '<td>' . $item->kode_buku . '</td>';
                $html .= '<td>' . $item->judul . '</td>';
                $html .= '<td>' . $item->penulis . '</td>';
                $html .= '<td>' . $item->stok . '</td>';
                $html .= '<td>' . $aksiHtml . '</td>';
                $html .= '</tr>';
            }

            if ($buku->isEmpty()) {
                $html .= '<tr><td colspan="7" class="text-center">Buku tidak ditemukan</td></tr>';
            }

            return response()->json([
                'html' => $html,
                'pagination' => (string) $buku->links()
            ]);
        }

        return view(
            'user.buku',
            compact('buku', 'dipinjam')
        );
    }


    // Riwayat Peminjaman
    public function riwayat()
    {
        // Cari anggota berdasarkan user login
        $anggota = Auth::user()->anggota;

        if (!$anggota) {

            return back()->with(
                'error',
                'Data anggota tidak ditemukan.'
            );
        }

        // Ambil riwayat peminjaman
        $riwayat = Peminjaman::with('buku')
            ->where('anggota_id', $anggota->id)
            ->orderBy('id', 'desc')
            ->get();

        return view(
            'user.riwayat',
            compact('riwayat')
        );
    }

    // Proses Pinjam Buku
    public function pinjam(int $id)
    {
        // Cari anggota berdasarkan user login
        $anggota = Auth::user()->anggota;

        if (!$anggota) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json(['error' => 'Data anggota tidak ditemukan.'], 404);
            }
            return back()->with(
                'error',
                'Data anggota tidak ditemukan.'
            );
        }

        // Cek status sanksi dinamis
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $statusSanksi = $user->cekStatusSanksi();

        if ($statusSanksi['status'] === 'frozen') {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json(['error' => 'Akun Anda dibekukan karena keterlambatan lebih dari 30 hari. Silakan lunasi pembayaran tagihan denda secara manual dan offline di Library Office!'], 403);
            }
            return back()->with('error', 'Akun Anda dibekukan karena keterlambatan lebih dari 30 hari. Silakan lunasi pembayaran tagihan denda secara manual dan offline di Library Office!');
        } elseif ($statusSanksi['status'] === 'suspended') {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json(['error' => 'Peminjaman ditolak! Anda memiliki buku yang terlambat dikembalikan lebih dari 7 hari dan denda belum dibayar.'], 403);
            }
            return back()->with('error', 'Peminjaman ditolak! Anda memiliki buku yang terlambat dikembalikan lebih dari 7 hari dan denda belum dibayar.');
        }

        try {
            DB::transaction(function () use ($id, $anggota) {
                // Cari buku dan lock baris tersebut untuk update
                $buku = Buku::where('id', $id)->lockForUpdate()->firstOrFail();

                // Cek stok secara atomic
                if ($buku->stok <= 0) {
                    throw new \Exception('Stok buku habis.');
                }

                // Cek apakah user masih meminjam atau booking buku yang sama
                $cek = Peminjaman::where('anggota_id', $anggota->id)
                    ->where('buku_id', $buku->id)
                    ->whereIn('status', ['booking', 'dipinjam'])
                    ->first();

                if ($cek) {
                    throw new \Exception('Anda masih meminjam buku ini.');
                }

                // Kurangi stok (reservasi)
                $buku->stok -= 1;
                if ($buku->stok <= 0) {
                    $buku->status = 'dipinjam'; // atau bisa dibiarkan 'tersedia' karena logic cek stok di atas
                }
                $buku->save();

                // Simpan data peminjaman
                Peminjaman::create([
                    'anggota_id'      => $anggota->id,
                    'buku_id'         => $buku->id,
                    'tanggal_pinjam'  => now()->toDateString(),
                    'tanggal_kembali' => now()->addDays(7)->toDateString(),
                    'status'          => 'booking',
                ]);
            });

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json(['success' => 'Buku berhasil di-booking.']);
            }
            return redirect('/Perpustakaan/riwayat')->with('success', 'Buku berhasil di-booking. Silakan ambil di perpustakaan.');
        } catch (\Exception $e) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json(['error' => $e->getMessage()], 400);
            }
            return back()->with('error', $e->getMessage());
        }
    }

    // Proses Kembalikan Buku
    public function kembalikan(int $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status == 'dipinjam') {

            $peminjaman->update([
                'status' => 'menunggu_pengembalian'
            ]);
        }

        return back()->with(
            'success',
            'Permintaan pengembalian dikirim, menunggu admin.'
        );
    }

    // Proses Bayar Denda
    public function bayarDenda(\App\Http\Requests\BayarDendaRequest $request)
    {
        $anggota = Auth::user()->anggota;

        if (!$anggota) {
            return back()->with('error', 'Data anggota tidak ditemukan.');
        }

        // Cek apakah ada buku terlambat yang masih dibawa pengguna (berstatus 'dipinjam')
        $bukuMasihDipinjam = Peminjaman::where('anggota_id', $anggota->id)
            ->where('status', 'dipinjam')
            ->where('denda', '>', 0)
            ->whereIn('status_denda', ['belum_bayar', 'menunggu_konfirmasi'])
            ->exists();

        if ($bukuMasihDipinjam) {
            return back()->with('error', 'Pembayaran ditolak! Anda harus mengembalikan buku yang terlambat terlebih dahulu (klik tombol "Kembalikan Buku") sebelum membayar denda agar nominal denda berhenti bertambah.');
        }

        // Cari peminjaman yang terlambat/didenda dan belum lunas (hanya yang sudah dikembalikan/menunggu pengembalian)
        $peminjaman = Peminjaman::where('anggota_id', $anggota->id)
            ->whereIn('status', ['menunggu_pengembalian', 'kembali'])
            ->where('denda', '>', 0)
            ->whereIn('status_denda', ['belum_bayar', 'menunggu_konfirmasi'])
            ->get();

        if ($peminjaman->isEmpty()) {
            return back()->with('error', 'Tidak ada denda yang perlu dibayar.');
        }

        try {
            if (!$request->hasFile('bukti_pembayaran')) {
                return back()->with('error', 'Silakan pilih file bukti pembayaran terlebih dahulu.');
            }

            \Illuminate\Support\Facades\DB::beginTransaction();

            $file = $request->file('bukti_pembayaran');
            $filename = time() . '_bukti_' . $file->hashName();
            $file->storeAs('bukti', $filename, 'public');

            foreach ($peminjaman as $trx) {
                // Update bukti pembayaran dan status denda
                $trx->update([
                    'bukti_pembayaran' => $filename,
                    'status_denda' => 'menunggu_konfirmasi'
                ]);
            }

            \Illuminate\Support\Facades\DB::commit();

            return back()->with('success', 'Bukti pembayaran berhasil diunggah. Menunggu verifikasi admin.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return back()->with('error', 'Gagal mengunggah bukti pembayaran: ' . $e->getMessage());
        }
    }
}
