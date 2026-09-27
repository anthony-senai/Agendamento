<?php
// Cancelar agendamento

require_once 'conexao.php';
require_once 'funcoes.php';

$msg = '';
$tipo = '';

$agendamentos = [];

$nome_salvo = '';
$senha_salva = '';


if (
    isset($_POST['acao']) &&
    $_POST['acao'] === 'buscar'
) {

    $nome = trim($_POST['nome'] ?? '');
    $senha = trim($_POST['senha'] ?? '');


    if (
        strlen($nome) >= 2 &&
        strlen($senha) === 6
    ) {

        $agendamentos = buscarAgendamentos(
            $conexao,
            $nome,
            $senha
        );


        if (count($agendamentos) > 0) {

            $nome_salvo = $nome;
            $senha_salva = $senha;

        } else {

            $msg =
                'Nenhum agendamento encontrado com esse nome e senha.';

            $tipo = 'erro';
        }


    } else {

        $msg = 'Preencha todos os campos corretamente.';
        $tipo = 'erro';
    }
}


if (
    isset($_POST['acao']) &&
    $_POST['acao'] === 'cancelar'
) {

    $id = intval($_POST['id'] ?? 0);
    $nome = trim($_POST['nome'] ?? '');
    $senha = trim($_POST['senha'] ?? '');


    if (
        $id &&
        strlen($nome) >= 2 &&
        strlen($senha) === 6
    ) {

        $cancelado = cancelarAgendamento(
            $conexao,
            $id,
            $nome,
            $senha
        );


        if ($cancelado) {

            $msg = 'Agendamento cancelado com sucesso!';
            $tipo = 'ok';

        } else {

            $msg =
                'Não foi possível cancelar. O agendamento pode já ter sido removido.';

            $tipo = 'erro';
        }


        $agendamentos = buscarAgendamentos(
            $conexao,
            $nome,
            $senha
        );


        if (count($agendamentos) > 0) {

            $nome_salvo = $nome;
            $senha_salva = $senha;

        } else {

            $nome_salvo = '';
            $senha_salva = '';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Cancelar Agendamento</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>


<header>

    <h1>Cancelar Agendamento</h1>

    <p>
        Informe seus dados para consultar seus agendamentos
    </p>

</header>


<div class="container">


    <?php if ($msg !== '') { ?>

        <div class="msg msg-<?php echo $tipo; ?>">

            <?php echo htmlspecialchars($msg); ?>

        </div>

    <?php } ?>


    <form method="POST">

        <input
            type="hidden"
            name="acao"
            value="buscar"
        >


        <label for="nome">
            Nome
        </label>

        <input
            type="text"
            id="nome"
            name="nome"
            minlength="2"
            value="<?php echo htmlspecialchars($nome_salvo); ?>"
            required
        >


        <label for="senha">
            Senha de 6 dígitos
        </label>
        <input
        type="text" 
        id="senha" 
        name="senha" 
        maxlength="6" 
        minlength="6"
        pattern="\d{6}" 
        inputmode="numeric" 
        title="Digite exatamente 6 dígitos numéricos"
        required
        >


        <div class="acoes">

            <button
                type="submit"
                class="btn btn-azul"
            >
                Buscar Agendamentos
            </button>


            <a
                href="index.php"
                class="btn btn-borda"
            >
                Voltar
            </a>

        </div>

    </form>


    <?php if (count($agendamentos) > 0) { ?>

        <h2>Seus Agendamentos</h2>


        <?php foreach ($agendamentos as $agendamento) { ?>

            <div class="agendamento-card">


                <div class="agendamento-linha">

                    <span class="rotulo">
                        Serviço
                    </span>

                    <span class="valor">

                        <?php
                        echo htmlspecialchars(
                            $agendamento['servico']
                        );
                        ?>

                    </span>

                </div>


                <div class="agendamento-linha">

                    <span class="rotulo">
                        Data
                    </span>

                    <span class="valor">

                        <?php
                        echo date(
                            'd/m/Y',
                            strtotime(
                                $agendamento['data']
                            )
                        );
                        ?>

                    </span>

                </div>


                <div class="agendamento-linha">

                    <span class="rotulo">
                        Horário
                    </span>

                    <span class="valor">

                        <?php
                        echo substr(
                            $agendamento['hora'],
                            0,
                            5
                        );
                        ?>

                    </span>

                </div>


                <div class="agendamento-linha">

                    <span class="rotulo">
                        Preço
                    </span>

                    <span class="valor preco">

                        R$

                        <?php
                        echo number_format(
                            $agendamento['preco'],
                            2,
                            ',',
                            '.'
                        );
                        ?>

                    </span>

                </div>


                <form method="POST">

                    <input
                        type="hidden"
                        name="acao"
                        value="cancelar"
                    >


                    <input
                        type="hidden"
                        name="id"
                        value="<?php
                        echo $agendamento['id'];
                        ?>"
                    >


                    <input
                        type="hidden"
                        name="nome"
                        value="<?php
                        echo htmlspecialchars($nome_salvo);
                        ?>"
                    >


                    <input
                        type="hidden"
                        name="senha"
                        value="<?php
                        echo htmlspecialchars($senha_salva);
                        ?>"
                    >


                    <button
                        type="submit"
                        class="btn btn-vermelho"
                    >
                        Cancelar
                    </button>

                </form>


            </div>

        <?php } ?>

    <?php } ?>

</div>


<footer>

    Sistema de Agendamento para Barbearias &copy; 2026

</footer>


<script src="script.js"></script>

</body>

</html>
