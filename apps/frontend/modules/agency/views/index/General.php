<?php

namespace Agency\Profile;

class General
{
    private $agency;
    private $access;

    public static function create()
    {
        return new static();
    }

    public function setAgency($agency)
    {
        $this->agency = $agency;

        return $this;
    }

    public function __invoke()
    {
        return $this->render();
    }

    public function render()
    {
        return <<<HTML
<div class="row m-0">
    <div class="col p-0">
        <div class="h3 m-0 p-0 font-weight-bold">{$this->agency['name']}</div>
        <div>модельное агентство</div>

        <!-- START LOCATION -->
        <div class="mt-1">
            {$this->getLocation()}
        </div>
        <!-- END LOCATION -->
    </div>
    <div class="col-3 p-0 text-right">
        <div class="position-relative" data-container="agency-logo">
            <button type="button" class="img-upload btn bg-transparent position-absolute w-100 h-100" onclick="ImageUploader.makeChoose(this)">
                <i class="fas fa-plus"></i></button>
            <img class="card-img-top" src="/public/img/no_image.png" alt="..."/>
            <input type="file" class="d-none" name="photos[]" accept="image/png, image/jpeg"/>
        </div>
    </div>
</div>
<script>
    const ImageUploader = (() => {
        document.querySelectorAll('input[type=file]').forEach(target => {
            const container = target.closest('div[data-container="agency-logo"]');

            target.addEventListener('change', upload.bind({
                button: container.querySelector('button'),
                thumbnail: container.querySelector('img.card-img-top'),
            }), false);
        });

        return {
            makeChoose,
            upload,
        };

        function makeChoose(target) {
            const container = target.closest('div[data-container="agency-logo"]');

            container
                    .querySelector('input[type=file]')
                    .click();
        }

        function upload({target: {files}}) {
            const {button, thumbnail} = this;
            const reader = new FileReader();

            reader.onload = function () {
                thumbnail.src = reader.result;
                // thumbnail.classList.remove('d-none');
                // button.classList.add('d-none');
            };
            
            const fd = new FormData();
            fd.append('file', files[0])
            fetch('/agency/upload_logo', {method: "POST", body: fd});

            reader.readAsDataURL(files[0]);
        }
    })();
</script>
<style>
    button.img-upload {
        opacity: 0;
        transition: opacity .5s;
    }
    
    button.img-upload:hover {
        opacity: 1;
    }
</style>
HTML;
    }

    private function getLocation()
    {
        ob_start();
        $agency = $this->agency;
        $access = $this->access;

        include __DIR__.'/location.php';

        return ob_get_clean();
    }

    public function setAccess($access)
    {
        $this->access = $access;

        return $this;
    }
}