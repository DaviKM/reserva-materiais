<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Empréstimo de Materiais - Empréstimos por Dia</title>
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
            <a href="?entidade=home&acao=index"><button type="button">Home</button></a>
            <a href="?entidade=aluno&acao=listar"><button type="button">Alunos</button></a>
            <a href="?entidade=material&acao=listar"><button type="button">Materiais</button></a>
            <a href="?entidade=emprestimo&acao=listar"><button type="button">Empréstimos</button></a>
        </div>
    </header>
    <section id="corpo">
        <main>
            <?php
            require_once __DIR__ . '/../dao/EmprestimoDAO.php';
            require_once __DIR__ . '/../dao/MaterialDAO.php';

            $dao = new EmprestimoDAO();
            $mdao = new MaterialDAO();
            $materiais = $mdao->listarTodos();

            $data = isset($_GET['data']) ? $_GET['data'] : '';
            $material = isset($_GET['material']) ? $_GET['material'] : '';

            $rows = array();
            if ($data !== '') {
                $rows = ($material !== '')
                    ? $dao->listarPorDia($data, $material)
                    : $dao->listarPorDia($data, null);
            }

            echo '<h2>Empréstimos por dia</h2>';
            echo '<form method="get">';
            echo '<input type="hidden" name="entidade" value="emprestimo">';
            echo '<input type="hidden" name="acao" value="por_dia">';

            echo 'Data: <input type="date" name="data" value="' . h($data) . '"> ';

            echo 'Material (opcional): <select name="material"><option value="">(todos)</option>';
            foreach ($materiais as $m) {
                $sel = ($material === (string) $m['id_material']) ? ' selected' : '';
                echo '<option value="' . h($m['id_material']) . '"' . $sel . '>'
                    . h($m['nome']) . ' (ID ' . h($m['id_material']) . ')</option>';
            }
            echo '</select> ';

            echo '<button type="submit"><i class="fa-solid fa-magnifying-glass"></i> Procurar</button>';
            echo '</form>';

            if ($data !== '') {
                echo '<h3>Resultados</h3>';

                if (!$rows) {
                    echo '<p>Nenhum empréstimo encontrado.</p>';
                } else {
                    echo '<table>';
                    echo '<tr>
                <th>ID</th>
                <th>Aluno</th>
                <th>Material</th>
                <th>Data Empréstimo</th>
                <th>Data Devolução</th>
                <th>Status</th>
              </tr>';

                    foreach ($rows as $r) {
                        echo '<tr>';
                        echo '<td>' . h($r["id_emprestimo"]) . '</td>';
                        echo '<td>' . h($r["id_aluno"]) . '</td>';
                        echo '<td>' . h($r["id_material"]) . '</td>';
                        echo '<td>' . h($r["data_emprestimo"]) . '</td>';
                        echo '<td>' . h($r["data_devolucao"]) . '</td>';
                        echo '<td>' . h($r["status"]) . '</td>';
                        echo '</tr>';
                    }

                    echo '</table>';
                }
            }
            ?>
        </main>
    </section>
</body>

</html>