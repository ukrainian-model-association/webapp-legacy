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

/* forms/covers.html.twig */
class __TwigTemplate_701470f583ba9620b46681f9093fbe0cec02cbfb24672100c21d39a87cfebf6b extends \Twig\Template
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
        echo "<form method=\"post\" enctype=\"multipart/form-data\" name=\"covers\" class=\"d-none\" novalidate>
    <input type=\"hidden\" name=\"covers[id]\">

    <div class=\"card border-0\">
        <div class=\"imagebox card-img-top\">
            <input type=\"hidden\" name=\"covers[image][id]\">
            <input type=\"file\" name=\"covers[image][data]\" accept=\"image/jpeg,image/png\"/>
            <button type=\"button\" class=\"btn btn-dark imagebox-control\">
                <i class=\"fas fa-cloud-upload-alt\"></i>
            </button>
            <img alt=\"...\" class=\"img-fluid w-100 rounded-top\" style=\"min-height: 400px\" src=\"https://dummyimage.com/600x400/9ca1ae\">
        </div>
        <div class=\"card-body\">
            <div class=\"form-group row\">
                <label for=\"covers[journal_name]\" class=\"col-form-label col-4\">Журнал</label>
                <div class=\"col-8\">
                    <input type=\"text\" id=\"covers[journal_name]\" name=\"covers[journal_name]\" class=\"form-control\"
                           placeholder=\"Название журнала\" aria-label=\"Название журнала\"/>
                </div>
            </div>
            <div class=\"form-group row\">
                <div class=\"col-8 offset-4\">
                    <div class=\"input-group\">
                        <input type=\"text\" name=\"covers[journal_number]\" placeholder=\"Номер\" aria-label=\"Номер\"
                               class=\"form-control\"/>
                        <select class=\"custom-select\" id=\"covers[journal_month]\" name=\"covers[journal_month]\"
                                aria-label=\"Месяц\">
                            ";
        // line 28
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["datetime"]) ? $context["datetime"] : $this->getContext($context, "datetime")), "months", []));
        foreach ($context['_seq'] as $context["value"] => $context["text"]) {
            // line 29
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
        // line 31
        echo "                        </select>
                        <select class=\"custom-select\" id=\"covers[journal_year]\" name=\"covers[journal_year]\"
                                aria-label=\"Год\">
                            ";
        // line 34
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["datetime"]) ? $context["datetime"] : $this->getContext($context, "datetime")), "years", []));
        foreach ($context['_seq'] as $context["_key"] => $context["year"]) {
            // line 35
            echo "                                <option value=\"\">";
            echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $context["year"], "Y"), "html", null, true);
            echo "</option>
                            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['year'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 37
        echo "                        </select>
                    </div>
                </div>
            </div>
            <div class=\"form-group row\">
                <div class=\"col-form-label col-4\">Напечатан</div>
                <div class=\"col-8\">
                    <div class=\"form-check\">
                        <input class=\"form-check-input\" type=\"radio\" name=\"covers[printedIn][]\"
                               id=\"covers[printedIn_ukraine]\" value=\"ukraine\" checked/>
                        <label class=\"form-check-label\" for=\"covers[printedIn_ukraine]\">в Украине</label>
                    </div>
                    <div class=\"form-check\">
                        <input class=\"form-check-input\" type=\"radio\" name=\"covers[printedIn][]\"
                               id=\"covers[printedIn_otherCountry]\" value=\"otherCountry\"/>
                        <label class=\"form-check-label\" for=\"covers[printedIn_otherCountry]\">в другой стране</label>
                    </div>
                    <div class=\"form-check\">
                        <input class=\"form-check-input\" type=\"radio\" name=\"covers[printedIn][]\"
                               id=\"covers[printedIn_moreThanOneCountries]\" value=\"moreThanOneCountries\"/>
                        <label class=\"form-check-label\" for=\"covers[printedIn_moreThanOneCountries]\">в нескольких
                            странах</label>
                    </div>
                </div>
            </div>
            <div class=\"form-group row\">
                <label for=\"covers[makeupArtist]\" class=\"col-form-label col-4\">Визажист</label>
                <div class=\"col-8\">
                    <input type=\"text\" class=\"form-control\" id=\"covers[makeupArtist]\" name=\"covers[makeupArtist]\">
                </div>
            </div>
            <div class=\"form-group row\">
                <label for=\"covers[stylist]\" class=\"col-form-label col-4\">Стилист</label>
                <div class=\"col-8\">
                    <input type=\"text\" class=\"form-control\" id=\"covers[stylist]\" name=\"covers[stylist]\">
                </div>
            </div>
            <div class=\"form-group row\">
                <label for=\"covers[photographer]\" class=\"col-form-label col-4\">Фотограф</label>
                <div class=\"col-8\">
                    <input type=\"text\" class=\"form-control\" id=\"covers[photographer]\" name=\"covers[photographer]\">
                </div>
            </div>
            <div class=\"form-group row mb-0\">
                <label for=\"covers[designer]\" class=\"col-form-label col-4\">Дизайнер одежды</label>
                <div class=\"col-8\">
                    <input type=\"text\" class=\"form-control\" id=\"covers[designer]\" name=\"covers[designer]\"/>
                </div>
            </div>
        </div>
    </div>
</form>
";
    }

    public function getTemplateName()
    {
        return "forms/covers.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  92 => 37,  83 => 35,  79 => 34,  74 => 31,  63 => 29,  59 => 28,  30 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "forms/covers.html.twig", "/apps/web/templates/forms/covers.html.twig");
    }
}
