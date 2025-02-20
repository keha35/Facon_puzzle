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
        yield "    <div class=\"relative overflow-hidden\">
        <!-- Décorations de pièces de puzzle -->
        <puzzle-decoration position=\"top-left\" :count=\"3\" />
        <puzzle-decoration position=\"bottom-right\" :count=\"4\" />

        <section class=\"hero relative\">
            <h1 class=\"text-4xl md:text-5xl font-bold mb-6\">";
        // line 13
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["title"] ?? null), "html", null, true);
        yield "</h1>
            <p class=\"text-xl mb-8 max-w-2xl mx-auto\">";
        // line 14
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["description"] ?? null), "html", null, true);
        yield "</p>
            <div class=\"cta-buttons\">
                <puzzle-button 
                    href=\"/creations\" 
                    variant=\"primary\" 
                    size=\"lg\"
                    class=\"mr-4\"
                >
                    Créer mon puzzle
                </puzzle-button>
                <puzzle-button 
                    href=\"/catalogue\" 
                    variant=\"secondary\" 
                    size=\"lg\"
                >
                    Voir le catalogue
                </puzzle-button>
            </div>
        </section>

        <section class=\"features relative\">
            <puzzle-decoration position=\"center-left\" :count=\"2\" />
            
            <h2 class=\"text-3xl font-bold mb-12\">Pourquoi choisir Façon Puzzle ?</h2>
            <div class=\"features-grid\">
                <div class=\"feature-card group\">
                    <div class=\"feature-icon\">
                        <i class=\"fas fa-magic text-4xl text-primary mb-4\"></i>
                        <puzzle-decoration position=\"top-right\" :count=\"1\" />
                    </div>
                    <h3 class=\"text-xl font-bold mb-2\">Personnalisation unique</h3>
                    <p>Créez votre puzzle à partir de vos photos préférées</p>
                </div>
                <div class=\"feature-card group\">
                    <div class=\"feature-icon\">
                        <i class=\"fas fa-gem text-4xl text-secondary mb-4\"></i>
                        <puzzle-decoration position=\"top-right\" :count=\"1\" />
                    </div>
                    <h3 class=\"text-xl font-bold mb-2\">Qualité premium</h3>
                    <p>Matériaux durables et finition professionnelle</p>
                </div>
                <div class=\"feature-card group\">
                    <div class=\"feature-icon\">
                        <i class=\"fas fa-truck text-4xl text-accent mb-4\"></i>
                        <puzzle-decoration position=\"top-right\" :count=\"1\" />
                    </div>
                    <h3 class=\"text-xl font-bold mb-2\">Livraison rapide</h3>
                    <p>Recevez votre puzzle en quelques jours</p>
                </div>
            </div>
        </section>
    </div>
";
        return; yield '';
    }

    // line 68
    public function block_stylesheets($context, array $blocks = [])
    {
        $macros = $this->macros;
        yield "<style>
.hero {
    @apply text-center py-16 md:py-24 px-4;
    background: linear-gradient(to bottom, theme('colors.primary.light/5'), theme('colors.primary.light/10'));
}

.features {
    @apply py-16 md:py-24 px-4 bg-white text-center;
}

.features-grid {
    @apply grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto;
}

.feature-card {
    @apply p-6 rounded-lg transition-all duration-300 relative overflow-hidden;
    background: linear-gradient(to bottom right, theme('colors.white'), theme('colors.primary.light/5'));
}

.feature-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 20px theme('colors.primary.light/10');
}

.feature-icon {
    @apply relative inline-block mb-4;
}

@media (prefers-reduced-motion: reduce) {
    .feature-card:hover {
        transform: none;
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
        return array (  140 => 68,  82 => 14,  78 => 13,  70 => 7,  66 => 6,  58 => 4,  50 => 3,  39 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends \"base.twig\" %}

{% block title %}{{ title }}{% endblock %}
{% block description %}{{ description }}{% endblock %}

{% block content %}
    <div class=\"relative overflow-hidden\">
        <!-- Décorations de pièces de puzzle -->
        <puzzle-decoration position=\"top-left\" :count=\"3\" />
        <puzzle-decoration position=\"bottom-right\" :count=\"4\" />

        <section class=\"hero relative\">
            <h1 class=\"text-4xl md:text-5xl font-bold mb-6\">{{ title }}</h1>
            <p class=\"text-xl mb-8 max-w-2xl mx-auto\">{{ description }}</p>
            <div class=\"cta-buttons\">
                <puzzle-button 
                    href=\"/creations\" 
                    variant=\"primary\" 
                    size=\"lg\"
                    class=\"mr-4\"
                >
                    Créer mon puzzle
                </puzzle-button>
                <puzzle-button 
                    href=\"/catalogue\" 
                    variant=\"secondary\" 
                    size=\"lg\"
                >
                    Voir le catalogue
                </puzzle-button>
            </div>
        </section>

        <section class=\"features relative\">
            <puzzle-decoration position=\"center-left\" :count=\"2\" />
            
            <h2 class=\"text-3xl font-bold mb-12\">Pourquoi choisir Façon Puzzle ?</h2>
            <div class=\"features-grid\">
                <div class=\"feature-card group\">
                    <div class=\"feature-icon\">
                        <i class=\"fas fa-magic text-4xl text-primary mb-4\"></i>
                        <puzzle-decoration position=\"top-right\" :count=\"1\" />
                    </div>
                    <h3 class=\"text-xl font-bold mb-2\">Personnalisation unique</h3>
                    <p>Créez votre puzzle à partir de vos photos préférées</p>
                </div>
                <div class=\"feature-card group\">
                    <div class=\"feature-icon\">
                        <i class=\"fas fa-gem text-4xl text-secondary mb-4\"></i>
                        <puzzle-decoration position=\"top-right\" :count=\"1\" />
                    </div>
                    <h3 class=\"text-xl font-bold mb-2\">Qualité premium</h3>
                    <p>Matériaux durables et finition professionnelle</p>
                </div>
                <div class=\"feature-card group\">
                    <div class=\"feature-icon\">
                        <i class=\"fas fa-truck text-4xl text-accent mb-4\"></i>
                        <puzzle-decoration position=\"top-right\" :count=\"1\" />
                    </div>
                    <h3 class=\"text-xl font-bold mb-2\">Livraison rapide</h3>
                    <p>Recevez votre puzzle en quelques jours</p>
                </div>
            </div>
        </section>
    </div>
{% endblock %}

{% block stylesheets %}
<style>
.hero {
    @apply text-center py-16 md:py-24 px-4;
    background: linear-gradient(to bottom, theme('colors.primary.light/5'), theme('colors.primary.light/10'));
}

.features {
    @apply py-16 md:py-24 px-4 bg-white text-center;
}

.features-grid {
    @apply grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto;
}

.feature-card {
    @apply p-6 rounded-lg transition-all duration-300 relative overflow-hidden;
    background: linear-gradient(to bottom right, theme('colors.white'), theme('colors.primary.light/5'));
}

.feature-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 20px theme('colors.primary.light/10');
}

.feature-icon {
    @apply relative inline-block mb-4;
}

@media (prefers-reduced-motion: reduce) {
    .feature-card:hover {
        transform: none;
    }
}
</style>
{% endblock %} ", "home/index.twig", "C:\\xampp\\htdocs\\Facon_puzzle-new\\src\\Views\\home\\index.twig");
    }
}
