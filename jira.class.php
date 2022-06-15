<?php

require_once 'vendor/autoload.php';

use Dotenv\Dotenv;

class Jira {

    protected $headers;

    function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__);
        $dotenv->safeLoad();

        $this->headers = [
            'Accept' => 'application/json'
        ];
    }

    public function getBoards()
    {
        $response = $this->query( 'board' );
        return $response->body;
    }

    public function getSprints( $boardId )
    {
        $response = $this->query( "board/{$boardId}/sprint" );
        return $response->body;
    }

    public function getSprintIssues( $boardId, $sprintId )
    {
        $response = $this->query( "board/{$boardId}/sprint/{$sprintId}/issue" );
        return $response->body;
    }

    public function issueUrl( $key )
    {
        return  trim( $_ENV['JIRA_DOMAIN'], "/" ) . "/browse/" . $key;
    }

    private function query( $path )
    {
        $this->authenticate();

        $response = Unirest\Request::get(
            trim( $_ENV['JIRA_DOMAIN'], "/" ) . '/rest/agile/1.0/'.$path,
            $this->headers
        );

        return $response;
    }

    private function authenticate()
    {
        Unirest\Request::auth($_ENV['JIRA_USER'], $_ENV['JIRA_TOKEN']);
    }
}