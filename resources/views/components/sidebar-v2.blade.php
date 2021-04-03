<?php

use App\Models\Menu;

$menus = Menu::with('submenus.childSubMenus')->get();

?>

<div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
  <div class="c-sidebar-brand d-lg-down-none">
    <div class="c-sidebar-brand-full">
      Ritter POS
    </div>
    <div class="c-sidebar-brand-minimized">
      RitPOS
    </div>
  </div>
  <ul class="c-sidebar-nav">
    @foreach ($menus as $menu)
      <li class="c-sidebar-nav-title">{{ $menu->name }} <span class="sr-only">{{ $menu->name }}</span></li>
      @if (count($menu->submenus) > 0) 
        @foreach ($menu->submenus as $submenu)
        @if (count($submenu->childSubMenus) > 0)
        <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">
          <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
            <svg class="c-sidebar-nav-icon">
              <use xlink:href="{{ asset($submenu->icon) }}"></use>
            </svg> {{ $submenu->name }}
          </a>
          <ul class="c-sidebar-nav-dropdown-items">
              @foreach ($submenu->childSubMenus as $childSubMenu)
              <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route($childSubMenu->url) }}"><span class="c-sidebar-nav-icon"></span> {{ $childSubMenu->name }}</a><span class="sr-only">{{ $childSubMenu->name }}</span></li>
              @endforeach
          </ul>
          <span class="sr-only">{{ $submenu->name }}</span>
        </li>
        @else
          <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="@if($submenu->url != '#') {{route($submenu->url)}}  @else {{ $submenu->url }} @endif">
              <svg class="c-sidebar-nav-icon">
                <use xlink:href="{{ asset($submenu->icon) }}"></use>
              </svg> {{ $submenu->name }}
            </a>
            <span class="sr-only">{{ $submenu->name }}</span>
          </li>
        @endif
        @endforeach
      @endif
    @endforeach
  </ul>
  <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent" data-class="c-sidebar-minimized"></button>
</div>