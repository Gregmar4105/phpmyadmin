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

/* login/header.twig */
class __TwigTemplate_2e09783f3d878c5e1ae29242c388f2a9 extends Template
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
        if ((($context["session_expired"] ?? null) == true)) {
            // line 2
            echo "    <div id=\"modalOverlay\">
";
        }
        // line 4
        echo "<div class=\"container";
        echo twig_escape_filter($this->env, ($context["add_class"] ?? null), "html", null, true);
        echo "\">
<div class=\"row\">
<div class=\"col-12\">
<a href=\"";
        // line 7
        echo twig_escape_filter($this->env, PhpMyAdmin\Core::linkURL("https://larable.dev/"), "html", null, true);
        echo "\" target=\"_blank\" rel=\"noopener noreferrer\" class=\"logo\">
<img src=\"themes/boodark-orange/img/larable_logo.png\" id=\"imLogo\" name=\"imLogo\" alt=\"Larable\" border=\"0\">
</a>

<noscript>
";
        // line 12
        echo $this->env->getFilter('error')->getCallable()(_gettext("Javascript must be enabled past this point!"));
        echo "
</noscript>

<div class=\"hide\" id=\"js-https-mismatch\">
";
        // line 16
        echo $this->env->getFilter('error')->getCallable()(_gettext("There is a mismatch between HTTPS indicated on the server and client. This can lead to a non working Larable or a security risk. Please fix your server configuration to indicate HTTPS properly."));
        echo "
</div>
";
    }

    public function getTemplateName()
    {
        return "login/header.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  65 => 16,  58 => 12,  50 => 7,  43 => 4,  39 => 2,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "login/header.twig", "D:\\Herd\\phpmyadmin\\templates\\login\\header.twig");
    }
}
