<?php
require_once __DIR__ . '/../dao/EmprestimoDAO.php';
$dao = new EmprestimoDAO();

$id = isset($_GET['id']) ? $_GET['id'] : '';

if ($id !== '') {
    $dao->finalizar($id); 
}

header('Location: ?entidade=emprestimo&acao=listar');
