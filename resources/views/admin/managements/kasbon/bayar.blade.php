@extends('layouts.template')
@section('content')
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="card">
        	<div class="card-header d-flex justify-content-between align-items-center">
        		<span class="lead">Bayar kasbon</span>
        		<div class="btn-group">
              <a class="btn btn-sm btn-danger" href="{{ route('managementKasbon') }}">Kembali</a>
            </div>
        	</div>
        	<div class="card-body">
        		<div class="row">
        			<div class="col-6 col-md-5">
        				<div class="d-flex justify-content-start flex-column">
        					<span class="text-uppercase font-weight-bold text-primary">Pelanggan</span>
        					<span class="text-small text-muted" id="nama_pelanggan"></span>
        					<span class="text-small text-muted" id="email_pelanggan"></span>
        					<span class="text-small text-muted" id="telp_pelanggan"></span>
        					<span class="text-small text-muted" id="alamat_pelanggan"></span>
        				</div>
        			</div>
        			<div class="col-6 col-md-3">
        				<div class="d-flex justify-content-start flex-column">
        					<span class="text-uppercase font-weight-bold text-primary">Total Kasbon</span>
        					<span class="text-small text-danger" id="totalKasbon">0</span>
        				</div>
        			</div>
        			<div class="col-6 col-md-4">
        				<div class="d-flex justify-content-end flex-column align-items-end">
        					<span class="text-uppercase font-weight-bold text-primary">Total Transaksi</span>
        					<span class="text-small text-danger" id="total_transaksi">0</span>
        				</div>
        			</div>
        		</div>
        		<div class="dropdown-divider"></div>
        		<div class="table-responsive">
        			<table class="table table-borderless table-striped">
        				<thead>
        					<tr>
        						<th style="width: 20%">Jumlah</th>
        						<th>Tanggal Transaksi</th>
        						<th>Jatuh Tempo</th>
        						<th style="width: 15%">Status</th>
        						<th style="width: 20%">Actions</th>
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

@section('modal')
  <div class="modal fade" id="bayarKasbon" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Bayar Kasbon</h4>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-6">
              <div class="d-flex justify-content-start align-items-start flex-column">
                <small class="text-muted">Nama Pelanggan</small>
                <span class="font-weight-bold" id="customerName">Nurdin</span>
              </div>
            </div>
            <div class="col-6">
              <div class="d-flex justify-content-end align-items-end flex-column">
                <small class="text-muted">Hubungi</small>
                <div class="d-flex">
                  <a href="#" class="btn btn-sm btn-success mr-2" id="chatWhatsapp" data-action="share/whatsapp/share">
                    <i class="fab fa-whatsapp"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
          <div class="dropdown-divider"></div>
          <div class="status"></div>
          <div class="d-flex justify-content-between flex-column">
            <div class="row mb-1">
              <div class="col-6">
                <div class="d-flex justify-content-start align-items-start flex-column">
                  <small class="text-muted">Tanggal Transaksi</small>
                  <span class="font-weight-bold" id="tglTransaksi"></span>
                </div>
              </div>
              <div class="col-6">
                <div class="d-flex justify-content-end align-items-end flex-column">
                  <small class="text-muted">Jatuh Tempo</small>
                  <span class="font-weight-bold" id="tglTempo"></span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-6">
                <div class="d-flex justify-content-start align-items-start flex-column">
                  <small class="text-muted">Total</small>
                  <span class="font-weight-bold totalKasbon">0</span>
                </div>
              </div>
              <div class="col-6">
                <div class="d-flex justify-content-end align-items-end flex-column">
                  <small class="text-muted">Belum Dibayar</small>
                  <span class="font-weight-bold" id="sisa"></span>
                </div>
              </div>
            </div>
          </div>
          <div class="dropdown-divider"></div>
          <div class="table-responsive">
            <table class="table table-borderless table-striped">
              <thead>
                <tr>
                  <th>Cicilan</th>
                  <th>Tanggal Pembayaran</th>
                  <th>Sisa</th>
                </tr>
              </thead>
              <tbody id="listCicilan">
                
              </tbody>
            </table>
          </div>
        </div>
        <div class="modal-footer">
          {{-- <button class="btn btn-primary" id="btn-submit" type="submit">Save changes</button> --}}
          <a class="btn btn-primary btn-bayar" href="#" >Lanjutkan Pembayaran</a>
        </div>
      </div>
      <!-- /.modal-content-->
    </div>
    <!-- /.modal-dialog-->
  </div>
@endsection

@section('js')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/b10279cbf9.js" crossorigin="anonymous"></script>
  <script>
    const URL_API = '{{ url('api/v1') }}'
    const URL_IMAGE = '{{ url('') }}'
    const id = '{{ $id }}'
    const KODE_NOMOR = '{{ env('KODE_NOMOR') }}'
    const NAMA_TOKO = '{{ env('NAMA_TOKO') }}'
    const urlPageKasbon = '{{ route('managementKasbon') }}'
  </script>
	<script type="text/javascript" src="{{ asset('js/managements/kasbon/bayar.js') }}"></script>
@endsection