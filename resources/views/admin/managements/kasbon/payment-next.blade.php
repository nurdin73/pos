@extends('layouts.template')
@section('content')
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <span class="lead">Pembayaran Piutang</span>
            <a href="{{ route('managementKasbon') }}" class="btn btn-danger btn-sm">Kembali</a>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="card">
              <div class="card-body">
                <input type="hidden" id="id_user">
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
                        <input type="text" value="0" name="jumlah" id="jumlah" class="form-control">
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
        <div class="card">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-borderless table-striped">
                <thead>
                  <tr>
                    <th style="width: 15%">Cicilan</th>
                    <th style="width: 20%">Tanggal Pembayaran</th>
                    <th>Keterangan</th>
                    <th style="width: 15%">Sisa</th>
                  </tr>
                </thead>
                <tbody id="listData">

                </tbody>
              </table>
              <nav aria-label="..." class="d-flex justify-content-end">
                <ul class="pagination">
                  
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection 

@section('js')
  <script src="{{ asset('js/jquery-validate.js') }}" ></script>
  <script src="{{ asset('js/additional-method.js') }}"></script>
  <script src="{{ asset('js/message_id.js') }}" integrity="sha512-Pb0klMWnom+fUBpq+8ncvrvozi/TDwdAbzbICN8EBoaVXZo00q6tgWk+6k6Pd+cezWRwyu2cB+XvVamRsbbtBA==" crossorigin="anonymous"></script>
  <script>
    const URL_API = '{{ url('api/v1') }}'
    const URL_IMAGE = '{{ url('') }}'
    const id = '{{ $id_kasbon }}'
    const urlKasbon = '{{ route('managementKasbon') }}'
  </script>
  <script src="{{ asset('js/managements/kasbon/payment.js') }}"></script>
@endsection