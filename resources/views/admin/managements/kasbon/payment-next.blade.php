@extends('layouts.template')
@section('content')
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="card">
          <div class="card-header">
            <span class="lead">Pembayaran Piutang</span>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="card">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                  <div class="d-flex justify-content-start align-items-start flex-column">
                    <small class="text-primary text-uppercase font-weight-bold">Nama pelanggan</small>
                    <small class="text-muted" id="nameCust"></small>
                  </div>
                  <div class="d-flex justify-content-end align-items-end flex-column">
                    <small class="text-primary text-uppercase font-weight-bold">Sisa yang harus dibayar</small>
                    <small class="text-muted" id="custSisa">Rp. 700 ,-</small>
                  </div>
                </div>
                <div class="dropdown-divider"></div>
                <small class="text-danger text-uppercase font-weight-bold">Detail Pelanggan</small>
                <div class="dropdown-divider w-25"></div>
                <div class="d-flex justify-content-start align-items-start flex-column">
                  <small class="text-primary font-weight-bold">Email</small>
                  <small class="text-muted" id="custEmail"></small>
                </div>
                <div class="d-flex justify-content-start align-items-start flex-column">
                  <small class="text-primary font-weight-bold">No Telp</small>
                  <small class="text-muted" id="custTelp"></small>
                </div>
                <div class="d-flex justify-content-start align-items-start flex-column">
                  <small class="text-primary font-weight-bold">Alamat</small>
                  <small class="text-muted" id="custAddress"></small>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-8">
            <div class="card">
              <div class="card-body">
                <form action="#" id="paymentForm" autocomplete="off">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="jumlah">Jumlah</label>
                        <input type="number" min="0" value="0" name="jumlah" id="jumlah" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="method_payment">Metode pembayaran</label>
                        <select name="method_payment" id="method_payment" class="form-control">
                          <option value="cash">Cash</option>
                          <option value="debit">Debit</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="keterangan">keterangan</label>
                        <textarea name="keterangan" id="keterangan" cols="30" rows="2" class="form-control"></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <button class="btn btn-sm btn-primary">Simpan</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection 

@section('js')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js" integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg==" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/additional-methods.min.js" integrity="sha512-6Uv+497AWTmj/6V14BsQioPrm3kgwmK9HYIyWP+vClykX52b0zrDGP7lajZoIY1nNlX4oQuh7zsGjmF7D0VZYA==" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/localization/messages_id.min.js" integrity="sha512-Pb0klMWnom+fUBpq+8ncvrvozi/TDwdAbzbICN8EBoaVXZo00q6tgWk+6k6Pd+cezWRwyu2cB+XvVamRsbbtBA==" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <script>
    const URL_API = '{{ url('api/v1') }}'
    const URL_IMAGE = '{{ url('') }}'
    const id = '{{ $id_kasbon }}'
  </script>
  <script src="{{ asset('js/managements/kasbon/payment.js') }}"></script>
@endsection