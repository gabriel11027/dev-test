// Adiciona a classe d-none aos cursos filtrados
function filtarCursos(dataCursos) 
{
    $(".col-8").each(function (curso) {
        curso += 1;
        if (!dataCursos.includes($("#curso" + curso).attr("id"))) {
            $("#curso" + curso).addClass("d-none");
        } else {
            $("#curso" + curso).removeClass("d-none");
        }
    })
}

function submeterPesquisa()
{
    data_input = $("#formBuscar").serialize();
    console.log(data_input)
    $.ajax({
        type: "POST",
        url: "php/buscar.php",
        data: data_input,
        dataType: "json",
        encode: true
    }).done(function (data) {
        filtarCursos(data);
    });
}


$("#formBuscar").on("keyup change paste", "input, select", function() {
    submeterPesquisa();
}).submit(function(e) {
    submeterPesquisa();
    e.preventDefault();
});


$(".matricula").on("click", function() {
    var matricula = "./matricula.html?curso=" + $(this).parent().parent().attr("id"); 

    if(matricula) {
        window.location = matricula;
    }
});