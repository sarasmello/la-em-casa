<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = trim($_POST['nome']);

    if (!empty($nome)) {
        // Verificar se a categoria já existe
        $check_sql = "SELECT COUNT(*) AS total FROM categorias WHERE nome = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("s", $nome);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        $row = $check_result->fetch_assoc();

        if ($row['total'] > 0) {
            // Se a categoria já existir, exibe uma mensagem de erro
            echo "A categoria '$nome' já está cadastrada.";
        } else {
            // Preparar a consulta para inserir a nova categoria
            $sql = "INSERT INTO categorias (nome) VALUES (?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $nome);

            if ($stmt->execute()) {
                // Redirecionar para a página de categorias após a inserção
                header("Location: /la-em-casa/categorias.php");
                exit;
            } else {
                echo "Erro ao adicionar a categoria: " . $conn->error;
            }
        }
    } else {
        echo "O nome da categoria não pode estar vazio.";
    }
}

$conn->close();
?>
