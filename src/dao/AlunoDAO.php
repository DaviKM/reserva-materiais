<?php
require_once __DIR__ . '/../../config/db.php';

class AlunoDAO {
  private $pdo;
  public function __construct() { $this->pdo = getPDO(); }

  public function listarTodos() {
    $stmt = $this->pdo->query("SELECT matricula, nome, curso, email FROM Aluno ORDER BY nome ASC");
    return $stmt->fetchAll();
  }

  public function buscarPorMatricula($matricula) {
    $stmt = $this->pdo->prepare("SELECT matricula, nome, curso, email FROM Aluno WHERE matricula = ?");
    $stmt->execute(array($matricula));
    return $stmt->fetch();
  }

  public function criar($matricula, $nome, $curso, $email) {
    $stmt = $this->pdo->prepare("INSERT INTO Aluno (matricula, nome, curso, email) VALUES (?, ?, ?, ?)");
    $stmt->execute(array($matricula, $nome, $curso, $email));
    return $matricula;
  }

  public function atualizar($matricula, $nome, $curso, $email) {
    $stmt = $this->pdo->prepare("UPDATE Aluno SET nome = ?, curso = ?, email = ? WHERE matricula = ?");
    $stmt->execute(array($nome, $curso, $email, $matricula));
    return $stmt->rowCount() > 0;
  }

  public function excluir($matricula) {
    $this->pdo->beginTransaction();
    try {
      $stmt = $this->pdo->prepare("DELETE FROM Emprestimo WHERE id_aluno = ?");
      $stmt->execute(array($matricula));

      $stmt = $this->pdo->prepare("DELETE FROM Aluno WHERE matricula = ?");
      $stmt->execute(array($matricula));

      $deleted = $stmt->rowCount() > 0;
      $this->pdo->commit();
      return $deleted;
    } catch (Exception $e) {
      $this->pdo->rollBack();
      throw $e;
    }
  }
}
