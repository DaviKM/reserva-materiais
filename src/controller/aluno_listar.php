<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8">
  <title>Empréstimo de Materiais - Alunos</title>
  <link rel="stylesheet" href="assets/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
    integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
  <header>
    <div>
      <i class="fa-regular fa-futbol"></i>
      <h1>Sistema de Empréstimo de Materiais Esportivos</h1>
    </div>
    <div>
      <a href="?entidade=material&acao=listar"><button type="button">Materiais</button></a>
      <a href="?entidade=emprestimo&acao=listar"><button type="button">Empréstimos</button></a>
      <a href="?entidade=emprestimo&acao=por_dia"><button type="button">Empréstimos por dia</button></a>
    </div>
  </header>
  <section id="corpo">
    <main>
      <?php
      require_once __DIR__ . '/../dao/AlunoDAO.php';
      $dao = new AlunoDAO();
      $alunos = $dao->listarTodos();
      echo '<h2>Alunos</h2>';
      echo '<p><a href="?entidade=aluno&acao=criar"><button type="button" class="opt"> <i class="fa-solid fa-plus"></i> Novo Aluno</button></a> | <a href="/reserva-materiais/public/index.php"><button type="button" class="opt"> <i class="fa-solid fa-house"></i> Home</button></a></p>';
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
                <a href="?entidade=aluno&acao=editar&matricula=' . urlencode($a["matricula"]) . '"><i class="fa-solid fa-pen-to-square"></i></a> |
                <a href="?entidade=aluno&acao=excluir&matricula=' . urlencode($a["matricula"]) . '" onclick="return confirm(\'Excluir este aluno? Se confirmar, todos os empréstimos relacionados a ele também serão excluídos.\')"><i class="fa-solid fa-trash"></i></a>
              </td>';
        echo '</tr>';
      }
      echo '</table>';
      ?>
    </main>
  </section>
</body>

</html>