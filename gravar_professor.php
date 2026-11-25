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

    if (gravar_professor($conexao, $nome, $cpf, $curso, $login, $senha)) {
        $mensagem = "Professor cadastrado com sucesso!";
    } else {
        $mensagem = "Erro ao cadastrar professor: " . mysqli_error($conexao);
    }
}
?>
<h1>Cadastro de professor</h1>
<?php if ($mensagem !== "") { ?>
    <p><?= htmlspecialchars($mensagem) ?></p>
<?php } ?>
<form method="POST">
    Nome: <input type="text" name="nome" required><br><br>
    CPF: <input type="text" name="cpf" required><br><br>
    Curso: <input type="text" name="curso" required><br><br>
    Login: <input type="text" name="login" required><br><br>
    Senha: <input type="password" name="senha" required><br><br>
    <button type="submit">Gravar professor</button>
</form>
<a href="index.php">Voltar ao início</a>