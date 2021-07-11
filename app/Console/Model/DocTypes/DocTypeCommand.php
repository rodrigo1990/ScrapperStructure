<?php


namespace App\Console\Model\DocTypes;


use Illuminate\Support\Facades\DB;

class DocTypeCommand
{
    private $type;

    function __construct( $text, $type = null ){
        $this->type = $type == 'auto' ? $this->setType( $text ) : $type;
    }

    private function setType( $text, $country="de" ){
        $textShort = strtolower(substr($text, 0, 1000));
        $doctypesAvailable = DB::select("select doctype_short,doctype_full from doctype where country='$country'");

        $doctypesAvailable = collect($doctypesAvailable);

        $doctypesAvailable = $doctypesAvailable->sortByDesc(function($doctype){
            return strlen($doctype->doctype_short);
        })->toArray();

        //get the matching phrase which is the closest to beginning of the text
        $lowestId = 1000;
        $doctype = "";
        foreach ($doctypesAvailable as $dt) {
            $position = strpos($textShort, strtolower($dt->doctype_short));
            if ($position !== false && $lowestId > $position) {
                $lowestId = $position;
                $doctype = $dt->doctype_short;
            } else {
                $position = strpos($textShort, strtolower($dt->doctype_full));
                if ($position !== false && $lowestId > $position) {
                    $lowestId = $position;
                    $doctype = $dt->doctype_short;
                }
            }
        }

        return $doctype;
    }

    public function getType(){
        return $this->type;
    }

}
