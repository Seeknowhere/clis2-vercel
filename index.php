<?php 
    include_once($_SERVER['DOCUMENT_ROOT'].'/clis/root/header_footer.php');
?>
<?php 
    header("Location: ".root_url()."system/login");


    // this an associative array (non-object)
    // SETTERS of associative array;
    // array() is a reserved word in PHP
    // Reserved word is a word in a programming language which has a fixed meaning and cannot be redefined by the programmer. 
    // - Wikipedia

    // $array = array(
    //     "Name" => "Joseph Mark Anthony Huelgas",
    //     "Age" => 22,
    //     "Email"=> "huelgasjcowork@gmail.com" 
    // );
    
    // $object = (object)$array; //Convert from associative array to object.
    // //Accessing the value by index key
    // //Index key can be redefined or generated.
    
    // echo $object->Name;

?>

