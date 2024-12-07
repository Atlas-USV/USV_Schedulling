import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/fullcalendar.custom.css'
                ],
            refresh: true,
        }),
    ],
    // server: {
    //     host: '0.0.0.0', // Allow connections from the network
    //     port: 5173,      // Default Vite port (adjust if needed)
    //     hmr: {
    //         host: '192.168.0.93', // Replace with your local IP address
    //     },
    // },
});
