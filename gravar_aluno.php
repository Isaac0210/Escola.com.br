<link rel="stylesheet" href="style.css">
<?php
require_once "conexao.php";
require_once "functions.php";

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim($_POST["nome"] ?? "");
    $cpf = trim($_POST["cpf"] ?? "");
    $curso = trim($_POST["curso"] ?? "");
    $login = trim($_POST["login"] ?? "");
    $senha = $_POST["senha"] ?? "";

    if (gravar_aluno($conexao, $nome, $cpf, $curso, $login, $senha)) {
        $foto = enviar_foto($_FILES["foto"] ?? null, __DIR__ . "/uploads");
        if ($foto !== false) {
            atualizar_foto_aluno($conexao, md5($cpf), $foto);
            $mensagem = "Aluno cadastrado com foto!";
        } else {
            $mensagem = "Aluno cadastrado, mas houve erro ao enviar a foto (verifique formato JPEG/PNG/WEBP e tamanho até 2 MB).";
        }
    } else {
        $mensagem = "Erro ao cadastrar aluno.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Cadastro de Aluno</title>
  <link rel="stylesheet" href="estilo.css">
</head>
<body>
  <div class="container">
    <h1>Cadastro de aluno</h1>
    <?php if ($mensagem !== "") { ?>
      <div class="msg"><?= htmlspecialchars($mensagem) ?></div>
    <?php } ?>
    <form method="POST" enctype="multipart/form-data">
      <div class="campo">
        <label for="nome">Nome</label>
        <input id="nome" type="text" name="nome" required>
      </div>
      <div class="campo">
        <label for="cpf">CPF</label>
        <input id="cpf" type="text" name="cpf" required>
      </div>
      <div class="campo">
        <label for="curso">Curso</label>
        <input id="curso" type="text" name="curso" required>
      </div>
      <div class="campo">
        <label for="login">Login</label>
        <input id="login" type="text" name="login" required>
      </div>
      <div class="campo">
        <label for="senha">Senha</label>
        <input id="senha" type="password" name="senha" required>
      </div>
      <div class="campo">
        <label for="foto">Foto (JPEG, PNG ou WEBP - máx. 2 MB)</label>
        <input id="foto" type="file" name="foto" accept="image/jpeg,image/png,image/webp" required>
      </div>
      <button class="btn" type="submit">Gravar aluno</button>
    </form>
    <a class="footer-link" href="index.php">Voltar ao início</a>
  </div>
</body>
</html>