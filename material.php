<?php
class Material {
    private $conn;
    private $table_name = "materiais";

    public $id_material;
    public $nome;
    public $descricao;
    public $unidade;
    public $estoque_atual;
    public $preco;
    public $data_cadastro;
    public $ativo;

    public function __construct($db) {
        $this->conn = $db;
    }

    // CREATE 
    public function criar() {
        $query = "INSERT INTO " . $this->table_name . 
                " SET nome=:nome, descricao=:descricao, unidade=:unidade, 
                estoque_atual=:estoque_atual, preco=:preco";

        $stmt = $this->conn->prepare($query);

        // Sanitização
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->descricao = htmlspecialchars(strip_tags($this->descricao));
        $this->unidade = htmlspecialchars(strip_tags($this->unidade));
        $this->estoque_atual = htmlspecialchars(strip_tags($this->estoque_atual));
        $this->preco = htmlspecialchars(strip_tags($this->preco));

        // Bind parameters
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":descricao", $this->descricao);
        $stmt->bindParam(":unidade", $this->unidade);
        $stmt->bindParam(":estoque_atual", $this->estoque_atual);
        $stmt->bindParam(":preco", $this->preco);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // READ listar
    public function listar() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE ativo = 1 ORDER BY nome ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // READ - Buscar materiais por nome
    public function buscar($search) {
        $query = "SELECT * FROM " . $this->table_name . " 
                 WHERE ativo = 1 AND nome LIKE :search 
                 ORDER BY nome ASC";
        
        $stmt = $this->conn->prepare($query);
        $search_param = "%{$search}%";
        $stmt->bindParam(":search", $search_param);
        $stmt->execute();
        return $stmt;
    }

    // READ - Ler um específico
    public function lerUm() {
        $query = "SELECT * FROM " . $this->table_name . " 
                 WHERE id_material = ? LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id_material);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row) {
            $this->nome = $row['nome'];
            $this->descricao = $row['descricao'];
            $this->unidade = $row['unidade'];
            $this->estoque_atual = $row['estoque_atual'];
            $this->preco = $row['preco'];
            $this->data_cadastro = $row['data_cadastro'];
            return true;
        }
        return false;
    }

    // UPDATE - Atualizar material
    public function atualizar() {
        $query = "UPDATE " . $this->table_name . 
                " SET nome=:nome, descricao=:descricao, unidade=:unidade, 
                estoque_atual=:estoque_atual, preco=:preco 
                WHERE id_material=:id_material";

        $stmt = $this->conn->prepare($query);

        // Sanitização
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->descricao = htmlspecialchars(strip_tags($this->descricao));
        $this->unidade = htmlspecialchars(strip_tags($this->unidade));
        $this->estoque_atual = htmlspecialchars(strip_tags($this->estoque_atual));
        $this->preco = htmlspecialchars(strip_tags($this->preco));
        $this->id_material = htmlspecialchars(strip_tags($this->id_material));

        // Bind parameters
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":descricao", $this->descricao);
        $stmt->bindParam(":unidade", $this->unidade);
        $stmt->bindParam(":estoque_atual", $this->estoque_atual);
        $stmt->bindParam(":preco", $this->preco);
        $stmt->bindParam(":id_material", $this->id_material);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // DELETE 
    public function excluir() {
        $query = "UPDATE " . $this->table_name . " SET ativo = 0 WHERE id_material = ?";
        
        $stmt = $this->conn->prepare($query);
        $this->id_material = htmlspecialchars(strip_tags($this->id_material));
        $stmt->bindParam(1, $this->id_material);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>