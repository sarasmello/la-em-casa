//Modal editar produto
function abrirModalEditarProduto(id, nome, categoria_id) {
    document.getElementById("produtoId").value = id;
    document.getElementById("nomeProduto").value = nome;
    document.getElementById("categoriaProduto").value = categoria_id;

    document.getElementById("modalEditarProduto").style.display = "block";
}

function fecharModalEditarProduto() {
    document.getElementById("modalEditarProduto").style.display = "none";
}

// modal editar categoria
function abrirModalEditarCategoria(id, nome) {
    document.getElementById("categoriaId").value = id;
    document.getElementById("nomeCategoria").value = nome;

    document.getElementById("modalEditarCategoria").style.display = "block";
}

function fecharModalEditarCategoria() {
    document.getElementById("modalEditarCategoria").style.display = "none";
}