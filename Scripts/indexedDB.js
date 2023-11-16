let db;
const dbName = 'SpringfieldExplorerDB';
const dbVersion = 1;

const request = indexedDB.open(dbName, dbVersion);

request.onupgradeneeded = event => {
  db = event.target.result;

  if (!db.objectStoreNames.contains('users')) {
    const usersStore = db.createObjectStore('users', { keyPath: 'username' });
    usersStore.createIndex('password', 'password', { unique: false });
    usersStore.createIndex('isAdmin', 'isAdmin', { unique: false });
    usersStore.add({ username: 'admin', password: '123', isAdmin: true });
  }

  if (!db.objectStoreNames.contains('favorites')) {
    const favoritesStore = db.createObjectStore('favorites', { keyPath: 'id', autoIncrement: true });
    favoritesStore.createIndex('title', 'title', { unique: false });
  }

  if (!db.objectStoreNames.contains('curiosities')) {
    const curiositiesStore = db.createObjectStore('curiosities', { keyPath: 'id', autoIncrement: true });
    curiositiesStore.createIndex('text', 'text', { unique: false });
  }
};

request.onsuccess = event => {
  db = event.target.result;
};

function addToUsers(user) {
  const transaction = db.transaction('users', 'readwrite');
  const store = transaction.objectStore('users');
  store.add(user);
}

function getUser(username) {
  return new Promise((resolve, reject) => {
    const transaction = db.transaction('users', 'readonly');
    const store = transaction.objectStore('users');
    const request = store.get(username);
    request.onsuccess = () => resolve(request.result);
    request.onerror = () => reject('Usuario no encontrado');
  });
}

function addToFavorites(item) {
  const transaction = db.transaction('favorites', 'readwrite');
  const store = transaction.objectStore('favorites');
  store.add(item);
}

function getAllFavorites() {
  return new Promise((resolve, reject) => {
    const transaction = db.transaction('favorites', 'readonly');
    const store = transaction.objectStore('favorites');
    const request = store.getAll();
    request.onsuccess = () => resolve(request.result);
    request.onerror = () => reject('Error al recuperar favoritos');
  });
}

function addToCuriosities(curiosity) {
  return new Promise((resolve, reject) => {
    const transaction = db.transaction('curiosities', 'readwrite');
    const store = transaction.objectStore('curiosities');
    const request = store.add(curiosity);

    request.onsuccess = () => resolve();
    request.onerror = () => reject('Error al agregar la curiosidad');
  });
}

function getAllCuriosities() {
  return new Promise((resolve, reject) => {
    const transaction = db.transaction('curiosities', 'readonly');
    const store = transaction.objectStore('curiosities');
    const request = store.getAll();
    request.onsuccess = () => resolve(request.result);
    request.onerror = () => reject('Error al recuperar curiosidades');
  });
}

function deleteCuriosityById(curiosityId) {
    return new Promise((resolve, reject) => {
        const transaction = db.transaction('curiosities', 'readwrite');
        const store = transaction.objectStore('curiosities');
        const request = store.delete(curiosityId);

        request.onsuccess = () => resolve();
        request.onerror = () => reject('Error al eliminar la curiosidad');
    });
}

function getAllCuriosities() {
  return new Promise((resolve, reject) => {
      const transaction = db.transaction('curiosities', 'readonly');
      const store = transaction.objectStore('curiosities');
      const request = store.getAll();
      request.onsuccess = () => resolve(request.result);
      request.onerror = () => reject('Error al recuperar curiosidades');
  });
}