<?php
include("includes/config.php");

// Fetch desktop banners
$desktop_banner = "SELECT * FROM banner WHERE del_i=0 AND image_type='desktop' ORDER BY order_id ASC";
$desktop_result = mysqli_query($con, $desktop_banner);
$desktop_banners = mysqli_fetch_all($desktop_result, MYSQLI_ASSOC);

// Fetch mobile banners
$mobile_banner = "SELECT * FROM banner WHERE del_i=0 AND image_type='mobile' ORDER BY order_id ASC";
$mobile_result = mysqli_query($con, $mobile_banner);
$mobile_banners = mysqli_fetch_all($mobile_result, MYSQLI_ASSOC);
?>

<!-- ================= Desktop Carousel ================= -->
<div id="carouselDesktop" class="carousel slide d-none d-md-block" data-bs-ride="carousel">
    <?php if (!empty($desktop_banners)) { ?>
        <!-- Indicators -->
        <div class="carousel-indicators">
            <?php foreach ($desktop_banners as $i => $row) { ?>
                <button type="button" data-bs-target="#carouselDesktop" data-bs-slide-to="<?php echo $i; ?>"
                    class="<?php echo ($i === 0) ? 'active' : ''; ?>"
                    aria-current="<?php echo ($i === 0) ? 'true' : 'false'; ?>"
                    aria-label="Slide <?php echo $i + 1; ?>"></button>
            <?php } ?>
        </div>

        <!-- Carousel Items -->
        <div class="carousel-inner">
            <?php foreach ($desktop_banners as $i => $row) { ?>
                <div class="carousel-item <?php echo ($i === 0) ? 'active' : ''; ?>">
                    <img src="<?php echo $url_config; ?>/uploads/banner/<?php echo $row["image"]; ?>"
                         class="d-block w-100"
                         alt="<?php echo htmlspecialchars($row["image_alt"]); ?>"
                         title="<?php echo htmlspecialchars($row["image_title"]); ?>">
                </div>
            <?php } ?>
        </div>

        <!-- Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselDesktop" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselDesktop" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
            <span class="visually-hidden">Next</span>
        </button>
    <?php } ?>
</div>

<!-- ================= Mobile Carousel ================= -->
<div id="carouselMobile" class="carousel slide d-block d-md-none" data-bs-ride="carousel">
    <?php if (!empty($mobile_banners)) { ?>
        <!-- Indicators -->
        <div class="carousel-indicators">
            <?php foreach ($mobile_banners as $i => $row) { ?>
                <button type="button" data-bs-target="#carouselMobile" data-bs-slide-to="<?php echo $i; ?>"
                    class="<?php echo ($i === 0) ? 'active' : ''; ?>"
                    aria-current="<?php echo ($i === 0) ? 'true' : 'false'; ?>"
                    aria-label="Slide <?php echo $i + 1; ?>"></button>
            <?php } ?>
        </div>

        <!-- Carousel Items -->
        <div class="carousel-inner">
            <?php foreach ($mobile_banners as $i => $row) { ?>
                <div class="carousel-item <?php echo ($i === 0) ? 'active' : ''; ?>">
                    <img src="<?php echo $url_config; ?>/uploads/banner/<?php echo $row["image"]; ?>"
                         class="d-block w-100"
                         alt="<?php echo htmlspecialchars($row["image_alt"]); ?>"
                         title="<?php echo htmlspecialchars($row["image_title"]); ?>">
                </div>
            <?php } ?>
        </div>

        <!-- Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselMobile" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselMobile" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
            <span class="visually-hidden">Next</span>
        </button>
    <?php } ?>
</div>

<!-- ================= Custom CSS ================= -->
<style>
/* --- Indicators --- */
.carousel-indicators [data-bs-target] {
    width: 40px;
    height: 6px;
    margin: 8px;
    border-radius: 10px;
    background-color: #fff;
}
.carousel-indicators .active {
    background-color: #0079c0;
}

/* Mobile indicators: dots */
@media (max-width: 767px) {
    #carouselMobile .carousel-indicators [data-bs-target] {
        width: 10px;
        height: 10px;
        border-radius: 50%;
    }
}

/* --- Controls (arrows) --- */
.carousel-control-prev-icon,
.carousel-control-next-icon {
    background-image: none !important;
}
.carousel-control-prev-icon::after {
    content: "⟨";
    font-size: 2rem;
    color: #0079c0;
}
.carousel-control-next-icon::after {
    content: "⟩";
    font-size: 2rem;
    color: #0079c0;
}
</style>
