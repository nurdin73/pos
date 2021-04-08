@extends('layouts.template')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/select2.css') }}"/>
  <link rel="stylesheet" href="{{ asset('css/select2-bs4.css') }}">
  <style>
    .form-atas {
      height: 130px;
    }
    @media screen and (max-width: 992px) {
      .form-atas {
        height: auto;
      }
    }
  </style>
@endsection

@section('content')
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="row">
          <div class="col-md-4">
            <div class="card form-atas">
              <div class="card-body">
                <div class="form-group row">
                  <label class="col-md-4 col-form-label" for="kasir">Kasir</label>
                  <div class="col-md-8">
                    <input class="form-control" id="kasir" type="text" name="kasir">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-md-4 col-form-label" for="customer">Customer</label>
                  <div class="col-md-8">
                    <select name="customer" id="customer" class="form-control">
                      
                    </select>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card form-atas">
              <div class="card-body">
                {{-- <form action="#" id="addProduct" autocomplete="off"> --}}
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="barcode">Kode</label>
                    <div class="col-md-9">
                      <input class="form-control" id="barcode" type="text" name="barcode" autofocus>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="pajak">Pajak</label>
                    <div class="input-group col-md-9">
                      <input class="form-control" id="persentasePajak" type="text" name="persentasePajak" placeholder="0.00" disabled>
                      <div class="input-group-append">
                        <span class="input-group-text" id="basic-addon2">%</span>
                      </div>
                    </div>
                  </div>
                {{-- </form> --}}

              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card form-atas">
              <div class="card-body">
                <div class="card-body d-flex justify-content-center align-items-end flex-column">
                  <div class="d-flex justify-content-end align-items-end flex-column">
                    <span class="text-muted">Invoice <span class="font-weight-bold" id="noInvoice"></span></span>
                    <span class="font-weight-bold" style="font-size: 30px" id="subTotalBadge"></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-borderless table-striped">
                <thead>
                  <tr>
                    <th style="width:5%">No.</th>
                    <th>Nama barang</th>
                    <th style="width: 17%">Harga</th>
                    <th style="width:8%">Qyt</th>
                    <th>Eceran</th>
                    <th>Total Diskon</th>
                    <th>Total</th>
                    <th style="width: 10%">Actions</th>
                  </tr>
                </thead>
                <tbody id="listCarts">

                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="row mb-4">
          <div class="col-md-8">
            <textarea name="keterangan" id="keterangan" cols="30" rows="5" class="form-control" placeholder="keterangan"></textarea>
            <small class="text-muted font-weight-bold" id="pajakDetail">-</small>
          </div>
          <div class="col-md-4">
            <input type="hidden" id="grandTotal">
            <input type="hidden" id="subTotal">
            <ul class="list-group list-group-flush">
              <li class="list-group-item d-flex justify-content-lg-between align-items-center">
                <span class="font-weight-bold text-uppercase">Subtotal</span>
                <small class="text-muted" id="sub_total">Rp. 0 ,-</small>
              </li>
              <input type="hidden" name="pajak" id="pajak">
              <li class="list-group-item d-flex justify-content-lg-between align-items-center">
                <span class="font-weight-bold text-uppercase">Diskon</span>
                <div class="row justify-content-lg-end">
                  <div class="col-7">
                    <input type="number" name="diskon" id="diskon" class="form-control" placeholder="Diskon" value="0">
                  </div>
                </div>
              </li>
              <li class="list-group-item d-flex justify-content-lg-between align-items-center">
                <span class="font-weight-bold text-uppercase">Total</span>
                <small class="text-muted" id="grand_total">Rp. 0 ,-</small>
              </li>
            </ul>
            <button class="btn btn-block btn-danger" id="cancelOrder">Cancel</button>
            <button class="btn btn-block btn-success btn-lg" id="btn-proccess-payment" type="submit">Prosess</button>
            {{-- <button class="btn btn-block btn-success btn-lg" data-target="#processPaymentModal" data-toggle="modal">Prosess</button> --}}
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection 

@section('modal')
  <div class="modal fade" id="detailCart" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Update keranjang</h4>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div>
        <form id="formUpdateCart" autocomplete="off">
          <input type="hidden" name="id_cart" id="id_cart">
          <div class="modal-body">
            <div class="d-flex justify-content-between align-items-start">
              <div class="d-flex justify-content-center flex-column align-items-center">
                <span class="font-weight-bold text-primary">Harga</span>
                <small class="text-muted" id="hargaBarangUpdate"></small>
              </div>
              <div class="d-flex justify-content-end flex-column align-items-end">
                <span class="font-weight-bold text-primary">Nama Barang</span>
                <small class="text-muted" id="namaBarangUpdate"></small>
              </div>
            </div>
            <div class="dropdown-divider"></div>
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="qyt_update">Qyt</label>
                  <input type="text" name="qyt_update" id="qyt_update" class="form-control">
                </div>
              </div>
              <div class="col-md-9">
                <div class="form-group">
                  <label for="dicount_barang_update">Diskon Produk</label>
                  <input type="number" min="0" name="dicount_barang_update" id="dicount_barang_update" class="form-control">
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            {{-- <button class="btn btn-primary" id="btn-submit" type="submit">Save changes</button> --}}
            <button class="btn btn-primary" type="submit">Simpan</button>
          </div>
        </form>
      </div>
      <!-- /.modal-content-->
    </div>
    <!-- /.modal-dialog-->
  </div>

  <!-- Modal -->
{{-- <div class="modal fade" id="processPaymentModal" tabindex="-1" aria-labelledby="paymentModal" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Total Belanja : <span id="paymentModal"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <textarea name="cash" id="fieldCash" cols="30" rows="2" class="form-control mb-2" readonly></textarea>
        <div class="container-fluid">
          <div class="row">
            @for ($i = 1; $i < 10; $i++)
            <div class="col-4 d-flex justify-content-center align-items-center border border-primary btn-number" data-number="{{ $i }}" style="height: 50px; cursor: pointer">
              <span class="lead font-weight-bold text-uppercase">{{ $i }}</span>
            </div>
            @endfor
            <div class="col-4 d-flex justify-content-center align-items-center border border-primary btn-number" data-number="0" style="height: 50px; cursor: pointer">
              <span class="lead font-weight-bold text-uppercase">0</span>
            </div>
            <div class="col-4 d-flex justify-content-center align-items-center border border-primary btn-number" data-number="000" style="height: 50px; cursor: pointer">
              <span class="lead font-weight-bold text-uppercase">000</span>
            </div>
            <div class="col-4 d-flex justify-content-center align-items-center border border-primary btn-number" data-number="C" style="height: 50px; cursor: pointer">
              <span class="lead font-weight-bold text-uppercase">C</span>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn-proccess-payment">Prosess</button>
      </div>
    </div>
  </div>
</div> --}}
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
  <script src="{{ asset('js/managements/transaksi/index.js') }}"></script>
@endsection