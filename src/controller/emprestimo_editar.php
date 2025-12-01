<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title>Empréstimo de Materiais - Editar Empréstimo</title>
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
            <a href="?entidade=alunos&acao=listar"><button type="button">Alunos</button></a>
            <a href="?entidade=material&acao=listar"><button type="button">Materiais</button></a>
            <a href="?entidade=emprestimo&acao=por_dia"><button type="button">Empréstimos por dia</button></a>
        </div>
    </header>
    <section id="corpo">
        <main>
            <?php
            require_once __DIR__ . '/../dao/EmprestimoDAO.php';
            require_once __DIR__ . '/../dao/MaterialDAO.php';
            require_once __DIR__ . '/../dao/AlunoDAO.php';

            $dao = new EmprestimoDAO();
            $mdao = new MaterialDAO();
            $adao = new AlunoDAO();

            $id = isset($_GET['id']) ? $_GET['id'] : '';
            if ($id === '') {
                header('Location: ?entidade=emprestimo&acao=listar');
                exit;
            }

            $row = $dao->buscarPorId($id);
            if (!$row) {
                echo '<p>Empréstimo não encontrado.</p>';
                exit;
            }

            $materiais = $mdao->listarTodos();
            $alunos = $adao->listarTodos();

            $erros = array();
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                csrf_check();
                $data_emp = trim($_POST['data_emprestimo'] ?? '');
                $data_dev = trim($_POST['data_devolucao'] ?? '');
                $aluno = trim($_POST['id_aluno'] ?? '');
                $material = trim($_POST['id_material'] ?? '');

                if ($data_emp === '')
                    $erros[] = 'Data de empréstimo é obrigatória.';
                if ($data_dev === '')
                    $erros[] = 'Data de devolução é obrigatória.';
                if ($aluno === '')
                    $erros[] = 'Selecione um aluno.';
                if ($material === '')
                    $erros[] = 'Selecione um material.';
                if ($data_emp !== '' && $data_dev !== '' && $data_emp > $data_dev)
                    $erros[] = 'A data de devolução deve ser posterior à data de empréstimo.';

                if (empty($erros)) {
                    try {
                        $dao->atualizar($id, $aluno, $material, $data_emp, $data_dev);
                        header('Location: ?entidade=emprestimo&acao=listar');
                        exit;
                    } catch (Exception $e) {
                        $erros[] = $e->getMessage();
                    }
                }
            }

            echo '<h2>Editar Empréstimo</h2>';
            if (!empty($erros)) {
                echo '<div style="color:#a00">' . implode('<br>', array_map('h', $erros)) . '</div>';
            }

            echo '<form method="post">';
            csrf_input();
            echo 'Data de Empréstimo: <input type="date" name="data_emprestimo" value="' . h($row['data_emprestimo']) . '"><br>';
            echo 'Data de Devolução: <input type="date" name="data_devolucao" value="' . h($row['data_devolucao']) . '"><br>';

            echo 'Aluno: <select name="id_aluno">';
            foreach ($alunos as $a) {
                $sel = ($a['matricula'] == $row['id_aluno']) ? ' selected' : '';
                echo '<option value="' . h($a['matricula']) . '"' . $sel . '>' . h($a['matricula']) . ' - ' . h($a['nome']) . '</option>';
            }
            echo '</select><br>';

            echo 'Material: <select name="id_material">';
            foreach ($materiais as $m) {
                $sel = ($m['id_material'] == $row['id_material']) ? ' selected' : '';
                echo '<option value="' . h($m['id_material']) . '"' . $sel . '>' . h($m['nome']) . ' (Disponíveis: ' . h($m['quantidade_disp']) . ')</option>';
            }
            echo '</select><br>';

            echo '<button type="submit"><i class="fa-solid fa-floppy-disk"></i> Salvar</button> ';
            echo '<a href="?entidade=emprestimo&acao=listar"><button type="button" class="formButton">Cancelar</button></a>';
            echo '</form>';
            ?>
        </main>
    </section>
</body>

</html>