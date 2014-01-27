<?php

/* GeneratedLinksModal.html.twig */
class __TwigTemplate_444a81b6dacbee6cbf131ff02da2a5c12972fda0ad843839ae7453da44b25628 extends Twig_Template
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
        echo "    <div class=\"modal fade\" id=\"generatedLinks\" tabindex=\"-1\" role=\"dialog\" aria-hidden=\"true\">
        <div class=\"modal-dialog\">
            <div class=\"modal-content\">
                <div class=\"modal-header\">
                    <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">&times;</button>
                    <h4 class=\"modal-title\">";
        // line 6
        echo gettext("Share this paste");
        echo "</h4>
                </div>

                <div class=\"modal-body\">
                    <div class=\"input-group\" style=\"width: 100%\">
                        <span class=\"input-group-addon tooltip-top\" title=\"";
        // line 11
        echo gettext("BBCode");
        echo "\" style=\"max-width: 90px\"><i class=\"fa fa-align-left\"></i></span>
                        <input onclick=\"this.select();\" class=\"form-control input-lg\" type=\"text\" 
                            value=\"[url=";
        // line 13
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["config"]) ? $context["config"] : $this->getContext($context, "config")), "full_url"), "html", null, true);
        echo "paste/";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["paste"]) ? $context["paste"] : $this->getContext($context, "paste")), "id"), "html", null, true);
        echo "]";
        echo gettext("Paste");
        echo " ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["paste"]) ? $context["paste"] : $this->getContext($context, "paste")), "id"), "html", null, true);
        echo "[/url]\" />
                    </div><br />
                    <div class=\"input-group\" style=\"width: 100%\">
                        <span class=\"input-group-addon tooltip-top\" title=\"";
        // line 16
        echo gettext("Direct link");
        echo "\" style=\"max-width: 90px\"><i class=\"fa fa-link\"></i></span>
                        <input onclick=\"this.select();\" class=\"form-control input-lg\" type=\"text\" 
                            value=\"";
        // line 18
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["config"]) ? $context["config"] : $this->getContext($context, "config")), "full_url"), "html", null, true);
        echo "paste/";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["paste"]) ? $context["paste"] : $this->getContext($context, "paste")), "id"), "html", null, true);
        echo "\" />
                    </div><br />
                    <div class=\"input-group\" style=\"width: 100%\">
                        <span class=\"tooltip-top input-group-addon\" title=\"";
        // line 21
        echo gettext("HTML");
        echo "\" style=\"max-width: 90px\"><i class=\"fa fa-code\"></i></span>
                        <input onclick=\"this.select();\" class=\"form-control input-lg\" type=\"text\" 
                            value='<a href=\"";
        // line 23
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["config"]) ? $context["config"] : $this->getContext($context, "config")), "full_url"), "html", null, true);
        echo "paste/";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["paste"]) ? $context["paste"] : $this->getContext($context, "paste")), "id"), "html", null, true);
        echo "\">";
        echo gettext("Paste");
        echo " ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["paste"]) ? $context["paste"] : $this->getContext($context, "paste")), "id"), "html", null, true);
        echo "</a>' />
                    </div><br />
                    <div class=\"input-group\" style=\"width: 100%\">
                        <span class=\"input-group-addon tooltip-top\" title=\"";
        // line 26
        echo gettext("Markdown");
        echo "\" style=\"max-width: 90px\"><i class=\"fa fa-list\"></i></span>
                        <input onclick=\"this.select();\" class=\"form-control input-lg\" type=\"text\" 
                            value=\"[";
        // line 28
        echo gettext("Paste");
        echo " ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["paste"]) ? $context["paste"] : $this->getContext($context, "paste")), "id"), "html", null, true);
        echo "](";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["config"]) ? $context["config"] : $this->getContext($context, "config")), "full_url"), "html", null, true);
        echo "paste/";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["paste"]) ? $context["paste"] : $this->getContext($context, "paste")), "id"), "html", null, true);
        echo ")\" />
                    </div>
                </div>

                <div class=\"modal-footer\">
                    <div class=\"btn-group pull-left\">
                        <a title=\"";
        // line 34
        echo gettext("Share on Twitter");
        echo "\" href=\"http://twitter.com/share?url=";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["config"]) ? $context["config"] : $this->getContext($context, "config")), "full_url"), "html", null, true);
        echo "paste/";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["paste"]) ? $context["paste"] : $this->getContext($context, "paste")), "id"), "html", null, true);
        echo "\" rel=\"nofollow\" class=\"btn btn-primary tooltip-top\"><i class=\"fa fa-twitter fa-lg\"></i></a>

                        <a title=\"";
        // line 36
        echo gettext("Share on Google+");
        echo "\" href=\"https://plus.google.com/share?url=";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["config"]) ? $context["config"] : $this->getContext($context, "config")), "full_url"), "html", null, true);
        echo "paste/";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["paste"]) ? $context["paste"] : $this->getContext($context, "paste")), "id"), "html", null, true);
        echo "\" rel=\"nofollow\" class=\"btn btn-primary tooltip-top \"><i class=\"fa fa-google-plus-square fa-lg\"></i></a>

                        <a title=\"";
        // line 38
        echo gettext("Share on Facebook");
        echo "\" href=\"http://www.facebook.com/sharer.php?u=";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["config"]) ? $context["config"] : $this->getContext($context, "config")), "full_url"), "html", null, true);
        echo "paste/";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["paste"]) ? $context["paste"] : $this->getContext($context, "paste")), "id"), "html", null, true);
        echo "\" rel=\"nofollow\" class=\"btn btn-primary tooltip-top\"><i class=\"fa fa-facebook fa-lg\"></i></a>
                        
                        <a title=\"";
        // line 40
        echo gettext("Share on LinkedIn");
        echo "\" href=\"http://www.linkedin.com/shareArticle?mini=true&amp;url=";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["config"]) ? $context["config"] : $this->getContext($context, "config")), "full_url"), "html", null, true);
        echo "paste/";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["paste"]) ? $context["paste"] : $this->getContext($context, "paste")), "id"), "html", null, true);
        echo "\" rel=\"nofollow\" class=\"btn btn-primary tooltip-top\"><i class=\"fa fa-linkedin fa-lg\"></i></a>
                    </div>

                    <button type=\"button\" class=\"btn btn-danger\" data-dismiss=\"modal\"><i class=\"fa fa-times\"></i> ";
        // line 43
        echo gettext("Close window");
        echo "</button>
                </div>
            </div>
        </div>
    </div>";
    }

    public function getTemplateName()
    {
        return "GeneratedLinksModal.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  138 => 43,  128 => 40,  119 => 38,  110 => 36,  101 => 34,  86 => 28,  81 => 26,  69 => 23,  64 => 21,  56 => 18,  51 => 16,  39 => 13,  34 => 11,  26 => 6,  19 => 1,);
    }
}
