<nav class="navbar navbar-expand-lg navbar-dark bg-dark border mt-1 mb-5">
    <div class="container-fluid">        
        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav">
                <a href="main.php" class="nav-item nav-link <?= $page == "main" ? "active" : "" ?>"><i class="bi bi-house"></i> Home</a>
                <a href="jogos.php" class="nav-item nav-link <?= $page == "jogos" ? "active" : "" ?>"><i class="bi bi-joystick"></i> Jogos</a>
                <a href="#" class="nav-item nav-link"><i class="bi bi-bar-chart"></i> Estatísticas</a>
                <a href="#" class="nav-item nav-link disabled" tabindex="-1"><i class="bi bi-gear"></i> Configurações</a>
            </div>
            <div class="navbar-nav ms-auto">
                <a href="#" class="nav-item nav-link">
                  <button class="btn btn-danger btn-sm" id="sair">Sair <i class="bi bi-door-open-fill"></i></button>
                </a>
            </div>
        </div>
    </div>
</nav>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
<script>
  const button = document.querySelector("#sair")
        const fd = new FormData()
        fd.append("query", "logout")        
        button.addEventListener('click', () => {
            fetch('../controllers/UserController.php', {
                body: fd,
                method: "POST",
                headers: { 
                    'Accept': 'application/json'
                }
            }).
            then((res) => res.json()).
            then((data) => {
                if(data === null) {
                    window.location.href = "../index.php"
                }
            })
        })
</script>