<?php
/**
 * Created by PhpStorm.
 * User: texas
 * Date: 3/21/18
 * Time: 9:54 PM
 */

namespace AppBundle\Service;


class RedmineRequestService
{
    private $client;

    public function __construct(\Redmine\Client $client)
    {
        $this->client = $client;
    }

    public function getProjects()
    {
        $projects = $this->client->project->all();
        dump($projects);
        return $projects;
    }

    public function getProjectsArray()
    {
        $list = [];
        $projects = $this->getProjects();

        if (empty($projects)) {
            return false;
        }

        foreach ($projects['projects'] as $project) {
            $list[$project['name']] = $project['id'];
        }

        return $list;
    }

    public function getProjectDetails($id)
    {
        $projectID = (int)$id;
        $details = $this->client->project->show($projectID);

        return $details;
    }
}