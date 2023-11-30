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

        // Conectar MySQL 
        $conn_alunos = mysqli_connect("localhost", "root", "", "ALUNOS");
        
        // Falha na conexão 
        if (!$conn_alunos) {
            exit("Erro de conexão a base de dados: " . mysqli_connect_error());
        }
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
        } else {
            // Valida se o email já não foi cadastrado
            $sql_query_email = "SELECT * FROM ALUNOS_MATRICULADOS WHERE EMAIL='{$inputEmail}'";
            $query_result = mysqli_query($conn_alunos, $sql_query_email);

            if (mysqli_num_rows($query_result) != 0) {
                array_push($erros, "erro_email");
                $sucesso = 0;
            }
        }
        mysqli_close($conn_alunos);

        // Telefone inválido (contém números) ou (tamanho != 9 e tamanho !=11)
        if (!preg_match("/^\d{11}$/", $inputTelefone)) {
            array_push($erros, "erro_telefone");
            $sucesso = 0;
        }
        
        if ($sucesso) {
            $sql_insert = "INSERT INTO ALUNOS_POTENCIAIS(NOME_COMPLETO, CURSO, EMAIL, TELEFONE) VALUES" .
                          "('{$inputNomeCompleto}', '{$inputCursoSelecionado}'," .
                          " '{$inputEmail}',        '{$inputTelefone}')";
            
            // Conectar MySQL 
            $conn = mysqli_connect("localhost", "root", "", "ALUNOS");
        
            // Falha na conexão 
            if (!$conn) {
                exit("Erro de conexão a base de dados: " . mysqli_connect_error());
            }

            $houve_mudança = 1;

            // Checa se o usuário voltou para mudar algum dado, a fim de evitar entras repetidas na base de dados
            if ($_SESSION["NOME_COMPLETO"] == $inputNomeCompleto && $_SESSION["CURSO"] = $inputCursoSelecionado && 
                $_SESSION["EMAIL"] == $inputEmail && $_SESSION["TELEFONE"] = $inputTelefone ) 
            {
                    $houve_mudança = 0;
            }

            if ($houve_mudança == 1 && mysqli_query($conn, $sql_insert)) {
                $resposta["aluno_identificado"] = 1;
            } else {
                array_push($erros, "erro_banco_de_dados");
            }

            $_SESSION["NOME_COMPLETO"] = $inputNomeCompleto;
            $_SESSION["CURSO"] = $inputCursoSelecionado;
            $_SESSION["EMAIL"] = $inputEmail;
            $_SESSION["TELEFONE"] = $inputTelefone;

            mysqli_close($conn);
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
            $_SESSION["CEP"] = str_replace(array("-"), "", $inputCEP);
            $_SESSION["CPF"] = str_replace(array(".", "-"), "", $inputCPF);
            $_SESSION["NASCIMENTO"] = $inputNascimento;
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

        $documento = NULL;
        $extensao = NULL;
        $tamanho = NULL;
        $erro = NULL;

        // Valida se algum arquivo foi enviado
        if (isset($_FILES["inputDocumento"])) {
            $documento = $_FILES["inputDocumento"]["tmp_name"];
            $extensao = $_FILES["inputDocumento"]["type"];
            $tamanho = $_FILES["inputDocumento"]["size"];
            $erro = $_FILES["inputDocumento"]["error"];

        } else {
            array_push($erros, "erro_documento");
            $sucesso = 0;
        }
      
        // Testa se o formato do arquivo está em pdf
        if ($extensao != "application/pdf") {
            array_push($erros, "erro_pdf");
            $sucesso = 0;
        }

        if ($sucesso) {            
            // Enviar arquivo para o servidor
            $target_dir = "./documentos/documento" . $_SESSION["CPF"] . ".pdf";
            $move = move_uploaded_file($_FILES["inputDocumento"]["tmp_name"], $target_dir);

            // Salvar informações na tabela
            $sql_insert = "INSERT INTO ALUNOS_MATRICULADOS (NOME_COMPLETO, CURSO, EMAIL, TELEFONE, NASCIMENTO, CEP, CPF, DOCUMENTO) VALUES" .
                          "('{$_SESSION['NOME_COMPLETO']}', '{$_SESSION['EMAIL']}',".
                          "'{$_SESSION['EMAIL']}',          '{$_SESSION['TELEFONE']}',".
                          "'{$_SESSION['NASCIMENTO']}',     '{$_SESSION['CEP']}'," .
                          "'{$_SESSION['CPF']}',            '{$target_dir}')";

            // Conectar MySQL 
            $conn_alunos = mysqli_connect("localhost", "root", "", "ALUNOS");
        
            // Falha na conexão 
            if (!$conn_alunos) {
                exit("Erro de conexão a base de dados: " . mysqli_connect_error());
            }


            if (mysqli_query($conn_alunos, $sql_insert)) {
                $resposta["aluno_cadastrado"] = 1;
            
                // Remover usuário da lista de alunos potenciais
                $sql_delete = "DELETE FROM `ALUNOS_POTENCIAIS` WHERE EMAIL='{$_SESSION['EMAIL']}'";
                mysqli_query($conn_alunos, $sql_insert);
            } else {
                array_push($erros, "erro_banco_de_dados");
            }

            mysqli_close($conn_alunos);
        }

        $resposta["erros"] = $erros;
        $resposta["sucesso"] = $sucesso;
        echo json_encode($resposta);
    }
?>