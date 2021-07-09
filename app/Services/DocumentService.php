<?php


namespace App\Services;


use App\Console\Model\DocLink\DocLinkCommand;
use App\Console\Model\DocumentCommand;
use App\Models\Document;

class DocumentService
{
    public function existsByLink( DocLinkCommand $docLinkCommand ){

        $document = Document::where('doc_link', $docLinkCommand->getLink() )->first();

        if($document) {
            $documentCommand = new DocumentCommand();
            $documentCommand->setLinkCommand( $docLinkCommand );
            return $documentCommand;
        }else
            return null;

    }
}
