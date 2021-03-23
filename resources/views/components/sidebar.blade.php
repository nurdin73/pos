<div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
    <div class="c-sidebar-brand d-lg-down-none">
      POS
      {{-- <svg class="c-sidebar-brand-full" width="118" height="46" alt="CoreUI Logo">
        <use xlink:href="{{ asset('assets/brand/coreui.svg#full') }}"></use>
      </svg>
      <svg class="c-sidebar-brand-minimized" width="46" height="46" alt="CoreUI Logo">
        <use xlink:href="{{ asset('assets/brand/coreui.svg#signet') }}"></use>
      </svg> --}}
    </div>
    <ul class="c-sidebar-nav">
      <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="{{ route('dashboardAdmin') }}">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-speedometer') }}"></use>
          </svg> Dashboard
        </a>
        <span class="sr-only">Dashboard</span>
      </li>
      <li class="c-sidebar-nav-title">Management <span class="sr-only">Management</span></li>
      <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="{{ route('managementBarang') }}">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-storage') }}"></use>
          </svg> Barang
        </a>
        <span class="sr-only">Barang</span>
      </li>
      <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="{{ route('managementKategori') }}">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-excerpt') }}"></use>
          </svg> Kategori Barang
        </a>
        <span class="sr-only">Kategori Barang</span>
      </li>
      <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="{{ route('managementSuplier') }}">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-truck') }}"></use>
          </svg> Suplier
        </a>
        <span class="sr-only">Suplier</span>
      </li>
      <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="{{ route('managementCabang') }}">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-industry') }}"></use>
          </svg> Cabang
        </a>
        <span class="sr-only">Cabang</span>
      </li>
      <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="{{ route('managementStok') }}">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-equalizer') }}"></use>
          </svg> Management Stok
        </a>
        <span class="sr-only">Management Stok</span>
      </li>
      <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">
        <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-chart') }}"></use>
          </svg> Transaksi
        </a>
        <ul class="c-sidebar-nav-dropdown-items">
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('listTransaksi') }}"><span class="c-sidebar-nav-icon"></span> List Transaksi</a><span class="sr-only">List Transaksi</span></li>
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('managementTransaksi') }}"><span class="c-sidebar-nav-icon"></span> Tambah Transaksi</a><span class="sr-only">Tambah Transaksi</span></li>
        </ul>
        <span class="sr-only">Transaksi</span>
      </li>
      <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="{{ route('managementPelanggan') }}">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-people') }}"></use>
          </svg> Pelanggan
        </a>
        <span class="sr-only">Pelanggan</span>
      </li>
      <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="{{ route('managementKasbon') }}">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-wallet') }}"></use>
          </svg> Kasbon
        </a>
        <span class="sr-only">Kasbon</span>
      </li>
      <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="{{ route('pajakUniversal') }}">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-fax') }}"></use>
          </svg> Pajak
        </a>
        <span class="sr-only">Pajak</span>
      </li>
      <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="{{ route('settingManagementStaff') }}">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-contact') }}"></use>
          </svg> Management Staff
          <span class="badge badge-warning">On Going</span>
        </a>
      </li>
      {{-- <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="{{ route('loyalityProgram') }}">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-dollar') }}"></use>
          </svg> Loyality Program
          <span class="badge badge-danger">Soon</span>
        </a>
        <span class="sr-only">Loyality Program</span>
      </li> --}}
      <li class="c-sidebar-nav-title">Laporan <span class="sr-only">Laporan</span></li>
      <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">
        <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-save') }}"></use>
          </svg> Laporan
        </a>
        <ul class="c-sidebar-nav-dropdown-items">
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('reportUmum') }}"><span class="c-sidebar-nav-icon"></span> Umum</a><span class="sr-only">Umum</span></li>
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('reportTransaksi') }}"><span class="c-sidebar-nav-icon"></span> Transaksi</a><span class="sr-only">Transaksi</span></li>
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('reportPenjualan') }}"><span class="c-sidebar-nav-icon"></span> Penjualan Barang</a><span class="sr-only">Penjualan Barang</span></li>
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('reportPembelian') }}"><span class="c-sidebar-nav-icon"></span> Pembelian Barang</a><span class="sr-only">Pembelian Barang</span></li>
        </ul>
        <span class="sr-only">Laporan</span>
      </li>
      <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="{{ route('reportBarang') }}">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-storage') }}"></use>
          </svg> Barang
        </a>
        <span class="sr-only">Modal</span>
      </li>
      <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="{{ route('reportModal') }}">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-swap-horizontal') }}"></use>
          </svg> Modal
        </a>
        <span class="sr-only">Modal</span>
      </li>
      <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="{{ route('reportPajak') }}">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-fax') }}"></use>
          </svg> Pajak
          {{-- <span class="badge badge-warning">On Going</span> --}}
        </a>
      </li>
      <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="{{ route('reportKasbon') }}">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-wallet') }}"></use>
          </svg> Kasbon
        </a>
      </li>
      <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="{{ route('reportPelanggan') }}">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-people') }}"></use>
          </svg> Pelanggan
        </a>
      </li>
      <li class="c-sidebar-nav-title">Pengaturan <span class="sr-only">Pengaturan</span></li>
      <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="{{ route('settingProfile') }}">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-user') }}"></use>
          </svg> Profile
        </a>
        <span class="sr-only">Profile</span>
      </li>
      <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="{{ route('settingToko') }}">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-house') }}"></use>
          </svg> Toko
        </a>
        <span class="sr-only">Toko</span>
      </li>
      <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="{{ route('settingDatabase') }}">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-storage') }}"></use>
          </svg> Database
        </a>
      </li>
      <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="{{ route('printerSettings') }}">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-print') }}"></use>
          </svg> Printer Settings
        </a>
        <span class="sr-only">Toko</span>
      </li>
      {{-- <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="{{ route('settingApi') }}">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-settings') }}"></use>
          </svg> API
          <span class="badge badge-danger">Soon</span>
        </a>
        <span class="sr-only">API</span>
      </li> --}}
    </ul>
    <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent" data-class="c-sidebar-minimized"></button>
  </div>