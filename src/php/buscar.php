<?php
    // Nome do curso
    $cursoPesquisado = htmlspecialchars($_POST["barraDePesquisa"]);

    // Tipo
    $tipoGraduacao = $_POST["tipoGraduacao"];
    $tipoPosGraduacao = $_POST["tipoPosGraduacao"];

    // Modalidade
    $modalidadeEAD = $_POST["modalidadeEAD"];
    $modalidadePresencial = $_POST["modalidadePresencial"];

    $servidor = "localhost";
    $database = "CURSOS";
    $username = "root";
    $password = "";
    
    // Conectar MySQL 
    $conn = mysqli_connect($servidor, $username, $password, $database);
        
    // Falha na conexão 
    if (!$conn)  {
        exit("Erro de conexão a base de dados: " . mysqli_connect_error());
    }

    $sql_query = "SELECT * FROM CURSOS_DISPONIVEIS WHERE 
                  NOME LIKE '%{$cursoPesquisado}%'";

    // Tipo 
    if (isset($tipoGraduacao) && !isset($tipoPosGraduacao)) {
        $sql_query = $sql_query . " AND TIPO = 'graduação'";
    }  
    elseif (!isset($tipoGraduacao) && isset($tipoPosGraduacao)) {
        $sql_query = $sql_query . " AND TIPO = 'pós-graduação'";
    }
        
    // Modalidade
    if (isset($modalidadeEAD) && !isset($modalidadePresencial)) {
        $sql_query = $sql_query . " AND MODALIDADE = 'ead'";
    }  
    elseif (!isset($modalidadeEAD) && isset($modalidadePresencial)) {
        $sql_query = $sql_query . " AND MODALIDADE = 'presencial'";
    }

    $query_result = mysqli_query($conn, $sql_query);
    $cursos_encontrados = array();

    if (mysqli_num_rows($query_result) > 0) {
        while($row = mysqli_fetch_assoc($query_result)) {
            array_push($cursos_encontrados, "curso" . $row["ID"]);
        }
    } 
    
    header('Content-type: application/json');
    echo json_encode($cursos_encontrados);

    mysqli_close($conn);
?>