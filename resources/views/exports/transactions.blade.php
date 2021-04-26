@php
    $settings = DB::table('stores')->select("*")->first();
@endphp
<table>
    <tbody>
        <tr>
            <th colspan="10">TOKO : {{ $settings->nama_toko ?? "Rittercoding" }}</th>
        </tr>
        <tr>
            <th colspan="10">No Telp : {{ $settings->no_telp ?? "0823-1231-2312" }}</th>
        </tr>
        <tr>
            <th colspan="8">NPWP : {{ $settings->npwp ?? "-" }}</th>
        </tr>
        <tr>
            <th colspan="8">Alamat : {{ $settings->alamat ?? "Cirebon" }}</th>
        </tr>
        <tr>
            <th colspan="10">Report Transaksi {{ date('d F Y') }}</th>
        </tr>
        <tr>
            <th colspan="10"></th>
        </tr>
        <tr>
            <th align="center" colspan="2">Waktu</th>
            <th align="center" colspan="2">Total Transaksi</th>
            <th align="center" colspan="2">Total Pendapatan</th>
            <th align="center" colspan="2">Total Modal</th>
            <th align="center" colspan="2">Total Keuntungan</th>
        </tr>
        @foreach ($transactions as $transaction => $vals)
            <tr>
                <td align="center" colspan="2">{{ $transaction }}</td>
                <td align="center" colspan="2">{{ number_format($vals['totalTrx']) }}</td>
                <td align="center" colspan="2">Rp. {{ number_format($vals['totalPendapatan'], 2, ',', '.') }}</td>
                <td align="center" colspan="2">Rp. {{ number_format($vals['totalModal'], 2, ',', '.') }}</td>
                <td align="center" colspan="2">Rp. {{ number_format($vals['totalKeuntungan'], 2, ',', '.') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>