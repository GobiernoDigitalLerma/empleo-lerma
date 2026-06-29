import axios from 'axios';

// Cliente HTTP global para futuras llamadas AJAX protegidas por Laravel.
window.axios = axios;

// Encabezado estándar para que Laravel identifique peticiones XMLHttpRequest.
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
