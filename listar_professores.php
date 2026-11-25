<link rel="stylesheet" href="style.css">
<?php
require_once "conexao.php";
require_once "functions.php";

$resultado = listar_professores_com_foto($conexao);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Professores Cadastrados</title>
  <link rel="stylesheet" href="estilo.css">
</head>
<body>
  <div class="container">
    <h1>Professores cadastrados</h1>
    <div class="topbar">
      <a class="btn" href="gravar_professor.php">Cadastrar novo professor</a>
      <a class="btn btn-secondary" href="index.php">Voltar ao início</a>
    </div>
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>Foto</th>
            <th>ID</th>
            <th>Nome</th>
            <th>CPF (MD5)</th>
            <th>Curso</th>
            <th>Login</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($professor = mysqli_fetch_assoc($resultado)) { ?>
            <tr>
              <td>
                <?php if (!empty($professor["foto"])) { ?>
                  <img src="uploads/<?= htmlspecialchars($professor["foto"]) ?>"
                       width="70" height="70" style="object-fit:cover; border-radius:6px;"
                       alt="Foto do professor">
                <?php } else { ?>
                  Sem foto
                <?php } ?>
              </td>
              <td><?= (int)$professor["id_professor"] ?></td>
              <td><?= htmlspecialchars($professor["nome"]) ?></td>
              <td><?= htmlspecialchars($professor["cpf"]) ?></td>
              <td><?= htmlspecialchars($professor["curso"]) ?></td>
              <td><?= htmlspecialchars($professor["login"]) ?></td>
              <td class="acoes">
                <a href="editar_professor.php?id=<?= (int)$professor["id_professor"] ?>">Editar</a>
                <a class="excluir" href="excluir_professor.php?id=<?= (int)$professor["id_professor"] ?>" onclick="return confirm('Deseja excluir este professor?')">Excluir</a>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>