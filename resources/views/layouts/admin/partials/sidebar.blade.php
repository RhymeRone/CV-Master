        <div class="sidebar" data-background-color="dark">
            <div class="sidebar-logo">
                <!-- Logo Header -->
                <div class="logo-header" data-background-color="dark">
                    <a href="{{ route('admin.dashboard') }}" class="logo">
                        <img src="{{ asset('assets/img/admin/logo_light.svg') }}" alt="navbar brand" class="navbar-brand"
                            height="20" />
                    </a>
                    <div class="nav-toggle">
                        <button class="btn btn-toggle toggle-sidebar">
                            <i class="gg-menu-right"></i>
                        </button>
                        <button class="btn btn-toggle sidenav-toggler">
                            <i class="gg-menu-left"></i>
                        </button>
                    </div>
                    <button class="topbar-toggler more">
                        <i class="gg-more-vertical-alt"></i>
                    </button>
                </div>
                <!-- End Logo Header -->
            </div>
            <div class="sidebar-wrapper scrollbar scrollbar-inner">
                <div class="sidebar-content">
                    <ul class="nav nav-secondary">
                        <li class="nav-item active">
                            <a href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-home"></i>
                                <p>Ana Sayfa</p>
                            </a>
                        </li>
                        <li class="nav-section">
                            <span class="sidebar-mini-icon">
                                <i class="fa fa-ellipsis-h"></i>
                            </span>
                            <h4 class="text-section">Bilgiler</h4>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.cvlist') }}">
                                <i class="fas fa-user"></i>
                                <p>CV Listesi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.experiences') }}">
                                <i class="fas fa-briefcase"></i>
                                <p>Deneyimler</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.services') }}">
                                <i class="fas fa-cog"></i>
                                <p>Hizmetler</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.skills') }}">
                                <i class="fas fa-star"></i>
                                <p>Yetenekler</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.testimonials') }}">
                                <i class="fas fa-comment-dots"></i>
                                <p>Referanslar</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="collapse" href="#portfolios">
                                <i class="fas fa-images"></i>
                                <p>Projeler</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse" id="portfolios">
                                <ul class="nav nav-collapse">
                                    <li>
                                        <a href="{{ route('admin.portfolios') }}">
                                            <i class="fas fa-plus-circle"></i> Proje Ekle
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.portfolioCategories') }}">
                                            <i class="fas fa-tags"></i> Kategoriler
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
