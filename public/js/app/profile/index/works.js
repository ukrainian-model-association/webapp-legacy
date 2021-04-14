class Works {
  list;
  forms;
  modal;
  personId;
  types = new Map();
  state = {
    currentForm: null,
  };

  constructor(scope, { personId, albumTypes }) {
    const forms = new Map();
    const modal = UI.useAsModal(scope.querySelector(':scope > div.modal'), {
      onClose: this.handleModalClose,
    });
    const list = UI.useAsList(scope.querySelector('ul.list-group'), {
      onRead: this.handleRead,
      onRemove: this.handleRemove,
    });

    this.types = new Map(Object.entries(JSON.parse(albumTypes)));

    scope
      .querySelectorAll('a[data-form-name]')
      .forEach(a => a.addEventListener('click', this.handleAddClick));

    modal
      .querySelectorAll('.modal-body > form[name]')
      .forEach(scope => {
        forms.set(scope.name, UI.useAsForm(scope, {
          personId,
          onUpload: this.handleUpload,
          onSubmit: this.handleFormSubmit,
          onReset: this.handleFormReset,
        }));
      });

    modal
      .querySelector('div.modal-footer > button[type="submit"]')
      .addEventListener('click', this.handleSubmitBtnClick);

    modal
      .querySelector('div.modal-footer > button[type="button"]')
      .addEventListener('click', this.handleCancelBtnClick);

    Object.assign(this, { personId, forms, modal, list });
  }

  handleModalClose = () => {
    this.state.currentForm.reset();
  };

  handleSubmitBtnClick = () => {
    this.state.currentForm.dispatchEvent(new Event('submit', {
      bubbles: true,
      cancelable: true,
    }));
  };

  handleCancelBtnClick = () => {
    this.modal.close();
  };

  handleUpload = () => {
    this.modal.open();
  };

  useForm(name) {
    this.modal
      .querySelectorAll('form')
      .forEach(form => {
        if (form.name !== name) {
          return form.classList.add('d-none');
        }

        form.classList.remove('d-none');
      });

    return this.state.currentForm = this.forms.get(name);
  }

  handleAddClick = ({ target: { dataset: { formName: name } } }) => {
    const form = this.useForm(name);
    const imageboxBtn = form.querySelector('button.imagebox-control');

    imageboxBtn.dispatchEvent(new MouseEvent('click'));
  };

  handleRead = event => {
    const { detail: { albumId } } = event;

    api['persons/albums'](this.personId)
      .get(albumId)
      .then(data => {
        const { id, type, name, description, cover: { resourceId }, extra_data } = data;
        const form = this.useForm(type);

        const imgBox = form.querySelector('div.imagebox');
        imgBox.querySelector(':scope > input[type="hidden"]').value = resourceId;
        imgBox.querySelector(':scope > img').setAttribute('src', `/imgserve?pid=${resourceId}`);

        Object
          .keys(extra_data)
          .forEach((key) => {
            const fcName = `${type}[${key}]`;
            const fcValue = extra_data[key];
            const fc = form[fcName];

            fc && (fc.value = fcValue);
          });

        this.modal.open();
      });
  };

  handleRemove = event => {
    if (!confirm('вы действительно хотите удалить работу?')) {
      return event.preventDefault();
    }

    const { detail: { albumId } } = event;

    api['persons/albums'](this.personId)
      .remove(albumId)
      .then(r => console.log(r));
  };

  handleFormSubmit = event => {
    const { target: form } = event;
    const formData = new FormData(form);

    if (form.checkValidity() !== true) {
      return form.classList.add('was-validated');
    }

    fetch(`/sfx/persons/${this.personId}/albums?type=${form.name}`, {
      method: 'POST',
      body: formData,
    })
      .then(r => r.json())
      .then(({ id, name, type }) => this.list.add({ id, name, type: this.types.get(type) }));

    this.modal.close();
  };

  handleFormReset = event => {
    const { target: form } = event;

    form
      .classList
      .remove('was-validated');

    form
      .querySelector('div.imagebox > img')
      .removeAttribute('src');
  };
}

class UI {

  static useAsModal(scope, { onClose = e => e }) {
    $(scope).on('hide.bs.modal', onClose);

    return Object.assign(scope, { open, close });

    function open() {
      $(scope).modal('show');
    }

    function close() {
      $(scope).modal('hide');
    }
  }

  static useAsForm(scope, context) {
    const { personId, onUpload, onSubmit = e => e, onReset = e => e } = context;
    const handleSubmit = e => {
      e.preventDefault();
      return onSubmit(e);
    };

    scope.addEventListener('submit', handleSubmit, false);
    scope.addEventListener('reset', e => onReset(e), false);

    this.useAsGeoClassifier(scope);
    this.useAsImageBox(scope.querySelector('div.imagebox'), { personId, onUpload });

    return Object.assign(scope, {});
  }

  static useAsGeoClassifier(scope) {
    const handleChange = (event, target) => {
      const { target: producer, target: { value } } = event;
      const formGroup = target.closest('div.form-group');

      target.value = undefined;
      target.options.length = 0;

      if (value > 0) {
        return api.getGeoClassifier()
          .getCitiesByCountry(value)
          .then(data => {
            target.append(createOption({ text: `&mdash;` }));
            data.map(({ id: value, name: text }) => {
              target.append(createOption({ value, text }));
            });

            formGroup.classList.remove('d-none');

          });
      }

      formGroup.classList.add('d-none');
    };

    scope
      .querySelectorAll('*[data-depends-on]')
      .forEach(target => {
        const { dataset: { dependsOn: selectors } } = target;

        scope
          .querySelector(selectors)
          .addEventListener('change', e => handleChange(e, target), false);
      });

    function createOption({ selected = '', value = '', text: innerHTML }) {
      return Object.assign(document.createElement('option'), { selected, value, innerHTML });
    }
  }

  static useAsImageBox(scope, { personId, onUpload = e => e }) {
    const fileReader = new FileReader();
    const hiddenInput = scope.querySelector(':scope > input[type="hidden"]');
    const fileInput = scope.querySelector(':scope > input[type="file"]');
    const button = scope.querySelector(':scope > button.imagebox-control');
    const img = scope.querySelector(':scope > img');

    const uploadImage = (imageData) => {
      const body = new FormData(),
        options = { body, method: 'POST' };

      body.append('act', 'upload');
      body.append('key', 'image');
      body.append('uid', `${personId}`);
      body.append('image', imageData);

      return fetch(`/imgserve`, options)
        .then(r => r.text())
        .catch(console.error);
    };

    const handleLoad = ({ target: { result: imageData } }) => {
      img.src = imageData;
      onUpload();
    };

    const handleChange = ({ target: { files } }) => {
      [...files].forEach((file) => {
        uploadImage(file)
          .then(imageId => {
            hiddenInput.value = imageId;
            fileReader.readAsDataURL(file);
          });
      });
    };

    const handleClick = e => {
      e.preventDefault();
      e.stopPropagation();
      fileInput.dispatchEvent(new MouseEvent('click', { bubbles: true }));
    };

    fileReader.addEventListener('load', handleLoad);
    fileInput.addEventListener('change', handleChange, false);
    button.addEventListener('click', handleClick, false);
  }

  static useAsList(scope, { onRead = e => e, onRemove = e => e }) {
    const itemTpl = scope.querySelector('template[id="listItem"]');

    scope.addEventListener('read', e => onRead(e));
    scope.addEventListener('remove', e => onRemove(e));

    return {
      add,
      read,
      show,
      contains,
      remove,
    };

    function add(album) {
      const html = eval(`\`${itemTpl.innerHTML}\``);
      const { body: { firstChild: li } } = new DOMParser().parseFromString(html, 'text/html');
      scope.prepend(li);
    }

    function read(target) {
      const { albumId } = target.dataset;
      const detail = { target, albumId };
      const event = new CustomEvent('read', { detail, cancelable: true });

      if (!scope.dispatchEvent(event)) {

      }
    }

    function contains(li) {
      return scope.contains(li);
    }

    function remove(target) {
      const { albumId } = target.dataset;
      const detail = { target, albumId };

      if (!contains(target)) {
        throw new Error('List does not contain item');
      }

      const event = new CustomEvent('remove', { detail, cancelable: true });
      if (!scope.dispatchEvent(event)) {
        return;
      }

      scope.removeChild(target);
    }

    function show(target) {
      const { albumId, personId } = target.dataset;
      const modal = document.querySelector('div#work_preview');

      api['persons/albums'](personId)
        .get(albumId)
        .then(({cover: {resourceId}}) => {
          modal.querySelector('img').src = `/imgserve?pid=${resourceId}`
          $(modal).modal('show');
        })

    }

  }
}
