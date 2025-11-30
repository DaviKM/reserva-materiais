<?php
require_once __DIR__ . '/../dao/AlunoDAO.php';

$dao = new AlunoDAO();
$matricula = isset($_GET['matricula']) ? $_GET['matricula'] : '';
if ($matricula === '') { header('Location: ?entidade=aluno&acao=listar'); exit; }

$aluno = $dao->buscarPorMatricula($matricula);
if (!$aluno) { echo '<p>Aluno não encontrado.</p>'; exit; }

$erros = array();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $nome = trim($_POST['nome'] ?? '');
    $curso = trim($_POST['curso'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if ($nome === '') $erros[] = 'Nome é obrigatório.';
    if ($curso === '') $erros[] = 'Curso é obrigatório.';
    if ($email === '') $erros[] = 'Email é obrigatório.';
    if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) $erros[] = 'Email inválido.';

    if (empty($erros)) {
        try {
            $dao->atualizar($matricula, $nome, $curso, $email);
            header('Location: ?entidade=aluno&acao=listar');
            exit;
        } catch (Exception $e) {
            $erros[] = $e->getMessage();
        }
    }
}

echo '<h2>Editar Aluno</h2>';
if (!empty($erros)) { echo '<div style="color:#a00">'.implode('<br>', array_map('h', $erros)).'</div>'; }

echo '<form method="post">';
csrf_input();
echo 'Matrícula: <input type="text" name="matricula" value="'.h($aluno['matricula']).'" disabled><br>';
echo 'Nome: <input type="text" name="nome" value="'.h($aluno['nome']).'"><br>';
echo 'Curso: <input type="text" name="curso" value="'.h($aluno['curso']).'"><br>';
echo 'Email: <input type="email" name="email" value="'.h($aluno['email']).'"><br>';
echo '<button type="submit">Salvar</button> ';
echo '<a href="?entidade=aluno&acao=listar">Cancelar</a>';
echo '</form>';

