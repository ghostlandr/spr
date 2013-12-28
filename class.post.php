<?php

class Post
{
    private $id;
    private $authorid;
    public $created;
    public $release_number;
    public $prepared_by;
    public $subject;
    public $body;
    public $occurrence_date;
    public $occurrence_number;
    private $approved;

    function __construct($id, $authorid, $created, $release_number, $prepared_by,
     $subject, $body, $occurrence_date, $occurrence_number, $approved)
    {
        $this->id = $id;
        $this->authorid = $authorid;
        $this->created = $created;
        $this->release_number = $release_number;
        $this->prepared_by = $prepared_by;
        $this->subject = $subject;
        $this->body = $body;
        $this->occurrence_date = $occurrence_date;
        $this->occurrence_number = $occurrence_number;
        $this->approved = $approved;
    }

    function __destruct()
    {
        unset($this);
    }

    function is_approved()
    {
        return $this->approved == APPROVED;
    }

    function to_html_markup()
    {
        $occurrence_number = $this->occurrence_number ? $this->occurrence_number : "";
        return 
        "<div class='content_item'>
            <br clear='right'>
            <div style='margin: 15px 0px;'>
                <div style='float:left; font-weight:bold;'>Date: {$this->occurrence_date}</div>
                <div style='float:right; width:200px; font-weight:bold;'>Release Number: 
                <a href='http://www.police.saskatoon.sk.ca/index.php?loc=headlines.php&amp;news_id={$this->release_number}'>
                {$this->release_number}</a></div>
                <br>
                <div style='float:left; font-weight:bold;'>Released By:  {$this->prepared_by}</div>
                <div style='float:right; width:200px; font-weight:bold;'>Occurrence Number: {$occurrence_number}</div>
                <br>
                <div style='float:left; font-weight:bold;'>Subject: {$this->subject}</div>
            </div>
            <br>
            <div>
            <p>
                {$this->body}
            </p>
            </div>
        </div>";
    }
}
