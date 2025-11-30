<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Listar Alunos</title>
  <link rel="stylesheet" href="./../public/assets/style.css">

</head>

<body>
  <?php
  require_once __DIR__ . '/../dao/AlunoDAO.php';
  $dao = new AlunoDAO();
  $alunos = $dao->listarTodos();

  echo '<h2>Alunos</h2>';
  echo '<p><a href="?entidade=aluno&acao=criar">Novo Aluno</a> | <a href="/reserva-materiais/public/index.php">Home</a></p>';

  echo '<table>';
  echo '<tr>
        <th>Matrícula</th>
        <th>Nome</th>
        <th>Curso</th>
        <th>Email</th>
        <th>Ações</th>
      </tr>';

  foreach ($alunos as $a) {
    echo '<tr>';
    echo '<td>' . h($a["matricula"]) . '</td>';
    echo '<td>' . h($a["nome"]) . '</td>';
    echo '<td>' . h($a["curso"]) . '</td>';
    echo '<td>' . h($a["email"]) . '</td>';

    echo '<td>
            <a href="?entidade=aluno&acao=editar&matricula=' . urlencode($a["matricula"]) . '">Editar</a> |
            <a href="?entidade=aluno&acao=excluir&matricula=' . urlencode($a["matricula"]) . '" onclick="return confirm(\'Excluir este aluno?\')">Excluir</a>
          </td>';

    echo '</tr>';
  }

  echo '</table>';
  ?>
</body>

</html>
