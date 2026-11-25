<?php
// =======================
// FUNÇÕES PARA ALUNOS
// =======================

function gravar_aluno($conexao, $nome, $cpf, $curso, $login, $senha) {
    if ($nome === "" || $cpf === "" || $curso === "" || $login === "" || $senha === "") {
        return false;
    }

    $cpf_md5 = md5($cpf);
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
    if ($senha_hash === false) {
        return false;
    }

    $sql = "INSERT INTO alunos (nome, cpf, curso, login, senha) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conexao, $sql);
    if (!$stmt) {
        return false;
    }

    mysqli_stmt_bind_param($stmt, "sssss", $nome, $cpf_md5, $curso, $login, $senha_hash);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

function listar_alunos($conexao) {
    $sql = "SELECT id_aluno, nome, cpf, curso, login FROM alunos ORDER BY nome";
    return mysqli_query($conexao, $sql);
}

function buscar_aluno($conexao, $id_aluno) {
    $sql = "SELECT * FROM alunos WHERE id_aluno = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    if (!$stmt) {
        return false;
    }

    mysqli_stmt_bind_param($stmt, "i", $id_aluno);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    return $resultado;
}

function atualizar_aluno($conexao, $id_aluno, $nome, $cpf, $curso, $login, $senha) {
    if ($id_aluno <= 0 || $nome === "" || $cpf === "" || $curso === "" || $login === "") {
        return false;
    }

    $cpf_md5 = md5($cpf);

    if ($senha !== "") {
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        if ($senha_hash === false) {
            return false;
        }

        $sql = "UPDATE alunos SET nome=?, cpf=?, curso=?, login=?, senha=? WHERE id_aluno=?";
        $stmt = mysqli_prepare($conexao, $sql);
        if (!$stmt) {
            return false;
        }

        mysqli_stmt_bind_param($stmt, "sssssi", $nome, $cpf_md5, $curso, $login, $senha_hash, $id_aluno);
    } else {
        $sql = "UPDATE alunos SET nome=?, cpf=?, curso=?, login=? WHERE id_aluno=?";
        $stmt = mysqli_prepare($conexao, $sql);
        if (!$stmt) {
            return false;
        }

        mysqli_stmt_bind_param($stmt, "ssssi", $nome, $cpf_md5, $curso, $login, $id_aluno);
    }

    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

function excluir_aluno($conexao, $id_aluno) {
    $sql = "DELETE FROM alunos WHERE id_aluno = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    if (!$stmt) {
        return false;
    }

    mysqli_stmt_bind_param($stmt, "i", $id_aluno);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

// ===========================
// FUNÇÕES PARA PROFESSORES
// ===========================

function gravar_professor($conexao, $nome, $cpf, $curso, $login, $senha) {
    if ($nome === "" || $cpf === "" || $curso === "" || $login === "" || $senha === "") {
        return false;
    }

    $cpf_md5 = md5($cpf);
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
    if ($senha_hash === false) {
        return false;
    }

    $sql = "INSERT INTO professores (nome, cpf, curso, login, senha) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conexao, $sql);
    if (!$stmt) {
        return false;
    }

    mysqli_stmt_bind_param($stmt, "sssss", $nome, $cpf_md5, $curso, $login, $senha_hash);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

function listar_professores($conexao) {
    $sql = "SELECT id_professor, nome, cpf, curso, login FROM professores ORDER BY nome";
    return mysqli_query($conexao, $sql);
}

function buscar_professor($conexao, $id_professor) {
    $sql = "SELECT * FROM professores WHERE id_professor = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    if (!$stmt) {
        return false;
    }

    mysqli_stmt_bind_param($stmt, "i", $id_professor);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    return $resultado;
}

function atualizar_professor($conexao, $id_professor, $nome, $cpf, $curso, $login, $senha) {
    if ($id_professor <= 0 || $nome === "" || $cpf === "" || $curso === "" || $login === "") {
        return false;
    }

    $cpf_md5 = md5($cpf);

    if ($senha !== "") {
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        if ($senha_hash === false) {
            return false;
        }

        $sql = "UPDATE professores SET nome=?, cpf=?, curso=?, login=?, senha=? WHERE id_professor=?";
        $stmt = mysqli_prepare($conexao, $sql);
        if (!$stmt) {
            return false;
        }

        mysqli_stmt_bind_param($stmt, "sssssi", $nome, $cpf_md5, $curso, $login, $senha_hash, $id_professor);
    } else {
        $sql = "UPDATE professores SET nome=?, cpf=?, curso=?, login=? WHERE id_professor=?";
        $stmt = mysqli_prepare($conexao, $sql);
        if (!$stmt) {
            return false;
        }

        mysqli_stmt_bind_param($stmt, "ssssi", $nome, $cpf_md5, $curso, $login, $id_professor);
    }

    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

function excluir_professor($conexao, $id_professor) {
    $sql = "DELETE FROM professores WHERE id_professor = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    if (!$stmt) {
        return false;
    }

    mysqli_stmt_bind_param($stmt, "i", $id_professor);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}
?>