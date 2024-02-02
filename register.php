<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <title>Registro</title>
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
                    <legend class="text-center">Registro</legend>
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="name" name="name" required maxlength="20" onblur="this.value=this.value.trim();" placeholder="O nome de usuário deve ser único" />
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email" required maxlength="40" onblur="this.value=this.value.trim();" placeholder="O e-mail deve ser único" />
                    </div>
                    <div class="mb-3">
                        <label for="senha" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="password" name="password" required maxlength="60" placeholder="Informe uma senha" />
                    </div>
                    <div class="mb-3">
                        <label></label>
                        <button type="submit" class="btn btn-primary w-100">
                            Registrar <i class="bi bi-person-plus-fill"></i>
                        </button>
                    </div>
                    <div class="mb-3">
                        <div class="alert alert-danger" id="alert" style="display: none;"></div>
                    </div>
                    <div class="mt-5 text-center">
                        <i class="bi bi-check"></i> <a href="index.php" class="text-light" style="text-decoration: none;">Possui registro? Faça seu login</a>
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
            const name = document.querySelector('#name').value
            const email = document.querySelector('#email').value
            const password = document.querySelector('#password').value
            const alert = document.querySelector('#alert')
            const fd = new FormData();
            fd.append("query", "register")
            fd.append("name", name);
            fd.append("email", email)
            fd.append("password", password)
            fetch('./controllers/UserController.php', {
                body: fd,
                method: 'POST',                
                headers: { 'Accept': 'application/json' }
            })
            .then((res) => res.json())
            .then((data) => {
                if(data === null) {
                    alert.style.display = "block"
                    alert.innerHTML = "Erro. Verifique se nome ou e-mail já foram registrados"
                }
                else {
                    alert.classList.remove("alert-danger")
                    alert.classList.add("alert-info")
                    alert.innerHTML = "Registro concluído, redirecionando para o login..."
                    setTimeout(() => {
                        window.location.href = "index.php"
                    }, 2000)
                }
            })
        })
    </script>

</body>

</html>