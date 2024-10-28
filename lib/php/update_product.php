<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $nome = trim($_POST['nome']);
    $categoria_id = intval($_POST['categoria_id']);

    $sql = "UPDATE produtos SET nome = ?, categoria_id = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sii", $nome, $categoria_id, $id);

    if ($stmt->execute()) {
        header("Location: /la-em-casa/add_produto.php") ;
        exit;
    } else {
        echo "Erro ao atualizar o produto: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
