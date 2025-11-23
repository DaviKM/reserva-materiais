<?php
require_once __DIR__ . '/../dao/MaterialDAO.php';

$dao = new MaterialDAO();
$id = isset($_GET['id']) ? $_GET['id'] : '';
if ($id === '') { header('Location: ?entidade=material&acao=listar'); exit; }

$material = $dao->buscarPorId($id);
if (!$material) { echo '<p>Material não encontrado.</p>'; exit; }

$erros = array();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $nome = trim($_POST['nome'] ?? '');
    $categoria = trim($_POST['categoria'] ?? '');
    $quantidade = trim($_POST['quantidade_total'] ?? '');
    $estado = trim($_POST['estado'] ?? 'ativo');
    $descricao = trim($_POST['descricao'] ?? '');

    if ($nome === '') $erros[] = 'Nome é obrigatório.';
    if ($categoria === '') $erros[] = 'Categoria é obrigatória.';
    if ($quantidade === '' || !is_numeric($quantidade) || (int)$quantidade < 0) $erros[] = 'Quantidade total inválida.';

    if (empty($erros)) {
        try {
            $ok = $dao->atualizar($id, $nome, $categoria, (int)$quantidade, $estado, $descricao !== '' ? $descricao : null);
            header('Location: ?entidade=material&acao=listar');
            exit;
        } catch (Exception $e) {
            $erros[] = $e->getMessage();
        }
    }
}

echo '<h2>Editar Material</h2>';
if (!empty($erros)) { echo '<div style="color:#a00">'.implode('<br>', array_map('h', $erros)).'</div>'; }

echo '<form method="post">';
csrf_input();
echo 'Nome: <input type="text" name="nome" value="'.h($material['nome']).'"><br>';
echo 'Categoria: <input type="text" name="categoria" value="'.h($material['categoria']).'"><br>';
echo 'Quantidade total: <input type="number" name="quantidade_total" min="0" value="'.h($material['quantidade_total']).'"><br>';
$selAt = $material['estado'] === 'ativo' ? ' selected' : '';
$selIn = $material['estado'] === 'inativo' ? ' selected' : '';
echo 'Estado: <select name="estado"><option value="ativo"'.$selAt.'>Ativo</option><option value="inativo"'.$selIn.'>Inativo</option></select><br>';
echo 'Descrição:<br><textarea name="descricao" rows="4" cols="50">'.h($material['descricao'] ?? '').'</textarea><br>';
echo '<button type="submit">Salvar</button> ';
echo '<a href="?entidade=material&acao=listar">Cancelar</a>';
echo '</form>';
