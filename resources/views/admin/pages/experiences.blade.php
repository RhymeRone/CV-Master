@extends('layouts.admin.component')

@section('title', 'Deneyimleriniz')
@section('page-name', 'Deneyim')
@section('component-name', 'experiences')

@section('route', route('admin.experiences'))

@section('add-form')
    <!-- Başlık -->
    <div class="col-md-12">
        <h6 class="mb-3"><i class="fa fa-user me-2 text-primary"></i>@yield('page-name')</h6>
    </div>
    <!-- Pozisyon -->
    <div class="col-md-6">
        <div class="input-group mb-3">
            <span class="input-group-text">
                <i class="fa fa-briefcase fa-fw" style="color: #6c757d;"></i>
            </span>
            <input id="addPosition" name="position" type="text" class="form-control" placeholder="Pozisyon giriniz"
                required />
        </div>
    </div>
    <!-- Şirket -->
    <div class="col-md-6">
        <div class="input-group mb-3">
            <span class="input-group-text">
                <i class="fa fa-building fa-fw" style="color: #6c757d;"></i>
            </span>
            <input id="addCompany" name="company" type="text" class="form-control" placeholder="Şirket adı giriniz"
                required />
        </div>
    </div>
    <!-- Başlangıç Tarihi -->
    <div class="col-md-6">
        <div class="input-group mb-3">
            <span class="input-group-text">
                <i class="fa fa-calendar-alt fa-fw" style="color: #6c757d;"></i>
            </span>
            <input id="addStartDate" name="start_date" type="date" class="form-control" placeholder="Başlangıç tarihi"
                min="1900-01-01" max="{{ date('Y-m-d', strtotime('+1 year')) }}" required />
        </div>
    </div>
    <!-- Bitiş Tarihi -->
    <div class="col-md-6">
        <div class="input-group mb-3">
            <span class="input-group-text">
                <i class="fa fa-calendar-check fa-fw" style="color: #6c757d;"></i>
            </span>
            <input id="addEndDate" name="end_date" type="date" class="form-control"
                placeholder="Bitiş tarihi (Devam ediyorsa boş bırakın)" min="1900-01-01"
                max="{{ date('Y-m-d', strtotime('+1 year')) }}" />
        </div>
    </div>
@endsection

@section('edit-form')
    <!-- Başlık -->
    <div class="col-md-12">
        <h6 class="mb-3"><i class="fa fa-user me-2 text-primary"></i>@yield('page-name')
        </h6>
    </div>
    <!-- Pozisyon -->
    <div class="col-md-6">
        <div class="input-group mb-3">
            <span class="input-group-text">
                <i class="fa fa-briefcase fa-fw" style="color: #6c757d;"></i>
            </span>
            <input id="editPosition" name="position" type="text" class="form-control" placeholder="Pozisyon giriniz"
                required />
        </div>
    </div>
    <!-- Şirket -->
    <div class="col-md-6">
        <div class="input-group mb-3">
            <span class="input-group-text">
                <i class="fa fa-building fa-fw" style="color: #6c757d;"></i>
            </span>
            <input id="editCompany" name="company" type="text" class="form-control" placeholder="Şirket adı giriniz"
                required />
        </div>
    </div>
    <!-- Başlangıç Tarihi -->
    <div class="col-md-6">
        <div class="input-group mb-3">
            <span class="input-group-text">
                <i class="fa fa-calendar-alt fa-fw" style="color: #6c757d;"></i>
            </span>
            <input id="editStartDate" name="start_date" type="date" class="form-control" placeholder="Başlangıç tarihi"
                min="1900-01-01" max="{{ date('Y-m-d', strtotime('+1 year')) }}" required />
        </div>
    </div>
    <!-- Bitiş Tarihi -->
    <div class="col-md-6">
        <div class="input-group mb-3">
            <span class="input-group-text">
                <i class="fa fa-calendar-check fa-fw" style="color: #6c757d;"></i>
            </span>
            <input id="editEndDate" name="end_date" type="date" class="form-control"
                placeholder="Bitiş tarihi (Devam ediyorsa boş bırakın)" min="1900-01-01"
                max="{{ date('Y-m-d', strtotime('+1 year')) }}" />
        </div>
    </div>
@endsection

@section('table-header')
    <th>POZİSYON</th>
    <th>ŞİRKET</th>
    <th>BAŞLANGIÇ TARİHİ</th>
    <th>BITİŞ TARİHİ</th>
@endsection

@section('table-body')
    <td>${info.position ?? 'Belirtilmemiş'}</td>
    <td>${info.company ?? 'Belirtilmemiş'}</td>
    <td>${info.start_date ? new Date(info.start_date).toLocaleDateString('tr-TR') : 'Belirtilmemiş'}</td>
    <td>${info.end_date ? new Date(info.end_date).toLocaleDateString('tr-TR') : 'Devam Ediyor'}</td>
@endsection
