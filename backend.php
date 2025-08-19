<?php
    // Tipo de resposta = JSON
    header('Content-Type: application/json');
    header('Acess-Control-Allow-Origin: *');
    header('Acess-Control-Allow-Methods: GET, POST, OPTIONS');
    header('Acess-Control-Allow-Headers: Content-Type, Authorization');

    // Resposta padrão do backend: 
    $response = array(
        "success" => false,
        "name" => "Pokémon não encontrado",
        "id" => "",
        "type" => "",
        "description" => "Tente outro nome.",
        "image" => "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/0.png"
    );

    if(!empty($_GET["pokemon_name"])){
        $searchName = strtolower(trim($_GET["pokemon_name"]));

        // Coloca o nome no fim da URL, definindo assim a rota que vamos pegar as informações
        $url = "https://pokeapi.co/api/v2/pokemon/" . $searchName;

        // Curl é usado para fazer a conexão HTTP
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $apiResponse = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);
 
    // Se for bem sucedido e ter resposta (code 200), pega as informações json e decoda
    if($httpCode == 200 && $apiResponse){
        $pokemonData = json_decode($apiResponse, true);

        $pokemonName = ucfirst($pokemonData['name']);
        $pokemonId = $pokemonData['id'];
        $pokemonType = ucfirst($pokemonData['types'][0]['type']['name']);
        $pokemonImage = $pokemonData['sprites']['other']['official-artwork']['front_default'];
        $speciesUrl = $pokemonData['species']['url'];

        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $speciesUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $speciesResponse = curl_exec($ch);

        curl_close($ch);

        $speciesData = json_decode($speciesResponse, true);

        $description = "Descrição não encontrada";

        foreach($speciesData['flavor_text_entries'] as $entry){
            if ($entry['language']['name'] == 'en'){
                $description = $entry['flavor_text'];
                break;
            }
        }

        $pokemonDescription = str_replace(array("\n", "\f"), " ", $description);
        $response = array(
            "success" => true,
            "name" => $pokemonName,
            "id" => $pokemonId,
            "type" => $pokemonType,
            "description" => $pokemonDescription,
            "image" => $pokemonImage
        );

    } else {
        $response['description'] = "Erro HTTP: $httpCode";
    }
    }

    echo json_encode($response);
?>

