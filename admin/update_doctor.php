<?php
include("../includes/config.php"); 

$id = intval($_POST["id"]);

$current_query = "SELECT * FROM doctors WHERE id=$id";
$current_result = mysqli_query($con, $current_query);
$ab = mysqli_fetch_assoc($current_result);

$doctor_name = mysqli_real_escape_string($con, $_POST['doctor_name']);
function generateSlug($string) {
    $slug = strtolower($string);
    $slug = preg_replace('/[^a-z0-9]+/i', '-', $slug);
    $slug = trim($slug, '-');
    return $slug;
}
$doctor_slug = generateSlug($doctor_name);
$doctor_studies = mysqli_real_escape_string($con, $_POST['doctor_studies']);
$image_title = mysqli_real_escape_string($con, $_POST['image_title']);
$image_alt_tag = mysqli_real_escape_string($con, $_POST['image_alttag']);
$doctor_content = mysqli_real_escape_string($con, $_POST['doctor_content']);
$doctor_publication = mysqli_real_escape_string($con, $_POST['doctor_publication']);
$branch_id = mysqli_real_escape_string($con, $_POST['branch_id']);
$user_id = mysqli_real_escape_string($con, $_POST['user_id']);
$status = intval($_POST['status']); 
$update_date = date("Y-m-d H:i:s");

$file_name = $ab['doctor_image'];

if (isset($_FILES['doctor_photo']) && $_FILES['doctor_photo']['error'] == UPLOAD_ERR_OK) {
    $errors = array();

    $file_name = $_FILES['doctor_photo']['name'];
    $file_size = $_FILES['doctor_photo']['size'];
    $file_tmp = $_FILES['doctor_photo']['tmp_name'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    
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

        if (move_uploaded_file($file_tmp, $destination_path)) {
            
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
            echo "<script>alert('Failed to upload the image.');</script>";
            echo "<script>window.history.back();</script>";
            exit();
        }
    } else {
        echo "<script>alert('" . implode(" ", $errors) . "');</script>";
        echo "<script>window.history.back();</script>";
        exit();
    }
}
$query2 = "UPDATE doctors SET  slug='$doctor_slug',doctor_name='$doctor_name', doctor_studies='$doctor_studies', image_title='$image_title', image_alttag='$image_alt_tag', 
doctor_content='$doctor_content', doctor_publication='$doctor_publication', status='$status', doctor_image='$file_name' ,user_id='$user_id',branch_id='$branch_id' WHERE id=$id";

$result2 = mysqli_query($con, $query2);

if ($result2) {
    echo "<script>alert('Doctor details updated successfully.');</script>";
    echo "<script>window.location.href = 'doctor.php';</script>";
    exit();
} else {
    echo "<script>alert('Failed to update Doctor details. Please try again.');</script>";
}

mysqli_close($con);
?>
