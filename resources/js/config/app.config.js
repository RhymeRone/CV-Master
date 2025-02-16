export const APP_CONFIG = {
    FORMS: {
        LOGIN: {
            selector: '#loginForm',
            endpoint: '/api/auth/login',
            method: 'POST',
            fields: {
                email: {
                    rules: ['required', 'email'],
                },
                password: {
                    rules: ['required', 'min:6']
                }
            },
            actions: {
                success: {
                    saveToken: true,
                    redirect: '/dashboard',
                    message: 'Giriş başarılı!'
                },
                error: {
                    401: {
                        message: 'Giriş bilgileri hatalı',
                        redirect: '/login'
                    },
                    422: {
                        showValidation: true
                    }
                }
            }
        },
        REGISTER: {
            selector: '#registerForm',
            endpoint: '/api/auth/register',
            method: 'POST',
            fields: {
                name: {
                    rules: ['required']
                },
                email: {
                    rules: ['required', 'email']
                },
                password: {
                    rules: ['required', 'min:6']
                }
            },
            actions: {
                success: {
                    redirect: '/email/verify',
                    message: 'Kayıt başarılı!'
                }
            }
        }
    },

    API: {
        baseURL: '/api',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        timeout: 30000,
        errors: {
            401: {
                redirect: '/login',
                clearToken: true
            },
            500: {
                message: 'Sistem hatası oluştu'
            }
        }
    },

    ROUTES: {
        auth: {
            login: '/login',
            register: '/register',
            logout: '/logout',
            dashboard: '/dashboard'
        }
    },

    UI: {
        notifications: {
            position: 'top-end',
            timer: 3000,
            showConfirmButton: false
        },
        validation: {
            showErrors: true,
            errorClass: 'is-invalid',
            successClass: 'is-valid',
            messages: {
                required: 'Bu alan zorunludur',
                email: 'Geçerli bir email adresi giriniz',
                'min:6': 'En az 6 karakter olmalıdır'
            }
        }
    }
};

// Helper fonksiyonlar
export const getFormConfig = (formKey) => APP_CONFIG.FORMS[formKey];
export const getApiConfig = () => APP_CONFIG.API;
export const getRouteConfig = () => APP_CONFIG.ROUTES;
export const getUiConfig = () => APP_CONFIG.UI;

// Yeni helper fonksiyonlar
export const getValidationMessage = (rule) => APP_CONFIG.UI.validation.messages[rule];
export const getApiErrorConfig = (status) => APP_CONFIG.API.errors[status]; 