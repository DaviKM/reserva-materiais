<?php
require_once __DIR__ . '/../../config/db.php';

class EmprestimoDAO {
  private $pdo;
  public function __construct() { $this->pdo = getPDO(); }

  public function listarTodos() {
    $stmt = $this->pdo->query("SELECT id_emprestimo, id_aluno, id_material, data_emprestimo, data_devolucao, status
                                FROM Emprestimo
                                ORDER BY data_emprestimo DESC, data_devolucao ASC");
    return $stmt->fetchAll();
  }

  public function listarPorDia($data, $id_material = null) {
    if ($id_material) {
      $stmt = $this->pdo->prepare("SELECT * FROM Emprestimo WHERE data_emprestimo = ? AND id_material = ? ORDER BY data_emprestimo ASC");
      $stmt->execute(array($data, $id_material));
    } else {
      $stmt = $this->pdo->prepare("SELECT * FROM Emprestimo WHERE data_emprestimo = ? ORDER BY id_material ASC, data_emprestimo ASC");
      $stmt->execute(array($data));
    }
    return $stmt->fetchAll();
  }

  public function buscarPorId($id) {
    $stmt = $this->pdo->prepare("SELECT * FROM Emprestimo WHERE id_emprestimo = ?");
    $stmt->execute(array($id));
    return $stmt->fetch();
  }

  public function criar($id_aluno, $id_material, $data_emp, $data_dev) {
    $stmt = $this->pdo->prepare("SELECT quantidade_disp FROM Material WHERE id_material = ?");
    $stmt->execute(array($id_material));
    $row = $stmt->fetch();
    if (!$row) {
      throw new Exception('Material não encontrado.');
    }
    if ((int)$row['quantidade_disp'] <= 0) {
      throw new Exception('Material indisponível.');
    }

    $this->pdo->beginTransaction();
    try {
      $stmt = $this->pdo->prepare("INSERT INTO Emprestimo (id_aluno, id_material, data_emprestimo, data_devolucao, status)
                                   VALUES (?, ?, ?, ?, 'ativo')");
      $stmt->execute(array($id_aluno, $id_material, $data_emp, $data_dev));
      $id = $this->pdo->lastInsertId();

      $stmt = $this->pdo->prepare("UPDATE Material SET quantidade_disp = quantidade_disp - 1 WHERE id_material = ?");
      $stmt->execute(array($id_material));

      $this->pdo->commit();
      return $id;
    } catch (Exception $e) {
      $this->pdo->rollBack();
      throw $e;
    }
  }

  public function atualizar($id, $id_aluno, $id_material, $data_emp, $data_dev) {
    $stmt = $this->pdo->prepare("UPDATE Emprestimo
                                 SET id_aluno=?, id_material=?, data_emprestimo=?, data_devolucao=?
                                 WHERE id_emprestimo=?");
    return $stmt->execute(array($id_aluno, $id_material, $data_emp, $data_dev, $id));
  }

  public function finalizar($id) {
    $stmt = $this->pdo->prepare("SELECT id_material, status FROM Emprestimo WHERE id_emprestimo = ?");
    $stmt->execute(array($id));
    $row = $stmt->fetch();
    if (!$row) return false;

    if ($row['status'] === 'ativo' || $row['status'] === 'Em aberto') {
      $this->pdo->beginTransaction();
      try {
        $stmt = $this->pdo->prepare("UPDATE Emprestimo SET status = 'finalizado' WHERE id_emprestimo = ?");
        $stmt->execute(array($id));

        $stmt = $this->pdo->prepare("UPDATE Material SET quantidade_disp = quantidade_disp + 1 WHERE id_material = ?");
        $stmt->execute(array($row['id_material']));

        $this->pdo->commit();
        return true;
      } catch (Exception $e) {
        $this->pdo->rollBack();
        throw $e;
      }
    }
    return false;
  }

  public function excluir($id) {
    $stmt = $this->pdo->prepare("SELECT id_material, status FROM Emprestimo WHERE id_emprestimo = ?");
    $stmt->execute(array($id));
    $row = $stmt->fetch();
    if (!$row) return false;

    $this->pdo->beginTransaction();
    try {
      if ($row['status'] === 'ativo' || $row['status'] === 'Em aberto') {
        $stmt = $this->pdo->prepare("UPDATE Material SET quantidade_disp = quantidade_disp + 1 WHERE id_material = ?");
        $stmt->execute(array($row['id_material']));
      }

      $stmt = $this->pdo->prepare("DELETE FROM Emprestimo WHERE id_emprestimo = ?");
      $stmt->execute(array($id));

      $this->pdo->commit();
      return true;
    } catch (Exception $e) {
      $this->pdo->rollBack();
      if ($e instanceof PDOException && $e->getCode() === '23000') {
        throw new Exception('Não é possível excluir o empréstimo: existem dependências.');
      }
      throw $e;
    }
  }
}
