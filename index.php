<?php
//declare(strict_types=1);
//strict mode
//ini_set('display_errors', "1");
//ini_set('display_startup_errors', "1");
//error_reporting(E_ALL);

//getting the input and fetch data from api and convert object into associative array
$pokemonApi = json_decode(file_get_contents('https://pokeapi.co/api/v2/pokemon/' . $_GET['search']), true);
$species = json_decode(file_get_contents($pokemonApi['species']['url']), true);
$evolveFrom = json_decode(file_get_contents($species['evolves_from_species']['url']), true);
$evolveTo = json_decode(file_get_contents($species['evolution_chain']['url']), true);

//check if the user enter pokemon name or id
function validate()
{
    $search = $_GET['search'];
    if (empty($search)) {
        echo 'Please enter a Pokemon name or ID';
    }
    return;
}

//get moves of the pokemon
$pokemonMoves = [];
$randomMoves = [];
foreach ($pokemonApi['moves'] as $move) {
    array_push($pokemonMoves, $pokemonApi['moves'][$move]['move']['name']);
}
$fourRandomMoves = array_rand($pokemonMoves, min(4, count($pokemonMoves)));
foreach ($fourRandomMoves as $moves) {
    array_push($randomMoves, $pokemonApi['moves'][$moves]['move']['name']);
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
    <H1>Pokédex</H1>
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
                <p class="name"><?php echo ucfirst($pokemonApi["name"]) ?></p>
                <img class="pokemonPic" src="<?php echo $pokemonApi["sprites"]["front_default"]; ?>" alt="pokemon">
                <p class="id">Pokemon ID: <?php echo $pokemonApi["id"]; ?></p>
            </div>
            <h2 id="leftbullets">• • •</h2>
        </div>
        <!-- search input -->
        <form method="get" action="" class="searchContent">
            <p class="label"><?php validate(); ?> </p>
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
                    <?php foreach ($randomMoves as $random) {
                        echo "<li>" . ucfirst($random) . "</li>";
                    } ?>
                </ul>
                <div class="description"></div>
                <div class="evolution">
                    <p> Previous evolution</p>
                    <?php if ($species['evolves_from_species'] !== null) {
                        echo "<p>" . ucfirst($species['evolves_from_species']['name']) . "</p>";
                        $preEvoSpecies = json_decode(file_get_contents($evolveFrom['varieties'][0]['pokemon']['url']), true);
                        echo '<img class="evoImage" src="' . $preEvoSpecies["sprites"]["front_default"] . '" alt="">';
                    } else {
                        echo '<p> No previous evolution found.</p>';
                    } ?>
                </div>
            </div>
            <h2>• • •</h2>
        </div>
    </div>
</div>
</body>
</html>