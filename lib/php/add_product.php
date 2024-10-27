<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $nova_categoria = trim($_POST['nova_categoria']);
    $categoria_id = $_POST['categoria'];
    
    /* Categoria
    Verifica se pelo menos uma categoria é fornecida*/
    if (empty($categoria_id) && empty($nova_categoria)) {
        echo "Você deve selecionar uma categoria existente ou adicionar uma nova categoria.";
        exit; 
    }

    // Se uma nova categoria for fornecida, verificar se já existe no banco
    if (!empty($nova_categoria)) {
        // Consulta para verificar se a categoria já existe
        $stmt_check = $conn->prepare("SELECT id FROM categorias WHERE nome = ?");
        $stmt_check->bind_param("s", $nova_categoria);
        $stmt_check->execute();
        $stmt_check->store_result();

        // Se a categoria já existir, informar ao usuário
        if ($stmt_check->num_rows > 0) {
            echo "Categoria já cadastrada.";
            $stmt_check->close();
            exit; 
        }

        $stmt_check->close();

        // Se não existir, insere a nova categoria
        $stmt_categoria = $conn->prepare("INSERT INTO categorias (nome) VALUES (?)");
        $stmt_categoria->bind_param("s", $nova_categoria);

        if ($stmt_categoria->execute()) {
            // Obter novo ID da categoria
            $categoria_id = $conn->insert_id; 
        } else {
            echo "Erro ao adicionar nova categoria: " . $stmt_categoria->error;
            exit;
        }

        $stmt_categoria->close();
    }

    /* Produto
    Verifica se o produto já existe antes de adicionar*/ 
    $stmt_check_produto = $conn->prepare("SELECT id FROM produtos WHERE nome = ?");
    $stmt_check_produto->bind_param("s", $nome);
    $stmt_check_produto->execute();
    $stmt_check_produto->store_result();

    // Se o produto já existir, retorna uma mensagem e sai
    if ($stmt_check_produto->num_rows > 0) {
        echo "Produto já cadastrado.";
        $stmt_check_produto->close();
        exit; // Para a execução se o produto já existir
    }

    $stmt_check_produto->close();

    // Insere o produto com a categoria selecionada ou a nova categoria na tabela produtos
    $stmt_produto = $conn->prepare("INSERT INTO produtos (nome, categoria_id) VALUES (?, ?)");
    $stmt_produto->bind_param("si", $nome, $categoria_id);

    if ($stmt_produto->execute()) {
        echo "Produto adicionado com sucesso!";
    } else {
        echo "Erro ao adicionar produto: " . $stmt_produto->error;
    }

    $stmt_produto->close();
}

$conn->close();
