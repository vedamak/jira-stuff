<?php

require_once "jira.class.php";
require_once "bamboo.class.php";
require_once "db.class.php";

$jira = new Jira;
$bamboo = new Bamboo;
$db = new DB("./storage/jira.db");

if ( function_exists( trim( $_GET['action'] ) ) ) 
{
    call_user_func( trim( $_GET['action'] ) );
}

function addDbTimeOff()
{
    global $db;

    $employeeName = @$_POST['name'];
    $date = @$_POST['date'];
    $time = @$_POST['days'];

    if( !empty($employeeName) && !empty($date) && !empty($time) && $table = $db->getTable("time_off"))
    {
        $result = $table->addRow([
            "employeeName" => $employeeName,
            "offDate" => $date,
            "daysOff" => $time
        ]);

        var_dump($result);
    }

    return true;
}

function dbTimeOff()
{
    global $db;
}

function bambooWhosOut()
{
    global $bamboo;

    header( 'Content-Type: application/json' );
    exit( $bamboo->whosOut() );
}

function getBoards()
{
    global $jira;

    $boards = $jira->getBoards();

    $output = [];

    if( !empty( $boards->values[0]->location->name ) )
    {
        foreach($boards->values as $board)
        {
            $output[] = [
                'id' => $board->id,
                'displayName' => $board->location->displayName,
                'projectName' => $board->location->projectName,
                'projectKey' => $board->location->projectKey,
                'projectTypeKey' => $board->location->projectTypeKey,
                'name' => $board->location->name,
            ];
        }
    }

    return output( $output );
}

function getSprints()
{
    global $jira;

    $output = [];

    if( empty( $_GET['boardId'] ) ) {

        return output( $output );
    }

    $sprints = $jira->getSprints( (int)$_GET['boardId'] );

    

    if( !empty( $sprints->values[0]->name ) )
    {
        $output = $sprints->values;
    }

    return output( $output );
}

function getSprintIssues()
{
    global $jira;

    $output = [];

    $boardId = (!empty($_GET['boardId']) ? (int)$_GET['boardId'] : false);
    $sprintId = (!empty($_GET['sprintId']) ? (int)$_GET['sprintId'] : false);

    if( ! $boardId || ! $sprintId )
    {
        return output( $output );
    }

    $issues = $jira->getSprintIssues( $boardId, $sprintId );

    if( !empty( $issues->issues[0]->id ) )
    {
        foreach($issues->issues as $issue)
        {
            $output[] = [
                'key' => $issue->key,
                'summary' => $issue->fields->summary,
                'created_at' => $issue->fields->created,
                'priority' => $issue->fields->priority->name,
                'priority_icon' => $issue->fields->priority->iconUrl,
                'time_estimate' => $issue->fields->timeestimate,
                'assignee' => !empty( $issue->fields->assignee->displayName ) ? $issue->fields->assignee->displayName : '-',
                'status' => $issue->fields->status->name,
                'reporter' => $issue->fields->reporter->displayName,
                'due_date' => !empty( $issue->fields->duedate ) ? date( 'j M Y', strtotime($issue->fields->duedate)) : '-',
                'labels' => $issue->fields->labels,
                'url' => $jira->issueUrl( $issue->key )
            ];
        }
    }

    return output( $output );
}

function output($data)
{
    header( 'Content-Type: application/json' );
    echo exit( json_encode( $data ) );
}