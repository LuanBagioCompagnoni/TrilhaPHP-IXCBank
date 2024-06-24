<?php
class Pessoa {
    private $id;
    private $nome;
    private $cpf;

    public function __construct($nome, $cpf) {
        $this->nome = $nome;
        $this->cpf = $cpf;
    }

    public function save() {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO pessoas (nome, cpf) VALUES (:nome, :cpf)");
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':cpf', $this->cpf);
        $stmt->execute();
        $this->id = $db->lastInsertId();
    }

    public function update() {
        $db = Database::getConnection();
        $stmt = $db->prepare("UPDATE pessoas SET nome = :nome, cpf = :cpf WHERE id = :id");
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':cpf', $this->cpf);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
    }

    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getCpf() {
        return $this->cpf;
    }
}
?>
