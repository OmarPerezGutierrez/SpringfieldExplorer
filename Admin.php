<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Administrador - Springfield Explorer</title>
    <link rel="stylesheet" href="CSS/admin.css">
    <link rel="manifest" href="manifest.json">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@600;700&display=swap" rel="stylesheet">
</head>
<nav id="navbar">
        <ul>
            <li id="logoutButton" onclick="logout()">Cerrar Sesión</li>
        </ul>
    </nav>
<body>
    <center>
    <section id="admin">
        <h2>Panel de Administrador</h2>

        <form id="addCuriosityForm">
            <label for="curiosityText">Nueva Curiosidad:</label>
            <textarea id="curiosityText" name="curiosityText" required></textarea>

            <button type="button" onclick="addCuriosity()">Agregar Curiosidad</button>
            <button type="button" onclick="toggleTable()">Mostrar/Ocultar Curiosidades</button>
        </form>

        <h3>Curiosidades existentes:</h3>
        <table id="curiositiesTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Texto</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="curiositiesList"></tbody>
        </table>
    </section>
</center>
    <script src="scripts/api.js"></script>
    <script src="scripts/indexedDB.js"></script>
    <script>
        async function addCuriosity() {
            const curiosityText = document.getElementById('curiosityText').value;

            if (!curiosityText.trim()) {
                alert('Por favor, ingresa una curiosidad válida.');
                return;
            }

            try {
                await addToCuriosities({ text: curiosityText });
                await displayCuriosities();
                document.getElementById('curiosityText').value = '';
            } catch (error) {
                alert('Error al agregar la curiosidad. Inténtalo de nuevo.');
            }
        }

        async function toggleTable() {
            const table = document.getElementById('curiositiesTable');

            table.style.display = table.style.display === 'none' ? 'table' : 'none';

            if (table.style.display !== 'none') {
                await displayCuriosities();
            }
        }

        function logout() {

    window.location.href = 'login.php';
}

        async function displayCuriosities() {
            const curiositiesList = document.getElementById('curiositiesList');
            curiositiesList.innerHTML = '';

            try {
                const curiosities = await getAllCuriosities();

                curiosities.forEach(curiosity => {
                    const row = document.createElement('tr');
                    const idCell = document.createElement('td');
                    idCell.textContent = curiosity.id;
                    row.appendChild(idCell);

                    const textCell = document.createElement('td');
                    textCell.textContent = curiosity.text;
                    row.appendChild(textCell);

                    const deleteButton = document.createElement('button');
                    deleteButton.textContent = 'Eliminar';
                    deleteButton.addEventListener('click', () => deleteCuriosity(curiosity.id));

                    const actionsCell = document.createElement('td');
                    actionsCell.appendChild(deleteButton);
                    row.appendChild(actionsCell);

                    curiositiesList.appendChild(row);
                });
            } catch (error) {
                console.error('Error al recuperar las curiosidades:', error);
            }
        }

        async function deleteCuriosity(curiosityId) {
            try {
                await deleteCuriosityById(curiosityId);
                await displayCuriosities();
            } catch (error) {
                alert('Error al eliminar la curiosidad. Inténtalo de nuevo.');
            }
        }

        displayCuriosities();

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
