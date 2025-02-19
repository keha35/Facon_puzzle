<?php
// Traitement du formulaire de connexion
$login_error = '';
$register_error = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'login':
                $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
                $password = $_POST['password'];
                
                $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
                $stmt->execute([$email]);
                $user = $stmt->fetch();
                
                if ($user && password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_email'] = $user['email'];
                    
                    // Redirection selon le rôle
                    if ($user['role'] === 'admin') {
                        header('Location: ' . SITE_URL . '/admin');
                    } else {
                        header('Location: ' . SITE_URL . '?page=compte');
                    }
                    exit;
                } else {
                    $login_error = 'Email ou mot de passe incorrect';
                }
                break;
                
            case 'register':
                $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
                $password = $_POST['password'];
                $confirm_password = $_POST['confirm_password'];
                $firstname = htmlspecialchars($_POST['firstname']);
                $lastname = htmlspecialchars($_POST['lastname']);
                
                // Vérifications
                if ($password !== $confirm_password) {
                    $register_error = 'Les mots de passe ne correspondent pas';
                } elseif (strlen($password) < 8) {
                    $register_error = 'Le mot de passe doit contenir au moins 8 caractères';
                } else {
                    // Vérification si l'email existe déjà
                    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
                    $stmt->execute([$email]);
                    if ($stmt->fetchColumn() > 0) {
                        $register_error = 'Cet email est déjà utilisé';
                    } else {
                        // Création du compte
                        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                        $referral_code = generateRandomString(8);
                        
                        $stmt = $pdo->prepare("
                            INSERT INTO users (email, password, firstname, lastname, referral_code, created_at) 
                            VALUES (?, ?, ?, ?, ?, NOW())
                        ");
                        
                        if ($stmt->execute([$email, $hashed_password, $firstname, $lastname, $referral_code])) {
                            $success_message = 'Compte créé avec succès ! Vous pouvez maintenant vous connecter.';
                        } else {
                            $register_error = 'Erreur lors de la création du compte';
                        }
                    }
                }
                break;
        }
    }
}
?>

<div class="auth-container">
    <div class="auth-tabs">
        <button class="tab-btn active" data-tab="login">Connexion</button>
        <button class="tab-btn" data-tab="register">Inscription</button>
    </div>

    <!-- Formulaire de connexion -->
    <div class="auth-form active" id="login-form">
        <h2>Connexion</h2>
        
        <?php if ($login_error): ?>
        <div class="alert alert-error"><?= $login_error ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <input type="hidden" name="action" value="login">
            
            <div class="form-group">
                <label for="login-email">Email</label>
                <input type="email" id="login-email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="login-password">Mot de passe</label>
                <input type="password" id="login-password" name="password" required>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Se connecter</button>
                <a href="<?= SITE_URL ?>?page=reset-password" class="forgot-password">
                    Mot de passe oublié ?
                </a>
            </div>
        </form>
    </div>

    <!-- Formulaire d'inscription -->
    <div class="auth-form" id="register-form">
        <h2>Inscription</h2>
        
        <?php if ($register_error): ?>
        <div class="alert alert-error"><?= $register_error ?></div>
        <?php endif; ?>
        
        <?php if ($success_message): ?>
        <div class="alert alert-success"><?= $success_message ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <input type="hidden" name="action" value="register">
            
            <div class="form-row">
                <div class="form-group">
                    <label for="firstname">Prénom</label>
                    <input type="text" id="firstname" name="firstname" required>
                </div>
                
                <div class="form-group">
                    <label for="lastname">Nom</label>
                    <input type="text" id="lastname" name="lastname" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="register-email">Email</label>
                <input type="email" id="register-email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="register-password">Mot de passe</label>
                <input type="password" id="register-password" name="password" required 
                       minlength="8" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                       title="Le mot de passe doit contenir au moins 8 caractères, dont une majuscule, une minuscule et un chiffre">
                <small class="password-hint">
                    Le mot de passe doit contenir au moins 8 caractères, dont une majuscule, une minuscule et un chiffre
                </small>
            </div>
            
            <div class="form-group">
                <label for="confirm-password">Confirmer le mot de passe</label>
                <input type="password" id="confirm-password" name="confirm_password" required>
            </div>
            
            <button type="submit" class="btn btn-primary">Créer mon compte</button>
        </form>
    </div>
</div>

<style>
.auth-container {
    max-width: 500px;
    margin: 2rem auto;
    padding: 2rem;
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.auth-tabs {
    display: flex;
    margin-bottom: 2rem;
    border-bottom: 2px solid #eee;
}

.tab-btn {
    flex: 1;
    padding: 1rem;
    border: none;
    background: none;
    color: var(--text-color);
    font-size: 1.1rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.tab-btn.active {
    color: var(--primary-color);
    border-bottom: 2px solid var(--primary-color);
    margin-bottom: -2px;
}

.auth-form {
    display: none;
}

.auth-form.active {
    display: block;
}

.auth-form h2 {
    color: var(--primary-color);
    margin-bottom: 1.5rem;
    text-align: center;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

label {
    display: block;
    margin-bottom: 0.5rem;
    color: var(--text-color);
}

input {
    width: 100%;
    padding: 0.8rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    transition: border-color 0.3s ease;
}

input:focus {
    border-color: var(--primary-color);
    outline: none;
}

.password-hint {
    display: block;
    margin-top: 0.5rem;
    font-size: 0.9rem;
    color: #666;
}

.form-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.forgot-password {
    color: var(--primary-color);
    text-decoration: none;
    font-size: 0.9rem;
}

.forgot-password:hover {
    text-decoration: underline;
}

.alert {
    padding: 1rem;
    border-radius: 4px;
    margin-bottom: 1.5rem;
}

.alert-error {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.alert-success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.btn {
    padding: 0.8rem 1.5rem;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 1rem;
    transition: background-color 0.3s ease;
}

.btn-primary {
    background: var(--primary-color);
    color: white;
}

.btn-primary:hover {
    background: var(--secondary-color);
}

@media (max-width: 768px) {
    .auth-container {
        margin: 1rem;
        padding: 1.5rem;
    }

    .form-row {
        grid-template-columns: 1fr;
    }

    .form-actions {
        flex-direction: column;
        gap: 1rem;
        align-items: stretch;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabBtns = document.querySelectorAll('.tab-btn');
    const authForms = document.querySelectorAll('.auth-form');
    
    tabBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const targetTab = this.dataset.tab;
            
            // Mise à jour des boutons
            tabBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            // Mise à jour des formulaires
            authForms.forEach(form => {
                form.classList.remove('active');
                if (form.id === `${targetTab}-form`) {
                    form.classList.add('active');
                }
            });
        });
    });
    
    // Validation du mot de passe en temps réel
    const password = document.getElementById('register-password');
    const confirmPassword = document.getElementById('confirm-password');
    
    function validatePassword() {
        if (password.value !== confirmPassword.value) {
            confirmPassword.setCustomValidity('Les mots de passe ne correspondent pas');
        } else {
            confirmPassword.setCustomValidity('');
        }
    }
    
    password.addEventListener('change', validatePassword);
    confirmPassword.addEventListener('keyup', validatePassword);
});
</script> 