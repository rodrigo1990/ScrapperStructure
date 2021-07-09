<?php


namespace App\Console\Model\DocTitles;


class DocTitleCommand
{
    private $title;

    function __construct( $title ){
        $this->title = $this->setTitle( $title );
    }

    private function setTitle( $title ){

        $title  = $this->sanitizeText( $title[0] );

        return $title;
    }

    public function getTitle(){
        return $this->title;;
    }

    private function sanitizeText($text, $lowercase = false){
        $text = str_replace("\xc2\xa0",' ',$text);
        $text = preg_replace("/\r|\n|\t/", " ", $text);
        $text = strip_tags($text);
        $text = trim($text);

        if($lowercase)
            $text = strtolower($text);

        return $text;
    }


}
