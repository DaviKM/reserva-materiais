<?php
require_once __DIR__ . '/../dao/ReservaDAO.php';
$dao = new ReservaDAO();
$codigo = isset($_GET['codigo'])?$_GET['codigo']:'';
if ($codigo!=='') { $dao->excluir($codigo); }
header('Location: ?entidade=reserva&acao=listar');
