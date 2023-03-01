if ("serviceWorker" in navigator) {
    navigator.serviceWorker.register("./guardarServiceWorker.js")
        .then( registrado => console.log("registrado " + registrado))
        .catch(error => console.log(error))
}