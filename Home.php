<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Springfield Explorer</title>
    <link rel="stylesheet" href="CSS/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@600;700&display=swap" rel="stylesheet">
    <link rel="manifest" href="manifest.json">
</head>
<body>
    <section id="splash">
        <img src="Images/logo.png" alt="Splash Image">

        <div class="card-container">
            <header>
                <h2>Springfield Explorer</h2>
                <button id="loginButton" onclick="redirectToLogin()">Iniciar Sesión</button>
            </header>
            
            <main id="main">
                <button onclick="showRandomImages()">Personaje Random</button>
                <button onclick="redirectCurio()">Curiosidades</button>
            </main>
        </div>
    </section>

    <script src="scripts/api.js"></script>
    <script src="scripts/indexedDB.js"></script>
    
    <script>
        function showRandomImages() {
            window.location.href = 'Random.php';
        }

        function showRandomCharacter() {
            getRandomCuriosidad().then(curiosidad => {
                showNotification(curiosidad.texto);
            });
        }

        function showStoredCuriosidades() {
            getCuriosidades().then(curiosidades => {
                if (curiosidades.length > 0) {
                    alert('Curiosidades almacenadas:\n\n' + JSON.stringify(curiosidades, null, 2));
                } else {
                    alert('No hay curiosidades almacenadas.');
                }
            });
        }

        function showNotification(message) {
            if ('Notification' in window) {
                if (Notification.permission === 'granted') {
                    new Notification('Curiosidad de Springfield Explorer', {
                        body: message,
                        icon: 'Images/notification-icon.png'
                    });
                } else if (Notification.permission !== 'denied') {
                    Notification.requestPermission().then(permission => {
                        if (permission === 'granted') {
                            showNotification(message);
                        }
                    });
                }
            }
        }

        function redirectToLogin() {
            window.location.href = 'Login.php'; 
        }

        function redirectCurio() {
            window.location.href = 'Curiosidades.php'; 
        }

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
