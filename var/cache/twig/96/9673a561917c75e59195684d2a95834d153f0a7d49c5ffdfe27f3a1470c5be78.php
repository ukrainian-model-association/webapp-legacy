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

/* widget/works_widget.twig */
class __TwigTemplate_bdf0e6ee8c1a4d0470527c790ee7405ed93d357a2e87fee4afc7a3c505a8c122 extends \Twig\Template
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
        $context["__internal_69e66dde87c7b8fb065d62c418eb48d5568c5ae2556271f33fd3354738c5322c"] = $this->loadTemplate("forms/forms.html.twig", "widget/works_widget.twig", 1)->unwrap();
        // line 2
        echo "
<script src=\"/public/js/app/profile/index/works.js\"></script>
<script>
  document.addEventListener('DOMContentLoaded', ({ target }) => {
    const scope = target.querySelector('section[id=\"works\"]');
    const provideData = (albums) => {
      albums.forEach(({ id, name, type }) => works.list.add({ id, name, type: works.types.get(type) }));
    };

    window.works = new Works(scope, {
      personId: ";
        // line 12
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["profile"]) ? $context["profile"] : $this->getContext($context, "profile")), "user_id", []), "html", null, true);
        echo ",
      albumTypes: '";
        // line 13
        echo twig_jsonencode_filter((isset($context["workTypes"]) ? $context["workTypes"] : $this->getContext($context, "workTypes")));
        echo "',
    });

    api['persons/albums'](";
        // line 16
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["profile"]) ? $context["profile"] : $this->getContext($context, "profile")), "user_id", []), "html", null, true);
        echo ")
      .all()
      .then(provideData);
  });
</script>

<section id=\"works\">
    <div class=\"d-flex flex-column px-0 mt-2\">
        <div class=\"d-flex flex-row\">
            <a class=\"square flex-grow-1\" data-toggle=\"button\" href=\"javascript:void 0\">Работы</a>
            <div class=\"btn-group\">
                <a class=\"btn btn-sm btn-light dropdown-toggle border-0\" role=\"button\" data-toggle=\"dropdown\"
                   aria-haspopup=\"true\"
                   aria-expanded=\"false\"><i class=\"fas fa-plus-circle\"></i></a>
                <div class=\"dropdown-menu dropdown-menu-right shadow rounded-0\"
                     aria-labelledby=\"dropdownMenuLink\">
                    ";
        // line 32
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["workTypes"]) ? $context["workTypes"] : $this->getContext($context, "workTypes")));
        foreach ($context['_seq'] as $context["key"] => $context["value"]) {
            // line 33
            echo "                        <a data-form-name=\"";
            echo twig_escape_filter($this->env, $context["key"], "html", null, true);
            echo "\" href=\"javascript:void 0;\"
                           class=\"dropdown-item btn btn-sm btn-light\">";
            // line 34
            echo twig_escape_filter($this->env, $context["value"], "html", null, true);
            echo "</a>
                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['key'], $context['value'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 36
        echo "                </div>
            </div>
        </div>
        <hr>
        <div>
            <div id=\"alertOfEmptyList\"
                 class=\"alert alert-dark m-0 border-0 rounded-0 fs12 text-center text-muted";
        // line 42
        if ( !twig_test_empty((isset($context["workList"]) ? $context["workList"] : $this->getContext($context, "workList")))) {
            echo " d-none";
        }
        echo "\"
                 role=\"alert\">Тут еще нет работ
            </div>
            <ul id=\"workAlbums\" class=\"list-group list-group-flush fs12\">
                <template id=\"listItem\">
                    <li data-album-id=\"\${album.id}\" data-person-id=\"";
        // line 47
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["profile"]) ? $context["profile"] : $this->getContext($context, "profile")), "user_id", []), "html", null, true);
        echo "\"
                        class=\"list-group-item px-0 py-1 d-flex flex-row justify-content-between align-items-center\">
                        <div>\${album.type} :: <a href=\"javascript:void(0);\"
                                                 onclick=\"works.list.show(this.closest('li'))\"
                                                 class=\"btn btn-link text-dark p-0\">\${album.name}</a></div>
                        <div>
                            <div class=\"btn-group dropright\">
                                <button class=\"btn btn-sm btn-light dropdown-toggle border-0 shadow-none\" type=\"button\"
                                        data-toggle=\"dropdown\"
                                        aria-haspopup=\"true\"
                                        aria-expanded=\"false\"><i class=\"fas fa-ellipsis-h\"></i></button>
                                <div class=\"dropdown-menu shadow\">
                                    <a class=\"dropdown-item btn btn-sm btn-light\" href=\"javascript: void 0;\"
                                       onclick=\"works.list.read(this.closest('li'))\">
                                        <i class=\"far fa-edit mr-2\"></i> Изменить
                                    </a>
                                    <a class=\"dropdown-item btn btn-sm btn-light\" href=\"javascript: void 0;\"
                                       onclick=\"works.list.remove(this.closest('li'))\">
                                        <i class=\"far fa-trash-alt mr-2\"></i> Удалить
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                </template>
            </ul>
        </div>
    </div>

    <div class=\"modal fade\" id=\"workFormModal\" data-backdrop=\"false\" data-keyboard=\"false\" tabindex=\"-1\" role=\"dialog\"
         aria-hidden=\"false\">
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
        // line 87
        $this->loadTemplate("forms/covers.html.twig", "widget/works_widget.twig", 87)->display($context);
        // line 88
        echo "                    ";
        // line 89
        echo "                    ";
        $this->loadTemplate("forms/defile.html.twig", "widget/works_widget.twig", 89)->display($context);
        // line 90
        echo "                    ";
        echo $context["__internal_69e66dde87c7b8fb065d62c418eb48d5568c5ae2556271f33fd3354738c5322c"]->getdefault("adv");
        echo "
                    ";
        // line 92
        echo "                    ";
        $this->loadTemplate("forms/contest.html.twig", "widget/works_widget.twig", 92)->display($context);
        // line 93
        echo "                    ";
        // line 94
        echo "                </div>
                <div class=\"modal-footer\">
                    <button type=\"submit\" class=\"btn btn-dark\">Сохранить</button>
                    <button type=\"button\" class=\"btn btn-outline-dark\" data-dismiss=\"modal\">Отменить</button>
                </div>
            </div>
        </div>
    </div>

    <div class=\"modal fade\" id=\"work_preview\" data-backdrop=\"false\" data-keyboard=\"false\" tabindex=\"-1\"
         role=\"dialog\" aria-hidden=\"true\">
        <div class=\"modal-dialog modal-dialog-centered\" style=\"max-width: 42em\">
            <div class=\"modal-content shadow rounded\">
                <div class=\"modal-header\">
                    <h6 class=\"modal-title text-uppercase\">Preview</h6>
                    <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                        <span aria-hidden=\"true\">&times;</span>
                    </button>
                </div>
                <div class=\"modal-body\">
                    <img src=\"https://dummyimage.com/600x400/9ca1ae\" class=\"img-fluid w-100\" alt=\"...\">
                </div>
            </div>
        </div>
    </div>

</section>

<script>
    ";
        // line 124
        echo "    ";
        // line 125
        echo "    ";
        // line 126
        echo "
    ";
        // line 128
        echo "    ";
        // line 129
        echo "    ";
        // line 130
        echo "
    // const slot = document.querySelector('div[slot=\"works\"]')
    // const works = new Works({})

    ";
        // line 135
        echo "    ";
        // line 136
        echo "    ";
        // line 137
        echo "    ";
        // line 138
        echo "    ";
        // line 139
        echo "    ";
        // line 140
        echo "    ";
        // line 141
        echo "    // });
</script>
";
    }

    public function getTemplateName()
    {
        return "widget/works_widget.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  228 => 141,  226 => 140,  224 => 139,  222 => 138,  220 => 137,  218 => 136,  216 => 135,  210 => 130,  208 => 129,  206 => 128,  203 => 126,  201 => 125,  199 => 124,  168 => 94,  166 => 93,  163 => 92,  158 => 90,  155 => 89,  153 => 88,  151 => 87,  108 => 47,  98 => 42,  90 => 36,  82 => 34,  77 => 33,  73 => 32,  54 => 16,  48 => 13,  44 => 12,  32 => 2,  30 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "widget/works_widget.twig", "/apps/web/templates/widget/works_widget.twig");
    }
}
