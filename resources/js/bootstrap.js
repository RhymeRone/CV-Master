import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import jQuery from 'jquery';
window.$ = window.jQuery = jQuery;


import moment from 'moment';
window.moment = moment;

import * as bootstrapModule from 'bootstrap/dist/js/bootstrap.bundle.min';
window.bootstrap = bootstrapModule;

import Swal from 'sweetalert2';
window.Swal = Swal;


import ApiFormIntegrator from 'api-form-integrator';
// Örneğin, resources/js/app.js içinden:
import integratorConfig from './config/integrator.config';

// SweetAlert varsayılan ayarları (opsiyonel)
Swal.defaultOptions = integratorConfig.UI.notifications;

document.addEventListener('DOMContentLoaded', () => {
    const integrator = new ApiFormIntegrator(integratorConfig);
    integrator.initialize();
    window.integrator = integrator;
    window.apiService = new ApiFormIntegrator.ApiService({
      baseUrl: 'http://127.0.0.1:8000/api'
    });
    
  });
