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
            @php
                $totalTrx = 0;
                $totalModal = 0;
                $totalPembelian = 0;
            @endphp
            @foreach ($vals as $trx)
                @php
                    $totalPembelian += $trx->total
                @endphp
                @foreach ($trx->carts as $cart)
                    @php
                        $hargaDasar = 0;
                    @endphp
                    @foreach ($cart->product->stocks as $stock)
                        @php
                            $hargaDasar = $stock->harga_dasar;
                        @endphp
                    @endforeach
                    @php
                        $totalModal += $hargaDasar * $cart->qyt;
                    @endphp
                @endforeach
                @php
                    $totalTrx++;
                @endphp
            @endforeach
            <tr>
                <td align="center" colspan="2">{{ $transaction }}</td>
                <td align="center" colspan="2">{{ $totalTrx }}</td>
                <td align="center" colspan="2">{{ $totalPembelian }}</td>
                <td align="center" colspan="2">{{ $totalModal }}</td>
                <td align="center" colspan="2">{{ $totalPembelian - $totalModal }}</td>
            </tr>
        @endforeach
    </tbody>
</table>