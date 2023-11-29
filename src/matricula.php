<?php

    // Ativar sessão. Referência: https://www.php.net/manual/en/function.session-status.php
    // A sessão será utilizada para salvar as informações já preenchidas caso o usuário não
    // complete o formulário

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Primeira etapa
    if (isset($_POST['submeter-primeira-etapa']))
    {       
        $response = array();
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
            array_push($erro, "erro_nome");
        }

        // Curso não selecionado
        if (empty($inputCursoSelecionado)) {
            $sucesso = 0;
            array_push($erro, "erro_curso");
        }

        // Email inválido 
        if (!filter_var($inputEmail, FILTER_VALIDATE_EMAIL)) {
            $sucesso = 0;
            array_push($erros, "erro_email");
        }
       
        // Telefone inválido (contém letras) ou (tamanho != 9 e tamanho !=11)
        if (!preg_match("/^\d+$/", $inputTelefone) || (strlen($inputTelefone) != 9 && strlen($inputTelefone) != 11)) {
            $sucesso = 0;
            array_push($erros, "erro_telefone");
        }
        
        array_push($response, $erros, $sucesso);
        echo json_encode($response);
    }
?>