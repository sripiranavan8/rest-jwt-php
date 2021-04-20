<?php
use \Firebase\JWT\JWT;

class Api extends Rest{
        public function __construct() {
			parent::__construct();
		}

        public function generateToken(){
            if($_SERVER['REQUEST_METHOD'] !== 'POST'){
                $this->throwError(REQUEST_METHOD_NOT_VALID,"Request Method is not valid");
            }
            $email = $this->validateParameter('email',$this->parameters['email'],STRING);
            $password = $this->validateParameter('password',$this->parameters['password'],STRING);
            try {
                $stmt = $this->dbConn->prepare("SELECT * FROM users WHERE email=:email AND password = :password");
                $stmt->bindParam(":email",$email);
                $stmt->bindParam(":password",$password);
                $stmt->execute();
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                if (!is_array($user)) {
                    $this->returnResponse(INVALID_USER_PASS,"Email or Password is Incorrect.");
                }

                if ($user['active'] == 0) {
                    $this->returnResponse(USER_NOT_ACTIVE,"User is not activated. Please contact to admin.");
                }

                $payload = [
                    'iat' =>time(),
                    'iss' =>'localhost',
                    'exp' => time() +(15*60),
                    'userId' => $user['id']
                ];
                $token = JWT::encode($payload,SECRETE_KEY);
                
                $data = ['token' => $token];
                $this->returnResponse(SUCCESS_RESPONSE,$data);
            } catch (Exception $e) {
                $this->throwError(JWT_PROCESSING_ERROR,$e->getMessage());
            }
        }

        public function addCustomer(){
            if($_SERVER['REQUEST_METHOD'] !== 'POST'){
                $this->throwError(REQUEST_METHOD_NOT_VALID,"Request Method is not valid");
            }
            $name = $this->validateParameter('name',$this->parameters['name'],STRING, false);
            $email = $this->validateParameter('email',$this->parameters['email'],STRING, false);
            $address = $this->validateParameter('address',$this->parameters['address'],STRING, false);
            $mobile = $this->validateParameter('mobile',$this->parameters['mobile'],STRING, false);

            $customer = new Customer;
            $customer->setName($name);
            $customer->setEmail($email);
            $customer->setAddress($address);
            $customer->setMobile($mobile);
            $customer->setCreatedBy($this->userId);
            $customer->setCreatedOn(date('Y-m-d'));
            if(!$customer->insert()){
                $message = "Failed to insert.";
            } else {
                $message = "Inserted successfully.";
            }
            $this->returnResponse(SUCCESS_RESPONSE,$message);
        }

        public function updateCustomer(){
            if($_SERVER['REQUEST_METHOD'] !== 'PUT'){
                $this->throwError(REQUEST_METHOD_NOT_VALID,"Request Method is not valid");
            }
            $customerId = $this->validateParameter('customerId',$this->parameters['customerId'],INTEGER);
            $name = $this->validateParameter('name',$this->parameters['name'],STRING, false);
            $address = $this->validateParameter('address',$this->parameters['address'],STRING, false);
            $mobile = $this->validateParameter('mobile',$this->parameters['mobile'],STRING, false);

            $customer = new Customer;
            $customer->setId($customerId);
            $customer->setName($name);
            $customer->setAddress($address);
            $customer->setMobile($mobile);
            $customer->setUpdatedBy($this->userId);
            $customer->setUpdatedOn(date('Y-m-d'));
            if(!$customer->update()){
                $message = "Failed to update.";
            } else {
                $message = "Updated successfully.";
            }
            $this->returnResponse(SUCCESS_RESPONSE,$message);
        }

        public function getCustomerDetails(){
            if($_SERVER['REQUEST_METHOD'] !== 'GET'){
                $this->throwError(REQUEST_METHOD_NOT_VALID,"Request Method is not valid");
            }
            $customerId = $this->validateParameter('customerId',$this->parameters['customerId'],INTEGER);

            $customer = new Customer;
            $customer->setId($customerId);
            $resultCustomer = $customer->getCustomerDetailsById();
            if (!is_array($resultCustomer)) {
                $this->returnResponse(SUCCESS_RESPONSE,['message' =>'Customer details are not in our database.']);
            }
            $response = array();
            $response['id'] = $resultCustomer['id']; 
            $response['name'] = $resultCustomer['name']; 
            $response['email'] = $resultCustomer['email']; 
            $response['address'] = $resultCustomer['address']; 
            $response['mobile'] = $resultCustomer['mobile']; 
            $response['updated_user'] = $resultCustomer['updated_user'];
            $response['updated_on'] = $resultCustomer['updated_on'];
            $response['created_user'] = $resultCustomer['created_user'];
            $response['created_on'] = $resultCustomer['created_on'];
            $this->returnResponse(SUCCESS_RESPONSE,$response);
        }

        public function deleteCustomer(){
            if($_SERVER['REQUEST_METHOD'] !== 'DELETE'){
                $this->throwError(REQUEST_METHOD_NOT_VALID,"Request Method is not valid");
            }
            $customerId = $this->validateParameter('customerId',$this->parameters['customerId'],INTEGER);
            $customer = new Customer;
            $customer->setId($customerId);
            if(!$customer->delete()){
                $message = "Failed to delete.";
            } else {
                $message = "Deleted successfully.";
            }
            $this->returnResponse(SUCCESS_RESPONSE,$message);
        }

        public function getAllCustomers(){
            if($_SERVER['REQUEST_METHOD'] !== 'GET'){
                $this->throwError(REQUEST_METHOD_NOT_VALID,"Request Method is not valid");
            }
            $customer = new Customer;
            if (!$customers = $customer->getAllCustomers()) {
                $message = "Failed to fetch customers.";
            } else {
                $message = $customers;
            }
            $this->returnResponse(SUCCESS_RESPONSE,$message);
        }
    }
?>