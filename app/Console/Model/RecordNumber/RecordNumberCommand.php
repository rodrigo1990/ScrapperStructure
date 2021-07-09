<?php


namespace App\Console\Model\RecordNumber;


class RecordNumberCommand
{
    private $recordNumber;

    function __construct( $text ){
        $this->recordNumber = $this->setrecordNumber( $text );
    }

    private function setrecordNumber( $text ){
        if( is_array($text) )
            $text = $text[0];
        $pattern = '/(?!Nr\.\s)\d{1,5}\/\d{1,5}/';
        preg_match($pattern, $text.' ', $recordNumber);
        return $recordNumber[0];
    }

    public function getrecordNumber(){
        return $this->recordNumber;;
    }

}
