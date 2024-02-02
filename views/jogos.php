<?php
    session_start();
    $page = "jogos";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Games4Learn</title>
    <style>
        [v-cloak] {
            display: none;
        }
        @keyframes fadeIn { 
            from { opacity: 0; } 
        }
        .trophy {
            animation: fadeIn 1s infinite alternate;
        }
    </style>
</head>

<body class="text-bg-light">
    <div class="container mt-2">
        <?php require_once("./partials/header.php"); ?>
    </div>
    <div class="container mt-2">
        <?php require_once("./partials/menu.php"); ?>
    </div>

    <div class="container" id="app" v-cloak>
        <div class="row">
            <div class="col-md-6">
                <div class="alert alert-warning fw-bold">
                    Acertos: 
                        <span id="acertos" class="text-primary">{{ acertos }}</span> 
                    Erros: 
                        <span id="erros" class="text-danger">{{ erros }}</span>
                    Precisão: 
                        <span id="precisao" class="text-success">{{ precisao }}%</span>
                </div>
            </div>
            <div class="col-md-6">
                <button class="btn btn-primary disabled" id="iniciar" @click="listarPergunta">
                    <i class="bi bi-journal-richtext"></i> Iniciar Prova
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">                
                <label for="jogos" class="mb-3">Cargos:</label>
                <span v-if="carregandoCargos" class="ms-2">
                    <i class="fa-solid fa-spinner fa-spin"></i>
                </span>
                <select v-if="!cargos.length" class="form-select" disabled></select>            
                <select class="form-select" ref="cargosInput" id="cargos" v-for="(cargo, index) in cargos" :key="cargo.id" @change="listarProvas">                    
                    <option v-if="index === 0" value=""></option>
                    <option :value="cargo.id">{{cargo.descricao}}</option>
                </select>
            </div>
            <div class="col-md-6">                
                <label for="provas" class="mb-3">Provas:</label>
                <span v-if="carregandoProvas" class="ms-2">
                    <i class="fa-solid fa-spinner fa-spin"></i>
                </span>
                <select v-if="!provas.length" class="form-select" disabled></select>
                <select v-else class="form-select" id="provas" v-for="(prova, index) in provas" :key="prova.id" @change="listarAssuntos">
                    <option v-if="index === 0" value=""></option>
                    <option :value="prova.id">{{prova.descricao}}</option>
                </select>
            </div>            
        </div>
        <div class="row">
            <div class="col-md-6">
                <label for="materias" class="mb-3">Matérias:</label>
                <span v-if="carregandoAssuntos" class="ms-2">
                    <i class="fa-solid fa-spinner fa-spin"></i>
                </span>
                <select v-if="!assuntos.length" class="form-select" disabled></select>
                <select v-else class="form-select" ref="assuntos" @change="configurarInicio">
                    <optgroup :label="assunto.descricao + ' ' + assunto.ano" v-for="(assunto, index) in assuntos" :key="assunto.id">
                        <option :value="assunto.id">{{assunto.materia}}</option>
                    </optgroup>                    
                </select>
            </div>
        </div>
        <div class="row invisible" id="jogo">
            <div class="col-md-6 mt-3">
                <button type="button" id="pergunta" class="btn btn-primary w-100 fw-bold">Pergunta</button>
                <input type="hidden" id="minhaResposta" />
            </div>
            <div class="col-md-6 mt-3 mb-5">
                <div class="row" v-if="carregandoPergunta">                    
                    <div class="col-12">
                        <button type="button" id="btn1" onclick="configurarResposta(this.value)" class="btn btn-dark w-100 mb-2 text-start btna disabled">Opção 1</button>
                    </div>
                    <div class="col-12">
                        <button type="button" id="btn2" onclick="configurarResposta(this.value)" class="btn btn-dark w-100 mb-2 text-start btna disabled">Opção 2</button>
                    </div>
                    <div class="col-12">
                        <button type="button" id="btn3" onclick="configurarResposta(this.value)" class="btn btn-dark w-100 mb-2 text-start btna disabled">Opção 3</button>
                    </div>
                    <div class="col-12">
                        <button type="button" id="btn4" onclick="configurarResposta(this.value)" class="btn btn-dark w-100 mb-2 text-start btna disabled">Opção 4</button>
                    </div>
                    <div class="col-12">
                        <button type="button" id="btn5" onclick="configurarResposta(this.value)" class="btn btn-dark w-100 mb-2 text-start btna disabled">Opção 5</button>
                    </div>
                </div>
            </div>            
        </div>
        <div class="row mt-3" id="gameover" style="display: none;">
            <div class="col-12">
                <div class="alert alert-primary p-3 text-center border border-5 border-success">
                    <h2><i class="bi bi-award-fill text-warning"></i> Prova Concluída</h2>
                    <i class="bi bi-trophy-fill text-primary trophy" style="font-size: 5rem;"></i>
                    <h4 class="fw-bold text-dark">Acertos: <span id="acertos2" class="text-primary"></span> Erros: <span id="erros2" class="text-danger"></span> Porcentagem: <span id="porcentagem2" class="text-success"></span></h4>
                </div>
            </div>
        </div>        
    </div>

    <script>

        const iniciarBtn = document.querySelector("#iniciar")

        function configurarInicio() {
            let provaSelect = document.querySelector("#provas")
            let materiaSelect = document.querySelector("#materias")
            let button = document.querySelector("#iniciar")
            if(provaSelect.value !== "" && materiaSelect.value !== "") {
                button.classList.remove("disabled")
            }
            else {
                button.classList.add("disabled")
            }             
        }

        iniciarBtn.addEventListener("click", (e) => {
            e.target.classList.add("disabled")
            let c = document.querySelector("#cargos")
            let p = document.querySelector("#provas") 
            let m = document.querySelector("#materias")            
            let jogoDiv = document.querySelector("#jogo")
            if(p.value !== "") {
                jogoDiv.classList.remove("invisible")
                carregarPerguntas(p, m)
                p.setAttribute("disabled", "")
                c.setAttribute("disabled", "")
                m.setAttribute("disabled", "")
            }            
        })

    </script>

    <script src="./js/questoes.js"></script>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="./js/app.js"></script>

</body>

</html>