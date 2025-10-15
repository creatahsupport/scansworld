<section class="ttm-row only_title-section ttm-bgcolor-darkgrey ttm-bgimage-yes bg-img4 ttm-bg clearfix">
        <div class="ttm-row-wrapper-bg-layer ttm-bg-layer"></div>
        <div class="container">
          <div class="row">
            <div class="col-lg-12">
              <div class="section-title title-style-center_text">
                <div class="title-header">
                  <h3>Testimonials</h3>
                  <h2 class="title">What Our Patients Say!</h2>
                </div>
                <div class="heading-seperator"><span></span></div>
                <div class="title-desc">
                  <p>I felt truly cared for at Scans World. The staff was incredibly kind, and they expertly handled my eye treatment, making the experience comforting.</p>
                </div>
              </div>
              <div class="padding_bottom60 res-991-padding_bottom0"></div>
            </div>
          </div>
        </div>
      </section>
<section class="ttm-row top_zero_padding-section mt_130 res-991-margin_top50 clearfix">
        <div class="container">

          <div class="row">
            <?php if (!empty($latest_testimonial)) { ?>
            <?php foreach ($latest_testimonial as $testimonial) { ?>
            <div class="col-lg-4 col-md-6 mb-4">
              <div class="testimonials ttm-testimonial-box-view-style1">
                <div class="testimonial-content">
                  <div class="d-flex align-items-center">
                    <div class="testimonial-avatar">
                      <div class="testimonial-img">
                        <img class="img-fluid" src="<?php echo $url_config ?>/images/testimonial/avatar.png" alt="testimonial-img">
                      </div>
                    </div>
                    <div class="testimonial-caption">
                      <h3><?php echo htmlspecialchars($testimonial["title"]); ?></h3>
                    </div>
                  </div>
                  <div class="ttm-border-line"></div>
                  <div class="star-ratings" style="color: #e8c433;">
                    <?php echo htmlspecialchars($testimonial['review']); ?>
                  </div>
                  <blockquote><?php echo htmlspecialchars($testimonial['content']); ?></blockquote>
                </div>
              </div>
            </div>
            <?php } ?>
            <?php } else { ?>
            <p class="text-center w-100">No testimonials available at the moment.</p>
            <?php } ?>
          </div>
        </div>
      </section>