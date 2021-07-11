<?php


namespace App\Console\Model\People;


use App\Models\Author;
use App\Support\Enum\ParliamentCodes;
use Illuminate\Support\Facades\DB;

class PeopleCommand
{
    private $people;
    private $author;
    private $authorFraction;

    function __construct( $text ){
        $this->people = $this->setPeople( $text );
        $this->author = $this->setAuthor( $text );
        $this->authorFraction = $this->setAuthorFraction();
    }

    private function setPeople( String $text ){

        $authors = DB::select('select id,full_name, first_name, last_name from authors where parliament="Schleswig-Holsteinischer Landtag"');
        $authorData = [];
        foreach ($authors as $author) {
            if($text != null && $author!=null) {
                //Improve query to find out in first and last name
                if ($author->full_name != null && strpos($text, $author->full_name) !== false) {
                    $authorData[$author->id] = $author->full_name;
                }
            }

        }
        return json_encode($authorData);
    }

    private function setAuthor( String $people ){
        $author = "";
        if ( $this->people != null ) {
            $authors = $this->people;
        } else {
            if (strpos($author, "Fraktion") !== false) {
                $authorGroup = trim(str_replace("Fraktion", "", $author));

                return $authorGroup;

            } else {
                return $author;
            }
        }

    }

    private function getAuthor( ){
        return $this->author;

    }

    public function getPeople(){
        return $this->people;;
    }

    public function setAuthorFraction()
    {
        $name = explode('(', $this->author)[0];
        $author = Author::where('full_name', $name)->first();
        if ($author) {
            return $author->fraction;
        }
        return null;
    }
}
