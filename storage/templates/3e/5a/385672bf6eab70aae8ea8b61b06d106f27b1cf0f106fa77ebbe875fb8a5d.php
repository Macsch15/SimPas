<?php

/* SiteOffline.html.twig */
class __TwigTemplate_3e5a385672bf6eab70aae8ea8b61b06d106f27b1cf0f106fa77ebbe875fb8a5d extends Twig_Template
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
        echo "<!DOCTYPE html>
<html lang=\"";
        // line 2
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["config"]) ? $context["config"] : $this->getContext($context, "config")), "locale"), 0), "html", null, true);
        echo "\">
<head>
    <meta charset=\"";
        // line 4
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["config"]) ? $context["config"] : $this->getContext($context, "config")), "charset"), "html", null, true);
        echo "\">
    <title>";
        // line 5
        echo gettext("Site is currently offline");
        echo " - ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["config"]) ? $context["config"] : $this->getContext($context, "config")), "site_title"), "html", null, true);
        echo "</title>
    <link href=\"";
        // line 6
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('assets')->getCallable(), array("css", "bootstrap.min.css")), "html", null, true);
        echo "\" rel=\"stylesheet\" />
    <link href=\"";
        // line 7
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('assets')->getCallable(), array("css", "simpas.css")), "html", null, true);
        echo "\" rel=\"stylesheet\" />
    <link href=\"";
        // line 8
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('assets')->getCallable(), array("css", "foundation.min.css")), "html", null, true);
        echo "\" rel=\"stylesheet\" />
    <style>
        body {
            background: #EDEDED;
        }

        .panel {
            background: #fff;
            margin-top: 15px;
        }

        .label {
            font-size: 12px;
        }

        .application a {
            float: right !important;
            color: #A8A8A8;
            font-size: 11px;
            margin-bottom: 15px;
            text-decoration: none;
        }

        .application a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class=\"row\">
        <div class=\"panel\" style=\"border-radius: 0; box-shadow: none\">
            <h3 style=\"color: #808080\">";
        // line 39
        echo gettext("This site is currently offline");
        echo "</h3>
            ";
        // line 40
        $context["site_title"] = $this->getAttribute((isset($context["config"]) ? $context["config"] : $this->getContext($context, "config")), "site_title");
        // line 41
        echo "            <h6>
            ";
        // line 42
        if ((!twig_test_empty($this->getAttribute((isset($context["config"]) ? $context["config"] : $this->getContext($context, "config")), "offline_message")))) {
            // line 43
            echo "                ";
            if ((twig_slice($this->env, $this->getAttribute((isset($context["config"]) ? $context["config"] : $this->getContext($context, "config")), "offline_message"), (-11), null) == "~html_force")) {
                // line 44
                echo "                    ";
                $context["offline_message"] = twig_slice($this->env, $this->getAttribute((isset($context["config"]) ? $context["config"] : $this->getContext($context, "config")), "offline_message"), 0, (-11));
                // line 45
                echo "                    
                    ";
                // line 46
                echo (isset($context["offline_message"]) ? $context["offline_message"] : $this->getContext($context, "offline_message"));
                echo "
                ";
            } else {
                // line 48
                echo "                    ";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["config"]) ? $context["config"] : $this->getContext($context, "config")), "offline_message"), "html", null, true);
                echo "
                ";
            }
            // line 50
            echo "            ";
        } else {
            // line 51
            echo "                ";
            echo strtr(gettext("%site_title% is currently under maintenance. We be back later."), array("%site_title%" => (isset($context["site_title"]) ? $context["site_title"] : $this->getContext($context, "site_title")), ));
            // line 52
            echo "            ";
        }
        // line 53
        echo "            </h6>
        </div>

        <footer class=\"application\">
            <a href=\"http://www.macsch15.pl\">Powered by SimPas Application by Macsch15</a>
        </footer>
    </div>
</body>
</html>";
    }

    public function getTemplateName()
    {
        return "SiteOffline.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  119 => 53,  116 => 52,  113 => 51,  110 => 50,  104 => 48,  99 => 46,  96 => 45,  93 => 44,  90 => 43,  88 => 42,  85 => 41,  83 => 40,  79 => 39,  45 => 8,  41 => 7,  37 => 6,  31 => 5,  27 => 4,  22 => 2,  19 => 1,);
    }
}
