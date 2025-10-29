<?php
include_once 'database.php';
include_once 'material.php';

$database = new Database();
$db = $database->getConnection();
$material = new Material($db);


$material->id_material = isset($_GET['id']) ? $_GET['id'] : die('ERRO: ID não especificado.');


$material->lerUm();

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
    } elseif($material->atualizar()){
        $mensagem = '<div class="alert alert-success">Material atualizado com sucesso!</div>';
    } else{
        $mensagem = '<div class="alert alert-danger">Erro ao atualizar material!</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Material - Farmácia Vila Boa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header bg-warning text-dark">
                        <h4 class="mb-0"> Editar Material</h4>
                    </div>
                    <div class="card-body">
                        
                        <a href="read.php" class="btn btn-secondary mb-3">Voltar para Lista</a>

                        
                        <?php echo $mensagem; ?>

                        
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$material->id_material}"); ?>">
                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome do Material </label>
                                <input type="text" class="form-control" id="nome" name="nome" required 
                                       value="<?php echo htmlspecialchars($material->nome); ?>">
                            </div>

                            <div class="mb-3">
                                <label for="descricao" class="form-label">Descrição</label>
                                <textarea class="form-control" id="descricao" name="descricao" 
                                         rows="3"><?php echo htmlspecialchars($material->descricao); ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="unidade" class="form-label">Unidade de Medida </label>
                                <select class="form-select" id="unidade" name="unidade" required>
                                    <option value="Unidade" <?php echo $material->unidade == 'Unidade' ? 'selected' : ''; ?>>Unidade</option>
                                    <option value="Caixa" <?php echo $material->unidade == 'Caixa' ? 'selected' : ''; ?>>Caixa</option>
                                    <option value="Frasco" <?php echo $material->unidade == 'Frasco' ? 'selected' : ''; ?>>Frasco</option>
                                    <option value="Ampola" <?php echo $material->unidade == 'Ampola' ? 'selected' : ''; ?>>Ampola</option>
                                    <option value="Comprimido" <?php echo $material->unidade == 'Comprimido' ? 'selected' : ''; ?>>Comprimido</option>
                                    <option value="ML" <?php echo $material->unidade == 'ML' ? 'selected' : ''; ?>>ML</option>
                                    <option value="Litro" <?php echo $material->unidade == 'Litro' ? 'selected' : ''; ?>>Litro</option>
                                    <option value="Gramas" <?php echo $material->unidade == 'Gramas' ? 'selected' : ''; ?>>Gramas</option>
                                    <option value="KG" <?php echo $material->unidade == 'KG' ? 'selected' : ''; ?>>KG</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="estoque_atual" class="form-label">Estoque Atual </label>
                                <input type="number" class="form-control" id="estoque_atual" name="estoque_atual" 
                                       required min="0" step="0.01" 
                                       value="<?php echo htmlspecialchars($material->estoque_atual); ?>">
                            </div>

                            <div class="mb-3">
                                <label for="preco" class="form-label">Preço Unitário (R$)</label>
                                <input type="number" class="form-control" id="preco" name="preco" 
                                       required min="0" step="0.01" 
                                       value="<?php echo htmlspecialchars($material->preco); ?>">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Data de Cadastro</label>
                                <input type="text" class="form-control" 
                                       value="<?php echo date('d/m/Y H:i', strtotime($material->data_cadastro)); ?>" 
                                       readonly disabled>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-warning btn-lg">Atualizar Material</button>
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