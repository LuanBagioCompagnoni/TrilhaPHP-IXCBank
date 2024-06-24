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
        $stmt = $db->prepare("INSERT INTO contas (titular_id, saldo, tipo) VALUES (:titular_id, :saldo, :tipo)");
        $stmt->bindParam(':titular_id', $this->titular->getId());
        $stmt->bindParam(':saldo', $this->saldo);
        $stmt->bindParam(':tipo', $this->tipo);
        $stmt->execute();
        $this->id = $db->lastInsertId();
    }

    public function update() {
        $db = Database::getConnection();
        $stmt = $db->prepare("UPDATE contas SET saldo = :saldo WHERE id = :id");
        $stmt->bindParam(':saldo', $this->saldo);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
    }

    public function getSaldo() {
        return $this->saldo;
    }

    public function getTitular() {
        return $this->titular;
    }
}
?>
