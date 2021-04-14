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

/* forms/forms.html.twig */
class __TwigTemplate_b3d30e143b9c7ee1f035b585e35bef995b59b3cece46f82437d052e3f95ee2fe extends \Twig\Template
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
    }

    // line 1
    public function getdefault($__name__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals([
            "name" => $__name__,
            "varargs" => $__varargs__,
        ]);

        $blocks = [];

        ob_start(function () { return ''; });
        try {
            // line 2
            echo "    <form method=\"post\" enctype=\"multipart/form-data\" name=\"";
            echo twig_escape_filter($this->env, (isset($context["name"]) ? $context["name"] : $this->getContext($context, "name")), "html", null, true);
            echo "\" class=\"d-none\" novalidate>
        <input type=\"hidden\" name=\"";
            // line 3
            echo twig_escape_filter($this->env, (isset($context["name"]) ? $context["name"] : $this->getContext($context, "name")), "html", null, true);
            echo "[id]\">

        <div class=\"card border-0\">
            <div class=\"imagebox card-img-top\">
                <input type=\"hidden\" name=\"";
            // line 7
            echo twig_escape_filter($this->env, (isset($context["name"]) ? $context["name"] : $this->getContext($context, "name")), "html", null, true);
            echo "[image][id]\">
                <input type=\"file\" name=\"";
            // line 8
            echo twig_escape_filter($this->env, (isset($context["name"]) ? $context["name"] : $this->getContext($context, "name")), "html", null, true);
            echo "[image][data]\" accept=\"image/jpeg,image/png\"/>
                <button type=\"button\" class=\"btn btn-dark imagebox-control\">
                    <i class=\"fas fa-cloud-upload-alt\"></i>
                </button>
                <img alt=\"...\" class=\"img-fluid w-100 rounded-top\" style=\"min-height: 400px\" src=\"https://dummyimage.com/600x400/9ca1ae\">
            </div>
            <div class=\"card-body\">

                <div class=\"form-group\">
                    <input class=\"form-control\" type=\"text\" name=\"";
            // line 17
            echo twig_escape_filter($this->env, (isset($context["name"]) ? $context["name"] : $this->getContext($context, "name")), "html", null, true);
            echo "[name]\" placeholder=\"Наименование\" aria-label=\"Наименование\" required=\"required\"/>
                    <div class=\"invalid-feedback\">Это поле обязательно для заполнения</div>
                </div>

                <div class=\"form-group mb-0\">
                    <textarea class=\"form-control\" name=\"";
            // line 22
            echo twig_escape_filter($this->env, (isset($context["name"]) ? $context["name"] : $this->getContext($context, "name")), "html", null, true);
            echo "[description]\" placeholder=\"Описание\" aria-label=\"Описание\" rows=\"8\"></textarea>
                </div>

            </div>
        </div>
    </form>
";
        } catch (\Exception $e) {
            ob_end_clean();

            throw $e;
        } catch (\Throwable $e) {
            ob_end_clean();

            throw $e;
        }

        return ('' === $tmp = ob_get_clean()) ? '' : new Markup($tmp, $this->env->getCharset());
    }

    public function getTemplateName()
    {
        return "forms/forms.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  80 => 22,  72 => 17,  60 => 8,  56 => 7,  49 => 3,  44 => 2,  32 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "forms/forms.html.twig", "/apps/web/templates/forms/forms.html.twig");
    }
}
