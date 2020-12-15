<table border="1">
    <thead>
        <tr>
            <th>Nama Barang</th>
            <th>Harga Dasar</th>
            <th>Sisa Stok</th>
            <th>Terjual</th>
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
            <td>{{ $product->nama_barang }}</td>
            <td>Rp. {{ number_format($harga_dasar, 0,',','.') }}</td>
            <td>{{ $stocks }}</td>
            <td>{{ $product->selled }}</td>
        </tr>
        @endforeach
    </tbody>
</table>