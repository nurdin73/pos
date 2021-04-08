@extends('layouts.template')
@section('content')
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="row">
          <div class="col-md-8">
            <div class="card">
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th style="width:5%">No.</th>
                        <th style="width: 15%">Nama barang</th>
                        <th style="width: 17%">Harga</th>
                        <th style="width: 10%">Qyt</th>
                        <th style="width: 8%">Eceran</th>
                        <th style="width: 15%">Total</th>
                      </tr>
                    </thead>
                    <tbody id="listCarts">
    
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                  <span class="text-muted">Invoice</span>
                  <span class="font-weight-bold" id="noInvoice"></span>
                </div>
                <div class="dropdown-divider"></div>
                <div class="d-flex justify-content-end align-items-end">
                  <span class="font-weight-bold" style="font-size: 30px" id="subTotalBadge">Rp. 0</span>
                </div>
                <div class="dropdown-divider"></div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection


@section('js')
  <script src="{{ asset('js/jquery-validate.js') }}" ></script>
  <script src="{{ asset('js/select2.js') }}"></script>
  <script src="{{ asset('js/additional-method.js') }}"></script>
  <script src="{{ asset('js/message_id.js') }}" integrity="sha512-Pb0klMWnom+fUBpq+8ncvrvozi/TDwdAbzbICN8EBoaVXZo00q6tgWk+6k6Pd+cezWRwyu2cB+XvVamRsbbtBA==" crossorigin="anonymous"></script>
  <script src="{{ asset('js/sweetalert.js') }}"></script>
  <script>
    const URL_API = '{{ url('api/v1') }}'
    const name = '{{ auth()->user()->name }}'
    const idUserInput = '{{ auth()->user()->id }}'
    const noInvoice = '{{ $no_invoice }}'
    const persentasePajak = '{{ $tax->persentasePajak ?? 0 }}'
    const persentaseLayanan = '{{ $tax->persentaseLayanan ?? 0 }}'
    const namaPajak = '{{ $tax->nama_pajak ?? "PPN" }}'
    const hargaBarangPajak = '{{ $tax->hargaBarang ?? 0 }}'
    const pajakAktif = '{{ $tax->pajakAktif ?? 0 }}'
    const layananAktif = '{{ $tax->layananAktif ?? 0 }}'
    const urlCetakStruk = '{{ route('cetakStruk') }}'
  </script>
  <script src="{{ asset('js/managements/transaksi/index-v2.js') }}"></script>
@endsection