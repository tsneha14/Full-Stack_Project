<?php

$firstName = "";
$lastName = "";
$email = "";
$city = "";
$mobile = "";
$state = "";
$password = "";
$hashed_password = "";
$stateList = array('AL', 'AK', 'AS', 'AZ', 'AR', 'CA', 'CO', 'CT', 'DE', 'DC', 'FM', 'FL', 'GA',
 'GU', 'HI', 'ID', 'IL', 'IN', 'IA', 'KS', 'KY', 'LA', 'ME', 'MH', 'MD', 'MA', 'MI', 'MN', 'MS',
 'MO', 'MT', 'NE', 'NV', 'NH', 'NJ', 'NM', 'NY', 'NC', 'ND', 'MP', 'OH', 'OK', 'OR', 'PW', 'PA',
 'PR', 'RI', 'SC', 'SD', 'TN', 'TX', 'UT', 'VT', 'VI', 'VA', 'WA', 'WV', 'WI', 'WY');
$flag = true;

// Validating firstname
if (isset($_POST['firstName'])) {
    $firstName = $_POST['firstName'];
    if (!preg_match("/^[a-zA-Z'\s]{3,8}$/", $firstName)) {
        $flag = false;
        echo "please enter a valid first name";
        return;
    }
}
// Validating lastname
if (isset($_POST['lastName'])) {
    $lastName = $_POST['lastName'];
    if (!preg_match("/^[a-zA-Z'\s]{3,8}$/", $lastName)) {
        $flag = false;
        echo "please enter a valid last name";
        return;
    }
}

// Validating email
if (isset($_POST['email'])) {
    $email = $_POST['email'];
    if (!preg_match("/^[a-zA-Z][a-zA-Z0-9_.'\-]*@[a-zA-Z]+(.[a-zA-Z]+){1,2}$/", $email)) {
        $flag = false;
        echo "please enter a valid email";
        return;
    }
}

// Validating mobile
if (isset($_POST['mobile'])) {
    $mobile = $_POST['mobile'];
    if (!preg_match("/^\d{3}-\d{3}-\d{4}$/", $mobile)) {
        $flag = false;
        echo "please enter a valid mobile number in the format xxx-xxx-xxxx";
        return;
    }
    $mobile = (int) preg_replace("/\D/", "", $mobile);
}

if (isset($_POST['city'])) {
    $city = $_POST['city'];
}

// Validating state
if (isset($_POST['state'])) {
    $state = $_POST['state'];
    if (!in_array($state,$stateList)) {
        $flag = false;
        echo "Please enter valid postal state abbreviation";
        return;
    }
}

// Validating password
if (isset($_POST['password'])) {
    $password = $_POST['password'];
    if (!preg_match("/^[a-zA-Z][a-zA-Z0-9]{5,}$/", $password)) {
        $flag = false;
        echo "please enter a valid password";
        return;
    }
}

// Hashing the password
if ($flag) {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "projectdb";
    // Create connection
    $conn = new mysqli($servername, $username, $password);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    

    // Create database
    $database_sql = "CREATE DATABASE IF NOT EXISTS projectdb";
    // Create table if not exists
    $tableName = "projecttable";
    $table_sql = "CREATE TABLE IF NOT EXISTS $tableName (
        id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        firstName VARCHAR(255) NOT NULL,
        lastName VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        mobile BIGINT(20) NOT NULL,
        city VARCHAR(255) NOT NULL,
        state VARCHAR(255) NOT NULL,
        password VARCHAR(255) NOT NULL
        )";
    if ($conn->query($database_sql) === TRUE) {
        // Select database
        if (!$conn->select_db($dbname)) {
            echo "Database selection Error: " . $sql . "<br>" . $conn->error;
        }
        // Inserting into the database
        if ($conn->query($table_sql) === TRUE) {
            $sql = "INSERT INTO projecttable(firstname, lastname, email,mobile,city,state,password)
            VALUES ('$firstName','$lastName','$email',$mobile,'$city','$state','$hashed_password')";
            if ($conn->query($sql) === TRUE) {
                echo "Registration completed, thank you";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

        } else {
            echo "Error creating table: " . $conn->error;
        }
    } else {
        echo "Error creating database: " . $conn->error;
    }

    
    $conn->close();
}
