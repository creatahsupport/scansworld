<?php
include("../includes/config.php"); 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $page_url =$_POST['page_url'];
    $meta_title = $_POST['meta_title'];
    $meta_description = $_POST['meta_description'];
    $og_alt_tag = $_POST['og_alt_tag'];
    $og_type = $_POST['og_type'];
    $og_place_name = $_POST['og_place_name'];
    $og_country = $_POST['og_country'];
    $og_postal_code = $_POST['og_postal_code'];
    $icbm =$_POST['icbm'];
    $scheme = $_POST['scheme'];
    $author = $_POST['author'];
    $user_id = $_POST['user_id'];
    
    $og_image = $_FILES['og_image']['name'];
    $og_image_tmp = $_FILES['og_image']['tmp_name'];
    $upload_directory = '../uploads/seo/';

    if (move_uploaded_file($og_image_tmp, $upload_directory . $og_image)) {
        $og_description =$_POST['og_description'];
        $og_local = $_POST['og_local'];
        $og_title = $_POST['og_title'];
        $og_position = $_POST['og_position'];
        $og_region = $_POST['og_region'];
        $og_latitude = $_POST['og_latitude'];
        $og_langtitude = $_POST['og_langtitude'];
        $keywords = $_POST['keywords'];

        $sql = "INSERT INTO seo_management (page_url,meta_title, meta_description,og_alt_tag,og_type,og_place_name,og_country,og_postal_code,icbm,scheme,og_image, og_description, og_local, og_title, og_position, og_region,og_latitude,og_langtitude,keywords,author,user_id) VALUES ('$page_url','$meta_title','$meta_description','$og_alt_tag','$og_type','$og_place_name','$og_country','$og_postal_code','$icbm','$scheme','$og_image','$og_description','$og_local','$og_title','$og_position','$og_region','$og_latitude','$og_langtitude','$keywords','$author','$user_id')";
        if ($con->query($sql) === TRUE) {
            echo "<script>alert('Data added successfully.');</script>";
            echo "<script>window.location.href = 'seo.php';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $con->error;
        }
    } else {
        echo "Error uploading the image.";
    }
}

$con->close();
?>