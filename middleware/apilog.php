<?php
class ApiLog extends \Slim\Middleware
{
    public function call()
    {
        $app = $this->app;
        $req = $app->request;
        $resourceUri = $req->getResourceUri();
        if(strncasecmp($resourceUri, '/api', 4) == 0) {
            Log::record('api', $resourceUri);
        }
        $this->next->call();
    }
}