(() => {

    class WorkPlaceForm {
        constructor() {
            this.target = document.querySelector('form[name="work_place"]');

            this.target.addEventListener('submit', this.handleSubmit);
        }

        handleSubmit({ target }) {
            const btn = target.querySelector('button[type="submit"]'),
                msgbox = btn.closest('div.card-footer').querySelector('p.text-success');

            btn.disabled = 'disabled';
            btn.querySelector(':scope > span').style.display = '';

            setTimeout(() => {
                btn.disabled = false;
                btn.querySelector(':scope > span').style.display = 'none';
                msgbox.classList.remove('d-none');

                setTimeout(() => {
                    msgbox.classList.add('d-none');
                }, 2000)
            }, 1000);
        }
    }

    class CountrySelect {
        constructor() {
            this.target = document.querySelector('select[name="work_place[country]"]');

            this.target.addEventListener('change', this.handleChange);
        }

        handleChange({ target: { value } }) {
            value = parseInt(value);

            if (value !== 0) {
                return $app.http('GET', `/api/journals?country=${value}`)
                    .then(data => {
                        ui.journal.setData(data);
                    });
            }

            ui.journal
                .setData([])
                .setValue(0);
        }

        setValue(value) {
            this.target.value = value;
            this.target.dispatchEvent(new CustomEvent('change', { target: { value } }));

            return this;
        }
    }

    class JournalSelect {
        constructor() {
            this.target = document.querySelector('select[name="work_place[journal]"]');

            this.target.addEventListener('change', this.handleChange);
        }

        toggleVisibility(state) {
            this.target.closest('div.form-row').style.display = state !== true ? 'none' : '';

            return this;
        }

        addOption(value, text) {
            const o = document.createElement('option');
            o.value = value;
            o.text = text;

            this.target.appendChild(o);

            return this;
        }

        setData(data) {
            this.target.options.length = 0;
            this.addOption(0, '-');
            data.forEach(({ id, name }) => {
                this.addOption(id, name);
            });

            return this;
        }

        setValue(value) {
            this.target.value = value;

            return this;
        }

        handleChange(e) {
            ui.position.setValue(0);
        }
    }

    class PositionSelect {
        constructor() {
            this.target = document.querySelector('select[name="work_place[position]"]');
        }

        setValue(value) {
            this.target.value = value;

            return this;
        }
    }

    const ui = {
        form: new WorkPlaceForm(),
        country: new CountrySelect(),
        journal: new JournalSelect(),
        position: new PositionSelect()
    };

    ui.country.setValue(0);

})();