import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/admin.css',
                'resources/js/admin.js'
            ],
            refresh: true,
        }),
    ],
    publicDir: 'public',
    resolve: {
        alias: {
            '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
            "~font-awesome": path.resolve(__dirname, 'node_modules/font-awesome'),
            "~daterangepicker": path.resolve(__dirname, 'node_modules/daterangepicker'),
            "~animate.css": path.resolve(__dirname, 'node_modules/animate.css'),
            '~select2': path.resolve(__dirname, 'node_modules/select2'),
            '~animsition': path.resolve(__dirname, 'node_modules/animsition'),
            '~countdowntime': path.resolve(__dirname, 'node_modules/countdowntime'),
            '~sweetalert2': path.resolve(__dirname, 'node_modules/sweetalert2'),
            'jquery': 'jquery',
            '$': 'jquery',
        }
    },


});
