@extends('layouts.admin.master')

@section('title', 'Profil Bilgileri')

@section('route', route('admin.profile'))

@section('content')
    <div class="page-inner">
        @include('layouts.admin.partials.page-header')

        <div class="row">
            <div class="col-md-12">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li><i class="fas fa-exclamation-circle mr-1"></i> {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <!-- Hızlı Erişim Butonları -->
            <div class="col-md-12 mb-3">
                <div class="d-flex justify-content-between">
                    <div>
                        <a href="{{ route('admin.profile') }}" class="btn btn-primary btn-rounded">
                            <i class="fas fa-user mr-2"></i> Profil Bilgilerim
                        </a>
                    </div>
                    <div>
                        {{-- <a href="{{ route('admin.settings') }}" class="btn btn-info btn-rounded">
                            <i class="fas fa-cog mr-2"></i> Ayarlar
                        </a> --}}
                        <a href="{{ route('admin.inbox') }}" class="btn btn-success btn-rounded ml-2">
                            <i class="fas fa-envelope mr-2"></i> Mesajlar
                            <span class="badge badge-light ml-1">{{ $messages->where('is_read', false)->count() }}</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Profil Kartı -->
            <div class="col-md-4">
                <div class="card card-profile">
                    <!-- Üst bölüm - arka plan -->
                    <div class="card-header" style="background-size: cover; height: 120px;"></div>

                    <!-- Profil içeriği -->
                    <div class="card-body pt-0">
                        <!-- Profil resmi bölümü -->
                        <div class="text-center" style="margin-top: -60px; margin-bottom: 20px;">
                            <div style="position: relative; display: inline-block;">
                                @if (auth()->guard('admin')->user()->avatar)
                                    <img src="{{ asset('storage/' . auth()->guard('admin')->user()->avatar) }}"
                                        alt="Profil Resmi" class="avatar-img rounded-circle border border-white shadow"
                                        style="width: 100px; height: 100px; object-fit: cover;">
                                @else
                                    <img src="{{ asset('assets/img/default-avatar.png') }}" alt="Varsayılan Profil"
                                        class="avatar-img rounded-circle border border-white shadow"
                                        style="width: 100px; height: 100px; object-fit: cover;">
                                @endif

                                <!-- Kamera ikonu - profil resmi değiştirme -->
                                <label for="avatar" title="Profil Fotoğrafını Değiştir"
                                    style="position: absolute; bottom: 5px; right: 5px; background: rgba(255,255,255,0.9); width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 2px 4px rgba(0,0,0,0.2); z-index: 10;">
                                    <i class="fas fa-camera text-primary"></i>
                                </label>
                            </div>
                        </div>

                        <!-- Gizli avatar formu -->
                        <form action="{{ route('admin.profile.avatar') }}" method="POST" enctype="multipart/form-data"
                            id="avatarForm" style="display: none;">
                            @csrf
                            <input type="file" id="avatar" name="avatar"
                                accept="{{ implode(',',array_map(function ($mime) {return '.' . $mime;}, config('admin.upload.image.mimes'))) }}"
                                style="display: none;">
                        </form>

                        <!-- Kullanıcı bilgileri -->
                        <div class="user-profile text-center">
                            <h4 class="name font-weight-bold mb-1">{{ ucwords(auth()->guard('admin')->user()->name) }}</h4>
                            <div class="job text-primary">{{ auth()->guard('admin')->user()->position ?? 'Yönetici' }}</div>
                            <div class="email mt-2">
                                <a href="mailto:{{ auth()->guard('admin')->user()->email }}" class="text-muted">
                                    <i class="fas fa-envelope mr-1"></i> {{ auth()->guard('admin')->user()->email }}
                                </a>
                            </div>

                            @if (auth()->guard('admin')->user()->bio)
                                <div class="desc mt-3 pt-3 border-top text-left">
                                    <p style="line-height: 1.6;">{{ auth()->guard('admin')->user()->bio }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer bg-light">
                        <div class="row user-stats text-center">
                            <div class="col-4 contact-stat">
                                <div
                                    class="contact-icon @if (auth()->guard('admin')->user()->phone) bg-success @else bg-danger @endif">
                                    <i
                                        class="fas @if (auth()->guard('admin')->user()->phone) fa-phone @else fa-phone-slash @endif text-white"></i>
                                </div>
                                <div class="title">Telefon</div>
                                <div class="detail">{{ auth()->guard('admin')->user()->phone ?? 'Yok' }}</div>
                            </div>
                            <div class="col-4 contact-stat">
                                <div
                                    class="contact-icon @if (auth()->guard('admin')->user()->address) bg-success @else bg-danger @endif">
                                    <i class="fas fa-map-marker-alt text-white"></i>
                                </div>
                                <div class="title">Adres</div>
                                <div class="detail">{{ auth()->guard('admin')->user()->address ? 'Kayıtlı' : 'Yok' }}</div>
                            </div>
                            <div class="col-4 contact-stat">
                                <div
                                    class="contact-icon @if (auth()->guard('admin')->user()->website) bg-success @else bg-danger @endif">
                                    <i class="fas fa-globe text-white"></i>
                                </div>
                                <div class="title">Web</div>
                                <div class="detail">
                                    @if (auth()->guard('admin')->user()->website)
                                        <a href="{{ auth()->guard('admin')->user()->website }}" target="_blank"
                                            class="text-primary">Ziyaret Et</a>
                                    @else
                                        Yok
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Aktivite Özeti -->
                <div class="card">
                    <div class="card-header bg-primary">
                        <div class="card-title text-white"><i class="fas fa-chart-line mr-2 text-white"></i> Aktivite Özeti
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-comments text-primary me-2"></i> Toplam Mesaj
                                </div>
                                <span class="badge badge-primary badge-pill">{{ $messages->total() ?? 0 }}</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-eye text-primary me-2"></i> Son Giriş
                                </div>
                                <span class="text-muted small">Bugün 10:30</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-user-shield text-primary me-2"></i> Hesap Durumu
                                </div>
                                <span class="badge badge-success">Aktif</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profil Bilgileri Tablar -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-white p-4">
                        <ul class="nav nav-tabs nav-line border-bottom-0" id="profileTabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="bilgiler-tab" data-toggle="pill" href="#bilgiler"
                                    role="tab" aria-selected="true">
                                    <i class="fas fa-user-edit mr-2"></i> Profil Bilgileri
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="sifre-tab" data-toggle="pill" href="#sifre" role="tab"
                                    aria-selected="false">
                                    <i class="fas fa-key mr-2"></i> Şifre Değiştir
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="adminAyarlar-tab" data-toggle="pill" href="#adminAyarlar"
                                    role="tab" aria-selected="false">
                                    <i class="fas fa-cog mr-2"></i> Sistem Ayarları
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="mesajlar-tab" data-toggle="pill" href="#mesajlar"
                                    role="tab" aria-selected="false">
                                    <i class="fas fa-envelope mr-2"></i> Mesajlar
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body pt-0 mt-0">
                        <div class="tab-content" id="profileTabsContent">
                            <!-- Profil Bilgileri Tab İçeriği -->
                            <div class="tab-pane fade show active" id="bilgiler" role="tabpanel">
                                <form action="{{ route('admin.profile.update') }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group form-group-default">
                                                <label for="name"><i class="fas fa-user mr-1"></i> Ad Soyad</label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                    value="{{ auth()->guard('admin')->user()->name }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-group-default">
                                                <label for="email"><i class="fas fa-envelope mr-1"></i> E-posta</label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                    value="{{ auth()->guard('admin')->user()->email }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group form-group-default">
                                                <label for="phone"><i class="fas fa-phone mr-1"></i> Telefon</label>
                                                <input type="text" class="form-control" id="phone" name="phone"
                                                    value="{{ auth()->guard('admin')->user()->phone }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-group-default">
                                                <label for="position"><i class="fas fa-briefcase mr-1"></i>
                                                    Pozisyon</label>
                                                <input type="text" class="form-control" id="position"
                                                    name="position"
                                                    value="{{ auth()->guard('admin')->user()->position }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group form-group-default">
                                        <label for="website"><i class="fas fa-globe mr-1"></i> Web Sitesi</label>
                                        <input type="url" class="form-control" id="website" name="website"
                                            value="{{ auth()->guard('admin')->user()->website }}">
                                    </div>

                                    <div class="form-group form-group-default">
                                        <label for="address"><i class="fas fa-map-marker-alt mr-1"></i> Adres</label>
                                        <textarea class="form-control" id="address" name="address" rows="3">{{ auth()->guard('admin')->user()->address }}</textarea>
                                    </div>

                                    <div class="form-group form-group-default">
                                        <label for="bio"><i class="fas fa-info-circle mr-1"></i> Hakkımda</label>
                                        <textarea class="form-control" id="bio" name="bio" rows="5">{{ auth()->guard('admin')->user()->bio }}</textarea>
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-rounded">
                                        <i class="fas fa-save mr-1"></i> Bilgileri Güncelle
                                    </button>
                                </form>
                            </div>

                            <!-- Şifre Değiştir Tab İçeriği -->
                            <div class="tab-pane fade" id="sifre" role="tabpanel">
                                <div class="alert alert-info">
                                    <i class="fas fa-shield-alt mr-2"></i> Güvenliğiniz için güçlü bir şifre tercih edin ve
                                    düzenli olarak şifrenizi değiştirin.
                                </div>

                                <form action="{{ route('admin.profile.password') }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="form-group form-group-default">
                                        <label for="current_password"><i class="fas fa-lock mr-1"></i> Mevcut
                                            Şifre</label>
                                        <input type="password" class="form-control" id="current_password"
                                            name="current_password">
                                    </div>

                                    <div class="form-group form-group-default">
                                        <label for="new_password"><i class="fas fa-key mr-1"></i> Yeni Şifre</label>
                                        <input type="password" class="form-control" id="new_password"
                                            name="new_password">
                                    </div>

                                    <div class="form-group form-group-default">
                                        <label for="new_password_confirmation"><i class="fas fa-check-double mr-1"></i>
                                            Yeni Şifre (Tekrar)</label>
                                        <input type="password" class="form-control" id="new_password_confirmation"
                                            name="new_password_confirmation">
                                    </div>

                                    <div class="progress mt-2 mb-3">
                                        <div class="progress-bar bg-danger" role="progressbar" id="password-strength"
                                            style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-rounded">
                                        <i class="fas fa-key mr-1"></i> Şifreyi Değiştir
                                    </button>
                                </form>
                            </div>

                            <!-- Sistem Ayarları Tab İçeriği -->
                            <div class="tab-pane fade" id="adminAyarlar" role="tabpanel">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle mr-2"></i> Sistem ayarlarınızı buradan
                                    yapılandırabilirsiniz.
                                </div>

                                <form id="adminSettingsForm">
                                    <div class="card mb-3">
                                        <div class="card-header bg-light">
                                            <h5 class="mb-0"><i class="fas fa-upload mr-2 text-primary"></i> &nbsp;Dosya
                                                Yükleme Ayarları
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <h6 class="fw-bold">Resim Yükleme Ayarları</h6>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>İzin Verilen Formatlar</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ implode(',', config('admin.upload.image.mimes')) }}"
                                                            name="image_mimes">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Min. Boyut (KB)</label>
                                                        <input type="number" class="form-control"
                                                            value="{{ config('admin.upload.image.min_size') }}"
                                                            name="image_min_size">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Max. Boyut (KB)</label>
                                                        <input type="number" class="form-control"
                                                            value="{{ config('admin.upload.image.max_size') }}"
                                                            name="image_max_size">
                                                    </div>
                                                </div>
                                            </div>

                                            <h6 class="fw-bold mt-3">CV Yükleme Ayarları</h6>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>İzin Verilen Formatlar</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ implode(',', config('admin.upload.cv.mimes')) }}"
                                                            name="cv_mimes">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Max. Boyut (KB)</label>
                                                        <input type="number" class="form-control"
                                                            value="{{ config('admin.upload.cv.max_size') }}"
                                                            name="cv_max_size">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card mb-3">
                                        <div class="card-header bg-light">
                                            <h5 class="mb-0"><i class="fas fa-envelope mr-2 text-primary"></i>
                                                &nbsp;İletişim Ayarları</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>İletişim E-posta Adresi</label>
                                                        <input type="email" class="form-control"
                                                            value="{{ config('admin.contact.email') }}"
                                                            name="contact_email">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Max. Deneme Sayısı</label>
                                                        <input type="number" class="form-control"
                                                            value="{{ config('admin.contact.throttle.max_attempts') }}"
                                                            name="contact_max_attempts">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Bekleme Süresi (dk)</label>
                                                        <input type="number" class="form-control"
                                                            value="{{ config('admin.contact.throttle.decay_minutes') }}"
                                                            name="contact_decay_minutes">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-rounded">
                                        <i class="fas fa-save mr-1"></i> Ayarları Kaydet
                                    </button>
                                </form>
                            </div>

                            <!-- Mesajlar Tab İçeriği -->
                            <div class="tab-pane fade" id="mesajlar" role="tabpanel">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <h5><i class="fas fa-envelope mr-2 text-primary"></i> İletişim Mesajları</h5>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <div class="form-group mb-0">
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="messageSearch"
                                                    placeholder="Mesajlarda ara...">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" id="searchButton"><i
                                                            class="fas fa-search"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-hover" id="messagesTable">
                                        <thead>
                                            <tr>
                                                <th width="50">#</th>
                                                <th>Gönderen</th>
                                                <th>Konu</th>
                                                <th>Tarih</th>
                                                <th width="100">Durum</th>
                                                <th width="120">İşlemler</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($messages ?? [] as $message)
                                                <tr class="{{ $message->is_read ? '' : 'table-active' }}" data-message-id="{{ $message->id }}">
                                                    <td>{{ $message->id }}</td>
                                                    <td>{{ $message->name }}</td>
                                                    <td>{{ Str::limit($message->subject, 30) }}</td>
                                                    <td>{{ $message->created_at->format('d.m.Y H:i') }}</td>
                                                    <td>
                                                        <span
                                                            class="badge {{ $message->is_read ? 'badge-success' : 'badge-warning' }}">
                                                            {{ $message->is_read ? 'Okundu' : 'Yeni' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <!-- Mesaj Görüntüleme Butonu -->
                                                        <button class="btn btn-sm btn-info view-message"
                                                            onclick="fetchMessageDetails({{ $message->id }})"
                                                            data-toggle="modal">
                                                            <i class="fas fa-eye"></i>
                                                        </button>

                                                        <!-- Cevaplama Butonu -->
                                                        <button class="btn btn-sm btn-primary reply-message"
                                                            onclick="fetchMessageForReply({{ $message->id }})"
                                                            data-toggle="modal">
                                                            <i class="fas fa-reply"></i>
                                                        </button>

                                                        <!-- Silme Butonu - Form yerine doğrudan buton kullan -->
                                                        <button type="button" class="btn btn-sm btn-danger"
                                                            onclick="deleteMessage({{ $message->id }})">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center">Henüz mesaj yok</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <div>
                                        <span class="text-muted">Toplam {{ $messages->total() ?? 0 }} mesaj</span>
                                    </div>
                                    <div>
                                        {{ $messages->links() ?? '' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mesaj Görüntüleme Modalı -->
    <div class="modal fade" id="viewMessageModal" tabindex="-1" role="dialog" aria-labelledby="viewMessageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header border-0 d-flex justify-content-between align-items-center">
                    <h5 class="modal-title" id="viewMessageModalLabel">Mesaj Detayı</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Kapat">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="message-details">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p><strong>Gönderen:</strong> <span id="modal-sender"></span></p>
                                <p><strong>E-posta:</strong> <span id="modal-email"></span></p>
                            </div>
                            <div class="col-md-6 text-right">
                                <p><strong>Tarih:</strong> <span id="modal-date"></span></p>
                                <p><strong>Durum:</strong> <span id="modal-status"></span></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label><strong>Konu:</strong></label>
                            <p id="modal-subject" class="p-2 bg-light rounded"></p>
                        </div>
                        <div class="form-group">
                            <label><strong>Mesaj:</strong></label>
                            <div id="modal-message" class="p-3 bg-light rounded"
                                style="white-space: pre-line; min-height: 120px;"></div>
                        </div>
                        <div class="form-group" id="reply-container">
                            <label><strong>Cevap:</strong></label>
                            <div id="modal-reply" class="p-3 bg-success-light rounded"
                                style="white-space: pre-line; min-height: 80px;"></div>
                        </div>
                        <!-- Gizli mesaj ID alanı ekle -->
                        <input type="hidden" id="current-message-id" value="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                    <button type="button" class="btn btn-primary" id="openReplyModal">Cevapla</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mesaj Cevaplama Modalı -->
    <div class="modal fade" id="replyMessageModal" tabindex="-1" role="dialog"
        aria-labelledby="replyMessageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header border-0 d-flex justify-content-between align-items-center">
                    <h5 class="modal-title" id="replyMessageModalLabel">Mesajı Cevapla</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Kapat">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="replyForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label><strong>Alıcı:</strong></label>
                            <p id="reply-recipient"></p>
                        </div>
                        <div class="form-group">
                            <label><strong>Konu:</strong></label>
                            <p id="reply-subject"></p>
                        </div>
                        <div class="form-group">
                            <label><strong>Orijinal Mesaj:</strong></label>
                            <div id="reply-original-message" class="p-3 bg-light rounded"
                                style="white-space: pre-line; max-height: 150px; overflow-y: auto;"></div>
                        </div>
                        <div class="form-group">
                            <label for="reply"><strong>Cevabınız:</strong></label>
                            <textarea class="form-control" id="reply" name="reply" rows="5" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                        <button type="submit" class="btn btn-primary" id="send-reply-btn">Cevap Gönder</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .btn-rounded {
            border-radius: 30px;
            padding: 8px 20px;
        }

        .card-body.pt-0 {
            border-top: 0px solid #dee2e6;
            padding-top: 20px !important;
        }

        .card-profile .card-header {
            border-bottom: 0 !important;
        }


        /* Tab geçişlerini daha yumuşak hale getirme */
        .tab-pane.fade {
            transition: all 0.1s ease-in-out;
        }

        /* Profil Kartı için özel stiller */
        .card-profile {
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .avatar-edit label {
            transition: all 0.2s ease;
        }

        .avatar-edit label:hover {
            background: #fff !important;
            transform: scale(1.1);
        }

        .contact-stat {
            padding: 10px 5px;
            transition: all 0.2s ease;
        }

        .contact-stat:hover {
            background-color: #f8f9fa;
        }

        .contact-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 8px;
            transition: transform 0.3s ease;
        }

        .contact-stat:hover .contact-icon {
            transform: scale(1.1);
        }

        .detail {
            font-size: 12px;
            margin-top: 3px;
            color: #6c757d;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }


        /* Form Stilleri */
        .form-group-default {
            background-color: #f7f7f7;
            border-radius: 4px;
            padding: 15px 15px 5px;
            margin-bottom: 15px;
            position: relative;
            transition: all 0.2s ease;
        }

        .form-group-default:hover {
            background-color: #f0f0f0;
        }

        .form-group-default label {
            font-size: 12px;
            color: #777;
            margin-bottom: 5px;
        }

        .form-group-default .form-control {
            border: 0;
            padding: 0;
            background: transparent;
            font-size: 14px;
        }

        .form-group-default .form-control:focus {
            box-shadow: none;
        }

        /* Tablo Stilleri */
        .table td,
        .table th {
            vertical-align: middle;
        }

        /* Liste Grup Stilleri */
        .list-group-item {
            border-left: 0;
            border-right: 0;
            padding: 12px 15px;
        }

        .list-group-item:first-child {
            border-top: 0;
        }

        /* Mesaj detayları için stiller */
        .bg-success-light {
            background-color: #d4edda;
            border-color: #c3e6cb;
        }

        .message-details p {
            margin-bottom: 0.5rem;
        }

        /* Tablo stillerini iyileştir */
        .table-active {
            font-weight: 500;
        }

        .badge-warning {
            background-color: #ffc107;
            color: #212529;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setupModalListeners();

            // Profil resmi değişikliğini otomatik olarak gönder
            document.getElementById('avatar').addEventListener('change', function() {
                const fileSize = this.files[0].size / 1024; // KB cinsinden
                const minSize = {{ config('admin.upload.image.min_size') }};
                const maxSize = {{ config('admin.upload.image.max_size') }};

                if (fileSize < minSize || fileSize > maxSize) {
                    alert(
                        `Dosya boyutu ${minSize}KB ile ${maxSize}KB arasında olmalıdır. Şu anki boyut: ${fileSize.toFixed(2)}KB`
                    );
                    return;
                }

                // Formu gönder
                document.getElementById('avatarForm').submit();
            });

            // URL hash'e göre tab gösterme
            const hash = window.location.hash;
            if (hash) {
                $(`#profileTabs a[href="${hash}"]`).tab('show');
            }

            // Şifre güçlülük kontrolü
            document.getElementById('new_password').addEventListener('input', function() {
                const password = this.value;
                let strength = 0;

                // Uzunluk kontrolü
                if (password.length >= 8) strength += 25;

                // Karakter çeşitliliği kontrolü
                if (/[A-Z]/.test(password)) strength += 25;
                if (/[a-z]/.test(password)) strength += 25;
                if (/[0-9]/.test(password)) strength += 12.5;
                if (/[^A-Za-z0-9]/.test(password)) strength += 12.5;

                const progressBar = document.getElementById('password-strength');
                progressBar.style.width = strength + '%';

                // Renk değiştirme
                if (strength < 30) {
                    progressBar.className = 'progress-bar bg-danger';
                } else if (strength < 60) {
                    progressBar.className = 'progress-bar bg-warning';
                } else if (strength < 80) {
                    progressBar.className = 'progress-bar bg-info';
                } else {
                    progressBar.className = 'progress-bar bg-success';
                }

                progressBar.setAttribute('aria-valuenow', strength);
            });

            // Admin ayarları formu
            document.getElementById('adminSettingsForm').addEventListener('submit', function(e) {
                e.preventDefault();
                // AJAX ile admin ayarlarını kaydetme işlemi
                alert('Admin ayarları kaydedildi');
            });

            // Tab'lar arası geçiş
            $('#profileTabs a').on('click', function(e) {
                e.preventDefault();
                $(this).tab('show');
            });

            // Mesaj detaylarını getir
            window.fetchMessageDetails = function(messageId) {
                apiService.request({
                    baseURL: 'http://127.0.0.1:8000/',
                    url: `/admin/contacts/${messageId}`,
                    method: 'GET',
                    actions: {
                        onSuccess: (response) => {
                            const data = response.data;

                            // Modal içeriğini doldur
                            document.getElementById('modal-sender').textContent = data.name;
                            document.getElementById('modal-email').textContent = data.email;
                            document.getElementById('modal-date').textContent = new Date(data
                                    .created_at)
                                .toLocaleString('tr-TR');
                            document.getElementById('modal-subject').textContent = data.subject;
                            document.getElementById('modal-message').textContent = data.message;

                            // Mesaj ID'sini sakla
                            document.getElementById('current-message-id').value = messageId;

                            // Cevap kontrolü
                            const replyContainer = document.getElementById('reply-container');
                            if (data.reply) {
                                replyContainer.style.display = 'block';
                                document.getElementById('modal-reply').textContent = data.reply;
                            } else {
                                replyContainer.style.display = 'none';
                            }

                            // Okunma durumu
                            const statusSpan = document.getElementById('modal-status');
                            if (data.is_read) {
                                statusSpan.textContent = 'Okundu';
                                statusSpan.className = 'badge badge-success';
                            } else {
                                statusSpan.textContent = 'Yeni';
                                statusSpan.className = 'badge badge-warning';

                                // Otomatik okundu olarak işaretle
                                markAsRead(messageId);
                            }

                            return false; // ApiService varsayılan işlemlerini engelle
                        },
                        onError: (error) => {
                            console.error('Mesaj detayları alınırken hata oluştu:', error);
                            return false;
                        }
                    }
                });
            };

            // Mesajı cevaplamak için detayları getir
            window.fetchMessageForReply = function(messageId) {
                showModal('#replyMessageModal');
                apiService.request({
                    baseURL: 'http://127.0.0.1:8000/',
                    url: `/admin/contacts/${messageId}`,
                    method: 'GET',
                    actions: {
                        onSuccess: (response) => {
                            const data = response.data;

                            // Cevap modalını doldur
                            document.getElementById('reply-recipient').textContent =
                                `${data.name} <${data.email}>`;
                            document.getElementById('reply-subject').textContent = data.subject;
                            document.getElementById('reply-original-message').textContent = data
                                .message;

                            // Cevap gönderme butonuna ID ekle
                            const replyButton = document.querySelector(
                                '#replyMessageModal .btn-primary');
                            replyButton.setAttribute('data-id', messageId);
                            replyButton.onclick = function() {
                                submitReply(messageId);
                            };

                            return false;
                        },
                        onError: (error) => {
                            console.error('Mesaj detayları alınırken hata oluştu:', error);
                            return false;
                        }
                    }
                });
            };

            // Mesajı okundu olarak işaretle
            window.markAsRead = function(messageId) {
                apiService.request({
                    baseURL: 'http://127.0.0.1:8000/',
                    url: `/admin/contacts/${messageId}/read`,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    actions: {
                        onSuccess: (response) => {
                            console.log('Mesaj okundu olarak işaretlendi');
                            // UI'da mesaj durumunu güncelle
                            updateMessageStatusInUI(messageId, true);
                            return false;
                        }
                    }
                });
            };

            // Mesaja cevap gönder
            window.submitReply = function(messageId) {
                const replyText = document.getElementById('reply').value;

                if (!replyText.trim()) {
                    alert('Lütfen bir cevap yazın!');
                    return;
                }

                apiService.request({
                    baseURL: 'http://127.0.0.1:8000/',
                    url: `/admin/contacts/${messageId}/reply`,
                    method: 'POST',
                    data: {
                        reply: replyText
                    },
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    actions: {
                        success: {
                            message: 'Cevabınız başarıyla gönderildi!',
                            callback: function() {
                                // Modal'ı kapat ve UI'ı güncelle
                                disposeModal('#replyMessageModal');
                                updateMessageStatusInUI(messageId, true);
                            }
                        },
                        errors: {
                            message: 'Cevap gönderilirken bir hata oluştu!'
                        }
                    }
                });
            };

            // Mesajı sil
            window.deleteMessage = function(messageId) {
                apiService.request({
                    baseURL: 'http://127.0.0.1:8000/',
                    url: `/admin/contacts/${messageId}`,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                            .getAttribute('content')
                    },
                    showConfirm: {
                        enabled: true,
                        title: 'Mesaj Silme Onayı',
                        text: 'Bu işlemi gerçekleştirmek istediğinize emin misiniz?',
                        icon: 'warning',
                        confirmButtonText: 'Evet, Sil',
                        cancelButtonText: 'İptal',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33'
                    },
                    actions: {
                        success: {
                            message: 'Mesaj başarıyla silindi!',
                            callback: function() {
                                // Mesaj satırını tablodan kaldır
                                removeMessageFromUI(messageId);
                            }
                        },
                        errors: {
                            message: 'Mesaj silinirken bir hata oluştu!'
                        }
                    }
                });
            };

            // UI güncelleme fonksiyonları
            window.updateMessageStatusInUI = function(messageId, isRead) {
                const row = document.querySelector(`tr[data-message-id="${messageId}"]`);
                if (row) {
                    const statusSpan = row.querySelector('.badge');
                    if (statusSpan) {
                        if (isRead) {
                            statusSpan.textContent = 'Okundu';
                            statusSpan.className = 'badge badge-success';
                            row.classList.remove('table-active'); // Bold yazıyı kaldır
                        } else {
                            statusSpan.textContent = 'Yeni';
                            statusSpan.className = 'badge badge-warning';
                            row.classList.add('table-active');
                        }
                    }
                }
            };

            window.removeMessageFromUI = function(messageId) {
                const row = document.querySelector(`tr[data-message-id="${messageId}"]`);
                if (row) {
                    row.remove();
                    // Eğer tablo boş kaldıysa "Henüz mesaj yok" mesajını göster
                    const tbody = document.querySelector('#messagesTable tbody');
                    if (tbody && tbody.children.length === 0) {
                        tbody.innerHTML = '<tr><td colspan="6" class="text-center">Henüz mesaj yok</td></tr>';
                    }
                }
            };

            // Modallar için buton event listener'lar
            document.querySelectorAll('.view-message').forEach(button => {
                button.removeAttribute('data-id'); // data-id özelliğini kaldır
            });

            document.querySelectorAll('.reply-message').forEach(button => {
                button.removeAttribute('data-id'); // data-id özelliğini kaldır
            });

            // Şu şekilde değiştirin:
            document.getElementById('replyForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const messageId = this.action.split('/').pop(); // URL'den ID'yi çıkar
                submitReply(messageId);
            });

            document.getElementById('viewMessageButton').addEventListener('click', function() {
                showModal('#viewMessageModal');
            });

            document.getElementById('replyMessageButton').addEventListener('click', function() {
                showModal('#replyMessageModal');
            });

            // Mesaj arama
            document.getElementById('searchButton').addEventListener('click', function() {
                const searchTerm = document.getElementById('messageSearch').value.toLowerCase();
                const table = document.getElementById('messagesTable');
                const rows = table.querySelectorAll('tbody tr');

                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    if (text.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });

            // "Cevapla" butonunu yakalama (viewMessageModal içindeki Cevapla butonu)
            if (document.getElementById('openReplyModal')) {
                document.getElementById('openReplyModal').addEventListener('click', function() {
                    // Mesaj ID'sini al
                    const messageId = document.getElementById('current-message-id').value;

                    if (!messageId) {
                        console.error('Mesaj ID bulunamadı!');
                        alert('Mesaj bilgilerine erişilemiyor. Lütfen sayfayı yenileyip tekrar deneyin.');
                        return;
                    }

                    // View modalını kapat
                    disposeModal('#viewMessageModal');

                    // Cevap modalını hazırla ve aç
                    setTimeout(() => {
                        fetchMessageForReply(messageId);
                    }, 100);
                });
            }
        }); // 300ms timeout ekleyerek DOM işlemlerinin tamamlanmasını bekle
    </script>
@endpush
