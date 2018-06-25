<?php

/* @SitesManager/globalSettings.twig */
class __TwigTemplate_7d26811d898a8570b37a712601d787cce15de03fbdd14ea173ae0c1567a00ef5 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("admin.twig", "@SitesManager/globalSettings.twig", 1);
        $this->blocks = array(
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "admin.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 3
        ob_start();
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("SitesManager_GlobalWebsitesSettings")), "html", null, true);
        $context["title"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        // line 1
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        // line 6
        echo "
    <div ng-include=\"'plugins/SitesManager/templates/global-settings.html?cb=";
        // line 7
        echo \Piwik\piwik_escape_filter($this->env, ($context["cacheBuster"] ?? $this->getContext($context, "cacheBuster")), "html", null, true);
        echo "'\"></div>

";
    }

    public function getTemplateName()
    {
        return "@SitesManager/globalSettings.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  39 => 7,  36 => 6,  33 => 5,  29 => 1,  25 => 3,  11 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% extends 'admin.twig' %}

{% set title %}{{ 'SitesManager_GlobalWebsitesSettings'|translate }}{% endset %}

{% block content %}

    <div ng-include=\"'plugins/SitesManager/templates/global-settings.html?cb={{ cacheBuster }}'\"></div>

{% endblock %}
", "@SitesManager/globalSettings.twig", "C:\\myProjects\\Intranet\\public\\analytics\\plugins\\SitesManager\\templates\\globalSettings.twig");
    }
}
