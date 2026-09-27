<?php

function buscarServicos($conexao)
{
    $sql = "SELECT id, nome, preco
            FROM servicos
            ORDER BY id";

    return $conexao->query($sql);
}

function criarAgendamento(
    $conexao,
    $nome,
    $servico_id,
    $data,
    $hora,
    $senha
) {
    $sql = "INSERT INTO agendamentos
            (nome_cliente, servico_id, data, hora, senha)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conexao->prepare($sql);

    $stmt->bind_param(
        "sisss",
        $nome,
        $servico_id,
        $data,
        $hora,
        $senha
    );

    $resultado = $stmt->execute();

    $stmt->close();

    return $resultado;
}

function horarioOcupado($conexao, $data, $hora)
{
    $sql = "SELECT id
            FROM agendamentos
            WHERE data = ?
            AND hora = ?";

    $stmt = $conexao->prepare($sql);

    $stmt->bind_param(
        "ss",
        $data,
        $hora
    );

    $stmt->execute();

    $resultado = $stmt->get_result();

    $ocupado = $resultado->num_rows > 0;

    $stmt->close();

    return $ocupado;
}

function buscarAgendamentos($conexao, $nome, $senha)
{
    $sql = "SELECT
                a.id,
                a.data,
                a.hora,
                s.nome AS servico,
                s.preco
            FROM agendamentos a
            INNER JOIN servicos s
                ON s.id = a.servico_id
            WHERE a.nome_cliente = ?
            AND a.senha = ?
            ORDER BY a.data, a.hora";

    $stmt = $conexao->prepare($sql);

    $stmt->bind_param(
        "ss",
        $nome,
        $senha
    );

    $stmt->execute();

    $resultado = $stmt->get_result();

    $agendamentos = $resultado->fetch_all(MYSQLI_ASSOC);

    $stmt->close();

    return $agendamentos;
}

function cancelarAgendamento(
    $conexao,
    $id,
    $nome,
    $senha
) {
    $sql = "DELETE FROM agendamentos
            WHERE id = ?
            AND nome_cliente = ?
            AND senha = ?";

    $stmt = $conexao->prepare($sql);

    $stmt->bind_param(
        "iss",
        $id,
        $nome,
        $senha
    );

    $stmt->execute();

    $cancelado = $stmt->affected_rows > 0;

    $stmt->close();

    return $cancelado;
}

function buscarAgendas($conexao)
{
    $sql = "SELECT
                a.id,
                a.data,
                a.hora
            FROM agendamentos a
            ORDER BY a.data, a.hora";

    $resultado = $conexao->query($sql);

    return $resultado;
}
