@extends('layouts.template')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/select2.css') }}"/>
  <link rel="stylesheet" href="{{ asset('css/select2-bs4.css') }}">
  <style>
    #carts {
      overflow-y: scroll;
      max-height: 500px;
    }
    #carts::-webkit-scrollbar {
      display: none;
    }

    @media only screen and (max-width: 600px) {
      #carts {
        overflow-y: auto;
      }
    }
  </style>
@endsection

@section('content')
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="desktop">
          <div class="alert alert-info" role="alert">
            <h4 class="alert-heading">Keyboard ShortCut</h4>
            <ul class="list-unstyled">
              <li><strong>CTRL + Y</strong> Tambah barang</li>
              <li><strong>CTRL + X</strong> Diskon transaksi</li>
              <li><strong>CTRL + ENTER</strong> proses transaksi</li>
              <li><strong>CTRL + C</strong> Batalkan transaksi</li>
            </ul>  
          </div>
          <div class="row position-relative">
            <div class="col-md-7">
              <div class="card">
                <div class="card-body">
                  <input class="form-control" id="barcode" type="text" name="barcode" placeholder="barcode" autofocus>
                  <div class="dropdown-divider"></div>
                  <div class="table-responsive" id="carts">
                    <table class="table table-borderless table-striped">
                      <thead>
                        <tr>
                          <th class="text-center" style="width: 10%">No</th>
                          <th>Nama Barang</th>
                          <th class="text-center" style="width: 25%">Harga/Qty</th>
                          <th class="text-center" style="width: 10%">Eceran</th>
                          <th></th>
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
                  <input type="hidden" id="diskonValue">
                  <div class="d-flex flex-column justify-content-end align-items-end">
                    <span class="text-muted font-weight-bold">{{ $no_invoice }}</span>
                    <span class="font-weight-bold grand_total" style="font-size: 30px"></span>
                  </div>
                  <div class="dropdown-divider"></div>
                  <div class="d-flex justify-content-between align-items-center">
                    <span class="font-weight-bold text-muted" style="font-size: 17px;">Sub Total</span>
                    <span class="font-weight-bold text-danger subTotalBadge" style="font-size: 14px;"></span>
                  </div>
                  <div class="d-flex justify-content-between align-items-center">
                    <span class="font-weight-bold text-muted" style="font-size: 17px;">Diskon</span>
                    <span class="font-weight-bold text-success" style="font-size: 14px;" id="diskonTrxLabel">Rp. 0,-</span>
                  </div>
                  <div class="dropdown-divider"></div>
                  <div class="d-flex justify-content-between align-items-center">
                    <span class="font-weight-bold text-muted" style="font-size: 17px;">Total</span>
                    <span class="font-weight-bold text-primary grand_total" style="font-size: 14px;"></span>
                  </div>
                  <div class="dropdown-divider"></div>
                  <div class="form-group">
                    <label for="customer">Member <small class="text-muted">* Jika ada</small> </label>
                    <select name="customer" id="customer" class="form-control">
                      
                    </select>
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

@section('modal')

<div class="modal fade" id="editCartModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Edit barang <span id="namaBarangLabel"></span></h4>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
      </div>
      <form id="formUpdateCart" autocomplete="off">
        <div class="modal-body" id="fieldUpdateCartForm">
          
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button class="btn btn-primary" type="submit">Save</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content-->
  </div>
  <!-- /.modal-dialog-->
</div>
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