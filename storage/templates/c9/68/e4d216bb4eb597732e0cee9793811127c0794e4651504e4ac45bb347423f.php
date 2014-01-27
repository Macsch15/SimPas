<?php

/* BaseBlockBlank.html.twig */
class __TwigTemplate_c968e4d216bb4eb597732e0cee9793811127c0794e4651504e4ac45bb347423f extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'document_header' => array($this, 'block_document_header'),
            'document_title' => array($this, 'block_document_title'),
            'document_content' => array($this, 'block_document_content'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html lang=\"";
        // line 2
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : $this->getContext($context, "config")), "locale"), 0), "html", null, true);
        echo "\">
<head>
    ";
        // line 4
        $this->displayBlock('document_header', $context, $blocks);
        // line 10
        echo "</head>
<body itemscope itemtype=\"http://schema.org/WebPage\">
    ";
        // line 12
        $this->displayBlock('document_content', $context, $blocks);
        // line 13
        echo "</body>
</html>";
    }

    // line 4
    public function block_document_header($context, array $blocks = array())
    {
        // line 5
        echo "        <meta charset=\"";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["config"]) ? $context["config"] : $this->getContext($context, "config")), "charset"), "html", null, true);
        echo "\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
        <title>";
        // line 7
        $this->displayBlock('document_title', $context, $blocks);
        echo (((!twig_test_empty($this->renderBlock("document_title", $context, $blocks)))) ? (" - ") : (null));
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["config"]) ? $context["config"] : $this->getContext($context, "config")), "site_title"), "html", null, true);
        echo "</title>
        <link href=\"";
        // line 8
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('assets')->getCallable(), array("css", "simpas.css")), "html", null, true);
        echo "\" rel=\"stylesheet\" />
    ";
    }

    // line 7
    public function block_document_title($context, array $blocks = array())
    {
    }

    // line 12
    public function block_document_content($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "BaseBlockBlank.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  69 => 12,  64 => 7,  58 => 8,  52 => 7,  46 => 5,  43 => 4,  38 => 13,  36 => 12,  32 => 10,  30 => 4,  25 => 2,  22 => 1,  104 => 27,  95 => 21,  88 => 17,  84 => 16,  80 => 15,  76 => 14,  71 => 12,  61 => 9,  53 => 8,  49 => 7,  37 => 6,  34 => 5,  31 => 4,  28 => 3,);
    }
}
