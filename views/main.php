<?php 
    session_start();
    $page = "main";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <title>Games</title>
</head>

<body class="text-bg-dark">
    <div class="container mt-2">        
        <?php require_once("./partials/header.php"); ?>
    </div>
    <div class="container mt-2">
        <?php require_once("./partials/menu.php"); ?>
    </div>    

    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="card text-bg-success mt-2">
                    <div class="card-header text-center">
                        <i class="bi bi-bookmarks-fill" style="font-size: 5rem;"></i>
                    </div>
                    <div class="card-body" style="min-height: 170px;">
                        <h5 class="card-title text-center">Questionário</h5>
                        <p class="card-text">Esse foi o último questionário que você respondeu</p>
                        <p class="text-center">
                            <span class="badge rounded-pill text-bg-primary p-2" id="ultimo"></span>
                        </p>                        
                    </div>
                </div>
            </div>
            <div class="col-md-3">
            <div class="card text-bg-primary mt-2">
                <div class="card-header text-center">
                    <i class="bi bi-trophy-fill text-warning" style="font-size: 5rem;"></i>
                </div>
                <div class="card-body" style="min-height: 170px;">
                    <h5 class="card-title text-center">Troféu</h5>
                    <p class="card-text">Até esse exato momento, você conseguiu atingir o nível</p>
                    <p class="text-center"><span class="badge rounded-pill text-bg-danger p-2">Troféu nível</span></p>
                </div>
            </div>
            </div>
            <div class="col-md-3">
            <div class="card text-bg-info mt-2">
                <div class="card-header text-center">
                    <i class="bi bi-clipboard2-data-fill" style="font-size: 5rem;"></i>
                </div>            
                <div class="card-body" style="min-height: 170px;">
                    <h5 class="card-title text-center">Progresso</h5>
                    <p class="card-text">Sugestões de provas e temas de estudos para você</p>
                    <p class="text-center"><span class="badge rounded-pill text-bg-success p-2">Sugestões</span></p>
                </div>
            </div>
            </div>
        </div>
        
    </div>

    <script>
        const conqForm = new FormData()
        conqForm.append("query", "list")
        fetch('../controllers/ConquistaController.php', {
            method: 'POST',
            body: conqForm,
            headers: {
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if(data.length !== 0) {
                document.querySelector("#ultimo").innerHTML = data[0].descricao + ' - ' + data[0].ano 
            }
            else {
                document.querySelector("#ultimo").innerHTML = "Respondeu 0 questionários"
            }          
        })
    </script>

</body>

</html>