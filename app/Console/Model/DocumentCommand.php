<?php


namespace App\Console\Model;


use App\Console\Model\DocLink\DocLinkCommand;
use App\Console\Model\DocTitles\DocTitleCommand;
use App\Console\Model\DocTypes\DocTypeCommand;
use App\Console\Model\Fulltexts\FullTextCommand;
use App\Console\Model\People\PeopleCommand;
use App\Console\Model\PubDates\PubDateCommand;
use App\Console\Model\RecordNumer\RecordNumberCommand;

class DocumentCommand
{

    private $docLink;
    private $pubDate;
    private $recordNumber;
    private $docTitle;
    private $fulltext;
    private $docType;
    private $people;

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

    public function setlink( String $docLink ){
        return $this->docLink = $docLink;
    }

    public function setPubDate( String $pubDate ){
        return $this->pubDate = $pubDate;
    }

    public function setRecordNumber( String $recordNumber ){
        return $this->recordNumber = $recordNumber;
    }

    public function setDocTitle( String $docTitle ){
        return $this->docTitle = $docTitle;
    }

    public function setFulltext( String $fullText ){
        return $this->fulltext = $fullText;
    }

    public function setType( String $docType ){
        return $this->docType = $docType;
    }

    public function setPeople( String $people ){
        return $this->people = $people;
    }

    public function getlink(){
        return $this->docLink;
    }

    public function getPubDate(){
        return $this->pubDate;
    }

    public function getRecordNumber(){
        return $this->recordNumber;
    }

    public function getDocTitle(){
        return $this->docTitle;
    }

    public function getFulltext(){
        return $this->fulltext;
    }

    public function getType(){
        return $this->docType;
    }

    public function getPeople(){
        return $this->people;
    }




}
