<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title>Empréstimo de Materiais - Novo Material</title>
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
            <a href="?entidade=emprestimo&acao=listar"><button type="button">Empréstimos</button></a>
            <a href="?entidade=emprestimo&acao=por_dia"><button type="button">Empréstimos por dia</button></a>
        </div>
    </header>
    <section id="corpo">
        <main>
            <?php
            require_once __DIR__ . '/../dao/MaterialDAO.php';
            $dao = new MaterialDAO();
            $erros = array();
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                csrf_check();
                $nome = trim($_POST['nome'] ?? '');
                $categoria = trim($_POST['categoria'] ?? '');
                $quantidade = trim($_POST['quantidade_total'] ?? '');
                $estado = trim($_POST['estado'] ?? 'Boa');
                $descricao = trim($_POST['descricao'] ?? '');
                if ($nome === '')
                    $erros[] = 'Nome é obrigatório.';
                if ($categoria === '')
                    $erros[] = 'Categoria é obrigatória.';
                if ($quantidade === '' || !is_numeric($quantidade) || (int) $quantidade < 0)
                    $erros[] = 'Quantidade total inválida.';
                if (empty($erros)) {
                    try {
                        $id = $dao->criar($nome, $categoria, (int) $quantidade, $estado, $descricao !== '' ? $descricao : null);
                        header('Location: ?entidade=material&acao=listar');
                        exit;
                    } catch (Exception $e) {
                        $erros[] = $e->getMessage();
                    }
                }
            }
            echo '<h2>Novo Material</h2>';
            if (!empty($erros)) {
                echo '<div style="color:#a00">' . implode('<br>', array_map('h', $erros)) . '</div>';
            }
            echo '<form method="post">';
            csrf_input();
            echo 'Nome: <input type="text" name="nome"><br>';
            echo 'Categoria: <input type="text" name="categoria"><br>';
            echo 'Quantidade total: <input type="number" name="quantidade_total" min="0"><br>';
            echo 'Estado (geral): <select name="estado">'
                . '<option value="Novo">Novo</option>'
                . '<option value="Boa">Boa</option>'
                . '<option value="Ruim">Ruim</option>'
                . '<option value="Quebrado">Quebrado</option>'
                . '</select><br>';
            echo 'Descrição:<br><textarea name="descricao" rows="4" cols="50"></textarea><br>';
            echo '<button type="submit"><i class="fa-solid fa-floppy-disk"></i> Salvar</button> ';
            echo '<a href="?entidade=material&acao=listar"><button type="button" class="formButton">Cancelar</button></a>';
            echo '</form>';
            ?>
        </main>
    </section>
</body>

</html>