<?php
include $_SERVER['DOCUMENT_ROOT'] . '\Trabalho_da_SEPE\templates\main.php';

if (isset($_SESSION['UserId'])) {

    if ($row['UserClass'] == 'adm' || $row['UserClass'] == 'host') {

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["userid"])) {
            if (isset($_POST['type'])) {
                if ($row['UserClass'] == 'adm' || $row['UserClass'] == 'host') {
                    if ($_POST['type'] == 'ban') {

                        $userId = $_POST["userid"];


                        $sqlCheckHost = "SELECT UserClass FROM users WHERE Userid = '$userId' AND UserClass = 'host'";
                        $resultCheckHost = mysqli_query($database, $sqlCheckHost);

                        if (mysqli_num_rows($resultCheckHost) > 0) {
                            echo "Não é possível banir um host.";
                            exit();
                        }

                        $sqlBan = "UPDATE users SET UserStatus = 'banned' WHERE UserID = '$userId'";

                        if (mysqli_query($database, $sqlBan)) {
                            echo "Usuário Banido com sucesso!";
                        }


                    } else if ($_POST['type'] == 'unban') {
                        $userId = $_POST["userid"];

                        $sqlUnban = "UPDATE users SET UserStatus = 'active' WHERE UserID = '$userId'";

                        if (mysqli_query($database, $sqlUnban)) {
                            echo "Usuário Desbanido com sucesso!";
                        }


                    } else if ($_POST['type'] == 'changeRole') {
                        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["userid"]) && isset($_POST["nova_classe"])) {
                            $userId = $_POST["userid"];
                            $novaClasse = $_POST["nova_classe"];

                            $sqlCheckHost = "SELECT UserClass FROM users WHERE Userid = '$userId' AND UserClass = 'host'";
                            $resultCheckHost = mysqli_query($database, $sqlCheckHost);

                            if (mysqli_num_rows($resultCheckHost) > 0) {
                                echo "Não é possível alterar a classe de um host.";
                                exit();
                            }

                            $sqlUpdateClass = "UPDATE users SET UserClass = '$novaClasse' WHERE UserID = '$userId'";

                            if (mysqli_query($database, $sqlUpdateClass)) {
                                echo "Classe do usuário atualizada com sucesso!";
                            } else {
                                echo "Erro ao atualizar a classe do usuário: " . mysqli_error($database);
                            }

                        } else {
                            echo 'Faltam informaçoes';
                        }
                    }
                } else {
                    echo 'Você não tem permição para banir um usuario';
                }
            }
        }


        $sql = "SELECT * FROM users";
        $result = mysqli_query($database, $sql);
        ?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Administração de Usuários</title>
        </head>
        <style>
            .conteudo2{
                display: flex;
                flex-direction: column;
                align-items: center;
            }
            table {
                font-family: sans-serif;
                border-collapse: collapse;
                background-color: rgb(237, 242, 252);

                margin: auto;
                border: solid 1px #3b3b3b;
                border-radius: 10px;
                overflow: hidden;

            }

            th,
            td {
                border: 1px solid #ccc;
                padding: 8px;
                text-align: left;
                border-radius: 0;
                white-space: nowrap
            }

            @media (max-width: 768px) {

                th,
                td {
                    display: block;
                    width: 100%;
                    box-sizing: border-box;
                }
            }
        </style>

        <body>

            <a href="<?php echo $url . '/' . '88/'?>" class="return-button">Voltar a pagina de adiministração</a>
     
            <a href="<?php echo $url ?>" class="return-button">Voltar a pagina principal</a>
            <h1>Administração de Usuários</h1>

            <table style="border-collapse: collapse;">
                <tr>
                    <th>Foto de Perfil</th>
                    <th>Nome Completo</th>
                    <th>Nome de Usuário</th>
                    <th>Email</th>
                    <th>Classe</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>

                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><img src="data:image/jpeg;base64,<?php echo (isset($row['profile_picture'])) ? $row['profile_picture'] : $row['default_picture'] ?>"
                                style="width:50px; height:50; border-radius:50%;" alt="Foto de Perfil"></td>
                        <td>
                            <?php echo $row['fullname']; ?>
                        </td>
                        <td>
                            <?php echo $row['username']; ?>
                        </td>
                        <td>
                            <?php echo $row['email']; ?>
                        </td>
                        <td>
                            <?php if ($row['UserClass'] !== 'host') { ?>
                                <form method="post">
                                    <input type="hidden" name="type" value="changeRole">
                                    <input type="hidden" name="userid" value="<?php echo $row['Userid']; ?>">
                                    <select name="nova_classe">
                                        <option value="user" <?php echo $row['UserClass'] === 'user' ? 'selected' : ''; ?>>Usuário
                                        </option>
                                        <option value="writer" <?php echo $row['UserClass'] === 'writer' ? 'selected' : ''; ?>>Escritor
                                        </option>
                                        <option value="adm" <?php echo $row['UserClass'] === 'adm' ? 'selected' : ''; ?>>Administrador
                                        </option>
                                    </select>
                                    <button type="submit">Alterar Classe</button>
                                </form>
                            <?php } else {
                                echo "Host";
                            } ?>
                        </td>
                        <td>
                            <?php echo $row['UserStatus']; ?>
                        </td>
                        <td>
                            <?php if ($row['UserClass'] !== 'host') { ?>

                                <form method="post">
                                    <?php if ($row['UserStatus'] === 'banned') { ?>
                                        <input type="hidden" name="type" value="unban">
                                        <input type="hidden" name="userid" value="<?php echo $row['Userid']; ?>">
                                        <button type="submit">Desbanir</button>
                                    <?php } else { ?>
                                        <input type="hidden" name="type" value="ban">
                                        <input type="hidden" name="userid" value="<?php echo $row['Userid']; ?>">
                                        <button type="submit">Banir</button>
                                    <?php } ?>
                                </form>
                            <?php } else {
                                echo "Host";
                            } ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </body>

        </html>
        <?php
    } else {
        echo 'Você não tem permissão para acessar esta pagina';
    }

} else {

    echo 'Faça login para acessar esta pagina';
}
$database->close();
?>