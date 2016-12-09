<?php

namespace App\Crawlers;

class Backlog
{
    protected $space;

    protected $apikey;

    public function __construct($config)
    {
        $this->space = array_get($config, 'space');
        $this->apikey = array_get($config, 'apikey');
        $this->projectId = array_get($config, 'projectId');
    }

    public function handle()
    {
        $space = $this->space;
        $client = new \GuzzleHttp\Client(['base_uri' => "https://{$space}.backlog.jp"]);

        $request = $this->newRequest('/api/v2/issues', ['projectId' => [$this->projectId]]);
        $promise = $client->sendAsync($request)->then(function ($response) use($client, $space) {
            $issues = json_decode($response->getBody());
            foreach ($issues as $issue) {
                $task = \App\Task::firstOrNew([
                    'url' => "https://{$space}.backlog.jp/view/{$issue->issueKey}",
                ]);
                $task->title = $issue->summary;
                $task->save();
            }
        });
        $promise->wait();
    }

    private function newRequest($path, $query = [])
    {
        $query['apiKey'] = $this->apikey;
        $url = new \GuzzleHttp\Psr7\Uri($path.'?'.http_build_query($query));
        return new \GuzzleHttp\Psr7\Request('GET', $url);
    }
}