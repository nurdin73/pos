@php
    $settings = DB::table('stores')->select("*")->first();
    $i = 1;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Invoice {{ $transactions->no_invoice }}</title>
</head>
<body>
  <table style="width: 100%">
    <thead>
      <tr>
        <th style="text-align: left;">Toko</th>
        <th style="text-align: right;">Transaksi</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td style="text-align: left;">{{ $settings->nama_toko ?? "RitterCoding" }}</td>
        <td style="text-align: right;">{{ $transactions->no_invoice }}</td>
      </tr>
      <tr>
        <td style="text-align: left;">{{ $settings->no_telp ?? "0834-2333-1111"}}</td>
        <td style="text-align: right;">{{ $transactions->tgl_transaksi ?? date('Y-m-d') }}</td>
      </tr>
      <tr>
        <td style="text-align: left;">NPWP : {{ $settings->npwp ?? "11.222.334.4-556.676" }}</td>
        <td style="text-align: right;">Rp. {{ number_format($transactions->total, 0, ',', '.') }}</td>
      </tr>
      <tr>
        <td style="text-align: left;" colspan="2">{{ $settings->alamat ?? "-" }}</td>
      </tr>
    </tbody>
  </table>
  <hr>
  <table style="width: 100%">
    <thead style="background-color: rgb(36, 34, 160); color: #fff;">
      <tr>
        <th style="width: 5%">#</th>
        <th style="width: 25%">Items</th>
        <th style="width: 5%">Qyt</th>
        <th style="width: 17%">Harga</th>
        <th style="width: 17%">Diskon</th>
        <th style="width: 17%">Total</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($transactions->carts as $cart)
        <tr>
          <td style="text-align: center">{{ $i++ }}</td>
          <td style="text-align: left">{{ $cart->product->nama_barang }}</td>
          <td style="text-align: center">{{ $cart->qyt }}</td>
          <td style="text-align: right">Rp. {{ number_format($cart->harga_product, 0, ',', '.') }}</td>
          <td style="text-align: right">Rp. {{ number_format($cart->diskon_product, 0, ',', '.') }}</td>
          <td style="text-align: right">Rp. {{ number_format($cart->harga_product - $cart->diskon_product, 0, ',', '.') }}</td>
        </tr>
      @endforeach
      <tr>
        <td colspan="6" style="padding: 10px;"></td>
      </tr>
      <tr>
        <th colspan="5" style="text-align: right;">Sub Total</th>
        <td style="text-align: right;">Rp. {{ number_format($transactions->total + $transactions->diskon_transaksi, 0, ',', '.') }}</td>
      </tr>
      <tr>
        <th colspan="5" style="text-align: right;">Diskon</th>
        <td style="text-align: right;">Rp. {{ number_format($transactions->diskon, 0, ',', '.') }}</td>
      </tr>
      <tr>
        <th colspan="5" style="text-align: right;">Pajak</th>
        <td style="text-align: right;">Rp. {{ number_format($transactions->pajak, 0, ',', '.') }}</td>
      </tr>
      <tr>
        <th colspan="5" style="text-align: right;">Total</th>
        <td style="text-align: right;">Rp. {{ number_format($transactions->total, 0, ',', '.') }}</td>
      </tr>
    </tbody>
  </table>
</body>
</html>