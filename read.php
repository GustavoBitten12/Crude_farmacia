<?php
include_once 'database.php';
include_once 'material.php';

$database = new Database();
$db = $database->getConnection();
$material = new Material($db);


$termo_busca = $_GET['search'] ?? '';
$stmt = '';

if(!empty($termo_busca)) {
    $stmt = $material->buscar($termo_busca);
} else {
    $stmt = $material->listar();
}

$num = $stmt->rowCount();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Materiais - Farmácia Vila Boa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-actions {
            white-space: nowrap;
        }
        .card {
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0"> Lista de Materiais - Farmácia Vila Boa</h4>
                <span class="badge bg-light text-dark"><?php echo $num; ?> itens</span>
            </div>
            <div class="card-body">
                
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <a href="create.php" class="btn btn-primary"> Novo Material</a>
                    
                    
                    <form method="get" class="d-flex">
                        <input type="text" class="form-control me-2" name="search" 
                               value="<?php echo htmlspecialchars($termo_busca); ?>" 
                               placeholder="Buscar por nome..." style="width: 300px;">
                        <button class="btn btn-outline-success me-2" type="submit">🔍 Buscar</button>
                        <?php if($termo_busca): ?>
                        <a href="read.php" class="btn btn-outline-danger"> Limpar</a>
                        <?php endif; ?>
                    </form>
                </div>

                <?php if($num > 0): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Descrição</th>
                                <th>Unidade</th>
                                <th>Estoque</th>
                                <th>Preço (R$)</th>
                                <th>Data Cadastro</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['id_material']); ?></td>
                                <td>
                                    <strong><?php echo htmlspecialchars($row['nome']); ?></strong>
                                </td>
                                <td><?php echo htmlspecialchars($row['descricao']); ?></td>
                                <td><?php echo htmlspecialchars($row['unidade']); ?></td>
                                <td>
                                    <span class="badge <?php echo $row['estoque_atual'] > 10 ? 'bg-success' : 'bg-warning'; ?>">
                                        <?php echo htmlspecialchars($row['estoque_atual']); ?>
                                    </span>
                                </td>
                                <td>R$ <?php echo number_format($row['preco'], 2, ',', '.'); ?></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($row['data_cadastro'])); ?></td>
                                <td class="table-actions">
                                    <a href="update.php?id=<?php echo $row['id_material']; ?>" 
                                       class="btn btn-sm btn-outline-warning">✏️ Editar</a>
                                    <a href="delete.php?id=<?php echo $row['id_material']; ?>" 
                                       class="btn btn-sm btn-outline-danger"
                                       onclick="return confirm('Tem certeza que deseja excluir este material?')"> Excluir</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="alert alert-info text-center">
                    <?php if($termo_busca): ?>
                    <h5> Nenhum material encontrado</h5>
                    <p>Nenhum material encontrado para "<?php echo htmlspecialchars($termo_busca); ?>"</p>
                    <?php else: ?>
                    <h5> Nenhum material cadastrado</h5>
                    <p>Clique em "Novo Material" para adicionar o primeiro material ao sistema.</p>
                    <?php endif; ?>
                    <a href="create.php" class="btn btn-primary mt-2"> Cadastrar Primeiro Material</a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>