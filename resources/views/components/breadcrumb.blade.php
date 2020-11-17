<?php 
  $url = url()->full(); 
  $explodeUrl = explode('/', $url);
?>
<div class="c-subheader px-3">
  <!-- Breadcrumb-->
  <ol class="breadcrumb border-0 m-0">
    @if ((count($explodeUrl) - 3) <= 3 )
      @for ($i = 3; $i < count($explodeUrl) - 1; $i++)
        <li class="breadcrumb-item">{{ $explodeUrl[$i] }}</li>
      @endfor
      <li class="breadcrumb-item active">{{ Str::slug(explode("?", end($explodeUrl))[0], " ") ?? Str::slug(end($explodeUrl), " ") }}</li>
      @else
      @for ($i = 3; $i < count($explodeUrl) - 2; $i++)
        <li class="breadcrumb-item">{{ $explodeUrl[$i] }}</li>
      @endfor
      <li class="breadcrumb-item">{{ Str::slug($explodeUrl[count($explodeUrl) - 2], " ") }}</li>
      <li class="breadcrumb-item active">{{ $id_kasbon ?? $id ?? end($explodeUrl) }}</li>
    @endif
  </ol>
</div>