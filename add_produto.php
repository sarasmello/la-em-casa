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
            if ($result->num_rows > 0) {
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

    <!-- Exibição Produtos cadastrados no banco de dados -->
    <h3>Produtos Cadastrados</h3>
    <table>
        <thead>
            <tr>
                <th>Produto</th>
                <th>Categoria</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql_produtos = "SELECT p.id, p.nome AS produto_nome, c.nome AS categoria_nome, p.categoria_id 
                             FROM produtos p 
                             LEFT JOIN categorias c ON p.categoria_id = c.id";
            $result_produtos = $conn->query($sql_produtos);

            if ($result_produtos->num_rows > 0) {
                while ($row_produto = $result_produtos->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row_produto['produto_nome']}</td>
                            <td>{$row_produto['categoria_nome']}</td>
                            <td>
                                <a href='javascript:void(0);' onclick='abrirModalEditarProduto({$row_produto['id']}, \"{$row_produto['produto_nome']}\", \"{$row_produto['categoria_id']}\")'>Editar</a> |
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

    <!-- Modal para editar produto -->
    <div id="modalEditarProduto" style="display:none;">
        <form id="formEditar" action="./lib/php/update_product.php" method="POST">
            <input type="hidden" name="id" id="produtoId">

            <label for="nomeProduto">Nome do Produto:</label>
            <input type="text" name="nome" id="nomeProduto" required><br><br>

            <label for="categoriaProduto">Categoria:</label>
            <select name="categoria_id" id="categoriaProduto">
                <?php
                $sql_categorias = "SELECT id, nome FROM categorias";
                $result_categorias = $conn->query($sql_categorias);

                if ($result_categorias->num_rows > 0) {
                    while ($row_categoria = $result_categorias->fetch_assoc()) {
                        echo "<option value='{$row_categoria['id']}'>{$row_categoria['nome']}</option>";
                    }
                }
                ?>
            </select><br><br>

            <button type="submit">Salvar Alterações</button>
            <button type="button" onclick="fecharModalEditarProduto()">Cancelar</button>
        </form>
    </div>

    <script src="./lib/js/modal-editar.js"></script>

    <?php $conn->close(); ?>
</body>

</html>