<?php
// src/dao/SalaDAO.php
require_once __DIR__ . '/../../config/db.php';

class SalaDAO {
  private $pdo;
  public function __construct() { $this->pdo = getPDO(); }

  public function listarTodos() {
    $stmt = $this->pdo->query("SELECT numero_sala, capacidade, recursos_disponiveis, horario_funcionamento FROM Sala ORDER BY numero_sala ASC");
    return $stmt->fetchAll();
  }

  public function buscarPorNumero($numero) {
    $stmt = $this->pdo->prepare("SELECT numero_sala, capacidade, recursos_disponiveis, horario_funcionamento FROM Sala WHERE numero_sala = ?");
    $stmt->execute(array($numero));
    return $stmt->fetch();
  }

  public function criar($numero_sala, $capacidade, $recursos, $horario) {
    $stmt = $this->pdo->prepare("INSERT INTO Sala (numero_sala, capacidade, recursos_disponiveis, horario_funcionamento) VALUES (?, ?, ?, ?)");
    $stmt->execute(array($numero_sala, $capacidade, $recursos, $horario));
    return $numero_sala;
  }

  public function atualizar($numero_sala, $capacidade, $recursos, $horario) {
    $stmt = $this->pdo->prepare("UPDATE Sala SET capacidade=?, recursos_disponiveis=?, horario_funcionamento=? WHERE numero_sala=?");
    return $stmt->execute(array($capacidade, $recursos, $horario, $numero_sala));
  }

  public function excluir($numero_sala) {
    try {
      $stmt = $this->pdo->prepare("DELETE FROM Sala WHERE numero_sala=?");
      return $stmt->execute(array($numero_sala));
    } catch (PDOException $e) {
      if ($e->getCode() === '23000') {
        throw new Exception('Não é possível excluir a sala: existem reservas associadas. Cancele/exclua as reservas antes.');
      }
      throw $e;
    }
  }
}
