<link rel="stylesheet" href="style.css">
<?php
require_once "conexao.php";
require_once "functions.php";

$id_professor = (int)($_GET["id"] ?? 0);
$erro = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim($_POST["nome"] ?? "");
    $cpf = trim($_POST["cpf"] ?? "");
    $curso = trim($_POST["curso"] ?? "");
    $login = trim($_POST["login"] ?? "");
    $senha = $_POST["senha"] ?? "";

    if (atualizar_professor($conexao, $id_professor, $nome, $cpf, $curso, $login, $senha)) {
        header("Location: listar_professores.php");
        exit;
    }
    $erro = "Não foi possível atualizar. Verifique os campos preenchidos.";
}

$resultado = buscar_professor($conexao, $id_professor);
$professor = $resultado ? mysqli_fetch_assoc($resultado) : null;
if (!$professor) {
    die("Professor não encontrado.");
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Editar Professor</title>
  <link rel="stylesheet" href="estilo.css">
</head>
<body>
  <div class="container">
    <h1>Editar professor</h1>
    <?php if ($erro !== "") { ?>
      <div class="msg"><?= htmlspecialchars($erro) ?></div>
    <?php } ?>
    <form method="POST">
      <div class="campo">
        <label for="nome">Nome</label>
        <input id="nome" type="text" name="nome" value="<?= htmlspecialchars($professor["nome"]) ?>" required>
      </div>
      <div class="campo">
        <label for="cpf">CPF</label>
        <input id="cpf" type="text" name="cpf" value="" placeholder="Digite novamente o CPF" required>
      </div>
      <div class="campo">
        <label for="curso">Curso</label>
        <input id="curso" type="text" name="curso" value="<?= htmlspecialchars($professor["curso"]) ?>" required>
      </div>
      <div class="campo">
        <label for="login">Login</label>
        <input id="login" type="text" name="login" value="<?= htmlspecialchars($professor["login"]) ?>" required>
      </div>
      <div class="campo">
        <label for="senha">Nova senha</label>
        <input id="senha" type="password" name="senha">
        <small>Deixe a senha vazia para manter a atual.</small>
      </div>
      <button class="btn" type="submit">Salvar alterações</button>
    </form>
    <a class="footer-link" href="listar_professores.php">Voltar à lista</a>
  </div>
</body>
</html>