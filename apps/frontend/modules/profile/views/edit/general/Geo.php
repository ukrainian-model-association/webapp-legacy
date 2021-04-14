<?php

class Geo
{
    const SIMPLE_LAYOUT = 'simple_layout';

    private $layout;
    private $country = 0;
    private $city = 0;
    private $profileStatus;

    public function __construct($profileStatus)
    {
        $this->profileStatus = $profileStatus;
    }

    public static function create($context)
    {
        $profile       = $context['profile'];
        $profileStatus = $profile['status'];

        $geo = (new static($profileStatus))
            ->setCountry($profile['country'])
            ->setCity($profile['city']);

        if (isset($context['layout'])) {
            $geo->setLayout($context['layout']);
        }

        return $geo;
    }

    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @param mixed $layout
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    /**
     * @return string|void
     */
    public function render()
    {
        if (42 === $this->profileStatus) {
            return;
        }

        // $country = 0;
        // $city    = 0;

        $country = function ($country) {
            return <<<HTML
<select class="form-control w-50" name="geo[country]" data-value="{$country}">
    <option selected disabled value="0">- Страна -</option>
    {$this->renderCountryOptions()}
</select>
HTML;
        };
        $city    = static function ($city) {
            return <<<HTML
<select class="form-control w-50" name="geo[city]" data-value="{$city}">
    <option selected disabled value="0">- Город -</option>
</select>
HTML;
        };

        return <<<HTML
<div class="geo-container">
    {$this->useLayout(
            [
                'country' => $country($this->country),
                'city'    => $city($this->city),
            ]
        )}
    
</div>
{$this->provideAssets()}
HTML;
    }

    private function renderCountryOptions()
    {
        return implode(
            PHP_EOL,
            array_map(
                static function ($country) {
                    return sprintf('<option value="%s">%s</option>', $country['country_id'], $country['name']);
                },
                geo_peer::instance()->get_countries()
            )
        );
    }

    private function useLayout($components = [])
    {
        switch ($this->layout) {
            case self::SIMPLE_LAYOUT:
                return <<<HTML
<div class="form-group">{$components['country']}</div>
<div class="form-group">{$components['city']}</div>
HTML;
            default:
                return <<<HTML
<div class="card-body">
    <div class="form-group">
        <div class="col offset-2 font-weight-bold">Страна</div>
        <div class="col-7 offset-2">
            {$components['country']}
        </div>
    </div>
    <div class="form-group">
        <div class="col offset-2 font-weight-bold">Город</div>
        <div class="col-7 offset-2">
            {$components['city']}
        </div>
    </div>
</div>
HTML;

        }
    }

    private function provideAssets()
    {
        return <<<SCRIPT
<script>
    (() => {
        const container = document.querySelector('div.geo-container'),
                country = container.querySelector('select[name="geo[country]"]'),
                city = container.querySelector('select[name="geo[city]"]');

        country.addEventListener('change', ({target: {value}}) => {
            if (value > 0) {
                fetch(`/api/geo/countries/\${value}/cities`)
                        .then(r => r.json())
                        .then(provideCities);
            } else {
                provideCities([]);
            }
        });

        setValue(country, country.dataset.value);
        
        function provideCities(cities = []) {
            setOptions(city, cities);
        }
        
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
SCRIPT;
    }
}

return static function ($ctx) {
    return Geo::create($ctx)->render();
};