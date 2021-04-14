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
class __TwigTemplate_d51fba40d42d5f3724b1613bb3772991e7d97587128d2f114d9a1fea181b53b7 extends \Twig\Template
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
        $context["__internal_95c86ea702f1d2a5a41aa63b21f092ca06c2bd26dbeeb375de141cdf6509a7a5"] = $this->loadTemplate("forms/forms.html.twig", "widget/container.html.twig", 1)->unwrap();
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
    <div class=\"d-flex flex-column px-0 mt-4\">
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
                    <li data-album-id=\"\${album.id}\"
                        class=\"list-group-item px-0 py-1 d-flex flex-row justify-content-between align-items-center\">
                        <div>\${album.type} :: <a href=\"javascript:void(0);\"
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
            ";
        // line 97
        echo "
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
        // line 112
        $this->loadTemplate("forms/covers.html.twig", "widget/container.html.twig", 112)->display($context);
        // line 113
        echo "                    ";
        // line 114
        echo "                    ";
        $this->loadTemplate("forms/defile.html.twig", "widget/container.html.twig", 114)->display($context);
        // line 115
        echo "                    ";
        echo $context["__internal_95c86ea702f1d2a5a41aa63b21f092ca06c2bd26dbeeb375de141cdf6509a7a5"]->getdefault("adv");
        echo "
                    ";
        // line 117
        echo "                    ";
        $this->loadTemplate("forms/contest.html.twig", "widget/container.html.twig", 117)->display($context);
        // line 118
        echo "                    ";
        // line 119
        echo "                </div>
                <div class=\"modal-footer\">
                    <button type=\"submit\" class=\"btn btn-dark\">Сохранить</button>
                    <button type=\"button\" class=\"btn btn-outline-dark\" data-dismiss=\"modal\">Отменить</button>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    ";
        // line 131
        echo "    ";
        // line 132
        echo "    ";
        // line 133
        echo "
    ";
        // line 135
        echo "    ";
        // line 136
        echo "    ";
        // line 137
        echo "
    // const slot = document.querySelector('div[slot=\"works\"]')
    // const works = new Works({})

    ";
        // line 142
        echo "    ";
        // line 143
        echo "    ";
        // line 144
        echo "    ";
        // line 145
        echo "    ";
        // line 146
        echo "    ";
        // line 147
        echo "    ";
        // line 148
        echo "    // });
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
        return array (  209 => 148,  207 => 147,  205 => 146,  203 => 145,  201 => 144,  199 => 143,  197 => 142,  191 => 137,  189 => 136,  187 => 135,  184 => 133,  182 => 132,  180 => 131,  167 => 119,  165 => 118,  162 => 117,  157 => 115,  154 => 114,  152 => 113,  150 => 112,  133 => 97,  98 => 42,  90 => 36,  82 => 34,  77 => 33,  73 => 32,  54 => 16,  48 => 13,  44 => 12,  32 => 2,  30 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "widget/container.html.twig", "/apps/web/templates/widget/container.html.twig");
    }
}
