<?php
class AdminAuth extends \Slim\Middleware
{
    public function call()
    {
        $app = $this->app;
        $req = $app->request;
        $resourceUri = $req->getResourceUri();
        if(strncasecmp($resourceUri, '/admin', 6) == 0) {
            $cookie = $app->getCookie('admin');
            if(!$cookie || !Admin::where('username', $cookie)->first()){}
                //return $app->response->redirect('/login');
        }
        $this->next->call();
    }
}