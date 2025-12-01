<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Empréstimo de Materiais - Materiais</title>
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
      <a href="?entidade=aluno&acao=listar"><button type="button">Alunos</button></a>
      <a href="?entidade=emprestimo&acao=listar"><button type="button">Empréstimos</button></a>
      <a href="?entidade=emprestimo&acao=por_dia"><button type="button">Empréstimos por dia</button></a>
    </div>
  </header>
  <section id="corpo">
    <main>
      <?php
      require_once __DIR__ . '/../dao/MaterialDAO.php';
      $dao = new MaterialDAO();
      $materiais = $dao->listarTodos();
      echo '<h2>Materiais Esportivos</h2>';
      echo '<p><a href="?entidade=material&acao=criar"><button type="button" class="opt"> <i class="fa-solid fa-plus"></i> Novo material</button></a> | <a href="/reserva-materiais/public/index.php"><button type="button" class="opt"> <i class="fa-solid fa-house"></i> Home</button></a></p>';
      echo '<table>';
      echo '<tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Categoria</th>
            <th>Total</th>
            <th>Disponível</th>
            <th>Estado</th>
            <th>Ações</th>
          </tr>';
      foreach ($materiais as $m) {
        echo '<tr>';
        echo '<td>' . h($m["id_material"]) . '</td>';
        echo '<td>' . h($m["nome"]) . '</td>';
        echo '<td>' . h($m["categoria"]) . '</td>';
        echo '<td>' . h($m["quantidade_total"]) . '</td>';
        echo '<td>' . h($m["quantidade_disp"]) . '</td>';
        echo '<td>' . h($m["estado"]) . '</td>';
        echo '<td>
                <a href="?entidade=material&acao=editar&id=' . urlencode($m["id_material"]) . '"><i class="fa-solid fa-pen-to-square"></i></a> |
                <a href="?entidade=material&acao=excluir&id=' . urlencode($m["id_material"]) . '" onclick="return confirm(\'Excluir este material?\')"><i class="fa-solid fa-trash"></i></a>
              </td>';
        echo '</tr>';
      }
      echo '</table>';
      ?>
    </main>
  </section>
</body>

</html>