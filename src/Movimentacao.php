<?php
class Movimentacao {
    private $id;
    private $conta_id;
    private $tipo;
    private $quantia;
    private $dataHora;

    public function __construct($conta_id, $tipo, $quantia) {
        $this->conta_id = $conta_id;
        $this->tipo = $tipo;
        $this->quantia = $quantia;
        $this->dataHora = date('Y-m-d H:i:s');
    }

    public function save() {
        $db = Database::getConnection();
        $contaId = $this->conta_id;
        $tipo = $this->tipo;
        $quantia = $this->quantia;
        $dataHora = $this->dataHora;
        $stmt = $db->prepare("INSERT INTO movimentacoes (conta_id, tipo, quantia, dataHora) VALUES (:conta_id, :tipo, :quantia, :dataHora)");
        $stmt->bindParam(':conta_id', $contaId);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':quantia', $quantia);
        $stmt->bindParam(':dataHora', $dataHora);
        $stmt->execute();
        $this->id = $db->lastInsertId();
    }

    public function update() {
        $db = Database::getConnection();
        $tipo = $this->tipo;
        $quantia = $this->quantia;
        $dataHora = $this->dataHora;
        $id = $this->id;
        $stmt = $db->prepare("UPDATE movimentacoes SET tipo = :tipo, quantia = :quantia, dataHora = :dataHora WHERE id = :id");
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':quantia', $quantia);
        $stmt->bindParam(':dataHora', $dataHora);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function display() {
        echo "ID: $this->id, Conta ID: $this->conta_id, Tipo: $this->tipo, Quantia: $this->quantia, Data/Hora: $this->dataHora\n";
    }
}
?>
