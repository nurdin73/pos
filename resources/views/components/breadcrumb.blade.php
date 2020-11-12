<?php 
  $url = url()->full(); 
  $explodeUrl = explode('/', $url);
?>
<div class="c-subheader px-3">
  <!-- Breadcrumb-->
  <ol class="breadcrumb border-0 m-0">
    @for ($i = 3; $i < count($explodeUrl) - 1; $i++)
      <li class="breadcrumb-item">{{ $explodeUrl[$i] }}</li>
    @endfor
    <li class="breadcrumb-item active">{{ Str::slug(end($explodeUrl), " ") }}</li>
  </ol>
</div>