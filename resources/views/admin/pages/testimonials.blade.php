@extends('layouts.admin.component')

@section('title', 'Referanslar')
@section('page-name', 'Referans')
@section('component-name', 'testimonials')
@section('form-name', 'TESTIMONIALS')

@section('route', route('admin.testimonials'))


@push('scripts')
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
    <!-- Referans Adı -->
    <div class="col-md-6">
        <label for="name" class="form-label">Referans Adı: </label>
        <div class="input-group mb-3">
            <span class="input-group-text">
                <i class="fa fa-user fa-fw" style="color: #6c757d;"></i>
            </span>
            <input name="name" type="text" class="form-control" placeholder="Referans adı giriniz" required />
        </div>
    </div>
    <!-- Meslek -->
    <div class="col-md-6">
        <label for="job" class="form-label">Meslek: </label>
        <div class="input-group mb-3">
            <span class="input-group-text">
                <i class="fa fa-briefcase fa-fw" style="color: #6c757d;"></i>
            </span>
            <input name="job" type="text" class="form-control" placeholder="Meslek giriniz" required />
        </div>
    </div>
    <!-- Yorum -->
    <div class="col-md-12">
        <label for="comment" class="form-label">Yorum: </label>
        <div class="input-group mb-3">
            <span class="input-group-text">
                <i class="fa fa-comment fa-fw" style="color: #6c757d;"></i>
            </span>
            <textarea name="comment" class="form-control" rows="3" placeholder="Referans yorumu giriniz" required></textarea>
        </div>
    </div>
    <!-- Görsel -->
    <div class="col-md-12">
        <label for="image" class="form-label">Referans Fotoğrafı: </label>
        <div class="input-group mb-3">
            <span class="input-group-text">
                <i class="fa fa-image fa-fw" style="color: #6c757d;"></i>
            </span>
            <input name="image" type="file" class="form-control" accept="image/jpeg,image/png,image/jpg,image/svg+xml" />
        </div>
        <small class="form-text text-muted">Referans kişisinin fotoğrafını yükleyiniz.</small>
    </div>
@endsection

@section('table-header')
    <th>GÖRSEL</th>
    <th>REFERANS ADI</th>
    <th>MESLEK</th>
    <th>YORUM</th>
@endsection

@section('table-body')
    <td>
        <img src="${info.image ? info.image : '{{ asset('assets/img/no-image.png') }}'}" alt="Referans Fotoğrafı"
            class="img-fluid" style="width: 50px; height: 50px; cursor: pointer;"
            onclick="openImageModal('${info.image ? info.image : '{{ asset('assets/img/no-image.png') }}'}', '${info.name ?? 'Referans Fotoğrafı'}')">
    </td>
    <td>${info.name ?? 'Belirtilmemiş'}</td>
    <td>${info.job ?? 'Belirtilmemiş'}</td>
    <td>${info.comment ?? 'Belirtilmemiş'}</td>

@endsection
