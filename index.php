<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/eb31cd41f7.js" crossorigin="anonymous"></script>
    <title>Reproductor De M&uacute;sica</title>
</head>

<body>
    <div>
        <div><img class="dance" src="imagenes/Girl.svg" alt=""></div>
        <div><img class="disco" src="imagenes/disco.svg" alt=""></div>
    </div>
    <div>
        <div><img class="ballDisco" src="imagenes/ballDisco.svg" alt=""></div>
        <audio id="reproductor">
            <source src="audios/Get Lucky.mp3">
        </audio>
        <div class="media-controls">
            <div id="titulo"></div>
            <div class="media-buttons">
                <button id="bajarVolumen" class="rewind-button media-button" onclick="document.getElementById('reproductor').volume-=0.1">
                    <i class="fa-solid fa-volume-low button-icons"></i>
                    <span class="button-text milli"></span>
                </button>
                <button id="reproducir" class="play-button media-button">
                    <i class="fa-solid fa-play button-icons"></i>
                    <span class="button-text milli"></span>
                </button>
                <button id="pausar" style="display: none;" class="play-button media-button">
                    <i class="fa-solid fa-pause button-icons"></i>
                    <span class="button-text milli"></span>
                </button>
                <button id="subirVolumen" class="fast-forward-button media-button" onclick="document.getElementById('reproductor').volume+=0.1">
                    <i class="fa-solid fa-volume-high button-icons"></i>
                    <span class="button-text milli"></span>
                </button>
            </div>
            <div class="media-progress">
                <div class="progress-bar-wrapper progress">
                    <div id="progresoActual" class="progress-bar">
                    </div>
                </div>
                <div id="tiempoActual" class="progress-time-current milli"></div>
                <div id="duracionTotal" class="progress-time-total milli"></div>
            </div>
        </div>
        <div class="lista">
            <form action="">
                <div>
                    <select name="cancion" id="cancion" size="10">
                        <?php
                        foreach (scandir('audios') as $cancion) {
                            if ($cancion <> '.' and $cancion <> '..') {
                                echo '<option value="' . chop($cancion, ".mp3") . '">' . chop($cancion, ".mp3") . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
            </form>
        </div>
    </div>
    <div>
        <div><img class="dance" src="imagenes/Boy.svg" alt=""></div>
        <div><img class="disco" src="imagenes/disco.svg" alt=""></div>
    </div>
</body>

</html>
<script>
    $(document).ready(function() {

        var progresoInicial = 1;
        var reproductor = $("#reproductor").get(0);
        var cancion = $("#cancion");
        var reproducir = $("#reproducir");
        var pausar = $("#pausar");

        $("#cancion").on("change", cargarCancion);
        $("#reproductor").on("timeupdate", actualizarProgreso);
        $("#reproducir").on("click", play);
        $("#pausar").on("click", pause);

        function cargarCancion() {
            $("#reproductor").html('<source src="audios/' + cancion.val() + '.mp3">');
            reproducir.show();
            pausar.hide();
            reproductor.load();
            $("#progresoActual").css("width", "1%");            
            $("#titulo").html("<b>" + cancion.val() + "</b>");
            actualizarProgreso();
        };

        function actualizarProgreso() {
            $("#tiempoActual").html(formatTime(reproductor.currentTime));
            if (reproductor.currentTime >= (reproductor.duration / 100) * progresoInicial) {
                progresoInicial++;
                $("#progresoActual").css("width", progresoInicial + "%");
                if (reproductor.currentTime >= reproductor.duration) {
                    pause();
                }
            }
        };

        function play() {
            $("#duracionTotal").html(formatTime(reproductor.duration));
            $(".disco").css("animation", "rotacion 1s infinite linear");
            $(".ballDisco").css("animation", "bajarBola 10s linear 1 forwards");            
            $(".dance").css("animation", "bailar 0.5s infinite ease-in-out alternate");
            if (reproductor.currentTime >= reproductor.duration) {
                reproductor.currentTime = 0;
                $("#progresoActual").css("width", "1%");
            }
            reproductor.play();
            reproducir.hide();
            pausar.show();
        };

        function pause() {
            $(".disco").css("animation-play-state", "paused");
            $(".dance").css("animation-play-state", "paused");
            reproductor.pause();
            reproducir.show();
            pausar.hide();
        };

        function formatTime(seconds) {
            minutes = Math.floor(seconds / 60);
            minutes = (minutes >= 10) ? minutes : "0" + minutes;
            seconds = Math.floor(seconds % 60);
            seconds = (seconds >= 10) ? seconds : "0" + seconds;
            return minutes + ":" + seconds;
        };
    });
</script>