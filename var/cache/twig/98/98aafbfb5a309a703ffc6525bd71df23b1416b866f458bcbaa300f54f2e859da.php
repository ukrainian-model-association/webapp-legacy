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

/* forms/defile.html.twig */
class __TwigTemplate_eb4816a166e42d55f5c6386d5972d672bff8ca7ec9c85b3b949054f4cd2e843a extends \Twig\Template
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
        echo "<form method=\"post\" enctype=\"multipart/form-data\" name=\"defile\" class=\"d-none\" novalidate>
    <input type=\"hidden\" name=\"defile[id]\">

    <div class=\"card border-0\">
        <div class=\"imagebox card-img-top\">
            <input type=\"hidden\" name=\"defile[image][id]\">
            <input type=\"file\" name=\"defile[image][data]\" accept=\"image/jpeg,image/png\"/>
            <button type=\"button\" class=\"btn btn-dark imagebox-control\">
                <i class=\"fas fa-cloud-upload-alt\"></i>
            </button>
            <img alt=\"...\" class=\"img-fluid w-100 rounded-top\" style=\"min-height: 300px;\"
                 src=\"https://placehold.jp/500x300.png\">
        </div>
        <div class=\"card-body\">

            <div class=\"form-group row\">
                <label for=\"defile[event]\" class=\"col-form-label col-4\">Мероприятие</label>
                <div class=\"col-8\">
                    <input type=\"text\" class=\"form-control\" id=\"defile[event]\" name=\"defile[event]\">
                </div>
            </div>

            <div class=\"form-group row\">
                <label for=\"defile[country]\" class=\"col-form-label col-4\">Страна</label>
                <div class=\"col-8\">
                    <select class=\"custom-select\" id=\"defile[country]\" name=\"defile[country]\" required=\"required\">
                        <option selected> &mdash;</option>
                        ";
        // line 28
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["geo"]) ? $context["geo"] : $this->getContext($context, "geo")), "countries", []));
        foreach ($context['_seq'] as $context["_key"] => $context["country"]) {
            // line 29
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
        // line 31
        echo "                    </select>
                </div>
            </div>
            <div class=\"form-group row d-none\">
                <label for=\"defile[city]\" class=\"col-form-label col-4\">Город</label>
                <div class=\"col-8\">
                    <select
                            class=\"custom-select\"
                            id=\"defile[city]\"
                            name=\"defile[city]\"
                            data-depends-on=\"select[id='defile[country]']\"
                            required=\"required\"></select>
                </div>
            </div>

            <div class=\"form-group row\">
                <label for=\"defile[period]\" class=\"col-form-label col-4\">Период</label>
                <div class=\"col-8\">
                    <div class=\"input-group\">
                        <select class=\"custom-select w-50\" id=\"defile[period_month]\" name=\"defile[period_month]\">
                            ";
        // line 51
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["datetime"]) ? $context["datetime"] : $this->getContext($context, "datetime")), "months", []));
        foreach ($context['_seq'] as $context["value"] => $context["text"]) {
            // line 52
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
        // line 54
        echo "                        </select>
                        <select class=\"custom-select\" id=\"defile[period_year]\" name=\"defile[period_year]\">
                            ";
        // line 56
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["datetime"]) ? $context["datetime"] : $this->getContext($context, "datetime")), "years", []));
        foreach ($context['_seq'] as $context["_key"] => $context["year"]) {
            // line 57
            echo "                                <option value=\"\">";
            echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $context["year"], "Y"), "html", null, true);
            echo "</option>
                            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['year'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 59
        echo "                        </select>
                    </div>
                </div>
            </div>

            <div class=\"form-group row\">
                <div class=\"col-4\">Показ</div>
                <div class=\"col-8\">
                    <div class=\"form-check\">
                        <input class=\"form-check-input\" type=\"checkbox\" name=\"defile[show_opening]\"
                               id=\"defile[show_opening]\" value=\"1\"/>
                        <label class=\"form-check-label\" for=\"defile[show_opening]\">Открывала</label>
                    </div>
                    <div class=\"form-check\">
                        <input class=\"form-check-input\" type=\"checkbox\" name=\"defile[show_closing]\"
                               id=\"defile[show_closing]\" value=\"1\"/>
                        <label class=\"form-check-label\" for=\"defile[show_closing]\">Закрывала</label>
                    </div>
                </div>
            </div>

            <div class=\"form-group row\">
                <label for=\"defile[makeupArtist]\" class=\"col-form-label col-4\">Визажист</label>
                <div class=\"col-8\">
                    <input type=\"text\" class=\"form-control\" id=\"defile[makeupArtist]\" name=\"defile[makeupArtist]\">
                </div>
            </div>

            <div class=\"form-group row\">
                <label for=\"defile[stylist]\" class=\"col-form-label col-4\">Стилист</label>
                <div class=\"col-8\">
                    <input type=\"text\" class=\"form-control\" id=\"defile[stylist]\" name=\"defile[stylist]\">
                </div>
            </div>

            <div class=\"form-group row mb-0\">
                <label for=\"defile[designer]\" class=\"col-form-label col-4\">Дизайнер</label>
                <div class=\"col-8\">
                    <input type=\"text\" class=\"form-control\" id=\"defile[designer]\" name=\"defile[designer]\">
                </div>
            </div>
        </div>
    </div>
</form>
";
    }

    public function getTemplateName()
    {
        return "forms/defile.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  128 => 59,  119 => 57,  115 => 56,  111 => 54,  100 => 52,  96 => 51,  74 => 31,  63 => 29,  59 => 28,  30 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "forms/defile.html.twig", "/apps/web/templates/forms/defile.html.twig");
    }
}
