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

/* navigation/main.twig */
class __TwigTemplate_6e5542b0b95442b7c1d2a1696ba484fb extends Template
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
        if ( !($context["is_ajax"] ?? null)) {
            // line 2
            echo "  <div id=\"pma_navigation\" class=\"d-print-none\" data-config-navigation-width=\"";
            echo twig_escape_filter($this->env, ($context["config_navigation_width"] ?? null), "html", null, true);
            echo "\">
    <div id=\"pma_navigation_resizer\"></div>
    <div id=\"pma_navigation_collapser\"></div>
    <div id=\"pma_navigation_content\">
      <div id=\"pma_navigation_header\">
        <style>
          #pmalogo { height: auto !important; padding: 2px 12px !important; text-align: center !important; }
          #imgpmalogo { width: 82% !important; max-width: 180px !important; height: auto !important; max-height: none !important; display: block !important; margin: 0 auto !important; }
        </style>

        ";
            // line 12
            if (twig_get_attribute($this->env, $this->source, ($context["logo"] ?? null), "is_displayed", [], "any", false, false, false, 12)) {
                // line 13
                echo "          <div id=\"pmalogo\">
            ";
                // line 14
                if (twig_get_attribute($this->env, $this->source, ($context["logo"] ?? null), "has_link", [], "any", false, false, false, 14)) {
                    // line 15
                    echo "              <a href=\"";
                    echo twig_escape_filter($this->env, ((twig_get_attribute($this->env, $this->source, ($context["logo"] ?? null), "link", [], "any", true, true, false, 15)) ? (_twig_default_filter(twig_get_attribute($this->env, $this->source, ($context["logo"] ?? null), "link", [], "any", false, false, false, 15), "#")) : ("#")), "html", null, true);
                    echo "\"";
                    echo twig_get_attribute($this->env, $this->source, ($context["logo"] ?? null), "attributes", [], "any", false, false, false, 15);
                    echo ">
            ";
                }
                // line 17
                echo "            ";
                if ( !twig_test_empty(twig_get_attribute($this->env, $this->source, ($context["logo"] ?? null), "source", [], "any", false, false, false, 17))) {
                    // line 18
                    echo "              <img id=\"imgpmalogo\" src=\"";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["logo"] ?? null), "source", [], "any", false, false, false, 18), "html", null, true);
                    echo "\" alt=\"Larable\">
            ";
                } else {
                    // line 20
                    echo "              <h1>Larable</h1>
            ";
                }
                // line 22
                echo "            ";
                if (twig_get_attribute($this->env, $this->source, ($context["logo"] ?? null), "has_link", [], "any", false, false, false, 22)) {
                    // line 23
                    echo "              </a>
            ";
                }
                // line 25
                echo "          </div>
        ";
            }
            // line 27
            echo "
        <div id=\"navipanellinks\">
          <a href=\"";
            // line 29
            echo PhpMyAdmin\Url::getFromRoute("/");
            echo "\" title=\"";
echo _gettext("Home");
            echo "\">";
            // line 30
            echo PhpMyAdmin\Html\Generator::getImage("b_home", _gettext("Home"));
            // line 31
            echo "</a>

          ";
            // line 33
            if ((($context["server"] ?? null) != 0)) {
                // line 34
                echo "            <a class=\"logout disableAjax\" href=\"";
                echo PhpMyAdmin\Url::getFromRoute("/logout");
                echo "\" title=\"";
                echo twig_escape_filter($this->env, (((($context["auth_type"] ?? null) == "config")) ? (_gettext("Empty session data")) : (_gettext("Log out"))), "html", null, true);
                echo "\">";
                // line 35
                echo PhpMyAdmin\Html\Generator::getImage("s_loggoff", (((($context["auth_type"] ?? null) == "config")) ? (_gettext("Empty session data")) : (_gettext("Log out"))));
                // line 36
                echo "</a>
          ";
            }
            // line 38
            echo "
          <a href=\"";
            // line 39
            echo PhpMyAdmin\Html\MySQLDocumentation::getDocumentationLink("index");
            echo "\" title=\"";
echo _gettext("Larable documentation");
            echo "\" target=\"_blank\" rel=\"noopener noreferrer\">";
            // line 40
            echo PhpMyAdmin\Html\Generator::getImage("b_docs", _gettext("Larable documentation"));
            // line 41
            echo "</a>

          <a href=\"";
            // line 43
            echo PhpMyAdmin\Util::getdocuURL(($context["is_mariadb"] ?? null));
            echo "\" title=\"";
            echo twig_escape_filter($this->env, ((($context["is_mariadb"] ?? null)) ? (_gettext("MariaDB Documentation")) : (_gettext("MySQL Documentation"))), "html", null, true);
            echo "\" target=\"_blank\" rel=\"noopener noreferrer\">";
            // line 44
            echo PhpMyAdmin\Html\Generator::getImage("b_sqlhelp", ((($context["is_mariadb"] ?? null)) ? (_gettext("MariaDB Documentation")) : (_gettext("MySQL Documentation"))));
            // line 45
            echo "</a>

          <a id=\"pma_navigation_settings_icon\"";
            // line 47
            echo (( !($context["is_navigation_settings_enabled"] ?? null)) ? (" class=\"hide\"") : (""));
            echo " href=\"#\" title=\"";
echo _gettext("Navigation panel settings");
            echo "\">";
            // line 48
            echo PhpMyAdmin\Html\Generator::getImage("s_cog", _gettext("Navigation panel settings"));
            // line 49
            echo "</a>

          <a id=\"pma_navigation_reload\" href=\"#\" title=\"";
echo _gettext("Reload navigation panel");
            // line 51
            echo "\">";
            // line 52
            echo PhpMyAdmin\Html\Generator::getImage("s_reload", _gettext("Reload navigation panel"));
            // line 53
            echo "</a>
        </div>

        ";
            // line 56
            if ((($context["is_servers_displayed"] ?? null) && (twig_length_filter($this->env, ($context["servers"] ?? null)) > 1))) {
                // line 57
                echo "          <div id=\"serverChoice\">
            ";
                // line 58
                echo ($context["server_select"] ?? null);
                echo "
          </div>
        ";
            }
            // line 61
            echo "
        ";
            // line 62
            echo PhpMyAdmin\Html\Generator::getImage("ajax_clock_small", _gettext("Loading…"), ["style" => "visibility: hidden; display:none", "class" => "throbber"]);
            // line 65
            echo "
      </div>
      <div id=\"pma_navigation_tree\" class=\"list_container";
            // line 67
            echo ((($context["is_synced"] ?? null)) ? (" synced") : (""));
            echo ((($context["is_highlighted"] ?? null)) ? (" highlight") : (""));
            echo ((($context["is_autoexpanded"] ?? null)) ? (" autoexpand") : (""));
            echo "\">
";
        }
        // line 69
        echo "
";
        // line 70
        if ( !($context["navigation_tree"] ?? null)) {
            // line 71
            echo "  ";
            echo $this->env->getFilter('error')->getCallable()(_gettext("An error has occurred while loading the navigation display"));
            echo "
";
        } else {
            // line 73
            echo "  ";
            echo ($context["navigation_tree"] ?? null);
            echo "
";
        }
        // line 75
        echo "
";
        // line 76
        if ( !($context["is_ajax"] ?? null)) {
            // line 77
            echo "      </div>

      <div id=\"pma_navi_settings_container\">
        ";
            // line 80
            if (($context["is_navigation_settings_enabled"] ?? null)) {
                // line 81
                echo "          ";
                echo ($context["navigation_settings"] ?? null);
                echo "
        ";
            }
            // line 83
            echo "      </div>
    </div>

    ";
            // line 86
            if (($context["is_drag_drop_import_enabled"] ?? null)) {
                // line 87
                echo "      <div class=\"pma_drop_handler\">
        ";
echo _gettext("Drop files here");
                // line 89
                echo "      </div>
      <div class=\"pma_sql_import_status\">
        <h2>
          ";
echo _gettext("SQL upload");
                // line 93
                echo "          ( <span class=\"pma_import_count\">0</span> )
          <span class=\"close\">x</span>
          <span class=\"minimize\">-</span>
        </h2>
        <div></div>
      </div>
    ";
            }
            // line 100
            echo "  </div>
  ";
            // line 101
            echo twig_include($this->env, $context, "modals/unhide_nav_item.twig");
            echo "
  ";
            // line 102
            echo twig_include($this->env, $context, "modals/create_view.twig");
            echo "
";
        }
    }

    public function getTemplateName()
    {
        return "navigation/main.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  262 => 102,  258 => 101,  255 => 100,  246 => 93,  240 => 89,  236 => 87,  234 => 86,  229 => 83,  223 => 81,  221 => 80,  216 => 77,  214 => 76,  211 => 75,  205 => 73,  199 => 71,  197 => 70,  194 => 69,  187 => 67,  183 => 65,  181 => 62,  178 => 61,  172 => 58,  169 => 57,  167 => 56,  162 => 53,  160 => 52,  158 => 51,  153 => 49,  151 => 48,  146 => 47,  142 => 45,  140 => 44,  135 => 43,  131 => 41,  129 => 40,  124 => 39,  121 => 38,  117 => 36,  115 => 35,  109 => 34,  107 => 33,  103 => 31,  101 => 30,  96 => 29,  92 => 27,  88 => 25,  84 => 23,  81 => 22,  77 => 20,  71 => 18,  68 => 17,  60 => 15,  58 => 14,  55 => 13,  53 => 12,  39 => 2,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "navigation/main.twig", "D:\\Herd\\phpmyadmin\\templates\\navigation\\main.twig");
    }
}
