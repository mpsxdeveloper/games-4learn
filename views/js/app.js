const { createApp, ref, onMounted } = Vue

createApp({
  setup() {    
    const acertos = ref('0')
    const erros = ref('0')
    const precisao = ref('0')
    const quantidade = ref('0')
    const perguntas = ref([])
    const cargos = ref([])
    const carregandoCargos = ref(false)
    const provas = ref([])
    const carregandoProvas = ref(false)
    const assuntos = ref([])
    const carregandoAssuntos = ref(false)
    const carregandoPergunta = ref(false)

    const cargosInput = ref(null)

    function calcularPrecisao() {
        precisao.value = ((acertos.value / quantidade.value) * 100).toFixed(2) + '%'
    }

    function configurarInicio() {              
        let cargoSelect = document.querySelector("#cargos")
        let provaSelect = document.querySelector("#provas")
        let assuntoSelect = document.querySelector("#assuntos")        
        let button = document.querySelector("#iniciar")
        if(assuntoSelect.value !== "") {
            button.classList.remove("disabled")
        }
        else {
            button.classList.add("disabled")
        }             
    }

    onMounted(() => {        
        listarCargos()        
    })

    function listarCargos() {
        carregandoCargos.value = true
        const formData = new FormData()         
        formData.append("query", "list")
        fetch('../controllers/CargoController.php', {
            method: 'POST',
            body: formData,
            headers: {
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            carregandoCargos.value = false            
            cargos.value = data            
        })
    }

    function listarProvas(e) { 
        console.log(cargosInput.value)
        provas.value = []
        if(e.target.value === "") {
            return
        }
        carregandoProvas.value = true
        const provaData = new FormData()
        let provaSelect = document.querySelector("#provas")
        provaData.append("query", "list")
        provaData.append("cargo_id", e.target.value)
        fetch('../controllers/ProvaController.php', {
            method: 'POST',
            body: provaData,
            headers: {
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            carregandoProvas.value = false
            provas.value = data
        })
    }

    function listarAssuntos(e) {
        assuntos.value = []
        if(e.target.value === "") {
            return
        }
        carregandoAssuntos.value = true
        const materiaData = new FormData()
        materiaData.append("query", "list")
        materiaData.append("prova_id", e.target.value)
        fetch('../controllers/MateriaController.php', {
            method: 'POST',
            body: materiaData,
            headers: {
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {                
            carregandoAssuntos.value = false
            assuntos.value = data
        })
    }

    function listarPergunta(e) {
        alert(materias)
        e.target.classList.add("disabled")
        let c = document.querySelector("#cargos")
        let p = document.querySelector("#provas") 
        let m = document.querySelector("#assuntos")            
        let jogoDiv = document.querySelector("#jogo")
        if(p.value !== "") {
            jogoDiv.classList.remove("invisible")            
            p.setAttribute("disabled", "")
            c.setAttribute("disabled", "")
            m.setAttribute("disabled", "")
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
    }

    return {
      acertos, erros, precisao, cargos, provas, assuntos, carregandoCargos, carregandoProvas, carregandoAssuntos, 
      carregandoPergunta, listarProvas, listarAssuntos, listarPergunta, configurarInicio, calcularPrecisao, cargosInput
    }
  }
}).mount('#app')
