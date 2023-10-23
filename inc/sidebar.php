 <!-- # Sidenav Left -->
 <div class="offcanvas offcanvas-start" id="affanOffcanvas" data-bs-scroll="true" tabindex="-1"
    aria-labelledby="affanOffcanvsLabel">

    <button class="btn-close btn-close-white text-reset" type="button" data-bs-dismiss="offcanvas"
      aria-label="Close"></button>

    <div class="offcanvas-body p-0">
      <div class="sidenav-wrapper">
        <!-- Sidenav Profile -->
        <div class="sidenav-profile bg-gradient">
          <div class="sidenav-style1"></div>

          <!-- User Thumbnail -->
          <div class="user-profile">
            <img src="admin/uploads/avatar/<?=$_SESSION['avatar']?>" alt="">
          </div>

          <!-- User Info -->
          <div class="user-info">
            <h6 class="user-name mb-0">
            <?php
            
            $account->id = $_SESSION['account_id'] ;
            $account->table = "accounts";
            $stmt = $account->showAllWhere('id',['id']);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            extract($row);
            $details=unserialize($row['details']);
            $details_opt=unserialize($row['details_opt']);
            print_r($details[0]['nome']);
            echo "&nbsp;";
            print_r($details[1]['cognome']);

            ?>            
            </h6>
            
          </div>
        </div>

        <!-- Sidenav Nav -->
        <ul class="sidenav-nav ps-0">
          <li>
            <a href="home.php"><i class="bi bi-house-door"></i> <?=$fe_side_home?></a>
          </li>

          <li>
            <a href="my-program.php"><i class="bi bi-clock"></i> <?=$fe_side_myprogram?></a>
          </li>

          <li>
            <a href="profile.php"><i class="bi bi-person-circle"></i> <?=$fe_side_edit_profile?>
            </a>
          </li>

          <!-- <li>
            <div class="night-mode-nav">
              <i class="bi bi-moon"></i> Night Mode
              <div class="form-check form-switch">
                <input class="form-check-input form-check-success" id="darkSwitch" type="checkbox">
              </div>
            </div>
          </li> -->
          <li>
            <a href="admin/core/logout.php"><i class="bi bi-box-arrow-right"></i> <?=$common_logout?></a>
          </li>
        </ul>
      </div>
               <!-- Copyright Info -->
        <div class="copyright-info">
            <img src="assets/img/logo_salomon_rid.png" alt="Logo"/> &nbsp; web app <br><br> 

            by <a href="http://www.dmweblab.com" target="_blank"><img src="assets/img/dmweblab_logo.png"></a>
        </div>
        </div>
      </div>
    </div>

  
      </div>
    </div>
  </div>