<?php 
    if(!isset($_SESSION)) {
        session_start();
    }    
    if(!isset($_SESSION["csrf"])) {
        $_SESSION["csrf"] = md5(time() . rand(0, 99999));
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <title>Login</title>
</head>

<body class="text-bg-dark">
    
    <div class="container p-3">
        <h1 class="text-center">Games4Learn</h1>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-6 text-center d-none d-sm-block">
                <i class="bi bi-controller" style="font-size: 15rem;"></i>                
            </div>
            <div class="col-md-6">
                <form class="p-3" method="post" action="./controllers/UserController.php">
                    <input type="hidden" id="csrf" value="<?= $_SESSION['csrf'] ?>" />
                    <legend class="text-center">Login</legend>
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email" required maxlength="40" onblur="this.value=this.value.trim();" placeholder="Informe seu e-mail" />
                    </div>
                    <div class="mb-3">
                        <label for="senha" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="password" name="password" required maxlength="60" placeholder="Informe sua senha" />
                    </div>
                    <div class="mb-3">
                        <label></label>
                        <button type="submit" class="btn btn-primary w-100">
                            Logar <i class="bi bi-box-arrow-in-right"></i>
                        </button>
                    </div>
                    <div class="mb-3">
                        <div class="alert alert-danger" id="alert" style="display: none;"></div>
                    </div>
                    <div class="mt-5 text-center">
                        <i class="bi bi-person-circle"></i> <a href="register.php" class="text-light" style="text-decoration: none;">Sem registro ainda? Registre-se aqui</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="fixed-bottom">
            <h5 class="text-center">Games4Learn&copy; - Todos os direitos reservados (<?= date('Y') ?>)</h5>
        </div>
    </div>

    <script>
        const form = document.querySelector('form')
        form.addEventListener('submit', (e) => {
            e.preventDefault()            
            const email = document.querySelector('#email').value
            const password = document.querySelector('#password').value
            const csrf = document.querySelector('#csrf').value
            const alert = document.querySelector('#alert')
            const fd = new FormData()
            fd.append("query", "login")            
            fd.append("email", email)
            fd.append("password", password)
            fd.append("csrf", csrf)
            fetch('./controllers/UserController.php', {
                body: fd,
                method: 'POST',
                headers: { 'Accept': 'application/json' }
            })
            .then((res) => res.json())
            .then((data) => {
                if(data === null) {
                    alert.style.display = "block"
                    alert.innerHTML = "Erro. Verifique e-mail e/ou senha informados"
                }
                else {
                    window.location.href = "./views/main.php"
                }
            })
        })
    </script>

</body>

</html>