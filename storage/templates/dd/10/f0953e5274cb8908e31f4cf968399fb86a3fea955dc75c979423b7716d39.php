<?php

/* IndexBlock.html.twig */
class __TwigTemplate_dd10f0953e5274cb8908e31f4cf968399fb86a3fea955dc75c979423b7716d39 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("BaseBlock.html.twig");

        $this->blocks = array(
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
    public function block_document_content($context, array $blocks = array())
    {
        // line 4
        echo "        <form method=\"post\" action=\"";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["config"]) ? $context["config"] : $this->getContext($context, "config")), "full_url"), "html", null, true);
        echo "paste/";
        echo twig_escape_filter($this->env, (isset($context["paste_id"]) ? $context["paste_id"] : $this->getContext($context, "paste_id")), "html", null, true);
        echo "\">

            <div class=\"pull-left\" style=\"width: 49%; margin-right: 2%;\">
                <input type=\"text\" autocomplete=\"off\" name=\"post_paste_title\" pattern=\"[A-Za-z0-9";
        // line 7
        echo twig_escape_filter($this->env, (((!twig_test_empty($this->getAttribute((isset($context["config"]) ? $context["config"] : $this->getContext($context, "config")), "accented_characters")))) ? ($this->getAttribute((isset($context["config"]) ? $context["config"] : $this->getContext($context, "config")), "accented_characters")) : (null)), "html", null, true);
        echo "\\-_?!\\s]+\" maxlength=\"";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["config"]) ? $context["config"] : $this->getContext($context, "config")), "max_title_chars"), "html", null, true);
        echo "\" class=\"form-control\" placeholder=\"";
        echo gettext("Title (Optional)");
        echo "\" />
            </div>
            <div class=\"pull-left\" style=\"width: 49%\">
                <input type=\"text\" autocomplete=\"off\" name=\"post_paste_author\" pattern=\"[A-Za-z0-9";
        // line 10
        echo twig_escape_filter($this->env, (((!twig_test_empty($this->getAttribute((isset($context["config"]) ? $context["config"] : $this->getContext($context, "config")), "accented_characters")))) ? ($this->getAttribute((isset($context["config"]) ? $context["config"] : $this->getContext($context, "config")), "accented_characters")) : (null)), "html", null, true);
        echo "\\-_\\s]+\" maxlength=\"";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["config"]) ? $context["config"] : $this->getContext($context, "config")), "max_author_chars"), "html", null, true);
        echo "\" class=\"form-control\" placeholder=\"";
        echo gettext("Author (Optional)");
        echo "\" />
            </div>
            <br /><br />

            <h4 class=\"muted_font pull-left\"><i class=\"fa fa-code\"></i> ";
        // line 14
        echo gettext("Paste text or code in the field below");
        echo "</h4>
            <button type=\"button\" id=\"options\" data-toggle=\"popover\" data-placement=\"left\" style=\"margin-left: 6px\" title=\"";
        // line 15
        echo gettext("Pastebin options");
        echo "\" class=\"tooltip-top muted_font btn pull-right\"><i class=\"fa fa-plus\"></i></button>

            <div id=\"form_data\" class=\"hide\"></div>
            <div id=\"popover_content\" class=\"hide\">
                ";
        // line 19
        $this->env->loadTemplate("Options.html.twig")->display($context);
        // line 20
        echo "            </div>

            ";
        // line 22
        $context["max_chars"] = $this->getAttribute((isset($context["config"]) ? $context["config"] : $this->getContext($context, "config")), "max_chars");
        // line 23
        echo "            ";
        $context["max_size"] = $this->getAttribute((isset($context["config"]) ? $context["config"] : $this->getContext($context, "config")), "max_size");
        // line 24
        echo "            <span class=\"pull-right label label-default\"><i class=\"fa fa-info-circle\"></i> ";
        echo strtr(gettext("Maximum: %max_chars% chars / %max_size%KB"), array("%max_chars%" => (isset($context["max_chars"]) ? $context["max_chars"] : $this->getContext($context, "max_chars")), "%max_size%" => (isset($context["max_size"]) ? $context["max_size"] : $this->getContext($context, "max_size")), ));
        echo "</span>
        
            <textarea id=\"_chars_left\" style=\"height: 350px;\" required=\"required\" name=\"post_paste_content\" class=\"form-control\" placeholder=\"";
        // line 26
        echo gettext("Paste content (required)");
        echo "...\"></textarea>
            <br />

            <div class=\"col-lg-4 syntax_highlight_option pull-left\">
                <h4 class=\"muted_font\"><i class=\"fa fa-puzzle-piece\"></i> ";
        // line 30
        echo gettext("Syntax highlighting");
        echo "</h4>
                <select class=\"form-control chzn-select\" name=\"post_syntax_highlight_language\">
                    ";
        // line 32
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["geshi_languages"]) ? $context["geshi_languages"] : $this->getContext($context, "geshi_languages")));
        foreach ($context['_seq'] as $context["_key"] => $context["languages"]) {
            // line 33
            echo "                        <option value=\"";
            echo twig_escape_filter($this->env, (isset($context["languages"]) ? $context["languages"] : $this->getContext($context, "languages")), "html", null, true);
            echo "\"";
            echo (((twig_lower_filter($this->env, (isset($context["languages"]) ? $context["languages"] : $this->getContext($context, "languages"))) == twig_lower_filter($this->env, $this->getAttribute((isset($context["config"]) ? $context["config"] : $this->getContext($context, "config")), "default_geshi_language")))) ? (" selected=\"selected\"") : (""));
            echo ">";
            echo twig_escape_filter($this->env, (isset($context["languages"]) ? $context["languages"] : $this->getContext($context, "languages")), "html", null, true);
            echo "</option>
                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['languages'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 35
        echo "                </select>
            </div>

            <input type=\"hidden\" name=\"post_poked\" value=\"1\" />

            <div class=\"pull-right\">
                <h4 class=\"muted_font\"><i class=\"fa fa-save\"></i> ";
        // line 41
        echo gettext("Send this paste");
        echo "</h4>
                <button data-loading-text=\"";
        // line 42
        echo gettext("Sending...");
        echo "\" id=\"loading_button\" type=\"submit\" class=\"btn main_button\">";
        echo gettext("Paste it!");
        echo "</button>
            </div>
        </form>
    ";
    }

    public function getTemplateName()
    {
        return "IndexBlock.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  130 => 42,  126 => 41,  118 => 35,  105 => 33,  101 => 32,  96 => 30,  89 => 26,  83 => 24,  80 => 23,  78 => 22,  74 => 20,  72 => 19,  65 => 15,  61 => 14,  50 => 10,  40 => 7,  31 => 4,  28 => 3,);
    }
}
