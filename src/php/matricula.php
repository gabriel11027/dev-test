<?php

    // Ativar sessão. Referência: https://www.php.net/manual/en/function.session-status.php
    // A sessão será utilizada para salvar as informações já preenchidas 
    
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Primeira etapa
    if (isset($_POST['submeter-primeira-etapa'])) {       
        $resposta = array();
        $erros = array();
        $sucesso = 1;

        $inputNomeCompleto = htmlspecialchars($_POST["inputNomeCompleto"]);
        $inputCursoSelecionado = ($_POST["inputCursoSelecionado"]); 
        $inputEmail = ($_POST["inputEmail"]); 
        $inputTelefone = str_replace(array("(", ")", "-"), "", $_POST["inputTelefone"]); 


        // Validação da primeira etapa
        
        // Nome inválido
        if (strlen($inputNomeCompleto) > 255 || strlen($inputNomeCompleto) < 5) {
            $sucesso = 0;
            array_push($erros, "erro_nome");
        }

        // Curso não selecionado
        if (empty($inputCursoSelecionado)) {
            $sucesso = 0;
            array_push($erros, "erro_curso");
        }

        // Email inválido 
        if (!filter_var($inputEmail, FILTER_VALIDATE_EMAIL)) {
            $sucesso = 0;
            array_push($erros, "erro_email");
        }
       
        // Telefone inválido (contém números) ou (tamanho != 9 e tamanho !=11)
        if (!preg_match("/^\d+$/", $inputTelefone) || (strlen($inputTelefone) != 9 && strlen($inputTelefone) != 11)) {
            $sucesso = 0;
            array_push($erros, "erro_telefone");
        }
        
        if ($sucesso) {
            $sql_insert = "INSERT INTO ALUNOS_POTENCIAIS(NOME_COMPLETO, CURSO, EMAIL, TELEFONE) VALUES".
                          "('{$inputNomeCompleto}', '{$inputCursoSelecionado}',".
                          "'{$inputEmail}', '{$inputTelefone}')";
            
            // Conectar MySQL 
            $conn = mysqli_connect("localhost", "root", "", "ALUNOS");
        
            // Falha na conexão 
            if (!$conn) {
                exit("Erro de conexão a base de dados: " . mysqli_connect_error());
            }

            $houve_mudança = 1;

            // Checa se o usuário voltou para mudar algum dado, a fim de evitar entras repetidas na base de dados
            if ($_SESSION["NOME"] == $inputNomeCompleto && $_SESSION["CURSO"] = $inputCursoSelecionado &&
                $_SESSION["EMAIL"] == $inputEmail && $_SESSION["TELEFONE"] = $inputTelefone ) {
                    $houve_mudança = 0;
            }

            if ($houve_mudança == 1 && mysqli_query($conn, $sql_insert)) {
                $resposta["aluno_cadastrado"] = 1;
            } else {
                array_push($erros, "erro_banco_de_dados");
            }

            $_SESSION["NOME"] = $inputNomeCompleto;
            $_SESSION["CURSO"] = $inputCursoSelecionado;
            $_SESSION["EMAIL"] = $inputEmail;
            $_SESSION["TELEFONE"] = $inputTelefone;
        }

        $resposta["erros"] = $erros;
        $resposta["sucesso"] = $sucesso;
        echo json_encode($resposta);
        }
?>