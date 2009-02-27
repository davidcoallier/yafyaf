<?php

class Yafyaf_TwitterRss
{
    const URL = 'http://twitter.com/statuses/user_timeline/16592195.rss';
    const CACHE = 'TwitterCache.twit';
    const TWITUSER = 'user';
    const TWITPASS = 'pass';

    public $items;
    public $content;
    public $timeOfLastEntry;
    public $cachedItems;
    
    public function __construct() 
    {

        if (!$this->getCache()) {
            $items = array();
            $twitter = new Services_Twitter(self::TWITUSER, self::TWITPASS);
            try {
                foreach ($twitter->statuses->user_timeline()->status as $status) {
                    $items['items'][] = $status;
                }
            } catch (Exception $e) {
                $items['items'][0] = new stdClass();
                $items['items'][0]->created_at = date('Y-m-d H:i:s');
                $items['items'][0]->text       = 
                    'Twitter limit exceeded, will be back online at some point when they allow us again :)';
            }
            
            $stringStatus = '';
            foreach ($items['items'] as $key => $item) {
                $stringStatus .= 'LastFetch###' . strtotime(date('Y-m-d H:i:s'), 0) . '###Time###' . $item->created_at . '###Text###' . $item->text . PHP_EOL;
            }
            
            file_put_contents(dirname(__FILE__) . DIRECTORY_SEPARATOR . self::CACHE, $stringStatus);
        }
        
        $this->loadCache();
    }
    
    public function getEntries()
    {
        $entries = array();
        for ($i = 0; $i < 5; $i++) {
            if (isset($this->items[$i])) {
                $entries[$i]['date'] = $this->items[$i]->created_at;
                $entries[$i]['text'] = $this->items[$i]->text;
            }
        }
        return $entries;
    }
    
    private function loadCache()
    {
        /**
            [0] => LastFetch
            [1] => 1223230920
            [2] => Time
            [3] => Sat Oct 04 23:11:57 +0000 2008
            [4] => Text
            [5] => Working on a static design.
         */
        $string = file(dirname(__FILE__) . DIRECTORY_SEPARATOR . self::CACHE);
        $i = 0;
        foreach ($string as $line) {
            $parts = split('###', $line);
            
            $this->items[$i] = new stdClass();
            $this->items[$i]->created_at = $parts[3];
            $this->items[$i]->text       = $parts[5];
            
            ++$i;
        }
        
        return true;
    }
    
    public function getCache()
    {
        /**
            [0] => LastFetch
            [1] => 1223230920
            [2] => Time
            [3] => Sat Oct 04 23:11:57 +0000 2008
            [4] => Text
            [5] => Working on a static design.
         */
        $string    = file(dirname(__FILE__) . DIRECTORY_SEPARATOR . self::CACHE);
        $lastEntry = array_shift($string);
        
        $lastEntryParts = split('###', $lastEntry);

        $parts = new stdClass();
        $parts->LastFetch = $lastEntryParts[1];
        
        $dateFrom = $parts->LastFetch;
        $dateTo   = strtotime(date('Y-m-d H:i:s'), 0);;
        
        $difference = $dateTo - $dateFrom;
        
        // If difference is smaller than 10
        if (($difference / 60) < 10) {
            return true;
        }
        
        return false;
    }
}
