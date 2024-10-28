<?php
include 'db_connection.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Verificar se a categoria está associada a algum produto
    $check_sql = "SELECT COUNT(*) AS total FROM produtos WHERE categoria_id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("i", $id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    $row = $check_result->fetch_assoc();

    if ($row['total'] > 0) {
        // Se houver produtos associados, exibir os produtos.
        $produtos_sql = "SELECT nome FROM produtos WHERE categoria_id = ?";
        $produtos_stmt = $conn->prepare($produtos_sql);
        $produtos_stmt->bind_param("i", $id);
        $produtos_stmt->execute();
        $produtos_result = $produtos_stmt->get_result();

        // mensagem de erro com a lista de produtos
        $produtos_lista = [];
        while ($produto = $produtos_result->fetch_assoc()) {
            $produtos_lista[] = $produto['nome'];
        }
        $produtos_texto = implode(', ', $produtos_lista);
        echo "Não foi possível excluir a categoria porque está associada a um ou mais produtos: $produtos_texto.";
    } else {
        // Preparar a consulta para excluir a categoria se não houver produtos associados.
        $sql = "DELETE FROM categorias WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            // Retornar para a página de categorias após exclusão
            header("Location: /la-em-casa/categorias.php");
            exit;
        } else {
            echo "Erro ao excluir a categoria: " . $conn->error;
        }
    }
}

$conn->close();
?>
