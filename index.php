<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Trabalho_da_SEPE/templates/main.php';
?>

<script>
    window.onload = function () { var titulo = document.title; var adicional = "Pagina principal"; document.title = titulo + " - " + adicional; }
</script>

<style>
    a {
        text-decoration: none;
    }

    .card-indiv {
        box-shadow: 0 1px 2px rgb(54 64 67 / 30%), 0 1px 3px 1px rgb(54 64 67 / 15%);
        grid-template-columns: auto 440px;
        padding: 36px 36px 36px 60px;
        grid-gap: 24px 36px;
        grid-template-rows: 1fr auto;
        border-radius: 16px;
        display: grid;
        transition: all .25s ease-in-out;
        cursor: pointer;
    }

    .card-indiv:hover {
        box-shadow: 0 4px 4px rgb(54 64 67 / 30%), 0 8px 12px 6px rgb(54 64 67 / 15%);
    }

    .sec-card-indiv {
        display: none;
        animation: card-indiv 1.5s ease 0s 1 normal none running;
        margin: 25px auto;
        max-width: 1100px;
        padding: 0 32px;
        zoom: 0.7;
    }

    .alink-card-indiv {
        grid-column: 1/2;
        grid-row: 1/2;
        padding-top: 16px;
    }

    .h2-card-indiv {
        font-size: 32px;
        line-height: 1.1818181818;
        letter-spacing: -0.5px;
        text-rendering: optimizeLegibility;
        color: #202124;
        font-weight: 400;
        word-wrap: initial;
        margin: 0;
        padding: 0;
        font-family: 'Roboto', sans-serif;
    }

    .p-card-indiv {
        color: #5f6368;
        font-family: 'Roboto', sans-serif;
        font-size: 16px;
        line-height: 26px;
        margin-top: 24px;
        margin: 0;
        padding: 0;
        line-break: anywhere;
    }

    .a-img-card-indiv {
        grid-column: 2/3;
        grid-row: 1/3;
        height: 262px;
        border-radius: 12px;
    }

    .a-img-card-indiv:focus {
        outline: 2px solid #174ea6;
        outline-offset: 0;
    }

    .img-card-indiv {
        object-fit: cover;
        width: 100%;
        height: 100%;
        border-radius: 12px;
    }

    .div-autor-card-indiv {
        align-items: center;
        display: flex;
        justify-content: space-between;

    }

    .a-autor-card-indiv {
        align-items: center;
        display: grid;
        grid-gap: 16px;
        grid-template-columns: minmax(40px, auto) 1fr;
    }

    .autor-img-car-indiv {
        height: 40px;
        width: 40px;
    }

    .autor-info-car-indiv {
        font-family: 'Roboto', sans-serif;
        font-size: 14px;
        letter-spacing: 0;
        line-height: 24px;
    }

    .autor-name-car-indiv {
        color: #5f6368;
        font-weight: 700;
        line-height: 18px;
    }

    .div-container-carrosel {
        padding: 64px 0px;

    }

    .container-carrosel {
        max-width: 1100px;
        margin: 0 auto;
        display: flex;
        zoom: 0.7;

    }

    .carousel {
        width: 886px;
        overflow: hidden;
        position: relative;

    }

    .ul-itens {
        width: 900px;
        list-style: none;
        margin: 0;
        padding: 0;
        display: flex;
        transition: transform 0.5s ease;
    }

    .list-item {
        padding: 0 26px;
    }

    .carousel .prev,
    .carousel .next {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background-color: #fff;
        padding: 10px;
        font-size: 20px;
        cursor: pointer;
    }

    .carousel .prev {
        left: 2px;
        top: 170px;
    }

    .carousel .next {
        right: 18px;
        top: 170px;
    }

    .dots-container {
        display: flex;
        justify-content: center;
        margin-top: 10px;
    }

    .dots {
        display: flex;
        justify-content: center;
        padding: 8px;
    }

    .dots .dot {
        width: 10px;
        height: 10px;
        background-color: #bbb;
        border-radius: 50%;
        margin: 0 5px;
        cursor: pointer;
    }

    .dots .dot.active {
        background-color: #888;
    }

    .image-carrousel {

        aspect-ratio: 3/2;
        object-fit: cover;
        height: 150px;
    }

    .div-carrosel {
        width: 870px;
        /* 3 seções * (300px + 10px * 2) */
        padding: 0 20px;

    }

    .a-item-carrosel {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        cursor: pointer;
    }

    .a-item-carrosel:hover .title-carrosel {
        text-decoration: underline;
        text-decoration-color: #000;
        transition: .3s;
    }

    .a-item-carrosel:hover .image-carrousel {
        transform: scale(1.03);
        transition: transform 0.2s;
        transform-origin: bottom;
    }

    .div-title-item-carrosel {
        margin-bottom: 20px;
        width: 250px;
        height: 75px;
    }

    .title-carrosel {
        color: #202124;
        font-family: 'Roboto';
        font-weight: 400;
        overflow: hidden;
        margin: 0;
        font-size: 20px;
        overflow: hidden;
    }

    .image-carrousel {
        width: 250px;
        object-fit: cover;
        height: 150px;
        border-radius: 8px;
    }

    .h2-topico-carrosel {
        font-size: 24px;
        font-weight: 700;
        font-family: 'Roboto';
        overflow: hidden;
        margin: 0;
    }

    .div-title-topico-carrosel {
        width: 225px;
        margin-bottom: 75px;
    }

    .span-topico-carrosel {
        font-size: 16px;
        font-weight: 400;
        font-family: 'Roboto';
    }

    .a-more-topico-carrosel {
        align-items: center;
        background: #fff;
        border: 1px solid #dadce0;
        border-radius: 4px;
        display: flex;
        font-size: 16px;
        font-weight: 400;
        justify-content: center;
        line-height: 24px;
        min-height: 48px;
        padding: 0 8px;
        color: #1a73e8;
        cursor: pointer;
    }

    .a-more-topico-carrosel:hover {
        background-color: #f2f7fe;
    }

    .seta-carrosel {
        align-items: center;
        background: #fff;
        border: 0;
        border-radius: 50%;
        bottom: 130px;
        box-shadow: 0 1px 2px rgba(54, 64, 67, .3), 0 1px 3px 1px rgba(54, 64, 67, .15);
        display: flex;
        height: 32px;
        width: 32px;
        justify-content: center;
        position: absolute;
        transition: all .5s;
    }

    .a-autor-card-indiv:hover .autor-info-car-indiv {
        text-decoration: underline;
    }

    @media (max-width: 690px) {
        .sec-card-indiv {
            padding: 0 16px !important;
        }

        .card-indiv {
            display: block !important;
            padding: 16px !important;
        }

        .p-card-indiv {
            display: none;
        }

        .img-card-indiv {
            object-fit: cover;
            width: 100%;
            max-height: 400px;
            border-radius: 12px;
        }

        .h2-card-indiv {
            font-size: 20px !important;
            margin: 7px !important;
        }

        .a-img-card-indiv {
            height: 230px;
            display: block;
            width: 100%;
            margin: 15px 0px;
        }

        .div-autor-card-indiv {
            margin: 2px 4px;
        }

        .conteudo2 {
            padding: 10px !important;
        }
    }

    @media (max-width: 830px) {

        a {
            text-decoration: none;
        }

        .div-container-carrosel {
            padding: 38.4px 19.2px;
        }

        .container-carrosel {
            max-width: 660px;
            margin: 0 auto;
            padding: 0 22.8px;
            display: flex;
        }

        .carousel {
            width: 531.6px;
            overflow: hidden;
            position: relative;
        }

        .ul-itens {
            width: 540px;
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            transition: transform 0.5s ease;
        }

        .carousel .prev,
        .carousel .next {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: #fff;
            padding: 4px;
            font-size: 12px;
            cursor: pointer;
        }

        .carousel .prev {
            left: 1.2px;
            top: 102px;
        }

        .carousel .next {
            right: 7.2px;
            top: 102px;
        }

        .dots-container {
            display: flex;
            justify-content: center;
            margin-top: 4px;
        }

        .dots {
            display: flex;
            justify-content: center;
            padding: 3.2px;
        }

        .dots .dot {
            width: 4px;
            height: 4px;
            background-color: #bbb;
            border-radius: 50%;
            margin: 0 2px;
            cursor: pointer;
        }

        .dots .dot.active {
            background-color: #888;
        }

        .image-carrousel {
            aspect-ratio: 3/2;
            object-fit: cover;
            height: 90px;
        }

        .div-carrosel {
            width: 522px;
            padding: 0 12px;
        }

        .a-item-carrosel {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            cursor: pointer;
        }

        .a-item-carrosel:hover .title-carrosel {
            text-decoration: underline;
            text-decoration-color: #000;
            transition: 0.3s;
        }

        .a-item-carrosel:hover .image-carrousel {
            transform: scale(0.963);
            transition: transform 0.2s;
            transform-origin: bottom;
        }

        .div-title-item-carrosel {
            margin-bottom: 12px;
            width: 150px;
            height: 45px;
        }

        .title-carrosel {
            color: #202124;
            font-family: 'Roboto';
            font-weight: 400;
            overflow: hidden;
            margin: 0;
            font-size: 12px;
            overflow: hidden;
        }

        .image-carrousel {
            width: 150px;
            object-fit: cover;
            height: 90px;
            border-radius: 3.2px;
        }

        .h2-topico-carrosel {
            font-size: 14.4px;
            font-weight: 700;
            font-family: 'Roboto';
            overflow: hidden;
            margin: 0;
        }

        .div-title-topico-carrosel {
            width: 135px;
            margin-bottom: 45px;
        }

        .span-topico-carrosel {
            font-size: 9.6px;
            font-weight: 400;
            font-family: 'Roboto';
        }

        .a-more-topico-carrosel {
            align-items: center;
            background: #fff;
            border: 0.4px solid #dadce0;
            border-radius: 2.4px;
            display: flex;
            font-size: 9.6px;
            font-weight: 400;
            justify-content: center;
            line-height: 14.4px;
            min-height: 28.8px;
            padding: 0 4.8px;
            color: #1a73e8;
            cursor: pointer;
        }

        .a-more-topico-carrosel:hover {
            background-color: #f2f7fe;
        }

        .seta-carrosel {
            align-items: center;
            background: #fff;
            border: 0;
            border-radius: 50%;
            bottom: 78px;
            box-shadow: 0 0.4px 0.8px rgba(54, 64, 67, 0.3), 0 0.4px 1.2px 0.4px rgba(54, 64, 67, 0.15);
            display: flex;
            height: 19.2px;
            width: 19.2px;
            justify-content: center;
            position: absolute;
            transition: all 0.5s;
        }
    }

    @media (max-width: 500px) {
        .container-carrosel {
            display: block;
            padding: 0;
        }

        .div-carrosel {
            margin: auto;
        }

        .div-container-carrosel {
            padding: 0;
            margin: 35px 0;
        }

        .div-title-topico-carrosel {
            margin: 0 auto 12px;
            width: fit-content;
        }

        .a-more-topico-carrosel {
            margin: 10px 20%;
        }
    }

    @media (max-width: 381px) {
        .dot {
            display: none;
        }

        .conteudo2 {
            padding: 0 !important;
        }

        .div-carrosel {
            padding: 0 !important;
        }

        .div-carrosel {
            width: 152vw;
        }

        .carousel {
            width: 152vw;
        }

        .ul-itens {
            width: 152vw;
            overflow-x: auto;
            padding-bottom: 12px;
        }

        .div-container-carrosel {
            margin: 29px 0;
        }

        .a-autor-card-indiv {
            display: flex;
            flex-direction: column;
            margin: auto;
        }
    }

    #img-index {
        max-width: 772px;
        width: 95%;
        border-radius: 15px;
    }

    .card-group {
        box-shadow: 0 1px 2px rgb(54 64 67 / 50%), 0 1px 3px 1px rgb(54 64 67 / 25%);
        border-radius: 10px;
        transition: all .25s ease-in-out;
        cursor: pointer;
        width: 212px;
        height: 250px;
    }

    .card-group:hover {
        box-shadow: 0 4px 4px rgb(54 64 67 / 30%), 0 8px 12px 6px rgb(54 64 67 / 15%);
    }

    .div-img-card-group {
        height: 55%;
        width: 100%;
    }

    .img-card-group {
        height: 100%;
        width: 100%;
        border-radius: 10px 10px 0px 0px;
        object-fit: cover;
    }

    .div-inf-card-group {
        height: 30%;
        width: 95%;
        padding: 1% 0 0 5%;
    }
    .a-card-group{
        height: 100%;
        width: 100%;
    }

    .a-card-group * {
        line-break: anywhere;
        overflow: hidden;
    }
    .autor-info-card-group{
        display: flex;
    }
    .autor-img-card-group{
        height: 25px;
        width: 25px;
        margin: 0 3px 0 7px
    }

    .grid-card-group{
        display: flex;
        gap: 10px;
        justify-content: center;
        flex-wrap: wrap;
    }
    @keyframes card-indiv {
        from {
            opacity: 0;
            transform: scale(0.9);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }
    }
</style>
<div style="margin:auto;text-align:center;">
    <img id='img-index' src="<?php echo $url ?>/midia/icones/indexcapa.png" alt="Geographic World">
</div>
<?php
$query = "SELECT * FROM posts ORDER BY topic";
$result = $database->query($query);

if ($result->num_rows > 0) {
    $query_card_indiv = "SELECT * FROM posts ORDER BY data DESC LIMIT 7";
    $result_card_indiv = $database->query($query_card_indiv);

    if ($result_card_indiv->num_rows > 0) {

        echo '<header>';
        while ($row_card = $result_card_indiv->fetch_assoc()) {

            $dataHora = new DateTime($row_card['data']);
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
            $query_card_indiv_creator = "SELECT * FROM users WHERE userid = '" . $row_card['CreatorId'] . "'";
            $result_card_indiv_creator = $database->query($query_card_indiv_creator);
            $row_card_creator = $result_card_indiv_creator->fetch_assoc();
            if (!empty($row_card_creator["profile_picture"])) {
                $card_creator_image = $row_card_creator["profile_picture"];
            } else {
                $card_creator_image = $row_card_creator["default_picture"];
            }

            echo '
                    <div class="sec-card-indiv">
                        <div class="card-indiv card redirectiable" data-url="' . $url . '/' . 'posts/verPost.php?PageId=' . $row_card['Pageid'] . '">
                    <a class="alink-card-indiv">
                        <h2 class="h2-card-indiv">' . $row_card['title'] . '</h2>
                        <p class="p-card-indiv">' . $row_card['description'] . '</p>
                    </a>
                    <a class="a-img-card-indiv"><img alt="' . $row_card['title'] . '" class="img-card-indiv" src="data:image/jpeg;base64,' . base64_encode($row_card["cover_image"]) . '"/></a>
                    <div class="div-autor-card-indiv">
                        <a href="' . $url . '/users/verUsuario.php?UserId=' . $row_card_creator['Userid'] . '" class="a-autor-card-indiv">
                            <div>
                                <img alt="Autor" style="border-radius:50%" class="autor-img-car-indiv"
                                    src="data:image/jpeg;base64,' . $card_creator_image . '">
                            </div>
                            <div class="autor-info-car-indiv">
                                <span class="autor-name-car-indiv">' . $row_card_creator['username'] . ' <span style="font-size: 13px;color: gray;">&bull;  ' . $dataFormatada . '</span></span>

                            </div>
                        </a>
                    </div>
                </div>
            </div>
            ';

        }
        echo '</header>';
    }



    $currentTopic = "";
    echo '<div class="grid-card-group">';
    while ($row = $result->fetch_assoc()) {

        //<p style="font-size: 12px; margin:0 2px">topico</p>
       echo' <div class="card-group">
    <div class="a-card-group redirectiable" data-url="' . $url . '/' . 'posts/verPost.php?PageId=' . $row['Pageid'] . '">
        <div class="div-img-card-group">
            <img class="img-card-group" src="data:image/jpeg;base64,' . base64_encode($row["cover_image"]) . '">
        </div>
        <div class="div-inf-card-group">
            
            <p style="font-size: 18px; margin-top:5px">' . $row["title"] . '</p>
        </div>
        <a href="bliat" class="autor-info-card-group">
            <div>
                <img alt="Autor" style="border-radius:50%" class="autor-img-card-group"
                    src="data:image/jpeg;base64,' . $card_creator_image . '">
            </div>
            <div class="autor-info-car-indiv">
                        <span class="autor-name-car-indiv">' . $row_card_creator['username'] . '<span
                        style="font-size: 13px;color: gray;">&bull; ' . $dataFormatada . '</span></span>

            </div>
</a>

</div>
</div>';

        /*
        if ($row["topic"] != $currentTopic) {
            if ($currentTopic != "") {
                echo '</div>
                <div class="prev seta-carrosel">&#10094;</div>
                <div class="next seta-carrosel">&#10095;</div>
            </div>
            <div class="dots-container">
                <div class="dots"></div>
            </div>
        </div>
    </div>
    </section>';
            }
            echo '
            <section class="div-container-carrosel">
            <div class="container-carrosel">
            <div>
                <div class="div-title-topico-carrosel">
                <h2 class="h2-topico-carrosel">' . $row['topic'] . '</h2>
                </div>
                    <a class="a-more-topico-carrosel" href="' . $url . '/' . 'posts/verTopico.php?TopicoName=' . str_replace(" ", "%20", $row['topic']) . '">
                    <span class="span-topico-carrosel">
                        Veja mais
                    </span><svg style="height:15px; margin: -2px 4px;" viewBox="0 0 18 18"><path fill-rule="evenodd" clip-rule="evenodd"
              d="M9 0C4.02933 0 0 4.02933 0 9C0 13.9707 4.02933 18.0003 9 18.0003C13.9707 18.0003 18 13.9707 18 9C18 4.02933 13.9707 0 9 0ZM9 14.4492L8.03686 13.486L11.8417 9.68115H3.55082V8.31885H11.8417L8.03686 4.51396L9 3.55082L14.4492 9L9 14.4492Z"
              fill="#1A73E8"/></svg>
                    </a>
            </div>
            <div class="div-carrosel">
                <div class="carousel">
                    <ul class="ul-itens">';
            $currentTopic = $row["topic"];
        }

        echo '
            <li class="list-item">
                <a href="' . $url . '/' . 'posts/verPost.php?PageId=' . $row['Pageid'] . '" class="a-item-carrosel">
                    <div class="div-title-item-carrosel">
                        <h3 class="title-carrosel">' . $row["title"] . '</h3>
                    </div>
                    <img alt="' . $row['title'] . '" class="image-carrousel" src="data:image/jpeg;base64,' . base64_encode($row["cover_image"]) . '"/>
                </a>
            </li>
    ';
    */
    }
    echo '</div>';
    /*

    echo '</ul>
        <div class="prev seta-carrosel">&#10094;</div>
        <div class="next seta-carrosel">&#10095;</div>
    </div>
    <div class="dots-container">
        <div class="dots"></div>
    </div>
</div>
</div>
</section>'
    ;
    */
} else {
    echo "<div style='text-align:center;'>Nenhuma postagem encontrada</div>";
}

?>

<br>


</div>
</main>

<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Trabalho_da_SEPE/templates/footer.php';
?>

<script>


    document.addEventListener('DOMContentLoaded', function () {

        const divElements = document.querySelectorAll('.redirectiable');

        divElements.forEach(element => {
            element.addEventListener('click', () => {

                const url = element.getAttribute('data-url');

                window.location.href = url;
            });
        });

        let touchStartX = 0;
        let touchEndX = 0;

        function setupCarousels() {
            const carousels = document.querySelectorAll('.carousel');

            carousels.forEach(function (carousel) {
                const prevButton = carousel.querySelector('.prev');
                const nextButton = carousel.querySelector('.next');
                const list = carousel.querySelector('.ul-itens');
                const listItem = carousel.querySelectorAll('.list-item');
                const itemWidth = listItem[0].offsetWidth + 20;
                const visibleItems = 3;
                const totalSections = Math.ceil(listItem.length / visibleItems);
                let currentSection = 1;

                const dotsContainer = document.createElement('div');
                dotsContainer.classList.add('dots');
                carousel.appendChild(dotsContainer);


                for (let index = 1; index <= totalSections; index++) {
                    const dot = document.createElement('div');
                    dot.classList.add('dot');
                    if (index === currentSection) {
                        dot.classList.add('active');
                    }
                    dot.addEventListener('click', function () {
                        currentSection = index;
                        updateCarousel();
                    });
                    dotsContainer.appendChild(dot);
                }

                prevButton.addEventListener('click', function () {
                    currentSection--;
                    if (currentSection < 1) {
                        currentSection = totalSections;
                    }
                    updateCarousel();
                });

                nextButton.addEventListener('click', function () {
                    currentSection++;
                    if (currentSection > totalSections) {
                        currentSection = 1;
                    }
                    updateCarousel();
                });

                carousel.addEventListener('touchstart', function (event) {
                    touchStartX = event.touches[0].clientX;
                }, { passive: true });


                carousel.addEventListener('touchend', function (event) {
                    touchEndX = event.changedTouches[0].clientX;
                    handleSwipe();
                });

                prevButton.style.display = 'none';

                function handleSwipe() {
                    if (touchEndX < touchStartX) {
                        currentSection++;
                        if (currentSection > totalSections) {
                            currentSection = 1;
                        }
                    } else if (touchEndX > touchStartX) {
                        currentSection--;
                        if (currentSection < 1) {
                            currentSection = totalSections;
                        }
                    }
                    updateCarousel();
                    touchStartX = 0;
                    touchEndX = 0;
                }

                function updateCarousel() {
                    if (window.innerWidth >= 380) {
                        const currentPosition = (currentSection - 1) * -itemWidth * visibleItems;
                        list.style.transform = `translateX(${currentPosition}px)`;
                        updateDots();
                        updateButtons();
                        updateButtonsVisibility();
                    }
                }

                function updateDots() {
                    const dots = dotsContainer.querySelectorAll('.dot');
                    dots.forEach(function (dot, index) {
                        if (index + 1 === currentSection) {
                            dot.classList.add('active');
                        } else {
                            dot.classList.remove('active');
                        }
                    });
                }

                function updateButtons() {
                    if (currentSection === 1) {
                        prevButton.style.display = 'none';
                    } else {
                        prevButton.style.display = 'flex';
                    }
                    if (currentSection === totalSections) {
                        nextButton.style.display = 'none';
                    } else {
                        nextButton.style.display = 'flex';
                    }
                }
                function updateButtonsVisibility() {
                    if (window.innerWidth <= 500) {
                        prevButton.style.display = 'none';
                        nextButton.style.display = 'none';
                    } else {
                        prevButton.style.display = 'flex';
                        nextButton.style.display = 'flex';
                    }
                    if (totalSections === 1) {
                        prevButton.style.display = 'none';
                        nextButton.style.display = 'none';
                        dotsContainer.style.display = 'none';
                    } else {
                        dotsContainer.style.display = 'flex';
                    }
                }
                const resizeObserver = new ResizeObserver(entries => {

                    for (const entry of entries) {
                        if (entry.target === document.body) {
                            updateButtonsVisibility();
                        }
                    }
                });


                resizeObserver.observe(document.body);
            });
        }

        setupCarousels();
    });

    const card_indiv_items = document.querySelectorAll('.sec-card-indiv');
    let currentIndex = 0;

    function showNextItem() {
        card_indiv_items[currentIndex].style.display = 'none';
        currentIndex = (currentIndex + 1) % card_indiv_items.length;
        card_indiv_items[currentIndex].style.display = 'block';
    }

    if (card_indiv_items.length > 0) {
        showNextItem();
    }


    if (card_indiv_items.length > 1) {
        setInterval(showNextItem, 10000);
    }
</script>


</body>

</html>
<?php $database->close(); ?>