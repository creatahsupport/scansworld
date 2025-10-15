<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 10000; background: #0079c06e;">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <!-- <h2 class="sec-title mb-4">Our Expert - Details</h2> -->
        <span class="sub-title mb-0"><img src="assets/scan-world/icon.webp" alt="shape">Our Experts Details</span>
        <button type="button" class="btn text-danger" data-bs-dismiss="modal" aria-label="Close">
    <i class="fa fa-times"></i>
</button>



      </div>
      <div class="modal-body">
        <div class="row">
          <!-- Left side image -->
          <div class="col-md-4">
            <img id="doctor-image" src="" alt="Doctor Image" class="img-fluid">
          </div>
          <!-- Right side details -->
          <div class="col-md-8">
            <h3 id="doctor-name" class="box-title mt-0 mb-0"></h3>
            <p id="doctor-studies" class="box-desig"></p>
            <p id="doctor-content" class="mb-20"></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.doctor-detail').forEach(item => {
        item.addEventListener('click', function () {
            let name = this.getAttribute('data-name') || "No Name Available";
            let studies = this.getAttribute('data-studies') || "No Details Available";
            let image = this.getAttribute('data-image') || "assets/default-doctor.png";
            let content = this.getAttribute('data-content') || "No Description Available";

            document.getElementById('doctor-name').innerText = name;
            document.getElementById('doctor-studies').innerText = studies;
            document.getElementById('doctor-image').src = image;
            document.getElementById('doctor-content').innerHTML = content; // FIXED HERE
        });
    });
});

</script>
<style>
    .btn-close {
  color: red !important;
}
.btn-close:hover {
  color: darkred !important;
}
</style>
