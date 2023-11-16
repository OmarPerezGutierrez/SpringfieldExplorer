<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi App PWA</title>
    <link rel="stylesheet" href="CSS/home.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@600;700&display=swap" rel="stylesheet">
    <link rel="manifest" href="manifest.json">
</head>
<body>
    <section id="home">
        <div class="card-container">
            <div class="video-container">
                <video id="mainVideo" width="960" height="540" controls autoplay onloadeddata="onVideoLoaded()">
                    <source src="Images/vintro.mp4" type="video/mp4">
                    Tu navegador no soporta el elemento de video.
                </video>
            </div>
            <div class="loading-message">Espere por favor, el contenido está cargando...</div>
        </div>
    </section>
    <script src="scripts/app.js"></script>
    <script>
            window.addEventListener("load", () => {
        registrarSW();
        loadBreeds(); 
    });

    async function registrarSW() {
        if ("serviceWorker" in navigator) {
            try {
                await navigator.serviceWorker.register("sw.js");
            } catch (e) {
                console.log("El SW no pudo ser registrado");
            }
        }
    }

    </script>
</body>
</html>
