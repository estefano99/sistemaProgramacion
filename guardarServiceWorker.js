const nombreCache = "ronnie-v2";
const archivos = [
    "index.php",
    "./inicio/inicio.php",
    "template/cabecera.php",
    "template/footer.php",
    "index.css",
    "index.js",
    "./ventas/ventas.php",
]


self.addEventListener("install", e => {
    
    // e.waitUntil(
    //     caches.open(nombreCache)
    //         .then( cache => {
    //             console.log("cacheando")
    //             cache.addAll(archivos)
    //         })
    // )
})

self.addEventListener("activate", e => {

    // e.waitUntil(
    //     caches.keys()
    //         .then( keys => {
    //             return Promise.all(
    //                 keys.filter( keys => keys !== nombreCache)
    //                 .map( key => caches.delete(key))
    //             )
    //         })
    // )
})

self.addEventListener("fetch", e => {

    // e.respondWith(
    //     caches.match(e.request)
    //         .then( respuestaCache => {
    //             return respuestaCache
    //         })
    // )
})