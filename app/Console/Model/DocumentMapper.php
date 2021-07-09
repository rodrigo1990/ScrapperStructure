<?php


namespace App\Console\Model;


use App\Http\Services\DocumentService;

class DocumentMapper
{

    function __construct( Document $document ){


        $document->map(function ($document) {

            return $document->name;
        });
    }

}