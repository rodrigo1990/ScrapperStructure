<?php


namespace App\Console\Model\Fulltexts;


use Illuminate\Support\Facades\Storage;
use Label305\DocxExtractor\Basic\BasicExtractor;

class FullTextCommand
{
    private $text;
    private $client;

    function __construct( $docLink, $client )
    {
        $this->prepareFolders();
        $this->client = $this->setClient( $client );
        $this->text = $this->setFullText( $docLink );
    }

    public function getFullText(){
        return $this->text;
    }

    private function setFullText($docLink, $cache = false){
        $docName = md5($docLink) . ".pdf";
        $textName = md5($docLink) . ".txt";
        $this->deleteFiles( $docName, $docLink );
        $cmd = "/usr/bin/pdftotext -raw -enc UTF-8 \"" . storage_path() . "/app/pdfs/" . $docName . "\" \"" . storage_path() . "/app/pdf2text/" . $textName."\"";
        $this->prepareFolders();
        if (( !Storage::exists("pdfs/" . $docName) && mime_content_type(storage_path() . "/app/pdfs/" . $docName ) != "application/pdf" ) || !$cache) {
            $this->info("downloading: " . $docName . " " . $docLink);

            $parse_url = parse_url($docLink);

            $filePath = storage_path() . "/app/pdfs/" . $docName;

            $file = fopen($filePath, 'wb');

            $this->info('Downloading with proxy client...');
            try {
                $response = $this->client->get($docLink, ['sink' => $file]);
                $status = $response->getStatusCode()==200? true:false;
            }catch (\Exception $e) {
                $status = false;
                $this->error($e->getMessage());
            }

            fclose($file);

            if (!$status) {
                $this->warn("Download problem " . $docName);
            }
        }

        $out = $ret = "";
        if (mime_content_type(
                storage_path() . "/app/pdfs/" . $docName
            ) != "application/pdf"
        ) {
            return "";
        }
        if (!file_exists(storage_path() . "/app/pdf2text/" . $textName) || !$cache) {
            exec(escapeshellcmd($cmd), $out, $ret);
        }
        if (!file_exists(storage_path() . "/app/pdf2text/" . $textName)) {
            return false;
        }

        $fullText=file_get_contents(storage_path() . "/app/pdf2text/" . $textName);

        if ($fullText=='') {

            // Check if we have a word-file here.
            preg_match('/.doc(x)?$/', storage_path() . "/app/pdfs/" . $docName, $matches);
            if (count($matches)) {
                $extractor=new BasicExtractor();
                $fullText=$extractor->extractStringsAndCreateMappingFile(storage_path() . "/app/pdfs/" . $docName, storage_path() . "/app/pdfs/" . $docName.'extracted.docx');
                $fullText=implode('', $fullText);
                unlink(storage_path() . "/app/pdfs/" . $docName.'extracted.docx');
            }
        }

        $fullText = $this->sanitizeText( $fullText );

        return $fullText;
    }

    private function setClient($client){
        $this->client = $client;
    }

    private function prepareFolders(){
        if (!file_exists(storage_path() . '/app/pdfs')) {
            Storage::makeDirectory('pdfs');
        }
        if (!file_exists(storage_path() . '/app/pdf2text')) {
            Storage::makeDirectory('pdf2text');
        }
    }

    private function deleteFiles($docName, $textName){
        \File::delete(storage_path() . "/app/pdfs/" . $docName);
        \File::delete(storage_path() . "/app/pdf2text/" . $textName);
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
