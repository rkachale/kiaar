<div class="crop-col <?php echo $yearly_crops[0]['year']; ?>">
  <div class="crop-mapping-detail">
    <?php 
      if(!empty($yearly_crops))
      { 
        foreach($yearly_crops as $yearly)
        { 
          $monthNum  = $yearly['month'];
          $monthName = date('M', mktime(0, 0, 0, $monthNum, 10)); // March
    ?>
          <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 col-pd">
            <div class="crop-box">
              <div class="month-text"><?php echo $monthName; ?> <?php echo $yearly['year']; ?></div>
              <div class="crop-detail">
                <!-- <img src="/assets/kiaar-web/images/nabard/crop-detail.png" /> -->
                <img src="/upload_file/crop_health_upload/<?php echo $yearly['FARMER_ID'].'_'.$yearly['year'].'-'.$yearly['month'];?>/<?php echo $yearly['image'];?>" />
                <!-- <div class="view-all-text" data-target="#crop-modal<?php echo $yearly["year"]; ?>" data-toggle="modal">View all</div> -->
                <!-- <a href="#" data-toggle="modal" id="<?php echo $yearly["crop_id"]; ?>" data-id="<?php echo $yearly["month"]; ?>" class="view-all-text view_data">View all</a> -->
                <a href="<?php echo base_url().'en/crop-health-monitoring/'.$yearly['FARMER_ID'].'/'.$yearly['year'].'/'.$yearly['month']; ?>" class="view-all-text view_data">View all</a>
              </div>
            </div>
          </div>
    <?php 
        } 
      } 
      else 
      { 
    ?>
        <p class="errormsg">There are no farmers matching the filter.</p>
    <?php } ?>
  </div>
</div>

