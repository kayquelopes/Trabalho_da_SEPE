<?php
include $_SERVER['DOCUMENT_ROOT'] . '\Trabalho_da_SEPE\templates\main.php';


if (isset($_COOKIE['UserId'])) {
    if ($row['UserClass'] == 'adm' || $row['UserClass'] == 'writer' || $row['UserClass'] == 'host') {

        ?>
        <script>
            window.onload = function () { var titulo = document.title; var adicional = "Administração - Posts"; document.title = titulo + " - " + adicional; }
        </script>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Administração de Postagens</title>
            <style>
                table {
                    border-collapse: collapse;
                    width: 80%;
                    margin: auto;
                    margin-top: 20px;
                }

                th,
                td {
                    border: 1px solid #ccc;
                    padding: 8px;
                    text-align: left;
                }

                th {
                    background-color: #f2f2f2;
                }

                .div-post-adm {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                }

            </style>
        </head>

        <body>
            <div class="div-post-adm">
            <?php if(isset($_GET['return']) && $_GET['return'] == $url . '/' . '88/'){
                echo '<a href="' . $url . '/' . '88/' . '" class="return-button">Voltar a pagina de adiministração</a>';
            } ?>   
            <a href="<?php echo $url ?>" class="return-button">Voltar a pagina principal</a>
                <h1>Administração de Postagens</h1>

                <a href="<?php echo $url ?>/88/posts.php" style=" padding:5px 12px;background-color:#C2E7FF" class="sidebar-icon" isSelected="true"
                    href="#">
                    <img style="height:20px;" class="sidebar-img" src="<?php echo $url ?>/midia/icones/write.png"></img>
                    <span class="text" style="font-size:12px">Criar Post</span>
                </a>
                <table>
                    <tr>
                        <th>Capa</th>
                        <th>Título</th>
                        <th>Descrição</th>
                        <th>Tópico</th>
                        <th>Ultima edição</th>
                        <th>Data</th>
                        <th>Ações</th>
                    </tr>
                    <?php
                    $sql = "SELECT * FROM posts";
                    $result = $database->query($sql);


                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $Creatorid = $row["CreatorId"];
                            $Creatorquery = "SELECT * FROM users WHERE Userid = '$Creatorid'";
                            $Creatorresult = $database->query($Creatorquery);
                            $Creatorrow = $Creatorresult->fetch_assoc();

                            echo "<tr>
                    <td><img style='height:50px; width:50px;' src='data:image/jpeg;base64," . base64_encode($row["cover_image"]) . "'/></td>
                    <td>" . $row["title"] . "</td>
                    <td>" . $row["description"] . "</td>
                    <td>" . $row["topic"] . "</td>
                    <td>" . $Creatorrow['username'] . "</td>
                    <td>" . $row["data"] . "</td>
                    <td>
                        <button class='delete-btn' data-id='" . $row["Pageid"] . "'>Excluir</button>
                        <form action='posts.php' method='POST'>
                        <input type='hidden' name='Editing'>
                        <input type='hidden' name='Pageid' value='" . $row["Pageid"] . "'>
                        <button type='submit' class='edit-btn'>Editar</button>
                        </form>
                    </td>
                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>Nenhuma postagem encontrada.</td></tr>";
                    }

                    $database->close();
                    ?>
                </table>
            </div>

            <script>
                $(document).ready(function () {
                    $(".delete-btn").click(function () {
                        const postId = $(this).data("id");
                        const confirmDelete = confirm("Tem certeza que deseja excluir esta postagem?");

                        if (confirmDelete) {
                            $.ajax({
                                url: "<?php $url ?>/backend/delete_post.php",
                                method: "POST",
                                data: { id: postId },
                                success: function (response) {
                                    if (response === "success") {
                                        alert("Postagem excluída com sucesso!");
                                        location.reload();
                                    } else {
                                        alert(`Erro ao excluir a postagem: ${response}`);
                                    }
                                },
                                error: function (error) {
                                    console.error("Erro ao enviar solicitação: ", error);
                                }
                            });
                        }
                    });
                });
            </script>
        </body>

        </html>
        <?php
    } else {
        echo 'Você não tem permissão para acessar esta pagina';
    }
} else {
    echo 'Você precisa fazer login para acessar esta pagina';
}
$database->close();
?>