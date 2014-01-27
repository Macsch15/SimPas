<?php

/* ForbiddenResponse404.html.twig */
class __TwigTemplate_2409fe9c5a98f961b84f5780e44deb0bea6d1f9adfef6868eb5e3224c3b2339d extends Twig_Template
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
    <title>
        ";
        // line 6
        if (((twig_constant("Application\\Application::ENVIORMENT") == "dev") && twig_length_filter($this->env, (isset($context["routes"]) ? $context["routes"] : $this->getContext($context, "routes"))))) {
            // line 7
            echo "            Route not found - ";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["config"]) ? $context["config"] : $this->getContext($context, "config")), "site_title"), "html", null, true);
            echo "
        ";
        } else {
            // line 9
            echo "            404 Page not found - ";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["config"]) ? $context["config"] : $this->getContext($context, "config")), "site_title"), "html", null, true);
            echo "
        ";
        }
        // line 11
        echo "    </title>
    ";
        // line 12
        if (((twig_constant("Application\\Application::ENVIORMENT") == "prod") || (!twig_length_filter($this->env, (isset($context["routes"]) ? $context["routes"] : $this->getContext($context, "routes")))))) {
            echo "  
        <link href=\"";
            // line 13
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('assets')->getCallable(), array("css", "bootstrap.min.css")), "html", null, true);
            echo "\" rel=\"stylesheet\" />
        <link href=\"";
            // line 14
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('assets')->getCallable(), array("css", "simpas.css")), "html", null, true);
            echo "\" rel=\"stylesheet\" />
    ";
        }
        // line 16
        echo "    
    <link href=\"";
        // line 17
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
        ";
        // line 48
        if (((twig_constant("Application\\Application::ENVIORMENT") == "dev") && twig_length_filter($this->env, (isset($context["routes"]) ? $context["routes"] : $this->getContext($context, "routes"))))) {
            // line 49
            echo "            <h3 style=\"color: #808080\">Route not found</h3>
            <div style=\"margin-left: 20px\">
                <h5>
                    Route for <code>";
            // line 52
            echo twig_escape_filter($this->env, (isset($context["requested_url"]) ? $context["requested_url"] : $this->getContext($context, "requested_url")), "html", null, true);
            echo "</code> not found
                    <div style=\"text-align: right\">
                        <small>404 Page not found</small>
                    </div>
                </h5>
            </div>
            <hr />
            <h5>List of routes</h5>
            <code>
                ";
            // line 61
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["routes"]) ? $context["routes"] : $this->getContext($context, "routes")));
            $context['loop'] = array(
              'parent' => $context['_parent'],
              'index0' => 0,
              'index'  => 1,
              'first'  => true,
            );
            if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof Countable)) {
                $length = count($context['_seq']);
                $context['loop']['revindex0'] = $length - 1;
                $context['loop']['revindex'] = $length;
                $context['loop']['length'] = $length;
                $context['loop']['last'] = 1 === $length;
            }
            foreach ($context['_seq'] as $context["_key"] => $context["route"]) {
                // line 62
                echo "                    <div style=\"margin-left: 20px\">
                        <span style=\"font-size: 41px; float:left; color: #808080; margin-right: 15px\">";
                // line 63
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["loop"]) ? $context["loop"] : $this->getContext($context, "loop")), "index"), "html", null, true);
                echo "</span> 
                            ";
                // line 64
                echo twig_escape_filter($this->env, ((($this->getAttribute((isset($context["route"]) ? $context["route"] : $this->getContext($context, "route")), "route_name") == "/")) ? (($this->getAttribute((isset($context["route"]) ? $context["route"] : $this->getContext($context, "route")), "route_name") . " (Index)")) : ($this->getAttribute((isset($context["route"]) ? $context["route"] : $this->getContext($context, "route")), "route_name"))), "html", null, true);
                echo "<br />
                            ";
                // line 65
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["route"]) ? $context["route"] : $this->getContext($context, "route")), "route_data"), "controller"), "html", null, true);
                echo "::";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["route"]) ? $context["route"] : $this->getContext($context, "route")), "route_data"), "action"), "html", null, true);
                echo "Action()<br />
                            Static: ";
                // line 66
                echo twig_escape_filter($this->env, ((($this->getAttribute($this->getAttribute((isset($context["route"]) ? $context["route"] : null), "route_data", array(), "any", false, true), "static", array(), "any", true, true) && ($this->getAttribute($this->getAttribute((isset($context["route"]) ? $context["route"] : $this->getContext($context, "route")), "route_data"), "static") == true))) ? (($this->getAttribute($this->getAttribute((isset($context["route"]) ? $context["route"] : null), "route_data", array(), "any", false, true), "static", array(), "any", true, true) && ($this->getAttribute($this->getAttribute((isset($context["route"]) ? $context["route"] : $this->getContext($context, "route")), "route_data"), "static") == true))) : (0)), "html", null, true);
                echo "
                    </div>
                    <hr />
                ";
                ++$context['loop']['index0'];
                ++$context['loop']['index'];
                $context['loop']['first'] = false;
                if (isset($context['loop']['length'])) {
                    --$context['loop']['revindex0'];
                    --$context['loop']['revindex'];
                    $context['loop']['last'] = 0 === $context['loop']['revindex0'];
                }
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['route'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 70
            echo "            </code>
        ";
        } else {
            // line 72
            echo "            <h3 style=\"color: #808080\">";
            echo gettext("404 Page not found");
            echo "</h3>
            <h6>";
            // line 73
            echo gettext("SimPas couldn't locate the page you're requesting to view");
            echo "</h6><br />
            <a href=\"";
            // line 74
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["config"]) ? $context["config"] : $this->getContext($context, "config")), "full_url"), "html", null, true);
            echo "\" class=\"btn btn-primary\"><i class=\"fa fa-home\"></i> ";
            echo gettext("Return to index page");
            echo "</a>
        ";
        }
        // line 76
        echo "        </div>

        <footer class=\"application\">
            <a href=\"http://www.macsch15.pl\">Powered by SimPas Application by Macsch15</a>
        </footer>
    </div>
</body>
</html>";
    }

    public function getTemplateName()
    {
        return "ForbiddenResponse404.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  190 => 76,  183 => 74,  179 => 73,  174 => 72,  170 => 70,  152 => 66,  146 => 65,  142 => 64,  138 => 63,  135 => 62,  118 => 61,  106 => 52,  101 => 49,  99 => 48,  65 => 17,  62 => 16,  57 => 14,  53 => 13,  49 => 12,  46 => 11,  40 => 9,  34 => 7,  32 => 6,  27 => 4,  22 => 2,  19 => 1,);
    }
}
