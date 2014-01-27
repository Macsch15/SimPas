<?php

/* Embed.html.twig */
class __TwigTemplate_51cf7d01f1e943a5a56f271d3adfdeed3a32c104860879aa4ff169f3825ed137 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("BaseBlockBlank.html.twig");

        $this->blocks = array(
            'document_content' => array($this, 'block_document_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "BaseBlockBlank.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_document_content($context, array $blocks = array())
    {
        // line 4
        echo "    ";
        $context["paste_h4"] = (((twig_length_filter($this->env, $this->getAttribute((isset($context["paste"]) ? $context["paste"] : $this->getContext($context, "paste")), "unique_id")) > 10)) ? ((((("<span class=\"tooltip-top\" title=\"" . $this->getAttribute((isset($context["paste"]) ? $context["paste"] : $this->getContext($context, "paste")), "unique_id")) . "\">") . twig_slice($this->env, $this->getAttribute((isset($context["paste"]) ? $context["paste"] : $this->getContext($context, "paste")), "unique_id"), 0, 10)) . "...</span>")) : ($this->getAttribute((isset($context["paste"]) ? $context["paste"] : $this->getContext($context, "paste")), "unique_id")));
        // line 5
        echo "
    <h4 itemprop=\"name\">";
        // line 6
        echo gettext("Paste");
        echo " \"<a target=\"_blank\" href=\"";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["config"]) ? $context["config"] : $this->getContext($context, "config")), "full_url"), "html", null, true);
        echo "paste/";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["paste"]) ? $context["paste"] : $this->getContext($context, "paste")), "unique_id"), "html", null, true);
        echo "\">";
        echo (isset($context["paste_h4"]) ? $context["paste_h4"] : $this->getContext($context, "paste_h4"));
        echo "</a>\" ";
        echo gettext("by");
        echo " PasteAuthor&nbsp;&nbsp;
        <a href=\"#\" id=\"zclip\" class=\"btn btn-primary btn-sm\"><i class=\"fa fa-copy\"></i> ";
        // line 7
        echo gettext("Copy to clipboard");
        echo "</a>
        <a target=\"_blank\" href=\"";
        // line 8
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["config"]) ? $context["config"] : $this->getContext($context, "config")), "full_url"), "html", null, true);
        echo "raw/";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["paste"]) ? $context["paste"] : $this->getContext($context, "paste")), "unique_id"), "html", null, true);
        echo "\" class=\"btn btn-primary btn-sm\"><i class=\"fa fa-terminal\"></i> ";
        echo gettext("Raw mode");
        echo "</a>
        <a target=\"_blank\" href=\"";
        // line 9
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["config"]) ? $context["config"] : $this->getContext($context, "config")), "full_url"), "html", null, true);
        echo "download/";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["paste"]) ? $context["paste"] : $this->getContext($context, "paste")), "unique_id"), "html", null, true);
        echo "\" class=\"btn btn-primary btn-sm\"><i class=\"fa fa-download\"></i> ";
        echo gettext("Download");
        echo "</a>
    </h4>

    ";
        // line 12
        echo $this->getAttribute((isset($context["paste"]) ? $context["paste"] : $this->getContext($context, "paste")), "content");
        echo "

    <script src=\"";
        // line 14
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('assets')->getCallable(), array("js", "jquery-2.0.3.min.js")), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 15
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('assets')->getCallable(), array("js", "bootstrap.min.js")), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 16
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('assets')->getCallable(), array("js", "simpas.js")), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 17
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('assets')->getCallable(), array("js", "jquery.zclip.min.js")), "html", null, true);
        echo "\"></script>
    <script>
        \$(document).ready(function () {
            \$('a#zclip').zclip({
                path: \"";
        // line 21
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('assets')->getCallable(), array("js", "ZeroClipboard.swf")), "html", null, true);
        echo "\",
                copy: \$('pre#zclip_copy').text()
            });

            \$('#zclip').click(function () {
                \$(this).addClass('disabled');
                \$(this).html('<i class=\"fa fa-check\"></i> ";
        // line 27
        echo gettext("Copied to clipboard!");
        echo "');
            });
        });
    </script>

    <script>
        \$(function() {
            if(document.location.hash) {
                showLine();
            }

            \$('li').click(function() {
                \$('.line_active').removeClass('line_active');
                \$(this).addClass('line_active');
            });
        });

        function showLine() {
            var hashName = window.location.hash;
            var lineNumber = hashName.slice(6);

            \$('#line-' + lineNumber).addClass('line_active');
        }
    </script>
";
    }

    public function getTemplateName()
    {
        return "Embed.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  104 => 27,  95 => 21,  88 => 17,  84 => 16,  80 => 15,  76 => 14,  71 => 12,  61 => 9,  53 => 8,  49 => 7,  37 => 6,  34 => 5,  31 => 4,  28 => 3,);
    }
}
