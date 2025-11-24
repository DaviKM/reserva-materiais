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
}
