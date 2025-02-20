<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* home/index.twig */
class __TwigTemplate_c25af53c894a82a8e7224b9751333ad73119e74d31567fc805f5cf5db9c6dca8 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'description' => [$this, 'block_description'],
            'content' => [$this, 'block_content'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "base.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $this->parent = $this->loadTemplate("base.twig", "home/index.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["title"] ?? null), "html", null, true);
        return; yield '';
    }

    // line 4
    public function block_description($context, array $blocks = [])
    {
        $macros = $this->macros;
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["description"] ?? null), "html", null, true);
        return; yield '';
    }

    // line 6
    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 7
        yield "    <section class=\"hero\">
        <h1>";
        // line 8
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["title"] ?? null), "html", null, true);
        yield "</h1>
        <p>";
        // line 9
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["description"] ?? null), "html", null, true);
        yield "</p>
        <div class=\"cta-buttons\">
            <a href=\"/creations\" class=\"btn btn-primary\">Créer mon puzzle</a>
            <a href=\"/catalogue\" class=\"btn btn-secondary\">Voir le catalogue</a>
        </div>
    </section>

    <section class=\"features\">
        <h2>Pourquoi choisir Façon Puzzle ?</h2>
        <div class=\"features-grid\">
            <div class=\"feature-card\">
                <h3>Personnalisation unique</h3>
                <p>Créez votre puzzle à partir de vos photos préférées</p>
            </div>
            <div class=\"feature-card\">
                <h3>Qualité premium</h3>
                <p>Matériaux durables et finition professionnelle</p>
            </div>
            <div class=\"feature-card\">
                <h3>Livraison rapide</h3>
                <p>Recevez votre puzzle en quelques jours</p>
            </div>
        </div>
    </section>
";
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "home/index.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable()
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo()
    {
        return array (  76 => 9,  72 => 8,  69 => 7,  65 => 6,  57 => 4,  49 => 3,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends \"base.twig\" %}

{% block title %}{{ title }}{% endblock %}
{% block description %}{{ description }}{% endblock %}

{% block content %}
    <section class=\"hero\">
        <h1>{{ title }}</h1>
        <p>{{ description }}</p>
        <div class=\"cta-buttons\">
            <a href=\"/creations\" class=\"btn btn-primary\">Créer mon puzzle</a>
            <a href=\"/catalogue\" class=\"btn btn-secondary\">Voir le catalogue</a>
        </div>
    </section>

    <section class=\"features\">
        <h2>Pourquoi choisir Façon Puzzle ?</h2>
        <div class=\"features-grid\">
            <div class=\"feature-card\">
                <h3>Personnalisation unique</h3>
                <p>Créez votre puzzle à partir de vos photos préférées</p>
            </div>
            <div class=\"feature-card\">
                <h3>Qualité premium</h3>
                <p>Matériaux durables et finition professionnelle</p>
            </div>
            <div class=\"feature-card\">
                <h3>Livraison rapide</h3>
                <p>Recevez votre puzzle en quelques jours</p>
            </div>
        </div>
    </section>
{% endblock %} ", "home/index.twig", "C:\\xampp\\htdocs\\Facon_puzzle-new\\src\\Views\\home\\index.twig");
    }
}
