<?php
// src/dao/ReservaDAO.php
require_once __DIR__ . '/../../config/db.php';

class ReservaDAO {
  private $pdo;
  public function __construct() { $this->pdo = getPDO(); }

  public function listarTodos() {
    $sql = "SELECT r.codigo_reserva, r.data_reserva, r.horario_inicio, r.horario_termino, r.status,
                   r.numero_sala, r.email_usuario, s.capacidade
            FROM Reserva r
            JOIN Sala s ON s.numero_sala = r.numero_sala
            ORDER BY r.data_reserva DESC, r.horario_inicio ASC";
    $stmt = $this->pdo->query($sql);
    return $stmt->fetchAll();
  }

  public function listarPorDia($data, $numero_sala = null) {
    if ($numero_sala) {
      $stmt = $this->pdo->prepare("SELECT * FROM Reserva WHERE data_reserva = ? AND numero_sala = ? ORDER BY horario_inicio ASC");
      $stmt->execute(array($data, $numero_sala));
    } else {
      $stmt = $this->pdo->prepare("SELECT * FROM Reserva WHERE data_reserva = ? ORDER BY numero_sala ASC, horario_inicio ASC");
      $stmt->execute(array($data));
    }
    return $stmt->fetchAll();
  }

  public function buscarPorCodigo($codigo) {
    $stmt = $this->pdo->prepare("SELECT * FROM Reserva WHERE codigo_reserva = ?");
    $stmt->execute(array($codigo));
    return $stmt->fetch();
  }

  public function proximoCodigo() {
    // gera um código simples R<n>
    $stmt = $this->pdo->query("SELECT codigo_reserva FROM Reserva ORDER BY LENGTH(codigo_reserva) DESC, codigo_reserva DESC LIMIT 1");
    $row = $stmt->fetch();
    if (!$row) return 'R1';
    $num = (int)preg_replace('/\D/', '', $row['codigo_reserva']);
    return 'R' . ($num + 1);
  }

  public function existeConflito($numero_sala, $data, $inicio, $termino, $ignorar_codigo = null) {
    $sql = "SELECT COUNT(*) AS qtd
            FROM Reserva
            WHERE numero_sala = ? AND data_reserva = ? AND status = 'ativa'
              AND (? < horario_termino) AND (? > horario_inicio)";
    $params = array($numero_sala, $data, $termino, $inicio);
    if ($ignorar_codigo) {
      $sql .= " AND codigo_reserva <> ?";
      $params[] = $ignorar_codigo;
    }
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($params);
    $row = $stmt->fetch();
    return ($row && (int)$row['qtd'] > 0);
  }

  public function criar($data, $inicio, $termino, $numero_sala, $email_usuario) {
    // valida conflito
    if ($this->existeConflito($numero_sala, $data, $inicio, $termino, null)) {
      throw new Exception('Conflito de horário para a sala selecionada.');
    }
    $codigo = $this->proximoCodigo();
    $stmt = $this->pdo->prepare("INSERT INTO Reserva (codigo_reserva, data_reserva, horario_inicio, horario_termino, status, numero_sala, email_usuario)
                                 VALUES (?, ?, ?, ?, 'ativa', ?, ?)");
    $stmt->execute(array($codigo, $data, $inicio, $termino, $numero_sala, $email_usuario));
    return $codigo;
  }

  public function atualizar($codigo, $data, $inicio, $termino, $numero_sala, $email_usuario) {
    if ($this->existeConflito($numero_sala, $data, $inicio, $termino, $codigo)) {
      throw new Exception('Conflito de horário para a sala selecionada.');
    }
    $stmt = $this->pdo->prepare("UPDATE Reserva
                                 SET data_reserva=?, horario_inicio=?, horario_termino=?, numero_sala=?, email_usuario=?
                                 WHERE codigo_reserva=?");
    return $stmt->execute(array($data, $inicio, $termino, $numero_sala, $email_usuario, $codigo));
  }

  public function cancelar($codigo) {
    $stmt = $this->pdo->prepare("UPDATE Reserva SET status='cancelada' WHERE codigo_reserva=?");
    return $stmt->execute(array($codigo));
  }

  public function excluir($codigo) {
    $stmt = $this->pdo->prepare("DELETE FROM Reserva WHERE codigo_reserva=?");
    return $stmt->execute(array($codigo));
  }
}
