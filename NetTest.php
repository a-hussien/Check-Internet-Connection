<?php
class NetTest{
    const CHECK_ONE_TIME = 1;
    const CHECK_FIVE_TIME = 5;
    const CHECK_TEN_TIME = 2;
    const CHECK_ALWAYS = 3;
    private $typeCheck;
    private $speed;
    private $sensitivity = 50;
    function __construct($typeCheck = NetTest::CHECK_ALWAYS){
        $this->typeCheck = $typeCheck;
        $this->_generate();
    }
    private function _generate(){
        session_regenerate_id();
        session_start();
        
        if (!isset($_SESSION['checkNetStatus'])) {
            $this->_start();
        }
        
        else if ($_SESSION['checkNetStatus'] == 'start'){
            $this->_end();
        }
        $this->_checkType();
    }
    private function _start(){
        $_SESSION['checkNetStatus'] = 'start';
        $_SESSION['checkNetTime'] = microtime(true);
        header("Location: http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}");
        exit;
    }
    private function _end(){
        $_SESSION['checkNetStatus'] = 'end';
        $_SESSION['checkNetTime'] = microtime(true)-$_SESSION['checkNetTime'];
    }
    private function _checkType(){
        switch ($this->typeCheck){
            case NetTest::CHECK_ONE_TIME:{
                if (isset($_SESSION['checkNetRepeat'])){
                    unset($_SESSION['checkNetRepeat']);
                }
                break;
            }
            case NetTest::CHECK_FIVE_TIME:{
                if (!isset($_SESSION['checkNetRepeat'])){
                    unset($_SESSION['checkNetStatus']);
                    $_SESSION['checkNetRepeat'] = 5;
                    break;
                }
                if (--$_SESSION['checkNetRepeat'] <= 0){
                    unset($_SESSION['checkNetStatus']);
                    $_SESSION['checkNetRepeat'] = 5;
                }
                break;
            }
            case NetTest::CHECK_TEN_TIME:{
                if (!isset($_SESSION['checkNetRepeat'])){
                    unset($_SESSION['checkNetStatus']);
                    $_SESSION['checkNetRepeat'] = 10;
                    break;
                }
                if (--$_SESSION['checkNetRepeat'] <= 0){
                    unset($_SESSION['checkNetStatus']);
                    $_SESSION['checkNetRepeat'] = 10;
                }
                break;
            }
            case NetTest::CHECK_ALWAYS:{
                unset($_SESSION['checkNetStatus']);
                unset($_SESSION['checkNetRepeat']);
                break;
            }
        }
    }
    
    function getTime(){
        return $_SESSION['checkNetTime'];
    }
    function getSpeed(){
        return intval($this->getSpeedFloat());
    }
    function getSpeedFloat(){
        if ($this->speed){
            return $this->speed;
        }
        $this->speed = 101-($this->getTime())*(3 * $this->sensitivity);
        if ($this->speed < 1){
            $this->speed = 1;
        }else if ($this->speed > 100){
            $this->speed = 100;
        }
        return $this->speed;
    }
    function setSensitivity($sensitivity){
        if ($sensitivity < 1)
            $sensitivity = 1;
        else if ($sensitivity > 100)
            $sensitivity = 100;
        $this->sensitivity = $sensitivity;
        $this->speed = null;
    }
    function getSensitivity(){
        return $this->sensitivity;
    }
    function getSpeedName(){
        $speed = $this->getSpeed();
        if ($speed >= 99)
            return "Excellent";
        else if ($speed >= 98)
            return "Very Good";
        else if ($speed >= 94)
            return "Good";
        else if ($speed > 90)
            return "Fair";
        else if ($speed > 80)
            return "Bad";
        else if ($speed > 70)
            return "Very Bad";
        else if ($speed > 30)
            return "Weak";
        else
            return "Not Stable";
    }
}
