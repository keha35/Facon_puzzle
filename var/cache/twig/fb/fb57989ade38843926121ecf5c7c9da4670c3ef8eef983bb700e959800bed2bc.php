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

/* base.twig */
class __TwigTemplate_4430470aa70c99c2cd8448fb1351349e24b15680e84e0db3afaaf22f228821c2 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'description' => [$this, 'block_description'],
            'stylesheets' => [$this, 'block_stylesheets'],
            'content' => [$this, 'block_content'],
            'javascripts' => [$this, 'block_javascripts'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        yield "<!DOCTYPE html>
<html lang=\"fr\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>";
        // line 6
        yield from $this->unwrap()->yieldBlock('title', $context, $blocks);
        yield "</title>
    <meta name=\"description\" content=\"";
        // line 7
        yield from $this->unwrap()->yieldBlock('description', $context, $blocks);
        yield "\">
    <link rel=\"stylesheet\" href=\"";
        // line 8
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["app"] ?? null), "base_path", [], "any", false, false, false, 8), "html", null, true);
        yield "/assets/css/style.css\">
    ";
        // line 9
        yield from $this->unwrap()->yieldBlock('stylesheets', $context, $blocks);
        // line 10
        yield "</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href=\"";
        // line 15
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["app"] ?? null), "base_path", [], "any", false, false, false, 15), "html", null, true);
        yield "/\">Accueil</a></li>
                <li><a href=\"";
        // line 16
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["app"] ?? null), "base_path", [], "any", false, false, false, 16), "html", null, true);
        yield "/creations\">Vos Créations</a></li>
                <li><a href=\"";
        // line 17
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["app"] ?? null), "base_path", [], "any", false, false, false, 17), "html", null, true);
        yield "/catalogue\">Notre Catalogue</a></li>
                <li><a href=\"";
        // line 18
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["app"] ?? null), "base_path", [], "any", false, false, false, 18), "html", null, true);
        yield "/panier\">Panier</a></li>
                <li><a href=\"";
        // line 19
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["app"] ?? null), "base_path", [], "any", false, false, false, 19), "html", null, true);
        yield "/compte\">Mon Compte</a></li>
            </ul>
        </nav>
    </header>

    <main>
        ";
        // line 25
        yield from $this->unwrap()->yieldBlock('content', $context, $blocks);
        // line 26
        yield "    </main>

    <footer>
        <div class=\"footer-content\">
            <div class=\"footer-section\">
                <h3>À propos</h3>
                <p>Façon Puzzle - Créez vos puzzles personnalisés</p>
            </div>
            <div class=\"footer-section\">
                <h3>Liens utiles</h3>
                <ul>
                    <li><a href=\"";
        // line 37
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["app"] ?? null), "base_path", [], "any", false, false, false, 37), "html", null, true);
        yield "/mentions-legales\">Mentions légales</a></li>
                    <li><a href=\"";
        // line 38
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["app"] ?? null), "base_path", [], "any", false, false, false, 38), "html", null, true);
        yield "/cgv\">CGV</a></li>
                    <li><a href=\"";
        // line 39
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["app"] ?? null), "base_path", [], "any", false, false, false, 39), "html", null, true);
        yield "/contact\">Contact</a></li>
                </ul>
            </div>
        </div>
        <div class=\"footer-bottom\">
            <p>&copy; ";
        // line 44
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate("now", "Y"), "html", null, true);
        yield " Façon Puzzle. Tous droits réservés.</p>
        </div>
    </footer>

    <script src=\"";
        // line 48
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["app"] ?? null), "base_path", [], "any", false, false, false, 48), "html", null, true);
        yield "/assets/js/app.js\"></script>
    ";
        // line 49
        yield from $this->unwrap()->yieldBlock('javascripts', $context, $blocks);
        // line 50
        yield "</body>
</html> ";
        return; yield '';
    }

    // line 6
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        yield "Façon Puzzle";
        return; yield '';
    }

    // line 7
    public function block_description($context, array $blocks = [])
    {
        $macros = $this->macros;
        yield "Créez vos puzzles personnalisés uniques";
        return; yield '';
    }

    // line 9
    public function block_stylesheets($context, array $blocks = [])
    {
        $macros = $this->macros;
        return; yield '';
    }

    // line 25
    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
        return; yield '';
    }

    // line 49
    public function block_javascripts($context, array $blocks = [])
    {
        $macros = $this->macros;
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "base.twig";
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
        return array (  176 => 49,  169 => 25,  162 => 9,  154 => 7,  146 => 6,  140 => 50,  138 => 49,  134 => 48,  127 => 44,  119 => 39,  115 => 38,  111 => 37,  98 => 26,  96 => 25,  87 => 19,  83 => 18,  79 => 17,  75 => 16,  71 => 15,  64 => 10,  62 => 9,  58 => 8,  54 => 7,  50 => 6,  43 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<!DOCTYPE html>
<html lang=\"fr\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>{% block title %}Façon Puzzle{% endblock %}</title>
    <meta name=\"description\" content=\"{% block description %}Créez vos puzzles personnalisés uniques{% endblock %}\">
    <link rel=\"stylesheet\" href=\"{{ app.base_path }}/assets/css/style.css\">
    {% block stylesheets %}{% endblock %}
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href=\"{{ app.base_path }}/\">Accueil</a></li>
                <li><a href=\"{{ app.base_path }}/creations\">Vos Créations</a></li>
                <li><a href=\"{{ app.base_path }}/catalogue\">Notre Catalogue</a></li>
                <li><a href=\"{{ app.base_path }}/panier\">Panier</a></li>
                <li><a href=\"{{ app.base_path }}/compte\">Mon Compte</a></li>
            </ul>
        </nav>
    </header>

    <main>
        {% block content %}{% endblock %}
    </main>

    <footer>
        <div class=\"footer-content\">
            <div class=\"footer-section\">
                <h3>À propos</h3>
                <p>Façon Puzzle - Créez vos puzzles personnalisés</p>
            </div>
            <div class=\"footer-section\">
                <h3>Liens utiles</h3>
                <ul>
                    <li><a href=\"{{ app.base_path }}/mentions-legales\">Mentions légales</a></li>
                    <li><a href=\"{{ app.base_path }}/cgv\">CGV</a></li>
                    <li><a href=\"{{ app.base_path }}/contact\">Contact</a></li>
                </ul>
            </div>
        </div>
        <div class=\"footer-bottom\">
            <p>&copy; {{ \"now\"|date(\"Y\") }} Façon Puzzle. Tous droits réservés.</p>
        </div>
    </footer>

    <script src=\"{{ app.base_path }}/assets/js/app.js\"></script>
    {% block javascripts %}{% endblock %}
</body>
</html> ", "base.twig", "C:\\xampp\\htdocs\\Facon_puzzle-new\\src\\Views\\base.twig");
    }
}
