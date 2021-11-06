<?php
namespace DAO;
use Models\Career;
use Models\Student;
use Models\User;

class OriginStudentDAO
{
    private $url='https://utn-students-api.herokuapp.com/api/Student';
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
            //BUSCAR EN LA BASE DE USERS ROL EL OBJETO ROL PARA METERLO EN EL ESTUDIANTE (LO NECESITA EL USER DAO PARA INSERTAR ETC)

                $student= new Student();
                $student->setUserId($value['studentId']);
                $student->setEmail($value['email']);
                $student->setLastName($value['lastName']);
                $student->setFirstName($value['firstName']);
                $student->setActive($value['active']);

                $career= new Career();
                $career->setCareerId($value['careerId']);
                $student->setCareer($career);

                $student->setDni($value['dni']);
                $student->setFileNumber($value['fileNumber']);
                $student->setBirthDate($value['birthDate']);
                $student->setGender($value['gender']);
                $student->setPhoneNumber($value['phoneNumber']);

                array_push($this->finalArray, $student);
        }
    }


    private function getAll()
    {
        return $this->finalArray;
    }

    public function  start(OriginStudentDAO $api)
    {
        $api->init();
        $api->setOption()->setOption( CURLOPT_RETURNTRANSFER, true)->setOption(CURLOPT_SSL_VERIFYPEER, false)->setOption(CURLOPT_HTTPHEADER, array(API_KEY))->decode();
        $students= $api->getAll();
        $api->close();
        if(!empty($this->finalArray))
        {
            $this->finalArray=array();
        }

        return $students;
    }

    private function close()
    {
        curl_close($this->handler);
        return $this;
    }




}