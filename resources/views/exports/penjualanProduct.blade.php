@php
    $settings = DB::table('stores')->select("*")->first();
@endphp
<table>
    <thead>
        <tr>
            <th colspan="8">TOKO : {{ $settings->nama_toko ?? "Rittercoding" }}</th>
        </tr>
        <tr>
            <th colspan="8">No Telp : {{ $settings->no_telp ?? "0823-1231-2312" }}</th>
        </tr>
        <tr>
            <th colspan="8">NPWP : {{ $settings->npwp ?? "-" }}</th>
        </tr>
        <tr>
            <th colspan="8">Alamat : {{ $settings->alamat ?? "Cirebon" }}</th>
        </tr>
        <tr>
            <th colspan="8"></th>
        </tr>
        <tr>
            <th colspan="8">{{ "Data Penjualan Tahun : ". date('Y') }}</th>
        </tr>
        <tr>
            <th colspan="8"></th>
        </tr>
        <tr>
            <th align="center" colspan="2">Bulan</th>
            <th align="center" colspan="2">Modal</th>
            <th align="center" colspan="2">Pendapatan</th>
            <th align="center" colspan="2">Keuntungan</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $product => $vals)
            @php
                $modal = 0;
                $pendapatan = 0;
                $keuntungan = 0;
            @endphp
            @foreach ($vals as $v)
                @php
                    $modal += $v['modal'];
                    $pendapatan += $v['pendapatan'];
                    $keuntungan += $v['keuntungan'];
                @endphp
            @endforeach
            <tr>
                <td align="center" colspan="2">{{ $product }}</td>
                <td align="center" colspan="2">{{ $modal }}</td>
                <td align="center" colspan="2">{{ $pendapatan }}</td>
                <td align="center" colspan="2">{{ $keuntungan }}</td>
            </tr>
        @endforeach
    </tbody>
</table>