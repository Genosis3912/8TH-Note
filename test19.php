<html>
    <head>
<style>
    
    .card-slider {
            width: 80%;
            margin: 40px auto;
            display: flex;
            flex-wrap: nowrap;
            overflow-x: auto;
            cursor: grab;
        }


        .card {
            width: 250px;
            margin: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 10px 10px 0 0;
        }

        .card.song-info {
            padding: 20px;
        }

        .card.song-info h1 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .card.song-info p {
            font-size: 14px;
            color: #666;
        }

        .card.audio-controls {
            padding: 20px;
        }

        .card.audio-controls button {
            background-color: #333;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }

        .card.audio-controls button:hover {
            background-color: #444;
        }

</style>
<script>
         const cardSlider = document.getElementById('card-slider');
    let cardWidth = 250; // adjust this value to match your card width
    let cardMargin = 20; // adjust this value to match your card margin
    let cardsPerView = 3; // adjust this value to match the number of cards you want to display at once

    function moveCards(direction) {
        let scrollLeft = cardSlider.scrollLeft;
        let newScrollLeft = scrollLeft + (direction * (cardWidth + cardMargin));
        cardSlider.scrollLeft = newScrollLeft;
    }
    </script>
    </head>
    <body>
<section>
        <div class="card-slider" id="card-slider">
            <?php
            $sql = "SELECT id, file_path, audio_name, play_count, artists FROM audios ORDER BY RAND() LIMIT 6";
            $result = mysqli_query($con, $sql);
            $audios = mysqli_fetch_all($result, MYSQLI_ASSOC);
            foreach ($audios as $audio) {
                $songloc = basename($audio['file_path']);
                $songName = pathinfo($songloc, PATHINFO_FILENAME);
                $playCount = $audio['play_count'];
            ?>
                <div class="card">
                    <img src="https://via.placeholder.com/250x150" alt="<?php echo $songName; ?>">
                    <div class="song-info">
                        <h1 id="song-name"><?php echo $songName; ?></h1>
                        <p>Artist: <?php echo $audio['artists']; ?></p>
                        <p>Streams: <?php echo $playCount; ?></p>
                    </div>
                    <div class="audio-controls">
                        <audio id="audio-<?php echo $songloc; ?>" onplay="updatePlayCount('<?php echo $songloc; ?>')" src="<?php echo $audio['file_path']; ?>" type="audio/mpeg">
                            Your browser does not support the audio element.
                        </audio>
                        <button id="play-pause-button-<?php echo $songloc; ?>" class="control-button">
                            <i id="play-pause-icon-<?php echo $songloc; ?>" class="fas fa-play"></i>
                        </button>
                        <input type="range" id="progress-bar-<?php echo $songloc; ?>" value="0">
                        <div id="volume-container-<?php echo $songloc; ?>">
                            <div id="volume-slider-<?php echo $songloc; ?>" class="volume-slider">
                                <input type="range" id="volume-control-<?php echo $songloc; ?>" min="0" max="1" step="0.1" value="1" orient="vertical">
                            </div>
                            <button id="volume-button-<?php echo $songloc; ?>" class="control-button">
                                <i class="fas fa-volume-up"></i>
                            </button>
                        </div>
                        <button id="download-button-<?php echo $songloc; ?>" class="control-button">
                            <i class="fas fa-download"></i>
                        </button>
                    </div>
                </div>
            <?php
            }
            ?>

        </div>
        <div class="nav-buttons">
    <button id="prev-button" onclick="moveCards(-1)"><i class="fas fa-chevron-left"></i></button>
    <button id="next-button" onclick="moveCards(1)"><i class="fas fa-chevron-right"></i></button>
</div>
    </section>
    </body>
</html>