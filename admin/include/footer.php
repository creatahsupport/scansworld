
<?php 
include("../includes/config.php"); 
$sql = "SELECT * FROM settings WHERE del_i = 0 ORDER BY id DESC LIMIT 1";
$result = mysqli_query($con, $sql);
if ($result && mysqli_num_rows($result) > 0) {
    $settings = mysqli_fetch_assoc($result);
    $design_develop = htmlspecialchars($settings['design_develop']);
} 
?>
<footer class="pc-footer">
      <div class="footer-wrapper container-fluid">
        <div class="row">
          
          <div class="col-sm-6 my-1">
            <p class="m-0"> <?php echo $footer_text;  ?></a></p>
          </div>
          <div class="col-sm-6 my-1">
            <p class="m-0">Design And Develop By <b><?php echo $design_develop;  ?></b></a></p>
          </div>
         
        </div>
      </div>
    </footer> 