<?php
namespace DAO;
use Models\Career;

class OriginCareerDAO
{
    private $url='https://utn-students-api.herokuapp.com/api/Career';
    private $option;
    private $handler; //mi $ch
    private $response;
    private $finalArray = array();


    public function __construct($url = null, $option= null)
    {
        $this->url= is_null($url) ? $this->url : $url;
        $this->option= is_null($option) ? CURLOPT_URL : $option;

    }

    private function init()
    {
        $this->handler= curl_init();
        return $this;
    }

    private function setOption($option = null, $value = null)
    {
        curl_setopt($this->handler, is_null($option) ? $this->option : $option, is_null($value) ? $this->url : $value );
        return $this;
    }


    private function execute()
    {
        return curl_exec($this->handler);
    }

    private function decode()
    {
        $this->response= json_decode($this->execute(), true);
        $this->convertion();
    }

    private function convertion()
    {
        foreach ($this->response as $key =>$value)
        {
            $career= new Career();
            $career->setCareerId($value['careerId']);
            $career->setDescription($value['description']);
            $career->setActive($value['active']);

            array_push($this->finalArray, $career);
        }
    }


    private function getAll()
    {
        return $this->finalArray;
    }

    public function  start(OriginCareerDAO $api)
    {
        $api->init();
        $api->setOption()->setOption( CURLOPT_RETURNTRANSFER, true)->setOption(CURLOPT_SSL_VERIFYPEER, false)->setOption(CURLOPT_HTTPHEADER, array(API_KEY))->decode();
        $careers= $api->getAll();
        $api->close();

        return $careers;
    }

    private function close()
    {
        curl_close($this->handler);
        return $this;
    }






}