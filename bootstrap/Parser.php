<?php

use PHPHtmlParser\Dom;

class Parser
{
    private $mainUrl = "";
    private $timeForUrl;
    private $a = [];
    private $dom;


    public function __construct($mainUrl)
    {
        $this->mainUrl = $mainUrl;
        $this->timeForUrl = time() * 1000;
        $this->dom = new Dom();
    }

    /**
     * parse rbk by url
     */
    public function parse()
    {
        $contents = json_decode(file_get_contents($this->mainUrl . $this->timeForUrl));

        $a = [];
        foreach ($contents->items as $item) {
            $this->dom->load($item->html);
            $a[] = $this->dom->find('a');
        }

        $article = [];
        foreach ($a as $el) {
            $article[] = ['href' => $el->getAttribute('href'),
                'info' => $this->articleParse($el->getAttribute('href')),
                'title' => strip_tags($el->innerHtml)];
        }

        $this->a = $article;

    }

    /**
     * get articles after parse
     * @return array articles
     */
    public function getArticles()
    {
        return $this->a;
    }

    /**
     * parse single article by url
     * @param string url
     * @return array article
     */
    private function articleParse($href)
    {
        $this->dom->load($href);

        $img = $this->dom->find('div.article__main-image img');

        $text = $this->dom->find('div.article__text p');

        $articleArray = [];

        foreach ($text as $t) {

            $articleArray[] = $t->text;

        }

        if (isset($img[0])) {
            $articleArray[] = $img[0]->src;
        } else $articleArray[] = "";

        return $articleArray;

    }

}