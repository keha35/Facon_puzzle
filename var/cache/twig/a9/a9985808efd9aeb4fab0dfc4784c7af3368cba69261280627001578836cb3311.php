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

/* creations/index.twig */
class __TwigTemplate_5cbeebb4b8c4e9df8a24c3f38d2e39091c23ada6a41792adc184e242e64f54ff extends Template
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
        $this->parent = $this->loadTemplate("base.twig", "creations/index.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        yield "Créez votre puzzle personnalisé";
        return; yield '';
    }

    // line 4
    public function block_description($context, array $blocks = [])
    {
        $macros = $this->macros;
        yield "Créez un puzzle unique à partir de vos photos préférées";
        return; yield '';
    }

    // line 6
    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
        yield "<div class=\"creation-page\">
    <!-- Indicateur d'étape -->
    <div class=\"steps-indicator\">
        <div class=\"steps-progress\">
            <div class=\"progress-bar\" style=\"width: 33%\"></div>
            <div class=\"steps\">
                <div class=\"step active\">
                    <div class=\"step-number\">1</div>
                    <div class=\"step-label\">Upload d'image</div>
                </div>
                <div class=\"step\">
                    <div class=\"step-number\">2</div>
                    <div class=\"step-label\">Personnalisation</div>
                </div>
                <div class=\"step\">
                    <div class=\"step-number\">3</div>
                    <div class=\"step-label\">Finalisation</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Zone de dépôt d'image -->
    <div class=\"upload-zone\">
        <div class=\"drop-zone\" id=\"dropZone\">
            <input type=\"file\" id=\"fileInput\" class=\"hidden\" accept=\"image/*\">
            <div class=\"upload-content\">
                <i class=\"fas fa-cloud-upload-alt text-4xl mb-4\"></i>
                <h3 class=\"text-xl font-semibold mb-2\">Glissez-déposez votre image ici</h3>
                <p class=\"text-gray-600 mb-4\">ou</p>
                <button class=\"btn btn-primary\" onclick=\"document.getElementById('fileInput').click()\">
                    Parcourir
                </button>
            </div>
            <div class=\"upload-info\">
                <p class=\"text-sm text-gray-500 mt-4\">
                    Formats acceptés : JPG, PNG, WEBP - Max 10 Mo
                </p>
                <p class=\"text-sm text-gray-500\">
                    Dimensions recommandées : min 2000x2000px
                </p>
            </div>
        </div>
    </div>
</div>
";
        return; yield '';
    }

    // line 54
    public function block_stylesheets($context, array $blocks = [])
    {
        $macros = $this->macros;
        yield "<style>
.creation-page {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
}

.steps-indicator {
    margin-bottom: 3rem;
}

.steps-progress {
    position: relative;
    padding: 2rem 0;
}

.progress-bar {
    position: absolute;
    top: 50%;
    left: 0;
    height: 4px;
    background: var(--primary-color);
    border-radius: 2px;
    transition: width 0.3s ease;
}

.steps {
    display: flex;
    justify-content: space-between;
    position: relative;
    z-index: 1;
}

.step {
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
}

.step-number {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: white;
    border: 2px solid var(--primary-color);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    margin-bottom: 0.5rem;
    transition: all 0.3s ease;
}

.step.active .step-number {
    background: var(--primary-color);
    color: white;
}

.step-label {
    font-size: 0.875rem;
    color: var(--gray-600);
    font-weight: 500;
}

.upload-zone {
    max-width: 800px;
    margin: 0 auto;
}

.drop-zone {
    border: 2px dashed var(--gray-300);
    border-radius: 0.5rem;
    padding: 3rem;
    text-align: center;
    transition: all 0.3s ease;
    background: white;
}

.drop-zone:hover {
    border-color: var(--primary-color);
}

.drop-zone.drag-over {
    border-color: var(--primary-color);
    background: var(--primary-color-light/5);
}

.upload-content {
    margin-bottom: 2rem;
}

.hidden {
    display: none;
}

@media (max-width: 768px) {
    .creation-page {
        padding: 1rem;
    }

    .step-label {
        font-size: 0.75rem;
    }

    .drop-zone {
        padding: 2rem 1rem;
    }
}
</style>
";
        return; yield '';
    }

    // line 167
    public function block_javascripts($context, array $blocks = [])
    {
        $macros = $this->macros;
        yield "<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('fileInput');

    // Gestion du drag & drop
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, unhighlight, false);
    });

    function highlight(e) {
        dropZone.classList.add('drag-over');
    }

    function unhighlight(e) {
        dropZone.classList.remove('drag-over');
    }

    dropZone.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        handleFiles(files);
    }

    fileInput.addEventListener('change', function() {
        handleFiles(this.files);
    });

    function handleFiles(files) {
        if (files.length > 0) {
            const file = files[0];
            if (validateFile(file)) {
                uploadFile(file);
            }
        }
    }

    function validateFile(file) {
        const validTypes = ['image/jpeg', 'image/png', 'image/webp'];
        const maxSize = 10 * 1024 * 1024; // 10 Mo

        if (!validTypes.includes(file.type)) {
            alert('Format de fichier non supporté. Veuillez utiliser JPG, PNG ou WEBP.');
            return false;
        }

        if (file.size > maxSize) {
            alert('Fichier trop volumineux. La taille maximum est de 10 Mo.');
            return false;
        }

        return true;
    }

    function uploadFile(file) {
        const formData = new FormData();
        formData.append('image', file);

        fetch('/creations/upload', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = `/creations/personnaliser/\${data.id}`;
            } else {
                alert(data.message || 'Une erreur est survenue lors de l\\'upload.');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Une erreur est survenue lors de l\\'upload.');
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
        return "creations/index.twig";
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
        return array (  238 => 167,  120 => 54,  67 => 6,  59 => 4,  51 => 3,  40 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends \"base.twig\" %}

{% block title %}Créez votre puzzle personnalisé{% endblock %}
{% block description %}Créez un puzzle unique à partir de vos photos préférées{% endblock %}

{% block content %}
<div class=\"creation-page\">
    <!-- Indicateur d'étape -->
    <div class=\"steps-indicator\">
        <div class=\"steps-progress\">
            <div class=\"progress-bar\" style=\"width: 33%\"></div>
            <div class=\"steps\">
                <div class=\"step active\">
                    <div class=\"step-number\">1</div>
                    <div class=\"step-label\">Upload d'image</div>
                </div>
                <div class=\"step\">
                    <div class=\"step-number\">2</div>
                    <div class=\"step-label\">Personnalisation</div>
                </div>
                <div class=\"step\">
                    <div class=\"step-number\">3</div>
                    <div class=\"step-label\">Finalisation</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Zone de dépôt d'image -->
    <div class=\"upload-zone\">
        <div class=\"drop-zone\" id=\"dropZone\">
            <input type=\"file\" id=\"fileInput\" class=\"hidden\" accept=\"image/*\">
            <div class=\"upload-content\">
                <i class=\"fas fa-cloud-upload-alt text-4xl mb-4\"></i>
                <h3 class=\"text-xl font-semibold mb-2\">Glissez-déposez votre image ici</h3>
                <p class=\"text-gray-600 mb-4\">ou</p>
                <button class=\"btn btn-primary\" onclick=\"document.getElementById('fileInput').click()\">
                    Parcourir
                </button>
            </div>
            <div class=\"upload-info\">
                <p class=\"text-sm text-gray-500 mt-4\">
                    Formats acceptés : JPG, PNG, WEBP - Max 10 Mo
                </p>
                <p class=\"text-sm text-gray-500\">
                    Dimensions recommandées : min 2000x2000px
                </p>
            </div>
        </div>
    </div>
</div>
{% endblock %}

{% block stylesheets %}
<style>
.creation-page {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
}

.steps-indicator {
    margin-bottom: 3rem;
}

.steps-progress {
    position: relative;
    padding: 2rem 0;
}

.progress-bar {
    position: absolute;
    top: 50%;
    left: 0;
    height: 4px;
    background: var(--primary-color);
    border-radius: 2px;
    transition: width 0.3s ease;
}

.steps {
    display: flex;
    justify-content: space-between;
    position: relative;
    z-index: 1;
}

.step {
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
}

.step-number {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: white;
    border: 2px solid var(--primary-color);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    margin-bottom: 0.5rem;
    transition: all 0.3s ease;
}

.step.active .step-number {
    background: var(--primary-color);
    color: white;
}

.step-label {
    font-size: 0.875rem;
    color: var(--gray-600);
    font-weight: 500;
}

.upload-zone {
    max-width: 800px;
    margin: 0 auto;
}

.drop-zone {
    border: 2px dashed var(--gray-300);
    border-radius: 0.5rem;
    padding: 3rem;
    text-align: center;
    transition: all 0.3s ease;
    background: white;
}

.drop-zone:hover {
    border-color: var(--primary-color);
}

.drop-zone.drag-over {
    border-color: var(--primary-color);
    background: var(--primary-color-light/5);
}

.upload-content {
    margin-bottom: 2rem;
}

.hidden {
    display: none;
}

@media (max-width: 768px) {
    .creation-page {
        padding: 1rem;
    }

    .step-label {
        font-size: 0.75rem;
    }

    .drop-zone {
        padding: 2rem 1rem;
    }
}
</style>
{% endblock %}

{% block javascripts %}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('fileInput');

    // Gestion du drag & drop
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, unhighlight, false);
    });

    function highlight(e) {
        dropZone.classList.add('drag-over');
    }

    function unhighlight(e) {
        dropZone.classList.remove('drag-over');
    }

    dropZone.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        handleFiles(files);
    }

    fileInput.addEventListener('change', function() {
        handleFiles(this.files);
    });

    function handleFiles(files) {
        if (files.length > 0) {
            const file = files[0];
            if (validateFile(file)) {
                uploadFile(file);
            }
        }
    }

    function validateFile(file) {
        const validTypes = ['image/jpeg', 'image/png', 'image/webp'];
        const maxSize = 10 * 1024 * 1024; // 10 Mo

        if (!validTypes.includes(file.type)) {
            alert('Format de fichier non supporté. Veuillez utiliser JPG, PNG ou WEBP.');
            return false;
        }

        if (file.size > maxSize) {
            alert('Fichier trop volumineux. La taille maximum est de 10 Mo.');
            return false;
        }

        return true;
    }

    function uploadFile(file) {
        const formData = new FormData();
        formData.append('image', file);

        fetch('/creations/upload', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = `/creations/personnaliser/\${data.id}`;
            } else {
                alert(data.message || 'Une erreur est survenue lors de l\\'upload.');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Une erreur est survenue lors de l\\'upload.');
        });
    }
});
</script>
{% endblock %} ", "creations/index.twig", "C:\\xampp\\htdocs\\Facon_puzzle-new\\src\\Views\\creations\\index.twig");
    }
}
