// Formação selecionada na página de cursos
$(document).ready(function() {
    var url = new URL(window.location);
    var cursoSelecionado = url.searchParams.get("curso");

    if(cursoSelecionado) {
        curso = "option[value='" + cursoSelecionado + "']";
        $("option[value=" + cursoSelecionado + "]").attr("selected", true);
    }

    $("#inputTelefone").mask("(99) 99999-9999");
    $("#inputCEP").mask("99999-999");
    $("#inputCPF").mask("999.999.999-99");
    $("#inputNascimento").mask("99/99/9999");
    mostrarProximaEtapa("terceira-etapa");

});


// Mostrar somente a etapa atual
function mostrarProximaEtapa(proximaEtapa)
{
    var etapas = ["primeira-etapa", "segunda-etapa", "terceira-etapa"];
    etapas = etapas.filter(string => string != proximaEtapa);

    etapas.forEach(function(etapa) {
        $("." + etapa).addClass("d-none");
    })
    $("." + proximaEtapa).removeClass("d-none");
}

function mostrarErros(erros) 
{
    // Tabela para mapear os erros do servidor para os inputs do formulário
    erro_formulario = {
        "erro_nome"      : "inputNomeCompleto",
        "erro_email"     : "inputEmail",
        "erro_telefone"  : "inputTelefone",
        "erro_curso"     : "inputCursoSelecionado",
        "erro_nascimento": "inputNascimento",
        "erro_cep"       : "inputCEP",
        "erro_cpf"       : "inputCPF"
    }

    for (const [chave, valor] of Object.entries(erro_formulario)) {
        if (erros.includes(chave)) {
            $("#" + valor).addClass("is-invalid");
            $("#" + valor).removeClass("is-valid");
        } else {
            $("#" + valor).removeClass("is-invalid");
        }
    }
}


$("button[name='btn-primeira-etapa'], button[name='btn-segunda-etapa']").click(function(e) {
    e.preventDefault();
    mostrarProximaEtapa($(this).attr("name").slice(4));
});


$("button[name='submeter-primeira-etapa']").on("click", function(e) {
    e.preventDefault();

    dados_primeira_etapa = {
        "submeter-primeira-etapa": true,
        "inputNomeCompleto"      : $("#inputNomeCompleto").val(),
        "inputEmail"             : $("#inputEmail").val(),
        "inputTelefone"          : $("#inputTelefone").val(),
        "inputCursoSelecionado"  : $("#inputCursoSelecionado").val()
    }
    
    $.ajax({
        url     : "php/matricula.php",
        type    : "POST",
        data    : dados_primeira_etapa,
        dataType: "json",
        encode  : true
    }).done(function (resposta_servidor) {
        mostrarErros(resposta_servidor["erros"]);
        if(resposta_servidor["sucesso"] == 1)
            mostrarProximaEtapa("segunda-etapa");
    });
}); 

$("button[name='submeter-segunda-etapa']").on("click", function(e) {
    e.preventDefault();

    dados_segunda_etapa = {
        "submeter-segunda-etapa": true,
        "inputCEP"              : $("#inputCEP").val(),
        "inputCPF"              : $("#inputCPF").val(),
        "inputNascimento"       : $("#inputNascimento").val()
    }
    
    $.ajax({
        url     : "php/matricula.php",
        type    : "POST",
        data    : dados_segunda_etapa,
        dataType: "json",
        encode  : true
    }).done(function (resposta_servidor) {
        mostrarErros(resposta_servidor["erros"])
        if(resposta_servidor["sucesso"] == 1)
            mostrarProximaEtapa("terceira-etapa");
    });
});

$("button[name='submeter-terceira-etapa']").on("click", function(e) {
    e.preventDefault();

    var dados_terceira_etapa = new FormData();
    dados_terceira_etapa.append("submeter-terceira-etapa", true)
    dados_terceira_etapa.append("inputDocumento", document.getElementById("inputDocumento").files[0]);

    $.ajax({
        url        : "php/matricula.php",
        type       : "POST",
        data       : dados_terceira_etapa,
        processData: false, 
        contentType: false
    }).done(function (resposta_servidor) {
        console.log(resposta_servidor)
        if (JSON.parse(resposta_servidor)["sucesso"] == 1) {
            $(".terceira-etapa").addClass("d-none");
            $(".sucesso").removeClass("d-none");
        }
    });

});