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

// =======================================
// FUNÇÕES DE FOTOGRAFIA (DEMANDA 2)
// =======================================

// Recebe uma imagem, valida o arquivo e salva em uploads.
// Retorna o nome gerado ou false em caso de erro.
function enviar_foto($arquivo, $pasta_destino) {
    if (!isset($arquivo) || $arquivo["error"] !== UPLOAD_ERR_OK) {
        return false;
    }

    // Limita o tamanho a 2 MB.
    if ($arquivo["size"] > 2 * 1024 * 1024) {
        return false;
    }

    // Confere se o conteúdo é realmente uma imagem.
    $info = getimagesize($arquivo["tmp_name"]);
    if ($info === false) {
        return false;
    }

    // Aceita somente JPEG, PNG e WEBP.
    $permitidos = [
        "image/jpeg" => "jpg",
        "image/png" => "png",
        "image/webp" => "webp"
    ];

    $tipo = $info["mime"];
    if (!isset($permitidos[$tipo])) {
        return false;
    }

    // Gera um nome aleatório, sem confiar no nome enviado.
    $nome = bin2hex(random_bytes(16)) . "." . $permitidos[$tipo];
    $destino = rtrim($pasta_destino, "/\\") . DIRECTORY_SEPARATOR . $nome;

    if (move_uploaded_file($arquivo["tmp_name"], $destino)) {
        return $nome;
    }

    return false;
}

// Atualiza apenas a foto do aluno.
// O CPF é comparado em MD5, como no cadastro original.
function atualizar_foto_aluno($conexao, $cpf_md5, $foto) {
    $sql = "UPDATE alunos SET foto = ? WHERE cpf = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    if (!$stmt) {
        return false;
    }
    mysqli_stmt_bind_param($stmt, "ss", $foto, $cpf_md5);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

// Atualiza apenas a foto do professor.
function atualizar_foto_professor($conexao, $cpf_md5, $foto) {
    $sql = "UPDATE professores SET foto = ? WHERE cpf = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    if (!$stmt) {
        return false;
    }
    mysqli_stmt_bind_param($stmt, "ss", $foto, $cpf_md5);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

// Nova consulta de alunos incluindo a foto.
function listar_alunos_com_foto($conexao) {
    $sql = "SELECT id_aluno, nome, cpf, curso, login, foto
            FROM alunos ORDER BY nome";
    return mysqli_query($conexao, $sql);
}

// Nova consulta de professores incluindo a foto.
function listar_professores_com_foto($conexao) {
    $sql = "SELECT id_professor, nome, cpf, curso, login, foto
            FROM professores ORDER BY nome";
    return mysqli_query($conexao, $sql);
}
?>