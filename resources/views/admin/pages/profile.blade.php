@extends('layouts.admin.master')

@section('title', 'Profil Bilgileri')

@section('route', route('admin.profile'))

@section('content')
    <div class="page-inner">
        @include('layouts.admin.partials.page-header')
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title" id="portfolioName">'{{ $portfolio->name }}' İsimli Proje Görselleri</h4>
                        <button class="btn btn-primary btn-round ms-auto" onclick="showModal('#addRowModal')">
                            <i class="fa fa-plus"></i>
                            Görsel Ekle
                        </button>
                        <button onclick="window.location.href='{{ route('admin.portfolios') }}'"
                            class="btn btn-outline-primary btn-round ms-2">
                            <i class="fa fa-arrow-left"></i>
                            Proje Listesine Geri Dön
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
                                    <h5 class="modal-title" id="imageModalLabel">Proje Görseli</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Kapat"></button>
                                </div>
                                <div class="modal-body text-center p-0">
                                    <img src="" id="modalImage" class="img-fluid w-100" alt="Proje Görseli">
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
                                    <th class="sortable-handle" style="width: 40px;"><i class="fa fa-sort"></i></th>
                                    <th>ANA GÖRSEL</th>
                                    <th>GÖRÜNÜR</th>
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
    <style>
        /* Sürüklenebilir öğeler için stil */
        .sortable-ghost {
            opacity: 0.5;
            background: #c8ebfb;
        }

        .sortable-handle {
            cursor: move;
            cursor: -webkit-grabbing;
        }

        .sortable-chosen {
            background-color: #f8f9fa;
        }

        /* Sürükleme ipucu stil */
        .drag-hint {
            font-size: 12px;
            color: #6c757d;
            margin-top: 10px;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
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

                // Kaydetme başarısı ve hatalar için listener ekleyelim
                document.addEventListener('orderSaved', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sıralama Kaydedildi',
                        toast: true,
                        position: 'bottom-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                });

                document.addEventListener('orderError', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Sıralama Kaydedilemedi',
                        toast: true,
                        position: 'bottom-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                });
            }, 100);

        });

        function deleteImage(imageId) {
            portfolioApiService.request({
                url: `/portfolios/images/delete/${imageId}`,
                method: 'DELETE',
                sweetalert2: true,
                showConfirm: {
                    enabled: true,
                    title: 'Proje Görseli Silme Onayı',
                    text: 'Bu işlemi gerçekleştirmek istediğinize emin misiniz?',
                    icon: 'warning',
                    confirmButtonText: 'Evet, Sil',
                    cancelButtonText: 'İptal',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33'
                },
                actions: {
                    onSuccess: (response) => {
                        // Sayfayı yenilemek yerine sadece ilgili satırı kaldır
                        removeImageRow(imageId);

                        // Başarı mesajı
                        Swal.fire({
                            icon: 'success',
                            title: 'Görsel Silindi',
                            text: 'Proje görseli başarıyla silindi',
                            toast: true,
                            position: 'bottom-end',
                            showConfirmButton: false,
                            timer: 3000
                        });

                        // Eğer tablo boşsa, boş mesajını göster
                        checkEmptyTable();
                    },
                    onError: (error) => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Hata',
                            text: 'Görsel silinirken bir hata oluştu',
                            toast: true,
                            position: 'bottom-end',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    },
                    success: {
                        message: 'Proje görseli silindi'
                    },
                    errors: {
                        message: 'Proje görseli silinemedi'
                    }
                }
            });
        }

        // Silinen görseli DOM'dan kaldır
        function removeImageRow(imageId) {
            const row = document.querySelector(`#portfolioImagesList tr[data-id="${imageId}"]`);
            if (row) {
                // Silinme animasyonu ekleyelim
                row.style.transition = 'all 0.3s ease';
                row.style.opacity = '0';
                row.style.transform = 'translateX(20px)';

                // Animasyon bittikten sonra DOM'dan kaldır
                setTimeout(() => {
                    row.remove();

                    // Sıralama numaralarını güncelle
                    updateSortOrderNumbers();

                    // Eğer silinen görsel ana görselse, başka bir görseli ana görsel yap
                    checkMainImage(imageId);
                }, 300);
            }
        }

        // Silinen görsel ana görselse, başka bir görseli ana görsel yap
        function checkMainImage(deletedImageId) {
            const wasMainImage = document.querySelector(
                `#portfolioImagesList tr[data-id="${deletedImageId}"].table-primary`);

            if (wasMainImage) {
                // Eğer görseller kaldıysa, ilk görseli ana görsel yap
                const firstImage = document.querySelector('#portfolioImagesList tr[data-id]');
                if (firstImage) {
                    const firstImageId = firstImage.getAttribute('data-id');
                    // Sessizce API'ye gönder ve UI'ı güncelle (bildirim gösterme)
                    setMainImage(firstImageId, true); // true parametresi sessiz modda çalıştırır
                }
            }
        }

        // Sıralama numaralarını güncelle
        function updateSortOrderNumbers() {
            const rows = document.querySelectorAll('#portfolioImagesList tr[data-id]');
            rows.forEach((row, index) => {
                const sortOrderCell = row.querySelector('.sort-order-value');
                if (sortOrderCell) {
                    sortOrderCell.textContent = index;
                    row.setAttribute('data-sort', index);
                }
            });
        }

        // Tablo boşsa "Henüz görsel yok" mesajını göster
        function checkEmptyTable() {
            const tableBody = document.getElementById('portfolioImagesList');
            const rows = tableBody.querySelectorAll('tr[data-id]');

            if (rows.length === 0) {
                tableBody.innerHTML = `
            <tr>
                <td colspan="8" class="text-center">Henüz kaydedilmiş proje görselleri bulunmamaktadır.</td>
            </tr>
        `;
            }
        }

        // setMainImage fonksiyonunu güncelleyelim (silent parametresi ekleyelim)
        function setMainImage(imageId, silent = false) {
            // Önce UI'ı güncelle
            updateMainImageUI(imageId);

            // Sonra API isteği gönder
            portfolioApiService.request({
                url: `portfolios/images/set-main-image/${portfolioId}`,
                method: 'POST',
                data: {
                    image_id: imageId
                },
                sweetalert2: !silent, // Sessiz modda SweetAlert2 gösterme
                actions: {
                    onSuccess: () => {
                        // Başarı mesajı (sessiz modda gösterme)
                        if (!silent) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Ana görsel başarıyla güncellendi',
                                toast: true,
                                position: 'bottom-end',
                                showConfirmButton: false,
                                timer: 3000
                            });
                        }
                    },
                    onError: () => {
                        // Hata durumunda UI'ı eski haline döndür
                        if (silent) {
                            // Sessiz modda sadece yeniden yükle
                            loadImages();
                        }
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

        function updateMainImageUI(selectedId) {
            // Tüm radio buttonları ve satırları güncelle
            const rows = document.querySelectorAll('#portfolioImagesList tr[data-id]');
            rows.forEach(row => {
                const rowId = row.getAttribute('data-id');
                const isMain = rowId == selectedId;

                // Satır arkaplan rengini güncelle
                if (isMain) {
                    row.classList.add('table-primary');
                } else {
                    row.classList.remove('table-primary');
                }

                // Radio button ve badge'i güncelle
                const radio = row.querySelector('.active-status-input');
                const badge = row.querySelector('.badge');

                if (radio) {
                    radio.checked = isMain;
                    radio.disabled = isMain; // Seçili olanı disable et
                }

                if (badge) {
                    badge.className = `badge ${isMain ? 'bg-primary' : 'bg-light text-dark'}`;
                    badge.innerHTML = isMain ? '<i class="fa fa-star me-1"></i> Ana Görsel' : 'Ana Görsel Yap';
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
                         <h5 class="text-primary mb-1 fw-bold">Proje Görselleri Yükleniyor</h5>
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
                            // Görsel verilerini sıralama numarasına göre sırala
                            const sortedImages = response.data.data.sort((a, b) => (a.sort_order || 999) - (b
                                .sort_order || 999));

                            sortedImages.forEach(imageInfo => {
                                console.log(imageInfo);
                                portfolioImagesList.innerHTML += `
            <tr ${imageInfo.is_main ? 'class="table-primary"' : ''} data-id="${imageInfo.id}" data-sort="${imageInfo.sort_order || 0}">
                <td class="sortable-handle text-center">
                    <i class="fa fa-grip-vertical text-muted"></i>
                </td>
                <td>
                <div class="form-check d-flex align-items-center">
                    <input class="form-check-input active-status-input" type="radio" name="active"
                        value="${imageInfo.id}" ${imageInfo.is_main ? 'checked' : ''} 
                        onclick="setMainImage(${imageInfo.id})">
                    <label class="form-check-label ms-2" for="mainImage_${imageInfo.id}">
                        <span class="badge ${imageInfo.is_main ? 'bg-primary' : 'bg-light text-dark'}">
                            ${imageInfo.is_main ? '<i class="fa fa-star me-1"></i> Ana Görsel' : 'Ana Görsel Yap'}
                        </span>
                    </label>
                </div>
            </td>
                <!-- GÖRÜNÜR OLMA DURUMU -->
                <td>
                    <div class="form-check form-switch">
                        <input class="form-check-input is-active-switch" type="checkbox" 
                            id="isActiveSwitch${imageInfo.id}" 
                            ${imageInfo.is_active ? 'checked' : ''} 
                            onchange="toggleActiveStatus(${imageInfo.id}, this.checked)">
                        <label class="form-check-label" for="isActiveSwitch${imageInfo.id}">
                            ${imageInfo.is_active ? 'Aktif' : 'Pasif'}
                        </label>
                    </div>
                </td>
                <td>
                    <div class="avatar">
                        <img src="${imageInfo.image_path ? imageInfo.image_path : '/assets/img/no-image.png'}"
                            alt="${imageInfo.name || 'Proje Resmi'}"
                            class="avatar-img rounded"
                            style="cursor:pointer;"
                            onclick="openImageModal('${imageInfo.image_path ? imageInfo.image_path : '/assets/img/no-image.png'}', '${imageInfo.name || 'Proje Resmi'}')">
                    </div>
                </td>
                <td><span class="sort-order-value">${imageInfo.sort_order ?? 'Belirtilmemiş'}</span></td>
                <td>${imageInfo.created_at ? new Date(imageInfo.created_at).toLocaleDateString('tr-TR') : 'Belirtilmemiş'}</td>
                <td>
                    <div class="form-button-action">
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

                            // Sıralama bilgisi ekle
                            const cardBody = document.querySelector('.card-body');
                            if (cardBody && !document.querySelector('.drag-hint')) {
                                const dragHint = document.createElement('div');
                                dragHint.className = 'drag-hint mb-3';
                                dragHint.innerHTML =
                                    '<i class="fa fa-info-circle me-2"></i>Görselleri sürükleyip bırakarak sıralama yapabilirsiniz.';
                                cardBody.insertBefore(dragHint, cardBody.firstChild);
                            }

                            // Sortable'ı başlat
                            initSortable();
                        } else {
                            portfolioImagesList.innerHTML = `
                        <tr>
                            <td colspan="8" class="text-center">Henüz kaydedilmiş proje görselleri bulunmamaktadır.</td>
                        </tr>
                    `;
                        }
                    }
                }
            });
        }

        // Sortable başlatma fonksiyonu
        function initSortable() {
            const tableBody = document.getElementById('portfolioImagesList');

            if (tableBody && tableBody.children.length > 1) {
                const sortable = new Sortable(tableBody, {
                    handle: '.sortable-handle',
                    animation: 150,
                    ghostClass: 'sortable-ghost',
                    chosenClass: 'sortable-chosen',
                    dragClass: 'sortable-drag',
                    onEnd: function(evt) {
                        updateImageOrder();
                    }
                });
            }
        }

        // Görsel sıralama verilerini hazırlayıp API'ye gönderen fonksiyon
        function updateImageOrder() {
            // Tüm görsel satırlarını topla
            const rows = document.querySelectorAll('#portfolioImagesList tr[data-id]');

            if (rows.length === 0) return;

            // Görsel sıralamasını güncelle
            const images = [];
            rows.forEach((row, index) => {
                const imageId = row.getAttribute('data-id');
                if (imageId) {
                    // Sıralama numarasını güncelle (hem UI'da hem de veri olarak)
                    const sortOrderCell = row.querySelector('.sort-order-value');
                    if (sortOrderCell) {
                        sortOrderCell.textContent = index;
                    }

                    images.push({
                        id: parseInt(imageId),
                        sort_order: index
                    });
                }
            });

            // Sıralamayı API'ye gönder
            if (images.length > 0) {
                // Yükleniyor göstergesi
                const saveBtn = document.createElement('button');
                saveBtn.className = 'btn btn-primary btn-sm position-fixed';
                saveBtn.style.bottom = '20px';
                saveBtn.style.right = '20px';
                saveBtn.style.zIndex = '1050';
                saveBtn.innerHTML = '<i class="fa fa-sync fa-spin me-2"></i>Sıralama Kaydediliyor...';
                document.body.appendChild(saveBtn);


                // portfolioApiService ile API isteği gönder
                portfolioApiService.request({
                    url: `portfolios/images/order/${portfolioId}`,
                    method: 'PUT',
                    data: {
                        images: images
                    },
                    headers: {
                        'Content-Type': 'application/json', // Özel content type belirt
                        'Accept': 'application/json'
                    },
                    sweetalert2: false,
                    disableNotifications: true,
                    actions: {
                        onSuccess: (response) => {
                            // Başarı mesajı
                            saveBtn.innerHTML = '<i class="fa fa-check me-2"></i>Sıralama Kaydedildi';
                            saveBtn.className = 'btn btn-success btn-sm position-fixed';

                            // 2 saniye sonra butonu kaldır
                            setTimeout(() => {
                                saveBtn.remove();
                            }, 2000);

                            // Başarı bildirimi
                            Swal.fire({
                                icon: 'success',
                                title: 'Sıralama Kaydedildi',
                                toast: true,
                                position: 'bottom-end',
                                showConfirmButton: false,
                                timer: 3000
                            });
                        },
                        onError: (error) => {
                            // Hata mesajı
                            saveBtn.innerHTML = '<i class="fa fa-times me-2"></i>Sıralama Kaydedilemedi';
                            saveBtn.className = 'btn btn-danger btn-sm position-fixed';

                            // 3 saniye sonra butonu kaldır
                            setTimeout(() => {
                                saveBtn.remove();
                            }, 3000);

                            // Hata bildirimi
                            Swal.fire({
                                icon: 'error',
                                title: 'Sıralama Kaydedilemedi',
                                text: error.message || 'Bir hata oluştu',
                                toast: true,
                                position: 'bottom-end',
                                showConfirmButton: false,
                                timer: 3000
                            });
                        }
                    }
                });
            }
        }

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

             // Görsel durumunu değiştirme fonksiyonu
        function toggleActiveStatus(imageId, isActive) {
            // Önce UI'ı hemen güncelle
            const switchLabel = document.querySelector(`label[for="isActiveSwitch${imageId}"]`);
            if (switchLabel) {
                switchLabel.textContent = isActive ? 'Aktif' : 'Pasif';
            }
            portfolioApiService.request({
                url: `portfolios/images/toggle-active/${imageId}`,
                method: 'POST',
                data: {
                    is_active: isActive
                },
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                sweetalert2: true,
                actions: {
                    onSuccess: () => {
                        // Başarılı mesajı
                        Swal.fire({
                            icon: 'success',
                            title: isActive ? 'Görsel aktifleştirildi' : 'Görsel pasifleştirildi',
                            toast: true,
                            position: 'bottom-end',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    },
                    onError: (error) => {
                        // Hata durumunda UI'ı eski haline geri döndür
                        if (switchLabel) {
                            switchLabel.textContent = isActive ? 'Pasif' : 'Aktif';
                        }

                        // Checkbox'ı da eski haline döndür
                        const checkbox = document.getElementById(`isActiveSwitch${imageId}`);
                        if (checkbox) {
                            checkbox.checked = !isActive;
                        }
                    },
                    success: {
                        message: isActive ? 'Görsel başarıyla aktifleştirildi' : 'Görsel başarıyla pasifleştirildi'
                    },
                    errors: {
                        message: 'Görsel durumu güncellenirken bir hata oluştu'
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
