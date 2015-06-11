<?php

class Voice {

    private $dataFolder;
    private $name;

    public function __construct($name, $dataFolder){
        $this->name = $name;
        $this->dataFolder = $dataFolder;
    }


    public function speakString($string){
        $words = explode(" ", $string);
        $spoken = [];
        foreach($words as $word){
            if(is_numeric($word) and strlen($word) < 5){
                $spoken = array_merge($spoken ,PUTTS::getInstance()->getLanguage()->sayNumber($word));
            } elseif ($this->existsVoiceFile(strtolower($word))){
                $spoken[] = $word;
            } else {
                $chopped = str_split($word);
                foreach($chopped as $part){
                    if($this->existsVoiceFile(strtolower($word))){
                        $spoken[] = $part;
                    }
                }
            }
        }
        return new BrowserWav($spoken);
    }

    public function useable(){
        $required = PUTTS::getInstance()->getLanguage()->getRequired();
        foreach($required as $audio){
            if(!$this->existsVoiceFile($audio)){
                return false;
                break;
            }
        }

        return true;
    }

    public function existsVoiceFile($file){
        return file_exists($this->getDataFolder().$file.".wav");
    }

    public function getName(){
        return $this->name;
    }

    public function getDataFolder(){
        return $this->dataFolder."/";
    }

    public function getDataFolderContents(){
        return scandir($this->dataFolder);
    }

} 