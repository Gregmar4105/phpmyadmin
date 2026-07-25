<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* server/select/index.twig */
class __TwigTemplate_aabf9a4253f11ff1c385b22ff6358a7f extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        if (($context["not_only_options"] ?? null)) {
            // line 2
            echo "    <form class=\"disableAjax\" method=\"post\" action=\"";
            echo ($context["form_action"] ?? null);
            echo "\">
        ";
            // line 3
            if ((($context["omit_fieldset"] ?? null) == false)) {
                // line 4
                echo "            <fieldset class=\"pma-fieldset\">
        ";
            }
            // line 6
            echo "        ";
            echo PhpMyAdmin\Url::getHiddenFields([]);
            echo "
        <label for=\"select_server\">";
echo _gettext("Current server:");
            // line 7
            echo "</label>
        <select id=\"select_server\" class=\"autosubmit\" name=\"server\">
            <option value=\"\">(";
echo _gettext("Servers");
            // line 9
            echo ") ...</option>
            ";
            // line 10
            $this->loadTemplate("server/select/server_options.twig", "server/select/index.twig", 10)->display(twig_to_array(["select" => twig_get_attribute($this->env, $this->source,             // line 11
($context["servers"] ?? null), "select", [], "any", false, false, false, 11)]));
            // line 13
            echo "        </select>
        ";
            // line 14
            if ((($context["omit_fieldset"] ?? null) == false)) {
                // line 15
                echo "            </fieldset>
        ";
            }
            // line 17
            echo "    </form>
";
        } elseif (twig_get_attribute($this->env, $this->source,         // line 18
($context["servers"] ?? null), "list", [], "any", false, false, false, 18)) {
            // line 19
            echo "    ";
echo _gettext("Current server:");
            echo "<br>
    <ul id=\"list_server\">
        <li>
            ";
            // line 22
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, ($context["servers"] ?? null), "list", [], "any", false, false, false, 22));
            foreach ($context['_seq'] as $context["_key"] => $context["server"]) {
                // line 23
                echo "                ";
                if (twig_get_attribute($this->env, $this->source, $context["server"], "selected", [], "any", false, false, false, 23)) {
                    // line 24
                    echo "                    <strong>";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["server"], "label", [], "any", false, false, false, 24), "html", null, true);
                    echo "</strong>
                ";
                } else {
                    // line 26
                    echo "                    <a class=\"disableAjax item\" href=\"";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["server"], "href", [], "any", false, false, false, 26), "html", null, true);
                    echo "\">";
                    // line 27
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["server"], "label", [], "any", false, false, false, 27), "html", null, true);
                    // line 28
                    echo "</a>
                ";
                }
                // line 30
                echo "            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['server'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 31
            echo "        </li>
    </ul>
";
        } else {
            // line 34
            echo "    ";
            $this->loadTemplate("server/select/server_options.twig", "server/select/index.twig", 34)->display(twig_to_array(["select" => twig_get_attribute($this->env, $this->source,             // line 35
($context["servers"] ?? null), "select", [], "any", false, false, false, 35)]));
        }
    }

    public function getTemplateName()
    {
        return "server/select/index.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  124 => 35,  122 => 34,  117 => 31,  111 => 30,  107 => 28,  105 => 27,  101 => 26,  95 => 24,  92 => 23,  88 => 22,  81 => 19,  79 => 18,  76 => 17,  72 => 15,  70 => 14,  67 => 13,  65 => 11,  64 => 10,  61 => 9,  56 => 7,  50 => 6,  46 => 4,  44 => 3,  39 => 2,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "server/select/index.twig", "D:\\Herd\\phpmyadmin\\templates\\server\\select\\index.twig");
    }
}
