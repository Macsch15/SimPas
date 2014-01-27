<?php

/* Exception.html.twig */
class __TwigTemplate_a75887d04c184e1ae621655a663159183146e4c319e076ac374b2b5d3eb63542 extends Twig_Template
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
        if ((twig_constant("Application\\Application::ENVIORMENT") == "dev")) {
            // line 7
            echo "            ";
            if ((!twig_test_empty((isset($context["type"]) ? $context["type"] : $this->getContext($context, "type"))))) {
                // line 8
                echo "                ";
                echo twig_escape_filter($this->env, (isset($context["type"]) ? $context["type"] : $this->getContext($context, "type")), "html", null, true);
                echo " exception detected!
            ";
            } else {
                // line 10
                echo "                Exception detected!
            ";
            }
            // line 11
            echo " - ";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["config"]) ? $context["config"] : $this->getContext($context, "config")), "site_title"), "html", null, true);
            echo "
        ";
        } else {
            // line 13
            echo "            500 Internal Server Error - ";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["config"]) ? $context["config"] : $this->getContext($context, "config")), "site_title"), "html", null, true);
            echo "
        ";
        }
        // line 15
        echo "    </title>
    ";
        // line 16
        if ((twig_constant("Application\\Application::ENVIORMENT") == "prod")) {
            echo "  
        <link href=\"";
            // line 17
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('assets')->getCallable(), array("css", "bootstrap.min.css")), "html", null, true);
            echo "\" rel=\"stylesheet\" />
        <link href=\"";
            // line 18
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('assets')->getCallable(), array("css", "simpas.css")), "html", null, true);
            echo "\" rel=\"stylesheet\" />
    ";
        }
        // line 20
        echo "    <link href=\"";
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
        // line 51
        if ((twig_constant("Application\\Application::ENVIORMENT") == "dev")) {
            // line 52
            echo "            <h3 style=\"color: #808080\">Exception detected! :C</h3>
            <div style=\"margin-left: 20px\">
                <h5>
                    ";
            // line 55
            echo (isset($context["message"]) ? $context["message"] : $this->getContext($context, "message"));
            echo "
                    <div style=\"text-align: right\">
                        <small>500 Internal Server Error &mdash; Exception ";
            // line 57
            echo twig_escape_filter($this->env, (isset($context["type"]) ? $context["type"] : $this->getContext($context, "type")), "html", null, true);
            echo "</small>
                    </div>
                </h5>
            </div>
            <hr />

            <h5>File</h5>
                <div style=\"margin-left: 20px\">
                    <h3>
                        <small>
                             ";
            // line 67
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["data"]) ? $context["data"] : $this->getContext($context, "data")), 2), "html", null, true);
            echo " at line ";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["data"]) ? $context["data"] : $this->getContext($context, "data")), 0), "html", null, true);
            echo "
                        </small>
                    </h3>
                </div>
                <div class=\"alert-box secondary\" style=\"border-radius:3px; background: #FAFAFA; padding: 0; font-size: 12px\">
                    <pre style=\"font-family:Consolas; overflow: auto\">";
            // line 72
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["lines"]) ? $context["lines"] : $this->getContext($context, "lines")));
            foreach ($context['_seq'] as $context["line"] => $context["content"]) {
                if (((isset($context["line"]) ? $context["line"] : $this->getContext($context, "line")) == $this->getAttribute((isset($context["data"]) ? $context["data"] : $this->getContext($context, "data")), 1))) {
                    echo "<span class=\"alert label\">";
                    echo twig_escape_filter($this->env, ((isset($context["line"]) ? $context["line"] : $this->getContext($context, "line")) + 1), "html", null, true);
                    echo "</span>";
                } else {
                    echo "<span class=\"secondary label\">";
                    echo twig_escape_filter($this->env, ((isset($context["line"]) ? $context["line"] : $this->getContext($context, "line")) + 1), "html", null, true);
                    echo "</span>";
                }
                if (((isset($context["line"]) ? $context["line"] : $this->getContext($context, "line")) == $this->getAttribute((isset($context["data"]) ? $context["data"] : $this->getContext($context, "data")), 1))) {
                    echo "<span class=\"alert label\" style=\"white-space: pre; background: #D63E41;\">";
                    echo twig_escape_filter($this->env, (isset($context["content"]) ? $context["content"] : $this->getContext($context, "content")), "html", null, true);
                    echo "</span><br />";
                } else {
                    echo twig_escape_filter($this->env, (isset($context["content"]) ? $context["content"] : $this->getContext($context, "content")), "html", null, true);
                }
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['line'], $context['content'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            echo "</pre>
                </div>

            <br />

            <h5>Stack Trace</h5>
            <code>
                ";
            // line 79
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["stacktrace"]) ? $context["stacktrace"] : $this->getContext($context, "stacktrace")));
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
            foreach ($context['_seq'] as $context["key"] => $context["value"]) {
                // line 80
                echo "                        <div style=\"margin-left: 20px\">
                            <span style=\"font-size: 41px; float:left; color: #808080; margin-right: 15px\">";
                // line 81
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["loop"]) ? $context["loop"] : $this->getContext($context, "loop")), "index"), "html", null, true);
                echo "</span>
                            File: ";
                // line 82
                if ($this->getAttribute((isset($context["value"]) ? $context["value"] : null), "file", array(), "any", true, true)) {
                    echo twig_escape_filter($this->env, $this->getAttribute((isset($context["value"]) ? $context["value"] : $this->getContext($context, "value")), "file"), "html", null, true);
                } else {
                    echo "-";
                }
                echo "<br />
                            Line: ";
                // line 83
                if ($this->getAttribute((isset($context["value"]) ? $context["value"] : null), "line", array(), "any", true, true)) {
                    echo twig_escape_filter($this->env, $this->getAttribute((isset($context["value"]) ? $context["value"] : $this->getContext($context, "value")), "line"), "html", null, true);
                } else {
                    echo "-";
                }
                echo "<br />
                            Class: ";
                // line 84
                if (($this->getAttribute((isset($context["value"]) ? $context["value"] : null), "class", array(), "any", true, true) && $this->getAttribute((isset($context["value"]) ? $context["value"] : null), "function", array(), "any", true, true))) {
                    echo twig_escape_filter($this->env, $this->getAttribute((isset($context["value"]) ? $context["value"] : $this->getContext($context, "value")), "class"), "html", null, true);
                    echo "::";
                    echo twig_escape_filter($this->env, $this->getAttribute((isset($context["value"]) ? $context["value"] : $this->getContext($context, "value")), "function"), "html", null, true);
                    echo "()";
                } else {
                    echo "-";
                }
                // line 85
                echo "                        </div>
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
            unset($context['_seq'], $context['_iterated'], $context['key'], $context['value'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 88
            echo "            </code>
            
        ";
        } else {
            // line 91
            echo "            <h3 style=\"color: #808080\">500 Internal Server Error</h3>
            ";
            // line 92
            if (($this->getAttribute($this->getAttribute((isset($context["stacktrace"]) ? $context["stacktrace"] : null), 0, array(), "any", false, true), "class", array(), "any", true, true) && $this->getAttribute($this->getAttribute((isset($context["stacktrace"]) ? $context["stacktrace"] : null), 0, array(), "any", false, true), "function", array(), "any", true, true))) {
                // line 93
                echo "                <h6>Exception in <code>";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["stacktrace"]) ? $context["stacktrace"] : $this->getContext($context, "stacktrace")), 0), "class"), "html", null, true);
                echo "::";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["stacktrace"]) ? $context["stacktrace"] : $this->getContext($context, "stacktrace")), 0), "function"), "html", null, true);
                echo "()</code></h6>
            ";
            }
            // line 95
            echo "
            ";
            // line 96
            if ((!twig_test_empty($this->getAttribute((isset($context["config"]) ? $context["config"] : $this->getContext($context, "config")), "admin_email")))) {
                // line 97
                echo "                <br />

                ";
                // line 99
                $context["admin_email"] = $this->getAttribute((isset($context["config"]) ? $context["config"] : $this->getContext($context, "config")), "admin_email");
                // line 100
                echo "                <em>";
                echo strtr(gettext("Please contact the administrator %admin_email% and report it about this error."), array("%admin_email%" => (isset($context["admin_email"]) ? $context["admin_email"] : $this->getContext($context, "admin_email")), ));
                echo "</em>

                <br />
            ";
            }
            // line 104
            echo "
            <br />

            <em>";
            // line 107
            echo gettext("More information about this exception are available in the error log.");
            echo "</em>
        ";
        }
        // line 109
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
        return "Exception.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  289 => 109,  284 => 107,  279 => 104,  271 => 100,  269 => 99,  265 => 97,  263 => 96,  260 => 95,  252 => 93,  250 => 92,  247 => 91,  242 => 88,  226 => 85,  217 => 84,  209 => 83,  201 => 82,  197 => 81,  194 => 80,  177 => 79,  145 => 72,  135 => 67,  122 => 57,  117 => 55,  112 => 52,  110 => 51,  75 => 20,  70 => 18,  66 => 17,  62 => 16,  59 => 15,  53 => 13,  47 => 11,  43 => 10,  37 => 8,  34 => 7,  32 => 6,  27 => 4,  22 => 2,  19 => 1,);
    }
}
