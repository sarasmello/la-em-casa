<?php
include $_SERVER['DOCUMENT_ROOT'] . '/la-em-casa/lib/php/db_connection.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); 

    // Preparar a consulta para excluir o produto
    $sql = "DELETE FROM produtos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // retornar para o mesmo local
        header("Location: /la-em-casa/add_produto.php");
        exit;
    } else {
        echo "Erro ao excluir o produto: " . $conn->error;
    } 
}

$conn->close();
?>
