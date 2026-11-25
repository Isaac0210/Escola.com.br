<link rel="stylesheet" href="style.css">
<?php
require_once "conexao.php";
require_once "functions.php";

$resultado = listar_alunos_com_foto($conexao);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Alunos Cadastrados</title>
  <link rel="stylesheet" href="estilo.css">
</head>
<body>
  <div class="container">
    <h1>Alunos cadastrados</h1>
    <div class="topbar">
      <a class="btn" href="gravar_aluno.php">Cadastrar novo aluno</a>
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
          <?php while ($aluno = mysqli_fetch_assoc($resultado)) { ?>
            <tr>
              <td>
                <?php if (!empty($aluno["foto"])) { ?>
                  <img src="uploads/<?= htmlspecialchars($aluno["foto"]) ?>"
                       width="70" height="70" style="object-fit:cover; border-radius:6px;"
                       alt="Foto do aluno">
                <?php } else { ?>
                  Sem foto
                <?php } ?>
              </td>
              <td><?= (int)$aluno["id_aluno"] ?></td>
              <td><?= htmlspecialchars($aluno["nome"]) ?></td>
              <td><?= htmlspecialchars($aluno["cpf"]) ?></td>
              <td><?= htmlspecialchars($aluno["curso"]) ?></td>
              <td><?= htmlspecialchars($aluno["login"]) ?></td>
              <td class="acoes">
                <a href="editar_alunos.php?id=<?= (int)$aluno["id_aluno"] ?>">Editar</a>
                <a class="excluir" href="excluir_aluno.php?id=<?= (int)$aluno["id_aluno"] ?>" onclick="return confirm('Deseja excluir este aluno?')">Excluir</a>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>