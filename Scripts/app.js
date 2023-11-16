document.addEventListener('DOMContentLoaded', () => {
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('service-worker.js')
            .then((registration) => {
                console.log('Service Worker registrado con éxito:', registration);
            })
            .catch((error) => {
                console.error('Error al registrar el Service Worker:', error);
            });
    }

    setTimeout(() => {
        window.location.href = 'Home.php';
    }, 50000);

    // Verificar conexión al cargar la página
    checkConnectionStatus();

    // Agregar oyentes para eventos de conexión
    window.addEventListener('online', () => {
        showNotification('La aplicación está en línea');
    });

    window.addEventListener('offline', () => {
        showNotification('La aplicación está fuera de línea');
    });
});

function checkConnectionStatus() {
    if (navigator.onLine) {
        showNotification('La aplicación está en línea');
    } else {
        showNotification('La aplicación está fuera de línea');
    }
}

function showNotification(message) {
    if ('Notification' in window) {
        Notification.requestPermission().then(permission => {
            if (permission === 'granted') {
                new Notification('Estado de conexión', {
                    body: message,
                    icon: 'Images/logo.png'
                });
            }
        });
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const backgroundAudio = document.getElementById('backgroundAudio');
    
    if (backgroundAudio) {
        document.addEventListener('click', () => {
            backgroundAudio.play().catch(error => {
                console.error('Error al reproducir audio:', error);
            });
        }, { once: true }); 
    }
});
