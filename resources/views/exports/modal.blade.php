@php
    $settings = DB::table('stores')->select("*")->first();
@endphp
<table>
    <thead>
        <tr>
            <th colspan="16">TOKO : {{ $settings->nama_toko ?? "Rittercoding" }}</th>
        </tr>
        <tr>
            <th colspan="16">No Telp : {{ $settings->no_telp ?? "0823-1231-2312" }}</th>
        </tr>
        <tr>
            <th colspan="16"></th>
        </tr>
        <tr>
            <th colspan="16">Report Modal {{ date('d F Y') }}</th>
        </tr>
        <tr>
            <th colspan="16"></th>
        </tr>
        <tr>
            <th colspan="16">Sisa Modal Keseluruhan {{ 'Rp. '. number_format($modals['total_modal'], 0,',','.') }}</th>
        </tr>
        <tr>
            <th colspan="16"></th>
        </tr>
        <tr>
            <th colspan="5">Nama Barang</th>
            <th align="center" colspan="2">Stok</th>
            <th align="center" colspan="3">Terakhir Update</th>
            <th align="center" colspan="3">Harga Dasar</th>
            <th align="center" colspan="3">Sisa Modal</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($modals['modal'] as $modal)
            @php
                $totalModal = $modal->stok * $modal->harga_dasar;
                $tgl = explode(" ", $modal->tgl_update)[0];
            @endphp
            <tr>
                <td colspan="5">{{ $modal->product->nama_barang ?? "tidak ada nama" }}</td>
                <td align="center" colspan="2">{{ $modal->stok }}</td>
                <td align="center" colspan="3">{{ date('d F Y', strtotime($tgl)) }}</td>
                <td align="center" colspan="3">{{ 'Rp. ' . number_format($modal->harga_dasar, 0,',','.') }}</td>
                <td align="center" colspan="3">{{ 'Rp. ' . number_format($totalModal, 0,',','.') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>