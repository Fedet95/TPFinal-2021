<?php
namespace DAO;
use Models\Career;

class APICareerDAO
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

    public function init()
    {
        $this->handler= curl_init();
        return $this;
    }

    public function setOption($option = null, $value = null)
    {
        curl_setopt($this->handler, is_null($option) ? $this->option : $option, is_null($value) ? $this->url : $value );
        return $this;
    }


    public function execute()
    {
        return curl_exec($this->handler);
    }

    public function decode()
    {
        $this->response= json_decode($this->execute(), true);
        $this->convertion();
    }

    public function convertion()
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


    public function getAll()
    {
        return $this->finalArray;
    }

    public function  start(APICareerDAO $api)
    {
        $api->init();
        $api->setOption()->setOption( CURLOPT_RETURNTRANSFER, true)->setOption(CURLOPT_SSL_VERIFYPEER, false)->setOption(CURLOPT_HTTPHEADER, array(API_KEY))->decode();
        $careers= $api->getAll();
        $api->close();

        return $careers;
    }

    public function close()
    {
        curl_close($this->handler);
        return $this;
    }


}