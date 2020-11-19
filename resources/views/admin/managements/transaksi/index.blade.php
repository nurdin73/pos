@extends('layouts.template')

@section('css')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap4-select2-theme@1.0.3/src/css/bootstrap4-select2-theme.css">
@endsection

@section('content')
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="row">
          <div class="col-md-4">
            <div class="border bg-white p-3" style="height: 130px">
              <div class="form-group row">
                <label class="col-md-3 col-form-label" for="kasir">Kasir</label>
                <div class="col-md-9">
                  <input class="form-control" id="kasir" type="text" name="kasir">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 col-form-label" for="customer">Customer</label>
                <div class="col-md-9">
                  <select name="customer" id="customer" class="form-control">
                    
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="border bg-white p-3" style="height: 130px">
              <form action="#" id="addProduct">
                <div class="form-group row">
                  <label class="col-md-3 col-form-label" for="barcode">Kode</label>
                  <div class="col-md-9">
                    {{-- <input class="form-control" id="barcode" type="text" name="barcode"> --}}
                    <select name="barcode" id="barcode" style="width: 100%" class="form-control">

                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-md-3 col-form-label"></label>
                  <div class="col-md-9">
                    <button class="btn btn-primary btn-sm" type="submit">Tambah</button>
                  </div>
                </div>

              </form>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card">
              <div class="card-body d-flex justify-content-center align-items-end flex-column" style="height: 130px">
                <div class="d-flex justify-content-end align-items-end flex-column">
                  <span class="text-muted">Invoice <span class="font-weight-bold" id="noInvoice"></span></span>
                  <span class="font-weight-bold" style="font-size: 30px" id="subTotalBadge"></span>
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
                    <th>Kode Barang</th>
                    <th>Nama barang</th>
                    <th>Harga</th>
                    <th style="width:5%">Qyt</th>
                    <th>Diskon</th>
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
        <div class="row">
          <div class="col-md-3">
            <div class="card" style="height: 180px">
              <div class="card-body">
                <div class="form-group">
                  <input type="text" name="sub_total" id="sub_total" placeholder="Sub total" class="form-control">
                </div>
                <div class="form-group">
                  <input type="text" name="diskon" id="diskon" placeholder="Diskon" class="form-control">
                </div>
                <div class="form-group">
                  <input type="text" name="grand_total" id="grand_total" placeholder="grand total" class="form-control" readonly>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card">
              <div class="card-body">
                <div class="form-group">
                  <input type="text" name="cash" id="cash" placeholder="Cash" class="form-control">
                </div>
                <div class="form-group">
                  <input type="text" name="change" id="change" placeholder="Kembalian" class="form-control" readonly>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card">
              <div class="card-body">
                <div class="form-group">
                  <textarea name="keterangan" id="keterangan" cols="30" rows="2" class="form-control" placeholder="Keterangan"></textarea>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <button class="btn btn-block btn-danger">Cancel</button>
            <button class="btn btn-block btn-success btn-lg" id="btn-proccess-payment">Prosess</button>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection 

@section('js')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js" integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg==" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/additional-methods.min.js" integrity="sha512-6Uv+497AWTmj/6V14BsQioPrm3kgwmK9HYIyWP+vClykX52b0zrDGP7lajZoIY1nNlX4oQuh7zsGjmF7D0VZYA==" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/localization/messages_id.min.js" integrity="sha512-Pb0klMWnom+fUBpq+8ncvrvozi/TDwdAbzbICN8EBoaVXZo00q6tgWk+6k6Pd+cezWRwyu2cB+XvVamRsbbtBA==" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <script>
    const URL_API = '{{ url('api/v1') }}'
    const name = '{{ auth()->user()->name }}'
    const idUserInput = '{{ auth()->user()->id }}'
    const noInvoice = '{{ $no_invoice }}'
  </script>
  <script src="{{ asset('js/managements/transaksi/index.js') }}"></script>
@endsection