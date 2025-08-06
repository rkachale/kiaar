<?php foreach($monthly_crops as $item) 
{ 
?>
    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 col-pd">
      <div class="crop-box">
        <div class="crop-detail" data-title="Crop Health Map">
          <img alt="" src="/upload_file/crop_health_upload/<?php echo $item['FARMER_ID'].'_'.$item['year'].'-'.$item['month'];?>/<?php echo $item['image'];?>" />
          <div class="zoom-icon" data-year="<?php echo $item['year']; ?>" data-month="<?php echo $item['month']; ?>" data-farmer-id="<?php echo $item['FARMER_ID']; ?>"><span></span></div>
        </div>
      </div>
    </div>
<?php 
} 
?>