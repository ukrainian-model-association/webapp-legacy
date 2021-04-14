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

/* forms/contest.html.twig */
class __TwigTemplate_0d95efc7d2c3f95277c850c11d81dbcb100f90df954507b0f7330024cef168e7 extends \Twig\Template
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
        echo "<form method=\"post\" enctype=\"multipart/form-data\" name=\"contest\" class=\"d-none\" novalidate>
    <input type=\"hidden\" name=\"contest[id]\">

    <div class=\"card border-0\">
        <div class=\"imagebox card-img-top\">
            <input type=\"hidden\" name=\"contest[image][id]\">
            <input type=\"file\" name=\"contest[image][data]\" accept=\"image/jpeg,image/png\"/>
            <button type=\"button\" class=\"btn btn-dark imagebox-control\">
                <i class=\"fas fa-cloud-upload-alt\"></i>
            </button>
            <img alt=\"...\" class=\"img-fluid w-100 rounded-top\" style=\"min-height: 300px;\"
                 src=\"https://placehold.jp/500x300.png\">
        </div>
        <div class=\"card-body\">

            <div class=\"form-group row\">
                <label for=\"contest[event]\" class=\"col-form-label col-4\">Мероприятие</label>
                <div class=\"col-8\">
                    <input type=\"text\" class=\"form-control\" id=\"contest[event]\" name=\"contest[event]\"
                           required=\"required\">
                </div>
            </div>

            <div class=\"form-group row\">
                <label for=\"contest[country]\" class=\"col-form-label col-4\">Страна</label>
                <div class=\"col-8\">
                    <select class=\"custom-select\" id=\"contest[country]\" name=\"contest[country]\" required=\"required\">
                        <option selected> &mdash;</option>
                        ";
        // line 29
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["geo"]) ? $context["geo"] : $this->getContext($context, "geo")), "countries", []));
        foreach ($context['_seq'] as $context["_key"] => $context["country"]) {
            // line 30
            echo "                            <option value=\"";
            echo twig_escape_filter($this->env, $this->getAttribute($context["country"], "id", []), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, $this->getAttribute($context["country"], "name", []), "html", null, true);
            echo "</option>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['country'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 32
        echo "                    </select>
                </div>
            </div>
            <div class=\"form-group row d-none\">
                <label for=\"contest[city]\" class=\"col-form-label col-4\">Город</label>
                <div class=\"col-8\">
                    <select
                            class=\"custom-select\"
                            id=\"contest[city]\"
                            name=\"contest[city]\"
                            data-depends-on=\"select[id='contest[country]']\"
                            required=\"required\"></select>
                </div>
            </div>

            <div class=\"form-group row\">
                <label for=\"contest[period]\" class=\"col-form-label col-4\">Период</label>
                <div class=\"col-8\">
                    <div class=\"input-group\">
                        <select class=\"custom-select w-50\" id=\"contest[period_month]\" name=\"contest[period_month]\"
                                aria-label=\"Месяц\">
                            ";
        // line 53
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["datetime"]) ? $context["datetime"] : $this->getContext($context, "datetime")), "months", []));
        foreach ($context['_seq'] as $context["value"] => $context["text"]) {
            // line 54
            echo "                                <option value=\"";
            echo twig_escape_filter($this->env, $context["value"], "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, $context["text"], "html", null, true);
            echo "</option>
                            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['value'], $context['text'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 56
        echo "                        </select>
                        <select class=\"custom-select\" id=\"contest[period_year]\" name=\"contest[period_year]\"
                                aria-label=\"Год\">
                            ";
        // line 59
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["datetime"]) ? $context["datetime"] : $this->getContext($context, "datetime")), "years", []));
        foreach ($context['_seq'] as $context["_key"] => $context["year"]) {
            // line 60
            echo "                                <option value=\"\">";
            echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $context["year"], "Y"), "html", null, true);
            echo "</option>
                            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['year'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 62
        echo "                        </select>
                    </div>
                </div>
            </div>

            <div class=\"form-group row mb-0\">
                <div class=\"col-8 offset-4\">
                    <div class=\"form-check mb-1\">
                        <input class=\"form-check-input\" type=\"radio\" id=\"contest[hasAwards_no]\"
                               name=\"contest[hasAwards]\" value=\"0\" checked/>
                        <label class=\"form-check-label\" for=\"contest[hasAwards_no]\">Участие</label>
                    </div>
                    <div class=\"form-check mb-3\">
                        <input class=\"form-check-input\" type=\"radio\" id=\"contest[hasAwards_yes]\"
                               name=\"contest[hasAwards]\" value=\"1\"/>
                        <label class=\"form-check-label\" for=\"contest[hasAwards_yes]\">Награда</label>
                    </div>
                    <div class=\"form-group mb-0\"
                         data-bind-up=\"(target.value !== 1 && this.classList.add('d-none')) || this.classList.remove('d-none')\"
                         data-target=\"input[type='radio'][name='contest[hasAwards]']\">
                        <label>
                            <select class=\"custom-select\" name=\"contest[awards_level]\">
                                <option selected> &mdash;</option>
                                <option value=\"1\">1 место</option>
                                <option value=\"2\">2 место</option>
                                <option value=\"3\">3 место</option>
                            </select>
                        </label>
                    </div>
                </div>
            </div>

        </div>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', () => {

        const form = document.forms.namedItem('contest');

        const handleChange = ({target: {value}}) => {
            if (value !== 1) {

            }
        }

        form.querySelectorAll('input[name=\"contest[hasAwards]\"]').forEach(e => {
            e.addEventListener('change', handleChange);
        });

    });
</script>
";
    }

    public function getTemplateName()
    {
        return "forms/contest.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  131 => 62,  122 => 60,  118 => 59,  113 => 56,  102 => 54,  98 => 53,  75 => 32,  64 => 30,  60 => 29,  30 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "forms/contest.html.twig", "/apps/web/templates/forms/contest.html.twig");
    }
}
