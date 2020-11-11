@extends('components.auth.template')

@section('content')
<div class="col-md-5">
    <div class="card-group">
      <div class="card p-4">
        <div class="card-body">
          <h1>Masuk</h1>
          <p class="text-muted">Masuk dengan akun kamu</p>
          <form action="{{ route('loginPost') }}" method="post">
            @csrf
            <div class="form-group mb-3">
              <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text">
                    <svg class="c-icon">
                      <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-envelope-closed"></use>
                    </svg></span></div>
                <input class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" name="email" type="text" placeholder="Email" required autocomplete="email" autofocus>
              </div>
              @error('email')
                <span class="help-block text-danger">
                  <small>{{ $message }}</small>  
                </span>
              @enderror
            </div>
            <div class="form-group mb-4">
              <a href="#" class="btn-link px-0 float-right">Lupa password?</a>
              <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text">
                    <svg class="c-icon">
                      <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-lock-locked"></use>
                    </svg></span></div>
                <input class="form-control @error('password') is-invalid @enderror" name="password" type="password" placeholder="Password" required autocomplete="current-password">
              </div>
              @error('password')
                <span class="help-block text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
            <div class="row">
              <div class="col-6">
                <button class="btn btn-primary px-4" type="submit">Login</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      
    </div>
  </div>
@endsection