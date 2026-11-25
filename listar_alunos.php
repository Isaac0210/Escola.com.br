<link rel="stylesheet" href="style.css">
<?php
require_once "conexao.php";
require_once "functions.php";
// Chama a função que consulta os alunos.
$resultado = listar_alunos($conexao);
?>
<h1>Alunos cadastrados</h1>
<a href="gravar_aluno.php">Cadastrar novo aluno</a>
<table border="1" cellpadding="8">
<tr>
<th>ID</th>
<th>Nome</th>
<th>CPF (MD5)</th>
<th>Curso</th>
<th>Login</th>
<th>Ações</th>
</tr>
<?php while ($aluno = mysqli_fetch_assoc($resultado)) { ?>
<tr>
<td><?= $aluno["id_aluno"] ?></td>
<td><?= htmlspecialchars($aluno["nome"]) ?></td>
<td><?= htmlspecialchars($aluno["cpf"]) ?></td>
<td><?= htmlspecialchars($aluno["curso"]) ?></td>
<td><?= htmlspecialchars($aluno["login"]) ?></td>
<td>
<a href="editar_aluno.php?id=<?= $aluno["id_aluno"] ?>">Editar</a>
|
<a href="excluir_aluno.php?id=<?= $aluno["id_aluno"] ?>"
onclick="return confirm('Deseja excluir este aluno?')">
Excluir
</a>
</td>
</tr>
<?php } ?>
</table>
<a href="index.php">Voltar ao início</a>