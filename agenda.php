<?php
// Agenda geral

require_once 'conexao.php';
require_once 'funcoes.php';

$agendas = buscarAgendas($conexao);

$msg = '';
$tipo = '';

if (isset($_GET['sucesso'])) {

    $msg = 'Agendamento realizado com sucesso!';
    $tipo = 'ok';
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Agenda</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

    <header>

        <h1>Agenda</h1>

        <p>Agendamentos marcados</p>

    </header>

    <div class="container">

        <?php if ($msg !== '') { ?>

        <div class="msg msg-<?php echo $tipo; ?>">

            <?php echo htmlspecialchars($msg); ?>

        </div>

        <?php } ?>

        <h2>Agendamentos</h2>

        <?php if ($agendas->num_rows > 0) { ?>

        <?php while ($agenda = $agendas->fetch_assoc()) { ?>

        <div class="agendamento-card">


            <div class="agendamento-linha">

                <span class="rotulo">
                    Data
                </span>

                <span class="valor">
                    <?php
                        echo date(
                            'd/m/Y',
                            strtotime($agenda['data'])
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
                            $agenda['hora'],
                            0,
                            5
                        );
                        ?>
                </span>

            </div>

        </div>

        <?php } ?>

        <?php } else { ?>

        <p>Nenhum agendamento encontrado.</p>

        <?php } ?>

        <div class="acoes">

            <a href="cancelar.php" class="btn btn-vermelho">
                Cancelar Agendamento
            </a>

            <a href="index.php" class="btn btn-borda">
                Voltar
            </a>

        </div>

    </div>

    <footer>

        Sistema de Agendamento para Barbearias &copy; 2026

    </footer>

    <script src="script.js"></script>

</body>

</html>