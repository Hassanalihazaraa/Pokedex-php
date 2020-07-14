<!-- php code -->
<?php
if (isset($_GET['search']) && !empty('search')) {
    $pokemonApi = file_get_contents('https://pokeapi.co/api/v2/pokemon/' . $_GET['search']);
    $json = json_decode($pokemonApi, true);
    var_dump($json);
}
?>


<!-- html -->
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="index.css">
    <title>Pokedex</title>
</head>
<body>
<header>
    <H1>Pokemon Pokédex</H1>
</header>
<div class="aParent">
    <!-- First screen -->
    <div class="firstScreen">
        <!-- Pokemon logo -->
        <div class="pokemonLogo">
            <img src="assets/poke_logo.png" alt="Pokemon Logo" class="pokeLogo">
        </div>
        <div class="pokeFrame" id="leftFrame">
            <div class="pokemonScreen">
                <p class="name"><?php echo $json["name"]; ?></p>
                <img class="pokemonPic" src="<?php echo $json["sprites"]["front_default"]; ?>" alt="">
                <label class="id-label">ID:</label>
                <p class="id"><?php echo $json["id"]; ?></p>
            </div>
            <h2 id="leftbullets">• • •</h2>
        </div>
        <!-- search input -->
        <form method="get" action="index.php" class="searchContent">
            <label for="searchInput"></label>
            <input type="text" class="searchInput" id="searchInput" name="search" placeholder="Pokemon name">
            <input type="submit" class="searchButton" value="Go">
        </form>
    </div>
    <!-- Line in the middle -->
    <div class="hinges"></div>
    <!-- screen screen -->
    <div class="secondScreen">
        <div class="leds">
            <div class="led-box">
                <div class="led-green"></div>
            </div>

            <div class="led-box">
                <div class="led-yellow"></div>
            </div>
        </div>
        <div class="pokeFrame" id="rightframe">
            <div class="pokemonScreen">
                <ul class="moveList"></ul>
                <div class="description"></div>
                <div class="evolution">
                    <img class="evoImage" src="" alt="">
                    <p class="evoName"></p>
                </div>
            </div>
            <h2>• • •</h2>
        </div>
        <!-- Previous and Next buttons -->
        <div class="buttons">
            <button class="previous"><</button>
            <button class="next">></button>
        </div>
    </div>
</div>
</body>
</html>