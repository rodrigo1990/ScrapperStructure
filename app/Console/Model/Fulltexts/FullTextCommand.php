<?php


namespace App\Console\Model\Fulltexts;


use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Label305\DocxExtractor\Basic\BasicExtractor;
use phpDocumentor\Reflection\Types\Boolean;
use Smalot\PdfParser\Parser;

class FullTextCommand extends  Command
{
    private $command;
    private $filePath ;
    private $docName;
    private $folderPath;
    private $pdf;
    const COOKIE_PATH = '/tmp/cookie.txt';

    function __construct( String $docLink, Command $command )
    {
        $this->prepareFolders();
        $this->docName = $this->setDocName( $docLink );
        $this->filePath = storage_path() . "/app/pdfs/". $this->docName;
        $this->folderPath = storage_path() . "/app/pdfs/";
        $this->command = $command;
        $this->pdf = $this->setPDFFile( $docLink );

    }

    public function getFullText(){
        return $this->pdf->getText();
    }

    public function getTextByPage( Int $page ){
        $page = $this->pdf->getPages()[$page];
        return $page->getText();
    }

    private function setDocName( String $docLink ){
        return md5($docLink) . ".pdf";
    }

    private function setPDFFile( String $docLink, Boolean $cache = null){

        $this->deleteFile();
        if (( !Storage::exists($this->filePath)  ) || $cache == null) {
            $this->command->info("downloading: " . $this->docName . " " . $docLink);
            $this->downloadFile($docLink);
        }

        $PDFParser = new Parser();

        $pdf = $PDFParser->parseFile($this->filePath);
        $this->deleteFile();

        return $pdf;
    }

    private function prepareFolders(){
        if (!file_exists($this->folderPath)) {
            Storage::makeDirectory('pdfs');
        }
    }

    private function deleteFile(){
        \File::delete( $this->filePath );
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

    private function downloadFile( String $docLink){

        $file = fopen($this->filePath, 'wb');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $docLink);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_COOKIEFILE, self::COOKIE_PATH);
        curl_setopt($ch, CURLOPT_COOKIEJAR, self::COOKIE_PATH);

        $result = curl_exec($ch);
        curl_close($ch);

        fwrite($file, $result);
        fclose($file);
    }


}
