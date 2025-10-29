<?php
include_once 'database.php';
include_once 'material.php';

$database = new Database();
$db = $database->getConnection();
$material = new Material($db);

$mensagem = "";

if($_POST){
    $material->nome = $_POST['nome'];
    $material->descricao = $_POST['descricao'];
    $material->unidade = $_POST['unidade'];
    $material->estoque_atual = $_POST['estoque_atual'];
    $material->preco = $_POST['preco'];

    
    if($material->estoque_atual < 0) {
        $mensagem = '<div class="alert alert-danger">Erro: Estoque não pode ser negativo!</div>';
    } elseif($material->preco < 0) {
        $mensagem = '<div class="alert alert-danger">Erro: Preço não pode ser negativo!</div>';
    } elseif($material->criar()){
        $mensagem = '<div class="alert alert-success">Material criado com sucesso!</div>';
    } else{
        $mensagem = '<div class="alert alert-danger">Erro ao criar material!</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Material - Farmácia Vila Boa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Cadastrar Novo Material</h4>
                    </div>
                    <div class="card-body">
                        
                        <a href="read.php" class="btn btn-secondary mb-3">← Voltar para Lista</a>

                        
                        <?php echo $mensagem; ?>

                      
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome do Material *</label>
                                <input type="text" class="form-control" id="nome" name="nome" required 
                                       maxlength="100" placeholder="Ex: Dipirona Monoidratada">
                            </div>

                            <div class="mb-3">
                                <label for="descricao" class="form-label">Descrição</label>
                                <textarea class="form-control" id="descricao" name="descricao" 
                                         rows="3" placeholder="Descrição detalhada do material"></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="unidade" class="form-label">Unidade de Medida </label>
                                <select class="form-select" id="unidade" name="unidade" required>
                                    <option value="">Selecione...</option>
                                    <option value="Unidade">Unidade</option>
                                    <option value="Caixa">Caixa</option>
                                    <option value="Frasco">Frasco</option>
                                    <option value="Ampola">Ampola</option>
                                    <option value="Comprimido">Comprimido</option>
                                    <option value="ML">ML</option>
                                    <option value="Litro">Litro</option>
                                    <option value="Gramas">Gramas</option>
                                    <option value="KG">KG</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="estoque_atual" class="form-label">Estoque Atual </label>
                                <input type="number" class="form-control" id="estoque_atual" name="estoque_atual" 
                                       required min="0" step="0.01" placeholder="0.00">
                            </div>

                            <div class="mb-3">
                                <label for="preco" class="form-label">Preço Unitário (R$) </label>
                                <input type="number" class="form-control" id="preco" name="preco" 
                                       required min="0" step="0.01" placeholder="0.00">
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success btn-lg">Cadastrar Material</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>