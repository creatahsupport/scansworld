<?php
$current_page = basename($_SERVER['REQUEST_URI'], ".php"); // Get current page name
?>

<div class="col-xxl-4 col-lg-4">
    <aside class="sidebar-area sticky-sidebar">
        <div class="widget widget_categories">
            <h3 class="widget_title">Our Services</h3>
            <ul>
                <li class="<?= ($current_page == 'mri-scan') ? 'active' : ''; ?>">
                    <a href="mri-scan">3 Tesla MRI</a>
                </li>
                <li class="<?= ($current_page == 'pet-ct') ? 'active' : ''; ?>">
                    <a href="pet-ct">160 Slice Digital PET CT</a>
                </li>
                <li class="<?= ($current_page == '160-slice-cardiac-ct') ? 'active' : ''; ?>">
                    <a href="160-slice-cardiac-ct">160 Slice Cardiac CT</a>
                </li>
                <li class="<?= ($current_page == 'gamma-camera') ? 'active' : ''; ?>">
                    <a href="gamma-camera">Nuclear Scans / Gamma camera</a>
                </li>
                <li class="<?= ($current_page == 'multislice-ct-scan') ? 'active' : ''; ?>">
                    <a href="multislice-ct-scan">Multislice CT Scan</a>
                </li>
                <li class="<?= ($current_page == 'digital-mammography') ? 'active' : ''; ?>">
                    <a href="digital-mammography">Digital Mammography</a>
                </li>
                <li class="<?= ($current_page == 'color-doppler') ? 'active' : ''; ?>">
                    <a href="color-doppler">Color Doppler</a>
                </li>
                <li class="<?= ($current_page == 'echo') ? 'active' : ''; ?>">
                    <a href="echo">ECHO / ECG / Treadmill / Holter</a>
                </li>
                <li class="<?= ($current_page == 'eeg') ? 'active' : ''; ?>">
                    <a href="eeg">EEG / EMG / NCS / PFT</a>
                </li>
                <li class="<?= ($current_page == 'dexa') ? 'active' : ''; ?>">
                    <a href="dexa">Bone Mineral Densitometry / DEXA</a>
                </li>
                <li class="<?= ($current_page == 'digital-xray') ? 'active' : ''; ?>">
                    <a href="digital-xray">Digital X-Ray</a>
                </li>
                <li class="<?= ($current_page == 'opg') ? 'active' : ''; ?>">
                    <a href="opg">OPG</a>
                </li>
                <li class="<?= ($current_page == 'colonoscopy-and-endoscopy') ? 'active' : ''; ?>">
                    <a href="colonoscopy-and-endoscopy">Endoscopy / Colonoscopy</a>
         
                    <li class="<?= ($current_page == 'fnac') ? 'active' : ''; ?>">
                    <a href="fnac">Image-guided biopsy /FNAC / Drainage procedures</a>
                </li>
                      </li>
                    <li class="<?= ($current_page == 'automated-laboratory') ? 'active' : ''; ?>">
                    <a href="automated-laboratory">Automated Laboratory</a>
                </li>
              
            </ul>
        </div>
    </aside>
</div>

<!-- JavaScript Fallback for Active Class -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let currentPage = window.location.pathname.split("/").pop().replace(".php", ""); 
        let menuItems = document.querySelectorAll(".widget_categories ul li a");

        menuItems.forEach(item => {
            let href = item.getAttribute("href").replace(".php", ""); 
            if (href === currentPage) {
                item.parentElement.classList.add("active");
            }
        });
    });
</script>
<style>
    .widget_categories ul li.active a {
        color: #fff !important;
        background-color: #04ce78 !important;
    
    }
    .sticky-sidebar {
        position: sticky;
        top: 100px; /* Adjust based on your header height */
      
       
        overflow-y: auto; /* Enable scroll if necessary */
    }
</style>