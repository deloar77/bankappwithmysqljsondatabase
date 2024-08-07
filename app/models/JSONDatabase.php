<?php
namespace App\models;
use Exception;

use App\Models\Customer;
 require __DIR__.'/../../vendor/autoload.php';
class JSONDatabase{
    private $customers;
    private $data_file;
    private $transactions_file;
    private $data_path;
    private $transactions_path;

    public function __construct()
    {
        $config= require __DIR__.'/../../config/config.php';

       $this->data_file=$config['data_file'];
       $this->transactions_file=$config['transactions_file'];

       $this->data_path= __DIR__.'/../storage'.'/'.$this->data_file;
       $this->transactions_path=__DIR__.'/../storage'.'/'.$this->transactions_file;
       if(!file_exists($this->data_path) && !file_exists($this->transactions_path)){
          file_put_contents($this->data_path,'');
           file_put_contents($this->transactions_path,'');
       }
       
       
    }


    public function connect(){
     $this->customers=$this->loadData();

    }

  private  function loadData(){

    if(file_exists($this->data_path)){
      
        if(json_decode(file_get_contents($this->data_path),true)===null){
            return [];
        }else {
        return json_decode(file_get_contents($this->data_path),true);
    }
    } 
  }

   private function saveData(){
    file_put_contents($this->data_path,json_encode($this->customers));
   }

    private function loadTransactions(){

    if(file_exists($this->transactions_path)){
        return json_decode(file_get_contents($this->transactions_path),true);
    }else {
        return [];
    }

   }


   public function getAllCustomers(){
    return $this->customers;
   }



    public function logout()
    {  
       
        session_start();

        // Unset all session variables
        $_SESSION = [];

        // Destroy the session
        session_destroy();

        // Redirect to the login page or home page
       
        exit();
    }





    private function logTransaction($transaction){

         $transactions=$this->loadTransactions();
         $transactions[]=$transaction;
         file_put_contents($this->transactions_path,json_encode($transactions));
   }

//register customer starts here

    public function registerCustomer($customer){
         // Check if the email already exists
   if(empty($this->customers)){
        $customer = new Customer($customer['name'],$customer['email'],$customer['password']);
          $this->customers[]=(array)$customer;
          $this->saveData();
          $this->logTransaction(["type" => "register","sender_id"=>$customer->id, "recipient_id" => $customer->id,"amount"=>0, "created_at" => time()]);
   } else {
     foreach ($this->customers as $existingCustomer) {
        if ($existingCustomer['email'] !== $customer['email']) {
            $customer = new Customer($customer['name'],$customer['email'],$customer['password']);
          $this->customers[]=(array)$customer;
          $this->saveData();
          $this->logTransaction(["type" => "register","sender_id"=>$customer->id, "recipient_id" => $customer->id,"amount"=>0, "created_at" => time()]);
      } 
    }
   }
  }

  //register customer ends here

  //login customer starts here
   public function authenticate($email,$password){
      
            if(!empty($this->customers)){
               
              foreach($this->customers as $customer){
                 
         
                 if ($customer['email']===$email && $customer['password']==$password){
                      
                      return $customer;
                        } else{
                            return false;
                        }

                     }
               

                }
     
          }

  //login customer ends here
  //authenticate admin starts here
   public function authenticateadmin($email,$password){
      
            if(!empty($this->customers)){
               
              foreach($this->customers as $customer){
                 
         
                 if ($customer['email']===$email && $customer['password']==$password && $customer['is_Admin']){
                      
                      return $customer;
                        } else{
                            return false;
                        }

                     }
               

                }
     
          }
  //authenticate admin ends  here

  
   //getCustomer by id

    public function getCustomerById($customer_id){
    foreach($this->customers as $customer){
        if($customer['id']===$customer_id){
            return $customer;
        }
    }
    return null;
   }
   //get customer by id ends here

   //aprove customer starts here
    public function approveCustomer($customer_id){
    foreach($this->customers as &$customer){
        if($customer['id']===$customer_id){
            $customer['is_approved']=true;
            $this->saveData();
            $this->logTransaction(["type" => "approved","sender_id"=>$customer['id'], "recipient_id" => $customer['id'],"amount"=>0, "created_at" => time()]);
            return;
        }
    }
 }
 //approve customer ends here
// deposit function start here
    public function deposit($customer_id,$amount){
    foreach($this->customers as &$customer){
        if($customer['id']===$customer_id){
            if($customer['is_approved']){
                $customer['balance']+=$amount;
                $this->saveData();
               $this->logTransaction(["type" => "deposit","sender_id"=>$customer_id, "recipient_id" => $customer['id'],"amount"=>$amount, "created_at" => time()]);
                return;
            } else {
                return;
            }
        }
    }
 }

 //deposit function ens here

  //withdraw function starts here
  public function withdraw($customer_id,$amount){
    foreach($this->customers as &$customer){
        if($customer['id']===$customer_id){
            if($customer['is_approved']){
              
                if($customer['balance']>=$amount){
                    $customer['balance']-=$amount;
                    $this->saveData();
                     $this->logTransaction(["type" => "withdrawal","sender_id"=>$customer['id'], "recipient_id" => $customer_id,"amount"=>$amount, "created_at" => time()]);
                    return;
                }else{
                    return;
                }

            } else {
                return;
            }
        }
    }
  }

  //withdraw function ends here

//transfer starts here
  public function addTransaction($from_id,$to_email,$amount){
    $from_customer=null;
    $to_customer= null;

    foreach($this->customers as &$customer){
        if($customer['id']===$from_id){
            $from_customer=&$customer;
        }
        if($customer['email']===$to_email){
            $to_customer=&$customer;
        }
    }
    if($from_customer && $to_customer){
      if($from_customer['is_approved'] && $to_customer['is_approved']){
        if($from_customer['balance']>=$amount){
            $from_customer['balance']-=$amount;
            $to_customer['balance']+=$amount;
            $this->saveData();
            $this->logTransaction(["type" => "transfer","sender_id"=>$from_id, "recipient_id" => $to_customer['id'],"amount"=>$amount, "created_at" => time()]);
         
            return;
        } else {
            return;
        }
      }

    }


  }
  //transfer ends here



}











