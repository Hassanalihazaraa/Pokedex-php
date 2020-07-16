<?php
//declare(strict_types=1);
//strict mode
ini_set('display_errors', "1");
ini_set('display_startup_errors', "1");
error_reporting(E_ALL);

//getting the input and fetch data from api and display the pokemon
if (isset($_GET['search']) && !empty('search')) {
    $pokemonApi = file_get_contents('https://pokeapi.co/api/v2/pokemon/' . $_GET['search']);
    $species = file_get_contents('https://pokeapi.co/api/v2/pokemon-species/' . $_GET['search']);
    $pokemonArray = json_decode($pokemonApi, true);
    $speciesArray = json_decode($species, true);
}
//get moves of the pokemon
$pokemonMoves = [];
for ($i = 0; $i < count($pokemonArray['moves']); $i++) {
    array_push($pokemonMoves, $pokemonArray['moves'][$i]['move']['name']);
}
//random moves
$fourMoves = array_rand($pokemonMoves, min(4, count($pokemonMoves)));
$randomMoves = [];
//push 4 move into array
//var_dump($fourMoves);
if ($fourMoves < 0) {
    array_push($randomMoves, $pokemonArray['moves'][0]['move']['name']);
    //var_dump($randomMoves);
} else {
    //foreach moves push names to array
    foreach ($fourMoves as $moves) {
        array_push($randomMoves, $pokemonArray['moves'][$moves]['move']['name']);
    }
}
//evolution
$previousEvo = file_get_contents($speciesArray['evolution_chain']['url']);
$evo = json_decode($previousEvo, true);
$evolutionNames = [];
var_dump($evo['chain']['is_baby'], $evo['chain']['species']['name']);
if ($evo['chain']['is_baby'] === true) {
    array_push($evolutionNames, $evo['chain']['species']['name']);
    /*if ($evo['chain']['evolves_to'][0]['evolves_to'][0]['species']['name'] !== null) {
        $evolutionName = file_get_contents('https://pokeapi.co/api/v2/pokemon/ ' . $_GET['search']);
        $evoName = json_decode($evolutionName, true);
        array_push($evolutionNames, $evoName['chain']['species']['name']);
        var_dump($evo['chain']['evolves_to'][0]['evolves_to'][0]['species']['name']);
    } else if ($evo['chain']['evolves_to'][0]['evolves_to'][0]['species']['name'] !== null) {
        array_push($evolutionNames, $evo['chain']['evolves_to'][0]['evolves_to'][0]['species']['name']);
    }*/
} else {
    array_push($evolutionNames, "No previous evolution found");
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
                <p class="name"><?php echo $pokemonArray["name"]; ?></p>
                <img class="pokemonPic" src="<?php echo $pokemonArray["sprites"]["front_default"]; ?>" alt="">
                <label class="id-label">ID:</label>
                <p class="id"><?php echo $pokemonArray["id"]; ?></p>
            </div>
            <h2 id="leftbullets">• • •</h2>
        </div>
        <!-- search input -->
        <form method="get" action="" class="searchContent">
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
                <ul class="moveList">
                    <?php echo implode('<br>', $randomMoves) ?>
                </ul>
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