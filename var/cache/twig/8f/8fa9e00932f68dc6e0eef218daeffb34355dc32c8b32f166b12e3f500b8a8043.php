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

/* forms/adv.html.twig */
class __TwigTemplate_df430c2270c02239a467915c7315ff49d8d3a57db0c353a294df589f3b886b59 extends \Twig\Template
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
        echo "<form name=\"adv\" class=\"d-none\">
    <div class=\"card border-0\">
        <div class=\"imagebox card-img-top\">
            <input type=\"file\" name=\"adv[image]\" accept=\"image/jpeg,image/png\"/>
            <button type=\"button\" class=\"btn btn-dark imagebox-control\">
                <i class=\"fas fa-cloud-upload-alt\"></i>
            </button>
            <img alt=\"...\" class=\"img-fluid w-100 rounded-top\" style=\"min-height: 300px;\" src=\"https://placehold.jp/500x300.png\">
        </div>
        <div class=\"card-body\">

            <div class=\"form-group\">
                <input class=\"form-control\" type=\"text\" name=\"adv[name]\" placeholder=\"Наименование\" aria-label=\"Наименование\"/>
            </div>

            <div class=\"form-group mb-0\">
                <textarea class=\"form-control\" name=\"adv[description]\" placeholder=\"Описание\" aria-label=\"Описание\" rows=\"8\"></textarea>
            </div>

        </div>
    </div>
</form>
";
    }

    public function getTemplateName()
    {
        return "forms/adv.html.twig";
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
        return new Source("", "forms/adv.html.twig", "/apps/web/templates/forms/adv.html.twig");
    }
}
