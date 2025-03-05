@extends('layouts.admin.master')

@section('title', 'CV Listesi')

@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Giriş</h4>
            <ul class="breadcrumbs">
                <li class="nav-home">
                    <a href="#">
                        <i class="icon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">CV Listesi</a>
                </li>
            </ul>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">CV Listesi</h4>
                        <button class="btn btn-primary btn-round ms-auto" data-bs-toggle="modal"
                            data-bs-target="#addRowModal">
                            <i class="fa fa-plus"></i>
                            CV Ekle
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Modal -->
                    <!-- Yeni CV Ekleme Modal -->
                    <div class="modal fade" id="addRowModal" tabindex="-1" role="dialog" aria-labelledby="addRowModalLabel">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header border-0 d-flex justify-content-between align-items-center">
                                    <h5 class="modal-title">
                                        <span class="fw-mediumbold">Yeni</span>
                                        <span class="fw-light">CV</span>
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Kapat"></button>
                                </div>
                                <div class="modal-body">
                                    <p class="small">CV bilgilerini giriniz</p>
                                    <form method="POST" enctype="multipart/form-data" id="addCvForm">
                                        @csrf
                                        <div class="row">
                                            <!-- Kişisel Bilgiler Başlığı -->
                                            <div class="col-md-12">
                                                <h6 class="mb-3"><i class="fa fa-user me-2 text-primary"></i>Kişisel
                                                    Bilgiler</h6>
                                            </div>

                                            <!-- İsim -->
                                            <div class="col-md-6">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">
                                                        <i class="fa fa-user fa-fw" style="color: #6c757d;"></i>
                                                    </span>
                                                    <input id="addName" name="name" type="text" class="form-control"
                                                        placeholder="İsim giriniz" />
                                                </div>
                                            </div>
                                            <!-- Pozisyon -->
                                            <div class="col-md-6">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">
                                                        <i class="fa fa-briefcase fa-fw" style="color: #6c757d;"></i>
                                                    </span>
                                                    <input id="addPosition" name="position" type="text"
                                                        class="form-control" placeholder="Pozisyon giriniz" />
                                                </div>
                                            </div>
                                            <!-- Slogan -->
                                            <div class="col-md-6">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">
                                                        <i class="fa fa-quote-left fa-fw" style="color: #6c757d;"></i>
                                                    </span>
                                                    <input id="addSlogan" name="slogan" type="text" class="form-control"
                                                        placeholder="Sloganları virgülle giriniz" />
                                                </div>
                                            </div>
                                            <!-- Doğum Tarihi -->
                                            <div class="col-md-6">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">
                                                        <i class="fa fa-birthday-cake fa-fw" style="color: #6c757d;"></i>
                                                    </span>
                                                    <input id="addBirthday" name="birthday" type="date"
                                                        class="form-control" />
                                                </div>
                                            </div>
                                            <!-- Derece -->
                                            <div class="col-md-6">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">
                                                        <i class="fa fa-graduation-cap fa-fw" style="color: #6c757d;"></i>
                                                    </span>
                                                    <input id="addDegree" name="degree" type="text" class="form-control"
                                                        placeholder="Derece giriniz" />
                                                </div>
                                            </div>
                                            <!-- E-Posta -->
                                            <div class="col-md-6">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">
                                                        <i class="fa fa-envelope fa-fw" style="color: #6c757d;"></i>
                                                    </span>
                                                    <input id="addEmail" name="email" type="email"
                                                        class="form-control" placeholder="E-posta giriniz" />
                                                </div>
                                            </div>
                                            <!-- Telefon -->
                                            <div class="col-md-6">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">
                                                        <i class="fa fa-phone fa-fw" style="color: #6c757d;"></i>
                                                    </span>
                                                    <input id="addPhone" name="phone" type="tel"
                                                        class="form-control" placeholder="Telefon giriniz" />
                                                </div>
                                            </div>
                                            <!-- Adres -->
                                            <div class="col-md-6">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">
                                                        <i class="fa fa-map-marker-alt fa-fw" style="color: #6c757d;"></i>
                                                    </span>
                                                    <input id="addAddress" name="address" type="text"
                                                        class="form-control" placeholder="Adres giriniz" />
                                                </div>
                                            </div>

                                            <!-- Profesyonel Bilgiler Başlığı -->
                                            <div class="col-md-12">
                                                <h6 class="mt-3 mb-3"><i
                                                        class="fa fa-briefcase me-2 text-primary"></i>Profesyonel
                                                    Bilgiler</h6>
                                            </div>

                                            <!-- Tecrübe -->
                                            <div class="col-md-4">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">
                                                        <i class="fa fa-history fa-fw" style="color: #6c757d;"></i>
                                                    </span>
                                                    <input id="addExperience" name="experience" type="number"
                                                        min="0" class="form-control"
                                                        placeholder="Tecrübe (Yıl)" />
                                                </div>
                                            </div>

                                            <!-- Proje Sayısı -->
                                            <div class="col-md-4">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">
                                                        <i class="fa fa-tasks fa-fw" style="color: #6c757d;"></i>
                                                    </span>
                                                    <input id="addProjects" name="projects" type="number"
                                                        min="0" class="form-control" placeholder="Proje Sayısı" />
                                                </div>
                                            </div>

                                            <!-- Müşteri Sayısı -->
                                            <div class="col-md-4">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">
                                                        <i class="fa fa-users fa-fw" style="color: #6c757d;"></i>
                                                    </span>
                                                    <input id="addClients" name="clients" type="number" min="0"
                                                        class="form-control" placeholder="Müşteri Sayısı" />
                                                </div>
                                            </div>

                                            <!-- Freelance Durumu -->
                                            <div class="col-md-12">
                                                <div class="form-group mb-3">
                                                    <label class="form-label d-block">Freelance Durumu</label>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="freelance"
                                                            id="addFreelanceYes" value="Müsait">
                                                        <label class="form-check-label"
                                                            for="addFreelanceYes">Müsait</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="freelance"
                                                            id="addFreelanceNo" value="Müsait Değil">
                                                        <label class="form-check-label" for="addFreelanceNo">Müsait
                                                            Değil</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Sosyal Medya Başlığı -->
                                            <div class="col-md-12">
                                                <h6 class="mt-3 mb-3"><i
                                                        class="fa fa-share-alt me-2 text-primary"></i>Sosyal Medya
                                                    Bağlantıları</h6>
                                            </div>

                                            <!-- Sosyal Medya: LinkedIn -->
                                            <div class="col-md-4">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">
                                                        <i class="fab fa-linkedin fa-fw" style="color: #6c757d;"></i>
                                                    </span>
                                                    <input id="addLinkedin" name="linkedin" type="url"
                                                        class="form-control" placeholder="LinkedIn URL" />
                                                </div>
                                            </div>
                                            <!-- Sosyal Medya: Github -->
                                            <div class="col-md-4">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">
                                                        <i class="fab fa-github fa-fw" style="color: #6c757d;"></i>
                                                    </span>
                                                    <input id="addGithub" name="github" type="url"
                                                        class="form-control" placeholder="Github URL" />
                                                </div>
                                            </div>
                                            <!-- Sosyal Medya: Twitter -->
                                            <div class="col-md-4">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">
                                                        <i class="fab fa-twitter fa-fw" style="color: #6c757d;"></i>
                                                    </span>
                                                    <input id="addTwitter" name="twitter" type="url"
                                                        class="form-control" placeholder="Twitter URL" />
                                                </div>
                                            </div>
                                            <!-- Sosyal Medya: Facebook -->
                                            <div class="col-md-4">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">
                                                        <i class="fab fa-facebook fa-fw" style="color: #6c757d;"></i>
                                                    </span>
                                                    <input id="addFacebook" name="facebook" type="url"
                                                        class="form-control" placeholder="Facebook URL" />
                                                </div>
                                            </div>
                                            <!-- Sosyal Medya: Instagram -->
                                            <div class="col-md-4">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">
                                                        <i class="fab fa-instagram fa-fw" style="color: #6c757d;"></i>
                                                    </span>
                                                    <input id="addInstagram" name="instagram" type="url"
                                                        class="form-control" placeholder="Instagram URL" />
                                                </div>
                                            </div>
                                            <!-- Sosyal Medya: Website -->
                                            <div class="col-md-4">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">
                                                        <i class="fa fa-globe fa-fw" style="color: #6c757d;"></i>
                                                    </span>
                                                    <input id="addWebsite" name="website" type="url"
                                                        class="form-control" placeholder="Website URL" />
                                                </div>
                                            </div>

                                            <!-- Dosya Alanları Başlığı -->
                                            <div class="col-md-12">
                                                <h6 class="mt-3 mb-3"><i class="fa fa-file me-2 text-primary"></i>Dosya
                                                    Alanları</h6>
                                            </div>

                                            <!-- Profil Resmi -->
                                            <div class="col-md-6">
                                                <label for="addImage" class="form-label">Profil Resmi</label>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">
                                                        <i class="fa fa-image fa-fw" style="color: #6c757d;"></i>
                                                    </span>
                                                    <input id="addImage" name="image" type="file"
                                                        class="form-control" accept="image/*" />
                                                </div>
                                                <div class="form-text text-muted">
                                                    <small>Önerilen: JPEG veya PNG formatında, kare boyutlu (300x300px) bir
                                                        resim.</small>
                                                </div>
                                            </div>

                                            <!-- CV Dosyası -->
                                            <div class="col-md-6">
                                                <label for="addCvFile" class="form-label">CV Dosyası</label>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">
                                                        <i class="fa fa-file-pdf fa-fw" style="color: #6c757d;"></i>
                                                    </span>
                                                    <input id="addCvFile" name="cv_file" type="file"
                                                        class="form-control" accept=".pdf,.doc,.docx" />
                                                </div>
                                                <div class="form-text text-muted">
                                                    <small>Kabul edilen formatlar: PDF, DOC veya DOCX.</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button type="submit" class="btn btn-primary" id="btnAddCv">Ekle</button>
                                            <button type="button" class="btn btn-danger"
                                                data-bs-dismiss="modal">Kapat</button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- CV Detay Modal -->
                    <div class="modal fade" id="cvDetailModal" tabindex="-1" role="dialog" aria-labelledby="cvDetailModalLabel">
                        <div class="modal-dialog modal-xl" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title">
                                        <i class="fa fa-id-card me-2"></i>
                                        <span class="fw-bold">CV Bilgileri</span>
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-0">
                                    <!-- Modal içeriği dinamik olarak doldurulacak -->
                                    <div id="cvDetailContent"></div>
                                </div>
                                <div class="modal-footer bg-light">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                        <i class="fa fa-times me-1"></i>Kapat
                                    </button>
                                    <button type="button" class="btn btn-primary" onclick="window.print()">
                                        <i class="fa fa-print me-1"></i>Yazdır
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- CV Düzenleme Modal -->
                    <div class="modal fade" id="cvEditModal" tabindex="-1" role="dialog" aria-labelledby="cvEditModalLabel">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="cvEditModalLabel">CV Bilgilerini Düzenle</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Kapat"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" enctype="multipart/form-data" id="cvEditForm">
                                        @csrf
                                        <input type="hidden" name="id" id="editID">
                                        <div class="row">
                                            <!-- Mevcut Profil Resmi -->
                                            <div class="col-md-12 mb-3 text-center" id="profileImageContainer">
                                                <!-- Dinamik olarak doldurulacak -->
                                            </div>

                                            <!-- Kişisel Bilgiler Başlığı -->
                                            <div class="col-md-12">
                                                <h6 class="mb-3">
                                                    <span class="fa fa-user me-2 text-primary"
                                                        role="presentation"></span>Kişisel Bilgiler
                                                </h6>
                                            </div>

                                            <!-- İsim -->
                                            <div class="col-md-6">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">
                                                        <span class="fa fa-user fa-fw" style="color: #6c757d;"
                                                            role="presentation"></span>
                                                    </span>
                                                    <input id="editName" name="name" type="text"
                                                        class="form-control" placeholder="İsim giriniz">
                                                </div>
                                            </div>

                                            <!-- Pozisyon -->
                                            <div class="col-md-6">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">
                                                        <span class="fa fa-briefcase fa-fw" style="color: #6c757d;"
                                                            role="presentation"></span>
                                                    </span>
                                                    <input id="editPosition" name="position" type="text"
                                                        class="form-control" placeholder="Pozisyon giriniz">
                                                </div>
                                            </div>

                                            <!-- Slogan -->
                                            <div class="col-md-6">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">
                                                        <span class="fa fa-quote-left fa-fw" style="color: #6c757d;"
                                                            role="presentation"></span>
                                                    </span>
                                                    <input id="editSlogan" name="slogan" type="text"
                                                        class="form-control"
                                                        placeholder="Sloganları virgülle ayırarak giriniz">
                                                </div>
                                            </div>

                                            <!-- Doğum Tarihi -->
                                            <div class="col-md-6">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">
                                                        <span class="fa fa-birthday-cake fa-fw" style="color: #6c757d;"
                                                            role="presentation"></span>
                                                    </span>
                                                    <input id="editBirthday" name="birthday" type="date"
                                                        class="form-control">
                                                </div>
                                            </div>

                                            <!-- Derece -->
                                            <div class="col-md-6">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">
                                                        <span class="fa fa-graduation-cap fa-fw" style="color: #6c757d;"
                                                            role="presentation"></span>
                                                    </span>
                                                    <input id="editDegree" name="degree" type="text"
                                                        class="form-control" placeholder="Derece giriniz">
                                                </div>
                                            </div>

                                            <!-- E-Posta -->
                                            <div class="col-md-6">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">
                                                        <span class="fa fa-envelope fa-fw" style="color: #6c757d;"
                                                            role="presentation"></span>
                                                    </span>
                                                    <input id="editEmail" name="email" type="email"
                                                        class="form-control" placeholder="E-posta giriniz">
                                                </div>
                                            </div>

                                            <!-- Telefon -->
                                            <div class="col-md-6">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">
                                                        <span class="fa fa-phone fa-fw" style="color: #6c757d;"
                                                            role="presentation"></span>
                                                    </span>
                                                    <input id="editPhone" name="phone" type="tel"
                                                        class="form-control" placeholder="Telefon giriniz">
                                                </div>
                                            </div>

                                            <!-- Adres -->
                                            <div class="col-md-6">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">
                                                        <span class="fa fa-map-marker-alt fa-fw" style="color: #6c757d;"
                                                            role="presentation"></span>
                                                    </span>
                                                    <input id="editAddress" name="address" type="text"
                                                        class="form-control" placeholder="Adres giriniz">
                                                </div>
                                            </div>

                                            <!-- Profesyonel Bilgiler Başlığı -->
                                            <div class="col-md-12">
                                                <h6 class="mt-3 mb-3">
                                                    <span class="fa fa-briefcase me-2 text-primary"
                                                        role="presentation"></span>Profesyonel Bilgiler
                                                </h6>
                                            </div>

                                            <!-- Tecrübe -->
                                            <div class="col-md-4">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">
                                                        <span class="fa fa-history fa-fw" style="color: #6c757d;"
                                                            role="presentation"></span>
                                                    </span>
                                                    <input id="editExperience" name="experience" type="number"
                                                        min="0" class="form-control" placeholder="Tecrübe (Yıl)">
                                                </div>
                                            </div>

                                            <!-- Proje Sayısı -->
                                            <div class="col-md-4">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">
                                                        <span class="fa fa-tasks fa-fw" style="color: #6c757d;"
                                                            role="presentation"></span>
                                                    </span>
                                                    <input id="editProjects" name="projects" type="number"
                                                        min="0" class="form-control" placeholder="Proje Sayısı">
                                                </div>
                                            </div>

                                            <!-- Müşteri Sayısı -->
                                            <div class="col-md-4">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">
                                                        <span class="fa fa-users fa-fw" style="color: #6c757d;"
                                                            role="presentation"></span>
                                                    </span>
                                                    <input id="editClients" name="clients" type="number" min="0"
                                                        class="form-control" placeholder="Müşteri Sayısı">
                                                </div>
                                            </div>

                                            <!-- Freelance Durumu -->
                                            <div class="col-md-12">
                                                <div class="form-group mb-3">
                                                    <label class="form-label d-block">Freelance Durumu</label>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="freelance"
                                                            id="editFreelanceYes" value="Müsait">
                                                        <label class="form-check-label"
                                                            for="editFreelanceYes">Müsait</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="freelance"
                                                            id="editFreelanceNo" value="Müsait Değil">
                                                        <label class="form-check-label" for="editFreelanceNo">Müsait
                                                            Değil</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Sosyal Medya Başlığı -->
                                            <div class="col-md-12">
                                                <h6 class="mt-3 mb-3">
                                                    <span class="fa fa-share-alt me-2 text-primary"
                                                        role="presentation"></span>Sosyal Medya Bağlantıları
                                                </h6>
                                            </div>

                                            <!-- LinkedIn -->
                                            <div class="col-md-4">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">
                                                        <span class="fab fa-linkedin fa-fw" style="color: #6c757d;"
                                                            role="presentation"></span>
                                                    </span>
                                                    <input id="editLinkedin" name="linkedin" type="url"
                                                        class="form-control" placeholder="LinkedIn URL">
                                                </div>
                                            </div>

                                            <!-- Github -->
                                            <div class="col-md-4">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">
                                                        <span class="fab fa-github fa-fw" style="color: #6c757d;"
                                                            role="presentation"></span>
                                                    </span>
                                                    <input id="editGithub" name="github" type="url"
                                                        class="form-control" placeholder="Github URL">
                                                </div>
                                            </div>

                                            <!-- Twitter -->
                                            <div class="col-md-4">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">
                                                        <span class="fab fa-twitter fa-fw" style="color: #6c757d;"
                                                            role="presentation"></span>
                                                    </span>
                                                    <input id="editTwitter" name="twitter" type="url"
                                                        class="form-control" placeholder="Twitter URL">
                                                </div>
                                            </div>

                                            <!-- Facebook -->
                                            <div class="col-md-4">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">
                                                        <span class="fab fa-facebook fa-fw" style="color: #6c757d;"
                                                            role="presentation"></span>
                                                    </span>
                                                    <input id="editFacebook" name="facebook" type="url"
                                                        class="form-control" placeholder="Facebook URL">
                                                </div>
                                            </div>

                                            <!-- Instagram -->
                                            <div class="col-md-4">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">
                                                        <span class="fab fa-instagram fa-fw" style="color: #6c757d;"
                                                            role="presentation"></span>
                                                    </span>
                                                    <input id="editInstagram" name="instagram" type="url"
                                                        class="form-control" placeholder="Instagram URL">
                                                </div>
                                            </div>

                                            <!-- Website -->
                                            <div class="col-md-4">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">
                                                        <span class="fa fa-globe fa-fw" style="color: #6c757d;"
                                                            role="presentation"></span>
                                                    </span>
                                                    <input id="editWebsite" name="website" type="url"
                                                        class="form-control" placeholder="Website URL">
                                                </div>
                                            </div>

                                            <!-- Dosya Alanları Başlığı -->
                                            <div class="col-md-12">
                                                <h6 class="mt-3 mb-3">
                                                    <span class="fa fa-file me-2 text-primary"
                                                        role="presentation"></span>Dosya Alanları
                                                </h6>
                                            </div>

                                            <!-- Resim -->
                                            <div class="col-md-6">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">
                                                        <span class="fa fa-image fa-fw" style="color: #6c757d;"
                                                            role="presentation"></span>
                                                    </span>
                                                    <input id="editImage" name="image" type="file"
                                                        class="form-control">
                                                </div>
                                                <small class="text-muted">Mevcut resmi değiştirmek istemiyorsanız boş
                                                    bırakın.</small>
                                            </div>

                                            <!-- CV Dosyası -->
                                            <div class="col-md-6">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">
                                                        <span class="fa fa-file fa-fw" style="color: #6c757d;"
                                                            role="presentation"></span>
                                                    </span>
                                                    <input id="editCvFile" name="cv_file" type="file"
                                                        class="form-control">
                                                </div>
                                                <small class="text-muted">Mevcut CV dosyasını değiştirmek istemiyorsanız
                                                    boş bırakın.</small>
                                            </div>
                                        </div>
                                        <input type="submit" hidden id="cvEditSubmit">
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">İptal</button>
                                    <button type="submit" class="btn btn-primary" id="cvEditSaveButton"
                                        onclick="document.getElementById('cvEditSubmit').click()">Kaydet</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="add-row" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>AKTİF</th>
                                    <th>RESİM</th>
                                    <th>İSİM</th>
                                    <th>POZİSYON</th>
                                    <th>E-MAIL</th>
                                    <th>TELEFON</th>
                                    <th>SON GÜNCELLEME TARİHİ</th>
                                    <th style="width: 10%" class="text-center">İŞLEMLER</th>
                                </tr>
                            </thead>
                            <tbody id="cvList">
                            <!-- CV Listeleme Dinamik İçerik --> 
                            <tr id="loading-row">
                                <td colspan="8" class="text-center">
                                    <div class="d-flex justify-content-center align-items-center py-4">
                                        <div class="position-relative">
                                            <div class="spinner-border text-primary spinner-border-lg" style="width: 3rem; height: 3rem;" role="status">
                                                <span class="visually-hidden">Yükleniyor...</span>
                                            </div>
                                        </div>
                                        <div class="ms-4">
                                            <h5 class="text-primary mb-1 fw-bold">CV Listesi Yükleniyor</h5>
                                            <div class="text-muted">
                                                <small>Lütfen bekleyiniz, veriler hazırlanıyor...</small>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
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
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/js/integrator.cdn.js') }}"></script>

    <script>
        var cvApiService = new ApiFormIntegrator.ApiService({
            baseUrl: 'http://127.0.0.1:8000/api',
            sweetalert2: true,
        });
        let submitCounter = 0;

        document.addEventListener('DOMContentLoaded', function() {
            setupModalListeners();
            loadCvList();
        });



        function setupTooltipListeners() {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }

        function loadCvList() {
            cvApiService.request({
                url: '/cv-information',
                method: 'GET',
                sweetalert2: false,
                actions: {
                    onSuccess: (response) => {
                        const cvList = document.getElementById('cvList');
                        cvList.innerHTML = '';
                        if (response.data.data.length > 0) {
                            response.data.data.forEach(cvInfo => {
                                cvList.innerHTML += `
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio"
                                                    id="activeCheckbox_${cvInfo.id}" name="active"
                                                    value="${cvInfo.id}" ${cvInfo.is_active ? 'checked' : ''}>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="avatar">
                                                <img src="${cvInfo.image ? cvInfo.image : '/assets/img/default-avatar.jpg'}"
                                                    alt="${cvInfo.name || 'CV Resmi'}"
                                                    class="avatar-img rounded">
                                            </div>
                                        </td>
                                        <td>${cvInfo.name ?? 'İsimsiz' }</td>
                                        <td>${cvInfo.position ?? 'Belirtilmemiş' }</td>
                                        <td>${cvInfo.email ?? 'Belirtilmemiş' }</td>
                                        <td>${cvInfo.phone ?? 'Belirtilmemiş' }</td>
                                        <td>${cvInfo.created_at ? new Date(cvInfo.created_at).toLocaleDateString('tr-TR') : 'Belirtilmemiş' }</td>
                                        <td>
                                            <div class="form-button-action">
                                                <button type="button" 
                                                    class="btn btn-link btn-primary btn-lg view-btn"
                                                    data-bs-toggle="tooltip"
                                                    title="CV Bilgilerini Görüntüle"
                                                    onclick="loadCvDetail(${cvInfo.id})">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                                <button type="button"
                                                    class="btn btn-link btn-primary btn-lg edit-btn"
                                                    data-bs-toggle="tooltip"
                                                    title="CV Bilgilerini Düzenle"
                                                    onclick="prepareCvEditModal(${cvInfo.id})">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <button type="button"
                                                    class="btn btn-link btn-primary btn-lg delete-btn"
                                                    data-bs-toggle="tooltip"
                                                    title="CV Bilgilerini Sil"
                                                    onclick="deleteCv(${cvInfo.id})">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                `;
                            });
                        } else {
                            cvList.innerHTML = `
                                <tr>
                                    <td colspan="8" class="text-center">Henüz kaydedilmiş CV bulunmamaktadır.</td>
                                </tr>
                                `;
                        }
                    }
                }
            });
        }

        function prepareCvEditModal(cvId) {

            // CV verilerini API'den çek
            cvApiService.request({
                url: `/cv-information/${cvId}`,
                method: 'GET',
                sweetalert2: false,
                actions: {
                    onSuccess: (response) => {
                        if (response.data) {
                            // Form verilerini doldur
                            fillCvEditForm(response.data.data);

                            showModal('#cvEditModal');
                        }
                    },
                    onError: (error) => {
                        console.error('CV verileri yüklenirken hata oluştu:', error);
                    },
                    errors: {
                        message: 'CV bilgileri yüklenirken bir hata oluştu.'
                    }
                }
            });
        }
        // CV verilerini form alanlarına doldur
        function fillCvEditForm(cv) {
            // Profil resmi
            const profileContainer = document.getElementById('profileImageContainer');
            if (cv.image) {
                profileContainer.innerHTML =
                    `<img src="${cv.image}" alt="${cv.name || 'Kullanıcı'} profil resmi" class="img-thumbnail" style="max-height: 150px;">`;
            } else {
                profileContainer.innerHTML =
                    `<div class="no-image-placeholder text-muted"><i class="fa fa-user fa-3x"></i><p class="small">Profil resmi yok</p></div>`;
            }


            document.getElementById('editID').value = cv.id;

            // Kişisel bilgiler
            document.getElementById('editName').value = cv.name || '';
            document.getElementById('editPosition').value = cv.position || '';
            document.getElementById('editSlogan').value = Array.isArray(cv.slogan) ? cv.slogan.join(',') : (cv
                .slogan || '');
            document.getElementById('editBirthday').value = cv.birthday || '';
            document.getElementById('editDegree').value = cv.degree || '';
            document.getElementById('editEmail').value = cv.email || '';
            document.getElementById('editPhone').value = cv.phone || '';
            document.getElementById('editAddress').value = cv.address || '';

            // Profesyonel bilgiler
            document.getElementById('editExperience').value = cv.experience || '0';
            document.getElementById('editProjects').value = cv.projects || '0';
            document.getElementById('editClients').value = cv.clients || '0';

            // Freelance durumu
            document.getElementById('editFreelanceYes').checked = cv.freelance;
            document.getElementById('editFreelanceNo').checked = !cv.freelance;

            // Sosyal medya
            if (cv.social_media) {
                document.getElementById('editLinkedin').value = cv.social_media.linkedin || '';
                document.getElementById('editGithub').value = cv.social_media.github || '';
                document.getElementById('editTwitter').value = cv.social_media.twitter || '';
                document.getElementById('editFacebook').value = cv.social_media.facebook || '';
                document.getElementById('editInstagram').value = cv.social_media.instagram || '';
                document.getElementById('editWebsite').value = cv.social_media.website || '';
            }
        }
        // Fonksiyonlar
        function loadCvDetail(cvId) {
            cvApiService.request({
                url: `/cv-information/${cvId}`,
                method: 'GET',
                sweetalert2: false,
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
                                <a href="${cvInfo.cv_file ? '/storage/' + cvInfo.cv_file : '#'}" class="btn btn-outline-primary"
                                    target="_blank">
                                    <i class="fa fa-download me-2"></i>CV İndir
                                </a>
                                    <div class="mt-2">
                                  <span class="badge ${cvInfo.is_active ? 'bg-success' : 'bg-secondary'} py-2 px-3">
                                 <i class="fa fa-${cvInfo.is_active ? 'check-circle' : 'times-circle'} me-1"></i>
                                  ${cvInfo.is_active ? 'Aktif' : 'Pasif'}
                                    </span>
                                </div>
                                <p class="mt-2 small text-muted">
                                    <i class="fa fa-calendar me-1"></i> Doğum: ${cvInfo.birthday ? new Date(cvInfo.birthday).toLocaleDateString('tr-TR') : '-'}
                                </p>
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
                                                class="badge ${cvInfo.freelance === 'Müsait' ? 'bg-success' : 'bg-danger'} rounded-pill">
                                                ${cvInfo.freelance || 'Belirtilmemiş'}
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

        function deleteCv(cvId) {
            cvApiService.request({
                url: `/cv-information/${cvId}`,
                method: 'DELETE',
                sweetalert2: true,
                actions: {
                    onSuccess: () => {
                        loadCvList();
                    },
                    success: {
                        message: 'CV bilgileri silindi'
                    },
                    errors: {
                        message: 'CV bilgileri silinemedi'
                    }
                }
            });
        }
    </script>
@endpush
