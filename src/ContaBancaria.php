<?php
abstract class ContaBancaria {
    protected $id;
    protected $titular;
    protected $saldo;
    protected $tipo;
    protected $movimentacoes = [];

    public function __construct($titular, $tipo) {
        $this->titular = $titular;
        $this->tipo = $tipo;
        $this->saldo = 0.0;
    }

    public function depositar($quantia) {
        $this->saldo += $quantia;
        $this->addMovimentacao('deposito', $quantia);
    }

    public function sacar($quantia) {
        if ($this->saldo >= $quantia) {
            $this->saldo -= $quantia;
            $this->addMovimentacao('saque', $quantia);
        } else {
            throw new Exception("Saldo insuficiente!");
        }
    }

    protected function addMovimentacao($tipo, $quantia) {
        $movimentacao = new Movimentacao($this->id, $tipo, $quantia);
        $movimentacao->save();
        $this->movimentacoes[] = $movimentacao;
    }

    public function save() {
        $db = Database::getConnection();
        $titularId = $this->titular->getId();
        $saldo = $this->saldo;
        $tipo = $this->tipo;
        $stmt = $db->prepare("INSERT INTO contas (titular_id, saldo, tipo) VALUES (:titular_id, :saldo, :tipo)");
        $stmt->bindParam(':titular_id', $titularId);
        $stmt->bindParam(':saldo', $saldo);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->execute();
        $this->id = $db->lastInsertId();
    }

    public function update() {
        $db = Database::getConnection();
        $saldo = $this->saldo;
        $id = $this->id;
        $stmt = $db->prepare("UPDATE contas SET saldo = :saldo WHERE id = :id");
        $stmt->bindParam(':saldo', $saldo);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function getSaldo() {
        return $this->saldo;
    }

    public function getTitular() {
        return $this->titular;
    }

    public function getMovimentacoes() {
        return $this->movimentacoes;
    }
}
?>
