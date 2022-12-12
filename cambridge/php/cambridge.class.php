<?php

class Cambridge {
    private $text;
    private $words;
    
    public function __construct($text) {
        $this->text = $text;
        $this->words = preg_split("/[\s\v\"',.;:!-()]+/", $this->text, -1, PREG_SPLIT_OFFSET_CAPTURE | PREG_SPLIT_NO_EMPTY);
    }
    
    public function scramble() {
        foreach ($this->words as $word) {
            $this->text = substr_replace($this->text, $this->swap($word[0]), $word[1], strlen($word[0]));
        }
        return $this->text;
    }    
    
    private function swap($word) {
        if (strlen($word) > 3) {
            for ($i = 1; $i < strlen($word) - 2; $i+=2) {
                $letter_bak = $word[$i];
                $word[$i] = $word[$i + 1];
                $word[$i +1] = $letter_bak;
            }
        }
        return $word;
    }
    
}
