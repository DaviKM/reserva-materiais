<?php
require_once __DIR__ . '/../dao/emprestimoDAO.php';
$dao = new EmprestimoDAO();

$id = isset($_GET['id']) ? $_GET['id'] : '';

if ($id !== '') {
    try {
        $dao->excluir($id);
    } catch (Exception $e) {
        // opcional: registrar/logar erro e mostrar mensagem ao usuário
    }
}

header('Location: ?entidade=emprestimo&acao=listar');
exit;
