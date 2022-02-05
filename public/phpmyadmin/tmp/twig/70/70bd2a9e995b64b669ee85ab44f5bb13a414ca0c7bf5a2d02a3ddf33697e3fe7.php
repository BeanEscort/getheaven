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

/* display/export/template_options.twig */
class __TwigTemplate_fdc64d6448e28a4c01a455e011904e6918ede2f69615f965c189bf456e360741 extends \Twig\Template
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
        echo "<option value=\"\">-- ";
        echo _gettext("Select a template");
        echo " --</option>

";
        // line 3
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["templates"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["template"]) {
            // line 4
            echo "    <option value=\"";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["template"], "id", [], "any", false, false, false, 4), "html", null, true);
            echo "\"";
            echo (((twig_get_attribute($this->env, $this->source, $context["template"], "id", [], "any", false, false, false, 4) == ($context["selected_template"] ?? null))) ? (" selected") : (""));
            echo ">
        ";
            // line 5
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["template"], "name", [], "any", false, false, false, 5), "html", null, true);
            echo "
    </option>
";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['template'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
    }

    public function getTemplateName()
    {
        return "display/export/template_options.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  54 => 5,  47 => 4,  43 => 3,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "display/export/template_options.twig", "/data/www/getheaven/public/phpmyadmin/templates/display/export/template_options.twig");
    }
}
