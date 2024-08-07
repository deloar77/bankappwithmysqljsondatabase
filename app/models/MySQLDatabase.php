<?php
namespace App\models;
use mysqli;


class MySQLDatabase {

     private $mysqli;
     public function connect()
     {
        $config= require __DIR__.'/../../config/config.php';
         $this->mysqli =new mysqli($config['host'],$config['username'],$config['password'],$config['dbname']);
            if ($this->mysqli->connect_error) {
            die("Connection failed: " . $this->mysqli->connect_error);
        }

     }

       public function getAllCustomers()
    {
        $result = $this->mysqli->query("SELECT * FROM customers");
        return $result->fetch_all(MYSQLI_ASSOC);
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



        public function registerCustomer($customer)
    {
        $stmt = $this->mysqli->prepare("INSERT INTO customers (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $customer['name'], $customer['email'], $customer['password']);
        $stmt->execute();
        $stmt->close();
    }

    
    public function authenticate($email, $password) {
        $stmt = $this->mysqli->prepare("SELECT * FROM customers WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();

        if ($user &&  $user['password']===$password) {
            return $user;
        }
        return null;
    }
     public function authenticateadmin($email, $password) {
        $stmt = $this->mysqli->prepare("SELECT * FROM customers WHERE email = ? AND is_Admin=1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();

        if ($user &&  $user['password']===$password) {
            return $user;
        }
        return null;
    }

        public function getCustomerById($customer_id)
    {
        $stmt = $this->mysqli->prepare("SELECT * FROM customers WHERE id = ?");
        $stmt->bind_param("i", $customer_id);
         $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

         public function getCustomerByEmail($customer_email)
    {
        $stmt = $this->mysqli->prepare("SELECT * FROM customers WHERE email = ?");
        $stmt->bind_param("s", $customer_email);
         $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

     public function approveCustomer($customer_id){
          $customer = $this->getCustomerById($customer_id);
          if($customer){
            $customer['is_approved']=true;
            $stmt = $this->mysqli->prepare("UPDATE customers SET is_approved = ? WHERE id = ?");
            $stmt->bind_param("ii", $customer['is_approved'], $customer_id);
            $stmt->execute();
            $stmt->close();
          }
     }

    
    public function deposit($customer_id, $amount)
    {
        $customer = $this->getCustomerById($customer_id);
       
        if ($customer['is_approved']) {
            
            $newBalance = $customer['balance'] + $amount;
           
            $stmt = $this->mysqli->prepare("UPDATE customers SET balance = ? WHERE id = ?");
            $stmt->bind_param("di", $newBalance, $customer_id);
            $stmt->execute();
            $stmt->close();
            
            

            // Record transaction
            $stmt = $this->mysqli->prepare("INSERT INTO transactions (sender_id, recipient_id, amount, type, created_at) VALUES (?, ?, ?, ?, ?)");
            $timestamp = time();
            $datetime = date('Y-m-d H:i:s', $timestamp); 
            $type = 'deposit';
            $stmt->bind_param("iidss", $customer_id, $customer_id, $amount, $type, $datetime);
            $stmt->execute();
            $stmt->close();

            return true;
        }

        return false;
    }
   
    
    public function withdraw($customer_id, $amount)
    {
        $customer = $this->getCustomerById($customer_id);
        if($customer['is_approved']){
             if ($customer && $customer['balance'] >= $amount) {
            $newBalance = $customer['balance'] - $amount;
            $stmt = $this->mysqli->prepare("UPDATE customers SET balance = ? WHERE id = ?");
            $stmt->bind_param("di", $newBalance, $customer_id);
            $stmt->execute();
            $stmt->close();

             // Record transaction
            $stmt = $this->mysqli->prepare("INSERT INTO transactions (sender_id, recipient_id, amount, type, created_at) VALUES (?, ?, ?, ?, ?)");
            $timestamp = time();
            $datetime = date('Y-m-d H:i:s', $timestamp); 
            $type = 'withdrawal';
            $stmt->bind_param("iidss", $customer_id, $customer_id, $amount, $type, $datetime);
            $stmt->execute();
            $stmt->close();

            return true;
        }
        }

      

        return false;
    }


      public function getAllTransactions()
    {
        $result = $this->mysqli->query("SELECT * FROM transactions");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

     
    public function addTransaction($fromId, $toEmail, $amount)
    {
        $this->mysqli->begin_transaction();
       

        try {
            $fromCustomer = $this->getCustomerById($fromId);
            $toCustomer = $this->getCustomerByEmail($toEmail);
          

            if ($fromCustomer['is_approved'] && $toCustomer['is_approved'] && $fromCustomer['balance'] >= $amount) {
                // Deduct amount from sender
                $newFromBalance = $fromCustomer['balance'] - $amount;
                $stmt = $this->mysqli->prepare("UPDATE customers SET balance = ? WHERE id = ?");
                $stmt->bind_param("di", $newFromBalance, $fromId);
                $stmt->execute();
                $stmt->close();

                // Add amount to receiver
                $newToBalance = $toCustomer['balance'] + $amount;
                $stmt = $this->mysqli->prepare("UPDATE customers SET balance = ? WHERE email = ?");
                $stmt->bind_param("ds", $newToBalance, $toEmail);
                $stmt->execute();
                $stmt->close();

                  // Record transaction
            $stmt = $this->mysqli->prepare("INSERT INTO transactions (sender_id, recipient_id, amount, type, created_at) VALUES (?, ?, ?, ?, ?)");
            $timestamp = time();
            $datetime = date('Y-m-d H:i:s', $timestamp); 
            $type = 'transfer';
            $stmt->bind_param("iidss", $fromId, $toCustomer['id'], $amount, $type, $datetime);
            $stmt->execute();
            $stmt->close();

             $this->mysqli->commit();
                return true;
            } else {
                $this->mysqli->rollback();
                return false;
            }
        } catch (\Exception $e) {
            $this->mysqli->rollback();
            throw $e;
        }
    }





    }

   
   