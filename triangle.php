<?php 

// Triangle Porgram.  
$a = 7;  
$b = 10; 
$c = 5; 

if (checkValidity($a, $b, $c)){
	echo "Valid Triangle"; 
} else{
	echo "Invalid Triangle"; 
} 

function checkValidity($a, $b, $c) 
{ 
    if ($a + $b <= $c || $a + $c <= $b || $b + $c <= $a){
        return false; 
	}else{
        return true; 
	} 
} 

?>