@extends('layouts.admin.master')

@section('title', 'Portfolyo Görselleri')

@section('route', route('admin.portfolioImages', ['id' => $portfolio->id]))

@section('content')
    <div class="page-inner">
        @include('layouts.admin.partials.page-header')
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title" id="portfolioName">'{{ $portfolio->name }}' İsimli Portfolyo Görselleri</h4>
                        <button class="btn btn-primary btn-round ms-auto" onclick="showModal('#addRowModal')">
                            <i class="fa fa-plus"></i>
                            Görsel Ekle
                        </button>
                        <button onclick="window.location.href='{{ route('admin.portfolios') }}'"
                            class="btn btn-outline-primary btn-round ms-2">
                            <i class="fa fa-arrow-left"></i>
                            Portfolyo Listesine Geri Dön
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Modal -->

                    <!-- Görsel Ekleme Modalı -->
                    <div class="modal fade" id="addRowModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Yeni Görsel Ekle</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Kapat"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="addImageForm">
                                        <input type="hidden" name="portfolio_id" value="{{ $portfolio->id }}">

                                        <!-- Dosya Seçme Alanı -->
                                        <div class="form-group mb-3">
                                            <label for="imageInput" class="form-label">Görsel Seçin</label>
                                            <input type="file" class="form-control" id="imageInput" name="images[]"
                                                accept="image/jpeg,image/png,image/jpg,image/svg+xml" multiple>
                                            <div class="form-text text-muted">
                                                JPEG, PNG, JPG veya SVG formatında görseller seçebilirsiniz. Maksimum boyut:
                                                2MB
                                            </div>
                                        </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                                    <button type="submit" class="btn btn-primary" id="saveImagesBtn">Görselleri
                                        Kaydet</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Görsel Modalı -->
                    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="imageModalLabel">Portfolyo Görseli</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Kapat"></button>
                                </div>
                                <div class="modal-body text-center p-0">
                                    <img src="" id="modalImage" class="img-fluid w-100" alt="Portfolyo Görseli">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="add-row" class="display table table-hover">
                            <thead>
                                <tr>
                                    <th>AKTİF</th>
                                    <th>RESİM</th>
                                    <th>SIRASI</th>
                                    <th>EKLENME TARİHİ</th>
                                    <th style="width: 10%" class="text-center">İŞLEMLER</th>
                                </tr>
                            </thead>
                            <tbody id="portfolioImagesList">
                                <!-- CV Listeleme Dinamik İçerik -->

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
@endpush

@push('scripts')
    <script>
        var portfolioApiService;
        var formEntegrator;
        var portfolioId = {{ $portfolio->id }};
        document.addEventListener('DOMContentLoaded', function() {

            setTimeout(() => {
                portfolioApiService = window.apiService;
                formEntegrator = window.integrator;
                setupModalListeners();
                loadImages();
            }, 100);

        });

        // Ana görsel yapma fonksiyonu
        function setMainImage(imageId) {
            portfolioApiService.request({
                url: `portfolios/images/set-main-image/${portfolioId}`,
                method: 'POST',
                data: {
                    image_id: imageId
                },
                sweetalert2: true,
                actions: {
                    onSuccess: () => {
                        loadImages(portfolioId);
                    },
                    success: {
                        message: 'Ana görsel başarıyla güncellendi'
                    },
                    errors: {
                        message: 'Ana görsel güncellenirken bir hata oluştu'
                    }
                }
            });
        }

        function setActive(portfolioId) {
            portfolioApiService.request({
                url: `/portfolio-images/set-active/${portfolioId}`,
                method: 'POST',
                sweetalert2: true,
                actions: {
                    onSuccess: () => {
                        const activeInputs = document.querySelectorAll('.active-status-input');
                        activeInputs.forEach(input => {
                            if (input.value == cvId) {
                                input.checked = true;
                                input.disabled = true;
                            } else {
                                input.checked = false;
                                input.disabled = false;
                            }
                        });
                    },
                    errors: {
                        message: 'CV aktif durumu güncellenirken bir hata oluştu.'
                    },
                    success: {
                        message: 'CV başarıyla aktif edildi.'
                    }
                }
            });
        }

        function setupTooltipListeners() {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }

        function loadImages() {
            const portfolioImagesList = document.getElementById('portfolioImagesList');


            portfolioImagesList.innerHTML = `
            <tr id="loading-row">
              <td colspan="8" class="text-center">
                    <div class="d-flex justify-content-center align-items-center py-4">
                             <div class="position-relative">
                                 <div class="spinner-border text-primary spinner-border-lg" style="width: 3rem; height: 3rem;" role="status">
                                 <span class="visually-hidden">Yükleniyor...</span>
                                 </div>
                             </div>
                             <div class="ms-4">
                                 <h5 class="text-primary mb-1 fw-bold">Portfolyo Görselleri Yükleniyor</h5>
                                 <div class="text-muted">
                                     <small>Lütfen bekleyiniz, veriler hazırlanıyor...</small>
                                 </div>
                             </div>
                    </div>
              </td>
            </tr>
            `;

            portfolioApiService.request({
                url: 'portfolios/images/' + portfolioId,
                method: 'GET',
                sweetalert2: false,
                disableNotifications: true,
                actions: {
                    onSuccess: (response) => {
                        portfolioImagesList.innerHTML = '';
                        if (response.data.data.length > 0) {
                            response.data.data.forEach(imageInfo => {
                                portfolioImagesList.innerHTML += `
                                    <tr ${imageInfo.is_main ? 'class="table-primary"' : ''}>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input active-status-input" type="radio" name="active"
                                                    value="${imageInfo.id}" ${imageInfo.is_active ? 'checked disabled' : ''} onclick="setActive(${imageInfo.id})">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="avatar">
                                                <img src="${imageInfo.image_path ? imageInfo.image_path : '/assets/images/no-image.png'}"
                                                    alt="${imageInfo.name || 'Portfolyo Resmi'}"
                                                    class="avatar-img rounded"
                                                    style="cursor:pointer;"
                                                    onclick="openImageModal('${imageInfo.image_path ? imageInfo.image_path : '/assets/images/no-image.png'}', '${imageInfo.name || 'Portfolyo Resmi'}')">
                                            </div>
                                        </td>
                                        <td>${imageInfo.sort_order ?? 'Belirtilmemiş' }</td>
                                        <td>${imageInfo.created_at ? new Date(imageInfo.created_at).toLocaleDateString('tr-TR') : 'Belirtilmemiş' }</td>
                                        <td>
                                            <div class="form-button-action">
                                                <button type="button" 
                                                    class="btn btn-link btn-primary btn-lg set-main-btn"
                                                    data-bs-toggle="tooltip"
                                                    title="Ana Görsel Yap"
                                                    onclick="setMainImage(${imageInfo.id})">
                                                    <i class="fa fa-certificate"></i>
                                                </button>
                                                <button type="button"
                                                    class="btn btn-link btn-primary btn-lg delete-btn"
                                                    data-bs-toggle="tooltip"
                                                    title="Sil"
                                                    onclick="deleteImage(${imageInfo.id})">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                `;
                            });
                        } else {
                            portfolioImagesList.innerHTML = `
                                <tr>
                                    <td colspan="8" class="text-center">Henüz kaydedilmiş portfolyo görselleri bulunmamaktadır.</td>
                                </tr>
                                `;
                        }
                    }
                }
            });
        }

        // Fonksiyonlar
        function loadCvDetail(cvId) {
            cvApiService.request({
                url: `/cv-information/${cvId}`,
                method: 'GET',
                sweetalert2: false,
                disableNotifications: true,
                actions: {
                    onSuccess: (response) => {
                        if (response.data) {
                            const cvInfo = response.data.data;
                            const detailContent = document.getElementById('cvDetailContent');

                            // Profil üst kısmı
                            let html = `
                    <div class="bg-light p-4 border-bottom">
                        <div class="row align-items-center">
                            <div class="col-md-2 text-center">
                                <img src="${cvInfo.image ? cvInfo.image : '/assets/img/default-avatar.jpg'}" alt="Profil Resmi"
                                    class="img-fluid rounded-circle border shadow-sm"
                                    style="width: 120px; height: 120px; object-fit: cover;">
                            </div>
                            <div class="col-md-7">
                                <h3 class="mb-1">${cvInfo.name || 'İsimsiz'}</h3>
                                <p class="text-primary mb-2"><i class="fa fa-briefcase me-2"></i>${cvInfo.position || '-'}</p>
                                <p class="mb-2"><i class="fa fa-envelope me-2"></i>${cvInfo.email || '-'}</p>
                                <p class="mb-0"><i class="fa fa-phone me-2 text-muted"></i>${cvInfo.phone || '-'}</p>
                            </div>
                            <div class="col-md-3 text-md-end mt-3 mt-md-0">
                                <div class="d-flex flex-column align-items-end">
                                    <a href="${cvInfo.cv_file ? cvInfo.cv_file : '#'}" 
                                       class="btn btn-outline-primary btn-sm d-inline-flex align-items-center px-3"
                                       ${!cvInfo.cv_file ? 'disabled' : 'target="_blank"'}>
                                        <i class="fa fa-download me-2"></i>CV İndir
                                    </a>
                                    
                                    <div class="mt-3">
                                        <span class="badge ${cvInfo.is_active ? 'bg-success' : 'bg-secondary'} py-2 px-3 d-inline-flex align-items-center">
                                            <i class="fa fa-${cvInfo.is_active ? 'check-circle' : 'times-circle'} me-2"></i>
                                            ${cvInfo.is_active ? 'Aktif' : 'Pasif'}
                                        </span>
                                    </div>
                                    
                                    <div class="mt-3 small text-muted d-flex align-items-center">
                                        <i class="fa fa-calendar me-2"></i> 
                                        <span>Doğum: ${cvInfo.birthday ? new Date(cvInfo.birthday).toLocaleDateString('tr-TR') : '-'}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;

                            // Diğer detay içeriği
                            html += `
                    <div class="container-fluid p-4">
                        <div class="row">
                            <!-- Sol Kolon -->
                            <div class="col-md-4">
                                <!-- Profesyonel Bilgiler -->
                                <div class="card border-0 shadow-sm mb-4">
                                    <div class="card-header bg-white">
                                        <h6 class="mb-0 fw-bold"><i class="fa fa-chart-line text-primary me-2"></i>Profesyonel
                                            Özet</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row text-center">
                                            <div class="col-4">
                                                <div class="p-3">
                                                    <h3 class="text-primary mb-0">${cvInfo.experience || '-'}</h3>
                                                    <small class="text-muted">Yıl Tecrübe</small>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="p-3">
                                                    <h3 class="text-primary mb-0">${cvInfo.projects || '-'}</h3>
                                                    <small class="text-muted">Proje</small>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="p-3">
                                                    <h3 class="text-primary mb-0">${cvInfo.clients || '-'}</h3>
                                                    <small class="text-muted">Müşteri</small>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span>Freelance Durumu:</span>
                                            <span
                                                class="badge ${cvInfo.freelance == 1 ? 'bg-success' : 'bg-danger'} rounded-pill">
                                                ${cvInfo.freelance == 1 ? 'Müsait' : 'Müsait Değil'}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                ${cvInfo.slogan && cvInfo.slogan.length > 0 ? `
                                                                                                                                                                                                        <div class="card border-0 shadow-sm mb-4">
                                                                                                                                                                                                            <div class="card-header bg-white">
                                                                                                                                                                                                                <h6 class="mb-0 fw-bold"><i class="fa fa-quote-left text-primary me-2"></i>Sloganlar
                                                                                                                                                                                                                </h6>
                                                                                                                                                                                                            </div>
                                                                                                                                                                                                            <div class="card-body p-0">
                                                                                                                                                                                                                <div class="list-group list-group-flush">
                                                                                                                                                                                                                    ${cvInfo.slogan.map(slogan => `
                                            <div class="list-group-item border-0 d-flex">
                                                <i class="fa fa-angle-right text-primary me-2 mt-1"></i>
                                                <span>${slogan}</span>
                                            </div>
                                            `).join('')}
                                                                                                                                                                                                                </div>
                                                                                                                                                                                                            </div>
                                                                                                                                                                                                        </div>
                                                                                                                                                                                                        ` : ''}
                            </div>

                            <!-- Sağ Kolon -->
                            <div class="col-md-8">
                                <!-- Kişisel Bilgiler -->
                                <div class="card border-0 shadow-sm mb-4">
                                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0 fw-bold"><i class="fa fa-user text-primary me-2"></i>Kişisel Bilgiler
                                        </h6>
                                        <span class="badge bg-light text-dark">${cvInfo.degree || '-'}</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <h6 class="text-muted mb-2"><i class="fa fa-map-marker-alt me-2"></i>Adres</h6>
                                                <p class="mb-0">${cvInfo.address || '-'}</p>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="alert alert-light border mb-0">
                                                    <div class="d-flex">
                                                        <div class="me-3">
                                                            <i class="fa fa-info-circle text-primary fa-2x"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="alert-heading">Ek Bilgiler</h6>
                                                            <p class="mb-0 small">Bu kişi ${cvInfo.experience || '-'} yıllık deneyime
                                                            sahip ve şu ana kadar ${cvInfo.projects || '-'} projede yer almıştır.
                                                            Toplamda ${cvInfo.clients || '-'} müşteri ile çalışmıştır.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Yetenekler ve Beceriler (Örnek) -->
                                <div class="card border-0 shadow-sm">
                                    <div class="card-header bg-white">
                                        <h6 class="mb-0 fw-bold"><i class="fa fa-star text-primary me-2"></i>Yetenekler ve
                                            Beceriler</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <h6 class="small fw-bold mb-2">Teknik Beceriler</h6>
                                                <div class="progress mb-2" style="height: 8px;">
                                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 85%;"
                                                    aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <div class="d-flex justify-content-between small">
                                                    <span>Programlama</span>
                                                    <span>85%</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <h6 class="small fw-bold mb-2">Dil Becerileri</h6>
                                                <div class="progress mb-2" style="height: 8px;">
                                                    <div class="progress-bar bg-success" role="progressbar" style="width: 75%;"
                                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <div class="d-flex justify-content-between small">
                                                    <span>İngilizce</span>
                                                    <span>75%</span>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="d-flex flex-wrap gap-2 mt-2">
                                                    <span class="badge bg-light text-dark border">HTML/CSS</span>
                                                    <span class="badge bg-light text-dark border">JavaScript</span>
                                                    <span class="badge bg-light text-dark border">PHP</span>
                                                    <span class="badge bg-light text-dark border">Laravel</span>
                                                    <span class="badge bg-light text-dark border">MySQL</span>
                                                    <span class="badge bg-light text-dark border">Git</span>
                                                    <span class="badge bg-light text-dark border">Docker</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="card border-0 shadow-sm mt-4">
                                    <div class="card-header bg-white">
                                        <h6 class="mb-0 fw-bold"><i class="fa fa-share-alt text-primary me-2"></i>Sosyal Medya
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-borderless">
                                            <tr>
                                                ${cvInfo.social_media && cvInfo.social_media.linkedin ? `
                                                                                                                                                                                                                        <td style="width: 33.333%; padding: 5px;">
                                                                                                                                                                                                                            <a href="${cvInfo.social_media.linkedin}" 
                                                                                                                                                                                                                            class="btn btn-outline-secondary w-100 py-2" target="_blank">
                                                                                                                                                                                                                                <i class="fab fa-linkedin fa-fw fa-lg"></i> <span class="fs-6">LinkedIn</span>
                                                                                                                                                                                                                            </a>
                                                                                                                                                                                                                        </td>
                                                                                                                                                                                                                        ` : ''}

                                                ${cvInfo.social_media && cvInfo.social_media.github ? `
                                                                                                                                                                                                                        <td style="width: 33.333%; padding: 5px;">
                                                                                                                                                                                                                            <a href="${cvInfo.social_media.github}"
                                                                                                                                                                                                                            class="btn btn-outline-secondary w-100 py-2" target="_blank">
                                                                                                                                                                                                                                <i class="fab fa-github fa-fw fa-lg"></i> <span class="fs-6">GitHub</span>
                                                                                                                                                                                                                            </a>
                                                                                                                                                                                                                        </td>
                                                                                                                                                                                                                        ` : ''}

                                                ${cvInfo.social_media && cvInfo.social_media.twitter ? `
                                                                                                                                                                                                                        <td style="width: 33.333%; padding: 5px;">
                                                                                                                                                                                                                            <a href="${cvInfo.social_media.twitter}"
                                                                                                                                                                                                                            class="btn btn-outline-secondary w-100 py-2" target="_blank">
                                                                                                                                                                                                                                <i class="fab fa-twitter fa-fw fa-lg"></i> <span class="fs-6">Twitter</span>
                                                                                                                                                                                                                            </a>
                                                                                                                                                                                                                        </td>
                                                                                                                                                                                                                        ` : ''}
                                            </tr>
                                            <tr>
                                                ${cvInfo.social_media && cvInfo.social_media.facebook ? `
                                                                                                                                                                                                                        <td style="width: 33.333%; padding: 5px;">
                                                                                                                                                                                                                            <a href="${cvInfo.social_media.facebook}"
                                                                                                                                                                                                                            class="btn btn-outline-secondary w-100 py-2" target="_blank">
                                                                                                                                                                                                                                <i class="fab fa-facebook fa-fw fa-lg"></i> <span class="fs-6">Facebook</span>
                                                                                                                                                                                                                            </a>
                                                                                                                                                                                                                        </td>
                                                                                                                                                                                                                        ` : ''}

                                                ${cvInfo.social_media && cvInfo.social_media.instagram ? `
                                                                                                                                                                                                                        <td style="width: 33.333%; padding: 5px;">
                                                                                                                                                                                                                            <a href="${cvInfo.social_media.instagram}"
                                                                                                                                                                                                                            class="btn btn-outline-secondary w-100 py-2" target="_blank">
                                                                                                                                                                                                                                <i class="fab fa-instagram fa-fw fa-lg"></i> <span class="fs-6">Instagram</span>
                                                                                                                                                                                                                            </a>
                                                                                                                                                                                                                        </td>
                                                                                                                                                                                                                        ` : ''}

                                                ${cvInfo.social_media && cvInfo.social_media.website ? `
                                                                                                                                                                                                                        <td style="width: 33.333%; padding: 5px;">
                                                                                                                                                                                                                            <a href="${cvInfo.social_media.website}"
                                                                                                                                                                                                                            class="btn btn-outline-secondary w-100 py-2" target="_blank">
                                                                                                                                                                                                                                <i class="fa fa-globe fa-fw fa-lg"></i> <span class="fs-6">Website</span>
                                                                                                                                                                                                                            </a>
                                                                                                                                                                                                                        </td>
                                                                                                                                                                                                                        ` : ''}
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;

                            detailContent.innerHTML = html;
                            // Yazdır butonunun onclick metodunu güncelle
                            const printButton = document.querySelector('#cvDetailPrintButton');
                            if (printButton) {
                                printButton.setAttribute('onclick', `printCVData(${JSON.stringify(cvInfo)})`);
                            }

                            // Modal'ı göster
                            showModal('#cvDetailModal');
                        }
                        return true;
                    },
                    onError: (error) => {
                        console.error('Hata:', error);
                        return true;
                    },
                    errors: {
                        message: 'CV bilgileri alınamadı'
                    },
                    success: {
                        message: 'CV bilgileri alındı'
                    }
                }
            });
        }

        function deleteImage(imageId) {
            portfolioApiService.request({
                url: `/portfolios/images/delete/${imageId}`,
                method: 'DELETE',
                sweetalert2: true,
                showConfirm: {
                    enabled: true,
                    title: 'Portfolyo Görseli Silme Onayı',
                    text: 'Bu işlemi gerçekleştirmek istediğinize emin misiniz?',
                    icon: 'warning',
                    confirmButtonText: 'Evet, Sil',
                    cancelButtonText: 'İptal',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33'
                },
                actions: {
                    onSuccess: () => {
                        loadImages();
                    },
                    success: {
                        message: 'Portfolyo görseli silindi'
                    },
                    errors: {
                        message: 'Portfolyo görseli silinemedi'
                    }
                }
            });
        }
    </script>

    <!-- Görsel Modalı -->
    <script>
        // Görsel modalı açmak için fonksiyon
        function openImageModal(imageUrl, imageTitle) {
            // Modal başlığını ayarla
            document.getElementById('imageModalLabel').textContent = imageTitle;

            // Modal görselini ayarla
            const modalImage = document.getElementById('modalImage');
            modalImage.src = imageUrl;
            modalImage.alt = imageTitle;

            // Modal'ı açmak için
            showModal('#imageModal');
        }

        // Görsel yüklendiğinde
        document.getElementById('modalImage').addEventListener('load', function() {
            // Görsel yüklenmezse veya hatalıysa alternatif görsel göster
            this.onerror = function() {
                this.src = '{{ asset('images/no-image.png') }}';
            };
        });
    </script>
@endpush
