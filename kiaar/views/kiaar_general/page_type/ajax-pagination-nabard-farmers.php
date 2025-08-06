<section class="about-village-detail">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 col-md-12 col-12">
        <!-- <h2 class="subheading">Villages</h2> -->
        <div class="table-responsive">
          <table class="farmer-table">
            <tbody>
              <?php if(!empty($nabard_farmers_listing))
                {
              ?>
                <tr>
                    <th>Village Name</th>
                    <th>Cluster Name</th>
                    <th>Farmer</th>
                    <th>Farmer Name</th>
                    <th>Cultivator Code</th>
                    <th width="20%">Action Item</th>
                </tr>
              <?php } ?>
              <?php 
                if(!empty($nabard_farmers_listing))
                { 
                  foreach($nabard_farmers_listing as $farmers)
                  { 
              ?>
                    <tr>
                      <td><?php echo ucwords(strtolower($farmers['VILLAGE_NAME'])); ?></td>
                      <td><?php echo ucwords(strtolower($farmers['CLUSTER_NAME'])); ?></td>
                      <td>
                        <?php //if($farmers['IMAGE_FILE_NAME'] == '') { ?>
                          <!-- <div class="farmer-img"><img src="<?=base_url()?>assets/kiaar-web/images/nabard/placeholder.png" /></div> -->
                        <?php //} else { ?>
                          <!-- <div class="farmer-img"><img src="<?php //echo $farmers['IMAGE_FILE_NAME']; ?>" /></div> -->
                        <?php //} ?>
                        <?php 
                          $external_link = $farmers['IMAGE_FILE_NAME'];
                          if (@getimagesize($external_link)) { ?>
                          <div class="farmer-img"><img src="<?php echo $farmers['IMAGE_FILE_NAME']; ?>" /></div>
                          <?php } else { ?>
                          <div class="farmer-img"><img src="<?=base_url()?>assets/kiaar-web/images/nabard/placeholder.png" /></div>
                          <?php
                          }
                        ?>
                      </td>
                      <td><?php echo $farmers['FIRST_NAME']; ?> <?php echo $farmers['MIDDLE_NAME']; ?> <?php echo $farmers['LAST_NAME']; ?></td>
                      <td><?php echo $farmers['FARMER_ID']; ?></td>
                      <td>
                        <span class="view-farmer-detail">
                          <?php if($this->session->userdata('username') != ''){ ?>
                            <a href="<?=base_url()?>en/soil-test-results?id=<?php echo $farmers['FARMER_ID']; ?>">View Details</a>
                          <?php } elseif ($this->session->userdata('login_by') == 'Mobile' && $this->session->userdata('login_id')) {?>
                            <a href="<?php echo base_url('kiaar_general/loginby') ?>">View Details</a>
                          <?php } else { ?>
                            <a href="<?=base_url()?>en/login?id=<?php echo $farmers['FARMER_ID']; ?>">View Details</a>
                          <?php } ?>
                        </span>
                      </td>
                    </tr>
              <?php 
                  } 
                } 
                else 
                { 
              ?>
              <p class="errormsg">There are no farmers matching the filter.</p>
              <?php } ?>
            </tbody>
          </table>
        </div>
        <?php echo $this->ajax_pagination->create_links(); ?>
      </div>
    </div>
  </div>
</section>