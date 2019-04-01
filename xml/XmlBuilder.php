<?php

class XmlBuilder
{
    private $xmlDoc;

    public function __construct()
    {
        $this->xmlDoc = new DOMDocument('1.0', 'utf-8');
    }

    /**
     * adding data of articles to xmlDoc object
     * @param array data of articles
     * */
    public function addDataToXml($data)
    {
        $root = $this->xmlDoc->appendChild($this->xmlDoc->createElement("articles"));

        $id = 0;
        foreach ($data as $d) {
            if (!empty($d)) {
                $article = $root->appendChild($this->xmlDoc->createElement("article"));
                $article->appendChild($this->xmlDoc->createElement("id", $id++));
                $article->appendChild($this->xmlDoc->createElement("href", $d['href']));
                $article->appendChild($this->xmlDoc->createElement("title", html_entity_decode($d['title'])));
                $length = count($d['info']);
                $article->appendChild($this->xmlDoc->createElement("img", $d['info'][$length - 1]));
                foreach ($d['info'] as $key => $val) {
                    //don't include image
                    if ($key == $length - 1) {
                        break;
                    }
                    $article->appendChild($this->xmlDoc->createElement("row" . $key, htmlspecialchars(html_entity_decode($val))));
                }
            }
        }
    }

    /**
     * creating file with type xml of xmlDoc object
     * @return string file name
     * */
    public function createXml()
    {
        $this->xmlDoc->formatOutput = true;

        $fileName = "main" . time() . '.xml';
        $this->xmlDoc->save($fileName);

        return $fileName;
    }

}