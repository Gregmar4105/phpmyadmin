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

/* server/select/server_options.twig */
class __TwigTemplate_14880b95268c1598ce37d71864fa41fa extends Template
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
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["select"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["server"]) {
            // line 2
            echo "    <option
        value=\"";
            // line 3
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["server"], "value", [], "any", false, false, false, 3), "html", null, true);
            echo "\"
        ";
            // line 4
            if (twig_get_attribute($this->env, $this->source, $context["server"], "selected", [], "any", false, false, false, 4)) {
                echo "selected=\"selected\"";
            }
            // line 5
            echo "    >";
            // line 6
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["server"], "label", [], "any", false, false, false, 6), "html", null, true);
            // line 7
            echo "</option>
";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['server'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
    }

    public function getTemplateName()
    {
        return "server/select/server_options.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  56 => 7,  54 => 6,  52 => 5,  48 => 4,  44 => 3,  41 => 2,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "server/select/server_options.twig", "C:\\Users\\Admin\\Herd\\phpmyadmin\\templates\\server\\select\\server_options.twig");
    }
}
