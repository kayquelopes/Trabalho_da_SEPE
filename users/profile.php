<?php

include $_SERVER['DOCUMENT_ROOT'] . '/Trabalho_da_SEPE/templates/main.php';


if (isset($_SESSION['UserId'])) {

    $currentProfilePicture = '';


    $query = "SELECT * FROM users WHERE Userid = '$UserId'";
    $result = mysqli_query($database, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        $currentProfilePicture = $row['profile_picture'];

    }
    ?>
    <style>
        .conteudo2 {
            padding-top: 0;
            padding-bottom: 0;
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
            margin: 5px;
            padding: 14px 28px;
            border: solid 1px #3b3b3b;
            border-radius: 12px;
            text-decoration: none;
        }

        .mail-User-Info-Div-User-View {

            color: #252525;
        }

        #imageEditorContainer{
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.5);
            z-index: 9999;
        }


        .div-mail-User-Info-Div-User-View:hover .mail-User-Info-Div-User-View {
            text-decoration: underline !important;
        }

        .close {
            color: white;
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 30px;
            font-weight: bold;
            cursor: pointer;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.11/cropper.min.css">
    <?php
    $queryUser = "SELECT * FROM users WHERE userid = '" . $_COOKIE['UserId'] . "'";
    $resultUser = $database->query($queryUser);
    $rowUser = $resultUser->fetch_assoc();

    ?>
    <div style="  
    padding: 13px;
    display: flex;
    justify-content: center;
    flex-direction: column;
    align-items: center;">
        <a href="<?php echo $url ?>" class="return-button">Voltar a pagina principal</a>

    </div>
    
        <div class="User-Info-Div-User-View">

            <div class="div-img-User-Info-Div-User-View">
                <img id="profile-picture" class="img-User-Info-Div-User-View"
                    src="data:image/jpeg;base64,<?php echo (!empty($rowUser["profile_picture"])) ? $rowUser["profile_picture"] : $rowUser["default_picture"]; ?>">

                    <form id="removeProfPic" method="post">
        <input type="hidden" name="removeProfileImage" value="true">
        <input style="margin:10px" type="submit" name="submit" value="Remover Foto de Perfil">
    </form>
                    <form id="editForm" method="post" enctype="multipart/form-data">
                <label for="profileImage">Foto de Perfil:</label>

                <input type="file" accept="image/*" name="profileImage" id="profileImage">

               
            </div>

            <div class="div-img-User-Info-Div-User-View">
                <label for="fullname">Nome:</label>
                <input class="div-mail-User-Info-Div-User-View" type="text" required name="fullname" id="fullname"
                    value="<?php echo $row['fullname']; ?>">
                <br>
                <label for="username">Nome de usuario:</label>
                <input class="div-mail-User-Info-Div-User-View" type="text" required name="username" id="username"
                    value="<?php echo $row['username']; ?>">
                <br>
                <label for="descricao">Descrição:</label>
                <input class="div-mail-User-Info-Div-User-View" type="text" name="descricao" id="descricao"
                    value="<?php echo $row['descricao'] ?>"></textarea>
        
                <br>
                <input type="submit" class="div-mail-User-Info-Div-User-View" name="submit" value="Salvar">
            </div>
        </div>
    </form>


    <div id="imageEditorContainer" style="display: none; max-width: 500px;">
        <h2>Edite sua Foto de Perfil</h2>
        <div>

            <div style="max-height: 300px; overflow: hidden;">
                <img id="cropperImage" style="width: 100%;">
            </div>
        </div>
        <div>
            <button id="cropAndSaveButton">Recortar</button>
            <button id="cancelCropButton">Cancelar</button>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.11/cropper.min.js"></script>

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            document.getElementById('profileImage').addEventListener('change', function (e) {
                document.getElementById('imageEditorContainer').style.display = 'block';

                a
                const reader = new FileReader();
                reader.onload = function (e) {

                    resetCropper();

                    document.getElementById('cropperImage').src = e.target.result;

                    document.getElementById('cropperImage').onload = function () {
                        const cropper = new Cropper(document.getElementById('cropperImage'), {
                            aspectRatio: 1,
                            viewMode: 1,
                            autoCropArea: 1,
                        });


                        const cropAndSaveButton = document.getElementById('cropAndSaveButton');
                        const cancelCropButton = document.getElementById('cancelCropButton');

                        cropAndSaveButton.addEventListener('click', function () {
                            const croppedCanvas = cropper.getCroppedCanvas();
                            croppedCanvas.toBlob(function (blob) {

                                const croppedImageFile = new File([blob], 'cropped-image.png', {
                                    type: 'image/png'
                                });

                                const fileList = new DataTransfer();
                                fileList.items.add(croppedImageFile);

                                const profileImageInput = document.getElementById('profileImage');
                                profileImageInput.files = fileList.files;

                                document.getElementById('imageEditorContainer').style.display = 'none';
                            }, 'image/gif');
                        });

                        cancelCropButton.addEventListener('click', function () {

                            document.getElementById('profileImage').value = '';
                            document.getElementById('imageEditorContainer').style.display = 'none';
                        });
                    };
                };


                reader.readAsDataURL(e.target.files[0]);
            });
            function resetCropper() {
                const cropper = document.getElementById('cropperImage').cropper;
                if (cropper) {
                    cropper.destroy();
                }
                document.getElementById('cropperImage').src = '';
            }
        });
    </script>


    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
        if (isset($_POST['removeProfileImage'])) {

            $query = "UPDATE users SET profile_picture = NULL WHERE Userid = '$UserId'";
            mysqli_query($database, $query);
            echo '<script>window.location.href = window.location.href;</script>';
        } else if (isset($_POST['fullname'])) {
            $newUsername = isset($_POST['username']) ? $_POST['username'] : '';
            $newFullname = isset($_POST['fullname']) ? $_POST['fullname'] : '';
            $descricao = isset($_POST['descricao']) ? $_POST['descricao'] : '';
            $profileImage = isset($_FILES['profileImage']) ? $_FILES['profileImage'] : '';


            $queryA = "SELECT * FROM users WHERE username='$newUsername'";
            $resultA = mysqli_query($database, $queryA);

            $query = "SELECT username FROM users WHERE Userid = '$UserId'";
            $result = mysqli_query($database, $query);
            $oldUsername = mysqli_fetch_assoc($result);

            if (mysqli_num_rows($resultA) > 0) {
                $resultB = mysqli_fetch_assoc($resultA);
                if ($resultB['username'] !== $oldUsername['username']) {
                    die('<script>
                alert("Já tem um usuario com esse Nome de usuario");
                </script>');
                }
            }  
            
            if(trim($newUsername) == ''){
                die('<script>
                alert("nome de usuario não pode estar vazio");
                </script>');
            } else if(trim($newFullname) == ''){
                die('<script>
                alert("nome completo não pode estar vazio");
                </script>');
            } 
            
            if ($profileImage && $profileImage['name'] !== '') {
                $imageData = file_get_contents($profileImage['tmp_name']);
                $base64Image = base64_encode($imageData);
                $stmt = $database->prepare('UPDATE users SET profile_picture = ? WHERE Userid = ?');
                $stmt->bind_param('ss', $base64Image, $UserId);
                $stmt->execute();
            }
            
            $newFullname = ucfirst(strtolower($newFullname));
            $query = "UPDATE users SET fullname = '$newFullname' WHERE Userid = '$UserId'";
            mysqli_query($database, $query);

            $query = "UPDATE users SET descricao = '$descricao' WHERE Userid = '$UserId'";
            mysqli_query($database, $query);

            $query = "UPDATE users SET username = '$newUsername' WHERE Userid = '$UserId'";
            mysqli_query($database, $query);

            echo '<script>
            alert("Perfil atualizado!");
            window.location.href = window.location.href;</script>';
            exit;
        }
    }
    ?>

    <?php
} else {
    echo '<script>
    alert("Faça login para acessar esta pagina");
    window.location = "' . $url . '";
    </script>';
}
?>