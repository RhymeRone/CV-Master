import './bootstrap';
import 'animsition';
import 'select2';
import 'daterangepicker';
import 'countdowntime';
// En son custom JS'ler
import './pages/login/main'; 
import { APP_CONFIG } from './config/app.config';
import FormManager from './managers/FormManager';

// SweetAlert varsayılan ayarları
Swal.defaultOptions = APP_CONFIG.UI.notifications;

// Form manager'ı başlat
document.addEventListener('DOMContentLoaded', () => {
    FormManager.initialize();
});