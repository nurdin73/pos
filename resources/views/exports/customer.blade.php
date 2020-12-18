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
            <th colspan="16">Report Customers : {{ date('d F Y') }}</th>
        </tr>
        <tr>
            <th colspan="16"></th>
        </tr>
        <tr>
            <th colspan="16">Total Pelanggan {{ $customers['total'] }}</th>
        </tr>
        <tr>
            <th colspan="16">Total Pelanggan Kemarin {{ $customers['totalCustYesterday'] }}</th>
        </tr>
        <tr>
            <th colspan="16">Total Pelanggan Hari ini {{ $customers['totalCustNow'] }}</th>
        </tr>
        <tr>
            <th colspan="16"></th>
        </tr>
        <tr>
            <th colspan="2">NIK</th>
            <th colspan="2">Nama</th>
            <th align="center" colspan="2">Email</th>
            <th align="center" colspan="2">Point</th>
            <th align="center" colspan="2">No Telp</th>
            <th align="center" colspan="6">Alamat</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($customers['data'] as $customer)
        <tr>
            <td colspan="2">{{ $customer->nik }}</td>
            <td colspan="2">{{ $customer->nama }}</td>
            <td align="center" colspan="2">{{ $customer->email ?? "-" }}</td>
            <td align="center" colspan="2">{{ $customer->point }}</td>
            <td align="center" colspan="2">{{ $customer->no_telp }}</td>
            <td align="center" colspan="6">{{ $customer->alamat }}</td>
        </tr>
        @endforeach
    </tbody>
</table>