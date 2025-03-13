// API Form Integrator Konfigürasyonu @ts-check
import { disposeModal, showModal } from '../utils/modals';
export const integratorConfig = {
  FORMS: {
    LOGIN: {
      selector: '#loginForm', // Formun DOM'daki seçicisi (ID, class, vs.)
      endpoint: '/login', // API endpoint'i
      method: 'POST', // HTTP methodu (GET, POST, PUT, DELETE, vs.)
      preventRedirect: false, // Başarılı istekten sonra yönlendirmeyi engeller
      validation: true, // validasyon kontrolünü aktifleştir
      sweetalert2: true, // SweetAlert2 kullanımını etkinleştirir false ile console hataları gösterir.
      // tokenKey: 'token', // Token anahtarı (header'da token değeri), tokenName'e göre önceliklidir.
      // tokenName: 'token', // Token adı (localStorage'da token adı, dot notation desteği bulunmaktadır örneğin data.token.tokenName. tokenKey değeri girilirse bu alan gerekli değildir.)
      // -> tokenName ne işe yarar? 
      // -> tokenName değeri girildiğinde, token değeri localStorage'da data.token.tokenName şeklinde saklanır.
      // -> tokenName değeri api yanıtında token ismidir. Yanıtta token ismi verilmişse bu değeri giriniz. 
      // -> Örnek: {"data.token": "1234567890"} şeklinde bir yanıt aldığınızda tokenName değerini "data.token" olarak giriniz.
      // -> tokenKey değeri girildiğinde, token değeri header'da Authorization: Bearer tokenKey değeri şeklinde saklanır.
      // clearToken: true, // İstek sonrası token temizleme, eğer true ise tokenName değeri varsa localStorage'da silinir.
      validationOptions: {
        errorDisplayMode: 'pop', // Hata mesajının görünümü
        showErrors: true,
        errorClass: 'is-invalid',
        successClass: 'is-valid',
        errorColor: 'red',
      },
      fields: {
        email: {
          rules: ['required', 'email'], // Validasyon kuralları
          messages: {
            required: 'Email alanı zorunludur.',
            email: 'Geçerli bir email adresi giriniz.',
          },
        },
        password: {
          rules: ['required', 'min:6'], // Şifre için en az 6 karakter kuralı
          messages: {
            required: 'Şifre alanı zorunludur.',
            min: 'Şifre en az 6 karakter olmalıdır.',
          },
        },
      },
      actions: {
        // onSubmit callback desteği: Form gönderilmeden önce çalışır.
        onSubmit: (formData) => { console.log(formData) }, // Form verilerini konsola yazdır
        // onSuccess callback desteği: API başarılı yanıt verdiğinde çalışır.
        onSuccess: (response) => { console.log(response + "onSuccess başarılı"); return true }, // true döndürürse default işlemler çalışır.
        // onError callback desteği: API hata döndürdüğünde çalışır.
        onError: (error) => { console.log(error); return true }, // false döndürürse default hata işlemleri çalışmaz.
        success: {
          redirect: 'admin/dashboard', // Yönlendirme yapılacak sayfa
          message: 'Giriş başarılı!', // Başarı mesajı
        },
        errors: {
          // redirect: '/login',
          message: 'Bir hata oluştu',
          400: {
            redirect: 'admin/dashboard',
            message: 'Zaten giriş yapılmış', // 400 hatası için mesaj
          },
          401: {
            message: 'Email veya şifre hatalı!', // 401 hatası için mesaj
          },
          422: {
            message: 'Lütfen tüm alanları doldurun', // 422 hatası için mesaj
          },
        },
      },
    },
    ADD_CV: {
      selector: '#addCvForm', // Formun DOM'daki seçicisi (ID, class, vs.)
      endpoint: '/cv-information', // API endpoint'i
      method: 'POST', // HTTP methodu (GET, POST, PUT, DELETE, vs.)
      sweetalert2: true, // SweetAlert2 kullanımını etkinleştirir false ile console hataları gösterir.
      preventRedirect: true, // Başarılı istekten sonra yönlendirmeyi engeller
      validation: true, // validasyon kontrolünü aktifleştir
      validationOptions: {
        errorDisplayMode: 'inline', // Hata mesajının görünümü
        showErrors: true,
        errorClass: 'is-invalid',
        successClass: 'is-valid',
        errorColor: 'red',
      },
      fields: {
        // Kişisel Bilgiler
        name: {
          rules: [
            'required',
            'min:2',
            'max:100',
            'regex:/^[a-zA-ZğüşıöçĞÜŞİÖÇ\\s]+$/'
          ],
          messages: {
            required: 'İsim alanı zorunludur.',
            min: 'İsim en az 2 karakter olmalıdır.',
            max: 'İsim en fazla 100 karakter olmalıdır.',
            regex: 'İsim sadece harflerden oluşmalıdır.'
          }
        },
        position: {
          rules: [
            'required',
            'min:3',
            'max:100',
            'regex:/^[a-zA-ZğüşıöçĞÜŞİÖÇ\\s]+$/'
          ],
          messages: {
            required: 'Pozisyon alanı zorunludur.',
            min: 'Pozisyon en az 3 karakter olmalıdır.',
            max: 'Pozisyon en fazla 100 karakter olmalıdır.',
            regex: 'Pozisyon sadece harflerden oluşmalıdır.'
          }
        },
        slogan: {
          rules: [
            'required',
            'max:255'
          ],
          messages: {
            required: 'Slogan alanı zorunludur.',
            max: 'Slogan en fazla 255 karakter olmalıdır.'
          }
        },
        birthday: {
          rules: [
            'required',
            'date',
            'before:today',
            'after:1900-01-01'
          ],
          messages: {
            required: 'Doğum tarihi alanı zorunludur.',
            date: 'Geçerli bir doğum tarihi giriniz.',
            before: 'Doğum tarihi bugünden önce olmalıdır.',
            after: 'Doğum tarihi 1900 yılından sonra olmalıdır.'
          }
        },
        degree: {
          rules: [
            'required',
            'max:100'
          ],
          messages: {
            required: 'Derece alanı zorunludur.',
            max: 'Derece en fazla 100 karakter olmalıdır.'
          }
        },
        email: {
          rules: [
            'required',
            'email',
            'max:255',
            'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'
          ],
          messages: {
            required: 'E-posta alanı zorunludur.',
            email: 'Geçerli bir e-posta adresi giriniz.',
            max: 'E-posta en fazla 255 karakter olmalıdır.',
            regex: 'Geçerli bir e-posta formatı giriniz.'
          }
        },
        phone: {
          rules: [
            'required',
            'min:10',
            'max:15',
            'regex:/^[0-9]+$/'
          ],
          messages: {
            required: 'Telefon alanı zorunludur.',
            min: 'Telefon numarası en az 10 karakter olmalıdır.',
            max: 'Telefon numarası en fazla 15 karakter olmalıdır.',
            regex: 'Telefon numarası sadece rakamlardan oluşmalıdır.'
          }
        },
        address: {
          rules: [
            'required',
            'max:255'
          ],
          messages: {
            required: 'Adres alanı zorunludur.',
            max: 'Adres en fazla 255 karakter olmalıdır.'
          }
        },

        // Profesyonel Bilgiler
        experience: {
          rules: [
            'required',
            'numeric',
            'min:0',
            'max:100'
          ],
          messages: {
            required: 'Tecrübe alanı zorunludur.',
            numeric: 'Tecrübe sayısal bir değer olmalıdır.',
            min: 'Tecrübe 0 veya daha büyük olmalıdır.',
            max: 'Tecrübe 100 yıldan fazla olamaz.'
          }
        },
        projects: {
          rules: [
            'required',
            'numeric',
            'min:0',
            'max:10000'
          ],
          messages: {
            required: 'Proje sayısı alanı zorunludur.',
            numeric: 'Proje sayısı sayısal bir değer olmalıdır.',
            min: 'Proje sayısı 0 veya daha büyük olmalıdır.',
            max: 'Proje sayısı 10000\'den fazla olamaz.'
          }
        },
        clients: {
          rules: [
            'required',
            'numeric',
            'min:0',
            'max:10000'
          ],
          messages: {
            required: 'Müşteri sayısı alanı zorunludur.',
            numeric: 'Müşteri sayısı sayısal bir değer olmalıdır.',
            min: 'Müşteri sayısı 0 veya daha büyük olmalıdır.',
            max: 'Müşteri sayısı 10000\'den fazla olamaz.'
          }
        },
        freelance: {
          rules: [
            'required',
            'boolean',
          ],
          messages: {
            required: 'Freelance durumu alanı zorunludur.',
            boolean: 'Freelance durumu boolean formatında olmalıdır.',
          }
        },

        // Sosyal Medya Bağlantıları
        linkedin: {
          rules: [
            'required',
            'url',
            'regex:/^(https?:\/\/)?(www\.)?linkedin\.com\/.*$/'
          ],
          messages: {
            required: 'LinkedIn alanı zorunludur.',
            url: 'Geçerli bir LinkedIn URL\'si giriniz.',
            regex: 'Geçerli bir LinkedIn profil bağlantısı giriniz.'
          }
        },
        github: {
          rules: [
            'required',
            'url',
            'regex:/^(https?:\/\/)?(www\.)?github\.com\/.*$/'
          ],
          messages: {
            required: 'GitHub alanı zorunludur.',
            url: 'Geçerli bir GitHub URL\'si giriniz.',
            regex: 'Geçerli bir GitHub profil bağlantısı giriniz.'
          }
        },
        twitter: {
          rules: [
            'required',
            'url',
            'regex:/^(https?:\/\/)?(www\.)?(twitter|x)\.com\/.*$/'
          ],
          messages: {
            required: 'Twitter alanı zorunludur.',
            url: 'Geçerli bir Twitter URL\'si giriniz.',
            regex: 'Geçerli bir Twitter profil bağlantısı giriniz.'
          }
        },
        facebook: {
          rules: [
            'required',
            'url',
            'regex:/^(https?:\/\/)?(www\.)?facebook\.com\/.*$/'
          ],
          messages: {
            required: 'Facebook alanı zorunludur.',
            url: 'Geçerli bir Facebook URL\'si giriniz.',
            regex: 'Geçerli bir Facebook profil bağlantısı giriniz.'
          }
        },
        instagram: {
          rules: [
            'required',
            'url',
            'regex:/^(https?:\/\/)?(www\.)?instagram\.com\/.*$/'
          ],
          messages: {
            required: 'Instagram alanı zorunludur.',
            url: 'Geçerli bir Instagram URL\'si giriniz.',
            regex: 'Geçerli bir Instagram profil bağlantısı giriniz.'
          }
        },
        website: {
          rules: [
            'required',
            'url',
            'regex:/^(https?:\/\/)?(www\.)?[a-zA-Z0-9][a-zA-Z0-9-]{1,61}[a-zA-Z0-9]\.[a-zA-Z]{2,}.*$/'
          ],
          messages: {
            required: 'Website alanı zorunludur.',
            url: 'Geçerli bir website URL\'si giriniz.',
            regex: 'Geçerli bir website adresi giriniz.'
          }
        },

        // Dosya Alanları
        image: {
          rules: [
            'required',
            'file',
            'image',
            'mimes:jpeg,png,jpg,gif',
            'max:2048', // 2MB
            'dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000'
          ],
          messages: {
            required: 'Profil resmi alanı zorunludur.',
            file: 'Profil resmi bir dosya olmalıdır.',
            image: 'Yüklenen dosya bir resim olmalıdır.',
            mimes: 'Resim JPEG, PNG, JPG veya GIF formatında olmalıdır.',
            max: 'Resim boyutu en fazla 2MB olmalıdır.',
            dimensions: 'Resim boyutları en az 100x100px, en fazla 2000x2000px olmalıdır.'
          }
        },
        cv_file: {
          rules: [
            'required',
            'file',
            'mimes:pdf,doc,docx',
            'max:5120' // 5MB
          ],
          messages: {
            required: 'CV dosyası alanı zorunludur.',
            file: 'CV bir dosya olmalıdır.',
            mimes: 'CV dosyası PDF, DOC veya DOCX formatında olmalıdır.',
            max: 'CV dosyası boyutu en fazla 5MB olmalıdır.'
          }
        }
      },
      actions: {
        onSuccess: (response) => {
          disposeModal('#addRowModal');
          loadCvList();
          return true;
        },
        success: {
          message: 'CV başarıyla eklendi'
        },
        errors: {
          message: 'CV eklenirken bir hata oluştu',
          422: {
            message: 'Girilen bilgileri kontrol ediniz'
          }
        }
      }

    },
    EDIT_CV: {
      selector: '#cvEditForm', // Formun DOM'daki seçicisi (ID, class, vs.)
      endpoint: '/cv-information/{id}',
      method: 'POST', // HTTP methodu (GET, POST, PUT, DELETE, vs.)
      useFormData: true,
      sweetalert2: true, // SweetAlert2 kullanımını etkinleştirir false ile console hataları gösterir.
      headers: {
        'Content-Type': 'multipart/form-data', // İçerik tipi
        'X-HTTP-Method-Override': 'PUT',
        'X-CSRF-TOKEN': typeof document !== 'undefined'
          ? document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
          : process.env.CSRF_TOKEN // CSRF token'ının otomatik algılanması
      },
      preventRedirect: true, // Başarılı istekten sonra yönlendirmeyi engeller
      validation: true, // validasyon kontrolünü aktifleştir
      validationOptions: {
        errorDisplayMode: 'inline', // Hata mesajının görünümü
        showErrors: true,
        errorClass: 'is-invalid',
        successClass: 'is-valid',
        errorColor: 'red',
      },
      getData: {
        endpoint: 'cv-information/{id}',
        autoFill: false,
        mapping: {
          'name': 'name',
          'image': [{
            attribute: 'src',
            selector: '#currentImagePreview',
          },
          {
            attribute: 'value',
            selector: '#current_image',
          },
          {
            attribute: 'href',
            selector: '#currentImageLink',
            callback: (element, value, form) => {
              const noImgText = form.querySelector('#noImageText');
              if (value) {
                element.style.display = 'block';
                if (noImgText) noImgText.style.display = 'none';
              } else {
                element.style.display = 'none';
                if (noImgText) noImgText.style.display = 'block';
              }
            }
          }],
          'cv_file': [{
            attribute: 'value',
            selector: '#current_cv_file',
          },
          {
            attribute: 'href',
            selector: '#currentCvFileLink',
            callback: (element, value, form) => {
              const noCvText = form.querySelector('#noCvFileText');
              if (value) {
                element.style.display = 'block';
                if (noCvText) noCvText.style.display = 'none';
              } else {
                element.style.display = 'none';
                if (noCvText) noCvText.style.display = 'block';
              }
            }
          }],
          'social_media.linkedin': 'linkedin',
          'social_media.github': 'github',
          'social_media.twitter': 'twitter',
          'social_media.facebook': 'facebook',
          'social_media.instagram': 'instagram',
          'social_media.website': 'website',
          '*': true
        }
      },
      fields: {
        // Kişisel Bilgiler
        name: {
          rules: [
            'required',
            'min:2',
            'max:100',
            'regex:/^[a-zA-ZğüşıöçĞÜŞİÖÇ\\s]+$/'
          ],
          messages: {
            required: 'İsim alanı zorunludur.',
            min: 'İsim en az 2 karakter olmalıdır.',
            max: 'İsim en fazla 100 karakter olmalıdır.',
            regex: 'İsim sadece harflerden oluşmalıdır.'
          }
        },
        position: {
          rules: [
            'nullable',
            'min:3',
            'max:100',
            'regex:/^[a-zA-ZğüşıöçĞÜŞİÖÇ\\s]+$/'
          ],
          messages: {
            min: 'Pozisyon en az 3 karakter olmalıdır.',
            max: 'Pozisyon en fazla 100 karakter olmalıdır.',
            regex: 'Pozisyon sadece harflerden oluşmalıdır.'
          }
        },
        slogan: {
          rules: [
            'nullable',
            'max:255'
          ],
          messages: {
            max: 'Slogan en fazla 255 karakter olmalıdır.'
          }
        },
        birthday: {
          rules: [
            'nullable',
            'date',
            'before:today',
            'after:1900-01-01'
          ],
          messages: {
            date: 'Geçerli bir doğum tarihi giriniz.',
            before: 'Doğum tarihi bugünden önce olmalıdır.',
            after: 'Doğum tarihi 1900 yılından sonra olmalıdır.'
          }
        },
        degree: {
          rules: [
            'nullable',
            'max:100'
          ],
          messages: {
            max: 'Derece en fazla 100 karakter olmalıdır.'
          }
        },
        email: {
          rules: [
            'nullable',
            'email',
            'max:255',
            'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'
          ],
          messages: {
            email: 'Geçerli bir e-posta adresi giriniz.',
            max: 'E-posta en fazla 255 karakter olmalıdır.',
            regex: 'Geçerli bir e-posta formatı giriniz.'
          }
        },
        phone: {
          rules: [
            'nullable',
            'min:10',
            'max:15',
            'regex:/^[0-9]+$/'
          ],
          messages: {
            min: 'Telefon numarası en az 10 karakter olmalıdır.',
            max: 'Telefon numarası en fazla 15 karakter olmalıdır.',
            regex: 'Telefon numarası sadece rakamlardan oluşmalıdır.'
          }
        },
        address: {
          rules: [
            'nullable',
            'max:255'
          ],
          messages: {
            max: 'Adres en fazla 255 karakter olmalıdır.'
          }
        },

        // Profesyonel Bilgiler
        experience: {
          rules: [
            'nullable',
            'numeric',
            'min:0',
            'max:100'
          ],
          messages: {
            numeric: 'Tecrübe sayısal bir değer olmalıdır.',
            min: 'Tecrübe 0 veya daha büyük olmalıdır.',
            max: 'Tecrübe 100 yıldan fazla olamaz.'
          }
        },
        projects: {
          rules: [
            'nullable',
            'numeric',
            'min:0',
            'max:10000'
          ],
          messages: {
            numeric: 'Proje sayısı sayısal bir değer olmalıdır.',
            min: 'Proje sayısı 0 veya daha büyük olmalıdır.',
            max: 'Proje sayısı 10000\'den fazla olamaz.'
          }
        },
        clients: {
          rules: [
            'nullable',
            'numeric',
            'min:0',
            'max:10000'
          ],
          messages: {
            numeric: 'Müşteri sayısı sayısal bir değer olmalıdır.',
            min: 'Müşteri sayısı 0 veya daha büyük olmalıdır.',
            max: 'Müşteri sayısı 10000\'den fazla olamaz.'
          }
        },
        freelance: {
          rules: [
            'nullable',
            'boolean',
          ],
          messages: {
            boolean: 'Freelance durumu boolean formatında olmalıdır.',
          }
        },

        // Sosyal Medya Bağlantıları
        linkedin: {
          rules: [
            'nullable',
            'url',
            'regex:/^(https?:\/\/)?(www\.)?linkedin\.com\/.*$/'
          ],
          messages: {
            url: 'Geçerli bir LinkedIn URL\'si giriniz.',
            regex: 'Geçerli bir LinkedIn profil bağlantısı giriniz.'
          }
        },
        github: {
          rules: [
            'nullable',
            'url',
            'regex:/^(https?:\/\/)?(www\.)?github\.com\/.*$/'
          ],
          messages: {
            url: 'Geçerli bir GitHub URL\'si giriniz.',
            regex: 'Geçerli bir GitHub profil bağlantısı giriniz.'
          }
        },
        twitter: {
          rules: [
            'nullable',
            'url',
            'regex:/^(https?:\/\/)?(www\.)?(twitter|x)\.com\/.*$/'
          ],
          messages: {
            url: 'Geçerli bir Twitter URL\'si giriniz.',
            regex: 'Geçerli bir Twitter profil bağlantısı giriniz.'
          }
        },
        facebook: {
          rules: [
            'nullable',
            'url',
            'regex:/^(https?:\/\/)?(www\.)?facebook\.com\/.*$/'
          ],
          messages: {
            url: 'Geçerli bir Facebook URL\'si giriniz.',
            regex: 'Geçerli bir Facebook profil bağlantısı giriniz.'
          }
        },
        instagram: {
          rules: [
            'nullable',
            'url',
            'regex:/^(https?:\/\/)?(www\.)?instagram\.com\/.*$/'
          ],
          messages: {
            url: 'Geçerli bir Instagram URL\'si giriniz.',
            regex: 'Geçerli bir Instagram profil bağlantısı giriniz.'
          }
        },
        website: {
          rules: [
            'nullable',
            'url',
            'regex:/^(https?:\/\/)?(www\.)?[a-zA-Z0-9][a-zA-Z0-9-]{1,61}[a-zA-Z0-9]\.[a-zA-Z]{2,}.*$/'
          ],
          messages: {
            url: 'Geçerli bir website URL\'si giriniz.',
            regex: 'Geçerli bir website adresi giriniz.'
          }
        },

        // Dosya Alanları
        image: {
          rules: [
            'nullable',
            'file',
            'image',
            'mimes:jpeg,png,jpg,gif',
            'max:2048', // 2MB
            'dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000'
          ],
          messages: {
            file: 'Profil resmi bir dosya olmalıdır.',
            image: 'Yüklenen dosya bir resim olmalıdır.',
            mimes: 'Resim JPEG, PNG, JPG veya GIF formatında olmalıdır.',
            max: 'Resim boyutu en fazla 2MB olmalıdır.',
            dimensions: 'Resim boyutları en az 100x100px, en fazla 2000x2000px olmalıdır.'
          }
        },
        cv_file: {
          rules: [
            'nullable',
            'file',
            'mimes:pdf,doc,docx',
            'max:5120' // 5MB
          ],
          messages: {
            file: 'CV bir dosya olmalıdır.',
            mimes: 'CV dosyası PDF, DOC veya DOCX formatında olmalıdır.',
            max: 'CV dosyası boyutu en fazla 5MB olmalıdır.'
          }
        }
      },
      actions: {
        onSubmit: (formData, config) => {
          config.endpoint = config.endpoint.replace('{id}', formData.get('id'));
          // FormData nesnesini döngüye alarak tüm verileri konsola yazdır

          // // Boş dosya alanlarını formData'dan çıkar
          // if (document.getElementById('editCvFile').files.length === 0) {
          //   formData.delete('cv_file');
          // }

          // if (document.getElementById('editImage').files.length === 0) {
          //   formData.delete('image');
          // }
        },
        onSuccess: (response) => {
          disposeModal('#cvEditModal');
          loadCvList();
          return true;
        },
        success: {
          message: 'CV bilgileri başarıyla güncellendi'
        },
        errors: {
          message: 'CV bilgileri güncellenirken bir hata oluştu',
          422: {
            message: 'Girilen bilgileri kontrol ediniz'
          }
        }
      }

    },
    ADD_EXPERIENCES: {
      selector: '#addForm-experiences',
      endpoint: '/experiences',
      method: 'POST',
      useFormData: true,
      sweetalert2: true,
      preventRedirect: true,
      validation: true,
      validationOptions: {
        errorDisplayMode: 'inline',
        showErrors: true,
        errorClass: 'is-invalid',
        successClass: 'is-valid',
        errorColor: 'red',
      },
      fields: {
        position: {
          rules: ['required', 'min:3', 'max:100'],
          messages: {
            required: 'Pozisyon alanı zorunludur.',
            min: 'Pozisyon en az 3 karakter olmalıdır.',
            max: 'Pozisyon en fazla 100 karakter olmalıdır.',
          }
        },
        company: {
          rules: ['required', 'min:3', 'max:100'],
          messages: {
            required: 'Şirket alanı zorunludur.',
            min: 'Şirket en az 3 karakter olmalıdır.',
            max: 'Şirket en fazla 100 karakter olmalıdır.',
          }
        },
        start_date: {
          rules: ['required', 'date', 'before:end_date', 'after:1900-01-01'],
          messages: {
            required: 'Başlangıç tarihi alanı zorunludur.',
            date: 'Geçerli bir tarih giriniz.',
            before: 'Başlangıç tarihi bitiş tarihinden önce olmalıdır.',
            after: 'Başlangıç tarihi 1900 yılından sonra olmalıdır.',
          }
        },
        end_date: {
          rules: ['nullable', 'date', 'after:start_date', 'before:+1 year'],
          messages: {
            date: 'Geçerli bir tarih giriniz.',
            after: 'Bitiş tarihi başlangıç tarihinden sonra olmalıdır.',
            before: 'Bitiş tarihi gelecek yıldan büyük olamaz',
          }
        },
      },
      actions: {
        onSuccess: (response) => {
          disposeModal('#addModal');
          loadData();
          return true;
        },
        success: {
          message: 'Deneyim bilgileri başarıyla eklendi'
        },
        errors: {
          message: 'Deneyim bilgileri eklenirken bir hata oluştu',
        }
      }
    },
    EDIT_EXPERIENCES: {
      selector: '#editForm-experiences',
      endpoint: '/experiences/{id}',
      method: 'POST',
      headers: {
        'Content-Type': 'multipart/form-data', // İçerik tipi
        'X-HTTP-Method-Override': 'PUT',
        'X-CSRF-TOKEN': typeof document !== 'undefined'
          ? document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
          : process.env.CSRF_TOKEN // CSRF token'ının otomatik algılanması
      },
      useFormData: true,
      sweetalert2: true,
      preventRedirect: true,
      validation: true,
      validationOptions: {
        errorDisplayMode: 'inline',
        showErrors: true,
        errorClass: 'is-invalid',
        successClass: 'is-valid',
        errorColor: 'red',
      },
      getData: {
        endpoint: '/experiences/{id}',
        autoFill: false,
        mapping: {
          'start_date': 'start_date',
          'end_date': 'end_date',
          '*': true
        }
      },
      fields: {
        position: {
          rules: ['required', 'min:3', 'max:100'],
          messages: {
            required: 'Pozisyon alanı zorunludur.',
            min: 'Pozisyon en az 3 karakter olmalıdır.',
            max: 'Pozisyon en fazla 100 karakter olmalıdır.',
          }
        },
        company: {
          rules: ['required', 'min:3', 'max:100'],
          messages: {
            required: 'Şirket alanı zorunludur.',
            min: 'Şirket en az 3 karakter olmalıdır.',
            max: 'Şirket en fazla 100 karakter olmalıdır.',
          }
        },
        start_date: {
          rules: ['required', 'date', 'before:end_date', 'after:1900-01-01'],
          messages: {
            required: 'Başlangıç tarihi alanı zorunludur.',
            date: 'Geçerli bir tarih giriniz.',
            before: 'Başlangıç tarihi bitiş tarihinden önce olmalıdır.',
            after: 'Başlangıç tarihi 1900 yılından sonra olmalıdır.',
          }
        },
        end_date: {
          rules: ['nullable', 'date', 'after:start_date', 'before:+1 year'],
          messages: {
            date: 'Geçerli bir tarih giriniz.',
            after: 'Bitiş tarihi başlangıç tarihinden sonra olmalıdır.',
            before: 'Bitiş tarihi gelecek yıldan büyük olamaz',
          }
        },
      },
      actions: {
        onSubmit: (formData, config) => {
          config.endpoint = config.endpoint.replace('{id}', formData.get('id'));
        },
        onSuccess: (response) => {
          disposeModal('#editModal');
          loadData();
          return true;
        },
        success: {
          message: 'Deneyim bilgileri başarıyla güncellendi'
        },
        errors: {
          message: 'Deneyim bilgileri güncellenirken bir hata oluştu',
        }
      }
    },
    ADD_SERVICES: {
      selector: '#addForm-services',
      endpoint: '/services',
      method: 'POST',
      useFormData: true,
      sweetalert2: true,
      preventRedirect: true,
      validation: true,
      validationOptions: {
        errorDisplayMode: 'inline',
        showErrors: true,
        errorClass: 'is-invalid',
        successClass: 'is-valid',
        errorColor: 'red',
      },
      fields: {
        name: {
          rules: ['required', 'string', 'max:255'],
          messages: {
            required: 'Hizmet adı alanı zorunludur.',
            string: 'Hizmet adı metin formatında olmalıdır.',
            max: 'Hizmet adı en fazla 255 karakter olmalıdır.',
          }
        },
        // icon: {
        //   rules: ['required', 'string', 'max:50'],
        //   messages: {
        //     required: 'İkon alanı zorunludur.',
        //     string: 'İkon metin formatında olmalıdır.',
        //     max: 'İkon en fazla 50 karakter olmalıdır.',
        //   }
        // },
        description: {
          rules: ['required', 'string'],
          messages: {
            required: 'Açıklama alanı zorunludur.',
            string: 'Açıklama metin formatında olmalıdır.',
          }
        },
      },
      actions: {
        onSuccess: (response) => {
          disposeModal('#addModal');
          loadData();
          return true;
        },
        success: {
          message: 'Hizmet bilgileri başarıyla eklendi'
        },
        errors: {
          message: 'Hizmet bilgileri eklenirken bir hata oluştu',
        }
      }
    },
    EDIT_SERVICES: {
      selector: '#editForm-services',
      endpoint: '/services/{id}',
      method: 'POST',
      headers: {
        'Content-Type': 'multipart/form-data', // İçerik tipi
        'X-HTTP-Method-Override': 'PUT',
        'X-CSRF-TOKEN': typeof document !== 'undefined'
          ? document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
          : process.env.CSRF_TOKEN // CSRF token'ının otomatik algılanması
      },
      useFormData: true,
      sweetalert2: true,
      preventRedirect: true,
      validation: true,
      validationOptions: {
        errorDisplayMode: 'inline',
        showErrors: true,
        errorClass: 'is-invalid',
        successClass: 'is-valid',
        errorColor: 'red',
      },
      getData: {
        endpoint: '/services/{id}',
        autoFill: false,
        mapping: {
          '*': true
        }
      },
      fields: {
        name: {
          rules: ['required', 'string', 'max:255'],
          messages: {
            required: 'Hizmet adı alanı zorunludur.',
            string: 'Hizmet adı metin formatında olmalıdır.',
            max: 'Hizmet adı en fazla 255 karakter olmalıdır.',
          }
        },
        // icon: {
        //   rules: ['required', 'string', 'max:50'],
        //   messages: {
        //     required: 'İkon alanı zorunludur.',
        //     string: 'İkon metin formatında olmalıdır.',
        //     max: 'İkon en fazla 50 karakter olmalıdır.',
        //   }
        // },
        description: {
          rules: ['required', 'string'],
          messages: {
            required: 'Açıklama alanı zorunludur.',
            string: 'Açıklama metin formatında olmalıdır.',
          }
        },
      },
      actions: {
        onSubmit: (formData, config) => {
          config.endpoint = config.endpoint.replace('{id}', formData.get('id'));
        },
        onSuccess: (response) => {
          disposeModal('#editModal');
          loadData();
          return true;
        },
        success: {
          message: 'Hizmet bilgileri başarıyla güncellendi'
        },
        errors: {
          message: 'Hizmet bilgileri güncellenirken bir hata oluştu',
        }
      }
    },
    ADD_SKILLS: {
      selector: '#addForm-skills',
      endpoint: '/skills',
      method: 'POST',
      useFormData: true,
      sweetalert2: true,
      preventRedirect: true,
      validation: true,
      validationOptions: {
        errorDisplayMode: 'inline',
        showErrors: true,
        errorClass: 'is-invalid',
        successClass: 'is-valid',
        errorColor: 'red',
      },
      fields: {
        name: {
          rules: ['required', 'string', 'max:255'],
          messages: {
            required: 'Yetenek adı alanı zorunludur.',
            string: 'Yetenek adı metin formatında olmalıdır.',
            max: 'Yetenek adı en fazla 255 karakter olmalıdır.',
          }
        },
        level: {
          rules: ['required', 'integer', 'min:0', 'max:100'],
          messages: {
            required: 'Seviye alanı zorunludur.',
            integer: 'Seviye sayısal bir değer olmalıdır.',
            min: 'Seviye en az 0 olmalıdır.',
            max: 'Seviye en fazla 100 olmalıdır.',
          }
        },
        color: {
          rules: ['required', 'string', 'size:7', 'starts_with:#'],
          messages: {
            required: 'Renk alanı zorunludur.',
            string: 'Renk metin formatında olmalıdır.',
            size: 'Renk kodu 7 karakter olmalıdır.',
            starts_with: 'Renk kodu # ile başlamalıdır.',
          }
        },
      },
      actions: {
        onSuccess: (response) => {
          disposeModal('#addModal');
          loadData();
          return true;
        },
        success: {
          message: 'Yetenek başarıyla eklendi'
        },
        errors: {
          message: 'Yetenek eklenirken bir hata oluştu',
        }
      }
    },
    EDIT_SKILLS: {
      selector: '#editForm-skills',
      endpoint: '/skills/{id}',
      method: 'POST',
      headers: {
        'Content-Type': 'multipart/form-data', // İçerik tipi
        'X-HTTP-Method-Override': 'PUT',
        'X-CSRF-TOKEN': typeof document !== 'undefined'
          ? document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
          : process.env.CSRF_TOKEN // CSRF token'ının otomatik algılanması
      },
      useFormData: true,
      sweetalert2: true,
      preventRedirect: true,
      validation: true,
      validationOptions: {
        errorDisplayMode: 'inline',
        showErrors: true,
        errorClass: 'is-invalid',
        successClass: 'is-valid',
        errorColor: 'red',
      },
      getData: {
        endpoint: '/skills/{id}',
        autoFill: false,
        mapping: {
          '*': true
        }
      },
      fields: {
        name: {
          rules: ['required', 'string', 'max:255'],
          messages: {
            required: 'Yetenek adı alanı zorunludur.',
            string: 'Yetenek adı metin formatında olmalıdır.',
            max: 'Yetenek adı en fazla 255 karakter olmalıdır.',
          }
        },
        level: {
          rules: ['required', 'integer', 'min:0', 'max:100'],
          messages: {
            required: 'Seviye alanı zorunludur.',
            integer: 'Seviye sayısal bir değer olmalıdır.',
            min: 'Seviye en az 0 olmalıdır.',
            max: 'Seviye en fazla 100 olmalıdır.',
          }
        },
        color: {
          rules: ['required', 'string', 'size:7', 'starts_with:#'],
          messages: {
            required: 'Renk alanı zorunludur.',
            string: 'Renk metin formatında olmalıdır.',
            size: 'Renk kodu 7 karakter olmalıdır.',
            starts_with: 'Renk kodu # ile başlamalıdır.',
          }
        },
      },
      actions: {
        onSubmit: (formData, config) => {
          config.endpoint = config.endpoint.replace('{id}', formData.get('id'));
        },
        onSuccess: (response) => {
          disposeModal('#editModal');
          loadData();
          return true;
        },
        success: {
          message: 'Yetenek başarıyla güncellendi'
        },
        errors: {
          message: 'Yetenek güncellenirken bir hata oluştu',
        }
      }
    },
  },
  API: {
    baseURL: 'http://127.0.0.1:8000/api', // API'nin temel URL'i
    headers: {
      'Content-Type': 'multipart/form-data', // İçerik tipi
      'Accept': 'application/json', // Kabul edilen içerik tipi
      'X-CSRF-TOKEN': typeof document !== 'undefined'
        ? document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
        : process.env.CSRF_TOKEN // CSRF token'ının otomatik algılanması
    },
    timeout: 30000, // İstek zaman aşımı (ms)
    sweetalert2: true, // Sweetalert2 kullanımı
    preventRedirect: false, // Yönlendirme engelleme
    // tokenKey: 'token', // Token anahtarı (header'da token değeri), tokenName'e göre önceliklidir.
    //  tokenName: 'token', // Token adı (localStorage'da token adı, dot notation desteği bulunmaktadır örneğin data.token.tokenName. tokenKey değeri girilirse bu alan gerekli değildir.)
    // tokenName ne işe yarar? 
    // tokenName değeri girildiğinde, token değeri localStorage'da data.token.tokenName şeklinde saklanır.
    // tokenName değeri api yanıtında token ismidir. Yanıtta token ismi verilmişse bu değeri giriniz. 
    // Örnek: {"data.token": "1234567890"} şeklinde bir yanıt aldığınızda tokenName değerini "data.token" olarak giriniz.
    // tokenKey değeri girildiğinde, token değeri header'da Authorization: Bearer tokenKey değeri şeklinde saklanır.
    errors: { // Hata durumları
      // redirect: '/', // Hata durumunda yönlendirme
      message: 'Bir hata oluştu', // Hata durumunda mesaj
      401: {
        redirect: '/login',
        message: 'Yetkisiz erişim',
      },
      500: {
        message: 'Sistem hatası oluştu'
      }
    },
    success: {
      // redirect: '/', // Başarı durumunda yönlendirme
      message: 'İşlem başarılı!' // Başarı durumunda mesaj
    },
    // Yeni: Güvenlik header'ları ayarları
    security: {
      enableSecurityHeaders: true, // Güvenlik header'larını etkinleştir
      headers: {
        'X-XSS-Protection': '1; mode=block', // XSS saldırılarını engellemek için
        'Content-Security-Policy': "default-src 'self'", // CSP ayarları
        'X-Content-Type-Options': 'nosniff' // MIME türü kontrolünü engellemek için
      }
    },

    // Yeni: CSRF Token otomatik yönetimi ayarları
    csrf: {
      autoDetect: true, // CSRF token'ını otomatik olarak algılamak için
      cookieName: 'XSRF-TOKEN', // CSRF token'ının adı
      headerName: 'X-XSRF-TOKEN', // CSRF token'ının header adı
      refreshOnSubmit: true // Form gönderiminde CSRF token'ını yenilemek için
    },

    // Yeni: Rate limiting konfigürasyonu
    rateLimiting: {
      enabled: false, // Varsayılan kapalı; isteğe bağlı açılabilir
      strategy: 'token-bucket', // Alternatif: 'fixed-window'
      limits: {
        perMinute: 60, // Her dakika 60 istek
        perHour: 1000 // Her saat 1000 istek
      },
      headers: {
        show: true, // Rate limit bilgilerini header'larda göstermek için
        limit: 'X-RateLimit-Limit', // Maksimum istek sayısı
        remaining: 'X-RateLimit-Remaining', // Kalan istek sayısı
        reset: 'X-RateLimit-Reset' // Sıfırdan başlama zamanı
      }
    }
  },
  UI: {
    notifications: {
      position: 'center', // Bildirimin konumu
      timer: 2000, // Bildirimin gösterim süresi (ms)
      showConfirmButton: false,
    },
    validation: {
      showErrors: true,
      errorClass: 'is-invalid',
      successClass: 'is-valid',
      messages: {
        required: (field) => {
          const messages = {  // Mesajların tanımlanması
            email: 'Email adresi zorunludur', // Email alanı için mesaj
            password: 'Şifre zorunludur', // Şifre alanı için mesaj
            name: 'İsim alanı zorunludur', // İsim alanı için mesaj
            message: 'Mesaj alanı zorunludur', // Mesaj alanı için mesaj
            phone: 'Telefon numarası zorunludur', // Telefon numarası alanı için mesaj
          };
          return messages[field] || `${field} alanı zorunludur`;
        },
        email: 'Geçerli bir email adresi giriniz', // Email alanı için mesaj
        min: (field, value) => `${field} alanı en az ${value} karakter olmalıdır`, // Minumum karakter sayısı için mesaj
        max: (field, value) => `${field} alanı en fazla ${value} karakter olmalıdır`, // Maksimum karakter sayısı için mesaj
        pattern: 'Geçerli bir format giriniz', // Format için mesaj
      },
    },
  },
};

export default integratorConfig;
export const getFormConfig = (formKey) => integratorConfig.FORMS[formKey];
export const getApiConfig = () => integratorConfig.API;
export const getUiConfig = () => integratorConfig.UI;
export const getValidationMessage = (rule) => integratorConfig.UI.validation.messages[rule];
export const getApiErrorConfig = (status) => integratorConfig.API.errors[status];
