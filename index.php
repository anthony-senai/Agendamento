<?php

require_once 'conexao.php';
require_once 'funcoes.php';

$servicos = buscarServicos($conexao);

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Barbearia - Serviços</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>


    <header>

        <h1>Barbearia Navalha de Ouro</h1>

        <p>Escolha seu serviço e agende seu horário</p>

    </header>


    <div class="container">

        <h2>Nossos Serviços</h2>


        <?php while ($servico = $servicos->fetch_assoc()) { ?>

        <div class="servico">

            <h3>
                <?php echo htmlspecialchars($servico['nome']); ?>
            </h3>

            <span class="preco">

                R$

                <?php
                echo number_format(
                    $servico['preco'],
                    2,
                    ',',
                    '.'
                );
                ?>

            </span>

        </div>

        <?php } ?>


        <div class="acoes">

            <a href="agendamento.php" class="btn btn-azul">
                Agendar Horário
            </a>


            <a href="cancelar.php" class="btn btn-borda">
                Cancelar Agendamento
            </a>

            <a href="agenda.php" class="btn btn-azul">Ver Agenda</a>

        </div>

    </div>

    <footer>
        Sistema de Agendamento para Barbearias &copy; 2026
    </footer>
    <script src="script.js"></script>

</body>

</html>