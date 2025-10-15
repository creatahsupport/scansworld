<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("../includes/config.php"); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $doctor_name = $_POST['doctor_name'];
    function generateSlug($string) {
        $slug = strtolower($string);
        $slug = preg_replace('/[^a-z0-9]+/i', '-', $slug);
        $slug = trim($slug, '-');
        return $slug;
    }
    $doctor_slug = generateSlug($doctor_name);
    $doctor_studies = $_POST['doctor_studies'];
    $user_id = $_POST['user_id'];
    $image_title = $_POST['image_title'];
    $image_alttag = $_POST['image_alttag'];
    $doctor_content = $_POST['doctor_content'];
    $doctor_publication = $_POST['doctor_publication'];
    $branch_id = $_POST['branch_id'];
    $status = $_POST['status'];
    $created_date = date("Y-m-d H:i:s");

    $file_name = '';

    if (isset($_FILES['doctor_photo'])) {
        $errors = array();

        $file_name = $_FILES['doctor_photo']['name'];
        $file_size = $_FILES['doctor_photo']['size'];
        $file_tmp = $_FILES['doctor_photo']['tmp_name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        // Only allow png and webp
        $extensions = array("png", "webp");

        if (!in_array($file_ext, $extensions)) {
            $errors[] = "Only PNG and WebP files are allowed.";
        }

        if ($file_size > 2097152) {
            $errors[] = "File size must not exceed 2 MB.";
        }

        if (empty($errors)) {
         
            $destination_dir = "../uploads/doctor_images/";
            $destination_path = $destination_dir . $file_name;

            if (!is_dir($destination_dir)) {
                mkdir($destination_dir, 0777, true);
            }

            move_uploaded_file($file_tmp, $destination_path);

            list($width, $height) = getimagesize($destination_path);
            $new_width = 398;
            $new_height = 479;
            $image_p = imagecreatetruecolor($new_width, $new_height);

            if ($file_ext == "png") {
                $image = imagecreatefrompng($destination_path);
            } elseif ($file_ext == "webp") {
                $image = imagecreatefromwebp($destination_path);
            }

            imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

            if ($file_ext == "png") {
                imagepng($image_p, $destination_path, 9);
            } elseif ($file_ext == "webp") {
                imagewebp($image_p, $destination_path, 100);
            }

            imagedestroy($image_p);
            imagedestroy($image);
        } else {
            echo "<script>alert('" . implode(" ", $errors) . "');</script>";
            echo "<script>window.history.back();</script>";
            exit();
        }
    }

   
    $query1 = "INSERT INTO doctors (doctor_name,slug, doctor_studies, doctor_image, image_alttag, image_title, doctor_content, doctor_publication, created_date,status,user_id,branch_id) 
               VALUES ('$doctor_name','$doctor_slug', '$doctor_studies', '$file_name', '$image_alttag', '$image_title', '$doctor_content', '$doctor_publication', '$created_date','$status','$user_id','$branch_id')";

    $result1 = mysqli_query($con, $query1);

    if ($result1) {
        echo "<script>alert('Doctor details added successfully');</script>";
        echo "<script>window.setTimeout(function(){ window.location.href = 'doctor.php'; }, 1000);</script>";
    } else {
        echo "<script>alert('Failed to add Doctor details. Please try again.');</script>";
    }
} else {
    echo "<script>alert('Invalid request');</script>";
    echo "<script>location.href = 'doctor.php';</script>";
}
?>
