<?php


namespace App\Console\Model\FileManagers;


use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\Types\Boolean;
use Smalot\PdfParser\Parser;

class FileManager
{
    private $command;
    private $filePath ;
    private $docName;
    private $folderPath;
    private $file;
    const COOKIE_PATH = '/tmp/cookie.txt';

    function __construct( String $docLink, Command $command )
    {
        $this->prepareFolders();
        $this->docName = $this->setDocName( $docLink );
        $this->filePath = storage_path() . "/app/pdfs/". $this->docName;
        $this->folderPath = storage_path() . "/app/pdfs/";
        $this->command = $command;
        $this->file = $this->setFile( $docLink );

    }

    public function getFile(){
        return $this->file;
    }

    private function setDocName( String $docLink ){
        return md5($docLink) . ".pdf";
    }

    private function setFile(String $docLink, Boolean $cache = null){

        $this->deleteFile();
        if (( !Storage::exists($this->filePath)  ) || $cache == null) {
            $this->command->info("downloading: " . $this->docName . " " . $docLink);
            $this->downloadFile($docLink);
        }

        /******* Check parser factory option *****************/
        $PDFParser = new Parser();
        $pdf = $PDFParser->parseFile($this->filePath);
        /******************************************************/

        $this->deleteFile();

        return $pdf;
    }

    private function prepareFolders(){
        if (!file_exists($this->folderPath)) {
            Storage::makeDirectory('pdfs');
        }
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

    private function deleteFile(){
        \File::delete( $this->filePath );
    }

}
