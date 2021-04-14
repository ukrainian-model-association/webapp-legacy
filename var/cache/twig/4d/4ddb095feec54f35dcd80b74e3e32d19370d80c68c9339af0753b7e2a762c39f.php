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

/* forms/catalogs.html.twig */
class __TwigTemplate_be6dfaacb0d99c6586698e5b860c393f9cc4d96d275f77d7a7d0978176821e53 extends \Twig\Template
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
        echo "<form method=\"post\" enctype=\"multipart/form-data\" name=\"catalogs\" class=\"d-none\" novalidate>

    <div class=\"card border-0\">

        <div class=\"imagebox card-img-top\">
            <input type=\"hidden\" name=\"catalogs[image][id]\">
            <input type=\"file\" name=\"catalogs[image][data]\" accept=\"image/jpeg,image/png\"/>
            <button type=\"button\" class=\"btn btn-dark imagebox-control\">
                <i class=\"fas fa-cloud-upload-alt\"></i>
            </button>
            <img alt=\"...\" class=\"img-fluid w-100 rounded-top\" style=\"min-height: 300px;\" src=\"https://placehold.jp/500x300.png\">
        </div>

        <div class=\"card-body\">

            <div class=\"form-group row\">
                <label for=\"catalogs[event]\" class=\"col-form-label col-4\">Название</label>
                <div class=\"col-8\">
                    <input type=\"text\" class=\"form-control\" id=\"catalogs[event]\" name=\"catalogs[event]\">
                </div>
            </div>

            <div class=\"form-group row\">
                <label for=\"catalogs[brand]\" class=\"col-form-label col-4\">Бренд</label>
                <div class=\"col-8\">
                    <input type=\"text\" class=\"form-control\" id=\"catalogs[brand]\" name=\"catalogs[brand]\">
                </div>
            </div>

            <div class=\"form-group row\">
                <label for=\"catalogs[company]\" class=\"col-form-label col-4\">Компания</label>
                <div class=\"col-8\">
                    <input type=\"text\" class=\"form-control\" id=\"catalogs[company]\" name=\"catalogs[company]\">
                </div>
            </div>

            <div class=\"form-group row\">
                <div class=\"col-4\">Период</div>
                <div class=\"col-8\">
                    <div class=\"input-group\">
                        <select class=\"custom-select w-50\" id=\"catalogs[period][month]\" name=\"catalogs[period][month]\" aria-label=\"Месяц\">
                            ";
        // line 42
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["datetime"]) ? $context["datetime"] : $this->getContext($context, "datetime")), "months", []));
        foreach ($context['_seq'] as $context["value"] => $context["text"]) {
            // line 43
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
        // line 45
        echo "                        </select>
                        <select class=\"custom-select\" id=\"catalogs[period][year]\" name=\"catalogs[period][year]\" aria-label=\"Год\">
                            ";
        // line 47
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["datetime"]) ? $context["datetime"] : $this->getContext($context, "datetime")), "years", []));
        foreach ($context['_seq'] as $context["_key"] => $context["year"]) {
            // line 48
            echo "                                <option value=\"\">";
            echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $context["year"], "Y"), "html", null, true);
            echo "</option>
                            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['year'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 50
        echo "                        </select>
                    </div>
                </div>
            </div>

            <div class=\"form-group row\">
                <label for=\"catalogs[makeupArtist]\" class=\"col-form-label col-4\">Визажист</label>
                <div class=\"col-8\">
                    <input type=\"text\" class=\"form-control\" id=\"catalogs[makeupArtist]\" name=\"catalogs[makeupArtist]\">
                </div>
            </div>
            <div class=\"form-group row\">
                <label for=\"catalogs[stylist]\" class=\"col-form-label col-4\">Стилист</label>
                <div class=\"col-8\">
                    <input type=\"text\" class=\"form-control\" id=\"catalogs[stylist]\" name=\"catalogs[stylist]\">
                </div>
            </div>
            <div class=\"form-group row\">
                <label for=\"catalogs[photographer]\" class=\"col-form-label col-4\">Фотограф</label>
                <div class=\"col-8\">
                    <input type=\"text\" class=\"form-control\" id=\"catalogs[photographer]\" name=\"catalogs[photographer]\">
                </div>
            </div>
            <div class=\"form-group row mb-0\">
                <label for=\"catalogs[designer]\" class=\"col-form-label col-4\">Дизайнер одежды</label>
                <div class=\"col-8\">
                    <input type=\"text\" class=\"form-control\" id=\"catalogs[designer]\" name=\"catalogs[designer]\"/>
                </div>
            </div>

        </div>

    </div>

</form>
";
    }

    public function getTemplateName()
    {
        return "forms/catalogs.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  105 => 50,  96 => 48,  92 => 47,  88 => 45,  77 => 43,  73 => 42,  30 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "forms/catalogs.html.twig", "/apps/web/templates/forms/catalogs.html.twig");
    }
}
