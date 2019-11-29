<?php

if (!defined('ROISTAT_AB_AUTO_SUBMIT')) {
    @define('ROISTAT_AB_AUTO_SUBMIT', true);
}
 
class ABTest {

    const ROISTAT_AB_COOKIE = "roistat_ab";

    /**
     * @var array
     */
    private $_tests;
    
    private $ArrVariant = array('v0','v1','v2','v3','v4');

    /**
     * @var array
     */
    private $_testsCalculatedValues;

    private $_isSubmitted;

    private function __construct() {
        $this->_tests = require "./tests.php";
        if (!is_array($this->_tests)) {
            throw new Exception("Invalid data in tests.php. Expected array. " . var_export($this->_tests, true) . " given");
        }
        $this->_testsCalculatedValues = array();
        $this->_isSubmitted = false;
        if ($this->_userIsSeoBot() || count($this->_tests) === 0) {
            return;
        }
        foreach ($this->_tests as $testData) {
            if (!is_array($testData)) {
                throw new Exception("Test data '" . var_export($testData, true) . "' is not array");
            }
            $this->_initTest($testData);
        }
        if (ROISTAT_AB_AUTO_SUBMIT) {
            $this->submit();
        }
    }

    /**
     * @return self
     */
    public static function instance() {
        static $instance;
        if (is_null($instance)) {
            $instance = new self();
        }
        return $instance;
    }

    public function submit() {
        if ($this->_isSubmitted) {
            return;
        }
        $this->_isSubmitted = true;
        $this->_setRoistatCookie();
    }

    /**
     * @param string $testId
     */
    public function activateTest($testId) {
        foreach ($this->_tests as $index => $testData) {
            if ($testData['id'] !== $testId) {
                continue;
            }
            $this->_tests[$index]['active'] = true;
        }
    }

    /**
     * @param string $testId
     * @return string
     */
    public function getTestValue($testId) {
        $result = null;
        if (array_key_exists($testId, $this->_testsCalculatedValues)) {
            $result = $this->_testsCalculatedValues[$testId];
        } else {
            foreach ($this->_tests as $key=>$value) {
				
				if ($value['name'] == $testId) {
					$testId2 = $value['name'];
					break;
				}
				if ($value['id'] == $testId) {
					$testId2 = $value['name'];
					break;
				}
			}
            
            $result = $this->_getCookie($testId2);
        }
        return $result;
    }

    /**
     * @param array $testData
     */
    private function _initTest(array $testData) {
        
        $gettest = false;
        
        
        if ($_GET['abtest']) {
			
			$tmp = explode("||",$_GET['abtest']);
			$abtest_name = trim($tmp[0]);
			$abtest_v = trim($tmp[1]);
			
			foreach ($testData['variants'] as $variant)
				if ($variant['id'] == $abtest_v) {
					$gettest = true;
					break;
				}
		}
        
        if($abtest_name == $testData['name'] && in_array($abtest_v,$this->ArrVariant) && $gettest === true) {
        	$testValue = $abtest_v;
        }
        else {
        	$testCookie = $this->_getCookie($testData['name']);
	        if (!is_null($testCookie) && $this->_validTestCookie($testCookie, $testData)) {
	            return;
	        }
	        $userDefinedMethod = array_key_exists('method', $testData) && $testData['method'];
	        if ($userDefinedMethod) {
	            $methodName = $testData['method'];
	            $testValue = $this->$methodName($testData);
	        } else {
	            $testValue = $this->_calcRandomVariant($testData);
	        }
	    }
        $this->_setValue($testData['name'], $testValue);
    }

    /**
     * @param array $testData
     * @return string
     */
    private function _calcRandomVariant(array $testData) {
        $variantsIds = array();
        foreach ($testData['variants'] as $variantData) {
            $variantsIds[] = $variantData['id'];
        }
        $variantIndex = rand(0, count($variantsIds) - 1);
        return $variantsIds[$variantIndex];
    }

    /**
     * @param string $campaignId
     * @param string $variantId
     */
    private function _setValue($campaignId, $variantId) {
        $this->_testsCalculatedValues[$campaignId] = $variantId;
        $this->_setCookie($campaignId, $variantId);
    }

    /**
     * @param string $value
     * @param array $testData
     * @return bool
     */
    private function _validTestCookie($value, array $testData) {
        $result = false;
        foreach ($testData['variants'] as $variantData) {
            if ($value === $variantData['id']) {
                $result = true;
            }
        }
        return $result;
    }

    /**
     * @return bool
     */
    private function _userIsSeoBot() {
        if (!array_key_exists('HTTP_USER_AGENT', $_SERVER)) {
            return false;
        }
        $userAgent = strtolower($_SERVER['HTTP_USER_AGENT']);
        return @preg_match("#bot|crawl|slurp|spider#", $userAgent);
    }

    private function _setRoistatCookie() {
        $activeTests = $this->_getActiveTests();
        if (count($activeTests) === 0) {
            return;
        }
        $cookies = array();
        foreach ($activeTests as $testData) {
            $testId = $testData['name'];
            $testValue = $this->getTestValue($testId);
            $cookies[] = "{$testId}:{$testValue}";
        }
        $this->_setCookie(self::ROISTAT_AB_COOKIE, @implode(',', $cookies));
        //$this->writetxt (self::ROISTAT_AB_COOKIE, $this-> _getCookie(self::ROISTAT_AB_COOKIE));
    }

    /**
     * @return array
     */
    private function _getActiveTests() {
        $result = array();
        foreach ($this->_tests as $testData) {
            if (!array_key_exists('active', $testData) || $testData['active']) {
                $result[] = $testData;
            }
        }
        return $result;
    }

    /**
     * @param string $cookie
     * @return string
     */
    private function _getCookie($cookie) {
        //return array_key_exists($cookie, $_COOKIE) ? $_COOKIE[$cookie] : null;
        return $_SESSION[$cookie]?$_SESSION[$cookie]:(array_key_exists($cookie, $_COOKIE) ? $_COOKIE[$cookie] : null);
    }

    /**
     * @param string $cookie
     * @param string $value
     */
    private function _setCookie($cookie, $value) {
        setcookie($cookie, $value, time() + 3110400, '/' );
        $_SESSION[$cookie] = $value;
        //$this->writetxt ($cookie,$value);
    }
    
    function writetxt ($key,$val) {
		$f = fopen("ttt.txt","a+");
        fwrite($f,$key."=".$val."  ");
        fclose($f);
	}
}

ABTest::instance();