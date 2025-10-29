<?php
include_once 'database.php';
include_once 'material.php';

$database = new Database();
$db = $database->getConnection();
$material = new Material($db);


$material->id_material = isset($_GET['id']) ? $_GET['id'] : die('ERRO: ID não especificado.');


$material->lerUm();


if($_POST && isset($_POST['confirmar'])){
    if($material->excluir()){
        header("Location: read.php?msg=excluido");
        exit();
    } else{
        echo '<div class="alert alert-danger">Erro ao excluir material!</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Material - Farmácia Vila Boa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="card">
                    <div class="card-header bg-danger text-white">
                        <h4 class="mb-0"> Excluir Material</h4>
                    </div>
                    <div class="card-body">
                        
                        <a href="read.php" class="btn btn-secondary mb-3">← Voltar para Lista</a>

                        <div class="alert alert-warning">
                            <h5> Confirmação de Exclusão</h5>
                            <p class="mb-0">Tem certeza que deseja excluir este material?</p>
                        </div>

                       
                        <div class="card mb-3">
                            <div class="card-body">
                                <h6>Detalhes do Material:</h6>
                                <table class="table table-sm">
                                    <tr>
                                        <th>Nome:</th>
                                        <td><?php echo htmlspecialchars($material->nome); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Descrição:</th>
                                        <td><?php echo htmlspecialchars($material->descricao); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Unidade:</th>
                                        <td><?php echo htmlspecialchars($material->unidade); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Estoque:</th>
                                        <td><?php echo htmlspecialchars($material->estoque_atual); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Preço:</th>
                                        <td>R$ <?php echo number_format($material->preco, 2, ',', '.'); ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- Formulário de Confirmação -->
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$material->id_material}"); ?>">
                            <div class="d-grid gap-2">
                                <input type="hidden" name="confirmar" value="1">
                                <button type="submit" class="btn btn-danger btn-lg"> Sim, Excluir Material</button>
                                <a href="read.php" class="btn btn-secondary"> Cancelar</a>
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