<?php
require_once __DIR__ . '/../dao/EmprestimoDAO.php';
$dao = new EmprestimoDAO();

$id = isset($_GET['id']) ? $_GET['id'] : '';

if ($id !== '') {
    $dao->finalizar($id);  // método que você vai ter no DAO
}

header('Location: ?entidade=emprestimo&acao=listar');
