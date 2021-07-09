<?php


namespace App\Console\Model\DocLink;


class DocLinkCommand
{
    private $link;

    function __construct( $link ){
        $this->link = $this->setLink( $link );
    }

    private function setLink( $link ){

        if(is_array( $link ))
            return $link[0];

        return $link;
    }

    public function getLink(){
        return $this->link;;
    }

    public function getSchemalessLink( $link ){
        return str_replace(['https://','https://'], '', $this->link);;
    }





}
