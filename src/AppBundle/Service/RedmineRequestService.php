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
    /**
     * @var \Redmine\Client
     */
    private $client;

    /**
     * RedmineRequestService constructor.
     *
     * @param \Redmine\Client $client
     */
    public function __construct(\Redmine\Client $client)
    {
        $this->client = $client;
    }

    /**
     * Returns list of projects.
     *
     * @return array
     */
    public function getProjects()
    {
        $projects = $this->client->project->all();

        return $projects;
    }

    /**
     * Returns list of projects in array format.
     * Prepared for form select control.
     *
     * @return array|bool
     */
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

    /**
     * Returns project details by project identifier.
     *
     * @param int $id
     * @return array
     */
    public function getProjectDetails($id)
    {
        $projectID = (int)$id;
        $details = $this->client->project->show($projectID);

        return $details;
    }

    /**
     * Returns list of issues by project identifier of false if no data.
     *
     * @param int $id
     * @return array|bool
     */
    public function getIssuesByProjectId($id)
    {
        $projectID = (int)$id;

        $issues = $this->client->issue->all([
            'project_id' => $projectID
        ]);

        if (!empty($issues) && isset($issues['issues'])) {
            return $issues['issues'];
        }

        return false;

    }

    /**
     * Returns issue details by issue identifier or false if no data.
     *
     * @param int $id
     * @return array|bool
     */
    public function getIssueDetails($id)
    {
        $issueID = (int)$id;

        $details = $this->client->issue->show($issueID);

        if (!empty($details) && isset($details['issue'])) {
            return $details['issue'];
        }

        return false;
    }

    public function setIssueTime($data)
    {
        if (empty($data) || !is_array($data)) {
            return false;
        }

        $result = $this->client->time_entry->create([
            'issue_id'    => $data['issue_id'],
            'spent_on'    => $data['date']->format('Y-m-d'),
            'hours'       => $data['hours'],
            'activity_id' => $data['activity'],
            'comments'    => $data['comment']
        ]);

        return $result;
    }
}