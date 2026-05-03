/**
 * GIVIA Gift Shop - Bootstrap JavaScript
 * This loads the core dependencies for the application
 */

// Load Lodash
import _ from 'lodash';
window._ = _;

// Load Axios for HTTP requests
import axios from 'axios';
window.axios = axios;

// Set default header for CSRF protection
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Get CSRF token from meta tag
let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

// Simple notification function for GIVIA
window.showNotification = function(message, type = 'success') {
    alert(message); // You can replace this with a nicer notification later
};

console.log('GIVIA Gift Shop - Bootstrap loaded successfully!');