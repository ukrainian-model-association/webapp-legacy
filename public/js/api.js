const api = (() => {
  const onFulfilled = response => response.json();
  const onRejected = reason => console.error(reason);

  return {
    getGeoClassifier() {
      return {
        getCitiesByCountry,
      };

      function getCitiesByCountry(value) {
        return fetch(`/api/geo/countries/${value}/cities`)
          .then(onFulfilled)
          .catch(onRejected);
      }
    },
    'persons/albums': personId => {
      return {
        all,
        get,
        create,
        update,
        remove,
      };

      function all() {
        return fetch(`/sfx/persons/${personId}/albums`, { method: 'GET' })
          .then(onFulfilled)
          .catch(onRejected);
      }

      function get(albumId) {
        return fetch(`/sfx/persons/${personId}/albums/${albumId}`, { method: 'GET' })
          .then(onFulfilled)
          .catch(onRejected);
      }

      function create() {
        return fetch(`/sfx/persons/${personId}/albums`, { method: 'POST' })
          .then(onFulfilled)
          .catch(onRejected);
      }

      function update(albumId) {
        return fetch(`/sfx/persons/${personId}/albums/${albumId}`, { method: 'PUT' })
          .then(onFulfilled)
          .catch(onRejected);
      }

      function remove(albumId) {
        return fetch(`/sfx/persons/${personId}/albums/${albumId}`, { method: 'DELETE' })
          .then(onFulfilled)
          .catch(onRejected);
      }
    },
  };
})();
