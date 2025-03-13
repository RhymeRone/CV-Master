@extends('layouts.admin.component')

@section('title', 'Yetenekleriniz')
@section('page-name', 'Yetenek')
@section('component-name', 'skills')

@section('route', route('admin.skills'))

@push('styles')
@endpush

@push('scripts')
@endpush

@section('form')
    <!-- Başlık -->
    <div class="col-md-12">
        <h6 class="mb-3"><i class="fa fa-cog me-2 text-primary"></i>@yield('page-name')</h6>
    </div>
    <!-- Yetenek Adı -->
    <div class="col-md-6">
        <label for="name" class="form-label">Yetenek Adı: </label>
        <div class="input-group mb-3">
            <span class="input-group-text">
                <i class="fa fa-star fa-fw" style="color: #6c757d;"></i>
            </span>
            <input name="name" type="text" class="form-control" placeholder="Yetenek adı giriniz" required />
        </div>
    </div>
    <!-- Renk -->
    <div class="col-md-6">
        <label for="color" class="form-label">Yetenek Rengi: </label>
        <div class="input-group mb-3">
            <div class="input-group-text" style="width: 43px; height: 43px;">
                <i class="fa fa-paint-brush fa-fw" style="color: #6c757d;"></i>
            </div>
            <input name="color" type="color" class="form-control form-control-color" value="#4e73df"
                title="Yetenek çubuğu rengi seçin" required />
        </div>
    </div>
    <!-- Seviye -->
    <div class="col-md-12">
        <label for="levelRange" class="form-label">Seviye: </label>
        <div class="input-group mb-3">
            <span class="input-group-text">
                <i class="fa fa-level-up"></i>
            </span>
            <input name="level" type="range" min="0" max="100" class="form-control form-range"
                placeholder="Seviye (0-100)" value="50" required
                oninput="this.nextElementSibling.querySelector('.levelOutput').textContent = this.value" />
            <span class="input-group-text">
                <output class="levelOutput">50</output>
            </span>
        </div>
    </div>
@endsection

@section('table-header')
    <th>YETENEK ADI</th>
    <th>SEVİYE</th>
    {{-- <th>RENK</th> --}}
@endsection

@section('table-body')
    <td>
        <span class="badge"
            style="font-size: 0.9em; padding: 5px 10px; border-radius: 15px; background-color: ${info.color ?? '#4e73df'}; color: white;">
            ${info.name ? info.name.toUpperCase() : 'BELİRTİLMEMİŞ'}
        </span>
    </td>
    <td>${info.level ?? 'Belirtilmemiş'}</td>
    {{-- <td>
        <span style="display: inline-block; width: 20px; height: 20px; background-color: ${info.color ?? '#ccc'}; border-radius: 3px; margin-right: 5px;"></span>
        ${info.color ?? 'Belirtilmemiş'}
    </td> --}}
@endsection
