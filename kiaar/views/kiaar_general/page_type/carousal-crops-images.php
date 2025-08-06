<?php foreach($crop_images as $key => $item) 
{ 
?>    <div class="carousel-item <?php if($key == 0) { echo "active"; }?>">
        <div class="crop-detail">
          <img alt="" src="/upload_file/crop_health_upload/<?php echo $item['FARMER_ID'].'_'.$item['year'].'-'.$item['month'];?>/<?php echo $item['image'];?>" />
        </div>
      </div>
<?php 
} 
?>