@extends('layouts.admin.master')

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
                                        <span class="fw-light">@yield('page-name')</span>
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Kapat"></button>
                                </div>
                                <div class="modal-body">
                                    <p class="small">@yield('page-name') bilgilerini giriniz</p>
                                    <form method="POST" enctype="multipart/form-data" id="addForm-@yield('component-name')">
                                        @csrf
                                        <div class="row">
                                            @yield('form')
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
                                        <span class="fw-light">@yield('page-name')</span>
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Kapat"></button>
                                </div>
                                <div class="modal-body">
                                    <p class="small">@yield('page-name') bilgilerini düzenleyiniz</p>
                                    <form method="POST" enctype="multipart/form-data" id="editForm-@yield('component-name')">
                                        @csrf
                                        <div class="row">
                                            <input type="hidden" id="editId" name="id" />
                                            @yield('form')
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button type="submit" class="btn btn-primary" id="btnEdit">Düzenle</button>
                                            <button type="button" class="btn btn-danger"
                                                data-bs-dismiss="modal">Kapat</button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>

                    @yield('modal')

                    <div class="table-responsive">
                        <table id="add-row" class="display table table-hover">
                            <thead class="text-left">
                                <tr>
                                    <th>AKTİF</th>
                                    @yield('table-header')
                                    <th style="width: 10%" class="text-center">İŞLEMLER</th>
                                </tr>
                            </thead>
                            <tbody id="list" class="text-left">
                                <!-- Dinamik İçerik -->

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>

        var apiService;
        var formEntegrator;
        var componentName = '@yield('component-name')';
        var formName = '@yield('form-name')';

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

            // Önce tüm componentleri çek (CV'den bağımsız)
            apiService.request({
                url: '/' + componentName,
                method: 'GET',
                sweetalert2: false,
                disableNotifications: true,
                actions: {
                    onSuccess: (response) => {
                        // Componentleri sakla
                        const components = response.data.data || [];

                        // Şimdi aktif CV bilgisini çek
                        apiService.request({
                            url: '{{ route('cv.information.getActive') }}',
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

                                        // Aktif CV'nin atanmış componentlerini çek
                                        apiService.request({
                                            url: '{{ route('cv.components.getComponents', ['type' => '__TYPE__', 'cv' => '__ID__']) }}'
                                                .replace('__TYPE__', componentName).replace(
                                                    '__ID__', activeCV.id),
                                            method: 'GET',
                                            sweetalert2: false,
                                            disableNotifications: true,
                                            async: false, // Senkron işlem için
                                            actions: {
                                                onSuccess: (assignedResponse) => {
                                                    // Atanmış componentlerin ID'lerini bir dizi olarak al
                                                    assignedIds = assignedResponse.data
                                                        .filter(exp => exp && exp.id)
                                                        .map(exp => exp.id);
                                                    renderComponentList(components,
                                                        activeCvId, assignedIds,
                                                        headerHtml);
                                                },
                                                onError: () => {
                                                    // Atama bilgisi alınamazsa, boş liste ile devam et
                                                    renderComponentList(components,
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
                                                <span>Henüz aktif bir CV bulunmuyor. @yield('page-name') ataması yapabilmek için önce bir CV'yi aktif olarak işaretleyin.</span>
                                            </div>
                                        </td>
                                    </tr>
                                `;

                                        // CV yoksa da componentleri listele, ama checkbox'ları devre dışı bırak
                                        renderComponentList(components, null, [], headerHtml);
                                    }
                                },
                                onError: (error) => {
                                    // Aktif CV bilgisi alınamazsa, componentleri yine de listele

                                    // Aktif CV yoksa uyarı göster
                                    const headerHtml = `
                                    <tr class="table-warning">
                                        <td colspan="8">
                                            <div class="d-flex align-items-center">
                                                <i class="fa fa-exclamation-triangle me-2"></i>
                                                <span>Henüz aktif bir CV bulunmuyor. @yield('page-name') ataması yapabilmek için önce bir CV'yi aktif olarak işaretleyin.</span>
                                            </div>
                                        </td>
                                    </tr>
                                    `;

                                    // CV yoksa da componentleri listele, ama checkbox'ları devre dışı bırak
                                    renderComponentList(components, null, [], headerHtml);
                                }
                            }
                        });
                    },
                    onError: () => {
                        list.innerHTML = `
                    <tr>
                        <td colspan="8" class="text-center">
                            <div class="alert alert-danger">
                                @yield('page-name') bilgileri alınamadı. Lütfen daha sonra tekrar deneyin.
                            </div>
                        </td>
                    </tr>
                `;
                    }
                }
            });
        }
        // Component listesini oluşturacak yardımcı fonksiyon
        function renderComponentList(components, activeCvId, assignedIds, headerHtml) {
            const list = document.getElementById('list');
            list.innerHTML = headerHtml;

            if (components.length > 0) {
                components.forEach(info => {
                    // Componentin aktif CV'ye atanıp atanmadığını kontrol et
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
                                    onchange="toggleComponent(this, ${info.id}, ${activeCvId || 0})"
                                    class="colorinput-input" />
                              <span class="colorinput-color ${isAssigned ? 'bg-success' : 'bg-white'}"></span>
                           </label>
                        </div>
                    </td>
                    @yield('table-body')
                    <td>
                        <div class="form-button-action">
                            <button type="button" class="btn btn-link btn-primary btn-lg edit-btn" data-bs-toggle="tooltip"
                                title="Bilgileri Düzenle" onclick="editRow(${info.id})">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-link btn-primary btn-lg delete-btn" data-bs-toggle="tooltip"
                                title="Bilgileri Sil" onclick="deleteRow(${info.id})">
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
                <td colspan="8" class="text-center">Henüz kaydedilmiş @yield('page-name') bulunmamaktadır.</td>
            </tr>
        `;
            }
        }
        // Checkbox değiştiğinde çağrılacak fonksiyon
        function toggleComponent(checkbox, componentId, cvId) {
            // Eğer aktif CV yoksa (cvId = 0), işlem yapma
            if (!cvId) {
                checkbox.checked = !checkbox.checked; // Tıklamayı geri al
                Swal.fire({
                    icon: 'warning',
                    title: 'Uyarı',
                    text: '@yield('page-name') atayabilmek için önce bir CV aktifleştirmelisiniz.',
                    confirmButtonText: 'Tamam'
                });
                return;
            }

            if (checkbox.checked) {
                // Eğer checkbox işaretliyse, componenti aktif CV'ye ekle
                setActive(componentId, cvId);
                // Görsel geri bildirim için rengi güncelle
                checkbox.nextElementSibling.classList.remove('bg-white');
                checkbox.nextElementSibling.classList.add('bg-success');
            } else {
                // Eğer checkbox işareti kaldırılmışsa, componenti aktif CV'den kaldır
                setInactive(componentId, cvId);
                // Görsel geri bildirim için rengi güncelle
                checkbox.nextElementSibling.classList.remove('bg-success');
                checkbox.nextElementSibling.classList.add('bg-white');
            }
        }

        function setActive(componentId, cvId) {
            apiService.request({
                url: '{{ route('cv.components.addComponent', ['type' => '__TYPE__', 'cv' => '__ID__']) }}'.replace(
                    '__TYPE__', componentName).replace('__ID__', cvId),
                data: {
                    component_id: componentId
                },
                method: 'POST',
                sweetalert2: true,
                allowApiMessages: false,
                actions: {
                    errors: {
                        message: '@yield('page-name') aktif durumu güncellenirken bir hata oluştu.'
                    },
                    success: {
                        message: '@yield('page-name') başarıyla aktif edildi.'
                    }
                }
            });
        }

        function setInactive(componentId, cvId) {
            apiService.request({
                url: '{{ route('cv.components.removeComponent', ['type' => '__TYPE__', 'cv' => '__ID__']) }}'
                    .replace('__TYPE__', componentName).replace('__ID__', cvId) + '?component_id=' + componentId,
                method: 'DELETE',
                sweetalert2: true,
                allowApiMessages: false,
                actions: {
                    errors: {
                        message: '@yield('page-name') aktif durumu güncellenirken bir hata oluştu.'
                    },
                    success: {
                        message: '@yield('page-name') başarıyla pasif edildi.'
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
            @hasSection('edit-row')
                @yield('edit-row')
            @else
                 formEntegrator.loadFormData('EDIT_' + (formName ?? componentName), {
                params: {
                    id: id
                }
            });
            showModal('#editModal');
            @endif
        }
      
        function deleteRow(id) {
            apiService.request({
                url: '/' + componentName + '/' + id,
                method: 'DELETE',
                sweetalert2: true,
                allowApiMessages: false,
                showConfirm: {
                    enabled: true,
                    title: '@yield('page-name') Silme Onayı',
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
                        message: '@yield('page-name') bilgileri silindi'
                    },
                    errors: {
                        message: '@yield('page-name') bilgileri silinemedi'
                    }
                }
            });
        }
    </script>
@endpush
