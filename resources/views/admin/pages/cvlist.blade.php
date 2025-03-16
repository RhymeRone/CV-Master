@extends('layouts.admin.master')

@section('title', 'CV Listesi')

@section('route', route('admin.cvlist'))

@section('content')
    <div class="page-inner">
        @include('layouts.admin.partials.page-header')
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">Özgeçmiş Listeniz</h4>
                        <button class="btn btn-primary btn-round ms-auto" data-bs-toggle="modal" data-bs-target="#addRowModal">
                            <i class="fa fa-plus"></i>
                            CV Ekle
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Modal -->
                    <!-- Yeni CV Ekleme Modal -->
                    <div class="modal fade" id="addRowModal" tabindex="-1" role="dialog"
                        aria-labelledby="addRowModalLabel">
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
                                                    <input id="addEmail" name="email" type="email" class="form-control"
                                                        placeholder="E-posta giriniz" />
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
                                                            id="addFreelanceYes" value="1">
                                                        <label class="form-check-label"
                                                            for="addFreelanceYes">Müsait</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="freelance"
                                                            id="addFreelanceNo" value="0">
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
                    <div class="modal fade" id="cvDetailModal" tabindex="-1" role="dialog"
                        aria-labelledby="cvDetailModalLabel">
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
                                    <button type="button" class="btn btn-primary" id="cvDetailPrintButton"
                                        onclick="printCVData(cvInfo)">
                                        <i class="fa fa-print me-2"></i> Yazdır
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- CV Düzenleme Modal -->
                    <div class="modal fade" id="cvEditModal" tabindex="-1" role="dialog"
                        aria-labelledby="cvEditModalLabel">
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
                                                <img id="currentImagePreview" src="" alt=""
                                                    class="img-thumbnail" style="max-height: 150px;">
                                                <div class="no-image-placeholder text-muted" id="noImageText"><i
                                                        class="fa fa-user fa-3x"></i>
                                                    <p class="small">Profil resmi yok</p>
                                                </div>
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
                                                            id="editFreelanceYes" value="1">
                                                        <label class="form-check-label"
                                                            for="editFreelanceYes">Müsait</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="freelance"
                                                            id="editFreelanceNo" value="0">
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
                                            <!-- Mevcut dosya bilgilerini saklayacak hidden input'lar -->
                                            <input type="hidden" id="current_image" name="current_image">
                                            <input type="hidden" id="current_cv_file" name="current_cv_file">

                                            <!-- Mevcut profil resmi bilgisi -->
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Mevcut Profil Resmi</label>
                                                    <div id="currentImagePreview" class="mb-2">
                                                        <a id="currentImageLink" href="" target="_blank"
                                                            class="btn btn-sm btn-outline-secondary"
                                                            style="display: none;">
                                                            <i class="fa fa-image"></i> Profil Resmini Görüntüle
                                                        </a>
                                                        <span id="noImageText" class="text-muted"
                                                            style="display: none;">Profil resmi yok</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Mevcut CV dosyası bilgisi -->
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Mevcut CV Dosyası</label>
                                                    <div id="currentCvFilePreview" class="mb-2">
                                                        <a id="currentCvFileLink" href="" target="_blank"
                                                            class="btn btn-sm btn-outline-secondary"
                                                            style="display: none;">
                                                            <i class="fa fa-file-pdf"></i> CV Dosyasını Görüntüle
                                                        </a>
                                                        <span id="noCvFileText" class="text-muted"
                                                            style="display: none;">CV dosyası yok</span>
                                                    </div>
                                                </div>
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
                                                    <input id="edit" name="cv_file" type="file"
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

                    <!-- Görsel Modalı -->
                    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="imageModalLabel">Portfolyo Görseli</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Kapat"></button>
                                </div>
                                <div class="modal-body text-center p-0">
                                    <img src="" id="modalImage" class="img-fluid w-100" alt="Portfolyo Görseli">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Kapat</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="add-row" class="display table table-hover">
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
        var cvApiService;
        var formEntegrator;
        document.addEventListener('DOMContentLoaded', function() {

            setTimeout(() => {
                cvApiService = window.apiService;
                formEntegrator = window.integrator;
                setupModalListeners();
                loadCvList();
            }, 100);

        });



        function setActive(cvId) {
            cvApiService.request({
                url: `/cv-information/set-active/${cvId}`,
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

        function loadCvList() {
            const cvList = document.getElementById('cvList');


            cvList.innerHTML = `
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
            `;

            cvApiService.request({
                url: '/cv-information',
                method: 'GET',
                sweetalert2: false,
                disableNotifications: true,
                actions: {
                    onSuccess: (response) => {
                        cvList.innerHTML = '';
                        if (response.data.data.length > 0) {
                            response.data.data.forEach(cvInfo => {
                                cvList.innerHTML += `
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input active-status-input" type="radio" name="active"
                                                    value="${cvInfo.id}" ${cvInfo.is_active ? 'checked disabled' : ''} onclick="setActive(${cvInfo.id})">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="avatar">
                                                <img src="${cvInfo.image ? cvInfo.image : '/assets/img/default-avatar.jpg'}"
                                                    alt="${cvInfo.name || 'CV Resmi'}"
                                                    class="avatar-img rounded"
                                                    style="cursor: pointer;"
                                                    onclick="openImageModal('${cvInfo.image ? cvInfo.image : '/assets/img/default-avatar.jpg'}', '${cvInfo.name || 'CV Resmi'}')">
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
                                                    onclick="editCv(${cvInfo.id})">
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

        function editCv(cvId) {
            formEntegrator.loadFormData('EDIT_CV', {
                params: {
                    id: cvId
                }
            });
            showModal('#cvEditModal');
        }

        // Fonksiyonlar
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

        function deleteCv(cvId) {
            cvApiService.request({
                url: `/cv-information/${cvId}`,
                method: 'DELETE',
                sweetalert2: true,
                showConfirm: {
                    enabled: true,
                    title: 'CV Silme Onayı',
                    text: 'Bu işlemi gerçekleştirmek istediğinize emin misiniz?',
                    icon: 'warning',
                    confirmButtonText: 'Evet, Sil',
                    cancelButtonText: 'İptal',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33'
                },
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


        // ---------------------------------- ESKİ CV DÜZENLEME MODAL FONKSİYONU ----------------------------------
        function prepareCvEditModal(cvId) {



            // CV verilerini API'den çek
            cvApiService.request({
                url: `/cv-information/${cvId}`,
                method: 'GET',
                sweetalert2: false,
                disableNotifications: true,
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

            // Mevcut dosya bilgilerini hidden input'lara kaydet
            document.getElementById('current_image').value = cv.image || '';
            document.getElementById('current_cv_file').value = cv.cv_file || '';

            // Profil resmi bağlantısını göster
            const imageLink = document.getElementById('currentImageLink');
            const noImgText = document.getElementById('noImageText');

            if (cv.image) {
                imageLink.href = cv.image;
                imageLink.style.display = 'block';
                noImgText.style.display = 'none';
            } else {
                imageLink.style.display = 'none';
                noImgText.style.display = 'block';
            }

            // CV dosyası bağlantısını göster
            const cvFileLink = document.getElementById('currentCvFileLink');
            const noCvText = document.getElementById('noCvFileText');

            if (cv.cv_file) {
                cvFileLink.href = cv.cv_file;
                cvFileLink.style.display = 'block';
                noCvText.style.display = 'none';
            } else {
                cvFileLink.style.display = 'none';
                noCvText.style.display = 'block';
            }

            document.getElementById('editID').value = cv.id;

            // Kişisel bilgiler
            document.getElementById('editName').value = cv.name || '';
            document.getElementById('editPosition').value = cv.position || '';
            document.getElementById('editSlogan').value = Array.isArray(cv.slogan) ? cv.slogan.join(',') : (cv
                .slogan || '');

            document.getElementById('editBirthday').value = cv.birthday ? cv.birthday.split('T')[0] : '';
            document.getElementById('editDegree').value = cv.degree || '';
            document.getElementById('editEmail').value = cv.email || '';
            document.getElementById('editPhone').value = cv.phone || '';
            document.getElementById('editAddress').value = cv.address || '';

            // Profesyonel bilgiler
            document.getElementById('editExperience').value = cv.experience || '0';
            document.getElementById('editProjects').value = cv.projects || '0';
            document.getElementById('editClients').value = cv.clients || '0';

            // Freelance durumu
            if (cv.freelance == 1) {
                document.getElementById('editFreelanceYes').checked = true;
            } else {
                document.getElementById('editFreelanceNo').checked = true;
            }

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
    <!----------------------------------------------- YAZDIRMA MODAL ----------------------------------------- -->

    <!-- Loading Spinner HTML -->
    <div id="print-loading"
        style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255,255,255,0.9); z-index: 9999; display: none; justify-content: center; align-items: center;">
        <div
            style="background: white; border-radius: 10px; box-shadow: 0 5px 25px rgba(0,0,0,0.1); padding: 25px; text-align: center;">
            <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;"></div>
            <div class="mt-3 fw-bold">CV yazdırmaya hazırlanıyor...</div>
            <div class="small text-muted mt-2">Bu işlem birkaç saniye sürebilir</div>
        </div>
    </div>

    <!-- Yazdırma için gizli iframe -->
    <iframe id="print-iframe" style="position: absolute; width: 0; height: 0; border: 0; visibility: hidden;"></iframe>

    <script type="text/javascript">
        function printCVData(cvData) {
            if (!cvData) {
                alert('Yazdırılacak CV bilgisi bulunamadı.');
                return;
            }

            // Loading göster
            var loading = document.getElementById('print-loading');
            loading.style.display = 'flex';

            // iframe referansı
            var iframe = document.getElementById('print-iframe');
            var iframeDoc = iframe.contentDocument || iframe.contentWindow.document;

            // CSS Stilleri
            var styles = `
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: "Roboto", sans-serif; font-size: 11pt; line-height: 1.4; color: #333; background: white; }
    h1, h2, h3, h4, h5 { font-family: "Poppins", sans-serif; margin: 0; line-height: 1.2; }
    
    .a4-container { width: 210mm; height: 297mm; margin: 0 auto; padding: 15mm; background: white; position: relative; page-break-after: always; }
    
    .cv-header { display: flex; justify-content: space-between; margin-bottom: 10px; border-bottom: 2px solid #4a6cf7; padding-bottom: 10px; }
    .cv-header-content { flex: 1; }
    .cv-name { font-size: 18pt; font-weight: 600; color: #2c3e50; margin-bottom: 3px; }
    .cv-position { font-size: 12pt; font-weight: 500; color: #4a6cf7; margin-bottom: 5px; }
    .cv-slogan { font-size: 10pt; font-style: italic; color: #6c757d; margin-bottom: 5px; }
    
    .cv-profile-image { width: 80px; height: 80px; object-fit: cover; border-radius: 50%; border: 2px solid #4a6cf7; }
    
    .cv-container { display: flex; flex-wrap: wrap; gap: 10px; }
    .cv-left-column { flex: 0 0 65%; }
    .cv-right-column { flex: 0 0 32%; }
    
    .section { margin-bottom: 10px; }
    .section-title { font-size: 12pt; font-weight: 600; color: #4a6cf7; margin-bottom: 8px; padding-bottom: 3px; border-bottom: 1px solid #e9ecef; display: flex; align-items: center; }
    .section-title i { margin-right: 5px; width: 18px; text-align: center; }
    
    .info-list { list-style: none; margin: 0; padding: 0; }
    .info-item { margin-bottom: 5px; display: flex; align-items: center; }
    .info-icon { width: 22px; color: #4a6cf7; text-align: center; margin-right: 8px; flex-shrink: 0; }
    .info-label { font-weight: 500; margin-right: 5px; flex-shrink: 0; font-size: 10pt; }
    .info-content { color: #555; flex-grow: 1; font-size: 10pt; }
    
    .stats-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 6px; }
    .stat-card { position: relative; background: #f8f9fa; padding: 8px; border-radius: 5px; text-align: center; overflow: hidden; }
    .stat-value { font-size: 16pt; font-weight: 700; margin-bottom: 2px; color: #4a6cf7; }
    .stat-label { font-size: 9pt; color: #6c757d; }
    .stat-icon { position: absolute; bottom: -10px; right: -10px; font-size: 40px; opacity: 0.1; color: #4a6cf7; }
    
    .social-links { display: flex; flex-wrap: wrap; gap: 5px; margin-top: 5px; }
    .social-link { font-size: 9pt; text-decoration: none; color: #555; display: flex; align-items: center; }
    .social-link i { margin-right: 3px; color: #4a6cf7; }
    
    @media print {
      @page { size: A4 portrait; margin: 0; }
      html, body { width: 210mm; height: 297mm; }
      .a4-container { box-shadow: none; margin: 0; padding: 15mm; }
      .cv-container { break-inside: avoid; }
    }`;

            // HTML içeriğini oluştur
            var htmlContent = createCVHTML(cvData);

            // iframe içeriğini tamamen temizle
            iframeDoc.open();
            iframeDoc.close();

            // Head içeriğini oluştur
            iframeDoc.head.innerHTML = `
        <meta charset="UTF-8">
        <title>CV - ${cvData.name || ''} ${cvData.surname || ''}</title>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Poppins:wght@500;600&display=swap" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet">
        <style>${styles}</style>
    `;

            // Body içeriğini oluştur
            iframeDoc.body.innerHTML = htmlContent;

            // Loading'i kapat ve yazdır
            setTimeout(function() {
                loading.style.display = 'none';
                iframe.contentWindow.focus();
                iframe.contentWindow.print();
            }, 1000);
        }

        // CV HTML içeriğini oluştur - ayrı bir fonksiyon
        function createCVHTML(cvData) {
            var html = '<div class="a4-container">';

            // CV Header
            html += '<div class="cv-header">';
            html += '<div class="cv-header-content">';
            html += '<h1 class="cv-name">' + (cvData.name || '') + ' ' + (cvData.surname || '') + '</h1>';
            html += '<h3 class="cv-position">' + (cvData.position || 'Pozisyon belirtilmemiş') + '</h3>';

            if (cvData.slogan) {
                html += '<p class="cv-slogan">"' + cvData.slogan + '"</p>';
            }

            // Durum badge
            html += '<span style="font-size: 9pt; color: ' + (cvData.is_active ? '#0ca678' : '#868e96') + ';">';
            html += '<i class="fas fa-' + (cvData.is_active ? 'check-circle' : 'times-circle') + ' me-1"></i> ';
            html += cvData.is_active ? 'Aktif CV' : 'Pasif CV';
            html += '</span>';
            html += '</div>'; // header-content end

            // Profil Resmi
            html += '<div>';
            if (cvData.image) {
                html += '<img src="' + cvData.image + '" class="cv-profile-image" alt="Profil">';
            } else {
                html +=
                    '<div class="cv-profile-image" style="background: #f1f3f5; display: flex; align-items: center; justify-content: center;">';
                html += '<i class="fas fa-user fa-2x text-secondary"></i>';
                html += '</div>';
            }
            html += '</div>';
            html += '</div>'; // header end

            // İki Sütunlu İçerik
            html += '<div class="cv-container">';

            // SOL SÜTUN
            html += '<div class="cv-left-column">';

            // Kişisel Bilgiler
            html += '<div class="section">';
            html += '<div class="section-title"><i class="fas fa-user"></i>Kişisel Bilgiler</div>';
            html += '<ul class="info-list">';

            // Doğum Tarihi
            if (cvData.birthday) {
                html += '<li class="info-item">';
                html += '<div class="info-icon"><i class="fas fa-birthday-cake"></i></div>';
                html += '<div class="info-label">Doğum:</div>';
                html += '<div class="info-content">' + new Date(cvData.birthday).toLocaleDateString('tr-TR') + '</div>';
                html += '</li>';
            }

            // Eğitim Derecesi
            if (cvData.degree) {
                html += '<li class="info-item">';
                html += '<div class="info-icon"><i class="fas fa-graduation-cap"></i></div>';
                html += '<div class="info-label">Eğitim:</div>';
                html += '<div class="info-content">' + cvData.degree + '</div>';
                html += '</li>';
            }

            // Freelance Durumu
            html += '<li class="info-item">';
            html += '<div class="info-icon"><i class="fas fa-' + (cvData.freelance ? 'check' : 'briefcase') +
                '"></i></div>';
            html += '<div class="info-label">Çalışma:</div>';
            html += '<div class="info-content">' + (cvData.freelance ? 'Freelance Çalışabilir' : 'Tam Zamanlı') + '</div>';
            html += '</li>';

            html += '</ul>';
            html += '</div>'; // Kişisel bilgiler son

            // İstatistikler
            html += '<div class="section">';
            html += '<div class="section-title"><i class="fas fa-chart-bar"></i>Deneyim ve İstatistikler</div>';
            html += '<div class="stats-grid">';

            // Tecrübe Yılı
            if (cvData.experience) {
                html += '<div class="stat-card">';
                html += '<h3 class="stat-value">' + cvData.experience + '</h3>';
                html += '<p class="stat-label">Yıllık Tecrübe</p>';
                html += '<div class="stat-icon"><i class="fas fa-history"></i></div>';
                html += '</div>';
            }

            // Proje Sayısı
            if (cvData.projects) {
                html += '<div class="stat-card">';
                html += '<h3 class="stat-value">' + cvData.projects + '</h3>';
                html += '<p class="stat-label">Tamamlanan Proje</p>';
                html += '<div class="stat-icon"><i class="fas fa-tasks"></i></div>';
                html += '</div>';
            }

            // Müşteri Sayısı
            if (cvData.clients) {
                html += '<div class="stat-card">';
                html += '<h3 class="stat-value">' + cvData.clients + '</h3>';
                html += '<p class="stat-label">Mutlu Müşteri</p>';
                html += '<div class="stat-icon"><i class="fas fa-users"></i></div>';
                html += '</div>';
            }

            // Özgün İstatistik
            html += '<div class="stat-card">';
            html += '<h3 class="stat-value">%100</h3>';
            html += '<p class="stat-label">Müşteri Memnuniyeti</p>';
            html += '<div class="stat-icon"><i class="fas fa-heart"></i></div>';
            html += '</div>';

            html += '</div>'; // stats-grid end
            html += '</div>'; // İstatistikler son

            // CV Dosyası Bilgisi
            if (cvData.cv_file) {
                html += '<div class="section">';
                html += '<div class="section-title"><i class="fas fa-file-alt"></i>CV Dosyası</div>';
                html +=
                    '<div style="font-size: 9pt; background: #e3f2fd; border-radius: 5px; padding: 5px; display: flex; align-items: center;">';
                html += '<i class="fas fa-file-pdf text-primary me-2"></i>';

                // Dosya adını çıkar
                var fileName = cvData.cv_file.split('/').pop();
                html += '<span>' + fileName + '</span>';

                html += '</div>';
                html += '</div>';
            }

            html += '</div>'; // sol sütun sonu

            // SAĞ SÜTUN
            html += '<div class="cv-right-column">';

            // İletişim Bilgileri
            html += '<div class="section">';
            html += '<div class="section-title"><i class="fas fa-address-card"></i>İletişim</div>';
            html += '<ul class="info-list">';

            // Email
            if (cvData.email) {
                html += '<li class="info-item">';
                html += '<div class="info-icon"><i class="fas fa-envelope"></i></div>';
                html += '<div class="info-label">E-posta:</div>';
                html += '<div class="info-content">' + cvData.email + '</div>';
                html += '</li>';
            }

            // Telefon
            if (cvData.phone) {
                html += '<li class="info-item">';
                html += '<div class="info-icon"><i class="fas fa-phone"></i></div>';
                html += '<div class="info-label">Telefon:</div>';
                html += '<div class="info-content">' + cvData.phone + '</div>';
                html += '</li>';
            }

            // Adres
            if (cvData.address) {
                html += '<li class="info-item">';
                html += '<div class="info-icon"><i class="fas fa-map-marker-alt"></i></div>';
                html += '<div class="info-label">Adres:</div>';
                html += '<div class="info-content">' + cvData.address + '</div>';
                html += '</li>';
            }

            // Website
            if (cvData.social_media.website) {
                html += '<li class="info-item">';
                html += '<div class="info-icon"><i class="fas fa-globe"></i></div>';
                html += '<div class="info-label">Website:</div>';
                html += '<div class="info-content">' + cvData.social_media.website + '</div>';
                html += '</li>';
            }

            html += '</ul>';
            html += '</div>'; // İletişim son

            // Sosyal Medya
            html += '<div class="section">';
            html += '<div class="section-title"><i class="fas fa-share-alt"></i>Sosyal Medya</div>';
            html += '<div class="social-links">';

            if (cvData.social_media.linkedin) {
                html += '<a href="' + cvData.social_media.linkedin +
                    '" class="social-link"><i class="fab fa-linkedin"></i>LinkedIn</a>';
            }
            if (cvData.social_media.github) {
                html += '<a href="' + cvData.social_media.github +
                    '" class="social-link"><i class="fab fa-github"></i>GitHub</a>';
            }
            if (cvData.social_media.twitter) {
                html += '<a href="' + cvData.social_media.twitter +
                    '" class="social-link"><i class="fab fa-twitter"></i>Twitter</a>';
            }
            if (cvData.social_media.facebook) {
                html += '<a href="' + cvData.social_media.facebook +
                    '" class="social-link"><i class="fab fa-facebook"></i>Facebook</a>';
            }
            if (cvData.social_media.instagram) {
                html += '<a href="' + cvData.social_media.instagram +
                    '" class="social-link"><i class="fab fa-instagram"></i>Instagram</a>';
            }

            html += '</div>'; // social-links end
            html += '</div>'; // Sosyal medya son

            // Yetenekler
            html += '<div class="section">';
            html += '<div class="section-title"><i class="fas fa-star"></i>Yetenekler</div>';

            // Sabit yetenekler
            html += '<div style="display: flex; flex-wrap: wrap; gap: 5px; margin-top: 5px;">';
            html +=
                '<span style="font-size: 9pt; background: #f8f9fa; padding: 3px 8px; border-radius: 3px;">Problem Çözme</span>';
            html +=
                '<span style="font-size: 9pt; background: #f8f9fa; padding: 3px 8px; border-radius: 3px;">Takım Çalışması</span>';
            html +=
                '<span style="font-size: 9pt; background: #f8f9fa; padding: 3px 8px; border-radius: 3px;">İletişim</span>';
            html +=
                '<span style="font-size: 9pt; background: #f8f9fa; padding: 3px 8px; border-radius: 3px;">Analitik Düşünme</span>';
            html +=
                '<span style="font-size: 9pt; background: #f8f9fa; padding: 3px 8px; border-radius: 3px;">Zaman Yönetimi</span>';
            html += '</div>';

            html += '</div>'; // Yetenekler son

            html += '</div>'; // sağ sütun sonu

            html += '</div>'; // cv-container end

            // Alt bilgi
            html +=
                '<div style="position: absolute; bottom: 15mm; left: 15mm; right: 15mm; font-size: 8pt; color: #adb5bd; text-align: center;">';
            html += 'Bu CV ' + new Date().toLocaleDateString('tr-TR') + ' tarihinde oluşturulmuştur | CV-Master &copy; ' +
                new Date().getFullYear();
            html += '</div>';

            html += '</div>'; // a4-container end

            return html;
        }
    </script>
@endpush
