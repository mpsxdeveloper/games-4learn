let question = "";
let respostaCorreta = "";
let erros = 0;
var jogando = false;
var intervalo;
var resultado = 0;
var pergunta = "";
var acertos = 0;
var perguntas = '';
var quantidade;
let prova_id = ""
 
function carregarPerguntas(p, m) {
    questoesFormData = new FormData()
    questoesFormData.append("query", "list")
    questoesFormData.append("prova_id", p.value)
    questoesFormData.append("assunto_id", m.value)
    prova_id = p.value
    fetch('../../controllers/QuestaoController.php', {
        method: "POST",
        body: questoesFormData,
        headers: {
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then((data) => {
        perguntas = data
        quantidade = perguntas.length
        jogando = true
        enableButtons()
        repetir()
    })    
}
 
function repetir() {
    if(jogando === true && perguntas.length > 0) {        
        criarPergunta();
    }
}
    
function disableButtons() {
    for(var i = 1; i < 6; i++) {
        var btn = document.getElementById("btn" + i);
        btn.classList.add("disabled");
    }
}

function enableButtons() {
    for(let i = 1; i < 6; i++) {
        let btn = document.getElementById("btn" + i);
        btn.classList.remove("disabled");
    }
}
    
function createGameOver() {
    document.getElementById("jogo").style.display = "none"
    document.getElementById("gameover").style.display = "block"    
    document.querySelector("#acertos2").innerHTML = acertos
    document.querySelector("#erros2").innerHTML = erros
    document.querySelector("#porcentagem2").innerHTML = ((acertos / quantidade) * 100).toFixed(2) + '%'
    const fd = new FormData()
    fd.append("query", "register")
    fd.append("prova_id", prova_id)
    fetch('../controllers/ConquistaController.php', {
        method: 'POST',
        body: fd,
        headers: {
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {        
    })
}
    
function configurarResposta(resposta) {
    if(!jogando) {
        document.getElementById("minhaResposta").value = resposta;
        checkAnswers();
    }
}
    
function checkAnswers() {        
    for(var i = 1; i < 6; i++) {
        var btn = document.getElementById("btn" + i);
        btn.blur();
    }
    var resposta = document.getElementById("minhaResposta").value;        
        if(resposta === respostaCorreta) {
            acertos++;
            document.getElementById("acertos").innerHTML = acertos;
        }
        else {
            erros++;            
            document.getElementById("erros").innerHTML = erros;        
        }
        document.getElementById("porcentagem").innerHTML = ((acertos / quantidade) * 100).toFixed(2) + '%';
        if(perguntas.length === 0) {                      
            jogando = false;            
            for(var i = 1; i < 6; i++) {
                var btn = document.getElementById("btn" + i);
                btn.classList.add("disabled");
            }
            createGameOver();
        }
        else {
            jogando = true
            repetir();
        }        
    }
    
    function criarPergunta() {
        if(jogando) {            
            let numero = perguntas.length;
            let questaoAtual = null;
            if(numero > 0) {
                questaoAtual = perguntas[0]
                perguntas = perguntas.filter(pergunta => questaoAtual.id !== pergunta.id)                
            }            
            respostaCorreta = questaoAtual.gabarito;            
            imprimirAlternativas(questaoAtual);
        }
    }
    
    function imprimirAlternativas(question) {
        var pergunta = document.getElementById("pergunta")
        pergunta.innerHTML = question.pergunta               
        var b1 = document.getElementById("btn1");
        b1.innerHTML = question.resposta1; b1.value = "A";
        var b2 = document.getElementById("btn2");
        b2.innerHTML = question.resposta2; b2.value = "B";
        var b3 = document.getElementById("btn3");
        b3.innerHTML = question.resposta3; b3.value = "C";
        var b4 = document.getElementById("btn4");
        b4.innerHTML = question.resposta4; b4.value = "D";
        var b5 = document.getElementById("btn5");
        b5.innerHTML = question.resposta5; b5.value = "E";
        jogando = false;
    }