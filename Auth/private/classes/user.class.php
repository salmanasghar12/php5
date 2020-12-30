<?php

class User
{
  private $id;
  private $firstName;
  private $lastName;
  private $userName;
  private $email;
  private $hashedPassword;
  private $phoneNumber;
  private $address;
  private $createdOn;
  private $isVerified;
  private $verifyingString;


  function __construct($args)
  {
    $this->setFirstName($args['firstName'] ?? '');
    $this->setLastName($args['lastName'] ?? '');
    $this->setUserName($args['userName'] ?? '');
    $this->setEmail($args['email'] ?? '');
    $this->setPassword($args['password'] ?? '');
    $this->setConfirmPassword($args['confirmPassword'] ?? '');
    $this->setPhoneNumber($args['phoneNumber'] ?? '');
    $this->setAddress($args['address'] ?? '');
    $this->setIsVerified(false);
  }



  /******** Setters
  **************************/
  private function setId($id)
  {
    $this->id = $id;
  }
  public function setFirstName($firstName='')
  {
    $this->firstName = $firstName;
  }
  public function setLastName($lastName='')
  {
    $this->lastName = $lastName;
  }
  public function setUserName($userName='')
  {
    $this->userName = $userName;
  }
  public function setEmail($email='')
  {
    $this->email = $email;
  }
  public function setPassword($password='')
  {
    $this->password = $password;
  }
  public function setConfirmPassword($confirmPassword='')
  {
    $this->confirmPassword = $confirmPassword;
  }
  public function setPhoneNumber($phoneNumber='')
  {
    $this->phoneNumber = $phoneNumber;
  }
  public function setAddress($address='')
  {
    $this->address = $address;
  }
  private function setIsVerified($isVerified = false)
  {
    $this->isVerified= $isVerified;
  }
  private function setVerificationString($string = '')
  {
    $this->verifyingString = $string;
  }



  /******** Getters
  **************************/
  public function getId()
  {
    return $this->id;
  }
  public function getFirstName()
  {
    return $this->firstName;
  }
  public function getLastName()
  {
    return $this->lastName;
  }
  public function getUserName()
  {
    return $this->userName;
  }
  public function getEmail()
  {
    return $this->email;
  }
  public function getPhoneNumber()
  {
    return $this->phoneNumber;
  }
  public function getPassword(){
    return $this->password;
  }
  public function getConfirmedPassword()
  {
    return $this->confirmPassword;
  }
  public function getAddress()
  {
    return $this->address;
  }
  public function isVerified()
  {
    return $this->isVerified;
  }



  /***** Other functions
  *****************************/
  private function validate(){
    $errors = [];

    if(!hasPresence($this->getFirstName())){
      $errors['firstName']='First name can\'t be blank';
    }elseif (!has_length($this->getFirstName(), array('min' => 2, 'max' => 30))) {
      $errors['firstName'] = "First name must be between 2 and 30 characters.";
    }

    if(!hasPresence($this->getLastName())){
      $errors['lastName']='Last name can\'t be blank';
    }elseif (!has_length($this->getLastName(), array('min' => 2, 'max' => 30))) {
      $errors['lastName'] = "Last name must be between 2 and 30 characters.";
    }


    if(!hasPresence($this->getUserName())) {
      $errors['userName'] = "Username cannot be blank.";
    } elseif (!has_length($this->getUserName(), array('min' => 8, 'max' => 40))) {
      $errors['userName'] = "Username must be between 8 and 40 characters.";
    }
    // TODO: implement functionality that check user already exist or not
    // elseif (!has_unique_username($this->getUserName(), $this->getId() ?? 0)) {
    //   $this->errors['userName'] = "Username not allowed. Try another.";
    // }

    if(!isValidEmailFormat($this->getEmail())){$errors['email']="Please enter a valid Email address";}
    // TODO: check if email is already exist or not




      if(!hasPresence($this->getPassword())) {
        $errors['password'] = "Password cannot be blank.";
      } elseif (!has_length($this->getPassword(), array('min' => 12))) {
        $errors['password'] = "Password must contain 12 or more characters";
      } elseif (!preg_match('/[A-Z]/', $this->getPassword())) {
        $errors['password'] = "Password must contain at least 1 uppercase letter";
      } elseif (!preg_match('/[a-z]/', $this->getPassword())) {
        $errors['password'] = "Password must contain at least 1 lowercase letter";
      } elseif (!preg_match('/[0-9]/', $this->getPassword())) {
        $errors['password'] = "Password must contain at least 1 number";
      } elseif (!preg_match('/[^A-Za-z0-9\s]/', $this->getPassword())) {
        $errors['password'] = "Password must contain at least 1 symbol";
      }

      if(!hasPresence($this->getConfirmedPassword())) {
        $errors['confirmPassword'] = "Confirm password cannot be blank.";
      } elseif ($this->getPassword() !== $this->getConfirmedPassword()) {
        $errors['confirmPassword'] = "Password and confirm password not match";
      }



    if(!hasPresence($this->getPhoneNumber())){$errors['phoneNumber']= 'Phone Number can\'t be blank';}
    elseif (!has_length($this->getPhoneNumber(), array('min' => 10))) {
      $errors['phoneNumber'] = "Please Enter a valid phone number";
    }
    if(!hasPresence($this->getAddress())){$errors['address']= 'Address can\'t be blank';}
    elseif (!has_length($this->getAddress(), array('min' => 20))) {
      $errors['address'] = "Please enter complete address";
    }

    return $errors;
  }




  private function create()
  {
      // first validate the data, if validation successfull then save data and return true
      // if validation fails, then return errors array
      $errorsArray = $this->validate();
      if(isContainErrors($errorsArray))
      {
        return $errorsArray;
      }else {
        exit("Now All the data is valid, it's time to Save Data to the database");
      }

  }

  public function save()
  {
    if(!hasPresence($this->getId()))
    {
      // exit("Yes id has no presence");
      return $this->create();
    }else {
      // update the data
    }
  }













  public function toString()
  {
    $returningString = "Name: ".$this->getFirstName()." ".$this->getLastName()."\n";
    $returningString .= "Username: ".$this->getUserName()."\n";
    $returningString .= "Email: ".$this->getEmail()."\n";
    $returningString .= "Phone: ".$this->getPhoneNumber()."\n";
    $returningString .= "Address: ".$this->getAddress()."\n";
    $returningString .= "Is Verified: ";
    $this->isVerified() ? $returningString.="Yes" : $returningString.="No" ."\n";
    return $returningString;
  }
}


 ?>
