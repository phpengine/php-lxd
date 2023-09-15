<?php

namespace Opensaucesystems\Lxd\Endpoint\Instance;

use Opensaucesystems\Lxd\Endpoint\AbstractEndpoint;

class Logs extends AbstractEndpoint
{
    private $endpoint;

    protected function getEndpoint()
    {
        return $this->endpoint;
    }

    public function setEndpoint(string $endpoint)
    {
        $this->endpoint = $endpoint;
    }

    /**
     * List of logs for a container
     *
     * @param  string $name Name of container
     * @return array
     */
    public function all($name)
    {
        $logs = [];
        $config = [
            "project"=>$this->client->getProject()
        ];

        foreach ($this->get($this->getEndpoint().$name.'/logs/', $config) as $log) {
            $logs[] = str_replace(
                '/'.$this->client->getApiVersion().$this->getEndpoint().$name.'/logs/',
                '',
                $log
            );
        }

        return $logs;
    }

    /**
     * Get the contents of a particular log file
     *
     * @param string $name  Name of container
     * @param string $log   Name of log
     * @return object
     */
    public function read($name, $log)
    {
        $config = [
            "project"=>$this->client->getProject()
        ];
        return $this->get($this->getEndpoint().$name.'/logs/'.$log, $config);
    }

    /**
     * Remove a particular log file
     *
     * @param string $name  Name of container
     * @param string $log   Name of log
     * @return object
     */
    public function remove($name, $log)
    {
        $config = [
            "project"=>$this->client->getProject()
        ];
        return $this->delete($this->getEndpoint().$name.'/logs/'.$log, $config);
    }
}
