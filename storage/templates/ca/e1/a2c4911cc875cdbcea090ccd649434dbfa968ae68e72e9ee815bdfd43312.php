<?php

/* Rules.html.twig */
class __TwigTemplate_cae1a2c4911cc875cdbcea090ccd649434dbfa968ae68e72e9ee815bdfd43312 extends Twig_Template
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
        echo gettext("Rules");
    }

    // line 5
    public function block_document_content($context, array $blocks = array())
    {
        // line 6
        echo "        <h3>SimPas Terms and Conditions (\"Agreement\")</h3>
        <div style=\"padding: 10px;\">
            <p><em>This Agreement was last modified on September 10, 2013.</em></p>

            <p>Please read these Terms and Conditions (\"Agreement\", \"Terms and Conditions\") carefully before using http://www.macsch15.pl (\"the Site\") operated by SimPas (\"us\", \"we\", or \"our\"). This Agreement sets forth the legally binding terms and conditions for your use of the Site at http://www.macsch15.pl.</p>
            <p>By accessing or using the Site in any manner, including, but not limited to, visiting or browsing the Site or contributing content or other materials to the Site, you agree to be bound by these Terms and Conditions. Capitalized terms are defined in this Agreement.</p>

            <p><strong>Intellectual Property</strong><br />The Site and its original content, features and functionality are owned by SimPas and are protected by international copyright, trademark, patent, trade secret and other intellectual property or proprietary rights laws.</p>

            <p><strong>Termination</strong><br />We may terminate your access to the Site, without cause or notice, which may result in the forfeiture and destruction of all information associated with you. All provisions of this Agreement that by their nature should survive termination shall survive termination, including, without limitation, ownership provisions, warranty disclaimers, indemnity, and limitations of liability.</p>

            <p><strong>Links To Other Sites</strong><br />Our Site may contain links to third-party sites that are not owned or controlled by SimPas.</p>
            <p>SimPas has no control over, and assumes no responsibility for, the content, privacy policies, or practices of any third party sites or services. We strongly advise you to read the terms and conditions and privacy policy of any third-party site that you visit.</p>

            <p><strong>Governing Law</strong><br />This Agreement (and any further rules, polices, or guidelines incorporated by reference) shall be governed and construed in accordance with the laws of Poland, without giving effect to any principles of conflicts of law.</p>

            <p><strong>Changes To This Agreement</strong><br />We reserve the right, at our sole discretion, to modify or replace these Terms and Conditions by posting the updated terms on the Site. Your continued use of the Site after any such changes constitutes your acceptance of the new Terms and Conditions.</p>
            <p>Please review this Agreement periodically for changes. If you do not agree to any of this Agreement or any changes to this Agreement, do not use, access or continue to access the Site or discontinue any use of the Site immediately.</p>
        </div>
    ";
    }

    public function getTemplateName()
    {
        return "Rules.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  38 => 6,  35 => 5,  29 => 3,);
    }
}
