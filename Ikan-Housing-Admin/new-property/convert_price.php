<?php
include('../../config.php');
function convertPrice($price){
    $price = strtolower(trim($price));

    if(strpos($price,'cr') !==false){
        return (float)$price * 10000000 ;
    }
    if(strpos($price,'lac') !== false || strpos($price,'lakh') !== false){
        return (float)$price * 100000;
    }
    return (int)$price;
}

$q=mysqli_query($con, "SELECT id ,min_price,max_price FROM new_property");

while($row=mysqli_fetch_assoc($q)){
    $min = convertPrice($row['min_price']);
    $max = convertPrice($row['max_price']);

    mysqli_query($con , "UPDATE new_property SET max_price_int='$max' , min_price_int='$min' WHERE id='{$row['id']}'");
}

echo "Price convertion done";
?>