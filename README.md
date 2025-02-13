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

### 🔐 Auth
| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| POST | `/api/login` | Admin girişi | No |
| POST | `/api/logout` | Çıkış yapma | Yes |

### 📋 CV Information
| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| GET | `/api/cv-information` | Tüm CV bilgilerini listele | No |
| GET | `/api/cv-information/{id}` | Belirli CV bilgisini göster | No |
| POST | `/api/cv-information` | Yeni CV bilgisi oluştur | Yes |
| PUT | `/api/cv-information/{id}` | CV bilgisini güncelle | Yes |
| DELETE | `/api/cv-information/{id}` | CV bilgisini sil | Yes |

### 💪 Skills
| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| GET | `/api/skills` | Tüm yetenekleri listele | No |
| GET | `/api/skills/{id}` | Belirli yeteneği göster | No |
| POST | `/api/skills` | Yeni yetenek oluştur | Yes |
| PUT | `/api/skills/{id}` | Yeteneği güncelle | Yes |
| DELETE | `/api/skills/{id}` | Yeteneği sil | Yes |

### 👨‍💼 Experience
| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| GET | `/api/experiences` | Tüm deneyimleri listele | No |
| GET | `/api/experiences/{id}` | Belirli deneyimi göster | No |
| POST | `/api/experiences` | Yeni deneyim oluştur | Yes |
| PUT | `/api/experiences/{id}` | Deneyimi güncelle | Yes |
| DELETE | `/api/experiences/{id}` | Deneyimi sil | Yes |

### 🛠️ Services
| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| GET | `/api/services` | Tüm hizmetleri listele | No |
| GET | `/api/services/{id}` | Belirli hizmeti göster | No |
| POST | `/api/services` | Yeni hizmet oluştur | Yes |
| PUT | `/api/services/{id}` | Hizmeti güncelle | Yes |
| DELETE | `/api/services/{id}` | Hizmeti sil | Yes |

### 💼 Portfolio
| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| GET | `/api/portfolios` | Tüm portfolyo projelerini listele | No |
| GET | `/api/portfolios/{id}` | Belirli portfolyo projesini göster | No |
| POST | `/api/portfolios` | Yeni portfolyo projesi oluştur | Yes |
| PUT | `/api/portfolios/{id}` | Portfolyo projesini güncelle | Yes |
| DELETE | `/api/portfolios/{id}` | Portfolyo projesini sil | Yes |

### 📁 Portfolio Categories
| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| GET | `/api/portfolio-categories` | Tüm kategorileri listele | No |
| GET | `/api/portfolio-categories/{id}` | Belirli kategoriyi göster | No |
| POST | `/api/portfolio-categories` | Yeni kategori oluştur | Yes |
| PUT | `/api/portfolio-categories/{id}` | Kategoriyi güncelle | Yes |
| DELETE | `/api/portfolio-categories/{id}` | Kategoriyi sil | Yes |

### 👥 Testimonials
| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| GET | `/api/testimonials` | Tüm referansları listele | No |
| GET | `/api/testimonials/{id}` | Belirli referansı göster | No |
| POST | `/api/testimonials` | Yeni referans oluştur | Yes |
| PUT | `/api/testimonials/{id}` | Referansı güncelle | Yes |
| DELETE | `/api/testimonials/{id}` | Referansı sil | Yes |

### 📧 Contact
| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| POST | `/api/contact` | İletişim formu mesajı gönder | No* |

> *Contact endpoint'i rate limiting ile korunmaktadır.

## 🧪 Testleri Çalıştırma

  ```bash
  php artisan test
  ```

## 📝 Lisans

MIT License

## 👨‍💻 Geliştirici

[RhymeRone](https://github.com/RhymeRone)
