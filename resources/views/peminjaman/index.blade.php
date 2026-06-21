@extends('layout.layout')

@section('title', 'Data Peminjaman')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Data Peminjaman</h4>

                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
                @endif

                <div class="d-flex justify-content-end mb-3">

                    <a href="{{ route('peminjaman.create') }}" class="btn btn-primary btn-sm">

                        + Tambah Peminjaman

                    </a>

                </div>

                <div class="table-responsive">

                    <table id="tabelPeminjaman" class="table table-striped table-bordered">

                        <thead>

                            <tr>

                                <th>No</th>

                                <th>Anggota</th>

                                <th>Buku</th>

                                <th>Tanggal Pinjam</th>

                                <th>Tanggal Kembali</th>

                                <th>Status</th>

                                <th>Aksi</th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($peminjaman as $index => $item)

                            <tr>

                                <td>{{ $index + 1 }}</td>

                                <td>

                                    {{ $item->anggota->kode_anggota }}

                                    <br>

                                    {{ $item->anggota->nama }}

                                </td>

                                <td>

                                    {{ $item->buku->kode_buku }}

                                    <br>

                                    {{ $item->buku->judul }}

                                </td>

                                <td>

                                    {{ $item->tanggal_pinjam }}

                                </td>

                                <td>

                                    {{ $item->tanggal_kembali }}

                                </td>

                                <td>

                                    @if($item->status == 'booking')
                                    <span class="badge badge-warning">Booking</span>
                                    @elseif($item->status == 'dipinjam')
                                    <span class="badge badge-primary">Dipinjam</span>
                                    @elseif($item->status == 'menunggu_pengembalian')
                                    <span class="badge badge-danger">Menunggu Pengembalian</span>
                                    @elseif($item->status == 'kembali')
                                    <span class="badge badge-success">Dikembalikan</span>
                                    @endif

                                    @if($item->status_denda == 'belum_bayar')
                                    <br><span class="badge badge-danger mt-1">Belum Bayar (Rp {{ number_format($item->denda, 0, ',', '.') }})</span>
                                    @elseif($item->status_denda == 'menunggu_konfirmasi')
                                    <br><span class="badge badge-warning mt-1">Menunggu Konfirmasi Denda</span>
                                    @elseif($item->status_denda == 'lunas')
                                    <br><span class="badge badge-success mt-1">Denda Lunas</span>
                                    @endif

                                    @if($item->bukti_pembayaran != null)
                                    <button type="button" class="btn btn-info btn-sm mt-1" data-toggle="modal" data-target="#modalBuktiAdmin{{ $item->id }}">Lihat Bukti</button>
                                    @endif

                                </td>

                                <td>

                                    @if($item->status == 'booking')
                                    <form action="{{ route('peminjaman.validasi', $item->id) }}" method="POST" class="d-inline form-konfirmasi">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm">Validasi</button>
                                    </form>
                                    @endif

                                    @if($item->bukti_pembayaran && $item->status_denda == 'menunggu_konfirmasi')
                                    <button
                                        data-image="{{ asset('storage/bukti/' . $item->bukti_pembayaran) }}"
                                        data-action="{{ route('peminjaman.verifikasi', $item->id) }}"
                                        data-tolak="{{ route('peminjaman.tolak', $item->id) }}"
                                        onclick="openVerifikasiModal(this.getAttribute('data-image'), this.getAttribute('data-action'), this.getAttribute('data-tolak'))"
                                        class="btn btn-warning btn-sm text-dark font-weight-bold"><i class="fa fa-exclamation-circle"></i> Verifikasi Bukti</button>
                                    @endif

                                    <a href="{{ route('peminjaman.edit',$item->id) }}"
                                        class="btn btn-success btn-sm">
                                        Edit
                                    </a>

                                </td>

                            </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>
        </div>
    </div>
</div>

@foreach($peminjaman as $item)
@if($item->bukti_pembayaran != null)
<!-- Modal Bukti Admin -->
<div class="modal fade" id="modalBuktiAdmin{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="modalBuktiAdminLabel{{ $item->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header no-print">
                <h5 class="modal-title" id="modalBuktiAdminLabel{{ $item->id }}">Bukti Pembayaran Denda</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <h3 class="mb-3 d-none d-print-block text-dark">Struk Pembayaran Denda Perpus</h3>
                <img src="{{ asset('storage/bukti/' . $item->bukti_pembayaran) }}" alt="Bukti Pembayaran" style="max-width: 100%; height: auto; border-radius: 8px;">
            </div>
            <div class="modal-footer no-print">
                <button type="button" class="btn btn-primary" onclick="printModal('modalBuktiAdmin{{ $item->id }}')"><i class="fa fa-print"></i> Cetak Struk</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endif
@endforeach

<div id="modalVerifikasi" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.6); align-items: center; justify-content: center;">
    <div style="background-color: #1E293B; margin: auto; padding: 20px; border: 1px solid #334155; width: 90%; max-width: 500px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.3);">
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #334155; padding-bottom: 10px; margin-bottom: 15px;">
            <h4 style="color: #F8FAFC; margin: 0;">Verifikasi Bukti Pembayaran</h4>
            <span onclick="closeVerifikasiModal()" style="color: #94A3B8; font-size: 24px; font-weight: bold; cursor: pointer;">&times;</span>
        </div>
        <div style="text-align: center; margin-bottom: 15px;">
            <img id="buktiImage" src="" alt="Bukti Pembayaran" style="max-width: 100%; max-height: 300px; border-radius: 4px; border: 1px solid #334155;">
            <a id="buktiLink" href="" target="_blank" style="display: block; margin-top: 10px; color: #3B82F6;">Buka Gambar Penuh / PDF</a>
        </div>
        <div style="text-align: right; margin-top: 20px; display: flex; justify-content: flex-end; gap: 10px;">
            <button type="button" onclick="closeVerifikasiModal()" class="btn btn-secondary">Batal</button>
            <form id="formTolak" action="" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="btn btn-danger">Tolak Pembayaran</button>
            </form>
            <form id="formVerifikasi" action="" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="btn btn-success">Setujui Pembayaran</button>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')

<script>
    $(document).ready(function() {
        $('#tabelPeminjaman').DataTable();
    });

    function openVerifikasiModal(imageUrl, formActionUrl, formTolakUrl) {
        document.getElementById('modalVerifikasi').style.display = 'flex';
        document.getElementById('buktiImage').src = imageUrl;
        document.getElementById('buktiLink').href = imageUrl;
        document.getElementById('formVerifikasi').action = formActionUrl;
        if (document.getElementById('formTolak')) {
            document.getElementById('formTolak').action = formTolakUrl;
        }
    }

    function closeVerifikasiModal() {
        document.getElementById('modalVerifikasi').style.display = 'none';
        document.getElementById('buktiImage').src = '';
        document.getElementById('buktiLink').href = '';
        document.getElementById('formVerifikasi').action = '';
    }
</script>

@endsection