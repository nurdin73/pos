@php
    $settings = DB::table('stores')->select("*")->first();
@endphp
<table border="1">
    <thead>
        <tr>
            <th colspan="8">TOKO : {{ $settings->nama_toko ?? "Rittercoding" }}</th>
        </tr>
        <tr>
            <th colspan="8">No Telp : {{ $settings->no_telp ?? "0823-1231-2312" }}</th>
        </tr>
        <tr>
            <th colspan="8"></th>
        </tr>
        <tr>
            <th colspan="8">Report Product {{ date('d F Y') }}</th>
        </tr>
        <tr>
            <th colspan="8"></th>
        </tr>
        <tr>
            <th align="center" colspan="2">Nama Barang</th>
            <th align="center" colspan="2">Harga Dasar</th>
            <th align="center" colspan="2">Sisa Stok</th>
            <th align="center" colspan="2">Terjual</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $product)
        {{-- get stok --}}
        @php
            $stocks = 0;
            $harga_dasar = 0;
        @endphp
        @foreach ($product->stocks as $stok)
            @php
                $stocks += $stok->stok;
                $harga_dasar = $stok->harga_dasar;
            @endphp
        @endforeach
        <tr>
            <td align="center" colspan="2">{{ $product->nama_barang }}</td>
            <td align="center" colspan="2">Rp. {{ number_format($harga_dasar, 0,',','.') }}</td>
            <td align="center" colspan="2">{{ $stocks }}</td>
            <td align="center" colspan="2">{{ $product->selled }}</td>
        </tr>
        @endforeach
    </tbody>
</table>