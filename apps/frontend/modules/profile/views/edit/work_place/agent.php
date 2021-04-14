<?php

return static function ($personId) {
    $countries = implode(
        PHP_EOL,
        array_map(
            static function ($country) {
                return sprintf('<option value="%s">%s</option>', $country['country_id'], $country['name']);
            },
            geo_peer::instance()->get_countries()
        )
    );

    $wp = db::get_row(
        'SELECT * FROM agency_user au JOIN agency a on a.id = au.agency_id JOIN user_auth ua on ua.id = au.user_id WHERE au.user_id = :user_id',
        ['user_id' => $personId]
    );


    return <<<HTML
<form id="workPlace" action="/profile/edit?id={$personId}#work_place" method="post">
    <div class="card w-100">
        <div class="card-header">
            <h5 class="card-title m-0">Место работы</h5>
        </div>
        <div class="card-body">
            <div class="form-group">
                <div class="col font-weight-bold">Страна</div>
                <div class="col-7">
                    <select class="form-control w-50" id="country" data-value="{$wp['country']}">
                        <option selected disabled value="0">- Страна -</option>
                        {$countries}
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <div class="col font-weight-bold">Город</div>
                <div class="col-7">
                    <select class="form-control w-50" id="city_2" data-value="{$wp['city']}">
                        <option selected disabled value="0">- Город -</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <div class="col font-weight-bold">Агенство</div>
                <div class="col-7">
                    <select class="form-control w-50" id="agency" name="workPlace[agency_id]" data-value="{$wp['agency_id']}">
                        <option selected disabled value="0">- Агенство -</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <div class="col font-weight-bold">Должность</div>
                <div class="col-7">
                    <select class="form-control w-50" id="jobPosition" name="workPlace[job_position]" data-value="{$wp['job_position']}">
                        <option selected disabled value="0">- Должность -</option>
                        <option value="1">Директор</option>
                        <option value="2">Букер</option>
                        <option value="3">Международный букер</option>
                        <option value="4">Скаут</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="form-row align-items-baseline">
                <div class="col">
                    <button class="btn btn-dark" type="submit">
                        <span class="spinner-border spinner-border-sm text-white d-none" role="status" aria-hidden="true"></span>
                        Сохранить
                    </button>
                </div>
                <div class="col">
                    <p class="text-success m-0 p-0 d-none">Сохранено успешно</p>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
(() => {
    const form = document.forms['workPlace'],
            country = form.querySelector('select#country'),
            city = form.querySelector('select#city_2'),
            agency = form.querySelector('select#agency'),
            jobPosition = form.querySelector('select#jobPosition');

    country.addEventListener('change', ({target: {value}}) => {
        if (value > 0) {
            fetch(`/api/geo/countries/\${value}/cities`)
                    .then(r => r.json())
                    .then(provideCities);
        } else {
            provideCities([]);
        }
    });

    city.addEventListener('change', ({target: {value}}) => {
        if (value > 0) {
            const method = 'POST',
                    body = (formData => {
                        formData.append('find_by[country]', country.value);
                        formData.append('find_by[city]', value);
                        return formData;
                    })(new FormData());

            fetch(`/api/agencies`, {method, body})
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
    
    setValue(country, country.dataset.value);
    setValue(jobPosition, jobPosition.dataset.value);

    function createOption(value, text) {
        return Object.assign(document.createElement('option'), {value, text});
    }

    function setOptions(target, dataSource) {
        target.options.length = 1;
        // target.closest('div.form-row').style.display = dataSource.length > 0 ? '' : 'none';

        dataSource.forEach(({id: value, name: text}) => {
            target.append(createOption(value, text));
        });

        setValue(target, target.dataset.value || 0);
    }

    function setValue(target, value) {
        target.value = value;
        target.dispatchEvent(new Event('change'));
    }
})();
</script>
HTML;
};