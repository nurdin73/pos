@extends('layouts.template')
@section('content')
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="desktop">
          <div class="alert alert-info" role="alert">
            <h4 class="alert-heading">Keyboard ShortCut</h4>
            <ul class="list-unstyled">
              <li><strong>CTRL + Y</strong> Tambah barang</li>
              <li><strong>CTRL + B</strong> Diskon transaksi</li>
              <li><strong>CTRL + M</strong> untuk memilih member jika ada</li>
              <li><strong>CTRL + ENTER</strong> proses transaksi</li>
            </ul>  
          </div>
          <div class="row">
            <div class="col-md-7">
              <div class="card">
                <div class="card-body">
                  <input class="form-control" id="barcode" type="text" name="barcode" placeholder="barcode" autofocus>
                  <div class="dropdown-divider"></div>
                  <div class="table-responsive">
                    <table class="table table-borderless table-striped">
                      <thead>
                        <tr>
                          <th class="text-center" style="width: 10%">No</th>
                          <th>Nama Barang</th>
                          <th class="text-center" style="width: 25%">Harga/Qty</th>
                          <th class="text-center" style="width: 10%">Eceran</th>
                        </tr>
                      </thead>
                      <tbody id="listCarts">
                        
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-5">
              <div class="card">
                <div class="card-body">
                  <input type="hidden" id="grandTotal">
                  <input type="hidden" id="subTotal">
                  <input type="hidden" id="pajak">
                  <div class="d-flex flex-column justify-content-end align-items-end">
                    <span class="text-muted font-weight-bold">{{ $no_invoice }}</span>
                    <span class="font-weight-bold subTotalBadge" style="font-size: 30px">Rp.100.000 ,-</span>
                  </div>
                  <div class="dropdown-divider"></div>
                  <div class="d-flex justify-content-between align-items-center">
                    <span class="font-weight-bold text-muted" style="font-size: 17px;">Sub Total</span>
                    <span class="font-weight-bold text-danger subTotalBadge" style="font-size: 14px;">Rp.100.000 ,-</span>
                  </div>
                  <div class="d-flex justify-content-between align-items-center">
                    <span class="font-weight-bold text-muted" style="font-size: 17px;">Diskon</span>
                    <span class="font-weight-bold text-success" style="font-size: 14px;" id="diskonTrx">Rp.0 ,-</span>
                  </div>
                  <div class="dropdown-divider"></div>
                  <div class="d-flex justify-content-between align-items-center">
                    <span class="font-weight-bold text-muted" style="font-size: 17px;">Total</span>
                    <span class="font-weight-bold text-primary grand_total" style="font-size: 14px;">Rp.90.000 ,-</span>
                  </div>
                  <div class="dropdown-divider"></div>
                  <div class="form-group">
                    <label for="customer">Member <small class="text-muted">* Jika ada</small> </label>
                    <input type="text" class="form-control" name="customer" id="customer">
                  </div>
                  <button class="btn btn-block btn-secondary mt-2" id="cancelOrder">Cancel</button>
                  <button class="btn btn-block btn-primary btn-lg grand_total" id="btn-proccess-payment" type="submit">Rp.90.000 ,-</button>
                </div>
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
  <script src="{{ asset('js/managements/transaksi/index-v3.js') }}"></script>
@endsection