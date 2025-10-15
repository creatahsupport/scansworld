<?php 
 include("../includes/config.php"); 
 include_once("include/header.php");
 $banners_query = "SELECT * FROM banner WHERE del_i=0 and image_type='desktop' ORDER BY order_id ASC";
$banners_result = mysqli_query($con, $banners_query);
$mobile_banners_query = "SELECT * FROM banner WHERE del_i=0 and image_type='mobile' ORDER BY order_id ASC";
$mobile_banners_result = mysqli_query($con, $mobile_banners_query);
?>
<!doctype html>
<html lang="en">
<title>Banner Order Change | Scans World</title>
<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Scans World"/>
    <meta name="author" content="Scans World" />
    <link rel="icon" href="<?php echo $favicon; ?>" type="image/x-icon" />
    <link rel="stylesheet" href="assets/css/plugins/dropzone.min.css" />
    <link href="../../../../cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/monokai-sublime.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/plugins/quill.core.css" />
    <link rel="stylesheet" href="assets/css/plugins/quill.snow.css" />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600;700&amp;display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="assets/fonts/phosphor/duotone/style.css" />
    <link rel="stylesheet" href="assets/fonts/tabler-icons.min.css" />
    <link rel="stylesheet" href="assets/fonts/feather.css" />
    <link rel="stylesheet" href="assets/fonts/fontawesome.css" />
    <link rel="stylesheet" href="assets/fonts/material.css" />
    <link rel="stylesheet" href="assets/css/style.css" id="main-style-link" />
    <link rel="stylesheet" href="assets/css/style-preset.css" />
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.2/classic/ckeditor.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
  <body data-pc-preset="preset-1" data-pc-sidebar-theme="light" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light">
<div class="loader-bg">
  <div class="loader-track">
    <div class="loader-fill"></div>
  </div>
</div>
<style>
    /* Banner List Styling */
#banner-list {
  list-style-type: none;
  padding: 0;
  margin: 0;
}

.banner-item {
  cursor: grab;
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 10px;
  padding: 15px;
  border: 1px solid #ddd;
  border-radius: 8px;
  background-color: #f9f9f9;
  transition: transform 0.3s ease-in-out;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.banner-item img {
  max-width: 100px;
  margin-right: 10px;
}

.banner-item:hover {
  background-color: #eef0f1;
}

.banner-item:active {
  cursor: grabbing;
}

.banner-item .order-id {
  font-size: 14px;
  color: #888;
}

/* Highlight the banner while dragging */
#banner-list .sortable-chosen {
  background-color: #f0f0f0;
  border-color: #bbb;
}

#banner-list .sortable-ghost {
  opacity: 0.4;
}

</style>
<?php include("include/sidebar.php") ?>
    <div class="pc-container">
      <div class="pc-content">
        <div class="page-header">
          <div class="page-block">
            <div class="row align-items-center">
              <div class="col-md-12">
                <ul class="breadcrumb">
                </ul>
              </div>
              <div class="col-md-12">
                <div class="page-header-title">
                  <h2 class="mb-0">Banner Order Change</h2>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
        <div class="col-sm-6">
          <div class="card">
          <div class="card-body">
            <h5>Drag and Drop Desktop Banners to Reorder</h5>
            <ul id="desktop-banner-list">
              <?php while ($banner = mysqli_fetch_assoc($banners_result)) { ?>
                <li data-id="<?php echo $banner['id']; ?>" class="banner-item">
                  <img src="<?php echo $url_config; ?>/uploads/banner/<?php echo $banner['image']; ?>" alt="banner image" width="100" />
                  <input type="hidden" name="order_id[]" value="<?php echo $banner['order_id']; ?>" />
                </li>
              <?php } ?>
            </ul>
          </div>
        </div>
        
      </div>
      <div class="col-sm-6">
        <div class="card">
          <div class="card-body">
            <h5>Drag and Drop Mobile Banners to Reorder</h5>
            <ul id="mobile-banner-list">
              <?php while ($banner = mysqli_fetch_assoc($mobile_banners_result)) { ?>
                <li data-id="<?php echo $banner['id']; ?>" class="banner-item">
                  <img src="<?php echo $url_config; ?>/uploads/banner/<?php echo $banner['image']; ?>" alt="banner image" width="100" />
                  <input type="hidden" name="order_id[]" value="<?php echo $banner['order_id']; ?>" />
                </li>
              <?php } ?>
            </ul>
          </div>
        </div>
      </div>
</div>
      </div>
    </div>
    <?php include("include/footer.php");?>
    <script src="assets/js/plugins/simple-datatables.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// Initialize SortableJS for Desktop Banners
new Sortable(document.getElementById('desktop-banner-list'), {
  onEnd(evt) {
    let bannerIds = [];
    let orderIds = [];
    // Collect the new order of the desktop banners
    let items = document.querySelectorAll('#desktop-banner-list .banner-item');
    items.forEach((item, index) => {
      bannerIds.push(item.getAttribute('data-id'));
      orderIds.push(index + 1);  // Assign new order based on position in the list
    });

    // Send the new order to the server using AJAX
    updateBannerOrder(bannerIds, orderIds, 'desktop');
  }
});

// Initialize SortableJS for Mobile Banners
new Sortable(document.getElementById('mobile-banner-list'), {
  onEnd(evt) {
    let bannerIds = [];
    let orderIds = [];
    // Collect the new order of the mobile banners
    let items = document.querySelectorAll('#mobile-banner-list .banner-item');
    items.forEach((item, index) => {
      bannerIds.push(item.getAttribute('data-id'));
      orderIds.push(index + 1);  // Assign new order based on position in the list
    });

    // Send the new order to the server using AJAX
    updateBannerOrder(bannerIds, orderIds, 'mobile');
  }
});

function updateBannerOrder(bannerIds, orderIds, type) {
  const xhr = new XMLHttpRequest();
  xhr.open('POST', 'update_banner_order.php', true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  
  // Prepare the data to send
  let data = `banner_ids=${JSON.stringify(bannerIds)}&order_ids=${JSON.stringify(orderIds)}&type=${type}`;
  
  xhr.onload = function() {
    if (xhr.status === 200) {
      alert(type.charAt(0).toUpperCase() + type.slice(1) + ' banner order updated successfully!');
    } else {
      alert('Failed to update banner order');
    }
  };
  
  xhr.send(data);
}
</script>
<script src="assets/js/plugins/popper.min.js"></script>
<script src="assets/js/plugins/simplebar.min.js"></script>
<script src="assets/js/plugins/bootstrap.min.js"></script>
<script src="assets/js/fonts/custom-font.js"></script>
<script src="assets/js/pcoded.js"></script>
<script src="assets/js/plugins/feather.min.js"></script>
  </body>
</html>
