const profile = {
    foreignWorks: ((wrapper) => {
        if (!wrapper) return;

        const form = document.forms['foreign_works'],
            country = form.querySelector('select#country'),
            city = form.querySelector('select#city'),
            agency = form.querySelector('select#company_name'),
            submitBtn = form.querySelector('button[type="submit"]');

        const { profileId } = wrapper.dataset;

        const api = (() => {
            return {
                createForeignWork,
                readForeignWork,
                deleteForeignWork,
                updateForeignWork,
            };

            function readForeignWork(id) {
                return fetch(`/api/profiles/${profileId}/foreign-works/${id}`, { method: 'GET' })
                    .then(response => response.json())
                    .catch(console.error);
            }

            function createForeignWork(body) {
                return fetch(`/api/profiles/${profileId}/foreign-works`, { method: 'POST', body })
                    .then(response => response.json())
                    .catch(console.error);
            }

            function deleteForeignWork(id) {
                return fetch(`/api/profiles/${profileId}/foreign-works/${id}`, { method: 'DELETE' })
                    .then(response => response.json())
                    .catch(console.error);
            }

            function updateForeignWork(id, body) {
                return fetch(`/api/profiles/${profileId}/foreign-works/${id}`, { method: 'PUT', body })
                    .then(response => response.json())
                    .catch(console.error);
            }
        })();

        form.addEventListener('submit', handleSubmit);

        country.addEventListener('change', ({ target: { value }, ...rest }) => {
            if (value > 0) {
                fetch(`/api/geo/countries/${value}/cities`)
                    .then(r => r.json())
                    .then(provideCities);
            } else {
                provideCities([]);
            }
        });

        city.addEventListener('change', ({ target: { value }, ...rest }) => {
            console.log(rest);
            if (value > 0) {
                const method = 'POST',
                    body = (formData => {
                        formData.append('find_by[country]', country.value);
                        formData.append('find_by[city]', value);
                        return formData;
                    })(new FormData());

                fetch(`/api/agencies`, { method, body })
                    .then(r => r.json())
                    .then(provideAgencies);
            } else {
                provideAgencies([]);
            }
        });

        const provideCities = (cities = []) => {
            setOptions(city, cities);
        };

        const provideAgencies = (agencies = []) => {
            setOptions(agency, agencies);
        };

        function createOption(value, text) {
            return Object.assign(document.createElement('option'), { value, text });
        }

        function setOptions(target, dataSource) {
            target.options.length = 1;
            target.closest('div.form-group').style.display = dataSource.length > 0 ? '' : 'none';

            dataSource.forEach(({ id: value, name: text }) => {
                target.append(createOption(value, text));
            });

            setValue(target, 0);
        }

        function setValue(target, value) {
            target.value = value;
            target.dispatchEvent(new Event('change'));
        }

        return {
            modal: initModal('div#window-foreign_work'),
            createForeignWork,
            editForeignWork,
            deleteForeignWork,
            submitForm: handleSubmit,
        };

        function initModal(selector) {
            const modal = wrapper.querySelector(selector);

            return {
                open({
                         id = 0,
                         country = 0,
                         city = 0,
                         agency_id: agency,
                         work_description: description = '',
                     }) {
                    form.id.value = id;
                    form.dataset = {
                        city,
                        agency,
                    };
                    form.country.value = country;
                    form.country.dispatchEvent(new Event('change'));
                    form.description.value = description;

                    modal.classList.remove('d-none');
                },
                close() {
                    modal.classList.add('d-none');
                },
            };
        }

        function createForeignWork() {
            profile.foreignWorks.modal.open({});
        }

        function editForeignWork(id) {
            api
                .readForeignWork(id)
                .then(({ country, city, agency_id }) => {
                    profile.foreignWorks.modal.open({
                        country, city, agency_id,
                    });
                });
        }

        async function handleSubmit(event) {
            event.preventDefault();
            api.createForeignWork(new FormData(form));
            window.location.reload();
        }

        async function deleteForeignWork(id, a) {
            console.log(a);
            if (confirm('Вы действительно хотите удалить?')) {
                const response = await fetch(`/api/profiles/${profileId}/foreign-works/${id}`, { method: 'DELETE' });
                const body = await response.json();
                console.log(a.closest('li.list-group-item').remove());
            }
        }

    })(document.querySelector('section#foreignWorks')),
};
