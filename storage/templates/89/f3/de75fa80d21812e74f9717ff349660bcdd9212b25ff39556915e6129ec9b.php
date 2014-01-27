<?php

/* ClientError.html.twig */
class __TwigTemplate_89f3de75fa80d21812e74f9717ff349660bcdd9212b25ff39556915e6129ec9b extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("BaseBlock.html.twig");

        $this->blocks = array(
            'document_title' => array($this, 'block_document_title'),
            'document_content' => array($this, 'block_document_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "BaseBlock.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_document_title($context, array $blocks = array())
    {
        // line 4
        echo "        ";
        echo gettext("An error encountered!");
        // line 5
        echo "    ";
    }

    // line 7
    public function block_document_content($context, array $blocks = array())
    {
        // line 8
        echo "        <div class=\"panel panel-warning\">
            <div class=\"panel-heading\">
                <h3 class=\"panel-title\"><i class=\"fa fa-exclamation-triangle fa-lg\"></i> ";
        // line 10
        echo gettext("An error encountered!");
        echo "</h3>
            </div>
            
            ";
        // line 13
        echo twig_escape_filter($this->env, (isset($context["error_message"]) ? $context["error_message"] : $this->getContext($context, "error_message")), "html", null, true);
        echo "
        </div>

        <a href=\"";
        // line 16
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["config"]) ? $context["config"] : $this->getContext($context, "config")), "full_url"), "html", null, true);
        echo "\" class=\"btn btn-primary\"><i class=\"fa fa-home\"></i> ";
        echo gettext("Return to index page");
        echo "</a>
    ";
    }

    public function getTemplateName()
    {
        return "ClientError.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  58 => 16,  52 => 13,  46 => 10,  42 => 8,  39 => 7,  35 => 5,  32 => 4,  29 => 3,);
    }
}
