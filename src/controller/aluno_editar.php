<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title>Empréstimo de Materiais - Editar Aluno</title>
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
            $matricula = isset($_GET['matricula']) ? $_GET['matricula'] : '';
            if ($matricula === '') {
                header('Location: ?entidade=aluno&acao=listar');
                exit;
            }

            $aluno = $dao->buscarPorMatricula($matricula);
            if (!$aluno) {
                echo '<p>Aluno não encontrado.</p>';
                exit;
            }

            $erros = array();
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                csrf_check();
                $nome = trim($_POST['nome'] ?? '');
                $curso = trim($_POST['curso'] ?? '');
                $email = trim($_POST['email'] ?? '');

                if ($nome === '')
                    $erros[] = 'Nome é obrigatório.';
                if ($curso === '')
                    $erros[] = 'Curso é obrigatório.';
                if ($email === '')
                    $erros[] = 'Email é obrigatório.';
                if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL))
                    $erros[] = 'Email inválido.';

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
            if (!empty($erros)) {
                echo '<div style="color:#a00">' . implode('<br>', array_map('h', $erros)) . '</div>';
            }

            echo '<form method="post">';
            csrf_input();
            echo 'Matrícula: <input type="text" name="matricula" value="' . h($aluno['matricula']) . '" disabled><br>';
            echo 'Nome: <input type="text" name="nome" value="' . h($aluno['nome']) . '"><br>';
            echo 'Curso: <input type="text" name="curso" value="' . h($aluno['curso']) . '"><br>';
            echo 'Email: <input type="email" name="email" value="' . h($aluno['email']) . '"><br>';
            echo '<button type="submit"><i class="fa-solid fa-floppy-disk"></i> Salvar</button> ';
            echo '<a href="?entidade=aluno&acao=listar"><button type="button" class="formButton">Cancelar</button></a>';
            echo '</form>';
            ?>

        </main>
    </section>
</body>

</html>