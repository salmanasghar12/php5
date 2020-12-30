<?php

   function isValidEmailFormat($email) {
     $email_regex = '/\A[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}\Z/i';
     return preg_match($email_regex, $email) === 1;
   }


   // isBlank('abcd')
  // * validate data presence
  // * uses trim() so empty spaces don't count
  // * uses === to avoid false positives
  // * better than empty() which considers "0" to be empty
  function isBlank($value) {
    return !isset($value) || trim($value) === '';
  }
  // hasPresence('abcd')
  // * validate data presence
  // * reverse of isBlank()
  // * more developer friendly name
  function hasPresence($value) {
    return !isBlank($value);
  }

  function isContainErrors($errorsArray)
  {
    return !empty($errorsArray);
  }




  // has_length_greater_than('abcd', 3)
    // * validate string length
    // * spaces count towards length
    // * use trim() if spaces should not count
    function has_length_greater_than($value, $min) {
      $length = strlen($value);
      return $length > $min;
    }

    // has_length_less_than('abcd', 5)
    // * validate string length
    // * spaces count towards length
    // * use trim() if spaces should not count
    function has_length_less_than($value, $max) {
      $length = strlen($value);
      return $length < $max;
    }

    // has_length_exactly('abcd', 4)
    // * validate string length
    // * spaces count towards length
    // * use trim() if spaces should not count
    function has_length_exactly($value, $exact) {
      $length = strlen($value);
      return $length == $exact;
    }

    // has_length('abcd', ['min' => 3, 'max' => 5])
    // * validate string length
    // * combines functions_greater_than, _less_than, _exactly
    // * spaces count towards length
    // * use trim() if spaces should not count
    function has_length($value, $options) {
      if(isset($options['min']) && !has_length_greater_than($value, $options['min'] - 1)) {
        return false;
      } elseif(isset($options['max']) && !has_length_less_than($value, $options['max'] + 1)) {
        return false;
      } elseif(isset($options['exact']) && !has_length_exactly($value, $options['exact'])) {
        return false;
      } else {
        return true;
      }
    }



?>
