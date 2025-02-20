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

/* compte/index.twig */
class __TwigTemplate_41a0285e72488c811f00e46d50a8d7e219aadec920281ac26b92757dbcbf71b5 extends Template
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
        $this->parent = $this->loadTemplate("base.twig", "compte/index.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        yield "Mon compte";
        return; yield '';
    }

    // line 4
    public function block_description($context, array $blocks = [])
    {
        $macros = $this->macros;
        yield "Gérez votre compte et vos commandes";
        return; yield '';
    }

    // line 6
    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 7
        yield "<div class=\"account-page\">
    <div class=\"grid grid-cols-1 lg:grid-cols-4 gap-8\">
        <!-- Menu latéral -->
        <div class=\"lg:col-span-1\">
            <div class=\"bg-white rounded-lg shadow-sm p-6\">
                <!-- Photo de profil -->
                <div class=\"text-center mb-6\">
                    <div class=\"relative inline-block\">
                        <img 
                            src=\"";
        // line 16
        (((CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "avatar", [], "any", true, true, false, 16) &&  !(null === CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "avatar", [], "any", false, false, false, 16)))) ? (yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "avatar", [], "any", false, false, false, 16), "html", null, true)) : (yield "/assets/images/default-avatar.png"));
        yield "\" 
                            alt=\"Photo de profil\"
                            class=\"w-24 h-24 rounded-full object-cover border-4 border-white shadow\"
                        >
                        <button class=\"absolute bottom-0 right-0 bg-primary text-white rounded-full p-2 shadow hover:bg-primary-dark\">
                            <i class=\"fas fa-camera\"></i>
                        </button>
                    </div>
                    <h2 class=\"text-lg font-semibold mt-4\">";
        // line 24
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "fullName", [], "any", false, false, false, 24), "html", null, true);
        yield "</h2>
                    <p class=\"text-gray-600 text-sm\">";
        // line 25
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "email", [], "any", false, false, false, 25), "html", null, true);
        yield "</p>
                </div>

                <!-- Navigation -->
                <nav class=\"space-y-2\">
                    <a href=\"/compte\" class=\"nav-link active\">
                        <i class=\"fas fa-home\"></i>
                        Tableau de bord
                    </a>
                    <a href=\"/compte/commandes\" class=\"nav-link\">
                        <i class=\"fas fa-shopping-bag\"></i>
                        Mes commandes
                    </a>
                    <a href=\"/compte/creations\" class=\"nav-link\">
                        <i class=\"fas fa-puzzle-piece\"></i>
                        Mes créations
                    </a>
                    <a href=\"/compte/adresses\" class=\"nav-link\">
                        <i class=\"fas fa-map-marker-alt\"></i>
                        Mes adresses
                    </a>
                    <a href=\"/compte/parametres\" class=\"nav-link\">
                        <i class=\"fas fa-cog\"></i>
                        Paramètres
                    </a>
                    <button class=\"nav-link text-red-500 hover:bg-red-50\">
                        <i class=\"fas fa-sign-out-alt\"></i>
                        Déconnexion
                    </button>
                </nav>
            </div>
        </div>

        <!-- Contenu principal -->
        <div class=\"lg:col-span-3\">
            <!-- Statistiques rapides -->
            <div class=\"grid grid-cols-1 md:grid-cols-3 gap-6 mb-8\">
                <div class=\"stat-card\">
                    <div class=\"stat-icon bg-blue-100 text-blue-600\">
                        <i class=\"fas fa-shopping-cart\"></i>
                    </div>
                    <div class=\"stat-content\">
                        <h3 class=\"stat-value\">";
        // line 67
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["stats"] ?? null), "orders_in_progress", [], "any", false, false, false, 67), "html", null, true);
        yield "</h3>
                        <p class=\"stat-label\">Commandes en cours</p>
                    </div>
                </div>
                <div class=\"stat-card\">
                    <div class=\"stat-icon bg-green-100 text-green-600\">
                        <i class=\"fas fa-puzzle-piece\"></i>
                    </div>
                    <div class=\"stat-content\">
                        <h3 class=\"stat-value\">";
        // line 76
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["stats"] ?? null), "saved_creations", [], "any", false, false, false, 76), "html", null, true);
        yield "</h3>
                        <p class=\"stat-label\">Créations sauvegardées</p>
                    </div>
                </div>
                <div class=\"stat-card\">
                    <div class=\"stat-icon bg-purple-100 text-purple-600\">
                        <i class=\"fas fa-star\"></i>
                    </div>
                    <div class=\"stat-content\">
                        <h3 class=\"stat-value\">";
        // line 85
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["stats"] ?? null), "loyalty_points", [], "any", false, false, false, 85), "html", null, true);
        yield "</h3>
                        <p class=\"stat-label\">Points fidélité</p>
                    </div>
                </div>
            </div>

            <!-- Dernières commandes -->
            <div class=\"bg-white rounded-lg shadow-sm p-6 mb-8\">
                <div class=\"flex justify-between items-center mb-6\">
                    <h2 class=\"text-xl font-semibold\">Dernières commandes</h2>
                    <a href=\"/compte/commandes\" class=\"text-primary hover:text-primary-dark\">
                        Voir tout
                        <i class=\"fas fa-arrow-right ml-2\"></i>
                    </a>
                </div>

                ";
        // line 101
        if ((1 === CoreExtension::compare(Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["recent_orders"] ?? null)), 0))) {
            // line 102
            yield "                <div class=\"space-y-4\">
                    ";
            // line 103
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["recent_orders"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["order"]) {
                // line 104
                yield "                    <div class=\"order-item\">
                        <div class=\"flex justify-between items-center\">
                            <div>
                                <span class=\"text-gray-600\">#";
                // line 107
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["order"], "number", [], "any", false, false, false, 107), "html", null, true);
                yield "</span>
                                <span class=\"mx-2\">•</span>
                                <span class=\"text-gray-600\">";
                // line 109
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["order"], "date", [], "any", false, false, false, 109), "d/m/Y"), "html", null, true);
                yield "</span>
                            </div>
                            <div class=\"flex items-center gap-4\">
                                <span class=\"order-status ";
                // line 112
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["order"], "status", [], "any", false, false, false, 112), "html", null, true);
                yield "\">
                                    ";
                // line 113
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["order"], "status_label", [], "any", false, false, false, 113), "html", null, true);
                yield "
                                </span>
                                <span class=\"font-semibold\">";
                // line 115
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["order"], "total", [], "any", false, false, false, 115), "html", null, true);
                yield "€</span>
                                <a href=\"/compte/commandes/";
                // line 116
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["order"], "id", [], "any", false, false, false, 116), "html", null, true);
                yield "\" class=\"text-primary hover:text-primary-dark\">
                                    <i class=\"fas fa-eye\"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['order'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 123
            yield "                </div>
                ";
        } else {
            // line 125
            yield "                <p class=\"text-center text-gray-600 py-8\">
                    Vous n'avez pas encore passé de commande
                </p>
                ";
        }
        // line 129
        yield "            </div>

            <!-- Dernières créations -->
            <div class=\"bg-white rounded-lg shadow-sm p-6\">
                <div class=\"flex justify-between items-center mb-6\">
                    <h2 class=\"text-xl font-semibold\">Dernières créations</h2>
                    <a href=\"/compte/creations\" class=\"text-primary hover:text-primary-dark\">
                        Voir tout
                        <i class=\"fas fa-arrow-right ml-2\"></i>
                    </a>
                </div>

                ";
        // line 141
        if ((1 === CoreExtension::compare(Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["recent_creations"] ?? null)), 0))) {
            // line 142
            yield "                <div class=\"grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6\">
                    ";
            // line 143
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["recent_creations"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["creation"]) {
                // line 144
                yield "                    <div class=\"creation-card\">
                        <img 
                            src=\"";
                // line 146
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["creation"], "image", [], "any", false, false, false, 146), "html", null, true);
                yield "\" 
                            alt=\"Création #";
                // line 147
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["creation"], "id", [], "any", false, false, false, 147), "html", null, true);
                yield "\"
                            class=\"w-full h-48 object-cover rounded-lg mb-4\"
                        >
                        <div class=\"flex justify-between items-center\">
                            <div>
                                <p class=\"text-sm text-gray-600\">";
                // line 152
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["creation"], "date", [], "any", false, false, false, 152), "d/m/Y"), "html", null, true);
                yield "</p>
                                <p class=\"font-semibold\">";
                // line 153
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["creation"], "pieces", [], "any", false, false, false, 153), "html", null, true);
                yield " pièces</p>
                            </div>
                            <div class=\"flex gap-2\">
                                <a href=\"/creations/personnaliser/";
                // line 156
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["creation"], "id", [], "any", false, false, false, 156), "html", null, true);
                yield "\" class=\"action-button\">
                                    <i class=\"fas fa-edit\"></i>
                                </a>
                                <button class=\"action-button text-red-500 hover:text-red-600\">
                                    <i class=\"fas fa-trash-alt\"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['creation'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 166
            yield "                </div>
                ";
        } else {
            // line 168
            yield "                <div class=\"text-center py-8\">
                    <p class=\"text-gray-600 mb-4\">Vous n'avez pas encore de création</p>
                    <a href=\"/creations\" class=\"btn btn-primary\">
                        Créer mon premier puzzle
                    </a>
                </div>
                ";
        }
        // line 175
        yield "            </div>
        </div>
    </div>
</div>
";
        return; yield '';
    }

    // line 181
    public function block_stylesheets($context, array $blocks = [])
    {
        $macros = $this->macros;
        yield "<style>
.account-page {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
}

.nav-link {
    @apply flex items-center gap-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors;
}

.nav-link.active {
    @apply bg-primary text-white hover:bg-primary-dark;
}

.nav-link i {
    @apply w-5;
}

.stat-card {
    @apply bg-white p-6 rounded-lg shadow-sm flex items-center gap-4;
}

.stat-icon {
    @apply w-12 h-12 rounded-full flex items-center justify-center text-xl;
}

.stat-value {
    @apply text-2xl font-bold mb-1;
}

.stat-label {
    @apply text-gray-600;
}

.order-item {
    @apply p-4 border rounded-lg hover:bg-gray-50 transition-colors;
}

.order-status {
    @apply px-3 py-1 rounded-full text-sm font-medium;
}

.order-status.pending {
    @apply bg-yellow-100 text-yellow-800;
}

.order-status.processing {
    @apply bg-blue-100 text-blue-800;
}

.order-status.shipped {
    @apply bg-green-100 text-green-800;
}

.creation-card {
    @apply bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition-shadow;
}

.action-button {
    @apply w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 transition-colors;
}

@media (max-width: 768px) {
    .account-page {
        padding: 1rem;
    }
}
</style>
";
        return; yield '';
    }

    // line 253
    public function block_javascripts($context, array $blocks = [])
    {
        $macros = $this->macros;
        yield "<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion du changement de photo de profil
    const avatarButton = document.querySelector('.avatar-upload');
    const fileInput = document.createElement('input');
    fileInput.type = 'file';
    fileInput.accept = 'image/*';
    fileInput.style.display = 'none';
    document.body.appendChild(fileInput);

    avatarButton?.addEventListener('click', () => {
        fileInput.click();
    });

    fileInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const formData = new FormData();
            formData.append('avatar', this.files[0]);

            fetch('/compte/avatar', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
            });
        }
    });
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
        return "compte/index.twig";
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
        return array (  410 => 253,  333 => 181,  324 => 175,  315 => 168,  311 => 166,  295 => 156,  289 => 153,  285 => 152,  277 => 147,  273 => 146,  269 => 144,  265 => 143,  262 => 142,  260 => 141,  246 => 129,  240 => 125,  236 => 123,  223 => 116,  219 => 115,  214 => 113,  210 => 112,  204 => 109,  199 => 107,  194 => 104,  190 => 103,  187 => 102,  185 => 101,  166 => 85,  154 => 76,  142 => 67,  97 => 25,  93 => 24,  82 => 16,  71 => 7,  67 => 6,  59 => 4,  51 => 3,  40 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends \"base.twig\" %}

{% block title %}Mon compte{% endblock %}
{% block description %}Gérez votre compte et vos commandes{% endblock %}

{% block content %}
<div class=\"account-page\">
    <div class=\"grid grid-cols-1 lg:grid-cols-4 gap-8\">
        <!-- Menu latéral -->
        <div class=\"lg:col-span-1\">
            <div class=\"bg-white rounded-lg shadow-sm p-6\">
                <!-- Photo de profil -->
                <div class=\"text-center mb-6\">
                    <div class=\"relative inline-block\">
                        <img 
                            src=\"{{ user.avatar ?? '/assets/images/default-avatar.png' }}\" 
                            alt=\"Photo de profil\"
                            class=\"w-24 h-24 rounded-full object-cover border-4 border-white shadow\"
                        >
                        <button class=\"absolute bottom-0 right-0 bg-primary text-white rounded-full p-2 shadow hover:bg-primary-dark\">
                            <i class=\"fas fa-camera\"></i>
                        </button>
                    </div>
                    <h2 class=\"text-lg font-semibold mt-4\">{{ user.fullName }}</h2>
                    <p class=\"text-gray-600 text-sm\">{{ user.email }}</p>
                </div>

                <!-- Navigation -->
                <nav class=\"space-y-2\">
                    <a href=\"/compte\" class=\"nav-link active\">
                        <i class=\"fas fa-home\"></i>
                        Tableau de bord
                    </a>
                    <a href=\"/compte/commandes\" class=\"nav-link\">
                        <i class=\"fas fa-shopping-bag\"></i>
                        Mes commandes
                    </a>
                    <a href=\"/compte/creations\" class=\"nav-link\">
                        <i class=\"fas fa-puzzle-piece\"></i>
                        Mes créations
                    </a>
                    <a href=\"/compte/adresses\" class=\"nav-link\">
                        <i class=\"fas fa-map-marker-alt\"></i>
                        Mes adresses
                    </a>
                    <a href=\"/compte/parametres\" class=\"nav-link\">
                        <i class=\"fas fa-cog\"></i>
                        Paramètres
                    </a>
                    <button class=\"nav-link text-red-500 hover:bg-red-50\">
                        <i class=\"fas fa-sign-out-alt\"></i>
                        Déconnexion
                    </button>
                </nav>
            </div>
        </div>

        <!-- Contenu principal -->
        <div class=\"lg:col-span-3\">
            <!-- Statistiques rapides -->
            <div class=\"grid grid-cols-1 md:grid-cols-3 gap-6 mb-8\">
                <div class=\"stat-card\">
                    <div class=\"stat-icon bg-blue-100 text-blue-600\">
                        <i class=\"fas fa-shopping-cart\"></i>
                    </div>
                    <div class=\"stat-content\">
                        <h3 class=\"stat-value\">{{ stats.orders_in_progress }}</h3>
                        <p class=\"stat-label\">Commandes en cours</p>
                    </div>
                </div>
                <div class=\"stat-card\">
                    <div class=\"stat-icon bg-green-100 text-green-600\">
                        <i class=\"fas fa-puzzle-piece\"></i>
                    </div>
                    <div class=\"stat-content\">
                        <h3 class=\"stat-value\">{{ stats.saved_creations }}</h3>
                        <p class=\"stat-label\">Créations sauvegardées</p>
                    </div>
                </div>
                <div class=\"stat-card\">
                    <div class=\"stat-icon bg-purple-100 text-purple-600\">
                        <i class=\"fas fa-star\"></i>
                    </div>
                    <div class=\"stat-content\">
                        <h3 class=\"stat-value\">{{ stats.loyalty_points }}</h3>
                        <p class=\"stat-label\">Points fidélité</p>
                    </div>
                </div>
            </div>

            <!-- Dernières commandes -->
            <div class=\"bg-white rounded-lg shadow-sm p-6 mb-8\">
                <div class=\"flex justify-between items-center mb-6\">
                    <h2 class=\"text-xl font-semibold\">Dernières commandes</h2>
                    <a href=\"/compte/commandes\" class=\"text-primary hover:text-primary-dark\">
                        Voir tout
                        <i class=\"fas fa-arrow-right ml-2\"></i>
                    </a>
                </div>

                {% if recent_orders|length > 0 %}
                <div class=\"space-y-4\">
                    {% for order in recent_orders %}
                    <div class=\"order-item\">
                        <div class=\"flex justify-between items-center\">
                            <div>
                                <span class=\"text-gray-600\">#{{ order.number }}</span>
                                <span class=\"mx-2\">•</span>
                                <span class=\"text-gray-600\">{{ order.date|date('d/m/Y') }}</span>
                            </div>
                            <div class=\"flex items-center gap-4\">
                                <span class=\"order-status {{ order.status }}\">
                                    {{ order.status_label }}
                                </span>
                                <span class=\"font-semibold\">{{ order.total }}€</span>
                                <a href=\"/compte/commandes/{{ order.id }}\" class=\"text-primary hover:text-primary-dark\">
                                    <i class=\"fas fa-eye\"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    {% endfor %}
                </div>
                {% else %}
                <p class=\"text-center text-gray-600 py-8\">
                    Vous n'avez pas encore passé de commande
                </p>
                {% endif %}
            </div>

            <!-- Dernières créations -->
            <div class=\"bg-white rounded-lg shadow-sm p-6\">
                <div class=\"flex justify-between items-center mb-6\">
                    <h2 class=\"text-xl font-semibold\">Dernières créations</h2>
                    <a href=\"/compte/creations\" class=\"text-primary hover:text-primary-dark\">
                        Voir tout
                        <i class=\"fas fa-arrow-right ml-2\"></i>
                    </a>
                </div>

                {% if recent_creations|length > 0 %}
                <div class=\"grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6\">
                    {% for creation in recent_creations %}
                    <div class=\"creation-card\">
                        <img 
                            src=\"{{ creation.image }}\" 
                            alt=\"Création #{{ creation.id }}\"
                            class=\"w-full h-48 object-cover rounded-lg mb-4\"
                        >
                        <div class=\"flex justify-between items-center\">
                            <div>
                                <p class=\"text-sm text-gray-600\">{{ creation.date|date('d/m/Y') }}</p>
                                <p class=\"font-semibold\">{{ creation.pieces }} pièces</p>
                            </div>
                            <div class=\"flex gap-2\">
                                <a href=\"/creations/personnaliser/{{ creation.id }}\" class=\"action-button\">
                                    <i class=\"fas fa-edit\"></i>
                                </a>
                                <button class=\"action-button text-red-500 hover:text-red-600\">
                                    <i class=\"fas fa-trash-alt\"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    {% endfor %}
                </div>
                {% else %}
                <div class=\"text-center py-8\">
                    <p class=\"text-gray-600 mb-4\">Vous n'avez pas encore de création</p>
                    <a href=\"/creations\" class=\"btn btn-primary\">
                        Créer mon premier puzzle
                    </a>
                </div>
                {% endif %}
            </div>
        </div>
    </div>
</div>
{% endblock %}

{% block stylesheets %}
<style>
.account-page {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
}

.nav-link {
    @apply flex items-center gap-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors;
}

.nav-link.active {
    @apply bg-primary text-white hover:bg-primary-dark;
}

.nav-link i {
    @apply w-5;
}

.stat-card {
    @apply bg-white p-6 rounded-lg shadow-sm flex items-center gap-4;
}

.stat-icon {
    @apply w-12 h-12 rounded-full flex items-center justify-center text-xl;
}

.stat-value {
    @apply text-2xl font-bold mb-1;
}

.stat-label {
    @apply text-gray-600;
}

.order-item {
    @apply p-4 border rounded-lg hover:bg-gray-50 transition-colors;
}

.order-status {
    @apply px-3 py-1 rounded-full text-sm font-medium;
}

.order-status.pending {
    @apply bg-yellow-100 text-yellow-800;
}

.order-status.processing {
    @apply bg-blue-100 text-blue-800;
}

.order-status.shipped {
    @apply bg-green-100 text-green-800;
}

.creation-card {
    @apply bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition-shadow;
}

.action-button {
    @apply w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 transition-colors;
}

@media (max-width: 768px) {
    .account-page {
        padding: 1rem;
    }
}
</style>
{% endblock %}

{% block javascripts %}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion du changement de photo de profil
    const avatarButton = document.querySelector('.avatar-upload');
    const fileInput = document.createElement('input');
    fileInput.type = 'file';
    fileInput.accept = 'image/*';
    fileInput.style.display = 'none';
    document.body.appendChild(fileInput);

    avatarButton?.addEventListener('click', () => {
        fileInput.click();
    });

    fileInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const formData = new FormData();
            formData.append('avatar', this.files[0]);

            fetch('/compte/avatar', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
            });
        }
    });
});
</script>
{% endblock %} ", "compte/index.twig", "C:\\xampp\\htdocs\\Facon_puzzle-new\\src\\Views\\compte\\index.twig");
    }
}
