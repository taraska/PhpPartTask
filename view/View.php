<?php

class View
{

    /**
     * show full one article by id
     * @param int id
     * @param string file name
     *
     * @throws Exception
     */
    public function articleView($id, $file)
    {
        $articles = simplexml_load_file($file);

        if ($articles === false) throw new Exception("no file");

        $article = null;

        foreach ($articles->article as $a) {
            if ($a->id == $id) {
                $article = $a;
                break;
            }
        }

        if ($article == null) throw new Exception("no article");

        echo "<h4>" . $article->id . "</h4>";

        echo "<h1>" . $article->title . "</h1>";

        echo "<a href='$article->href'>" . "Оригинал" . "</a>";

        echo "<img src='$article->img'/>";

        //variables after id, href, title, img
        $rowCount = count($article) - 4;
        $n = 0;

        while ($rowCount-- > 0) {
            $name = 'row' . $n++;
            echo "<p>" . $article->{$name} . "</p>";
        }

    }

    /**
     * show all titles of file
     * @param string file name
     *
     * @throws Exception
     */
    public function articlesView($file)
    {

        $articles = simplexml_load_file($file);

        if ($articles === false) throw new Exception("no file");

        foreach ($articles->article as $a) {
            echo "<h4>" . $a->id . "</h4>";

            echo "<h1>" . mb_strimwidth($a->title, 0, 200, "...") . "</h1>";

            echo "<a href='?id=" . $a->id . "&" . "file=" . $file . "'>" . "подробнее" . "</a>";
        }
    }
}