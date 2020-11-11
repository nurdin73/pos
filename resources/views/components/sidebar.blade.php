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
      </li>
      <li class="c-sidebar-nav-title">Management</li>
      <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="{{ route('managementBarang') }}">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-storage') }}"></use>
          </svg> Barang
        </a>
      </li>
      <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="{{ route('managementKategori') }}">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-excerpt') }}"></use>
          </svg> Kategori Barang
        </a>
      </li>
      <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="{{ route('managementStok') }}">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-chart') }}"></use>
          </svg> management Stok
        </a>
      </li>
      <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="{{ route('managementPelanggan') }}">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-people') }}"></use>
          </svg> Pelanggan
        </a>
      </li>
      <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="{{ route('managementKasbon') }}">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-wallet') }}"></use>
          </svg> Kasbon
        </a>
      </li>
      <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="{{ route('managementPajak') }}">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-dollar') }}"></use>
          </svg> Pajak
        </a>
      </li>
      <li class="c-sidebar-nav-title">Laporan</li>
      <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">
        <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-save') }}"></use>
          </svg> Laporan
        </a>
        <ul class="c-sidebar-nav-dropdown-items">
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('reportUmum') }}"><span class="c-sidebar-nav-icon"></span> Umum</a></li>
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('reportTransaksi') }}"><span class="c-sidebar-nav-icon"></span> Transaksi</a></li>
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('reportPenjualan') }}"><span class="c-sidebar-nav-icon"></span> Penjualan Barang</a></li>
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('reportPembelian') }}"><span class="c-sidebar-nav-icon"></span> Pembelian Barang</a></li>
        </ul>
      </li>
      <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="{{ route('reportModal') }}">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-swap-horizontal') }}"></use>
          </svg> Modal
        </a>
      </li>
      <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="{{ route('reportPajak') }}">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-dollar') }}"></use>
          </svg> Pajak
        </a>
      </li>
      <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="{{ route('reportPengunjung') }}">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-people') }}"></use>
          </svg> Pengunjung
        </a>
      </li>
      <li class="c-sidebar-nav-title">Pengaturan</li>
      <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="{{ route('settingProfile') }}">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-user') }}"></use>
          </svg> Profile
        </a>
      </li>
      <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="{{ route('settingToko') }}">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-house') }}"></use>
          </svg> Toko
        </a>
      </li>
      <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="{{ route('settingDatabase') }}">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-storage') }}"></use>
          </svg> Database
        </a>
      </li>
      <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="{{ route('settingManagementStaff') }}">
          <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-contact') }}"></use>
          </svg> Management Staff
        </a>
      </li>
    </ul>
    <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent" data-class="c-sidebar-minimized"></button>
  </div>