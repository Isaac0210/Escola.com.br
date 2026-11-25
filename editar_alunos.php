<?php
require_once "conexao.php";
require_once "functions.php";

$id_aluno = (int)($_GET["id"] ?? 0);
$erro = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim($_POST["nome"] ?? "");
    $cpf = trim($_POST["cpf"] ?? "");
    $curso = trim($_POST["curso"] ?? "");
    $login = trim($_POST["login"] ?? "");
    $senha = $_POST["senha"] ?? "";

    if (atualizar_aluno($conexao, $id_aluno, $nome, $cpf, $curso, $login, $senha)) {
        header("Location: listar_alunos.php");
        exit;
    }
    $erro = "Não foi possível atualizar. Verifique os campos preenchidos.";
}

$resultado = buscar_aluno($conexao, $id_aluno);
$aluno = $resultado ? mysqli_fetch_assoc($resultado) : null;
if (!$aluno) {
    die("Aluno não encontrado.");
}
?>
<h1>Editar aluno</h1>
<?php if ($erro !== "") { ?>
    <p><?= htmlspecialchars($erro) ?></p>
<?php } ?>
<form method="POST">
    Nome: <input name="nome" value="<?= htmlspecialchars($aluno["nome"]) ?>" required><br><br>
    CPF: <input name="cpf" value="" placeholder="Digite novamente o CPF" required><br><br>
    Curso: <input name="curso" value="<?= htmlspecialchars($aluno["curso"]) ?>" required><br><br>
    Login: <input name="login" value="<?= htmlspecialchars($aluno["login"]) ?>" required><br><br>
    Nova senha: <input type="password" name="senha"><br>
    <small>Deixe a senha vazia para manter a atual.</small><br><br>
    <button type="submit">Salvar alterações</button>
</form>
<a href="listar_alunos.php">Voltar à lista</a>