$(document).ready(function() {
    var url = new URL(window.location);
    var cursoSelecionado = url.searchParams.get("curso");
    
    console.log(cursoSelecionado)
});

