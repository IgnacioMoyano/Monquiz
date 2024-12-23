<?php
date_default_timezone_set('America/Argentina/Buenos_Aires');

include_once("helper/MysqlDatabase.php");
include_once("helper/MysqlObjectDatabase.php");
include_once("helper/IncludeFilePresenter.php");
include_once("helper/Router.php");
include_once("helper/MustachePresenter.php");
include_once("helper/EmailSender.php");


include_once("controller/PerfilController.php");
include_once("model/PerfilModel.php");

include_once("controller/EditorController.php");
include_once("model/EditorModel.php");

include_once("controller/UsuarioController.php");
include_once("model/UsuarioModel.php");

include_once("controller/PartidaController.php");
include_once("model/PartidaModel.php");

include_once("controller/LobbyController.php");
include_once("model/LobbyModel.php");

include_once("controller/RankingController.php");
include_once("model/RankingModel.php");

include_once('vendor/mustache/src/Mustache/Autoloader.php');
include_once('vendor/phpqrcode/qrlib.php');
include_once ('vendor/fpdf/fpdf.php');

include_once('model/AdministradorModel.php');
include_once('controller/Administradorcontroller.php');

class Configuration
{
    public function __construct()
    {
    }

    public function getEditorController()
    {
        return new EditorController($this->getEditorModel(), $this->getPresenter());
    }

    public function getPokedexController()
    {
        return new PokedexController($this->getPokedexModel(), $this->getPresenter());
    }

    public function getPartidaController()
    {
        return new PartidaController($this->getPartidaModel(), $this->getPresenter());
    }

    public function getUsuarioController()
    {
        return new UsuarioController($this->getUsuarioModel(), $this->getPresenter());
    }

    public function getPerfilController()
    {
        return new PerfilController($this->getPerfilModel(), $this->getPresenter());
    }

    public function getLobbyController()
    {
        return new LobbyController($this->getLobbyModel(), $this->getPresenter());
    }

    public function getRankingController()
    {
        return new RankingController($this->getRankingModel(), $this->getPresenter());
    }

    public function getAdministradorController()
    {
        return new AdministradorController($this->getAdministradorModel(), $this->getPresenter());
    }

    public function getEditorModel()
    {
        return new EditorModel($this->getDatabase());
    }

    private function getPerfilModel()
    {
        return new PerfilModel($this->getDatabase());
    }

    private function getPartidaModel()
    {
        return new PartidaModel($this->getDatabase());
    }

    private function getLobbyModel()
    {
        return new LobbyModel($this->getDatabase());
    }

    private function getRankingModel()
    {
        return new RankingModel($this->getDatabase());
    }


    private function getPokedexModel()
    {
        return new PokedexModel($this->getDatabase());
    }

    private function getAdministradorModel()
    {
        return new AdministradorModel($this->getDatabase());
    }

    private function getPresenter()
    {
        return new MustachePresenter("./view");
    }


    private function getDatabase()
    {
        $config = parse_ini_file('configuration/config.ini');
        return new MysqlObjectDatabase(
            $config['host'],
            $config['port'],
            $config['user'],
            $config['password'],
            $config["database"]
        );
    }

    public function getRouter()
    {
        return new Router($this, "getUsuarioController", "login");
    }

    private function getUsuarioModel()
    {
        return new UsuarioModel($this->getDatabase());
    }


}