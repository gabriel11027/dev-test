// Formação selecionada na página de cursos
$(document).ready(function() {
    var url = new URL(window.location);
    var cursoSelecionado = url.searchParams.get("curso");

    if(cursoSelecionado) {
        curso = "option[value='" + cursoSelecionado + "']";
        $("option[value=" + cursoSelecionado + "]").attr("selected", true);
    }
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

$("button[name='btn-primeira-etapa'], button[name='btn-segunda-etapa']").click(function(e) {
    e.preventDefault();
    mostrarProximaEtapa($(this).attr("name").slice(4));
});


$("button[name='submeter-primeira-etapa']").on("click", function(e) {
    e.preventDefault();
    mostrarProximaEtapa("segunda-etapa");

    data_input = {
        "submeter-primeira-etapa": true,
        "inputNomeCompleto": $("#inputNomeCompleto").val(),
        "inputEmail": $("#inputEmail").val(),
        "inputTelefone": $("#inputTelefone").val(),
        "inputCursoSelecionado": $("#inputCursoSelecionado").val()
    }

    $.ajax({
        type: "POST",
        url: "matricula.php",
        data: data_input,
        dataType: "json",
        encode: true
    }).done(function (data) {
        // Mostrar erros
    });
}); 

$("button[name='submeter-segunda-etapa']").on("click", function(e) {
    e.preventDefault();
    mostrarProximaEtapa("terceira-etapa");
});

$("button[name='submeter-terceira-etapa']").on("click", function(e) {

});

$(window).bind("beforeunload", function() {
       // Salvar formulário antes de fechar a janela
}); 