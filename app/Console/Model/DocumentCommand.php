<?php


namespace App\Console\Model;


use App\Console\Model\DocLink\DocLinkCommand;
use App\Console\Model\DocTitles\DocTitleCommand;
use App\Console\Model\PeopleCommand\PeopleCommand;
use App\Console\Model\PubDates\PubDateCommand;
use App\Console\Model\RecordNumer\RecordNumberCommand;

class DocumentCommand
{

    private $docLinkCommand;
    private $pubDateCommand;
    private $recordNumberCommand;
    private $docTitleCommand;
    private $fulltextCommand;
    private $docTypeCommand;
    private $peopleCommand;

    function _construct(
            /*DocLinkCommand $docLinkCommand,
            PubDateCommand $pubDateCommand,
            RecordNumberCommand $recordNumberCommand,
            DocTitleCommand $docTitleCommand,
            FullTextCommand $fulltextCommand,
            DocTypeCommand $docTypeCommand,
            PeopleCommand $peopleCommand*/
    ){

         /*$this->docLinkCommand = $this->setlink($docLinkCommand);
         $this->pubDateCommand = $this->setPubDateCommand($pubDateCommand);
         $this->recordNumberCommand = $this->setRecordNumberCommand($recordNumberCommand);
         $this->docTitleCommand = $this->setDocTitleCommand($docTitleCommand);
         $this->fulltextCommand = $this->setFulltext($fulltextCommand);
         $this->docTypeCommand = $this->setType($docTypeCommand);
         $this->peopleCommand = $this->setPeopleCommand($peopleCommand);*/

    }

    public function setlinkCommand( $docLinkCommand ){
        return $this->docLinkCommand = $docLinkCommand->getlink();
    }

    public function setPubDateCommand( $pubDateCommand ){
        return $this->pubDateCommand = $pubDateCommand->getPubDateCommand();
    }

    public function setRecordNumberCommand( $recordNumberCommand ){
        return $this->recordNumberCommand = $recordNumberCommand->getRecordNumberCommand();
    }

    public function setDocTitleCommand( $docTitleCommand ){
        return $this->docTitleCommand = $docTitleCommand->getDocTitleCommand();
    }

    public function setFulltext( $fulltext ){
        return $this->fulltextCommand = $fulltext->getFulltext();
    }

    public function setType( $docTypeCommand ){
        return $this->docTypeCommand = $docTypeCommand->getType();
    }

    public function setPeopleCommand( $peopleCommand ){
        return $this->peopleCommand = $peopleCommand->getPeopleCommand();
    }


    public function mapDocumentModel(){
        //code that will map
    }



}
