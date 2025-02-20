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

/* error/404.twig */
class __TwigTemplate_b54a2a2ada2dceb0997d6a20cccbadca0c948bcd9cd76c0820c27761b60ad55c extends Template
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
            'stylesheets' => [$this, 'block_stylesheets'],
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
        $this->parent = $this->loadTemplate("base.twig", "error/404.twig", 1);
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
        yield "    <div class=\"error-page\">
        <h1>404</h1>
        <h2>";
        // line 9
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["title"] ?? null), "html", null, true);
        yield "</h2>
        <p>";
        // line 10
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["description"] ?? null), "html", null, true);
        yield "</p>
        <div class=\"error-actions\">
            <a href=\"/\" class=\"btn btn-primary\">Retour à l'accueil</a>
            <a href=\"/contact\" class=\"btn btn-secondary\">Nous contacter</a>
        </div>
    </div>
";
        return; yield '';
    }

    // line 18
    public function block_stylesheets($context, array $blocks = [])
    {
        $macros = $this->macros;
        yield "<style>
    .error-page {
        text-align: center;
        padding: 4rem 2rem;
    }
    
    .error-page h1 {
        font-size: 6rem;
        color: var(--secondary-color);
        margin-bottom: 1rem;
    }
    
    .error-page h2 {
        font-size: 2rem;
        margin-bottom: 1rem;
    }
    
    .error-actions {
        margin-top: 2rem;
        display: flex;
        gap: 1rem;
        justify-content: center;
    }
    
    @media (max-width: 768px) {
        .error-page h1 {
            font-size: 4rem;
        }
        
        .error-actions {
            flex-direction: column;
        }
    }
</style>
";
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "error/404.twig";
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
        return array (  90 => 18,  78 => 10,  74 => 9,  70 => 7,  66 => 6,  58 => 4,  50 => 3,  39 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends \"base.twig\" %}

{% block title %}{{ title }}{% endblock %}
{% block description %}{{ description }}{% endblock %}

{% block content %}
    <div class=\"error-page\">
        <h1>404</h1>
        <h2>{{ title }}</h2>
        <p>{{ description }}</p>
        <div class=\"error-actions\">
            <a href=\"/\" class=\"btn btn-primary\">Retour à l'accueil</a>
            <a href=\"/contact\" class=\"btn btn-secondary\">Nous contacter</a>
        </div>
    </div>
{% endblock %}

{% block stylesheets %}
<style>
    .error-page {
        text-align: center;
        padding: 4rem 2rem;
    }
    
    .error-page h1 {
        font-size: 6rem;
        color: var(--secondary-color);
        margin-bottom: 1rem;
    }
    
    .error-page h2 {
        font-size: 2rem;
        margin-bottom: 1rem;
    }
    
    .error-actions {
        margin-top: 2rem;
        display: flex;
        gap: 1rem;
        justify-content: center;
    }
    
    @media (max-width: 768px) {
        .error-page h1 {
            font-size: 4rem;
        }
        
        .error-actions {
            flex-direction: column;
        }
    }
</style>
{% endblock %} ", "error/404.twig", "C:\\xampp\\htdocs\\Facon_puzzle-new\\src\\Views\\error\\404.twig");
    }
}
