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

/* forms/advertisement.html.twig */
class __TwigTemplate_3cc4366659ca3957f66ddbe5a4262a73f4a29762fc47b73bf9324fa5fc8714f7 extends \Twig\Template
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
        echo "<form method=\"post\" enctype=\"multipart/form-data\" name=\"advertisement\" class=\"d-none\" novalidate>
    <div class=\"card border-0\">
        <div class=\"imagebox card-img-top\">
            <input type=\"hidden\" name=\"advertisement[image][id]\">
            <input type=\"file\" name=\"advertisement[image][data]\" accept=\"image/jpeg,image/png\"/>
            <button type=\"button\" class=\"btn btn-dark imagebox-control\">
                <i class=\"fas fa-cloud-upload-alt\"></i>
            </button>
            <img alt=\"...\" class=\"img-fluid w-100 rounded-top\" style=\"min-height: 300px;\" src=\"https://placehold.jp/500x300.png\">
        </div>
        <div class=\"card-body\">

            <div class=\"form-group row\">
                <div class=\"col-4\">Тип</div>
                <div class=\"col-8\">
                    <div class=\"form-check\">
                        <input class=\"form-check-input\" type=\"radio\" name=\"advertisement[type][]\" id=\"advertisement[type][journal]\" value=\"journal\" checked/>
                        <label class=\"form-check-label\" for=\"advertisement[type][journal]\">в журнале</label>
                    </div>
                    <div class=\"form-check\">
                        <input class=\"form-check-input\" type=\"radio\" name=\"advertisement[type][]\" id=\"advertisement[type][foreign]\" value=\"foreign\"/>
                        <label class=\"form-check-label\" for=\"advertisement[type][foreign]\">наружная</label>
                    </div>
                </div>
            </div>

            <div class=\"form-group row\">
                <label for=\"advertisement[brand]\" class=\"col-form-label col-4\">Бренд</label>
                <div class=\"col-8\">
                    <input type=\"text\" class=\"form-control\" id=\"advertisement[brand]\" name=\"advertisement[brand]\">
                </div>
            </div>

            <div class=\"form-group row\">
                <label for=\"advertisement[company]\" class=\"col-form-label col-4\">Компания</label>
                <div class=\"col-8\">
                    <input type=\"text\" class=\"form-control\" id=\"advertisement[company]\" name=\"advertisement[company]\">
                </div>
            </div>

            <div class=\"form-group row\">
                <div class=\"col-4\">Период</div>
                <div class=\"col-8\">
                    <div class=\"input-group\">
                        <select class=\"custom-select w-50\" id=\"advertisement[period][month]\" name=\"advertisement[period][month]\" aria-label=\"Месяц\">
                            ";
        // line 46
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["datetime"]) ? $context["datetime"] : $this->getContext($context, "datetime")), "months", []));
        foreach ($context['_seq'] as $context["value"] => $context["text"]) {
            // line 47
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
        // line 49
        echo "                        </select>
                        <select class=\"custom-select\" id=\"advertisement[period][year]\" name=\"advertisement[period][year]\" aria-label=\"Год\">
                            ";
        // line 51
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["datetime"]) ? $context["datetime"] : $this->getContext($context, "datetime")), "years", []));
        foreach ($context['_seq'] as $context["_key"] => $context["year"]) {
            // line 52
            echo "                                <option value=\"\">";
            echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $context["year"], "Y"), "html", null, true);
            echo "</option>
                            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['year'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 54
        echo "                        </select>
                    </div>
                </div>
            </div>

            <div class=\"form-group row\">
                <label for=\"advertisement[makeupArtist]\" class=\"col-form-label col-4\">Визажист</label>
                <div class=\"col-8\">
                    <input type=\"text\" class=\"form-control\" id=\"advertisement[makeupArtist]\" name=\"advertisement[makeupArtist]\">
                </div>
            </div>
            <div class=\"form-group row\">
                <label for=\"advertisement[stylist]\" class=\"col-form-label col-4\">Стилист</label>
                <div class=\"col-8\">
                    <input type=\"text\" class=\"form-control\" id=\"advertisement[stylist]\" name=\"advertisement[stylist]\">
                </div>
            </div>
            <div class=\"form-group row\">
                <label for=\"advertisement[photographer]\" class=\"col-form-label col-4\">Фотограф</label>
                <div class=\"col-8\">
                    <input type=\"text\" class=\"form-control\" id=\"advertisement[photographer]\" name=\"advertisement[photographer]\">
                </div>
            </div>
            <div class=\"form-group row mb-0\">
                <label for=\"advertisement[designer]\" class=\"col-form-label col-4\">Дизайнер одежды</label>
                <div class=\"col-8\">
                    <input type=\"text\" class=\"form-control\" id=\"advertisement[designer]\" name=\"advertisement[designer]\"/>
                </div>
            </div>

        </div>
    </div>
</form>
";
    }

    public function getTemplateName()
    {
        return "forms/advertisement.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  109 => 54,  100 => 52,  96 => 51,  92 => 49,  81 => 47,  77 => 46,  30 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "forms/advertisement.html.twig", "/apps/web/templates/forms/advertisement.html.twig");
    }
}
