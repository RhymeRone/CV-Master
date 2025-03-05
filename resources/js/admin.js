import './bootstrap';

import 'jquery-sparkline';
import 'jquery.scrollbar';
import 'datatables.net-dt';

import './pages/admin/bootstrap-notify.min';
import './pages/admin/kaiadmin.min';
import './pages/admin/demo';
import './pages/admin/setting-demo';

import { disposeModal, showModal } from './utils/modals';
window.disposeModal = disposeModal;
window.showModal = showModal;

import { ApiService } from 'api-form-integrator';
window.ApiService = ApiService;


