<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* widget/agency_reviews_widget.twig */
class __TwigTemplate_acc7e709ff8fbc7f9279b0962c526b29aed7a9f4c1a27951ecdc2ed6288292d9 extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 1
        echo "<script src=\"/public/js/app/agency/reviews.js\"></script>
<script>
  document.addEventListener('DOMContentLoaded', ({ target }) => {
    const section = target.querySelector('section[id=\"agency_reviews\"]');
    const modal = section.querySelector('div[id=\"agency_review_modal\"].modal');

    section.querySelector('a[id=\"add_review\"]').addEventListener('click', e => {
      \$(modal).modal('show');
      modal.querySelector('form').reset();
    });
  });
</script>

<section id=\"agency_reviews\">
    <div class=\"d-flex flex-column px-0 mt-4\">
        <div class=\"d-flex flex-row\">
            <a class=\"square flex-grow-1\" data-toggle=\"button\" href=\"javascript:void 0\">Отзывы</a>
            <div class=\"btn-group\">
                <a class=\"btn btn-sm btn-light border-0\" role=\"button\" id=\"add_review\">
                    <i class=\"fas fa-plus-circle\"></i>
                </a>
            </div>
        </div>
        <hr>
        <div>
            <div id=\"empty_list_alert\"
                 class=\"alert alert-dark m-0 border-0 rounded-0 fs12 text-center text-muted\"
                 role=\"alert\">Тут еще ничего нет
            </div>
        </div>
    </div>

    <div class=\"modal fade\" id=\"agency_review_modal\" data-backdrop=\"false\" data-keyboard=\"false\" tabindex=\"-1\"
         role=\"dialog\" aria-hidden=\"true\">
        <div class=\"modal-dialog modal-dialog-centered\" style=\"max-width: 42em\">
            <div class=\"modal-content shadow rounded\">
                <div class=\"modal-header\">
                    <h6 class=\"modal-title text-uppercase\">Оставить отзыв</h6>
                    <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                        <span aria-hidden=\"true\">&times;</span>
                    </button>
                </div>
                <div class=\"modal-body\">
                    <form method=\"post\" novalidate>
                        <div class=\"form-group\">
                            <h6>Финансовая выгода</h6>
                            <div class=\"text-center mt-3\">
                                <div class=\"form-check form-check-inline\">
                                    <input class=\"form-check-input\" type=\"radio\" name=\"inlineRadioOptions1\"
                                           id=\"inlineRadio1_1\" value=\"1\">
                                    <label class=\"form-check-label\" for=\"inlineRadio1_1\">1</label>
                                </div>
                                <div class=\"form-check form-check-inline\">
                                    <input class=\"form-check-input\" type=\"radio\" name=\"inlineRadioOptions1\"
                                           id=\"inlineRadio1_2\" value=\"2\">
                                    <label class=\"form-check-label\" for=\"inlineRadio1_2\">2</label>
                                </div>
                                <div class=\"form-check form-check-inline\">
                                    <input class=\"form-check-input\" type=\"radio\" name=\"inlineRadioOptions1\"
                                           id=\"inlineRadio1_3\" value=\"3\">
                                    <label class=\"form-check-label\" for=\"inlineRadio1_3\">3</label>
                                </div>
                                <div class=\"form-check form-check-inline\">
                                    <input class=\"form-check-input\" type=\"radio\" name=\"inlineRadioOptions1\"
                                           id=\"inlineRadio1_4\" value=\"4\">
                                    <label class=\"form-check-label\" for=\"inlineRadio1_4\">4</label>
                                </div>
                                <div class=\"form-check form-check-inline\">
                                    <input class=\"form-check-input\" type=\"radio\" name=\"inlineRadioOptions1\"
                                           id=\"inlineRadio1_5\" value=\"5\">
                                    <label class=\"form-check-label\" for=\"inlineRadio1_5\">5</label>
                                </div>
                            </div>
                            <div class=\"row mb-3 justify-content-center text-center\">
                                <div class=\"col-2\">Плохо</div>
                                <div class=\"col-3\">Среднее</div>
                                <div class=\"col-2\">Отлично</div>
                            </div>
                            <label for=\"exampleFormControlTextarea1\">
                                <span class=\"font-weight-bold\">Комментарий</span> (Вышли ли Вы с минуса, довольны ли Вы
                                количеством, качеством и стоимостью сделанных работ, сколько % от гонораров оставляло
                                себе агенство, сумма покетов, предоставляли ли Вам машину с водителем и т.д.)</label>
                            <textarea class=\"form-control\" id=\"exampleFormControlTextarea1\" rows=\"3\"></textarea>
                        </div>

                        <div class=\"form-group\">
                            <h6>Работа персонала агентства</h6>
                            <div class=\"text-center mt-3\">
                                <div class=\"form-check form-check-inline\">
                                    <input class=\"form-check-input\" type=\"radio\" name=\"inlineRadioOptions2\"
                                           id=\"inlineRadio2_1\" value=\"1\">
                                    <label class=\"form-check-label\" for=\"inlineRadio2_1\">1</label>
                                </div>
                                <div class=\"form-check form-check-inline\">
                                    <input class=\"form-check-input\" type=\"radio\" name=\"inlineRadioOptions2\"
                                           id=\"inlineRadio2_2\" value=\"2\">
                                    <label class=\"form-check-label\" for=\"inlineRadio2_2\">2</label>
                                </div>
                                <div class=\"form-check form-check-inline\">
                                    <input class=\"form-check-input\" type=\"radio\" name=\"inlineRadioOptions2\"
                                           id=\"inlineRadio2_3\" value=\"3\">
                                    <label class=\"form-check-label\" for=\"inlineRadio2_3\">3</label>
                                </div>
                                <div class=\"form-check form-check-inline\">
                                    <input class=\"form-check-input\" type=\"radio\" name=\"inlineRadioOptions2\"
                                           id=\"inlineRadio2_4\" value=\"4\">
                                    <label class=\"form-check-label\" for=\"inlineRadio2_4\">4</label>
                                </div>
                                <div class=\"form-check form-check-inline\">
                                    <input class=\"form-check-input\" type=\"radio\" name=\"inlineRadioOptions2\"
                                           id=\"inlineRadio2_5\" value=\"5\">
                                    <label class=\"form-check-label\" for=\"inlineRadio2_5\">5</label>
                                </div>
                            </div>
                            <div class=\"row mb-3 justify-content-center text-center\">
                                <div class=\"col-2\">Плохо</div>
                                <div class=\"col-3\">Среднее</div>
                                <div class=\"col-2\">Отлично</div>
                            </div>
                            <label for=\"exampleFormControlTextarea2\">
                                <span class=\"font-weight-bold\">Комментарий</span> (Общее отношение к модели, готовность
                                помочь, скорость обратной связи и т.д.)</label>
                            <textarea class=\"form-control\" id=\"exampleFormControlTextarea2\" rows=\"3\"></textarea>
                        </div>

                        <div class=\"form-group\">
                            <h6>Комфортность апартаментов</h6>
                            <div class=\"text-center mt-3\">
                                <div class=\"form-check form-check-inline\">
                                    <input class=\"form-check-input\" type=\"radio\" name=\"inlineRadioOptions3\"
                                           id=\"inlineRadio3_1\" value=\"1\">
                                    <label class=\"form-check-label\" for=\"inlineRadio3_1\">1</label>
                                </div>
                                <div class=\"form-check form-check-inline\">
                                    <input class=\"form-check-input\" type=\"radio\" name=\"inlineRadioOptions3\"
                                           id=\"inlineRadio3_2\" value=\"2\">
                                    <label class=\"form-check-label\" for=\"inlineRadio3_2\">2</label>
                                </div>
                                <div class=\"form-check form-check-inline\">
                                    <input class=\"form-check-input\" type=\"radio\" name=\"inlineRadioOptions3\"
                                           id=\"inlineRadio3_3\" value=\"3\">
                                    <label class=\"form-check-label\" for=\"inlineRadio3_3\">3</label>
                                </div>
                                <div class=\"form-check form-check-inline\">
                                    <input class=\"form-check-input\" type=\"radio\" name=\"inlineRadioOptions3\"
                                           id=\"inlineRadio3_4\" value=\"4\">
                                    <label class=\"form-check-label\" for=\"inlineRadio3_4\">4</label>
                                </div>
                                <div class=\"form-check form-check-inline\">
                                    <input class=\"form-check-input\" type=\"radio\" name=\"inlineRadioOptions3\"
                                           id=\"inlineRadio3_5\" value=\"5\">
                                    <label class=\"form-check-label\" for=\"inlineRadio3_5\">5</label>
                                </div>
                            </div>
                            <div class=\"row mb-3 justify-content-center text-center\">
                                <div class=\"col-2\">Плохо</div>
                                <div class=\"col-3\">Среднее</div>
                                <div class=\"col-2\">Отлично</div>
                            </div>
                            <label for=\"exampleFormControlTextarea3\">
                                <span class=\"font-weight-bold\">Комментарий</span> (Общее состояние интерьера, мебели,
                                сантехники, удобство месторасположения, удалённость
                                от мест кастингов и работ и т.д.)</label>
                            <textarea class=\"form-control\" id=\"exampleFormControlTextarea3\" rows=\"3\"></textarea>
                        </div>

                        <div class=\"form-group\">
                            <h6>Общее впечатление о сотрудничестве с агентством</h6>
                            <div class=\"text-center mt-3\">
                                <div class=\"form-check form-check-inline\">
                                    <input class=\"form-check-input\" type=\"radio\" name=\"inlineRadioOptions4\"
                                           id=\"inlineRadio4_1\" value=\"1\">
                                    <label class=\"form-check-label\" for=\"inlineRadio4_1\">1</label>
                                </div>
                                <div class=\"form-check form-check-inline\">
                                    <input class=\"form-check-input\" type=\"radio\" name=\"inlineRadioOptions4\"
                                           id=\"inlineRadio4_2\" value=\"2\">
                                    <label class=\"form-check-label\" for=\"inlineRadio4_2\">2</label>
                                </div>
                                <div class=\"form-check form-check-inline\">
                                    <input class=\"form-check-input\" type=\"radio\" name=\"inlineRadioOptions4\"
                                           id=\"inlineRadio4_3\" value=\"3\">
                                    <label class=\"form-check-label\" for=\"inlineRadio4_3\">3</label>
                                </div>
                                <div class=\"form-check form-check-inline\">
                                    <input class=\"form-check-input\" type=\"radio\" name=\"inlineRadioOptions4\"
                                           id=\"inlineRadio4_4\" value=\"4\">
                                    <label class=\"form-check-label\" for=\"inlineRadio4_4\">4</label>
                                </div>
                                <div class=\"form-check form-check-inline\">
                                    <input class=\"form-check-input\" type=\"radio\" name=\"inlineRadioOptions4\"
                                           id=\"inlineRadio4_5\" value=\"5\">
                                    <label class=\"form-check-label\" for=\"inlineRadio4_5\">5</label>
                                </div>
                            </div>
                            <div class=\"row mb-3 justify-content-center text-center\">
                                <div class=\"col-2\">Плохо</div>
                                <div class=\"col-3\">Среднее</div>
                                <div class=\"col-2\">Отлично</div>
                            </div>
                            <label for=\"exampleFormControlTextarea4\">
                                <span class=\"font-weight-bold\">Комментарий</span> (Опишите Ваше общее впечатление от
                                работы с агентством, поделитесь историями, как
                                позитивными, так и негативными.)</label>
                            <textarea class=\"form-control\" id=\"exampleFormControlTextarea4\" rows=\"3\"></textarea>
                        </div>
                    </form>
                </div>
                <div class=\"modal-footer\">
                    <button type=\"submit\" class=\"btn btn-dark\" data-dismiss=\"modal\">Оставить отзыв</button>
                    <button type=\"button\" class=\"btn btn-outline-dark\" data-dismiss=\"modal\">Отменить</button>
                </div>
            </div>
        </div>
    </div>
</section>
";
    }

    public function getTemplateName()
    {
        return "widget/agency_reviews_widget.twig";
    }

    public function getDebugInfo()
    {
        return array (  30 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "widget/agency_reviews_widget.twig", "/apps/web/templates/widget/agency_reviews_widget.twig");
    }
}
