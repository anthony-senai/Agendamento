<?php
// Agendamento

require_once 'conexao.php';
require_once 'funcoes.php';

$msg = '';
$tipo = '';

if (isset($_GET['sucesso'])) {

    $msg = 'Agendamento realizado com sucesso!';
    $tipo = 'ok';
}



if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = trim($_POST['nome'] ?? '');
    $servico_id = $_POST['servico_id'] ?? '';
    $data = $_POST['data'] ?? '';
    $hora = $_POST['hora'] ?? '';
    $senha = trim($_POST['senha'] ?? '');

    if (
        $nome === '' ||
        $servico_id === '' ||
        $data === '' ||
        $hora === '' ||
        $senha === ''
    ) {

        $msg = 'Preencha todos os campos.';
        $tipo = 'erro';


    } elseif (strlen($nome) < 2) {

        $msg = 'O nome deve ter pelo menos 2 caracteres.';
        $tipo = 'erro';


    } elseif (
        strlen($senha) !== 6 ||
        !ctype_digit($senha)
    ) {

        $msg = 'A senha deve ter exatamente 6 dígitos.';
        $tipo = 'erro';


    } elseif ($data < date('Y-m-d')) {

        $msg = 'A data não pode ser no passado.';
        $tipo = 'erro';

    } elseif (
        horarioOcupado(
            $conexao,
            $data,
            $hora
        )
    ) {

        $msg = 'Este horário já está ocupado.';
        $tipo = 'erro';


    } else {

        $resultado = criarAgendamento(
            $conexao,
            $nome,
            $servico_id,
            $data,
            $hora,
            $senha
        );


        if ($resultado) {

            header(
                'Location: agenda.php?sucesso=1'
            );

            exit;

        } else {

            $msg = 'Erro ao realizar o agendamento.';
            $tipo = 'erro';
        }
    }
}

$servicos = buscarServicos($conexao);

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Agendar Horário</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>


    <header>

        <h1>Agendar Horário</h1>

        <p>Preencha os dados para realizar seu agendamento</p>

    </header>


    <div class="container">


        <?php if ($msg !== '') { ?>

        <div class="msg msg-<?php echo $tipo; ?>">

            <?php echo htmlspecialchars($msg); ?>

        </div>

        <?php } ?>


        <form method="POST">


            <label for="nome">
                Nome
            </label>

            <input type="text" id="nome" name="nome" minlength="2" required>


            <label for="servico_id">
                Serviço
            </label>

            <select id="servico_id" name="servico_id" required>

                <option value="">
                    Selecione um serviço
                </option>


                <?php while ($servico = $servicos->fetch_assoc()) { ?>

                <option value="<?php echo $servico['id']; ?>">

                    <?php
                    echo htmlspecialchars(
                        $servico['nome']
                    );
                    ?>

                    -

                    R$

                    <?php
                    echo number_format(
                        $servico['preco'],
                        2,
                        ',',
                        '.'
                    );
                    ?>

                </option>

                <?php } ?>

            </select>


            <label for="data">
                Data
            </label>

            <input type="date" id="data" name="data" required>


            <label for="hora">
                Horário
            </label>

            <select id="hora" name="hora" required>

                <option value="">
                    Selecione um horário
                </option>

                <option value="08:00">08:00</option>
                <option value="09:00">09:00</option>
                <option value="10:00">10:00</option>
                <option value="11:00">11:00</option>
                <option value="13:00">13:00</option>
                <option value="14:00">14:00</option>
                <option value="15:00">15:00</option>
                <option value="16:00">16:00</option>
                <option value="17:00">17:00</option>

            </select>


            <label for="senha">
                Senha de 6 dígitos
            </label>

            <input type="text" id="senha" name="senha" maxlength="6" inputmode="numeric" required>


            <div class="acoes">

                <button type="submit" class="btn btn-azul">
                    Agendar Horário
                </button>


                <a href="index.php" class="btn btn-borda">
                    Voltar
                </a>

            </div>


        </form>

    </div>


    <footer>

        Sistema de Agendamento para Barbearias &copy; 2026

    </footer>


    <script src="script.js"></script>

</body>

</html>
