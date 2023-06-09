<?php
$database = 'rksclg';
$host = 'localhost';
$user = 'root';
$pass = '';
$port = '3307';
// try to conncet to database
$con = mysqli_connect($host,$user,$pass,$database,$port);
function proper_date($d1)
{
    global $con;
    $sql = "SELECT DATE_FORMAT('$d1', \"%d/%m/%Y\") as dd";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    $date = $row["dd"];
    return $date;
}

// escape string
function e($val)
{
    global $con;
    return mysqli_real_escape_string($con, trim($val));
}

function fetchFrom($table,$id)
{
    global $con;
    $id=(int)$id;
    $query = "SELECT * FROM ".$table." WHERE id=".$id;        
    $result = mysqli_query($con,$query) or die(mysqli_error($con));
    $row = mysqli_fetch_array($result);                       
    return $row;
}

function fetchName($id)
{
    global $con;
    $id=(int)$id;
    $query = "SELECT fullName FROM users WHERE id=".$id;        
    $result = mysqli_query($con,$query) or die(mysqli_error($con));
    $row = mysqli_fetch_array($result);                       
    return $row['fullName'];
}

function myDateFormat($dateTime,$format)
{
    $myDate = "";
    if(!is_null($dateTime)) {
        $log = date_create($dateTime);
        $myDate = date_format($log,$format);        
    }
    return $myDate;
}
