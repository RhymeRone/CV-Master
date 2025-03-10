@extends('layouts.admin.master')

@section('title', 'Deneyimleriniz')

@section('page-name', 'Deneyim')
@section('route', route('admin.experiences'))

@section('content')
    <div class="page-inner">
        @include('layouts.admin.partials.page-header')
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">@yield('title')</h4>
                        <button class="btn btn-primary btn-round ms-auto" data-bs-toggle="modal" data-bs-target="#addModal">
                            <i class="fa fa-plus"></i>
                            @yield('page-name') Ekle
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Modal -->
                    <!-- Ekleme Modal -->
                    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header border-0 d-flex justify-content-between align-items-center">
                                    <h5 class="modal-title">
                                        <span class="fw-mediumbold">Yeni</span>
                                        <span class="fw-light">Deneyim</span>
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Kapat"></button>
                                </div>
                                <div class="modal-body">
                                    <p class="small">Deneyim bilgilerini giriniz</p>
                                    <form method="POST" enctype="multipart/form-data" id="addExperienceForm">
                                        @csrf
                                        <div class="row">
                                            <!-- Deneyim Başlığı -->
                                            <div class="col-md-12">
                                                <h6 class="mb-3"><i class="fa fa-user me-2 text-primary"></i>Deneyim</h6>
                                            </div>

                                            <!-- Pozisyon -->
                                            <div class="col-md-6">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">
                                                        <i class="fa fa-briefcase fa-fw" style="color: #6c757d;"></i>
                                                    </span>
                                                    <input id="addPosition" name="position" type="text"
                                                        class="form-control" placeholder="Pozisyon giriniz" required />
                                                </div>
                                            </div>
                                            <!-- Şirket -->
                                            <div class="col-md-6">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">
                                                        <i class="fa fa-building fa-fw" style="color: #6c757d;"></i>
                                                    </span>
                                                    <input id="addCompany" name="company" type="text"
                                                        class="form-control" placeholder="Şirket adı giriniz" required />
                                                </div>
                                            </div>
                                            <!-- Başlangıç Tarihi -->
                                            <div class="col-md-6">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">
                                                        <i class="fa fa-calendar-alt fa-fw" style="color: #6c757d;"></i>
                                                    </span>
                                                    <input id="addStartDate" name="start_date" type="date"
                                                        class="form-control" placeholder="Başlangıç tarihi" min="1900-01-01"
                                                        max="{{ date('Y-m-d', strtotime('+1 year')) }}" required />
                                                </div>
                                            </div>
                                            <!-- Bitiş Tarihi -->
                                            <div class="col-md-6">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">
                                                        <i class="fa fa-calendar-check fa-fw" style="color: #6c757d;"></i>
                                                    </span>
                                                    <input id="addEndDate" name="end_date" type="date"
                                                        class="form-control"
                                                        placeholder="Bitiş tarihi (Devam ediyorsa boş bırakın)"
                                                        min="1900-01-01" max="{{ date('Y-m-d', strtotime('+1 year')) }}" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button type="submit" class="btn btn-primary" id="btnAdd">Ekle</button>
                                            <button type="button" class="btn btn-danger"
                                                data-bs-dismiss="modal">Kapat</button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Düzenleme Modal -->
                    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header border-0 d-flex justify-content-between align-items-center">
                                    <h5 class="modal-title">
                                        <span class="fw-mediumbold">Düzenle</span>
                                        <span class="fw-light">Deneyim</span>
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Kapat"></button>
                                </div>
                                <div class="modal-body">
                                    <p class="small">Deneyim bilgilerini düzenleyiniz</p>
                                    <form method="POST" enctype="multipart/form-data" id="editExperienceForm">
                                        @csrf
                                        <div class="row">
                                            <input type="hidden" id="editId" name="id" />
                                            <!-- Deneyim Başlığı -->
                                            <div class="col-md-12">
                                                <h6 class="mb-3"><i class="fa fa-user me-2 text-primary"></i>Deneyim
                                                </h6>
                                            </div>

                                            <!-- Pozisyon -->
                                            <div class="col-md-6">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">
                                                        <i class="fa fa-briefcase fa-fw" style="color: #6c757d;"></i>
                                                    </span>
                                                    <input id="editPosition" name="position" type="text"
                                                        class="form-control" placeholder="Pozisyon giriniz" required />
                                                </div>
                                            </div>
                                            <!-- Şirket -->
                                            <div class="col-md-6">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">
                                                        <i class="fa fa-building fa-fw" style="color: #6c757d;"></i>
                                                    </span>
                                                    <input id="editCompany" name="company" type="text"
                                                        class="form-control" placeholder="Şirket adı giriniz" required />
                                                </div>
                                            </div>
                                            <!-- Başlangıç Tarihi -->
                                            <div class="col-md-6">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">
                                                        <i class="fa fa-calendar-alt fa-fw" style="color: #6c757d;"></i>
                                                    </span>
                                                    <input id="editStartDate" name="start_date" type="date"
                                                        class="form-control" placeholder="Başlangıç tarihi"
                                                        min="1900-01-01" max="{{ date('Y-m-d', strtotime('+1 year')) }}"
                                                        required />
                                                </div>
                                            </div>
                                            <!-- Bitiş Tarihi -->
                                            <div class="col-md-6">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">
                                                        <i class="fa fa-calendar-check fa-fw" style="color: #6c757d;"></i>
                                                    </span>
                                                    <input id="editEndDate" name="end_date" type="date"
                                                        class="form-control"
                                                        placeholder="Bitiş tarihi (Devam ediyorsa boş bırakın)"
                                                        min="1900-01-01"
                                                        max="{{ date('Y-m-d', strtotime('+1 year')) }}" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button type="submit" class="btn btn-primary"
                                                id="btnEdit">Düzenle</button>
                                            <button type="button" class="btn btn-danger"
                                                data-bs-dismiss="modal">Kapat</button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="add-row" class="display table table-hover">
                            <thead>
                                <tr>
                                    <th>AKTİF</th>
                                    <th>POZİSYON</th>
                                    <th>ŞİRKET</th>
                                    <th>BAŞLANGIÇ TARİHİ</th>
                                    <th>BITİŞ TARİHİ</th>
                                    <th style="width: 10%" class="text-center">İŞLEMLER</th>
                                </tr>
                            </thead>
                            <tbody id="list">
                                <!-- Deneyim Listeleme Dinamik İçerik -->

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
        var apiService;
        var formEntegrator;
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                apiService = window.apiService;
                formEntegrator = window.integrator;
                setupModalListeners();
                loadData();
            }, 100);

        });


        function loadData() {
            const list = document.getElementById('list');

            list.innerHTML = `
    <tr id="loading-row">
      <td colspan="8" class="text-center">
            <div class="d-flex justify-content-center align-items-center py-4">
                     <div class="position-relative">
                         <div class="spinner-border text-primary spinner-border-lg" style="width: 3rem; height: 3rem;" role="status">
                         <span class="visually-hidden">Yükleniyor...</span>
                         </div>
                     </div>
                     <div class="ms-4">
                         <h5 class="text-primary mb-1 fw-bold">Liste Yükleniyor</h5>
                         <div class="text-muted">
                             <small>Lütfen bekleyiniz, veriler hazırlanıyor...</small>
                         </div>
                     </div>
            </div>
      </td>
    </tr>
    `;

            // Önce tüm deneyimleri çek (CV'den bağımsız)
            apiService.request({
                url: '/experiences',
                method: 'GET',
                sweetalert2: false,
                disableNotifications: true,
                actions: {
                    onSuccess: (response) => {
                        // Deneyimleri sakla
                        const experiences = response.data.data || [];

                        // Şimdi aktif CV bilgisini çek
                        apiService.request({
                            url: '/cv-information/get-active',
                            method: 'GET',
                            sweetalert2: false,
                            disableNotifications: true,
                            actions: {
                                onSuccess: (cvResponse) => {
                                    const activeCV = cvResponse.data.data;
                                    let activeCvId = null;
                                    let assignedIds = [];

                                    // Aktif CV bilgisini ekleyin
                                    let headerHtml = '';
                                    if (activeCV && activeCV.id) {
                                        activeCvId = activeCV.id;

                                        // Başlık bilgisini CV bilgisi içerecek şekilde hazırla
                                        headerHtml = `
                                    <tr class="table-info">
                                        <td colspan="8">
                                            <div class="d-flex align-items-center">
                                                <i class="fa fa-info-circle me-2"></i>
                                                <strong>Aktif CV:</strong> &nbsp; ${activeCV.name || activeCV.position || 'CV #' + activeCV.id}
                                            </div>
                                        </td>
                                    </tr>
                                `;

                                        // Aktif CV'nin atanmış deneyimlerini çek
                                        apiService.request({
                                            url: '/cv/' + activeCV.id + '/components/experiences',
                                            method: 'GET',
                                            sweetalert2: false,
                                            disableNotifications: true,
                                            async: false, // Senkron işlem için
                                            actions: {
                                                onSuccess: (assignedResponse) => {
                                                    console.log("API Yanıtı:", assignedResponse);
                                                    // Atanmış deneyimlerin ID'lerini bir dizi olarak al
                                                    assignedIds = assignedResponse.data
                                                        .map(exp => exp.id);
                                                    renderExperienceList(experiences,
                                                        activeCvId, assignedIds,
                                                        headerHtml);
                                                },
                                                onError: () => {
                                                    // Atama bilgisi alınamazsa, boş liste ile devam et
                                                    renderExperienceList(experiences,
                                                        activeCvId, [], headerHtml);
                                                }
                                            }
                                        });
                                    } else {
                                        // Aktif CV yoksa uyarı göster
                                        headerHtml = `
                                    <tr class="table-warning">
                                        <td colspan="8">
                                            <div class="d-flex align-items-center">
                                                <i class="fa fa-exclamation-triangle me-2"></i>
                                                <span>Henüz aktif bir CV bulunmuyor. Deneyim ataması yapabilmek için önce bir CV'yi aktif olarak işaretleyin.</span>
                                            </div>
                                        </td>
                                    </tr>
                                `;

                                        // CV yoksa da deneyimleri listele, ama checkbox'ları devre dışı bırak
                                        renderExperienceList(experiences, null, [], headerHtml);
                                    }
                                },
                                onError: (error) => {
                                    // Aktif CV bilgisi alınamazsa, deneyimleri yine de listele
                                    console.log("Aktif CV bulunamadı:", error.response?.data
                                        ?.message || error.message);

                                    // Aktif CV yoksa uyarı göster
                                    const headerHtml = `
                                    <tr class="table-warning">
                                        <td colspan="8">
                                            <div class="d-flex align-items-center">
                                                <i class="fa fa-exclamation-triangle me-2"></i>
                                                <span>Henüz aktif bir CV bulunmuyor. Deneyim ataması yapabilmek için önce bir CV'yi aktif olarak işaretleyin.</span>
                                            </div>
                                        </td>
                                    </tr>
                                    `;

                                    // CV yoksa da deneyimleri listele, ama checkbox'ları devre dışı bırak
                                    renderExperienceList(experiences, null, [], headerHtml);
                                }
                            }
                        });
                    },
                    onError: () => {
                        list.innerHTML = `
                    <tr>
                        <td colspan="8" class="text-center">
                            <div class="alert alert-danger">
                                Deneyim bilgileri alınamadı. Lütfen daha sonra tekrar deneyin.
                            </div>
                        </td>
                    </tr>
                `;
                    }
                }
            });
        }

        // Deneyim listesini oluşturacak yardımcı fonksiyon
        function renderExperienceList(experiences, activeCvId, assignedIds, headerHtml) {
            const list = document.getElementById('list');
            list.innerHTML = headerHtml;

            if (experiences.length > 0) {
                experiences.forEach(info => {
                    // Deneyimin aktif CV'ye atanıp atanmadığını kontrol et
                    const isAssigned = assignedIds.includes(info.id);

                    // Eğer aktif CV yoksa, checkbox devre dışı bırakılır
                    const isDisabled = activeCvId ? '' : 'disabled';

                    list.innerHTML += `
                <tr>
                    <td>
                        <div class="col-auto">
                           <label class="colorinput">
                              <input name="cv_assignment" type="checkbox"  
                                    value="${info.id}" 
                                    ${isAssigned ? 'checked' : ''}
                                    ${isDisabled}
                                    onchange="toggleExperience(this, ${info.id}, ${activeCvId || 0})"
                                    class="colorinput-input" />
                              <span class="colorinput-color ${isAssigned ? 'bg-success' : 'bg-white'}"></span>
                           </label>
                        </div>
                    </td>
                    <td>${info.position ?? 'Belirtilmemiş'}</td>
                    <td>${info.company ?? 'Belirtilmemiş'}</td>
                    <td>${info.start_date ? new Date(info.start_date).toLocaleDateString('tr-TR') : 'Belirtilmemiş'}</td>
                    <td>${info.end_date ? new Date(info.end_date).toLocaleDateString('tr-TR') : 'Devam Ediyor'}</td>
                    <td>
                        <div class="form-button-action">
                            <button type="button"
                                class="btn btn-link btn-primary btn-lg edit-btn"
                                data-bs-toggle="tooltip"
                                title="Bilgileri Düzenle"
                                onclick="editRow(${info.id})">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button type="button"
                                class="btn btn-link btn-primary btn-lg delete-btn"
                                data-bs-toggle="tooltip"
                                title="Bilgileri Sil"
                                onclick="deleteRow(${info.id})">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
                });
            } else {
                list.innerHTML += `
            <tr>
                <td colspan="8" class="text-center">Henüz kaydedilmiş deneyim bulunmamaktadır.</td>
            </tr>
        `;
            }
        }

        // Checkbox değiştiğinde çağrılacak fonksiyon
        function toggleExperience(checkbox, experienceId, cvId) {
            // Eğer aktif CV yoksa (cvId = 0), işlem yapma
            if (!cvId) {
                checkbox.checked = !checkbox.checked; // Tıklamayı geri al
                Swal.fire({
                    icon: 'warning',
                    title: 'Uyarı',
                    text: 'Deneyim atayabilmek için önce bir CV aktifleştirmelisiniz.',
                    confirmButtonText: 'Tamam'
                });
                return;
            }

            if (checkbox.checked) {
                // Eğer checkbox işaretliyse, deneyimi aktif CV'ye ekle
                setActive(experienceId, cvId);
                // Görsel geri bildirim için rengi güncelle
                checkbox.nextElementSibling.classList.remove('bg-white');
                checkbox.nextElementSibling.classList.add('bg-success');
            } else {
                // Eğer checkbox işareti kaldırılmışsa, deneyimi aktif CV'den kaldır
                setInactive(experienceId, cvId);
                // Görsel geri bildirim için rengi güncelle
                checkbox.nextElementSibling.classList.remove('bg-success');
                checkbox.nextElementSibling.classList.add('bg-white');
            }
        }

        function setActive(experienceId, cvId) {
            apiService.request({
                url: '/cv/' + cvId + '/components/experiences',
                data: {
                    component_id: experienceId
                },
                method: 'POST',
                sweetalert2: true,
                actions: {
                    errors: {
                        message: 'Deneyim aktif durumu güncellenirken bir hata oluştu.'
                    },
                    success: {
                        message: 'Deneyim başarıyla aktif edildi.'
                    }
                }
            });
        }

        function setInactive(experienceId, cvId) {
            apiService.request({
                url: '/cv/' + cvId + '/components/experiences?component_id=' + experienceId,
                method: 'DELETE',
                sweetalert2: true,
                actions: {
                    errors: {
                        message: 'Deneyim aktif durumu güncellenirken bir hata oluştu.'
                    },
                    success: {
                        message: 'Deneyim başarıyla pasif edildi.'
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

        function editRow(id) {
            formEntegrator.loadFormData('EDIT_EXPERIENCE', {
                params: {
                    id: id
                }
            });
            showModal('#editModal');
        }

        function deleteRow(id) {
            apiService.request({
                url: `/experiences/${id}`,
                method: 'DELETE',
                sweetalert2: true,
                showConfirm: {
                    enabled: true,
                    title: 'Deneyim Silme Onayı',
                    text: 'Bu işlemi gerçekleştirmek istediğinize emin misiniz?',
                    icon: 'warning',
                    confirmButtonText: 'Evet, Sil',
                    cancelButtonText: 'İptal',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33'
                },
                actions: {
                    onSuccess: () => {
                        loadData();
                    },
                    success: {
                        message: 'Deneyim bilgileri silindi'
                    },
                    errors: {
                        message: 'Deneyim bilgileri silinemedi'
                    }
                }
            });
        }
    </script>
@endpush
