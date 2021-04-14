<?php

use App\Bootstrap\Components\FormControl;

?>

<div class="pt-3 pb-5 w-75 text-justify text-muted" style="margin: 0 auto">
    <div class="section-container">
        <section>
            <h3 class="text-center">Найди новую Топ Модель</h3>

            <p class="mt-3">Ассоциация моделей Украины в рамках проекта «Найди новую Топ Модель»
                объявляет
                конкурсный отбор девушек (как действующих моделей, так и желающих стать моделью) с выплатой
                вознаграждения
                до 25
                000 грн. тем, кто найдёт девушку желающую стать успешной моделью.</p>

            <p>Для участия в проекте девушка должна соответствовать критериям модельной внешности:
                красивое лицо, рост от 172 см, бедра до 90 см, от 14 до 24 лет (с параметрами модельной внешности можно
                ознакомиться по <a href="https://models.org.ua/page?link=parameters" class="btn-link p-0">ссылке</a>)
            </p>

            <form class="mt-3" method="post" name="enrollTopModel" enctype="multipart/form-data" novalidate>
                <div class="card text-justify" id="cardContainer">

                    <div class="card-body pt-3 pb-0">

                        <h6 class="card-title mb-3">Информация о лице, заполняющем анкету</h6>

                        <div class="form-group input-group">
                            <div class="input-group-prepend">
                        <span class="input-group-text" id="enrollTopModel[scout][fullName]">
                            <i class="fas fa-user"></i>
                        </span>
                            </div>
                            <?= FormControl::create('enrollTopModel[scout][fullName]', 'Имя, фамилия')->setRequired(true) ?>
                            <div class="invalid-feedback">Это поле обязательно для заполнения</div>
                        </div>

                        <div class="form-group input-group">
                            <div class="input-group-prepend">
                        <span class="input-group-text" id="enrollTopModel[scout][email]">
                            <i class="fas fa-at"></i>
                        </span>
                            </div>
                            <?= FormControl::create('enrollTopModel[scout][email]', 'E-mail', FormControl::TYPE_EMAIL) ?>
                            <div class="invalid-feedback">Введите валидный E-mail.</div>
                        </div>

                        <div class="form-group input-group">
                            <div class="input-group-prepend">
                        <span class="input-group-text" id="enrollTopModel[scout][phone]">
                            <i class="fas fa-phone-alt"></i>
                        </span>
                            </div>
                            <?= FormControl::create('enrollTopModel[scout][phone]', 'Телефон', FormControl::TYPE_TEL)->setRequired(true) ?>
                            <div class="invalid-feedback">Это поле обязательно для заполнения</div>
                        </div>

                    </div>

                    <div class="card-body py-0">

                        <h6 class="card-title mb-3">Информация о модели</h6>

                        <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-user"></i>
                        </span>
                            </div>
                            <?= FormControl::create('enrollTopModel[model][firstName]', 'Имя')->setRequired(true) ?>
                            <?= FormControl::create('enrollTopModel[model][lastName]', 'Фамилия') ?>
                            <div class="invalid-feedback">Это поле обязательно для заполнения</div>
                        </div>

                        <div class="form-group">
                            <?= FormControl::create('enrollTopModel[model][age]', 'Возраст') ?>
                        </div>

                        <div class="form-group">
                            <?= FormControl::create('enrollTopModel[model][residencePlace]', 'Место проживания') ?>
                        </div>

                    </div>

                    <div class="card-body py-0">

                        <h6 class="card-title mb-3">Параметры модели</h6>

                        <div class="form-group">
                            <?= FormControl::create('enrollTopModel[model][height]', 'Рост')->setRequired(true) ?>
                            <div class="invalid-feedback">Это поле обязательно для заполнения</div>
                        </div>

                        <div class="form-group">
                            <?= FormControl::create('enrollTopModel[model][weight]', 'Вес') ?>
                        </div>

                        <div class="form-group input-group">
                            <?= FormControl::create('enrollTopModel[model][chest]', 'Грудь') ?>
                            <?= FormControl::create('enrollTopModel[model][waist]', 'Талия') ?>
                            <?= FormControl::create('enrollTopModel[model][hips]', 'Бедра') ?>
                        </div>

                    </div>

                    <div class="card-body py-0">

                        <div class="form-group input-group">
                            <div class="input-group-prepend">
                        <span class="input-group-text" id="model-instagram">
                            <i class="fab fa-instagram font-weight-bold"></i>
                        </span>
                            </div>
                            <input type="text" class="form-control" placeholder="Instagram" aria-label="Instagram"
                                   aria-describedby="model-instagram">
                        </div>

                        <div class="form-group input-group">
                            <div class="input-group-prepend">
                        <span class="input-group-text" id="model-facebook">
                            <i class="fab fa-facebook font-weight-bold"></i>
                        </span>
                            </div>
                            <input type="text" class="form-control" placeholder="Facebook" aria-label="Facebook"
                                   aria-describedby="model-facebook">
                        </div>
                    </div>

                    <div class="card-body py-0">

                        <h6 class="card-title mb-3">Фото модели</h6>

                        <div class="card-group">
                            <?php $labels = ['Портрет', 'Полный рост', 'Произвольный'] ?>
                            <?php for ($i = 0; $i < 3; $i++) { ?>
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-title text-center m-0"><?= $labels[$i] ?></div>
                                    </div>
                                    <img class="card-img-top d-none" alt="<?= $labels[$i] ?>"/>
                                    <div class="card-body">
                                        <input type="file" class="d-none" name="photos[]"
                                               accept="image/png, image/jpeg"/>
                                        <button type="button" class="btn btn-light w-100"
                                                onclick="ImageUploader.makeChoose(this)">
                                            <i class="fas fa-plus mr-1"></i> Загрузить
                                        </button>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>

                    </div>

                    <div class="card-footer mt-3 p-3 text-center">
                        <button type="submit" class="btn btn-dark">Отправить</button>
                    </div>

                </div>
            </form>
        </section>
        <section class="d-none">
            <h3 class="mb-3 text-center">Спасибо!</h3>
            <div class="card">
                <div class="card-body">
                    <p class="mb-3">Вашу заявку расмотрят наши специалисты. Если девушка, которую вы предложили, имеет
                        потенциал стать моделью, мы с вами свяжемся</p>
                    <p class="mb-0">Приз в 25 000 грн. получит тот, кто пришлет нам информацию о девушке, которая имеет
                        шанс
                        стать топ-моделью, то есть которую возьмут на контракт в Нью-Йорк или Лондон. Призы от 3 000 до
                        15
                        000 грн. получат те, кто порекомендует нам девушку, которую возьмут на контракт в страны Европы
                        и
                        Азии. Размер вознаграждения будет зависеть от потенциала модели (возраст, параметры, образ).</p>
                </div>
            </div>
        </section>
    </div>
</div>

<script>
    (function () {
        'use strict';
        window.addEventListener('load', function () {
            const forms = document.querySelectorAll('form[name="enrollTopModel"]');
            const validation = Array.prototype.filter.call(forms, function (form) {
                form.addEventListener('submit', event => {
                    event.preventDefault();
                    event.stopPropagation();

                    form.classList.add('was-validated');

                    if (form.checkValidity() === true) {
                        sectionSwitcher.setSection(2);
                    }
                }, false);
            });
        }, false);
    })();
</script>

<script>
    const ImageUploader = (() => {
        document.querySelectorAll('input[type=file]').forEach(target => {
            const container = target.closest('div.card');

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
            const container = target.closest('div.card');

            container
                .querySelector('input[type=file]')
                .click();
        }

        function upload({target: {files}}) {
            const {button, thumbnail} = this;
            const reader = new FileReader();

            reader.onload = function () {
                thumbnail.src = reader.result;
                thumbnail.classList.remove('d-none');
                button.classList.add('d-none');
            };

            reader.readAsDataURL(files[0]);
        }
    })();
</script>

<script>
    const sectionSwitcher = (function () {
        const container = document.querySelector('div.section-container'),
            sections = container.querySelectorAll(':scope > section');

        return {
            setSection,
        }

        function setSection(index) {
            const target = container.querySelector(':scope > section:nth-child(' + index + ')');

            sections.forEach(section => section.classList.add('d-none'));
            target.classList.remove('d-none');
        }
    })();
</script>

<?php if (session::get_user_id() === 4) { ?>
    <script>
        (function () {
            const form = document.querySelector('form[name="enrollTopModel"]');

            form.querySelector('input[name="enrollTopModel[scout][fullName]"]').value = 'Артем';
            form.querySelector('input[name="enrollTopModel[scout][phone]"]').value = '+3806712345678';
            form.querySelector('input[name="enrollTopModel[model][firstName]"]').value = 'Артем';
            form.querySelector('input[name="enrollTopModel[model][height]').value = '185';
        })();
    </script>
<?php } ?>
