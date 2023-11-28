$(document).ready(function() {
    var url = new URL(window.location);
    var cursoSelecionado = url.searchParams.get("curso");

    if(cursoSelecionado) {
        curso = "option[value='" + cursoSelecionado + "']";
        $("option[value=" + cursoSelecionado + "]").attr("selected", true);
    }
});

