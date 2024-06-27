<?php
require 'autoload.php';

try {
    // Criando as tabelas no banco de dados
    $db = Database::getConnection();
    $db->exec("
        CREATE TABLE IF NOT EXISTS pessoas (
            id INTEGER PRIMARY KEY,
            nome TEXT NOT NULL,
            cpf TEXT NOT NULL
        );
        CREATE TABLE IF NOT EXISTS contas (
            id INTEGER PRIMARY KEY,
            titular_id INTEGER,
            saldo REAL,
            tipo TEXT,
            FOREIGN KEY (titular_id) REFERENCES pessoas(id)
        );
        CREATE TABLE IF NOT EXISTS movimentacoes (
            id INTEGER PRIMARY KEY,
            conta_id INTEGER,
            tipo TEXT,
            quantia REAL,
            dataHora TEXT,
            FOREIGN KEY (conta_id) REFERENCES contas(id)
        );
    ");

    // Criando uma pessoa
    $pessoa = new Pessoa('João da Silva', '123.456.789-00');
    $pessoa->save();

    // Criando uma conta poupança
    $contaPoupanca = new ContaPoupanca($pessoa, 0.5);
    $contaPoupanca->save();
    $contaPoupanca->depositar(1000);
    $contaPoupanca->aplicarJuros();
    echo "Saldo Conta Poupança: " . $contaPoupanca->getSaldo() . "\n";

    // Criando uma conta corrente
    $contaCorrente = new ContaCorrente($pessoa, 10, 2);
    $contaCorrente->save();
    $contaCorrente->depositar(2000);
    $contaCorrente->sacar(500);
    $contaCorrente->cobrarTaxaManutencao();
    echo "Saldo Conta Corrente: " . $contaCorrente->getSaldo() . "\n";

    // Exibindo movimentações
    foreach ($contaPoupanca->getMovimentacoes() as $movimentacao) {
        $movimentacao->display();
    }
    foreach ($contaCorrente->getMovimentacoes() as $movimentacao) {
        $movimentacao->display();
    }

} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}
?>
