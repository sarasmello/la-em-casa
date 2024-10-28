<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $nome = trim($_POST['nome']);

    // Verificar se o nome não está vazio
    if (!empty($nome)) {
        $sql = "UPDATE categorias SET nome = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $nome, $id);

        if ($stmt->execute()) {
            header("Location: /la-em-casa/categorias.php"); 
            exit;
        } else {
            echo "Erro ao atualizar a categoria: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "O nome da categoria não pode estar vazio.";
    }
}

$conn->close();
?>
