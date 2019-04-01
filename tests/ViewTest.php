<?php
require 'view/View.php';

use PHPUnit\Framework\TestCase;

/*
 * for start use the command in the root directory:
 * phpunit --bootstrap vendor/autoload.php tests
 * */
class ViewTest extends TestCase
{
    private $view = null;

    /**
     * example phpUnit test for class View
     * @test
     * */
    public function testArticleView()
    {
        $this->view = new View();

        $id = 0;
        $fileName = "test.xml";
        $isException = false;

        try {
            $this->view->articleView($id, $fileName);
        } catch (Exception $e) {
            $isException = true;
        }

        $this->assertTrue($isException);
    }

}