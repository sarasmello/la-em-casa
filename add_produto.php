<?php 
$pageTitle ="Adicionar Produto";
include 'lib/includes/header.php'; 
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

    <?php
    // Fechar a conexão
    $conn->close();
    ?>
</body>

</html>
