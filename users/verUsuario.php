<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Trabalho_da_SEPE/templates/main.php';
if (isset($_GET['UserId']) && $_GET['UserId'] != null) {
    $UserIdSearch = $_GET['UserId'];

    $queryUser = "SELECT * FROM users WHERE userid = '" . $UserIdSearch . "'";
    $resultUser = $database->query($queryUser);
    if ($resultUser->num_rows > 0) {
        $rowUser = $resultUser->fetch_assoc();
        ?>
        <style>
            .conteudo2 {
                padding: 0;
            }

            .content {
                padding-right: 52px;
            }

            .div-img-User-Info-Div-User-View {
                display: flex;
                margin: 25px auto;
                flex-direction: column;
                align-items: center;
            }

            .img-User-Info-Div-User-View {
                height: 200px;
                margin: auto;
                border-radius: 50%;
            }

            .fullname-User-Info-Div-User-View {
                font-family: sans-serif;
                font-size: 24px;
                color: #3b3b3b;
            }

            .username-User-Info-Div-User-View {
                font-family: sans-serif;
                font-size: 18px;
                color: #3b3b3b;
            }

            .div-mail-User-Info-Div-User-View {
                margin: 24px;
                padding: 14px 28px;
                border: solid 1px #3b3b3b;
                border-radius: 12px;
                text-decoration: none;
            }

            .mail-User-Info-Div-User-View {

                color: #252525;
            }

            .div-mail-User-Info-Div-User-View:hover .mail-User-Info-Div-User-View {
                text-decoration: underline !important;
            }

            .div-actions-User-Info-Div-User-View {
                width: 100%;
                text-align: center;
                margin: 20px auto;
            }


            table {
                font-family: sans-serif;
                border-collapse: collapse;
                width: 80%;
                background-color: rgb(237, 242, 252);
                max-width: 600px;
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
                max-width: 100px;
                overflow-x: hidden;

            }

            @media (max-width: 600px) {

                th,
                td {
                    max-width: calc(360px / 4);
                }

                table {
                    font-size: 12px;
                }

            }

            @media (max-width: 300px) {

                table {
                    font-size: 8px;
                }

            }
        </style>
        <div style="  
    padding: 13px;
    display: flex;
    justify-content: center;
    flex-direction: column;
    align-items: center;">
            <a href="<?php echo $url ?>" class="return-button">Voltar a pagina principal</a>
            <?php
            if (isset($_COOKIE['UserId'])) {
                if ($UserIdSearch == $_COOKIE['UserId']) {
                    echo '<a href="' . $url . '/users/profile.php' . '" class="return-button">Editar perfil</a>';
                }
            }
            ?>
        </div>
        <div class="User-Info-Div-User-View">
            <div class="div-img-User-Info-Div-User-View">
                <img class="img-User-Info-Div-User-View" src="<?php
                if (!empty($rowUser['UserStatus'] == 'active' && $rowUser["profile_picture"])) {
                    echo 'data:image/jpeg;base64,' . $rowUser["profile_picture"];
                } else if ($rowUser['UserStatus'] == 'active') {
                    echo 'data:image/jpeg;base64,' . $rowUser["default_picture"];
                } else {
                    echo $url . '/midia/icones/default-light.png"';
                } ?>">
            </div>
            <div class="div-img-User-Info-Div-User-View">
                <span class="fullname-User-Info-Div-User-View">
                    <?php echo ($rowUser['UserStatus'] == 'active') ? $rowUser['fullname'] : 'banido' ?>
                </span>
                <span class="username-User-Info-Div-User-View">@<?php echo $rowUser['username'] ?>
                </span>

                <?php if (isset($rowUser['descricao']) && $rowUser['descricao'] != null) {
                    echo '<span style="margin:20px; class="username-User-Info-Div-User-View">' . $rowUser['descricao'] . '</span>';
                }
                ?>

                <a <?php echo ($rowUser['UserStatus'] == 'active') ? 'href="mailto:' . $rowUser['email'] . '"' : null ?>
                    class="div-mail-User-Info-Div-User-View">
                    <span class="mail-User-Info-Div-User-View">
                        <?php echo ($rowUser['UserStatus'] == 'active') ? $rowUser['email'] : 'banido' ?>
                    </span>
                </a>

                <div class="div-actions-User-Info-Div-User-View">
                    <?php if ($rowUser['UserStatus'] == 'active') { ?>

                        <span>Açoes de Feedback registradas do usuario</span>
                        <?php
                        $sql = "SELECT acao, tipo, comentario_id, Page_id FROM likes_dislikes WHERE user_id = '$UserIdSearch'";
                        $result = mysqli_query($database, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            echo '<table>
                        <tr>
                            <th>Ação</th>
                            <th>Tipo</th>
                            <th>Alvo</th>
                            <th>Localização</th>
                        </tr>';

                            while ($row = mysqli_fetch_assoc($result)) {
                                $acao = $row['acao'];
                                $tipo = $row['tipo'];
                                $comentario_id = $row['comentario_id'];
                                $page_id = $row['Page_id'];

                                echo '<tr>';
                                echo '<td>' . ucfirst($acao) . '</td>';
                                echo '<td>' . ucfirst($tipo) . '</td>';

                                if ($tipo == 'comentario') {
                                    $sqlComment = "SELECT comentario, CreatorId, pagina_id FROM comentarios WHERE comment_id = '$comentario_id'";
                                    $resultComment = mysqli_query($database, $sqlComment);
                                    $rowComment = mysqli_fetch_assoc($resultComment);
                                    $sqlUser = "SELECT username FROM users WHERE UserId = '" . $rowComment['CreatorId'] . "'";
                                    $resultUser = mysqli_query($database, $sqlUser);
                                    $rowUser = mysqli_fetch_assoc($resultUser);
                                    $sqlLocation = "SELECT title, topic FROM posts WHERE Pageid = '" . $rowComment['pagina_id'] . "'";
                                    $resultLocation = mysqli_query($database, $sqlLocation);
                                    $rowLocation = mysqli_fetch_assoc($resultLocation);
                                    $location = $rowLocation['topic'] . '/' . $rowLocation['title'];


                                    echo '<td>' . $rowUser['username'] . ':' . $rowComment['comentario'] . '</td>';

                                } elseif ($tipo == 'pagina') {
                                    $sqlLocation = "SELECT title, topic FROM posts WHERE Pageid = '" . $page_id . "'";
                                    $resultLocation = mysqli_query($database, $sqlLocation);
                                    $rowLocation = mysqli_fetch_assoc($resultLocation);
                                    $location = $rowLocation['topic'] . '/' . $rowLocation['title'];

                                    echo '<td>' . $location . '</td>';
                                }

                                echo '<td>' . $location . '</td>';
                                echo '</tr>';
                            }

                            echo '</table>';
                        } else {
                            echo '<p style="font-size:12px; color:gray;">Nenhuma ação de feedback encontrada para este usuário.</p>';
                        }


                        if(isset($UserClass)){
                            if($UserClass == 'host' || $UserClass == 'adm'){
                                $permit == true;
                            } else {
                                $permit == false;
                            }
                        } else {
                            $permit == false;
                        }
                        ?>
                    </div>
                    <div class="div-actions-User-Info-Div-User-View">

                        <span>Açoes de Comentarios registradas do usuario</span>
                        <?php
                        $sql = "SELECT parent_id, comentario, pagina_id, CommentStatus FROM comentarios WHERE CreatorId = '$UserIdSearch'";
                        $result = mysqli_query($database, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            echo '<table>
                <tr>
                    <th>Tipo</th>
                    <th>Comentario</th>
                    <th>Alvo</th>
                    <th>Localização</th>
                </tr>';
                            
                            while ($row = mysqli_fetch_assoc($result)) {
                                if ($row['parent_id'] != null) {
                                    $tipo = 'Resposta';
                                } else {
                                    $tipo = 'Comentario';

                                }
                                
                                if ($row['CommentStatus'] == 'active')
                                echo '<tr>';
                                if ($row['CommentStatus'] == 'active') {
                                    echo '<td>' . ucfirst($tipo) . '</td>';
                                } else {
                                    echo '<td>' . ucfirst($tipo) . ' (deleted)' . '</td>';
                                }
                                echo '<td>' . ucfirst($row['comentario']) . '</td>';

                                if ($tipo == 'Comentario') {

                                    $sqlLocation = "SELECT title, topic FROM posts WHERE Pageid = '" . $row['pagina_id'] . "'";
                                    $resultLocation = mysqli_query($database, $sqlLocation);
                                    $rowLocation = mysqli_fetch_assoc($resultLocation);
                                    $location = $rowLocation['topic'] . '/' . $rowLocation['title'];

                                    echo '<td>' . $location . '</td>';

                                } else if ($tipo == 'Resposta') {

                                    $sqlParentId = "SELECT CreatorId, comentario FROM comentarios WHERE comment_id = '" . $row['parent_id'] . "'";
                                    $resultParentId = mysqli_query($database, $sqlParentId);
                                    $rowParentId = mysqli_fetch_assoc($resultParentId);

                                    $sqlLocation = "SELECT title, topic FROM posts WHERE Pageid = '" . $row['pagina_id'] . "'";
                                    $resultLocation = mysqli_query($database, $sqlLocation);
                                    $rowLocation = mysqli_fetch_assoc($resultLocation);
                                    $location = $rowLocation['topic'] . '/' . $rowLocation['title'];

                                    $sqlParentIdUser = "SELECT username FROM users WHERE UserId = '" . $rowParentId['CreatorId'] . "'";
                                    $resultParentIdUser = mysqli_query($database, $sqlParentIdUser);
                                    $rowParentIdUser = mysqli_fetch_assoc($resultParentIdUser);

                                    echo '<td>' . $rowParentIdUser['username'] . ':' . $rowParentId['comentario'] . '</td>';
                                }

                                echo '<td>' . $location . '</td>';
                                echo '</tr>';
                            }

                            echo '</table>';
                        } else {
                            echo '<p style="font-size:12px; color:gray;">Nenhuma ação de comentario encontrada para este usuário.</p>';
                        }
                        ?>
                    </div>
                <?php } ?>
            </div>
        </div>
        <?php
    } else {
        echo 'Usuario não encotrado';
    }

} else {
    echo 'Usuario a visualizar não selecionada';
}

?>