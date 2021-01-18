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
            <th colspan="10">Report Pembelian Barang {{ date('d F Y') }}</th>
        </tr>
        <tr>
            <th colspan="10"></th>
        </tr>
        <tr>
            <th align="center" colspan="2">Kode Barang</th>
            <th align="center" colspan="2">Nama Barang</th>
            <th align="center" colspan="2">Tanggal Update</th>
            <th align="center" colspan="2">Stok Awal</th>
            <th align="center" colspan="2">Harga Dasar</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $product)
            @php
                $stock = 0;
                $hargaDasar = 0;
                $tglUpdate = "";
            @endphp
            @foreach ($product->stocks as $prodStock)
                @php
                    $stock += $prodStock->stok;
                    $hargaDasar = $prodStock->harga_dasar;
                    $tglExplode = explode(" ", $prodStock->created_at);
                    $tglUpdate = $tglExplode[0];
                @endphp
            @endforeach
            <tr>
                <td align="center" colspan="2">{{ $product->kode_barang }}</td>
                <td align="center" colspan="2">{{ $product->nama_barang }}</td>
                <td align="center" colspan="2">{{ date('d F Y', strtotime($tglUpdate)) }}</td>
                <td align="center" colspan="2">{{ $stock + $product->selled }}</td>
                <td align="center" colspan="2">{{ 'Rp. '. number_format($hargaDasar, 0,',','.') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>