<?php

namespace App\Units\Blog\Http\Routes;

use App\Support\Http\Routing\RouteFile;

class Web extends RouteFile
{

    /**
     * @return mixed
     */
    protected function routes()
    {
        $this->router->group(['domain' => env('APP_DOMAIN'), 'middleware' => ['web', 'blog']], function () {
            $this->indexRoutes();
            $this->articlesRoutes();
            $this->projectRoutes();
            $this->newsRoutes();
            $this->aboutMeRoutes();
            $this->contactRoutes();
        });
    }

    protected function indexRoutes()
    {
        $this->router->get('', ['as' => 'blog.index', 'uses' => 'IndexController@index']);

        $this->router->get('/error', ['as' => 'blog.error', function () {
            return view('blog::error');
        }]);
    }

    protected function articlesRoutes()
    {
        $this->router->get('/artigos', ['as' => 'blog.articles.index', 'uses' => 'ArticlesController@index']);
        $this->router->get('/artigos/search/{tag}', ['as' => 'blog.articles.searchByTag', 'uses' => 'ArticlesController@searchByTag']);
        $this->router->post('/artigos/search', ['as' => 'blog.articles.searchByInput', 'uses' => 'ArticlesController@searchByInput']);
        $this->router->get('/artigos/{article}', ['as' => 'blog.articles.show', 'uses' => 'ArticlesController@show']);
    }

    protected function projectRoutes()
    {
        $this->router->get('/o-projeto', ['as' => 'blog.project.index', 'uses' => 'ProjectController@project']);
    }

    protected function newsRoutes()
    {
        $this->router->get('/noticias', ['as' => 'blog.news.index', 'uses' => 'NewsController@index']);
        $this->router->get('/noticias/{news}', ['as' => 'blog.news.show', 'uses' => 'NewsController@show']);
    }

    protected function aboutMeRoutes()
    {
        $this->router->get('/sobre-mim', ['as' => 'blog.about-me.index', 'uses' => 'AboutMeController@about']);
    }

    protected function contactRoutes()
    {
        $this->router->get('/contato', ['as' => 'blog.contact.index', 'uses' => 'ContactController@index']);
        $this->router->post('/contato', ['as' => 'blog.contact.send', 'uses' => 'ContactController@send']);
    }
}