const API_URL = 'https://thesimpsonsquoteapi.glitch.me/quotes?count=';

async function getQuotes() {
  try {
    const response = await fetch(API_URL);
    if (response.ok) {
      const data = await response.json();
      return data;
    } else {
      throw new Error('Fallo al obtener citas');
    }
  } catch (error) {
    console.error('Error:', error);
  }
}

async function getSimpsonsInfo() {
  try {
    const response = await fetch(API_URL);
    if (response.ok) {
      const data = await response.json();
      const character = data[0];

      const characterInfo = document.getElementById('characterInfo');
      characterInfo.innerHTML = `
        <img src="${character.image}" alt="${character.character}">
        <p>Nombre: ${character.character}</p>
        <p>Cita: ${character.quote}</p>
      `;

      
      showNotification(character.character, character.quote);
    } else {
      throw new Error('Fallo al obtener información del personaje');
    }
  } catch (error) {
    console.error('Error:', error);
  }
}


function showNotification(characterName, characterQuote) {
  if ('Notification' in window) {
    Notification.requestPermission().then((permission) => {
      if (permission === 'granted') {
        const notificationOptions = {
          body: `Personaje: ${characterName}\nCita: ${characterQuote}`,
          icon: 'notification-icon.png', 
        };

        new Notification('Nuevo Personaje de Los Simpsons', notificationOptions);
      }
    });
  }
}
