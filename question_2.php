<?php
namespace SoftwareEngineerTest;


define("SILVER_CREDIT",1.05);
define("GOLD_CREDIT",1.10);
define("MAX_LENGTH_ID",10);

// Question 2 & 3 & 4

/**
 * Class Customer
 */
abstract class Customer {
	protected $id;
	protected $balance = 0;

	public function __construct($id) {

	    $this->id = $this->generate_username($id);
	}

	public function get_balance() {
		return $this->balance;
	}
	
	public function get_id() {
    return $this->id; 
  }
	/**
	 * Generates an alphanumeric string for id if that passed in only a single character
	 */      	
	private function generate_username($id) {
	  if(strlen($id) == 1) $id .= uniqid();
    return $id;
  }
	
	/**
	 * implement in descendants
	 */   	
  abstract public function deposit($amount);
}


// Write your code below
/**
 *
 * Bronze Customer 
 */  
class Bronze_Customer extends Customer {

 function __construct($id) {
    parent::__construct($id);
  }

 public function deposit($amount) {
   $this->balance += $amount;
 } 

}

/**
 *
 * Silver Customer 
 */  
class Silver_Customer extends Customer {

 function __construct($id) {
    parent::__construct($id);
  }

 public function deposit($amount) {
   $this->balance += ($amount*SILVER_CREDIT);
 } 

}

/**
 *
 * Gold Customer 
 */  
class Gold_Customer extends Customer {

 function __construct($id) {
    parent::__construct($id);
  }

 public function deposit($amount) {
   $this->balance += ($amount*GOLD_CREDIT);
 } 

}

/**
 *
 * Factory class to create customer based on id passed through
 * Question   
 *
 */   
class CustomerFactory {
  
  public static function get_instance($id) {
     $cust = null;
     $id = trim($id);
     $alphanumeric = ctype_alnum($id);
     $length = strlen($id);
     $firstChar = substr($id, 0, 1);

    if(($alphanumeric && $length > 0 &&  $length <= MAX_LENGTH_ID) && ($firstChar == 'B' || $firstChar == 'S' || $firstChar == 'G')) {        
       switch($firstChar) {
          case 'B':
            $cust = new Bronze_Customer($id); 
          break;
          case 'S':
            $cust = new Silver_Customer($id);
          break;
          case 'G':
            $cust = new Gold_Customer($id);
          break;          
       }
    }
    else {
      throw new \InvalidArgumentException('Incorrect id passed in, please ensure id is 1 to 30 alphanumeric characters in length and starts with either a \'B\' or \'S\' or \'G\'.');    
    }
    return $cust;
  }
}

/**
 * Q3 pass in id 
 */
$cust = CustomerFactory::get_instance('S234433');
$cust->deposit(45.3);
echo 'id is '.$cust->get_id().' customer balance is  '.$cust->get_balance();

/**
 * Q4 generate id 
 */
$cust = CustomerFactory::get_instance('G');
$cust->deposit(45.3);
echo 'id is '.$cust->get_id().' customer balance is  '.$cust->get_balance();








