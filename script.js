document.getElementById('search-form').addEventListener('submit', function(event){
    event.preventDefault() // Previne que a página recarregue após o submit
    
    const form = event.target;
    const pokemonName = form.elements['pokemon_name'].value;

    // Variáveis de um pokémon
    const pokemonImage = document.getElementById('pokemon-image');
    const pokemonNameElement = document.getElementById('pokemon-name');
    const pokemonIdElement = document.getElementById('pokemon-id');
    const pokemonTypeElement = document.getElementById('pokemon-type');
    const pokemonDescriptionElement = document.getElementsById('pokemon-description');

    // Setta as variáveis por padrão assim
    pokemonNameElement.textContent = "Buscando...";
    pokemonIdElement.textContent = "";
    pokemonTypeElement.textContent = "";
    pokemonDescriptionElement.textContent = "";
    pokemonImage.src = "";
    
})