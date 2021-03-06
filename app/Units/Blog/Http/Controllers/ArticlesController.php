<?php

namespace App\Units\Blog\Http\Controllers;

use App\Domains\Articles\Repositories\ArticlesRepository;
use App\Domains\Tags\Repositories\TagsRepository;
use App\Support\Http\Controllers\Controller;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    /**
     * @var ArticlesRepository
     */
    private $articlesRepository;
    /**
     * @var TagsRepository
     */
    private $tagsRepository;

    /**
     * IndexController constructor.
     * @param ArticlesRepository $articlesRepository
     * @param TagsRepository $tagsRepository
     */
    public function __construct(ArticlesRepository $articlesRepository, TagsRepository $tagsRepository)
    {
        $this->articlesRepository = $articlesRepository;
        $this->tagsRepository = $tagsRepository;
    }

    public function index()
    {
        SEOMeta::setTitle('Artigos');
        SEOMeta::setDescription('Artigos sobre Internet das Coisas');
        SEOMeta::setCanonical('https://douglaszuqueto.com/artigos');

        OpenGraph::setTitle('Artigos');
        OpenGraph::setDescription('Artigos sobre Internet das Coisas');
        OpenGraph::setUrl('https://douglaszuqueto.com/artigos');
        OpenGraph::addProperty('type', 'website');
        OpenGraph::addImage('https://douglaszuqueto.com/images/identidade-visual/social-share-default.png');

        TwitterCard::addValue('card', 'summary');
        TwitterCard::setTitle('Artigos');
        TwitterCard::setDescription('Artigos sobre Internet das Coisas');
        TwitterCard::setSite('https://douglaszuqueto.com/artigos');
        TwitterCard::setUrl('https://douglaszuqueto.com/artigos');
        TwitterCard::addValue('image', 'https://douglaszuqueto.com/images/identidade-visual/social-share-default.png');

        $articles = $this->articlesRepository->scopeQuery(function ($query) {
            return $query->where('state', '=', 3)->orderBy('created_at', 'desc');
        })->all();

        $tags = $this->tagsRepository->findWhere(['state' => 1]);

        return $this->view('blog::articles.index', [
            'articles' => $articles,
            'tags' => $tags,
        ]);
    }

    public function searchByTag($tag)
    {
        SEOMeta::setTitle('Busca por ' . $tag);
        SEOMeta::setDescription('Resultados da busca filtrados pela tag ' . $tag);
        SEOMeta::setCanonical('https://douglaszuqueto.com/artigos/search/' . $tag);

        OpenGraph::setTitle('Busca por ' . $tag);
        OpenGraph::setDescription('Resultados da busca filtrados pela tag ' . $tag);
        OpenGraph::setUrl('https://douglaszuqueto.com/artigos/search/' . $tag);
        OpenGraph::addProperty('type', 'website');
        OpenGraph::addImage('https://douglaszuqueto.com/images/identidade-visual/social-share-default.png');

        TwitterCard::addValue('card', 'summary');
        TwitterCard::setTitle('Busca por ' . $tag);
        TwitterCard::setDescription('Resultados da busca filtrados pela tag ' . $tag);
        TwitterCard::setSite('https://douglaszuqueto.com/artigos/search/' . $tag);
        TwitterCard::setUrl('https://douglaszuqueto.com/artigos/search/' . $tag);
        TwitterCard::addValue('image', 'https://douglaszuqueto.com/images/identidade-visual/social-share-default.png');

        $articles = $this->articlesRepository->scopeQuery(function ($query) use ($tag) {
            return $query
                ->where('state', '=', 3)
                ->orderBy('created_at', 'desc')
                ->whereHas('tags', function ($query) use ($tag) {
                    $query->where('tag', '=', $tag);
                });
        })->all();

        $tags = $this->tagsRepository->findWhere(['state' => 1]);

        return $this->view('blog::articles.index', [
            'articles' => $articles,
            'tags' => $tags,
        ]);
    }

    public function searchByInput(Request $request)
    {
        $filter = $request->get('search');

        SEOMeta::setTitle('Busca por ' . $filter);
        SEOMeta::setDescription('Resultados da busca filtrados por ' . $filter);
        SEOMeta::setCanonical('https://douglaszuqueto.com/artigos/search/' . $filter);

        OpenGraph::setTitle('Busca por ' . $filter);
        OpenGraph::setDescription('Resultados da busca filtrados por ' . $filter);
        OpenGraph::setUrl('https://douglaszuqueto.com/artigos/search/' . $filter);
        OpenGraph::addProperty('type', 'website');
        OpenGraph::addImage('https://douglaszuqueto.com/images/identidade-visual/social-share-default.png');

        TwitterCard::addValue('card', 'summary');
        TwitterCard::setTitle('Busca por ' . $filter);
        TwitterCard::setDescription('Resultados da busca filtrados por ' . $filter);
        TwitterCard::setSite('https://douglaszuqueto.com/artigos/search/' . $filter);
        TwitterCard::setUrl('https://douglaszuqueto.com/artigos/search/' . $filter);
        TwitterCard::addValue('image', 'https://douglaszuqueto.com/images/identidade-visual/social-share-default.png');

        $articles = $this->articlesRepository->scopeQuery(function ($query) use ($filter) {
            return $query
                ->where('state', '=', 3)
                ->orderBy('created_at', 'desc')
                ->where('title', 'LIKE', '%' . $filter . '%')
                ->OrWhere('subtitle', 'LIKE', '%' . $filter . '%')
                ->OrWhere('text', 'LIKE', '%' . $filter . '%');
        })->all();

        $tags = $this->tagsRepository->findWhere(['state' => 1]);

        return $this->view('blog::articles.index', [
            'articles' => $articles,
            'tags' => $tags,
        ]);
    }

    public function show($article)
    {
        $url = 'https://' . env('APP_DOMAIN') . '/artigos/' . $article;
        $article = $this->articlesRepository->findWhere(['url' => $url])->first();

        if (!$article) {
            return $this->view('blog::error');
        }

        $tags = [];

        foreach ($article->tags()->get(['tag']) as $tag) {
            $tags[$tag->tag] = $tag->tag;
        }

        $tags = array_values($tags);

        SEOMeta::setTitle($article->title);
        SEOMeta::setDescription($article->subtitle);
        SEOMeta::setCanonical($article->url);
        SEOMeta::addMeta('fb:app_id', '191652421276345');

        OpenGraph::setTitle($article->title)
            ->setDescription($article->subtitle)
            ->setType('article')
            ->setUrl($article->url)
            ->setArticle([
                'published_time' => $article->created_at,
                'author' => 'https://www.facebook.com/douglaszuqueto',
                'tag' => $tags
            ])
            ->addImage($article->image_url);


        TwitterCard::addValue('card', 'summary');
        TwitterCard::setTitle($article->title);
        TwitterCard::setDescription($article->subtitle);
        TwitterCard::setSite($article->url);
        TwitterCard::setUrl($article->url);
        TwitterCard::addValue('image', $article->image_url);

        $article->text = (new Parsedown())->text($article->text);

        $lastArticles = $this->articlesRepository
            ->orderBy('created_at', 'desc')
            ->findWhere(['state' => 3, ['id', '<>', $article->id]])
            ->take(5);

        $tags = $this->tagsRepository->findWhere(['state' => 1]);

        return $this->view('blog::articles.show', [
            'article' => $article,
            'lastArticles' => $lastArticles,
            'tags' => $tags
        ]);
    }
}