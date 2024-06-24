<?php
class ContaCorrente extends ContaBancaria {
    private $taxaManutencao;
    private $taxaSaque;

    public function __construct($titular, $taxaManutencao, $taxaSaque) {
        parent::__construct($titular, 'corrente');
        $this->taxaManutencao = $taxaManutencao;
        $this->taxaSaque = $taxaSaque;
    }

    public function cobrarTaxaManutencao() {
        $this->saldo -= $this->taxaManutencao;
        $this->addMovimentacao('taxa_manutencao', $this->taxaManutencao);
    }

    public function sacar($quantia) {
        $quantiaTotal = $quantia + $this->taxaSaque;
        if ($this->saldo >= $quantiaTotal) {
            $this->saldo -= $quantiaTotal;
            $this->addMovimentacao('saque', $quantiaTotal);
        } else {
            throw new Exception("Saldo insuficiente!");
        }
    }
}
?>
