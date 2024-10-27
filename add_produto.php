<?php 
$pageTitle = "Adicionar Produto";
include './lib/includes/header.php'; 
?>

<?php
$sql = "SELECT id, nome FROM categorias";
$result = $conn->query($sql);
?>

<body>
    <h1>Adicionar Produto</h1>
    <form action="./lib/php/add_product.php" method="POST">
        <label for="nome">Nome do Produto:</label>
        <input type="text" id="nome" name="nome" required><br><br>

        <label for="categoria">Escolha uma Categoria:</label>
        <select id="categoria" name="categoria">
            <option value="">Selecione uma categoria</option>
            <?php
            // Verifica se há categorias disponíveis
            if ($result->num_rows > 0) {
                // Exibe cada categoria como uma opção na lista suspensa
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>{$row['nome']}</option>";
                }
            }
            ?>
        </select><br><br>

        <label for="nova_categoria">Adicionar Nova Categoria:</label>
        <input type="text" id="nova_categoria" name="nova_categoria" placeholder="Nome da nova categoria"><br><br>

        <input type="submit" value="Adicionar Produto">
    </form>

    <h3>Produtos Cadastrados</h3>
    <table>
        <thead>
            <tr>
                <th>Produto</th>
                <th>Categoria</th>
           
            </tr>
        </thead>
        <tbody>
            <?php
            // Consulta para buscar os produtos cadastrados + categoria
            $sql_produtos = "SELECT p.id, p.nome AS produto_nome, c.nome AS categoria_nome 
                             FROM produtos p 
                             LEFT JOIN categorias c ON p.categoria_id = c.id";
            $result_produtos = $conn->query($sql_produtos);

            if ($result_produtos->num_rows > 0) {
                // Exibição dos produtos na tabela
                while ($row_produto = $result_produtos->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row_produto['produto_nome']}</td>
                            <td>{$row_produto['categoria_nome']}</td>
                            <td>
                                <a href='./lib/php/edit_product.php?id={$row_produto['id']}'>Editar</a> | 
                                <a href='./lib/php/delete_product.php?id={$row_produto['id']}' onclick='return confirm(\"Tem certeza que deseja excluir?\")'>Excluir</a>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='3'>Nenhum produto cadastrado.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <?php
    // Fechar a conexão
    $conn->close();
    ?>
</body>
</html>
