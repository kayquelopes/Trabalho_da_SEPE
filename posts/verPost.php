<?php

include $_SERVER['DOCUMENT_ROOT'] . '/Trabalho_da_SEPE/templates/main.php';
if (isset($_GET['PageId']) && $_GET['PageId'] != null) {
    $Pageid = $_GET['PageId'];

    $query = "SELECT * FROM posts WHERE Pageid = '$Pageid'";
    $resultPost = mysqli_query($database, $query);
    if ($resultPost->num_rows > 0) {

        $row = mysqli_fetch_assoc($resultPost);


        $dataHora = new DateTime($row['data']);
        $meses = array(
            1 => "Janeiro",
            2 => "Fevereiro",
            3 => "Março",
            4 => "Abril",
            5 => "Maio",
            6 => "Junho",
            7 => "Julho",
            8 => "Agosto",
            9 => "Setembro",
            10 => "Outubro",
            11 => "Novembro",
            12 => "Dezembro"
        );
        $dataFormatada = $dataHora->format("d \d\\e ") . $meses[$dataHora->format("n")] . $dataHora->format(" G:i");

        $query_creator = "SELECT * FROM users WHERE userid = '" . $row['CreatorId'] . "'";
        $result_creator = $database->query($query_creator);
        $row_creator = $result_creator->fetch_assoc();
        if (!empty($row_creator["profile_picture"])) {
            $creator_image = $row_creator["profile_picture"];
        } else {
            $creator_image = $row_creator["default_picture"];
        }

        ?>

        <script>

            window.onload = function () { var titulo = document.title; var adicional = "<?php echo $row['title'] ?>"; document.title = adicional + " - " + titulo; }


            $(document).ready(function () {
                $(document).on('click', '.mostrar-respostas-btn', function () {
                    var commentId = $(this).data('comment-id');
                    $('#respostas-' + commentId).toggle();
                });

                $(document).on('click', '.responder-btn', function () {
                    var commentId = $(this).data('comment-id');
                    $('#resposta-' + commentId).toggle();
                });
                $(document).on('click', '.delete-btn', function () {
                    var commentId = $(this).data('comment-id');
                    $.ajax({
                        url: '<?php echo $url . '/backend/comentarios.php' ?>',
                        type: 'post',
                        data: { commentId: commentId, type: 'exclude' },
                        success: function (response) {
                            alert(response);
                            buscarComentarios();
                        }
                    });
                });


                $(document).on('submit', '#resposta-formulario', function (e) {
                    e.preventDefault();

                    var parentCommentId1 = $(this).data('parent-id');
                    var nome = $(this).find('input').val();
                    var resposta = $(this).find('textarea').val();

                    $.ajax({
                        url: '<?php echo $url . '/backend/comentarios.php' ?>',
                        type: 'post',
                        data: { nome: nome, comentario: resposta, pagina_id: '<?php echo $Pageid ?>', parent_id: parentCommentId1 },
                        success: function (response) {
                            buscarComentarios();
                        }
                    });
                });
                $(document).on('submit', '#comentarioForm', function (e) {
                    e.preventDefault();

                    var nome = $(this).find('input[name="nome"]').val();
                    var comentario = $(this).find('textarea[name="comentario"]').val();

                    $.ajax({
                        url: '<?php echo $url . '/backend/comentarios.php' ?>',
                        type: 'post',
                        data: { nome: nome, comentario: comentario, pagina_id: '<?php echo $Pageid ?>' },
                        success: function (response) {
                            buscarComentarios();
                            $('#CommentTextArea').val('');
                            alert(response)
                        }
                    });
                });
                $(document).on('click', '.like-btn, .dislike-btn', function () {
                    var commentId = $(this).data('comment-id');
                    var action = $(this).hasClass('like-btn') ? 'like' : 'dislike';
                    var type = $(this).data('type');

                    $.ajax({
                        url: '<?php echo $url . '/backend/like_dislike.php' ?>',
                        type: 'post',
                        data: { comment_id: commentId, action: action, type: type },
                        success: function (response) {
                            buscarComentarios();
                            LikePagina();
                        }
                    });
                });

                function buscarComentarios() {
                    $.ajax({
                        url: '<?php echo $url . '/backend/comentarios.php' ?>',
                        type: 'get',
                        data: { pagina_id: '<?php echo $Pageid ?>' },
                        success: function (response) {
                            $('#comentarios').html(response);
                        }
                    });
                }

                function LikePagina() {
                    $.ajax({
                        url: '<?php echo $url . '/backend/likespag.php' ?>',
                        type: 'get',
                        data: { pagina_id: '<?php echo $Pageid ?>' },
                        success: function (response) {
                            $('#likespag').html(response);
                        }
                    });
                }
                LikePagina()
                buscarComentarios();
            });
        </script>

        <style>
            .conteudo2 {
                padding-top: 0;
            }

            .article {
                margin: auto;
                width: 60%;
                font-family: 'Open Sans';
            }


            @media (max-width: 700px) {
                .article {
                    width: 75%;
                }
            }

            @media (max-width: 500px) {
                .article {
                    width: 90%;

                }
            }

            .img-pggrs {
                max-width: 100%;
            }





            #commentForm {
                margin-bottom: 20px;
                padding: 10px;
                border: 1px solid #ccc;
                background-color: #ffffff;
                border-radius: 5px;
            }

            #comentarioForm textarea {
                width: 100%;
                margin-bottom: 10px;
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 5px;
                resize: none;

            }

            #comentarioForm .button {
                display: block;
                margin-left: auto;
                margin-right: auto;
            }

            #comentarios {
                border-top: 1px solid #ccc;
                padding-top: 20px;
                text-wrap: wrap;
            }

            .comentario {
                border: 1px solid #ccc;
                margin-bottom: 15px;
                padding: 10px;
                border-radius: 5px;
                background-color: #f9f9f9;
            }

            .comentario .acao-usuario {
                background-color: #e57373;
                color: white;
            }

            .comentario .like-btn,
            .comentario .dislike-btn {
                padding: 5px 10px;
                background-color: #007bff;
                color: #fff;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                margin-right: 10px;
            }

            .comentario .like-btn:hover,
            .comentario .dislike-btn:hover {
                background-color: #0056b3;
            }

            .comentario .respostas {
                margin-left: 20px;
                margin-top: 10px;
                border-left: 1px solid #ccc;
                padding-left: 10px;
            }


            .resposta-form {
                margin-top: 10px;
            }

            .resposta-form input,
            .resposta-form textarea {
                width: 100%;
                margin-bottom: 5px;
                padding: 5px;
                border: 1px solid #ccc;
                border-radius: 5px;
            }


            .resposta-aninhada {
                margin-left: 40px;
                border-left: 1px solid #ccc;
                padding-left: 10px;
            }

            .acao-usuario {
                background-color: pink;
            }

            .creator-alguma-coisa {
                display: flex;
                align-items: center;
            }

            .img-creator-alguma-coisa {
                height: 25px;
                border-radius: 50%;
                margin: 0 5px;
            }

            .delete-btn {
                margin: 0 10px;
            }

            .respostas {
                margin-left: 20px;
                padding-top: 10px;
                border-left: 1px solid #ccc;
            }
            video{
                max-height: 550px;
            }
        </style>

        <body>
            <article class="article">
                <header class="header-main-article">
                    <div style="width: 100%;height: 50px;">
                        <a href="<?php echo $url ?>" class="return-button">Voltar a pagina principal</a>
                    </div>
                    <div style="width: fit-content; margin: 0 auto">

                        <img src='data:image/jpeg;base64,<?php echo base64_encode($row['cover_image'])?>'
                            alt='<?php $row['title'] ?>'  style="border-radius: 1vh; margin-top: 20px; width:100%">
                    </div>
                    <h1 style="text-align:center;font-size: 40px;">
                        <?php echo $row['title'] ?>
                    </h1>
                    <p style="width: 90%; margin: 0 auto; padding: 20px 0; color: #555555;text-align:center;">
                        <?php echo $row['description'] ?>
                    </p>
                    <div style="width: 100%; height: 30px; padding: 30px 0 ; border-bottom: 1px solid #555555;">
                        <div style="float:left; color:#555555">
                            <a style="text-decoration:none; color: #555555;" href=<?php echo '"' . $url . '/users/verUsuario.php?UserId=' . $row_creator['Userid'] . '"' ?> class="a-autor-card-indiv">
                                <div
                                    style="    align-items: center;display: grid;grid-gap: 16px;grid-template-columns: minmax(40px, auto) 1fr;">
                                    <img alt="<? $row_creator['username'] ?>" style="border-radius:50%; height: 40px;"
                                         src="data:image/jpeg;base64,<?php echo $creator_image ?>"><?php echo $row_creator['username'] ?>
                                </div>
                            </a>
                        </div>
                        <div style="float:right; color:#555555">
                            <?php echo $dataFormatada ?>
                        </div>
                    </div>
        </header>
                <div class="div-content-main-article" style="border-bottom: 1px solid #555555;">
                    <div class="content-main-article" style="width: 85%; margin: 0 auto; padding: 40px 0;">
                        <?php echo $row['text_content'] ?>
                    </div>
                    <div id="likespag"></div>
                    <?php if(!isset($_COOKIE['UserId'])){
                        echo 'Faça login para dar feedback';
                    }
                    ?>
                </div>


                <div id="commentForm" style="margin-top: 50px;">
                    <?php
                    if (isset($_COOKIE['UserId'])) {
                        echo '
    <div style="display:flex;">
            <img src="data:image/jpeg;base64,' . $ProfilePicture . '" class="img-creator-alguma-coisa" alt="Foto de Perfil">
    <form style="width: -webkit-fill-available;" id="comentarioForm">

        <textarea style="width: -webkit-fill-available;" id="CommentTextArea" name="comentario" placeholder="Seu comentário" required></textarea>
        <button class="button" type="submit">Enviar Comentário</button>
    </form>
    </div>
    ';
                    } else {

                        echo 'Faça login para Comentar';
                    }
                    ?>
                    <h2>Discussão:</h2>
                    <section id="comentarios"></section>
                </div>
        </body>

        </html>
        <?php
    } else {
        echo 'Pagina não encotrado';
    }

} else {
    echo 'Pagina a visualizar não selecionada';
}
?>

</main>
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Trabalho_da_SEPE/templates/footer.php';
?>