<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Visualizar Curiosidades - Springfield Explorer</title>
    <link rel="stylesheet" href="CSS/Curiosidades.css">
</head>

<body>
    <div id="curiosidad-container">
        <div class="curiosidad-card" id="curiosidad-card">
            <h2 id="curiosidad-title">Curiosidad</h2>
            <p id="curiosidad-text">Texto de la curiosidad.</p>
        </div>
        <div class="button-container">
            <button onclick="mostrarCuriosidadAnterior()">Anterior</button>
            <button onclick="mostrarCuriosidadSiguiente()">Siguiente</button>
        </div>
        <center>
            <button id="regresar-menu" onclick="regresarPagina()">Regresar</button>
        </center>
    </div>

    <script src="scripts/api.js"></script>
    <script src="scripts/indexedDB.js"></script>
    <script>
        let curiosidades = [];
        let curiosidadIndex = 0;

        // Cargar las curiosidades desde IndexedDB al cargar la página
        request.onsuccess = event => {
            db = event.target.result;
            cargarCuriosidadesDesdeIndexedDB();
        };

        function cargarCuriosidadesDesdeIndexedDB() {
            getAllCuriosities().then(curiosidadesFromDB => {
                if (curiosidadesFromDB.length > 0) {
                    curiosidades = curiosidadesFromDB;
                    mostrarCuriosidad(curiosidades[0]);
                } else {
                    mostrarCuriosidadVacia();
                }
            }).catch(error => {
                console.error('Error al cargar las curiosidades desde IndexedDB:', error);
            });
        }

        function mostrarCuriosidad(curiosidad) {
            document.getElementById('curiosidad-title').textContent = 'Curiosidad ' + curiosidad.id;
            document.getElementById('curiosidad-text').textContent = curiosidad.text;
            ajustarAlturaCard();
        }

        function mostrarCuriosidadVacia() {
            document.getElementById('curiosidad-title').textContent = 'No hay curiosidades';
            document.getElementById('curiosidad-text').textContent = 'Agrega curiosidades en el panel de administrador';
            ajustarAlturaCard();
        }

        function ajustarAlturaCard() {
            const curiosidadCard = document.getElementById('curiosidad-card');
            const maxHeight = window.innerHeight - curiosidadCard.offsetTop - 20; // 20px de espacio
            curiosidadCard.style.maxHeight = maxHeight + 'px';
        }

        function mostrarCuriosidadAnterior() {
            if (curiosidadIndex > 0) {
                curiosidadIndex--;
                mostrarCuriosidad(curiosidades[curiosidadIndex]);
            }
        }

        function mostrarCuriosidadSiguiente() {
            if (curiosidadIndex < curiosidades.length - 1) {
                curiosidadIndex++;
                mostrarCuriosidad(curiosidades[curiosidadIndex]);
            }
        }

        function regresarPagina() {
            window.history.back();
        }

        // Llamar a ajustarAlturaCard cuando se redimensiona la ventana
        window.addEventListener('resize', ajustarAlturaCard);
        window.addEventListener('load', ajustarAlturaCard);
    </script>
</body>

</html>
