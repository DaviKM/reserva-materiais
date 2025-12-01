<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Empréstimo de Materiais - Empréstimos</title>
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
        <main><?php
        require_once __DIR__ . '/../dao/EmprestimoDAO.php';
        $dao = new EmprestimoDAO();
        $rows = $dao->listarTodos();

        echo '<h2>Empréstimos</h2>';
        echo '<p><a href="?entidade=emprestimo&acao=criar"><button type="button" class="opt"> <i class="fa-solid fa-plus"></i> Novo Empréstimo</button></a> | <a href="/reserva-materiais/public/index.php"><button type="button" class="opt"> <i class="fa-solid fa-house"></i> Home</button></a></p>';

        echo '<table>';
        echo '<tr>
        <th>ID</th>
        <th>Aluno (Matrícula)</th>
        <th>Material</th>
        <th>Data Empréstimo</th>
        <th>Data Devolução</th>
        <th>Status</th>
        <th>Ações</th>
        </tr>';

        foreach ($rows as $r) {
            echo '<tr>';
            echo '<td>' . h($r["id_emprestimo"]) . '</td>';
            echo '<td>' . h($r["id_aluno"]) . '</td>';
            echo '<td>' . h($r["id_material"]) . '</td>';
            echo '<td>' . h($r["data_emprestimo"]) . '</td>';
            echo '<td>' . h($r["data_devolucao"]) . '</td>';
            $status_display = $r["status"];
            if ($status_display === 'finalizado' || $status_display === 'Devolvido') {
                $status_display = 'Devolvido';
            } elseif ($status_display === 'ativo' || $status_display === 'Em aberto') {
                $status_display = 'Em aberto';
            }
            echo '<td>' . h($status_display) . '</td>';

            echo '<td>';
            echo '<a href="?entidade=emprestimo&acao=editar&id=' . urlencode($r["id_emprestimo"]) . '"><i class="fa-solid fa-pen-to-square"></i></a> | ';

            if ($r["status"] === 'ativo' || $r["status"] === 'Em aberto') {
                echo '<a href="?entidade=emprestimo&acao=finalizar&id=' . urlencode($r["id_emprestimo"]) . '" onclick="return confirm(\'Finalizar este empréstimo?\')"><i class="fa-solid fa-circle-check"></i></a> | ';
            }

            echo '<a href="?entidade=emprestimo&acao=excluir&id=' . urlencode($r["id_emprestimo"]) . '" onclick="return confirm(\'Excluir?\')"><i class="fa-solid fa-trash"></i></a>';
            echo '</td>';

            echo '</tr>';
        }

        echo '</table>';
        ?></main>
    </section>
</body>

</html>