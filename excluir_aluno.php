<?php
require_once "conexao.php";
require_once "functions.php";
// Recebe e valida o identificador.
$id_aluno = (int)($_GET["id"] ?? 0);
// Chama a função que executa o DELETE.
if ($id_aluno > 0 && excluir_aluno($conexao, $id_aluno)) {
header("Location: listar_alunos.php");
exit;
}
echo "Não foi possível excluir o aluno.";
?>