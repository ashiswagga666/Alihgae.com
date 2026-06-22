
const CACHE_NAME = 'alihgae-v1';

const urlsToCache = [
    '/',
    '/lowongan',
    '/perusahaan',
    '/images/logo3.png',
];

// Install: simpan ke cache
self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME).then(cache => cache.addAll(urlsToCache))
    );
});

// Fetch: pakai cache kalau offline
self.addEventListener('fetch', event => {
    event.respondWith(
        caches.match(event.request).then(response => {
            return response || fetch(event.request);
        }).catch(() => {
            return caches.match('/');
        })
    );
});

// Activate: hapus cache lama
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(keys =>
            Promise.all(keys.filter(k => k !== CACHE_NAME).map(k => caches.delete(k)))
        )
    );
});