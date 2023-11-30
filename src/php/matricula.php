<?php

    // Ativar sessão. Referência: https://www.php.net/manual/en/function.session-status.php
    // A sessão será utilizada para salvar as informações já preenchidas 
    
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Primeira etapa
    if (isset($_POST["submeter-primeira-etapa"])) {       
        $resposta = array();
        $erros = array();
        $sucesso = 1;

        $inputNomeCompleto = htmlspecialchars($_POST["inputNomeCompleto"]);
        $inputCursoSelecionado = ($_POST["inputCursoSelecionado"]); 
        $inputEmail = ($_POST["inputEmail"]); 
        $inputTelefone = str_replace(array("(", ")", "-", " "), "", $_POST["inputTelefone"]); 


        // Validação da primeira etapa
        
        // Nome inválido
        if (strlen($inputNomeCompleto) > 255 || strlen($inputNomeCompleto) < 5) {
            array_push($erros, "erro_nome");
            $sucesso = 0;
        }

        // Curso não selecionado
        if (empty($inputCursoSelecionado)) {
            array_push($erros, "erro_curso");
            $sucesso = 0;
        }

        // Email inválido 
        if (!filter_var($inputEmail, FILTER_VALIDATE_EMAIL)) {
            array_push($erros, "erro_email");
            $sucesso = 0;
        }
       
        // Telefone inválido (contém números) ou (tamanho != 9 e tamanho !=11)
        if (!preg_match("/^\d{11}$/", $inputTelefone)) {
            array_push($erros, "erro_telefone");
            $sucesso = 0;
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
                $_SESSION["EMAIL"] == $inputEmail && $_SESSION["TELEFONE"] = $inputTelefone ) 
            {
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


    // Segunda etapa
    if (isset($_POST["submeter-segunda-etapa"])) {
        $resposta = array();
        $erros = array();
        $sucesso = 1;
    
        $inputCEP = $_POST["inputCEP"];
        $inputCPF = $_POST["inputCPF"]; 
        $inputNascimento = $_POST["inputNascimento"];
        list($dia, $mes, $ano) = explode("/", $inputNascimento);
            
        // Validar data de nascimento
        if (!preg_match("/^\d{2}\/\d{2}\/\d{4}$/", $inputNascimento) || !checkdate($mes, $dia, $ano)) {
            array_push($erros, "erro_nascimento");
            $sucesso = 0;
        }

        // Validar CEP (somente 8 números)
        if (!preg_match("/^\d{5}\-\d{3}$/", $inputCEP)) {
            array_push($erros, "erro_cep");
            $sucesso = 0;
        }

        // Validar CPF (somente 11 números)
        if (!preg_match("/^\d{3}\.\d{3}\.\d{3}\-\d{2}$/", $inputCPF)) {
            array_push($erros, "erro_cpf");
            $sucesso = 0;
        }

        if ($sucesso) {
            $_SESSION["CEP"] = $inputCEP;
            $_SESSION["CPF"] = $inputCPF;
            $_SESSION["DATA_DE_NASCIMENTO"] = $inputNascimento;
        }

        $resposta["erros"] = $erros;
        $resposta["sucesso"] = $sucesso;
        array_push($resposta, $erros);
        echo json_encode($resposta);
    }

    if (isset($_POST["submeter-terceira-etapa"])) {
        $resposta = array();
        $erros = array();
        $sucesso = 1;

        $documento = $_FILES["inputDocumento"]["tmp_name"];
        $tamanho = filesize($documento);
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $finfo_file = NULL;

        // Valida se algum arquivo foi enviado
        if (!isset($_FILES["inputDocumento"])) {
            array_push($erros, "erro_documento");
            $sucesso = 0;
        } else {
            $finfo_file = finfo_file($finfo, $documento);
        }
      
        // Testa se o formato do arquivo está em pdf
        if ($finfo_file != "application/pdf") {
            array_push($erros, "erro_pdf");
            $sucesso = 0;
        }

        $resposta["erros"] = $erros;
        $resposta["sucesso"] = $sucesso;
        echo json_encode($resposta);
    }
?>