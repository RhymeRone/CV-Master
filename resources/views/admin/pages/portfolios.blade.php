@extends('layouts.admin.component')

@section('title', 'Portfolyo')
@section('page-name', 'Portfolyo')
@section('component-name', 'portfolios')

@section('route', route('admin.portfolios'))

@section('edit-row')
    // Önce modalı göster
    showModal('#editModal');
    
    // Form verilerini yükle
    formEntegrator.loadFormData('EDIT_' + componentName, {
        params: {
            id: id
        },
        onLoadSuccess: (data) => {
            // Form verileri yüklendikten sonra kategorileri işaretle
            if (data && data.categories && Array.isArray(data.categories)) {
                setTimeout(() => {
                    const categoryIds = data.categories.map(cat => cat.id);
                    
                    // Modal içindeki kategori seçicisini bul
                    const modal = document.querySelector('#editModal');
                    const selectElement = modal.querySelector('.kategori-select');
                    
                    if (selectElement) {
                        // Select2 varsa onunla seç
                        if (typeof $().select2 === 'function') {
                            $(selectElement).val(categoryIds).trigger('change');
                        } 
                        // Yoksa manuel seç
                        else {
                            Array.from(selectElement.options).forEach(option => {
                                option.selected = categoryIds.includes(parseInt(option.value));
                            });
                        }
                    } else {
                        console.error('Edit modal içinde kategori seçici bulunamadı!');
                    }
                }, 500); // Biraz daha uzun bekle (kategorilerin yüklenmesi için)
            }
        }
    });
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
    /* Select2 stili */
    .select2-container--default .select2-selection--multiple {
        border-color: #ced4da;
    }
    .select2-container--default.select2-container--focus .select2-selection--multiple {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    /* İkon içeren seçenekler için stil */
    .select2-results__option i, .select2-selection__choice i {
        margin-right: 5px;
    }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
// Kategori verilerini yükle - modal parametresi ekliyoruz
function loadCategories(modalSelector) {
    // Doğru modal içindeki kategori seçiciyi bul
    const modal = document.querySelector(modalSelector);
    if (!modal) {
        return;
    }
    
    const selectElement = modal.querySelector('.kategori-select');
    if (!selectElement) {
        return;
    }
    
    // Yükleniyor mesajını göster
    selectElement.innerHTML = '<option value="" disabled selected>Kategoriler yükleniyor...</option>';
    
    apiService.request({
        url: '/portfolio-categories',
        method: 'GET',
        sweetalert2: false,
        disableNotifications: true,
        actions: {
            onSuccess: (response) => {
                const categories = response.data.data || [];
                
                // Eski options temizle
                selectElement.innerHTML = '';
                
                // Eğer kategori yoksa uyarı göster
                if (categories.length === 0) {
                    selectElement.innerHTML = '<option value="" disabled>Henüz kategori bulunmuyor</option>';
                    return;
                }
                
                // Kategorileri ekle
                categories.forEach(category => {
                    const option = document.createElement('option');
                    option.value = category.id;
                    
                    // Kategori ikonunu ekleme (varsa)
                    let categoryText = category.name;
                    if (category.icon) {
                        categoryText = `<i class="${category.icon} me-1"></i> ${category.name}`;
                    }
                    
                    option.innerHTML = categoryText;
                    selectElement.appendChild(option);
                });
                
                // Select2 kütüphanesini aktifleştir
                if (typeof $().select2 === 'function') {
                    $(selectElement).select2({
                        placeholder: 'Kategori seçiniz',
                        allowClear: true,
                        templateResult: formatOption,
                        templateSelection: formatOption
                    });
                }
            },
            onError: (error) => {
                selectElement.innerHTML = '<option value="" disabled>Kategoriler yüklenemedi</option>';
            }
        }
    });
    
    // İleriki kullanımlar için select elementini döndür
    return selectElement;
}

// İkon içeren seçenekleri düzgün göster (select2 için)
function formatOption(option) {
    if (!option.id) { return option.text; }
    return $(option.element).html();
}

// Modal açıldığında kategorileri yükle
document.addEventListener('DOMContentLoaded', function() {
    // Modal açılma olaylarına modal seçicisini ekliyoruz
    document.getElementById('addModal').addEventListener('shown.bs.modal', function() {
        loadCategories('#addModal');
    });
    
    document.getElementById('editModal').addEventListener('shown.bs.modal', function() {
        loadCategories('#editModal');
    });
});
</script>
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

@section('modal')
<!-- Görsel Modalı -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Portfolyo Görseli</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
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
@endsection
@section('form')
    <!-- Başlık -->
    <div class="col-md-12">
        <h6 class="mb-3"><i class="fa fa-cog me-2 text-primary"></i>@yield('page-name')</h6>
    </div>
    <!-- Portfolyo Adı -->
    <div class="col-md-6">
        <label for="name" class="form-label">Portfolyo Adı: </label>
        <div class="input-group mb-3">
            <span class="input-group-text">
                <i class="fa fa-briefcase fa-fw" style="color: #6c757d;"></i>
            </span>
            <input name="name" type="text" class="form-control" placeholder="Portfolyo adı giriniz" required />
        </div>
    </div>
    <!-- Bağlantı -->
    <div class="col-md-6">
        <label for="link" class="form-label">Proje Bağlantısı: </label>
        <div class="input-group mb-3">
            <span class="input-group-text">
                <i class="fa fa-link fa-fw" style="color: #6c757d;"></i>
            </span>
            <input name="link" type="url" class="form-control" placeholder="https://ornek.com" />
        </div>
    </div>
    <!-- Açıklama -->
    <div class="col-md-12">
        <label for="description" class="form-label">Açıklama: </label>
        <div class="input-group mb-3">
            <span class="input-group-text">
                <i class="fa fa-align-left fa-fw" style="color: #6c757d;"></i>
            </span>
            <textarea name="description" class="form-control" rows="3" placeholder="Proje açıklaması giriniz"></textarea>
        </div>
    </div>
    <!-- Görseller -->
    <div class="col-md-12">
        <label for="images" class="form-label">Proje Görselleri: </label>
        <div class="input-group mb-3">
            <span class="input-group-text">
                <i class="fa fa-images fa-fw" style="color: #6c757d;"></i>
            </span>
            <input name="images[]" type="file" class="form-control" multiple accept="image/jpeg,image/png,image/jpg,image/svg+xml" />
        </div>
        <small class="form-text text-muted">Seçtiğiniz görsellerden en son seçilen görsel ana görsel olarak ayarlanacaktır.</small>
    </div>
     <!-- Kategoriler -->
    <div class="col-md-12">
        <label for="categories" class="form-label">Portfolyo Kategorileri: </label>
        <div class="input-group mb-3">
            <span class="input-group-text">
                <i class="fa fa-tags fa-fw" style="color: #6c757d;"></i>
            </span>
            <select name="categories[]" id="categories" class="form-select select2 kategori-select" multiple required>
                <option value="" disabled>Kategoriler yükleniyor...</option>
            </select>
        </div>
        <small class="form-text text-muted">Projenizdeki portfolyoya uygun kategorileri seçiniz. Birden fazla kategori seçebilirsiniz.</small>
    </div>
@endsection

@section('table-header')
    <th>ANA GÖRSEL</th>
    <th>PORTFOLYO ADI</th>
    <th>PROJE BAĞLANTISI</th>
    <th>AÇIKLAMA</th>
    <th>KATEGORİLER</th>
@endsection

@section('table-body')
    <td>
        <img src="${info.main_image ? info.main_image : '{{ asset('images/no-image.png') }}'}" 
             alt="Portfolyo Görseli" 
             class="img-fluid" 
             style="max-width: 100px; cursor: pointer;"
             onclick="openImageModal('${info.main_image ? info.main_image : '{{ asset('images/no-image.png') }}'}', '${info.name ?? 'Portfolyo Görseli'}')">
    </td>
    <td>${info.name ?? 'Belirtilmemiş'}</td>
    <td>${info.link ? `<a href="${info.link}" target="_blank" class="text-primary">${info.link}</a>` : 'Belirtilmemiş'}</td>
    <td>${info.description ?? 'Belirtilmemiş'}</td>
    <td>
        ${info.categories ? info.categories.map(category => `<span class="badge bg-primary me-1">${category.name}</span>`).join(' ') : 'Belirtilmemiş'}
    </td>

@endsection
