# Laravel CV API

Modern, kapsamlı ve test edilmiş bir CV/Portfolio REST API'si.

## 🚀 Özellikler

### 👤 Kimlik Doğrulama
- JWT tabanlı kimlik doğrulama
- Admin paneli için güvenli erişim
- Rate limiting

### 📝 CV Yönetimi
- Kişisel bilgiler
- Deneyimler
- Yetenekler
- Hizmetler
- Portfolio projeleri
- Referanslar
- İletişim formu

### 📁 Dosya İşlemleri
- Resim yükleme (avatar, portfolio, referanslar)
- CV dosyası yükleme
- Otomatik boyutlandırma ve optimizasyon
- Güvenli depolama

### 📧 İletişim
- Mail gönderimi
- Rate limiting
- Özelleştirilmiş mail şablonları
- Kuyruk sistemi

## 🧪 Test Kapsamı

  ![3BmibMDc5T](https://github.com/user-attachments/assets/1b4ae7e8-6183-448c-8b57-082c53400096)
  ![z3LLBHlRu5](https://github.com/user-attachments/assets/02c03bf5-6644-4ddd-81eb-73747d1c9826)

## 🛠️ Teknolojiler

- PHP 8.2+
- Laravel 11
- MySQL 8.0+
- JWT Authentication
- PHPUnit
- Laravel Mail
- Laravel Storage

## 📦 Kurulum

1. Repository'yi klonlayın
  ```bash
  git clone https://github.com/username/cv-api.git
  cd cv-api
  ```

2. Bağımlılıkları yükleyin
  ```bash
  composer install
  ```

3. Ortam değişkenlerini ayarlayın
  ```bash
  cp .env.example .env
  php artisan key:generate
  ```

4. Veritabanını hazırlayın
  ```bash
  php artisan migrate --seed
  ```

5. Storage linkini oluşturun
  ```bash
  php artisan storage:link
  ```

## 🔑 API Endpoints

### Auth
- POST /api/login
- POST /api/logout

### CV Information
- GET /api/cv-information
- POST /api/cv-information
- PUT /api/cv-information/{id}
- DELETE /api/cv-information/{id}

### Portfolio
- GET /api/portfolios
- POST /api/portfolios
- PUT /api/portfolios/{id}
- DELETE /api/portfolios/{id}

### Services
- GET /api/services
- POST /api/services
- PUT /api/services/{id}
- DELETE /api/services/{id}

### Skills
- GET /api/skills
- POST /api/skills
- PUT /api/skills/{id}
- DELETE /api/skills/{id}

### Testimonials
- GET /api/testimonials
- POST /api/testimonials
- PUT /api/testimonials/{id}
- DELETE /api/testimonials/{id}

### Contact
- POST /api/contact

## 🧪 Testleri Çalıştırma

  ```bash
  php artisan test
  ```

## 📝 Lisans

MIT License

## 👨‍💻 Geliştirici

[RhymeRone](https://github.com/RhymeRone)
