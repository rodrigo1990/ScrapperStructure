<?php


namespace App\Console\Model\Fulltexts;


use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Label305\DocxExtractor\Basic\BasicExtractor;
use phpDocumentor\Reflection\Types\Boolean;
use Smalot\PdfParser\Document;
use Smalot\PdfParser\Parser;

class FullTextCommand extends  Command
{
    private $text;
    private $file;

    function __construct( Int $page = null, Document $file)
    {
        $this->file = $file;

        if($page == null)
            $this->text = $this->setText();
        else
            $this->text = $this->setTextByPage( $page );

    }

    public function getText(){
        return $this->text;
    }

    private function setText(){
        return $this->file->getText();
    }

    private function setTextByPage( Int $page ){
        $page = $this->file->getPages()[$page];
        return $page->getText();
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
