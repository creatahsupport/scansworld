<?php
include("../includes/config.php"); 

$id = intval($_POST["id"]);

// Fetch existing record for image reference
$current_query = "SELECT * FROM doctors WHERE id = $id AND del_i = 0";
$current_result = mysqli_query($con, $current_query);
$ab = mysqli_fetch_assoc($current_result);

if (!$ab) {
    echo "<script>alert('Invalid doctor record.');</script>";
    echo "<script>window.location.href = 'doctor.php';</script>";
    exit();
}

// ========== Function to Generate SEO Slug ==========
function generateSlug($string) {
    $slug = strtolower(trim($string));
    $slug = preg_replace('/[^a-z0-9]+/i', '-', $slug);
    return trim($slug, '-');
}

// ========== Collect Form Data ==========
$doctor_name     = mysqli_real_escape_string($con, $_POST['doctor_name']);
$doctor_slug     = generateSlug($doctor_name);
$doctor_studies  = mysqli_real_escape_string($con, $_POST['doctor_studies']);
$image_title     = mysqli_real_escape_string($con, $_POST['image_title']);
$image_alt_tag   = mysqli_real_escape_string($con, $_POST['image_alttag']);
$doctor_content  = mysqli_real_escape_string($con, $_POST['doctor_content']);
$user_id         = mysqli_real_escape_string($con, $_POST['user_id']);
$status          = intval($_POST['status']);
$update_date     = date("Y-m-d H:i:s");

$file_name = $ab['doctor_image']; // keep old image if not replaced

// ========== Handle Image Upload ==========
if (isset($_FILES['doctor_photo']) && $_FILES['doctor_photo']['error'] == UPLOAD_ERR_OK) {
    $errors = [];

    $file_name = $_FILES['doctor_photo']['name'];
    $file_size = $_FILES['doctor_photo']['size'];
    $file_tmp  = $_FILES['doctor_photo']['tmp_name'];
    $file_ext  = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    $allowed_extensions = ["png", "webp"];

    if (!in_array($file_ext, $allowed_extensions)) {
        $errors[] = "Only PNG and WebP files are allowed.";
    }

    if ($file_size > 2097152) { // 2MB
        $errors[] = "File size must not exceed 2 MB.";
    }

    if (empty($errors)) {
        $destination_dir = "../uploads/doctor_images/";
        if (!is_dir($destination_dir)) {
            mkdir($destination_dir, 0777, true);
        }

        $destination_path = $destination_dir . $file_name;

        if (move_uploaded_file($file_tmp, $destination_path)) {
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
            echo "<script>alert('Failed to upload the image.');</script>";
            echo "<script>window.history.back();</script>";
            exit();
        }
    } else {
        echo "<script>alert('" . implode(' ', $errors) . "');</script>";
        echo "<script>window.history.back();</script>";
        exit();
    }
}

// ========== Update Query (Cleaned) ==========
$query = "
    UPDATE doctors 
    SET 
        slug = '$doctor_slug',
        doctor_name = '$doctor_name',
        doctor_studies = '$doctor_studies',
        image_title = '$image_title',
        image_alttag = '$image_alt_tag',
        doctor_content = '$doctor_content',
        doctor_image = '$file_name',
        status = '$status',
        user_id = '$user_id',
        update_date = '$update_date'
    WHERE id = $id
";

$result = mysqli_query($con, $query);

// ========== Response ==========
if ($result) {
    echo "<script>alert('Doctor details updated successfully.');</script>";
    echo "<script>window.location.href = 'doctor.php';</script>";
} else {
    echo "<script>alert('Failed to update doctor details. Please try again.');</script>";
}

mysqli_close($con);
?>
