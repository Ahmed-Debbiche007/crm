var staticCacheName = "pwa-v" + new Date().getTime();
var filesToCache = [
    "/offline",
    "dist/css/tabler.min.css?1684106062",
    "dist/css/tabler-flags.min.css?1684106062",
    "dist/css/tabler-payments.min.css?1684106062",
    "dist/css/tabler-vendors.min.css?1684106062",
    "dist/css/demo.min.css?1684106062",
    "dist/js/datatables.net-bs5/css/dataTables.bootstrap5.min.css",
    "dist/js/filepond/filepond.css",
    "dist/js/filepond-plugin-image-preview/filepond-plugin-image-preview.css",
    "dist/js/filepond-plugin-get-file/filepond-plugin-get-file.css",
    "dist/js/toastify-js/src/toastify.css",
    "public/lib/animate/animate.min.css",
    "public/lib/owlcarousel/assets/owl.carousel.min.css",
    "public/css/bootstrap.min.css",
    "public/css/style.css",
    "dist/css/hotspot/hotspot-public.css",
    "dist/css/hotspot/style-public.css",
    "dist/libs/apexcharts/dist/apexcharts.min.js?1684106062",
    "dist/libs/jsvectormap/dist/js/jsvectormap.min.js?1684106062",
    "dist/libs/jsvectormap/dist/maps/world.js?1684106062",
    "dist/libs/jsvectormap/dist/maps/world-merc.js?1684106062",
    "dist/js/tabler.min.js?1684106062",
    "dist/js/demo.min.js?1684106062",
    "dist/js/intDark.js",
    "dist/js/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js",
    "dist/js/filepond-plugin-file-validate-type/filepond-plugin-file-validate-type.min.js",
    "dist/js/filepond-plugin-image-crop/filepond-plugin-image-crop.min.js",
    "dist/js/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js",
    "dist/js/filepond-plugin-image-filter/filepond-plugin-image-filter.min.js",
    "dist/js/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js",
    "dist/js/filepond-plugin-image-resize/filepond-plugin-image-resize.min.js",
    "dist/js/filepond-plugin-get-file/filepond-plugin-get-file.js",
    "dist/js/filepond/filepond.js",
    "dist/js/toastify-js/src/toastify.js",
    "public/lib/wow/wow.min.js",
    "public/lib/easing/easing.min.js",
    "public/lib/waypoints/waypoints.min.js",
    "public/lib/owlcarousel/owl.carousel.min.js",
    "/images/icons/icon-72x72.png",
    "/images/icons/icon-96x96.png",
    "/images/icons/icon-128x128.png",
    "/images/icons/icon-144x144.png",
    "/images/icons/icon-152x152.png",
    "/images/icons/icon-192x192.png",
    "/images/icons/icon-384x384.png",
    "/images/icons/icon-512x512.png",
];

// Cache on install
self.addEventListener("install", (event) => {
    this.skipWaiting();
    event.waitUntil(
        caches.open(staticCacheName).then((cache) => {
            return cache.addAll(filesToCache);
        })
    );
});

// Clear cache on activate
self.addEventListener("activate", (event) => {
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames
                    .filter((cacheName) => cacheName.startsWith("pwa-"))
                    .filter((cacheName) => cacheName !== staticCacheName)
                    .map((cacheName) => caches.delete(cacheName))
            );
        })
    );
});

// Serve from Cache
self.addEventListener("fetch", (event) => {
    event.respondWith(
        caches
            .match(event.request)
            .then((response) => {
                return response || fetch(event.request);
            })
            .catch(() => {
                return caches.match("offline");
            })
    );
});
