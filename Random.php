<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Personajes Random - Springfield Explorer</title>
    <link rel="stylesheet" href="CSS/random.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@600;700&display=swap" rel="stylesheet">
    <link rel="manifest" href="manifest.json">
</head>
<body>

    <div class="card-container">
        <div class="random-characters-container">
            <h1>Personajes Random</h1>
            <button onclick="getAndShowSimpsonsInfo()">Mostrar Personaje</button>
            
            <div id="characterInfo"></div>

            <button onclick="goToHomePage()">Regresar a la Página Principal</button>
        </div>
    </div>

    <script src="scripts/api.js"></script>
    <script>
        async function getAndShowSimpsonsInfo() {
            try {
                const characters = await getSimpsonsInfo();
                const randomCharacter = getRandomCharacter(characters);
                showCharacterInfo(randomCharacter);
                showNotificationOrOffline(randomCharacter.character, randomCharacter.quote);
            } catch (error) {
                console.error('Error obteniendo personaje:', error);
            }
        }

        function getRandomCharacter(characters) {
            const randomIndex = Math.floor(Math.random() * characters.length);
            return characters[randomIndex];
        }

        function showCharacterInfo(character) {
            const characterInfoContainer = document.getElementById('characterInfo');
            characterInfoContainer.innerHTML = `
                <img src="${character.image}" alt="Random Character">
                <p>Nombre: ${character.character}</p>
                <p>Cita: ${character.quote}</p>
            `;
        }

        function goToHomePage() {
            window.location.href = 'Home.php';
        }

        function showNotificationOrOffline(character, quote) {
            if (navigator.onLine) {
                showNotification(character, quote);
            } else {
                showOfflineNotification();
            }
        }

        function showNotification(character, quote) {
            if ('Notification' in window) {
                Notification.requestPermission().then(permission => {
                    if (permission === 'granted') {
                        new Notification('Nuevo personaje', {
                            body: `Personaje: ${character}\nCita: ${quote}`,
                            icon: 'Images/logo.png'
                        });
                    }
                });
            }
        }

        function showOfflineNotification() {
            if ('Notification' in window) {
                Notification.requestPermission().then(permission => {
                    if (permission === 'granted') {
                        new Notification('Sin conexión a Internet', {
                            body: 'No hay conexión a Internet. No se puede mostrar la notificación normal.',
                            icon: 'Images/logo.png'
                        });
                    }
                });
            }
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
