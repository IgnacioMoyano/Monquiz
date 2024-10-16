<?php

class PokedexModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function getPokemons()
    {
        $pokemons = $this->database->query("SELECT * FROM pokemon order by id_pokemon");

        return $this->trasnformImagePaths($pokemons);
    }

    public function filter($filter)
    {
        $sql = "SELECT * 
                FROM pokemon 
                WHERE nombre LIKE '%" . $filter . "%'
                OR id_pokemon  LIKE '" . $filter . "'
                OR tipo  LIKE '%" . $filter . "%'
                order by id_pokemon";

        $pokemons = $this->database->query($sql);

        if ( sizeof($pokemons) == 0 ) {
            $pokemons=  $this->getPokemons();
            $message = "No results found for $filter";
        }

        $data["pokemons"] = $this->trasnformImagePaths($pokemons);
        $data["message"] = $message;

        return $data;
    }

    public function trasnformImagePaths($pokemons){
        foreach ($pokemons as $key => $pokemon) {
            $pokemons[$key]['tipo'] = "/public/images/types/" . $pokemons[$key]['tipo'];
            $pokemons[$key]['imagen'] = "/public/images/pokemon/" . $pokemons[$key]['imagen'];
        }
        return $pokemons;
    }

    public function delete()
    {
        $sql = "DELETE FROM pokemon WHERE id = " . $_GET['id'];
        $this->database->execute($sql);
    }

    public function add($id_pokemon, $nombre, $imagen, $tipo)
    {
        $sql = "INSERT INTO pokemon (id_pokemon, nombre, imagen, tipo) VALUES ('" . $id_pokemon . "', '" . $nombre . "', '" . $imagen . "', '" . $tipo . "');";
        $this->database->execute($sql);
    }

    public function getPokemon($id){
        $sql = "SELECT * FROM pokemon WHERE id = " . $id;
        return $this->database->query($sql);
    }
}