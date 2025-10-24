<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("../includes/config.php"); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // ====== Function to Generate SEO Slug ======
    function generateSlug($string) {
        $slug = strtolower(trim($string));
        $slug = preg_replace('/[^a-z0-9]+/i', '-', $slug);
        return trim($slug, '-');
    }

    // ====== Basic Form Data ======
    $doctor_name    = mysqli_real_escape_string($con, $_POST['doctor_name']);
    $doctor_slug    = generateSlug($doctor_name);
    $doctor_studies = mysqli_real_escape_string($con, $_POST['doctor_studies']);
    $user_id        = mysqli_real_escape_string($con, $_POST['user_id']);
    $image_title    = mysqli_real_escape_string($con, $_POST['image_title']);
    $image_alttag   = mysqli_real_escape_string($con, $_POST['image_alttag']);
    $doctor_content = mysqli_real_escape_string($con, $_POST['doctor_content']);
    $status         = (int)$_POST['status'];
    $created_date   = date("Y-m-d H:i:s");

    $file_name = '';

    // ====== Image Upload & Resize ======
    if (isset($_FILES['doctor_photo']) && $_FILES['doctor_photo']['name'] != '') {
        $errors = array();

        $file_name = $_FILES['doctor_photo']['name'];
        $file_size = $_FILES['doctor_photo']['size'];
        $file_tmp  = $_FILES['doctor_photo']['tmp_name'];
        $file_ext  = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        $allowed_extensions = array("png", "webp");

        if (!in_array($file_ext, $allowed_extensions)) {
            $errors[] = "Only PNG and WebP files are allowed.";
        }
        if ($file_size > 2097152) { // 2 MB limit
            $errors[] = "File size must not exceed 2 MB.";
        }

        if (empty($errors)) {
            $destination_dir = "../uploads/doctor_images/";
            if (!is_dir($destination_dir)) {
                mkdir($destination_dir, 0777, true);
            }

            $destination_path = $destination_dir . $file_name;
            move_uploaded_file($file_tmp, $destination_path);

            // Resize to 398x479
            list($width, $height) = getimagesize($destination_path);
            $new_width = 398;
            $new_height = 479;
            $image_p = imagecreatetruecolor($new_width, $new_height);

            if ($file_ext == "png") {
                $image = imagecreatefrompng($destination_path);
            } else {
                $image = imagecreatefromwebp($destination_path);
            }

            imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

            if ($file_ext == "png") {
                imagepng($image_p, $destination_path, 9);
            } else {
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

    // ====== Insert Doctor Data (no branch / publication) ======
    $query = "
        INSERT INTO doctors 
        (doctor_name, slug, doctor_studies, doctor_image, image_alttag, image_title, doctor_content, created_date, status, user_id) 
        VALUES 
        ('$doctor_name', '$doctor_slug', '$doctor_studies', '$file_name', '$image_alttag', '$image_title', '$doctor_content', '$created_date', '$status', '$user_id')
    ";

    $result = mysqli_query($con, $query);

    if ($result) {
        echo "<script>alert('Doctor details added successfully');</script>";
        echo "<script>setTimeout(function(){ window.location.href='doctor.php'; }, 1000);</script>";
    } else {
        echo "<script>alert('Failed to add Doctor details. Please try again.');</script>";
    }

} else {
    echo "<script>alert('Invalid request');</script>";
    echo "<script>location.href = 'doctor.php';</script>";
}
?>
