<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión - Springfield Explorer</title>
    <link rel="stylesheet" href="CSS/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@600;700&display=swap" rel="stylesheet">
    <link rel="manifest" href="manifest.json">
</head>
<body>
    <div class="card-container">
        <div id="splash">
            <img src="Images/logo.png" alt="Springfield Explorer Logo">
        </div>
        <form id="loginForm">
            <div class="input-container">
                <label for="username">Usuario:</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="input-container">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="button" onclick="login()">Iniciar Sesión</button>

            <button type="button" onclick="regresarAHome()">Regresar a Home</button>
        </form>
    </div>

    <script src="scripts/api.js"></script>
    <script src="scripts/indexedDB.js"></script>
    <script>
        async function login() {
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;

            try {
                const user = await getUser(username);

                if (user && user.password === password) {
                    alert('Inicio de sesión exitoso');

                    if (user.isAdmin) {
                        window.location.href = 'Admin.php';
                    } else {
                        window.location.href = 'Login.php';
                    }
                } else {
                    alert('Credenciales incorrectas. Inténtalo de nuevo.');
                }
            } catch (error) {
                alert('Error al recuperar usuario. Inténtalo de nuevo.');
            }
        }

        function regresarAHome() {
            window.location.href = 'home.php';
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
