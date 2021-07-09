<?php


namespace App\Console\Model\PeopleCommand;


use App\Author;
use App\Support\Enum\ParliamentCodes;
use Illuminate\Support\Facades\DB;

class PeopleCommand
{
    private $people;
    private $author;
    private $authorFraction;

    function __construct( $people ){
        $this->people = $this->setPeople( $people );
        $this->author = $this->setAuthor( $people );
        $this->authorFraction = $this->setAuthorFraction();
    }

    private function setPeople( $people ){

        $authors = DB::select("select id,name from stakeholders_data where 1");

        $text = str_replace(array("\r\n", "\n", "\r"), ' ', $people);

        $authorData = [];
        foreach ($authors as $author) {
            if (strpos(
                    $text,
                    $author->name
                ) !== false
                || $this->fuzzyTextMatch($text, $author->name)
            ) {
                $authorData[$author->id] = $author->name;
            }
        }


        return json_encode($authorData);
    }

    private function setAuthor( $people ){
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

    private function getAuthor( $people ){
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