<?php
require_once __DIR__ . '/../../config/db.php';

class MaterialDAO {
  private $pdo;
  public function __construct() { $this->pdo = getPDO(); }

  public function listarTodos() {
    $stmt = $this->pdo->query("SELECT id_material, nome, categoria, quantidade_total, quantidade_disp, estado
                                FROM Material
                                ORDER BY nome ASC");
    return $stmt->fetchAll();
  }

  public function buscarPorId($id) {
    $stmt = $this->pdo->prepare("SELECT id_material, nome, categoria, quantidade_total, quantidade_disp, estado, descricao
                                 FROM Material WHERE id_material = ?");
    $stmt->execute(array($id));
    return $stmt->fetch();
  }

  public function criar($nome, $categoria, $quantidade_total, $estado = 'ativo', $descricao = null) {
    $this->pdo->beginTransaction();
    try {
      $stmt = $this->pdo->prepare("INSERT INTO Material (nome, categoria, quantidade_total, quantidade_disp, estado, descricao)
                                   VALUES (?, ?, ?, ?, ?, ?)");
      $stmt->execute(array($nome, $categoria, $quantidade_total, $quantidade_total, $estado, $descricao));
      $id = $this->pdo->lastInsertId();
      $this->pdo->commit();
      return $id;
    } catch (Exception $e) {
      $this->pdo->rollBack();
      throw $e;
    }
  }

  public function atualizar($id, $nome, $categoria, $quantidade_total, $estado = 'ativo', $descricao = null) {
    $stmt = $this->pdo->prepare("SELECT quantidade_total AS qt_old, quantidade_disp AS disp_old FROM Material WHERE id_material = ?");
    $stmt->execute(array($id));
    $row = $stmt->fetch();
    if (!$row) return false;

    $qt_old = (int)$row['qt_old'];
    $disp_old = (int)$row['disp_old'];
    $used = $qt_old - $disp_old; 
    $new_disp = max(0, $quantidade_total - $used);

    $stmt = $this->pdo->prepare("UPDATE Material SET nome=?, categoria=?, quantidade_total=?, quantidade_disp=?, estado=?, descricao=? WHERE id_material = ?");
    return $stmt->execute(array($nome, $categoria, $quantidade_total, $new_disp, $estado, $descricao, $id));
  }

  public function excluir($id) {
    try {
      $stmt = $this->pdo->prepare("DELETE FROM Material WHERE id_material = ?");
      return $stmt->execute(array($id));
    } catch (PDOException $e) {
      if ($e->getCode() === '23000') {
        throw new Exception('Não é possível excluir o material: existem dependências (empréstimos ou registros relacionados).');
      }
      throw $e;
    }
  }
}
