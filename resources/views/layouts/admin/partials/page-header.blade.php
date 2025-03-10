<div class="page-header">
    <h4 class="page-title">@yield('title')</h4>
    <ul class="breadcrumbs">
        <li class="nav-home">
            <a href="{{ route('admin.dashboard') }}">
                <i class="icon-home"></i>
            </a>
        </li>
        <li class="separator">
            <i class="icon-arrow-right"></i>
        </li>
        <li class="nav-item">
            <a href="@yield('route')">@yield('title')</a>
        </li>
    </ul>
</div>
