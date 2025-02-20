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

/* panier/index.twig */
class __TwigTemplate_ade89aaedabc744bb9537933a7be0d69742e58a7523087fd6ee8a73806767453 extends Template
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
            'javascripts' => [$this, 'block_javascripts'],
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
        $this->parent = $this->loadTemplate("base.twig", "panier/index.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        yield "Votre panier";
        return; yield '';
    }

    // line 4
    public function block_description($context, array $blocks = [])
    {
        $macros = $this->macros;
        yield "Gérez votre panier et finalisez votre commande";
        return; yield '';
    }

    // line 6
    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 7
        yield "<div class=\"cart-page\">
    <!-- En-tête -->
    <div class=\"page-header mb-8\">
        <h1 class=\"text-3xl font-bold mb-2\">Votre panier</h1>
        <p class=\"text-gray-600\">";
        // line 11
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["cart"] ?? null), "items", [], "any", false, false, false, 11)), "html", null, true);
        yield " article(s)</p>
    </div>

    <div class=\"grid grid-cols-1 lg:grid-cols-3 gap-8\">
        <!-- Liste des articles -->
        <div class=\"lg:col-span-2\">
            ";
        // line 17
        if ((1 === CoreExtension::compare(Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["cart"] ?? null), "items", [], "any", false, false, false, 17)), 0))) {
            // line 18
            yield "                <div class=\"space-y-4\">
                    ";
            // line 19
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, ($context["cart"] ?? null), "items", [], "any", false, false, false, 19));
            foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
                // line 20
                yield "                    <div class=\"cart-item bg-white p-4 rounded-lg shadow-sm\">
                        <div class=\"flex gap-4\">
                            <!-- Image -->
                            <div class=\"w-24 h-24 flex-shrink-0\">
                                <img 
                                    src=\"";
                // line 25
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "image", [], "any", false, false, false, 25), "html", null, true);
                yield "\" 
                                    alt=\"";
                // line 26
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "name", [], "any", false, false, false, 26), "html", null, true);
                yield "\"
                                    class=\"w-full h-full object-cover rounded-md\"
                                >
                            </div>
                            
                            <!-- Informations -->
                            <div class=\"flex-grow\">
                                <h3 class=\"text-lg font-semibold\">";
                // line 33
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "name", [], "any", false, false, false, 33), "html", null, true);
                yield "</h3>
                                <p class=\"text-gray-600\">";
                // line 34
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "pieces", [], "any", false, false, false, 34), "html", null, true);
                yield " pièces</p>
                                <p class=\"text-sm text-gray-500\">";
                // line 35
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "material", [], "any", false, false, false, 35), "html", null, true);
                yield "</p>
                            </div>

                            <!-- Prix et quantité -->
                            <div class=\"flex flex-col items-end gap-2\">
                                <span class=\"text-xl font-bold\">";
                // line 40
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "price", [], "any", false, false, false, 40), "html", null, true);
                yield "€</span>
                                <div class=\"flex items-center gap-2\">
                                    <button class=\"w-8 h-8 rounded-full border flex items-center justify-center hover:bg-gray-100\">-</button>
                                    <input type=\"number\" value=\"";
                // line 43
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "quantity", [], "any", false, false, false, 43), "html", null, true);
                yield "\" min=\"1\" class=\"w-12 text-center border rounded\">
                                    <button class=\"w-8 h-8 rounded-full border flex items-center justify-center hover:bg-gray-100\">+</button>
                                </div>
                                <button class=\"text-red-500 text-sm hover:text-red-600\">
                                    <i class=\"fas fa-trash-alt\"></i>
                                    Supprimer
                                </button>
                            </div>
                        </div>
                    </div>
                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 54
            yield "                </div>
            ";
        } else {
            // line 56
            yield "                <div class=\"empty-cart text-center py-12\">
                    <i class=\"fas fa-shopping-cart text-6xl text-gray-300 mb-4\"></i>
                    <h2 class=\"text-2xl font-semibold mb-2\">Votre panier est vide</h2>
                    <p class=\"text-gray-600 mb-6\">Découvrez notre catalogue de puzzles personnalisés</p>
                    <a href=\"/catalogue\" class=\"btn btn-primary\">Voir le catalogue</a>
                </div>
            ";
        }
        // line 63
        yield "        </div>

        <!-- Résumé de la commande -->
        <div class=\"lg:col-span-1\">
            <div class=\"bg-white p-6 rounded-lg shadow-sm\">
                <h2 class=\"text-xl font-semibold mb-4\">Résumé de la commande</h2>
                
                <!-- Code promo -->
                <div class=\"mb-6\">
                    <div class=\"flex gap-2\">
                        <input 
                            type=\"text\" 
                            placeholder=\"Code promo\" 
                            class=\"flex-grow px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary\"
                        >
                        <button class=\"btn btn-secondary\">Appliquer</button>
                    </div>
                </div>

                <!-- Calculs -->
                <div class=\"space-y-3 mb-6\">
                    <div class=\"flex justify-between\">
                        <span class=\"text-gray-600\">Sous-total</span>
                        <span class=\"font-semibold\">";
        // line 86
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["cart"] ?? null), "subtotal", [], "any", false, false, false, 86), "html", null, true);
        yield "€</span>
                    </div>
                    <div class=\"flex justify-between\">
                        <span class=\"text-gray-600\">Livraison</span>
                        <span class=\"font-semibold\">";
        // line 90
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["cart"] ?? null), "shipping", [], "any", false, false, false, 90), "html", null, true);
        yield "€</span>
                    </div>
                    ";
        // line 92
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["cart"] ?? null), "discount", [], "any", false, false, false, 92)) {
            // line 93
            yield "                    <div class=\"flex justify-between text-green-600\">
                        <span>Réduction</span>
                        <span>-";
            // line 95
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["cart"] ?? null), "discount", [], "any", false, false, false, 95), "html", null, true);
            yield "€</span>
                    </div>
                    ";
        }
        // line 98
        yield "                    <div class=\"flex justify-between text-gray-600\">
                        <span>TVA (20%)</span>
                        <span>";
        // line 100
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["cart"] ?? null), "tax", [], "any", false, false, false, 100), "html", null, true);
        yield "€</span>
                    </div>
                    <div class=\"border-t pt-3 flex justify-between items-center\">
                        <span class=\"text-lg font-semibold\">Total</span>
                        <span class=\"text-2xl font-bold\">";
        // line 104
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["cart"] ?? null), "total", [], "any", false, false, false, 104), "html", null, true);
        yield "€</span>
                    </div>
                </div>

                <!-- Bouton de commande -->
                <button class=\"btn btn-primary w-full mb-4\">
                    Passer la commande
                </button>

                <!-- Moyens de paiement -->
                <div class=\"text-center\">
                    <p class=\"text-sm text-gray-500 mb-2\">Paiement 100% sécurisé</p>
                    <div class=\"flex justify-center gap-2\">
                        <i class=\"fab fa-cc-visa text-2xl text-gray-400\"></i>
                        <i class=\"fab fa-cc-mastercard text-2xl text-gray-400\"></i>
                        <i class=\"fab fa-cc-paypal text-2xl text-gray-400\"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
";
        return; yield '';
    }

    // line 128
    public function block_stylesheets($context, array $blocks = [])
    {
        $macros = $this->macros;
        yield "<style>
.cart-page {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
}

.cart-item {
    transition: transform 0.2s ease;
}

.cart-item:hover {
    transform: translateX(5px);
}

@media (max-width: 768px) {
    .cart-page {
        padding: 1rem;
    }
}
</style>
";
        return; yield '';
    }

    // line 152
    public function block_javascripts($context, array $blocks = [])
    {
        $macros = $this->macros;
        yield "<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion des quantités
    const quantityInputs = document.querySelectorAll('input[type=\"number\"]');
    quantityInputs.forEach(input => {
        input.addEventListener('change', function() {
            // TODO: Mettre à jour le panier
            updateCart(this.dataset.id, this.value);
        });
    });

    // Fonction de mise à jour du panier
    function updateCart(id, quantity) {
        fetch('/panier/update', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                id: id,
                quantity: quantity
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Mettre à jour l'affichage
                location.reload();
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
        });
    }
});
</script>
";
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "panier/index.twig";
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
        return array (  285 => 152,  256 => 128,  228 => 104,  221 => 100,  217 => 98,  211 => 95,  207 => 93,  205 => 92,  200 => 90,  193 => 86,  168 => 63,  159 => 56,  155 => 54,  138 => 43,  132 => 40,  124 => 35,  120 => 34,  116 => 33,  106 => 26,  102 => 25,  95 => 20,  91 => 19,  88 => 18,  86 => 17,  77 => 11,  71 => 7,  67 => 6,  59 => 4,  51 => 3,  40 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends \"base.twig\" %}

{% block title %}Votre panier{% endblock %}
{% block description %}Gérez votre panier et finalisez votre commande{% endblock %}

{% block content %}
<div class=\"cart-page\">
    <!-- En-tête -->
    <div class=\"page-header mb-8\">
        <h1 class=\"text-3xl font-bold mb-2\">Votre panier</h1>
        <p class=\"text-gray-600\">{{ cart.items|length }} article(s)</p>
    </div>

    <div class=\"grid grid-cols-1 lg:grid-cols-3 gap-8\">
        <!-- Liste des articles -->
        <div class=\"lg:col-span-2\">
            {% if cart.items|length > 0 %}
                <div class=\"space-y-4\">
                    {% for item in cart.items %}
                    <div class=\"cart-item bg-white p-4 rounded-lg shadow-sm\">
                        <div class=\"flex gap-4\">
                            <!-- Image -->
                            <div class=\"w-24 h-24 flex-shrink-0\">
                                <img 
                                    src=\"{{ item.image }}\" 
                                    alt=\"{{ item.name }}\"
                                    class=\"w-full h-full object-cover rounded-md\"
                                >
                            </div>
                            
                            <!-- Informations -->
                            <div class=\"flex-grow\">
                                <h3 class=\"text-lg font-semibold\">{{ item.name }}</h3>
                                <p class=\"text-gray-600\">{{ item.pieces }} pièces</p>
                                <p class=\"text-sm text-gray-500\">{{ item.material }}</p>
                            </div>

                            <!-- Prix et quantité -->
                            <div class=\"flex flex-col items-end gap-2\">
                                <span class=\"text-xl font-bold\">{{ item.price }}€</span>
                                <div class=\"flex items-center gap-2\">
                                    <button class=\"w-8 h-8 rounded-full border flex items-center justify-center hover:bg-gray-100\">-</button>
                                    <input type=\"number\" value=\"{{ item.quantity }}\" min=\"1\" class=\"w-12 text-center border rounded\">
                                    <button class=\"w-8 h-8 rounded-full border flex items-center justify-center hover:bg-gray-100\">+</button>
                                </div>
                                <button class=\"text-red-500 text-sm hover:text-red-600\">
                                    <i class=\"fas fa-trash-alt\"></i>
                                    Supprimer
                                </button>
                            </div>
                        </div>
                    </div>
                    {% endfor %}
                </div>
            {% else %}
                <div class=\"empty-cart text-center py-12\">
                    <i class=\"fas fa-shopping-cart text-6xl text-gray-300 mb-4\"></i>
                    <h2 class=\"text-2xl font-semibold mb-2\">Votre panier est vide</h2>
                    <p class=\"text-gray-600 mb-6\">Découvrez notre catalogue de puzzles personnalisés</p>
                    <a href=\"/catalogue\" class=\"btn btn-primary\">Voir le catalogue</a>
                </div>
            {% endif %}
        </div>

        <!-- Résumé de la commande -->
        <div class=\"lg:col-span-1\">
            <div class=\"bg-white p-6 rounded-lg shadow-sm\">
                <h2 class=\"text-xl font-semibold mb-4\">Résumé de la commande</h2>
                
                <!-- Code promo -->
                <div class=\"mb-6\">
                    <div class=\"flex gap-2\">
                        <input 
                            type=\"text\" 
                            placeholder=\"Code promo\" 
                            class=\"flex-grow px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary\"
                        >
                        <button class=\"btn btn-secondary\">Appliquer</button>
                    </div>
                </div>

                <!-- Calculs -->
                <div class=\"space-y-3 mb-6\">
                    <div class=\"flex justify-between\">
                        <span class=\"text-gray-600\">Sous-total</span>
                        <span class=\"font-semibold\">{{ cart.subtotal }}€</span>
                    </div>
                    <div class=\"flex justify-between\">
                        <span class=\"text-gray-600\">Livraison</span>
                        <span class=\"font-semibold\">{{ cart.shipping }}€</span>
                    </div>
                    {% if cart.discount %}
                    <div class=\"flex justify-between text-green-600\">
                        <span>Réduction</span>
                        <span>-{{ cart.discount }}€</span>
                    </div>
                    {% endif %}
                    <div class=\"flex justify-between text-gray-600\">
                        <span>TVA (20%)</span>
                        <span>{{ cart.tax }}€</span>
                    </div>
                    <div class=\"border-t pt-3 flex justify-between items-center\">
                        <span class=\"text-lg font-semibold\">Total</span>
                        <span class=\"text-2xl font-bold\">{{ cart.total }}€</span>
                    </div>
                </div>

                <!-- Bouton de commande -->
                <button class=\"btn btn-primary w-full mb-4\">
                    Passer la commande
                </button>

                <!-- Moyens de paiement -->
                <div class=\"text-center\">
                    <p class=\"text-sm text-gray-500 mb-2\">Paiement 100% sécurisé</p>
                    <div class=\"flex justify-center gap-2\">
                        <i class=\"fab fa-cc-visa text-2xl text-gray-400\"></i>
                        <i class=\"fab fa-cc-mastercard text-2xl text-gray-400\"></i>
                        <i class=\"fab fa-cc-paypal text-2xl text-gray-400\"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{% endblock %}

{% block stylesheets %}
<style>
.cart-page {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
}

.cart-item {
    transition: transform 0.2s ease;
}

.cart-item:hover {
    transform: translateX(5px);
}

@media (max-width: 768px) {
    .cart-page {
        padding: 1rem;
    }
}
</style>
{% endblock %}

{% block javascripts %}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion des quantités
    const quantityInputs = document.querySelectorAll('input[type=\"number\"]');
    quantityInputs.forEach(input => {
        input.addEventListener('change', function() {
            // TODO: Mettre à jour le panier
            updateCart(this.dataset.id, this.value);
        });
    });

    // Fonction de mise à jour du panier
    function updateCart(id, quantity) {
        fetch('/panier/update', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                id: id,
                quantity: quantity
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Mettre à jour l'affichage
                location.reload();
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
        });
    }
});
</script>
{% endblock %} ", "panier/index.twig", "C:\\xampp\\htdocs\\Facon_puzzle-new\\src\\Views\\panier\\index.twig");
    }
}
