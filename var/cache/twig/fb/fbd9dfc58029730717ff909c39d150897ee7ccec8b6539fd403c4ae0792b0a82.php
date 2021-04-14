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

/* forms/fashion.html.twig */
class __TwigTemplate_fe3aa8b3a17301c07d1ad5e0a076a5140391ffba4b586eafc28934e31347379f extends \Twig\Template
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
        echo "<form method=\"post\" enctype=\"multipart/form-data\" name=\"fashion\" class=\"d-none\" novalidate>
    <div class=\"card border-0\">
        <div class=\"imagebox card-img-top\">
            <input type=\"hidden\" name=\"fashion[image][id]\">
            <input type=\"file\" name=\"fashion[image][data]\" accept=\"image/jpeg,image/png\"/>
            <button type=\"button\" class=\"btn btn-dark imagebox-control\">
                <i class=\"fas fa-cloud-upload-alt\"></i>
            </button>
            <img alt=\"...\" class=\"img-fluid w-100 rounded-top\" style=\"min-height: 300px;\" src=\"https://placehold.jp/500x300.png\">
        </div>
        <div class=\"card-body\">
            <div class=\"form-group row\">
                <label for=\"fashion[journal][name]\" class=\"col-form-label col-4\">Журнал</label>
                <div class=\"col-8\">
                    <input type=\"text\" id=\"fashion[journal][name]\" name=\"covers[journal][name]\" class=\"form-control\"
                           placeholder=\"Название журнала\" aria-label=\"Название журнала\"/>
                </div>
            </div>
            <div class=\"form-group row\">
                <div class=\"col-8 offset-4\">
                    <div class=\"input-group\">
                        <input type=\"text\" name=\"fashion[journal][number]\" placeholder=\"Номер\" aria-label=\"Номер\" class=\"form-control\"/>
                        <select class=\"custom-select\" id=\"fashion[journal][month]\" name=\"fashion[journal][month]\" aria-label=\"Месяц\">
                            ";
        // line 24
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["datetime"]) ? $context["datetime"] : $this->getContext($context, "datetime")), "months", []));
        foreach ($context['_seq'] as $context["value"] => $context["text"]) {
            // line 25
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
        // line 27
        echo "                        </select>
                        <select class=\"custom-select\" id=\"fashion[journal][year]\" name=\"fashion[journal][year]\" aria-label=\"Год\">
                            ";
        // line 29
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["datetime"]) ? $context["datetime"] : $this->getContext($context, "datetime")), "years", []));
        foreach ($context['_seq'] as $context["_key"] => $context["year"]) {
            // line 30
            echo "                                <option value=\"\">";
            echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $context["year"], "Y"), "html", null, true);
            echo "</option>
                            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['year'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 32
        echo "                        </select>
                    </div>
                </div>
            </div>

            <div class=\"form-group row\">
                <div class=\"col-4\">Напечатан</div>
                <div class=\"col-8\">
                    <div class=\"form-check\">
                        <input class=\"form-check-input\" type=\"radio\" name=\"fashion[printedIn][]\" id=\"fashion[printedIn][ukraine]\" value=\"ukraine\" checked/>
                        <label class=\"form-check-label\" for=\"fashion[printedIn][ukraine]\">в Украине</label>
                    </div>
                    <div class=\"form-check\">
                        <input class=\"form-check-input\" type=\"radio\" name=\"fashion[printedIn][]\" id=\"fashion[printedIn][otherCountry]\" value=\"otherCountry\"/>
                        <label class=\"form-check-label\" for=\"fashion[printedIn][otherCountry]\">в другой стране</label>
                    </div>
                    <div class=\"form-check\">
                        <input class=\"form-check-input\" type=\"radio\" name=\"fashion[printedIn][]\" id=\"fashion[printedIn][moreThanOneCountries]\" value=\"moreThanOneCountries\"/>
                        <label class=\"form-check-label\" for=\"fashion[printedIn][moreThanOneCountries]\">в нескольких странах</label>
                    </div>
                </div>
            </div>

            <div class=\"form-group row\">
                <label for=\"fashion[makeupArtist]\" class=\"col-form-label col-4\">Визажист</label>
                <div class=\"col-8\">
                    <input type=\"text\" class=\"form-control\" id=\"fashion[makeupArtist]\" name=\"fashion[makeupArtist]\">
                </div>
            </div>
            <div class=\"form-group row\">
                <label for=\"fashion[stylist]\" class=\"col-form-label col-4\">Стилист</label>
                <div class=\"col-8\">
                    <input type=\"text\" class=\"form-control\" id=\"fashion[stylist]\" name=\"fashion[stylist]\">
                </div>
            </div>
            <div class=\"form-group row mb-0\">
                <label for=\"fashion[photographer]\" class=\"col-form-label col-4\">Фотограф</label>
                <div class=\"col-8\">
                    <input type=\"text\" class=\"form-control\" id=\"fashion[photographer]\" name=\"fashion[photographer]\">
                </div>
            </div>
        </div>
    </div>
</form>
";
    }

    public function getTemplateName()
    {
        return "forms/fashion.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  87 => 32,  78 => 30,  74 => 29,  70 => 27,  59 => 25,  55 => 24,  30 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "forms/fashion.html.twig", "/apps/web/templates/forms/fashion.html.twig");
    }
}
