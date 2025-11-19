<?php
include("../includes/config.php"); 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Existing fields - only keep required for essential fields
    $page_url = $_POST['page_url'] ?? '';
    $meta_title = $_POST['meta_title'] ?? '';
    $meta_description = $_POST['meta_description'] ?? '';
    $og_alt_tag = $_POST['og_alt_tag'] ?? '';
    $og_type = $_POST['og_type'] ?? '';
    $og_place_name = $_POST['og_place_name'] ?? '';
    $og_country = $_POST['og_country'] ?? '';
    $og_postal_code = $_POST['og_postal_code'] ?? '';
    $icbm = $_POST['icbm'] ?? '';
    $scheme = $_POST['scheme'] ?? '';
    $author = $_POST['author'] ?? '';
    $user_id = $_POST['user_id'] ?? '';
    $og_description = $_POST['og_description'] ?? '';
    $og_local = $_POST['og_local'] ?? '';
    $og_title = $_POST['og_title'] ?? '';
    $og_position = $_POST['og_position'] ?? '';
    $og_region = $_POST['og_region'] ?? '';
    $og_latitude = $_POST['og_latitude'] ?? '';
    $og_langtitude = $_POST['og_langtitude'] ?? '';
    $keywords = $_POST['keywords'] ?? '';
    
    // New fields
   
   
    $publisher = $_POST['publisher'] ?? '';
    
    $twitter_title = $_POST['twitter_title'] ?? '';
    $twitter_description = $_POST['twitter_description'] ?? '';
    $twitter_site = $_POST['twitter_site'] ?? '';
    
    // Handle OG Image upload
    $og_image = $_FILES['og_image']['name'] ?? '';
    $og_image_tmp = $_FILES['og_image']['tmp_name'] ?? '';
    $upload_directory = '../uploads/seo/';
    
    // Handle Twitter Image upload
    $twitter_image = $_FILES['twitter_image']['name'] ?? '';
    $twitter_image_tmp = $_FILES['twitter_image']['tmp_name'] ?? '';
    
    $upload_success = true;
    $uploaded_images = [];
    
    // Upload OG Image (make it optional)
    if (!empty($og_image_tmp)) {
        if (move_uploaded_file($og_image_tmp, $upload_directory . $og_image)) {
            $uploaded_images['og_image'] = $og_image;
        } else {
            $upload_success = false;
            echo "Error uploading the OG image.";
        }
    } else {
        $uploaded_images['og_image'] = ''; // Allow empty OG image
    }
    
    // Upload Twitter Image (make it optional)
    if (!empty($twitter_image_tmp)) {
        if (move_uploaded_file($twitter_image_tmp, $upload_directory . $twitter_image)) {
            $uploaded_images['twitter_image'] = $twitter_image;
        } else {
            // Don't set upload_success to false for optional images
            $uploaded_images['twitter_image'] = '';
        }
    } else {
        $uploaded_images['twitter_image'] = ''; // Allow empty Twitter image
    }
    
    if ($upload_success) {
        // Escape all string values to prevent SQL injection
        $page_url = $con->real_escape_string($page_url);
        $meta_title = $con->real_escape_string($meta_title);
        $meta_description = $con->real_escape_string($meta_description);
        $og_alt_tag = $con->real_escape_string($og_alt_tag);
        $og_type = $con->real_escape_string($og_type);
        $og_place_name = $con->real_escape_string($og_place_name);
        $og_country = $con->real_escape_string($og_country);
        $og_postal_code = $con->real_escape_string($og_postal_code);
        $icbm = $con->real_escape_string($icbm);
        $scheme = $con->real_escape_string($scheme);
        $author = $con->real_escape_string($author);
        $user_id = $con->real_escape_string($user_id);
        $og_description = $con->real_escape_string($og_description);
        $og_local = $con->real_escape_string($og_local);
        $og_title = $con->real_escape_string($og_title);
        $og_position = $con->real_escape_string($og_position);
        $og_region = $con->real_escape_string($og_region);
        $og_latitude = $con->real_escape_string($og_latitude);
        $og_langtitude = $con->real_escape_string($og_langtitude);
        $keywords = $con->real_escape_string($keywords);
      
        $publisher = $con->real_escape_string($publisher);
        
        $twitter_title = $con->real_escape_string($twitter_title);
        $twitter_description = $con->real_escape_string($twitter_description);
        $twitter_site = $con->real_escape_string($twitter_site);
        $og_image_name = $con->real_escape_string($uploaded_images['og_image']);
        $twitter_image_name = $con->real_escape_string($uploaded_images['twitter_image']);
        
        $sql = "INSERT INTO seo_management (
            page_url, meta_title, meta_description, og_alt_tag, og_type, og_place_name, 
            og_country, og_postal_code, icbm, scheme, og_image, og_description, og_local, 
            og_title, og_position, og_region, og_latitude, og_langtitude, keywords, author, user_id,
             publisher,twitter_title, twitter_description, twitter_image, twitter_site
        ) VALUES (
            '$page_url', '$meta_title', '$meta_description', '$og_alt_tag', '$og_type', '$og_place_name',
            '$og_country', '$og_postal_code', '$icbm', '$scheme', '$og_image_name', '$og_description', '$og_local',
            '$og_title', '$og_position', '$og_region', '$og_latitude', '$og_langtitude', '$keywords', '$author', '$user_id',
             '$publisher', '$twitter_title', '$twitter_description', '$twitter_image_name', '$twitter_site'
        )";
        
        if ($con->query($sql) === TRUE) {
            echo "<script>alert('Data added successfully.');</script>";
            echo "<script>window.location.href = 'seo.php';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $con->error;
        }
    }
}

$con->close();
?>