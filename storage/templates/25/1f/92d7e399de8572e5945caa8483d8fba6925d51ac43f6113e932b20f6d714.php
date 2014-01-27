<?php

/* BaseBlock.html.twig */
class __TwigTemplate_251f92d7e399de8572e5945caa8483d8fba6925d51ac43f6113e932b20f6d714 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'document_header' => array($this, 'block_document_header'),
            'document_title' => array($this, 'block_document_title'),
            'document_navbar' => array($this, 'block_document_navbar'),
            'document_content' => array($this, 'block_document_content'),
            'document_javascript' => array($this, 'block_document_javascript'),
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
    <div itemprop=\"breadcrumb\" class=\"navbar navbar-static-top\">
        <div class=\"container wrap\">
            <span class=\"navbar-brand\">";
        // line 14
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["config"]) ? $context["config"] : $this->getContext($context, "config")), "site_title"), "html", null, true);
        echo "</span>
            <span class=\"navbar-brand muted_font\">
                ";
        // line 16
        echo twig_escape_filter($this->env, (((twig_length_filter($this->env, $this->getAttribute((isset($context["config"]) ? $context["config"] : $this->getContext($context, "config")), "site_description")) > $this->getAttribute((isset($context["config"]) ? $context["config"] : $this->getContext($context, "config")), "decription_limit"))) ? ((twig_slice($this->env, $this->getAttribute((isset($context["config"]) ? $context["config"] : $this->getContext($context, "config")), "site_description"), 0, $this->getAttribute((isset($context["config"]) ? $context["config"] : $this->getContext($context, "config")), "decription_limit")) . "...")) : ($this->getAttribute((isset($context["config"]) ? $context["config"] : $this->getContext($context, "config")), "site_description"))), "html", null, true);
        echo "
            </span>

            <ul class=\"nav navbar-nav\">
                <li><a class=\"tooltip-bottom\" title=\"";
        // line 20
        echo gettext("Go to home");
        echo "\" href=\"";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["config"]) ? $context["config"] : $this->getContext($context, "config")), "full_url"), "html", null, true);
        echo "\"><i class=\"fa fa-home\"></i></a></li>
                <li><a class=\"tooltip-bottom\" title=\"";
        // line 21
        echo gettext("Rules");
        echo "\" href=\"";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["config"]) ? $context["config"] : $this->getContext($context, "config")), "full_url"), "html", null, true);
        echo "rules\"><i class=\"fa fa-asterisk\"></i></a></li>
                <li><a class=\"tooltip-bottom\" title=\"";
        // line 22
        echo gettext("SimPas repository on GitHub");
        echo "\" href=\"https://github.com/Macsch15/SimPas\" rel=\"nofollow\"><i class=\"fa fa-github\"></i></a></li>
                ";
        // line 23
        $this->displayBlock('document_navbar', $context, $blocks);
        // line 24
        echo "            </ul>
        </div>
    </div>

    <div class=\"container wrap wrap_content\">
        <noscript>
            <div class=\"alert alert-info\"><i class=\"fa fa-exclamation-triangle fa-lg\"></i> ";
        // line 30
        echo gettext("It is recommended to enable JavaScript. Without it, this page may don't work correctly.");
        echo "</div>
        </noscript>

        ";
        // line 33
        if ((twig_length_filter($this->env, $this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "engineErrors", array(), "method")) > 0)) {
            // line 34
            echo "            <div class=\"panel panel-danger\">
                <div class=\"panel-heading\">
                    ";
            // line 36
            $context["error_count"] = twig_length_filter($this->env, $this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "engineErrors", array(), "method"));
            // line 37
            echo "                    <h3 class=\"panel-title\"><i class=\"fa fa-exclamation-triangle fa-lg\"></i> ";
            echo strtr(gettext("An errors encountered! (%error_count%)"), array("%error_count%" => (isset($context["error_count"]) ? $context["error_count"] : $this->getContext($context, "error_count")), ));
            echo "</h3>
                </div>
                ";
            // line 39
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "engineErrors", array(), "method"));
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
            foreach ($context['_seq'] as $context["_key"] => $context["error_message"]) {
                // line 40
                echo "                        ";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["loop"]) ? $context["loop"] : $this->getContext($context, "loop")), "index"), "html", null, true);
                echo ". ";
                echo twig_escape_filter($this->env, (isset($context["error_message"]) ? $context["error_message"] : $this->getContext($context, "error_message")), "html", null, true);
                echo "<br />
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
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['error_message'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 42
            echo "            </div>
        ";
        }
        // line 44
        echo "
        ";
        // line 45
        $this->displayBlock('document_content', $context, $blocks);
        // line 46
        echo "    </div>
    
    <footer class=\"containter wrap copyright\">
        ";
        // line 49
        if ((twig_constant("Application\\Application::ENVIORMENT") == "dev")) {
            // line 50
            echo "            <div class=\"pull-left\">
                <i class=\"fa fa-cogs\"></i> SimPas utilised ";
            // line 51
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "getUtilisedMemory", array(), "method"), "html", null, true);
            echo "KB memory for this request<br />
                <div style=\"text-align: left\"><i class=\"fa fa-fire\"></i> GZIP Compression: ";
            // line 52
            echo (($this->getAttribute((isset($context["config"]) ? $context["config"] : $this->getContext($context, "config")), "gzip_compression")) ? ("On") : ("Off"));
            echo "</div>
            </div>
        ";
        }
        // line 55
        echo "
        <a href=\"http://www.macsch15.pl\">Powered by SimPas Application by Macsch15</a>
    </footer>

    ";
        // line 59
        $this->displayBlock('document_javascript', $context, $blocks);
        // line 96
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

    // line 23
    public function block_document_navbar($context, array $blocks = array())
    {
    }

    // line 45
    public function block_document_content($context, array $blocks = array())
    {
    }

    // line 59
    public function block_document_javascript($context, array $blocks = array())
    {
        // line 60
        echo "        <script src=\"";
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('assets')->getCallable(), array("js", "jquery-2.0.3.min.js")), "html", null, true);
        echo "\"></script>
        <script src=\"";
        // line 61
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('assets')->getCallable(), array("js", "bootstrap.min.js")), "html", null, true);
        echo "\"></script>
        <script src=\"";
        // line 62
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('assets')->getCallable(), array("js", "chosen.jquery.min.js")), "html", null, true);
        echo "\"></script>
        <script src=\"";
        // line 63
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('assets')->getCallable(), array("js", "simpas.js")), "html", null, true);
        echo "\"></script>
        <script src=\"";
        // line 64
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('assets')->getCallable(), array("js", "jquery.maxlength-min.js")), "html", null, true);
        echo "\"></script>
        <script src=\"";
        // line 65
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('assets')->getCallable(), array("js", "jquery.zclip.min.js")), "html", null, true);
        echo "\"></script>
        ";
        // line 66
        if ($this->getAttribute((isset($context["config"]) ? $context["config"] : $this->getContext($context, "config")), "social_icons")) {
            // line 67
            echo "        <script type=\"text/javascript\" src=\"http://w.sharethis.com/button/buttons.js\"></script>
        ";
        }
        // line 69
        echo "        <script>
            \$(function() {
                \$('a#zclip').zclip({
                    path: \"";
        // line 72
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('assets')->getCallable(), array("js", "ZeroClipboard.swf")), "html", null, true);
        echo "\",
                    copy: \$('pre#zclip_copy').text()
                });

                \$('#zclip').click(function () {
                    \$(this).addClass('disabled');
                    \$(this).html('<i class=\"fa fa-check\"></i> ";
        // line 78
        echo gettext("Copied to clipboard!");
        echo "');
                });

                \$(\".chzn-select\").chosen({no_results_text: \"";
        // line 81
        echo gettext("Oops, nothing found!");
        echo "\"});

                \$('#_chars_left').maxlength({    
                    maxCharacters: \"";
        // line 84
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["config"]) ? $context["config"] : $this->getContext($context, "config")), "max_chars"), "html", null, true);
        echo "\", 
                    status: true,  
                    statusClass: \"muted_font pull-right\",
                    statusText: \"";
        // line 87
        echo gettext("chars left");
        echo "\",
                    notificationClass: \"chars_left\"  
                });
            });
        </script>
        ";
        // line 92
        if ($this->getAttribute((isset($context["config"]) ? $context["config"] : $this->getContext($context, "config")), "social_icons")) {
            // line 93
            echo "        <script type=\"text/javascript\">stLight.options({publisher: \"ur-860239a-833d-b5c-fca1-5bcd8c993cbb\"});</script>
        ";
        }
        // line 95
        echo "    ";
    }

    public function getTemplateName()
    {
        return "BaseBlock.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  292 => 95,  288 => 93,  286 => 92,  278 => 87,  272 => 84,  266 => 81,  260 => 78,  251 => 72,  242 => 67,  236 => 65,  232 => 64,  228 => 63,  224 => 62,  220 => 61,  215 => 60,  212 => 59,  207 => 45,  202 => 23,  197 => 7,  191 => 8,  185 => 7,  179 => 5,  176 => 4,  171 => 96,  169 => 59,  163 => 55,  157 => 52,  153 => 51,  148 => 49,  143 => 46,  134 => 42,  115 => 40,  92 => 37,  90 => 36,  86 => 34,  84 => 33,  78 => 30,  70 => 24,  64 => 22,  52 => 20,  45 => 16,  40 => 14,  34 => 10,  27 => 2,  24 => 1,  254 => 67,  246 => 69,  240 => 66,  235 => 62,  233 => 61,  227 => 60,  223 => 58,  216 => 53,  214 => 52,  209 => 50,  206 => 49,  204 => 48,  198 => 45,  190 => 44,  182 => 43,  178 => 42,  175 => 41,  167 => 40,  165 => 39,  155 => 38,  152 => 37,  150 => 50,  147 => 35,  144 => 34,  141 => 45,  138 => 44,  135 => 31,  132 => 30,  125 => 28,  121 => 26,  107 => 25,  101 => 23,  98 => 39,  81 => 21,  75 => 18,  71 => 16,  68 => 23,  65 => 14,  61 => 12,  58 => 21,  50 => 9,  48 => 8,  41 => 7,  38 => 6,  35 => 5,  32 => 4,  29 => 3,);
    }
}
