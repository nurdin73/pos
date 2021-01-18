@php
    $settings = DB::table('stores')->select("*")->first();
@endphp
<table>
    <thead>
        <tr>
            <th colspan="15">TOKO : {{ $settings->nama_toko ?? "Rittercoding" }}</th>
        </tr>
        <tr>
            <th colspan="15">No Telp : {{ $settings->no_telp ?? "0823-1231-2312" }}</th>
        </tr>
        <tr>
            <th colspan="15">NPWP : {{ $settings->npwp ?? "-" }}</th>
        </tr>
        <tr>
            <th colspan="15">Alamat : {{ $settings->alamat ?? "Cirebon" }}</th>
        </tr>
        <tr>
            <th colspan="15"></th>
        </tr>
        <tr>
            <th colspan="15">Report Kasbon Tahun {{ date('Y') }} Berdasarkan {{ $query }}</th>
        </tr>
        <tr>
            <th colspan="15"></th>
        </tr>
        <tr>
            <th colspan="15">Total Kasbon Keseluruhan {{ 'Rp. '. number_format($kasbon['totalKasbon'], 0,',','.') }}</th>
        </tr>
        <tr>
            <th colspan="15">Total Kasbon Terbayar {{ 'Rp. '. number_format($kasbon['totalDibayar'], 0,',','.') }}</th>
        </tr>
        <tr>
            <th colspan="15">Total Kasbon Belum Dibayar {{ 'Rp. '. number_format($kasbon['totalSisaKasbon'], 0,',','.') }}</th>
        </tr>
        <tr>
            <th colspan="15"></th>
        </tr>
        <tr>
            <th colspan="6">Bulan</th>
            <th colspan="3">Total Kasbon</th>
            <th align="center" colspan="3">Telah Dibayar</th>
            <th align="center" colspan="3">Belum Dibayar</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($kasbon['data'] as $bln => $data)
        @php
            $terbayar = 0;
            $sisa = 0;
            $total = 0;
        @endphp
        @foreach ($data as $d)
            @php
                $terbayar += $d['dibayar'];
                $sisa += $d['sisa'];
                $total += $d['jumlah'];
            @endphp
        @endforeach
        <tr>
            <td colspan="6">{{ $bln }}</td>
            <td colspan="3">{{ 'Rp. '. number_format($total, 0,',','.') }}</td>
            <td align="center" colspan="3">{{ 'Rp. '. number_format($terbayar, 0,',','.') }}</td>
            <td align="center" colspan="3">{{ "Rp. " . number_format($sisa, 0,',','.') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>