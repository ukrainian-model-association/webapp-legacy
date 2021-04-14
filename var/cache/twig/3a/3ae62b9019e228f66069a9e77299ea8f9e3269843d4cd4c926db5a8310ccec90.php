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

/* widget/container.html.twig */
class __TwigTemplate_a901e027028bd448f484611945940826bc3baddb4e2590ac4c8bbbc9dbfe5fce extends \Twig\Template
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
        echo "<div class=\"d-flex flex-column px-0 mt-4\">
    <div class=\"d-flex flex-row\">
        <a class=\"square flex-grow-1\" data-toggle=\"button\" href=\"javascript:void 0\">Работы</a>
        <div class=\"btn-group\">
            <a class=\"btn dropdown-toggle p-0\"
                    role=\"button\"
                    data-toggle=\"dropdown\"
                    aria-haspopup=\"true\"
                    aria-expanded=\"false\"
                    style=\"font-size: 12px\">Добавить</a>
            <div class=\"dropdown-menu dropdown-menu-right shadow rounded-0\"
                    aria-labelledby=\"dropdownMenuLink\"
                    style=\"font-size: 12px\">
                ";
        // line 14
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["workTypes"]) ? $context["workTypes"] : $this->getContext($context, "workTypes")));
        foreach ($context['_seq'] as $context["key"] => $context["value"]) {
            // line 15
            echo "                    <a data-form-name=\"";
            echo twig_escape_filter($this->env, $context["key"], "html", null, true);
            echo "\" href=\"javascript:void 0;\" class=\"dropdown-item\">";
            echo twig_escape_filter($this->env, $context["value"], "html", null, true);
            echo "</a>
                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['key'], $context['value'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 17
        echo "            </div>
        </div>
    </div>
    <hr>
    <div>
        <div>
            <ul class=\"list-group list-group-flush fs12\">
                <li class=\"list-group-item px-0 py-1 d-flex flex-row justify-content-between\">
                    <span>Конкурс :: <a href=\"/albums/album?aid=1564&amp;uid=4\">tralala, Украина, 123</a></span>
                    <span>Февраль, 2011</span>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class=\"modal fade\" id=\"workFormModal\" data-backdrop=\"false\" data-keyboard=\"false\" tabindex=\"-1\" role=\"dialog\" aria-hidden=\"false\">
    <div class=\"modal-dialog modal-dialog-centered\" style=\"max-width: 42em\">
        <div class=\"modal-content shadow rounded\">
            <div class=\"modal-header p-1 d-none\">
                <h6 class=\"modal-title text-uppercase\">Обложка</h6>
                <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                    <span aria-hidden=\"true\">&times;</span>
                </button>
            </div>
            <div class=\"modal-body p-0\">
                ";
        // line 43
        $context["__internal_a0595008d25078a3be70bcd1665dc7ab4ec4cffa0928aba5031c5f79f2963ca5"] = $this->loadTemplate("forms/default.html.twig", "widget/container.html.twig", 43)->unwrap();
        // line 44
        echo "
                ";
        // line 45
        echo $context["__internal_a0595008d25078a3be70bcd1665dc7ab4ec4cffa0928aba5031c5f79f2963ca5"]->getdefault("adv");
        echo "
                ";
        // line 46
        echo $context["__internal_a0595008d25078a3be70bcd1665dc7ab4ec4cffa0928aba5031c5f79f2963ca5"]->getdefault("portfolio");
        echo "
                ";
        // line 47
        $this->loadTemplate("forms/covers.html.twig", "widget/container.html.twig", 47)->display($context);
        // line 48
        echo "                ";
        $this->loadTemplate("forms/fashion.html.twig", "widget/container.html.twig", 48)->display($context);
        // line 49
        echo "                ";
        $this->loadTemplate("forms/defile.html.twig", "widget/container.html.twig", 49)->display($context);
        // line 50
        echo "                ";
        $this->loadTemplate("forms/advertisement.html.twig", "widget/container.html.twig", 50)->display($context);
        // line 51
        echo "                ";
        $this->loadTemplate("forms/contest.html.twig", "widget/container.html.twig", 51)->display($context);
        // line 52
        echo "                ";
        $this->loadTemplate("forms/catalogs.html.twig", "widget/container.html.twig", 52)->display($context);
        // line 53
        echo "            </div>
            <div class=\"modal-footer\">
                <button type=\"button\" class=\"btn btn-dark\">Сохранить</button>
                <button type=\"button\" class=\"btn btn-light\" data-dismiss=\"modal\">Отменить</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.querySelector('div[id=\"workFormModal\"].modal');
        const tabView = new TabView();

        modal
            .querySelectorAll('form[name]')
            .forEach(form => {
                tabView.add(form.name, form);
            });

        document
            .querySelectorAll('a[data-form-name]')
            .forEach(a => {
                a.addEventListener('click', ({target: {dataset: {formName}}}) => {
                    tabView.show(formName);
                    \$(modal).modal('show');
                });
            });

        modal
            .querySelectorAll('div.imagebox')
            .forEach(ImageView);

        function Form(formElement) {
            return {
                reset() {
                    formElement.dispatchEvent(new Event('reset'));
                }
            }
        }

        function TabView() {
            const content = new Map();

            return {
                add(name, view) {
                    content.set(name, view);

                    return this;
                },
                show(name) {
                    if (content.has(name)) {
                        content.forEach(({classList}) => {
                            classList.add('d-none');
                        });

                        content.get(name).classList.remove('d-none');
                    }

                    return this;
                }
            }
        }

        function ImageView(container) {
            const fileReader = new FileReader();
            const inputElement = container.querySelector(':scope > input[type=\"file\"]');
            const buttonElement = container.querySelector(':scope > button.imagebox-control');
            const imageElement = container.querySelector(':scope > img')

            inputElement.addEventListener('change', ({target: {files}}) => {
                [...files].forEach(fileReader.readAsDataURL.bind(fileReader));
            }, false);

            buttonElement.addEventListener('click', e => {
                inputElement.dispatchEvent(new MouseEvent('click', {bubbles: true}));
                e.preventDefault();
                e.stopPropagation();
            }, false);

            fileReader.onload = (e) => {
                imageElement.src = e.target.result;
            }

            container.closest('form').addEventListener('reset', e => {
                imageElement.removeAttribute('src');
            }, false);
        }

    });
</script>
";
    }

    public function getTemplateName()
    {
        return "widget/container.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  118 => 53,  115 => 52,  112 => 51,  109 => 50,  106 => 49,  103 => 48,  101 => 47,  97 => 46,  93 => 45,  90 => 44,  88 => 43,  60 => 17,  49 => 15,  45 => 14,  30 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "widget/container.html.twig", "/apps/web/src/UI/Widget/views/container.html.twig");
    }
}
