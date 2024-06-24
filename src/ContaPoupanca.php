<?php
class ContaPoupanca extends ContaBancaria {
    private $juros;

    public function __construct($titular, $juros) {
        parent::__construct($titular, 'poupanca');
        $this->juros = $juros;
    }

    public function aplicarJuros() {
        $quantia = $this->saldo * $this->juros / 100;
        $this->saldo += $quantia;
        $this->addMovimentacao('juros', $quantia);
    }
}
?>
