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

/* display/export/options_output_save_dir.twig */
class __TwigTemplate_d71fc5323b886b8f3e6f7142767b27f4dafbececa4fd95631d3c7a69d477c56c extends \Twig\Template
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
        echo "<li>
    <input type=\"checkbox\" name=\"onserver\" value=\"saveit\"
        id=\"checkbox_dump_onserver\"";
        // line 3
        echo ((($context["export_is_checked"] ?? null)) ? (" checked") : (""));
        echo ">
    <label for=\"checkbox_dump_onserver\">
        ";
        // line 5
        echo sprintf(_gettext("Save on server in the directory <strong>%s</strong>"), twig_escape_filter($this->env, ($context["save_dir"] ?? null)));
        echo "
    </label>
</li>
<li>
    <input type=\"checkbox\" name=\"onserver_overwrite\"
        value=\"saveitover\" id=\"checkbox_dump_onserver_overwrite\"";
        // line 11
        echo ((($context["export_overwrite_is_checked"] ?? null)) ? (" checked") : (""));
        echo ">
    <label for=\"checkbox_dump_onserver_overwrite\">
        ";
        // line 13
        echo _gettext("Overwrite existing file(s)");
        // line 14
        echo "    </label>
</li>
";
    }

    public function getTemplateName()
    {
        return "display/export/options_output_save_dir.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  61 => 14,  59 => 13,  54 => 11,  46 => 5,  41 => 3,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "display/export/options_output_save_dir.twig", "/data/www/getheaven/public/phpmyadmin/templates/display/export/options_output_save_dir.twig");
    }
}
