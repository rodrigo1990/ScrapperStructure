<?php


namespace App\Console\Model\PubDates;


class PubDateCommand
{
    private $pubdate;

    function __construct( $string )
    {
        $this->pubdate = $this->setPubDate( $string );
    }

    /**
     * Get date time from string (title or description) - SHOULD BE MOVED TO ANOTHER CLASS!!!!
     * @param $string
     * @return string
     */
    private function setPubDate( $string, Array $patterns = null )
    {
        $string = str_replace('	', ' ', $string);
        $string = str_replace('  ', ' ', $string);



        $dateTime = "";
        $matches = [];

        $months = [
            'en' => [
                'January ',
                'February ',
                'March',
                'April',
                'May',
                'June',
                'July',
                'August',
                'September',
                'October',
                'November',
                'December'
            ],
            'de' => [
                'Januar ',
                'Februar ',
                'März',
                'April',
                'Mai',
                'Juni',
                'Juli',
                'August',
                'September',
                'Oktober',
                'November',
                'Dezember'
            ]
        ];

        if( $patterns == null) {
            $patterns = [
                '/[0-9]{1,2}.[0-9]{1,2}.[0-9]{2,4}/',
                '/\d+\s*(January|February|March|April|May|June|July|August|September|October|November|December)\s*\d+\s*(,|um)?\s*(\d+(\.|\:)?\d*)*/',
                '/\d+(\-|\.|\/)\d+\s*(,|um)?(\-|\.|\/)(\d+(\.|\:)?\d*)*/',
                '/\d+\.\s(Januar|Februar|März|April|Mai|Juni|Juli|August|September|Oktober|November|Dezember)\s*\d+/',
                '/\d+\,\s(Januar|Februar|März|April|Mai|Juni|Juli|August|September|Oktober|November|Dezember)\s*\d+/',
                '/\w*(Mon|Tue|Wed|Thu|Fri|Sat|Sun),\s.\d\s*\w*(Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)\s*\d{4}/',
                '/(Januar|Februar|März|April|Mai|Juni|Juli|August|September|Oktober|November|Dezember)\s*\d+\,*\s\d{4}/'
            ];
        }

        $foundDates = collect();
        foreach ($patterns as $pattern) {
            preg_match($pattern, $string, $matches, PREG_OFFSET_CAPTURE);
            if (count($matches) > 0) {
                $foundDates->push(['date'=>$matches[0][0],'position'=>$matches[0][1]]);
            }
        }

        $foundDates = $foundDates->sortBy('position');
        foreach ($foundDates as $foundDate) {
            $dateTime = $foundDate['date'];
            if (strtotime($foundDate['date'])>0){
                break;
            }
        };

        //Replacing German months with English ones
        foreach ($months['de'] as $number => $month) {
            $dateTime = str_replace($month, $months['en'][$number], $dateTime);
        }

        //return $dateTime;

        $dateTime = str_replace('um', ',', $dateTime);
        $timestamp = strtotime($dateTime);

        if (!$timestamp) {
            //try to see if the format is perhaps "11. November 2015, 10" which needs adding ":00" to be translatable
            $timestamp = strtotime($dateTime . ":00");
        }

        if (!$timestamp) {
            $dateTime2 = str_replace(', ', ' ', $dateTime);
            $timestamp = strtotime($dateTime2);
        }

        if (!$timestamp) {
            $dateTime3 = str_replace('/', '.', $dateTime);
            $timestamp = strtotime($dateTime3);
        }

        //Dealing with dd.mm.YY format (strtotime can not recognize it)
        if (strlen($dateTime) == 8) {
            $dateTime = preg_replace('/\.\d{2}$/', '.'.date("Y"), $dateTime);
            $this->info("DATETIME:".$dateTime);
        }


        $timestamp = strtotime(trim($dateTime));

        return date("Y-m-d H:i:s", $timestamp);
    }
}
