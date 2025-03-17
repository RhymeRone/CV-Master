@extends('layouts.admin.component')

@section('title', 'Proje Kategorileriniz')
@section('page-name', 'Kategori')
@section('component-name', 'portfolio-categories')
@section('form-name', 'PORTFOLIOCATEGORIES')

@section('route', route('admin.portfolioCategories'))

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
            // Dinamik form ID'si
            const componentName = '@yield('component-name')';

            // Icon picker'ları oluşturmak için gecikmeli işlev
            function setupIconPickers() {
                setTimeout(function() {
                    try {
                        // Add modal içindeki elemanlar
                        const addIconInput = document.querySelector(
                            `#addForm-${componentName} input[name="icon"]`);
                        if (addIconInput) {
                            const addIconButton = addIconInput.nextElementSibling;
                            if (addIconButton) {
                                addIconInput.id = 'addIcon';
                                addIconButton.id = 'addIconButton';

                                // Add options
                                let addOptions = {
                                    loadCustomCss: true,
                                    iconLibraries: ['font-awesome.min.json'],
                                    mode: 'autoload',
                                    parentElement: 'body',
                                    allowEmpty: true,
                                    onSelect: function(jsonIconData) {
                                        addIconInput.value = jsonIconData.iconClass;

                                        const event = new Event('input', {
                                            bubbles: true
                                        });
                                        addIconInput.dispatchEvent(event);
                                    }
                                };

                                // Icon picker'ı başlat
                                new UniversalIconPicker('#addIconButton', addOptions);
                            }
                        }

                        // Edit modal içindeki elemanlar
                        const editIconInput = document.querySelector(
                            `#editForm-${componentName} input[name="icon"]`);
                        if (editIconInput) {
                            const editIconButton = editIconInput.nextElementSibling;
                            if (editIconButton) {
                                editIconInput.id = 'editIcon';
                                editIconButton.id = 'editIconButton';

                                // Edit options
                                let editOptions = {
                                    loadCustomCss: true,
                                    iconLibraries: ['font-awesome.min.json'],
                                    mode: 'autoload',
                                    parentElement: 'body',
                                    allowEmpty: true,
                                    onSelect: function(jsonIconData) {
                                        editIconInput.value = jsonIconData.iconClass;

                                        const event = new Event('input', {
                                            bubbles: true
                                        });
                                        editIconInput.dispatchEvent(event);
                                    }
                                };

                                // Icon picker'ı başlat
                                new UniversalIconPicker('#editIconButton', editOptions);
                            }
                        }
                    } catch (error) {
                        console.log('Icon picker setup error:', error);
                    }
                }, 1); // Modal açıldıktan sonra DOM'un güncellenmesi için biraz bekle
            }

            // Modal açıldığında icon picker'ları ayarla
            document.getElementById('addModal').addEventListener('shown.bs.modal', setupIconPickers);
            document.getElementById('editModal').addEventListener('shown.bs.modal', setupIconPickers);
        });
    </script>
@endpush

@section('form')
    <!-- Başlık -->
    <div class="col-md-12">
        <h6 class="mb-3"><i class="fa fa-cog me-2 text-primary"></i>@yield('page-name')</h6>
    </div>
    <!-- Proje Kategori Adı -->
    <div class="col-md-6">
        <div class="input-group mb-3">
            <span class="input-group-text">
                <i class="fa fa-cog fa-fw" style="color: #6c757d;"></i>
            </span>
            <input name="name" type="text" class="form-control" placeholder="Proje kategori adı giriniz"
                required />
        </div>
    </div>
    <!-- İkon -->
    <div class="col-md-6">
        <div class="input-group mb-3">
            <span class="input-group-text">
                <i class="fa fa-code"></i>
            </span>
            <input name="icon" type="text" class="form-control" placeholder="İkon kodu giriniz (örn: fa-code)" />
            <button type="button" class="btn btn-outline-secondary">
                <i class="fa fa-search"></i> İkon Seç
            </button>
        </div>
    </div>
@endsection

@section('table-header')
    <th>KATEGORİ ADI</th>
    <th>İKON</th>
@endsection
@section('table-buttons')
    <button class="btn btn-primary btn-round ms-3" onclick="window.location.href='{{ route('admin.portfolios') }}'">
        <i class="fa fa-briefcase"></i>
        Projeler
    </button>
@endsection
@section('table-body')
    <td>${info.name ?? 'Belirtilmemiş'}</td>
    <td><i class="${info.icon ?? ''}"></i></td>
@endsection
