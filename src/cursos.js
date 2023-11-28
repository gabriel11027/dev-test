function filtarCursos(dataCursos) 
{
    $(".col-8").each(function (index, obj) {
        if (!dataCursos.includes($(obj).attr("id"))) 
        {
            $(obj).addClass("d-none");
        } 
        else {
            $(obj).removeClass("d-none");
        }
    })
}

function submeterPesquisa()
{
    data_input = $("#formBuscar").serialize();

    $.ajax({
        type: "POST",
        url: "buscar.php",
        data: data_input,
        dataType: "json",
        encode: true
    }).done(function (data) {
        filtarCursos(data);
    });
}


$("#formBuscar").on("keyup change paste", "input, select, textarea", function(){
    submeterPesquisa();
}).submit(function(e) {
    submeterPesquisa();
    e.preventDefault();
});


$(".matricula").on("click", function() {
    var matricula = "./matricula.html?curso=" + $(this).parent().parent().attr("id"); 

    if(curso) {
        window.location = matricula;
    }
});
