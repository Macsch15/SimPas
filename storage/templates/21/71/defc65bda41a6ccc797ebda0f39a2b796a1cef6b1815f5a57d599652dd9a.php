<?php

/* ReadPaste.html.twig */
class __TwigTemplate_2171defc65bda41a6ccc797ebda0f39a2b796a1cef6b1815f5a57d599652dd9a extends Twig_Template
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
        ob_start();
        // line 5
        echo "            (";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["paste"]) ? $context["paste"] : $this->getContext($context, "paste")), "syntax"), "html", null, true);
        echo ") ";
        echo twig_escape_filter($this->env, (((!twig_test_empty($this->getAttribute((isset($context["paste"]) ? $context["paste"] : $this->getContext($context, "paste")), "title")))) ? ($this->getAttribute((isset($context["paste"]) ? $context["paste"] : $this->getContext($context, "paste")), "title")) : ($this->getAttribute((isset($context["paste"]) ? $context["paste"] : $this->getContext($context, "paste")), "unique_id"))), "html", null, true);
        echo "
            ";
        // line 6
        if ((!twig_test_empty($this->getAttribute((isset($context["paste"]) ? $context["paste"] : $this->getContext($context, "paste")), "author")))) {
            // line 7
            echo "                ";
            echo gettext("by");
            echo " ";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["paste"]) ? $context["paste"] : $this->getContext($context, "paste")), "author"), "html", null, true);
            echo "
            ";
        }
        // line 9
        echo "        ";
        echo trim(preg_replace('/>\s+</', '><', ob_get_clean()));
        // line 10
        echo "    ";
    }

    // line 12
    public function block_document_content($context, array $blocks = array())
    {
        // line 13
        echo "        ";
        if ((!twig_test_empty($this->getAttribute((isset($context["paste"]) ? $context["paste"] : $this->getContext($context, "paste")), "title")))) {
            // line 14
            echo "            ";
            $context["paste_title"] = $this->getAttribute((isset($context["paste"]) ? $context["paste"] : $this->getContext($context, "paste")), "title");
            // line 15
            echo "        ";
        } else {
            // line 16
            echo "            ";
            $context["paste_title"] = $this->getAttribute((isset($context["paste"]) ? $context["paste"] : $this->getContext($context, "paste")), "unique_id");
            // line 17
            echo "        ";
        }
        // line 18
        echo "
        ";
        // line 19
        $context["paste_h4"] = (((twig_length_filter($this->env, (isset($context["paste_title"]) ? $context["paste_title"] : $this->getContext($context, "paste_title"))) > 30)) ? ((((("<span class=\"tooltip-top\" title=\"" . (isset($context["paste_title"]) ? $context["paste_title"] : $this->getContext($context, "paste_title"))) . "\">") . twig_slice($this->env, (isset($context["paste_title"]) ? $context["paste_title"] : $this->getContext($context, "paste_title")), 0, 25)) . "...</span>")) : ((isset($context["paste_title"]) ? $context["paste_title"] : $this->getContext($context, "paste_title"))));
        // line 20
        echo "
        <h4 itemprop=\"name\">";
        // line 21
        echo gettext("Paste");
        echo " &quot;<a href=\"";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["config"]) ? $context["config"] : $this->getContext($context, "config")), "full_url"), "html", null, true);
        echo "paste/";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["paste"]) ? $context["paste"] : $this->getContext($context, "paste")), "unique_id"), "html", null, true);
        echo "\">";
        echo (isset($context["paste_h4"]) ? $context["paste_h4"] : $this->getContext($context, "paste_h4"));
        echo "</a>&quot; 
            ";
        // line 22
        if ((!twig_test_empty($this->getAttribute((isset($context["paste"]) ? $context["paste"] : $this->getContext($context, "paste")), "author")))) {
            // line 23
            echo "                ";
            echo gettext("by");
            echo " ";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["paste"]) ? $context["paste"] : $this->getContext($context, "paste")), "author"), "html", null, true);
            echo "
            ";
        }
        // line 24
        echo "&nbsp;
            <a href=\"#\" id=\"zclip\" class=\"btn btn-primary btn-sm\"><i class=\"fa fa-copy\"></i> ";
        // line 25
        echo gettext("Copy to clipboard");
        echo "</a>
            <a href=\"";
        // line 26
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["config"]) ? $context["config"] : $this->getContext($context, "config")), "full_url"), "html", null, true);
        echo "raw/";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["paste"]) ? $context["paste"] : $this->getContext($context, "paste")), "unique_id"), "html", null, true);
        echo "\" class=\"btn btn-primary btn-sm\"><i class=\"fa fa-terminal\"></i> ";
        echo gettext("Raw mode");
        echo "</a>
            <a href=\"";
        // line 27
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["config"]) ? $context["config"] : $this->getContext($context, "config")), "full_url"), "html", null, true);
        echo "download/";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["paste"]) ? $context["paste"] : $this->getContext($context, "paste")), "unique_id"), "html", null, true);
        echo "\" class=\"btn btn-primary btn-sm\"><i class=\"fa fa-download\"></i> ";
        echo gettext("Download");
        echo "</a>
            <a data-toggle=\"modal\" href=\"#share\" class=\"btn btn-primary btn-sm\"><i class=\"fa fa-share\"></i> ";
        // line 28
        echo gettext("Share");
        echo "</a>
        </h4>

        ";
        // line 31
        $this->env->loadTemplate("ShareModal.html.twig")->display($context);
        // line 32
        echo "            
        ";
        // line 33
        echo $this->getAttribute((isset($context["paste"]) ? $context["paste"] : $this->getContext($context, "paste")), "content");
        echo "
            
        ";
        // line 35
        if ($this->getAttribute((isset($context["config"]) ? $context["config"] : $this->getContext($context, "config")), "social_icons")) {
            // line 36
            echo "            <span class=\"st_email\" displayText=\"E-mail\"></span>
            <span class=\"st_twitter\" displayText=\"Tweet\"></span>
            <span class=\"st_facebook\" displayText=\"Facebook\"></span>
            <span class=\"st_googleplus\" displayText=\"Google+\"></span>
        ";
        }
        // line 41
        echo "
        <div class=\"pull-right\">
            <small class=\"muted_font\">";
        // line 43
        echo gettext("Submitted");
        echo " ";
        echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute((isset($context["paste"]) ? $context["paste"] : $this->getContext($context, "paste")), "time"), "d.m.Y"), "html", null, true);
        echo "&nbsp;&nbsp;</small>
            ";
        // line 44
        $context["paste_size"] = ($this->getAttribute((isset($context["paste"]) ? $context["paste"] : $this->getContext($context, "paste")), "size") / 1024);
        // line 45
        echo "            <span class=\"label label-default\"><i class=\"fa fa-hdd-o\"></i> ";
        echo twig_escape_filter($this->env, twig_round((isset($context["paste_size"]) ? $context["paste_size"] : $this->getContext($context, "paste_size")), 0, "ceil"), "html", null, true);
        echo "KB</span>
            <span class=\"label label-default\"><i class=\"fa fa-list-ol\"></i> ";
        // line 46
        echo gettext("Characters");
        echo ": ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["paste"]) ? $context["paste"] : $this->getContext($context, "paste")), "length"), "html", null, true);
        echo "</span>
            <span title=\"";
        // line 47
        echo gettext("Syntax highlighting");
        echo "\" class=\"tooltip-top label label-default\"><i class=\"fa fa-puzzle-piece\"></i> ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["paste"]) ? $context["paste"] : $this->getContext($context, "paste")), "syntax"), "html", null, true);
        echo "</span>
        </div>
    ";
    }

    public function getTemplateName()
    {
        return "ReadPaste.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  176 => 47,  170 => 46,  165 => 45,  163 => 44,  157 => 43,  153 => 41,  146 => 36,  144 => 35,  139 => 33,  136 => 32,  134 => 31,  128 => 28,  120 => 27,  112 => 26,  108 => 25,  105 => 24,  97 => 23,  95 => 22,  85 => 21,  82 => 20,  80 => 19,  77 => 18,  74 => 17,  71 => 16,  68 => 15,  65 => 14,  62 => 13,  59 => 12,  55 => 10,  52 => 9,  44 => 7,  42 => 6,  35 => 5,  32 => 4,  29 => 3,);
    }
}
