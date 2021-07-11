<?php


namespace App\Console\Model;


use App\Http\Services\DocumentService;
use App\Models\Document;

class DocumentMapper
{

    function __construct( DocumentCommand $documentCommand ){
        $document = new Document();

        $document->doc_title = $documentCommand->getDocTitle();
        $document->pubdate_source = $documentCommand->getPubDate();
        $document->record_nr = $documentCommand->getRecordNumber();
        $document->doc_link = $documentCommand->getlink();
        $document->doc_id = 'asdasdasd';
        $document->fulltext = $documentCommand->getFulltext();
        $document->provider_id = $this->provider_id;
        $document->location = self::LOCATION;
        $document->doc_type = $docType;
        $document->author_person = $authors;
        $document->related_records = $this->getRelatedRecords($document->fulltext);
        $document->bill_keywords = $this->getBillKeywords($document->fulltext);
        $document->related_people = $getPeopleResult;
        $document->related_people_list = implode(',', array_unique(array_values(json_decode($getPeopleResult, true))));
        $document->author_group = $this->getAuthorFraction($document->author_person) ? $this->getAuthorFraction($document->author_person) : '';
        $document->event_time = null;
        $document->source_keywords = '';
        $document->publish_status = '';
        $document->pdf_local_path = storage_path() . "/app/pdfs/" . md5($document->doc_link).'.pdf';
        $document->people_tags = $getPeopleResult;
        $document->update_link = '';
        $document->provider_group = self::PROVIDER_GROUP;
        $document->provider_group_container = $this->provider_group_container;
        $document->origin = get_class($this);
        $document->feed_id = self::FEED_ID;

    }

}
