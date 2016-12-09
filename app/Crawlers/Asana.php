<?php

namespace App\Crawlers;

class Asana
{
    protected $token;

    public function __construct($config)
    {
        $this->token = array_get($config, 'token');
        $this->project = array_get($config, 'project');
    }

    public function handle()
    {
        $project = $this->project;
        $client = new \GuzzleHttp\Client(['base_uri' => 'https://app.asana.com']);

        $request = $this->newRequest('GET', '/api/1.0/tasks', ['project' => $project]);
        $promise = $client->sendAsync($request)->then(function ($response) use($client, $project) {
            $tasks = json_decode($response->getBody());
            foreach ($tasks->data as $item) {
                $task = \App\Task::firstOrNew([
                    'url' => "https://app.asana.com/0/{$project}/{$item->id}",
                ]);
                $task->title = $item->name;
                $task->save();
            }
        });
        $promise->wait();
    }

    private function newRequest($method, $path, $query = [])
    {
        $url = new \GuzzleHttp\Psr7\Uri($path.'?'.http_build_query($query));
        return new \GuzzleHttp\Psr7\Request($method, $url, ['Authorization' => 'Bearer '.$this->token]);
    }
}