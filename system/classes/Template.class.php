<?php
defined('Imperial')or die('No direct script access.');

class Template {

    public ?string $tplDir = NULL;
    private array $options;

    private function parse($tplName, $tplTitle = array()){
        if (!strstr($tplName, '.tpl')){
            $tplName .= '.tpl';
        }

        if (file_exists(TPLDIR . $tplName)) {
            $this -> tplDir = TPLDIR . $tplName;
        } else {
            die('Файл ' . $tplName . ' не является шаблоном или не найден.');
        }

        $this -> options['title'] = $tplTitle['title'];

        extract($this -> options,256);

        require_once ''.$this -> tplDir.'';
    }


    /**
     * @param $tplName
     * @param array $tplTitle
     */
    public function display($tplName, $tplTitle = array()){
        $this -> parse($tplName, $tplTitle);
    }

    /**
     * @param $arrayParam
     * @param null $arrayParamRev
     * @return bool
     */
    public function assign($arrayParam, $arrayParamRev = NULL) {
        if (!$arrayParamRev and is_array($arrayParam)) {
            foreach($arrayParam AS $arrayParamEl => $arrayParamRow){
                $this -> options[$arrayParamEl] = $arrayParamRow;
            }
            return true;
        } elseif ($arrayParamRev){
                $this -> options[$arrayParam] = $arrayParamRev;
            return true;
        }
        return false;
    }
}