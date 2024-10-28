<?php
$pageTitle = "Categorias";
include './lib/includes/header.php';
?>

<?php
$sql = "SELECT id, nome FROM categorias";
$result = $conn->query($sql);
?>

<body>
    <h3>Categorias Cadastradas</h3>

    <!-- adicionar nova categoria -->
    <form action="./lib/php/add_category.php" method="POST">
        <label for="novaCategoria">Nova Categoria:</label>
        <input type="text" name="nome" id="novaCategoria" required>
        <button type="submit">Adicionar Categoria</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Consulta para buscar categorias cadastradas
            $sql_categorias = "SELECT id, nome FROM categorias";
            $result_categorias = $conn->query($sql_categorias);

            if ($result_categorias->num_rows > 0) {
                while ($row_categoria = $result_categorias->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row_categoria['nome']}</td>
                        <td>
                            <a href='javascript:void(0);' onclick='abrirModalEditarCategoria({$row_categoria['id']}, \"{$row_categoria['nome']}\")'>Editar</a> |
                            <a href='./lib/php/delete_category.php?id={$row_categoria['id']}' onclick='return confirm(\"Tem certeza que deseja excluir esta categoria?\")'>Excluir</a>
                        </td>
                      </tr>";
                }
            } else {
                echo "<tr><td colspan='2'>Nenhuma categoria cadastrada.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Modal para editar categoria -->
    <div id="modalEditarCategoria" style="display:none;">
        <form id="formEditarCategoria" action="./lib/php/update_category.php" method="POST">
            <input type="hidden" name="id" id="categoriaId">

            <label for="nomeCategoria">Nome da Categoria:</label>
            <input type="text" name="nome" id="nomeCategoria" required><br><br>

            <button type="submit">Salvar Alterações</button>
            <button type="button" onclick="fecharModalEditarCategoria()">Cancelar</button>
        </form>
    </div>

    <script src="./lib/js/modal-editar.js"></script>

    <?php $conn->close(); ?>

</body>

</html>
