@extends('layouts.template')
@section('content')
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="card">
        	<div class="card-header d-flex justify-content-between align-items-center">
        		<span class="lead">Bayar kasbon</span>
        		<button class="btn btn-sm btn-primary">Print</button>
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
        						<th style="width: 10%">Actions</th>
        					</tr>
        				</thead>
        				<tbody id="listData">
        					
        				</tbody>
        			</table>
        		</div>
        	</div>
        </div>
      </div>
    </div>
  </main>
@endsection 

@section('js')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous"></script>
	<script>
    const URL_API = '{{ url('api/v1') }}'
    const URL_IMAGE = '{{ url('') }}'
    const id = '{{ $id }}'
  </script>
	<script type="text/javascript" src="{{ asset('js/managements/kasbon/bayar.js') }}"></script>
@endsection