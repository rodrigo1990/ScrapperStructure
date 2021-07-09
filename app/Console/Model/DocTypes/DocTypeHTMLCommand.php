<?php


namespace App\Console\Model\DocTypes;


class DocTypeHTMLCommand extends \App\Console\Model\DocTypeCommand
{
    private $path;

    function __construct( $path, $text )
    {
        parent::__construct( $text );
        $this->path = $this->setPath( $path );
    }

    private function setPath ( $path )
    {
        $this->path = $path;
    }


}