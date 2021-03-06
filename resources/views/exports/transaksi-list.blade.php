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
            <th colspan="16">NPWP : {{ $settings->npwp ?? "-" }}</th>
        </tr>
        <tr>
            <th colspan="16">Alamat : {{ $settings->alamat ?? "Cirebon" }}</th>
        </tr>
        <tr>
            <th colspan="16"></th>
        </tr>
        <tr>
            <th colspan="16">Report Transaksi Tahun {{ $year }}</th>
        </tr>
        <tr>
            <th colspan="16"></th>
        </tr>
        <tr>
            <th align="center" colspan="3">No Invoice</th>
            <th align="center" colspan="2">Customer</th>
            <th align="center" colspan="2">Kasir</th>
            <th align="center" colspan="3">Tanggal Transaksi</th>
            <th align="center" colspan="2">Diskon</th>
            <th align="center" colspan="2">Sub Total</th>
            <th align="center" colspan="2">Total</th>
        </tr>
    </thead>
    <tbody>
        @if (count($transactions) > 0)
            @foreach ($transactions as $trx)
            <tr>
                <td align="center" colspan="3">{{ $trx->no_invoice }}</td>
                <td align="center" colspan="2">{{ $trx->customer != null ? $trx->customer->nama : "Umum" }}</td>
                <td align="center" colspan="2">{{ $trx->user->name ?? "Guest" }}</td>
                <td align="center" colspan="3">{{ date('d F Y', strtotime($trx->tgl_transaksi)) }}</td>
                <td align="center" colspan="2">Rp. {{ number_format($trx->diskon_transaksi, 0,',','.') }}</td>
                <td align="center" colspan="2">Rp. {{ number_format($trx->total + $trx->diskon_transaksi, 0,',','.') }}</td>
                <td align="center" colspan="2">Rp. {{ number_format($trx->total, 0,',','.') }}</td>
            </tr>
            @endforeach            
        @else
            <tr>
                <td align="center" colspan="16">Tidak ada transaksi di tahun {{ $year }}</td>
            </tr>
        @endif
    </tbody>
</table>