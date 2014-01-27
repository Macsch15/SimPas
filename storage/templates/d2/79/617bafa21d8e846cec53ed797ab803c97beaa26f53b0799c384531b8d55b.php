<?php

/* Options.html.twig */
class __TwigTemplate_d279617bafa21d8e846cec53ed797ab803c97beaa26f53b0799c384531b8d55b extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<div class=\"checkbox\">
    <label>
        <input class=\"checkbox\" value=\"1\" checked=\"checked\" name=\"post_checkbox_line_numbering\" type=\"checkbox\"> ";
        // line 3
        echo gettext("Line numbering");
        // line 4
        echo "    </label>
</div>
<hr />
<label>
    <div class=\"col-xs-2\">
        ";
        // line 9
        echo gettext("Start from line");
        echo " 
        <div class=\"col-xs-2\">
            <input type=\"text\" pattern=\"\\d+\" autocomplete=\"off\" class=\"form-control col-md-5\" name=\"post_start_from_line\" placeholder=\"";
        // line 11
        echo gettext("Enter number...");
        echo "\">
        </div>
    </div>
</label>";
    }

    public function getTemplateName()
    {
        return "Options.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  37 => 11,  32 => 9,  25 => 4,  23 => 3,  19 => 1,);
    }
}
