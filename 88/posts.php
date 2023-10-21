<?php
include $_SERVER['DOCUMENT_ROOT'] . '\Trabalho_da_SEPE\templates\main.php';

if (isset($_SESSION['UserId'])) {

  if ($row['UserClass'] == 'adm' || $row['UserClass'] == 'writer' || $row['UserClass'] == 'host') {
    if (isset($_POST['Editing']) && isset($_POST['Pageid'])) {
      $editing = true;
      $editId = $_POST['Pageid'];
      $queryEdit = "select * from posts where Pageid = '$editId';";

      $editresult = $database->query($queryEdit);
      $editrow = $editresult->fetch_assoc();

    } else {
      $editing = false;
    }
    ?>
    <style>
      body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
      }

      .container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        background-color: #ffffff;
        border: 1px solid #ccc;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
      }

      .container input[type="text"],
      .container textarea,
      .container select {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        resize: vertical;
      }

      .container input[type="file"] {
        margin-top: 10px;
      }

      #editor {
        border: 1px solid #ccc;
        padding: 10px;
        min-height: 200px;
        margin-bottom: 10px;
        background-color: #f9f9f9;
        border-radius: 4px;
      }

      #toolbar {
        margin-bottom: 10px;
        align-items: center;
      }

      #toolbar button,
      #toolbar select,
      #toolbar input[type="color"] {
        margin-right: 10px;
        padding: 8px;
        background-color: #e0e0e0;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
      }

      #toolbar button:hover,
      #toolbar select:hover,
      #toolbar input[type="color"]:hover {
        background-color: #ccc;
      }

      #editor img,
      #editor video {
        max-width: 100%;
        height: auto;
        border: 1px solid #ccc;
        border-radius: 4px;
      }


      .container input[type="submit"] {
        padding: 12px 20px;
        background-color: #4caf50;
        color: #ffffff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
      }

      .container input[type="submit"]:hover {
        background-color: #45a049;
      }

      .resizing-top,
      .resizing-bottom {
        cursor: ns-resize;
      }

      .resizing-left,
      .resizing-right {
        cursor: ew-resize;
      }

      .resizing img {
        user-select: none;
        -webkit-user-drag: none;
      }

      .resizing img::-moz-selection {
        background: transparent;
      }

      figure {
        background-color: blue;
      }
    </style>


    <header style="width: auto;
    display: flex;">
      <a href="<?php echo $url ?>" class="return-button">Voltar a pagina principal</a>
      <a href="<?php echo $url . '/88/ver-posts.php' ?>" class="return-button">Voltar ao painel de postagens </a>
    </header>
    <?php if ($editing) {
      echo '<h1>Editar post</h1>' . 'POST ID:' . $_POST['Pageid'];
    } else {
      echo '<h1>Criar post</h1>';
    }


    ?>


    <form id="metadata" action="<?php echo $url . '/backend/post-submit.php'; ?>" method="post" enctype="multipart/form-data">
      <p><label for="title" required>titulo:</label>
        <input type="text" id="title" maxlength="90" value="<?php if ($editing) {
          echo $editrow['title'];
        } ?>" name="title">
      </p>

      <p style="display: flex;
    align-items: center;"><label for="description" required>descricao:</label>
        <textarea id="description" name="description"><?php if ($editing) {
          echo $editrow['description'];
        } ?></textarea>
      </p>

      <p><label for="topic" required>Topico:</label>
        <input type="text" id="topic" maxlength="50" value="<?php if ($editing) {
          echo $editrow['topic'];
        } ?>" name="topic">
      </p>

      <p><label for="cover">Cover Image:</label>
        <input type="file" id="imageInput" accept="image/*">
        <input type="hidden" id="cover" name="cover"
          value="<?php echo ($editing) ? 'data:image/png;base64,' . base64_encode($editrow["cover_image"]) : null; ?>">
        <img id="imagePreview" src="" alt="Preview da Imagem" style="max-width: 300px; max-height: 300px;">
        <?php echo ($editing) ? '<input type="hidden" name="editing" value="' . $editId . '">' : null; ?>
      </p>


      <div id="toolbar">
        <button type="button" class="toolbar-btn" onclick="execCommand('bold')"><strong>Negro</strong></button>
        <button type="button" class="toolbar-btn" onclick="execCommand('italic')"><em>Itálico</em></button>
        <button type="button" class="toolbar-btn" onclick="execCommand('underline')"><u>Sublinhar</u></button>
        <button type="button" class="toolbar-btn" onclick="execCommand('superscript')">Superescrito</button>
        <button type="button" class="toolbar-btn" onclick="execCommand('subscript')">Subescrito</button>
        <button type="button" class="toolbar-btn" onclick="execCommand('insertOrderedList')">Lista Ordenada</button>
        <button type="button" class="toolbar-btn" onclick="execCommand('insertUnorderedList')">Lista Desordenada</button>
        <button type="button" class="toolbar-btn" onclick="execCommand('undo')">Desfazer</button>
        <button type="button" class="toolbar-btn" onclick="execCommand('redo')">Refazer</button>
        <button type="button" class="toolbar-btn" onclick="createLink()">Adicionar Link</button>
        <button type="button" class="toolbar-btn" onclick="execCommand('unlink')">Remover Link</button>
        <button type="button" class="toolbar-btn" onclick="execCommand('justifyLeft')">Alinhar à Esquerda</button>
        <button type="button" class="toolbar-btn" onclick="execCommand('justifyCenter')">Centralizar</button>
        <button type="button" class="toolbar-btn" onclick="execCommand('justifyRight')">Alinhar à Direita</button>
        <button type="button" class="toolbar-btn" onclick="execCommand('justifyFull')">Justificar</button>
        <button type="button" class="toolbar-btn" onclick="createAnchor()">Criar Âncora</button>

        Fonte:
        <select class="toolbar-select" data-command="fontName" onchange="execCommand('fontName', this.value)">
          <option value="Arial">Arial</option>
          <option value="Courier New">Courier New</option>
          <option value="Times New Roman">Times New Roman</option>
          <option value="Verdana">Verdana</option>
        </select>

        Tamanho:
        <select class="toolbar-select" data-command="fontSize" onchange="execCommand('fontSize', this.value)">
          <option value="1">1 (8pt)</option>
          <option value="2">2 (10pt)</option>
          <option value="3" selected>3 (12pt)</option>
          <option value="4">4 (14pt)</option>
          <option value="5">5 (18pt)</option>
          <option value="6">6 (24pt)</option>
          <option value="7">7 (36pt)</option>
        </select>

        Cor do Texto:
        <input type="color" class="toolbar-color-input" data-command="foreColor"
          onchange="execCommand('foreColor', this.value)">

        Cor de Fundo:
        <input type="color" class="toolbar-color-input" data-command="hiliteColor"
          onchange="execCommand('hiliteColor', this.value)">
      </div>

      inserir imagem:
      <input type="file" id="EditorimageInput" accept="image/*">
      <button type="button" onclick="insertImage()">Inserir Imagem</button>
      <BR>
      inserir audio:
      <input type="file" id="audioInput" accept="audio/*">
      <button type="button" onclick="insertAudio()">Inserir Áudio</button>
      <BR>
      inserir video:
      <input type="file" id="videoInput" accept="video/*">
      <button type="button" onclick="insertVideo()">Inserir Vídeo</button>

      Link URL:
      <input type="text" id="linkInput">

      <input type="hidden" id="text_content" name="text_content">
      <button class="sidebar-icon" style="padding:10px 20px" type="submit">
        <?php echo ($editing) ? 'Salvar' : 'Enviar' ?>
      </button>
    </form>

    <div id="editor" class="editor" contenteditable="true" style="border: 1px solid black; padding: 10px;"
      required>
    <?php if ($editing) {
      echo $editrow['text_content'];
    } ?>
    </div>

    <script>


      function validaForm() {
        var valid = true;

        if ($("#title").val() === "") {
          alert("Insira um titulo");
          valid = false;
        } else {

          if ($("#description").val() === "") {
            alert("Insira uma descrição");
            valid = false;
          } else {


            if ($("#topic").val() === "") {
              alert("Insira um topico");
              valid = false;
            } else {


              if ($("#cover").val() === "") {
                alert("selecione uma capa");
                valid = false;
              } else {


                if ($("#editor").html().trim() === "") {
                  alert("Insira algum conteudo no conteudo");
                  valid = false;
                }
              }
            }
          }
        }


        return valid;
      }


      $(document).ready(function () {
        $("#imagePreview").attr("src", $("#cover").val());
        $("#imageInput").on("change", function (event) {
          var file = event.target.files[0];
          if (file) {
            var reader = new FileReader();
            reader.onload = function (e) {
              $("#cover").val(e.target.result);
              $("#imagePreview").attr("src", e.target.result);
            };
            reader.readAsDataURL(file);
          } else {
            $("#cover").val($("#cover").data("default"));
            $("#imagePreview").attr("src", $("#cover").data("default"));
          }
        });

        $("#metadata").submit(function (event) {
          event.preventDefault();

          if (validaForm()) {
            var formData = new FormData(this);

            $.ajax({
              url: $(this).attr("action"),
              type: "POST",
              data: formData,
              processData: false,
              contentType: false,
              dataType: "json",
              success: function (response) {
                if (response.error) {
                  // Se ocorrer um erro
                  alert(response.message);
                } else {
                  // Se a operação foi concluída com sucesso
                  alert(response.message);
                  window.location = "<?php echo $url ?>/88/ver-posts.php";
                }
              },
              error: function () {
                alert("Ocorreu um erro na requisição AJAX.");
              }
            });
          }
        });
      });

      var resizingElement = null;
      var initialX = null;

      function startResize(event) {
        resizingElement = event.target;

        if (resizingElement.tagName === "IMG" || resizingElement.tagName === "VIDEO") {
          resizingElement.classList.add("resizing");
          initialX = event.clientX;
          resizingElement.style.userSelect = "none";

          if (event.offsetY < 5) {
            resizingElement.classList.add("resizing-top");
          } else if (event.offsetY > resizingElement.clientHeight - 5) {
            resizingElement.classList.add("resizing-bottom");
          }

          if (event.offsetX < 5) {
            resizingElement.classList.add("resizing-left");
          } else if (event.offsetX > resizingElement.clientWidth - 5) {
            resizingElement.classList.add("resizing-right");
          }

          document.addEventListener("mousemove", doResize);
          document.addEventListener("mouseup", stopResize);
        }
      }


      function doResize(event) {
        if (resizingElement) {
          var deltaX = event.clientX - initialX;
          var newWidth = resizingElement.clientWidth + deltaX;

          if (resizingElement.tagName === "IMG" || resizingElement.tagName === "VIDEO") {
            resizingElement.style.width = newWidth + "px";
            initialX = event.clientX;
          }
        }
      }

      function stopResize() {
        if (resizingElement) {
          resizingElement.classList.remove("resizing", "resizing-top", "resizing-bottom", "resizing-left", "resizing-right");
          resizingElement.style.userSelect = "auto";
          resizingElement = null;
          initialX = null;

          document.removeEventListener("mousemove", doResize);
          document.removeEventListener("mouseup", stopResize);
        }
      }

      document.getElementById("editor").addEventListener("mousedown", function (event) {
        if (event.target.tagName === "IMG" || event.target.tagName === "VIDEO") {
          startResize(event);
        }
      });


      function insertImage() {
        var input = document.getElementById("EditorimageInput");
        var file = input.files[0];
        var reader = new FileReader();
        reader.onload = function (e) {
          for (var i = 0; i < 2; i++) {
            var containerBreak = document.createElement("div");
            containerBreak.appendChild(document.createElement("br"))

            document.querySelector("[contenteditable]").appendChild(containerBreak);
          }
          var figure = document.createElement("figure");
          var img = document.createElement("img");
          img.src = e.target.result;
          img.classList.add("img-pggrs");

          var figcaption = document.createElement("figcaption");
          figcaption.textContent = "Legenda da imagem";

          figure.appendChild(img);
          figure.appendChild(figcaption);

          var mediaContainer = document.createElement("div");
          mediaContainer.classList.add("media-container");
          mediaContainer.appendChild(figure);

          document.querySelector("[contenteditable]").appendChild(mediaContainer);

          for (var i = 0; i < 3; i++) {
            var containerBreak = document.createElement("div");
            containerBreak.appendChild(document.createElement("br"))

            document.querySelector("[contenteditable]").appendChild(containerBreak);
          }
        }
        reader.readAsDataURL(file);
      }


      function insertAudio() {
        var input = document.getElementById("audioInput");
        var file = input.files[0];
        var reader = new FileReader();
        reader.onload = function (e) {
          var figure = document.createElement("figure");
          var audio = document.createElement("audio");
          audio.src = e.target.result;
          audio.controls = true;
          audio.contentEditable = false;

          var figcaption = document.createElement("figcaption");
          figcaption.textContent = "Legenda do audio";

          figure.appendChild(audio);
          figure.appendChild(figcaption);

          var container = document.createElement("div");
          container.classList.add("media-container");
          container.appendChild(figure);

          document.querySelector("[contenteditable]").appendChild(container);

          for (var i = 0; i < 3; i++) {
            var containerBreak = document.createElement("div");
            containerBreak.appendChild(document.createElement("br"))

            document.querySelector("[contenteditable]").appendChild(containerBreak);
          }
        };
        reader.readAsDataURL(file);
      }

      function insertVideo() {
        var input = document.getElementById("videoInput");
        var file = input.files[0];
        var reader = new FileReader();
        reader.onload = function (e) {
          var video = document.createElement("video");
          video.src = e.target.result;
          video.classList.add("img-pggrs");
          video.controls = true;
          video.contentEditable = false;

          var container = document.createElement("div");
          container.classList.add("media-container");
          container.appendChild(video);

          document.querySelector("[contenteditable]").appendChild(container);

          for (var i = 0; i < 3; i++) {
            var containerBreak = document.createElement("div");
            containerBreak.appendChild(document.createElement("br"))

            document.querySelector("[contenteditable]").appendChild(containerBreak);
          }
        };
        reader.readAsDataURL(file);
      }


      function createLink() {
        var input = document.getElementById("linkInput");
        var url = input.value;
        document.execCommand("createLink", false, url);
      }

      document.getElementById("metadata").addEventListener("submit", function () {
        var textContent = document.getElementById("editor").innerHTML;
        document.getElementById("text_content").value = textContent;
      });

      function createAnchor() {
        const selection = window.getSelection().toString();

        if (selection.length === 0) {
          alert("Selecione um texto para criar a âncora.");
          return;
        }
        const anchorName = selection.replace(/\s/g, "-").toLowerCase();

        const anchor = document.createElement("div");
        anchor.id = anchorName;
        anchor.classList.add("anchor");
        anchor.innerHTML = `
                  <h2>${selection}</h2>
                  <p>Conteúdo da Âncora...</p>
                `;
        const editor = document.getElementById("editor");
        editor.appendChild(anchor);
        editor.appendChild(document.createElement("br"));
        const selectedNode = window.getSelection().anchorNode.parentNode;

        const link = document.createElement("a");
        link.href = `#${anchorName}`;
        link.innerHTML = selection;

        const range = window.getSelection().getRangeAt(0);
        range.deleteContents();
        range.insertNode(link);

        editor.focus();
      }

      const toolbar = document.getElementById('toolbar');
      const editor = document.getElementById('editor');

      toolbar.addEventListener('click', (event) => {
        const command = event.target.getAttribute('data-command');
        if (command) {
          document.execCommand(command, false, null);
        }
      });

      toolbar.addEventListener('change', (event) => {
        const command = event.target.getAttribute('data-command');
        if (command) {
          const value = event.target.value;
          document.execCommand(command, false, value);
        }
      });
    </script>

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