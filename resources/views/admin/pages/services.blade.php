@extends('layouts.admin.component')

@section('title', 'Hizmetleriniz')
@section('page-name', 'Hizmet')
@section('component-name', 'services')

@section('route', route('admin.services'))

@push('styles')
    <!-- Universal Icon Picker CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/universal-icon-picker.min.css') }}">

    <!-- FontAwesome CSS (veya kullanmak istediğiniz ikon setleri) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endpush

@push('scripts')
    <!-- Universal Icon Picker JS -->
    <script src="{{ asset('assets/js/universal-icon-picker.min.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ekleme formu için icon picker seçenekleri
            const addOptions = {
                loadCustomCss: true,
                iconLibraries: ['font-awesome.min.json'],
                mode: 'autoload',
                parentElement: 'body',
                allowEmpty: true,
                onSelect: function(jsonIconData) {
                    // ADD FORM - Seçilen ikon verisini add form input'una aktar
                    document.getElementById('addIcon').value = jsonIconData.iconClass;

                    // ADD FORM - Önizleme alanını güncelle
                    const addPreviewElement = document.querySelector('#addIcon').closest('.input-group')
                        .querySelector('.input-group-text:last-child i');
                    if (addPreviewElement) {
                        addPreviewElement.className = jsonIconData.iconClass;
                    }

                    console.log('ADD FORM: İkon seçildi -', jsonIconData.iconClass);
                }
            };

            // EDIT formu için AYRI seçenekler
            const editOptions = {
                loadCustomCss: true,
                iconLibraries: ['font-awesome.min.json'],
                mode: 'autoload',
                parentElement: 'body',
                allowEmpty: true,
                onSelect: function(jsonIconData) {
                    // EDIT FORM - Seçilen ikon verisini edit form input'una aktar
                    document.getElementById('editIcon').value = jsonIconData.iconClass;

                    // EDIT FORM - Önizleme alanını güncelle
                    const editPreviewElement = document.querySelector('#editIcon').closest('.input-group')
                        .querySelector('.input-group-text:last-child i');
                    if (editPreviewElement) {
                        editPreviewElement.className = jsonIconData.iconClass;
                    }

                    console.log('EDIT FORM: İkon seçildi -', jsonIconData.iconClass);
                }
            };

            // Ekleme formundaki icon picker'ı oluştur
            var addIconPicker = new UniversalIconPicker('#addIconButton', addOptions);

            // Düzenleme formundaki icon picker'ı oluştur (AYRI options ile)
            var editIconPicker = new UniversalIconPicker('#editIconButton', editOptions);
        });
    </script>
@endpush

@section('form')
    <!-- Başlık -->
    <div class="col-md-12">
        <h6 class="mb-3"><i class="fa fa-cog me-2 text-primary"></i>@yield('page-name')</h6>
    </div>
    <!-- Hizmet Adı -->
    <div class="col-md-6">
        <div class="input-group mb-3">
            <span class="input-group-text">
                <i class="fa fa-cog fa-fw" style="color: #6c757d;"></i>
            </span>
            <input name="name" type="text" class="form-control" placeholder="Hizmet adı giriniz"
                required />
        </div>
    </div>
    <!-- İkon -->
    <div class="col-md-6">
        <div class="input-group mb-3">
            <span class="input-group-text">
                <i class="fa fa-code"></i>
            </span>
            <input name="icon" type="text" class="form-control"
                placeholder="İkon kodu giriniz (örn: fa-code)" value="fa-code" />
            <button type="button" class="btn btn-outline-secondary">
                <i class="fa fa-search"></i> İkon Seç
            </button>
        </div>
    </div>
    <!-- Açıklama -->
    <div class="col-md-12">
        <div class="input-group mb-3">
            <span class="input-group-text">
                <i class="fa fa-align-left fa-fw" style="color: #6c757d;"></i>
            </span>
            <textarea name="description" class="form-control" placeholder="Hizmet açıklaması giriniz"
                rows="4" required></textarea>
        </div>
    </div>
@endsection

@section('table-header')
    <th>HİZMET ADI</th>
    <th>İKON</th>
    <th>AÇIKLAMA</th>
@endsection

@section('table-body')
    <td>${info.name ?? 'Belirtilmemiş'}</td>
    <td><i class="${info.icon ?? ''}"></i></td>
    <td>${info.description ?? 'Belirtilmemiş'}</td>
@endsection
