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

/* catalogue/index.twig */
class __TwigTemplate_f07127741f1e96ad077bf6ffb927e83d4878c4fe13fdd78d7aa044c821b4fc85 extends Template
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
        $this->parent = $this->loadTemplate("base.twig", "catalogue/index.twig", 1);
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
        yield "<div class=\"catalogue-page\">
    <!-- En-tête -->
    <div class=\"page-header mb-8\">
        <h1 class=\"text-3xl font-bold mb-2\">Notre catalogue</h1>
        <p class=\"text-gray-600\">Découvrez notre sélection de puzzles personnalisés</p>
    </div>

    <div class=\"grid grid-cols-1 lg:grid-cols-4 gap-8\">
        <!-- Filtres -->
        <div class=\"lg:col-span-1\">
            <div class=\"bg-white rounded-lg shadow-sm p-6\">
                <h2 class=\"text-xl font-semibold mb-6\">Filtres</h2>

                <!-- Recherche -->
                <div class=\"mb-6\">
                    <label class=\"block text-sm font-medium text-gray-700 mb-2\">Rechercher</label>
                    <input 
                        type=\"text\" 
                        placeholder=\"Nom du puzzle...\" 
                        class=\"w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary\"
                    >
                </div>

                <!-- Nombre de pièces -->
                <div class=\"mb-6\">
                    <label class=\"block text-sm font-medium text-gray-700 mb-2\">Nombre de pièces</label>
                    <div class=\"space-y-2\">
                        <label class=\"flex items-center\">
                            <input type=\"checkbox\" class=\"form-checkbox text-primary\">
                            <span class=\"ml-2\">100 pièces</span>
                        </label>
                        <label class=\"flex items-center\">
                            <input type=\"checkbox\" class=\"form-checkbox text-primary\">
                            <span class=\"ml-2\">500 pièces</span>
                        </label>
                        <label class=\"flex items-center\">
                            <input type=\"checkbox\" class=\"form-checkbox text-primary\">
                            <span class=\"ml-2\">1000 pièces</span>
                        </label>
                    </div>
                </div>

                <!-- Matériaux -->
                <div class=\"mb-6\">
                    <label class=\"block text-sm font-medium text-gray-700 mb-2\">Matériaux</label>
                    <div class=\"space-y-2\">
                        <label class=\"flex items-center\">
                            <input type=\"checkbox\" class=\"form-checkbox text-primary\">
                            <span class=\"ml-2\">Standard</span>
                        </label>
                        <label class=\"flex items-center\">
                            <input type=\"checkbox\" class=\"form-checkbox text-primary\">
                            <span class=\"ml-2\">Premium (Bois)</span>
                        </label>
                    </div>
                </div>

                <!-- Prix -->
                <div>
                    <label class=\"block text-sm font-medium text-gray-700 mb-2\">Prix</label>
                    <div class=\"flex items-center gap-4\">
                        <input 
                            type=\"number\" 
                            placeholder=\"Min\" 
                            class=\"w-24 px-3 py-1 border rounded\"
                        >
                        <span>-</span>
                        <input 
                            type=\"number\" 
                            placeholder=\"Max\" 
                            class=\"w-24 px-3 py-1 border rounded\"
                        >
                    </div>
                </div>
            </div>
        </div>

        <!-- Grille de produits -->
        <div class=\"lg:col-span-3\">
            <div class=\"grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6\">
                ";
        // line 87
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(range(1, 9));
        foreach ($context['_seq'] as $context["_key"] => $context["i"]) {
            // line 88
            yield "                <div class=\"product-card\">
                    <img 
                        src=\"/assets/images/products/puzzle-";
            // line 90
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["i"], "html", null, true);
            yield ".jpg\" 
                        alt=\"Puzzle ";
            // line 91
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["i"], "html", null, true);
            yield "\"
                        class=\"w-full h-48 object-cover rounded-t-lg\"
                    >
                    <div class=\"p-4\">
                        <h3 class=\"text-lg font-semibold mb-2\">Puzzle Nature ";
            // line 95
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["i"], "html", null, true);
            yield "</h3>
                        <p class=\"text-gray-600 text-sm mb-4\">500 pièces • Premium</p>
                        <div class=\"flex justify-between items-center\">
                            <span class=\"text-xl font-bold\">49,99 €</span>
                            <button class=\"btn btn-primary\">
                                <i class=\"fas fa-shopping-cart mr-2\"></i>
                                Ajouter
                            </button>
                        </div>
                    </div>
                </div>
                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['i'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 107
        yield "            </div>

            <!-- Pagination -->
            <div class=\"flex justify-center mt-8\">
                <nav class=\"flex items-center gap-2\">
                    <a href=\"#\" class=\"pagination-link\">
                        <i class=\"fas fa-chevron-left\"></i>
                    </a>
                    <a href=\"#\" class=\"pagination-link active\">1</a>
                    <a href=\"#\" class=\"pagination-link\">2</a>
                    <a href=\"#\" class=\"pagination-link\">3</a>
                    <span class=\"px-2\">...</span>
                    <a href=\"#\" class=\"pagination-link\">8</a>
                    <a href=\"#\" class=\"pagination-link\">
                        <i class=\"fas fa-chevron-right\"></i>
                    </a>
                </nav>
            </div>
        </div>
    </div>
</div>
";
        return; yield '';
    }

    // line 130
    public function block_stylesheets($context, array $blocks = [])
    {
        $macros = $this->macros;
        yield "<style>
.catalogue-page {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
}

.product-card {
    @apply bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow;
}

.pagination-link {
    @apply w-8 h-8 flex items-center justify-center rounded-full border text-gray-600 hover:bg-gray-50;
}

.pagination-link.active {
    @apply bg-primary text-white border-primary hover:bg-primary-dark;
}

@media (max-width: 768px) {
    .catalogue-page {
        padding: 1rem;
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
        return "catalogue/index.twig";
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
        return array (  215 => 130,  189 => 107,  171 => 95,  164 => 91,  160 => 90,  156 => 88,  152 => 87,  70 => 7,  66 => 6,  58 => 4,  50 => 3,  39 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends \"base.twig\" %}

{% block title %}{{ title }}{% endblock %}
{% block description %}{{ description }}{% endblock %}

{% block content %}
<div class=\"catalogue-page\">
    <!-- En-tête -->
    <div class=\"page-header mb-8\">
        <h1 class=\"text-3xl font-bold mb-2\">Notre catalogue</h1>
        <p class=\"text-gray-600\">Découvrez notre sélection de puzzles personnalisés</p>
    </div>

    <div class=\"grid grid-cols-1 lg:grid-cols-4 gap-8\">
        <!-- Filtres -->
        <div class=\"lg:col-span-1\">
            <div class=\"bg-white rounded-lg shadow-sm p-6\">
                <h2 class=\"text-xl font-semibold mb-6\">Filtres</h2>

                <!-- Recherche -->
                <div class=\"mb-6\">
                    <label class=\"block text-sm font-medium text-gray-700 mb-2\">Rechercher</label>
                    <input 
                        type=\"text\" 
                        placeholder=\"Nom du puzzle...\" 
                        class=\"w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary\"
                    >
                </div>

                <!-- Nombre de pièces -->
                <div class=\"mb-6\">
                    <label class=\"block text-sm font-medium text-gray-700 mb-2\">Nombre de pièces</label>
                    <div class=\"space-y-2\">
                        <label class=\"flex items-center\">
                            <input type=\"checkbox\" class=\"form-checkbox text-primary\">
                            <span class=\"ml-2\">100 pièces</span>
                        </label>
                        <label class=\"flex items-center\">
                            <input type=\"checkbox\" class=\"form-checkbox text-primary\">
                            <span class=\"ml-2\">500 pièces</span>
                        </label>
                        <label class=\"flex items-center\">
                            <input type=\"checkbox\" class=\"form-checkbox text-primary\">
                            <span class=\"ml-2\">1000 pièces</span>
                        </label>
                    </div>
                </div>

                <!-- Matériaux -->
                <div class=\"mb-6\">
                    <label class=\"block text-sm font-medium text-gray-700 mb-2\">Matériaux</label>
                    <div class=\"space-y-2\">
                        <label class=\"flex items-center\">
                            <input type=\"checkbox\" class=\"form-checkbox text-primary\">
                            <span class=\"ml-2\">Standard</span>
                        </label>
                        <label class=\"flex items-center\">
                            <input type=\"checkbox\" class=\"form-checkbox text-primary\">
                            <span class=\"ml-2\">Premium (Bois)</span>
                        </label>
                    </div>
                </div>

                <!-- Prix -->
                <div>
                    <label class=\"block text-sm font-medium text-gray-700 mb-2\">Prix</label>
                    <div class=\"flex items-center gap-4\">
                        <input 
                            type=\"number\" 
                            placeholder=\"Min\" 
                            class=\"w-24 px-3 py-1 border rounded\"
                        >
                        <span>-</span>
                        <input 
                            type=\"number\" 
                            placeholder=\"Max\" 
                            class=\"w-24 px-3 py-1 border rounded\"
                        >
                    </div>
                </div>
            </div>
        </div>

        <!-- Grille de produits -->
        <div class=\"lg:col-span-3\">
            <div class=\"grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6\">
                {% for i in 1..9 %}
                <div class=\"product-card\">
                    <img 
                        src=\"/assets/images/products/puzzle-{{ i }}.jpg\" 
                        alt=\"Puzzle {{ i }}\"
                        class=\"w-full h-48 object-cover rounded-t-lg\"
                    >
                    <div class=\"p-4\">
                        <h3 class=\"text-lg font-semibold mb-2\">Puzzle Nature {{ i }}</h3>
                        <p class=\"text-gray-600 text-sm mb-4\">500 pièces • Premium</p>
                        <div class=\"flex justify-between items-center\">
                            <span class=\"text-xl font-bold\">49,99 €</span>
                            <button class=\"btn btn-primary\">
                                <i class=\"fas fa-shopping-cart mr-2\"></i>
                                Ajouter
                            </button>
                        </div>
                    </div>
                </div>
                {% endfor %}
            </div>

            <!-- Pagination -->
            <div class=\"flex justify-center mt-8\">
                <nav class=\"flex items-center gap-2\">
                    <a href=\"#\" class=\"pagination-link\">
                        <i class=\"fas fa-chevron-left\"></i>
                    </a>
                    <a href=\"#\" class=\"pagination-link active\">1</a>
                    <a href=\"#\" class=\"pagination-link\">2</a>
                    <a href=\"#\" class=\"pagination-link\">3</a>
                    <span class=\"px-2\">...</span>
                    <a href=\"#\" class=\"pagination-link\">8</a>
                    <a href=\"#\" class=\"pagination-link\">
                        <i class=\"fas fa-chevron-right\"></i>
                    </a>
                </nav>
            </div>
        </div>
    </div>
</div>
{% endblock %}

{% block stylesheets %}
<style>
.catalogue-page {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
}

.product-card {
    @apply bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow;
}

.pagination-link {
    @apply w-8 h-8 flex items-center justify-center rounded-full border text-gray-600 hover:bg-gray-50;
}

.pagination-link.active {
    @apply bg-primary text-white border-primary hover:bg-primary-dark;
}

@media (max-width: 768px) {
    .catalogue-page {
        padding: 1rem;
    }
}
</style>
{% endblock %} ", "catalogue/index.twig", "C:\\xampp\\htdocs\\Facon_puzzle-new\\src\\Views\\catalogue\\index.twig");
    }
}
