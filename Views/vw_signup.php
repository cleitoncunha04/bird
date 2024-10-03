<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link
            rel="shortcut icon"
            href="/assets/images/bird-logo.ico"
            type="image/x-icon"
    />
    <link
            rel="stylesheet"
            href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"
    />
    <link rel="stylesheet" href="/assets/css/signup.css"/>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
    <script src="/assets/js/animations/stripes&HeroReverse.js" defer></script>
    <script src="/assets/js/widgets/eyePassword.js" defer></script>
    <title>Cadastro</title>
</head>
<body>
<div class="overlay">
  <div class="bar"></div>
  <div class="bar"></div>
  <div class="bar"></div>
  <div class="bar"></div>
  <div class="bar"></div>
  <div class="bar"></div>
  <div class="bar"></div>
  <div class="bar"></div>
  <div class="bar"></div>
  <div class="bar"></div>
</div>

<main>
    <div class="loginLogo">
        <div class="loginLogo__alinhamento">
            <img
                    class="logo"
                    src="/assets/images/bird-logo.png"
                    alt="Logo do Bird"
            />
            <div class="loginLogo__alinhamento__texto">
                <h2 class="tablet">Já possui uma conta?</h2>
                <h2 class="desktop">Possui uma conta?</h2>
                <p>Tenha acesso a Base Institucional de Recursos Didáticos</p>
                <a href="/login">Entrar</a>
            </div>
        </div>
    </div>

    <form id="formCadastro" method="post">
        <h1>Criar conta</h1>

        <?php if (isset($_SESSION['error_message'])) : ?>

            <h2 class="formulario__mensagem-erro">
                <?php echo $_SESSION['error_message'];

                unset($_SESSION['error_message']) ?>
            </h2>

        <?php endif; ?>

        <div class="formCadastro__textField">
            <span class="material-symbols-outlined">person</span>

            <input
                    type="text"
                    name="username"
                    placeholder="Informe seu usuário..."
                    id="idUsername"
                    class="formCadastro__textField__input"
                    required
            />
        </div>

        <div class="formCadastro__textField">
            <span class="material-symbols-outlined">mail</span>

            <input
                    type="email"
                    name="email"
                    placeholder="Informe seu e-mail..."
                    id="idEmail"
                    class="formCadastro__textField__input"
                    required
            />
        </div>

        <div class="formCadastro__textField">
            <span class="material-symbols-outlined">lock</span>

            <input
                    type="password"
                    name="password"
                    placeholder="Informe sua senha..."
                    id="idSenha"
                    class="formCadastro__textField__input"
                    data-password="true"
                    required
            />

            <span class="material-symbols-outlined eye-password">visibility_off</span>
        </div>

        <div class="formCadastro__textField">
            <span class="material-symbols-outlined">lock</span>

            <input
                    type="password"
                    name="confirmPassword"
                    placeholder="Confirme sua senha..."
                    id="idSenhaConfirmada"
                    class="formCadastro__textField__input"
                    data-password="true"
                    required
            />

            <span class="material-symbols-outlined eye-password">visibility_off</span>
        </div>

        <input type="submit" value="Registre-se" id="btCadastro"/>

        <div class="formCadastro__links mobile">
            <p>Já possui uma conta? <a href="/login">Entre aqui...</a></p>
        </div>
    </form>
</main>
</body>
</html>
