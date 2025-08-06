<?php 
    $CI =& get_instance();
    $CI->load->model('Kiaar_general_model');
    $months_from_year  = $CI->Kiaar_general_model->months_from_year($crop_images[0]['year'],$crop_images[0]['FARMER_ID']);
    // echo "<pre>";print_r($months_from_year);exit;
?>

<div class="crop-select-month-block">
    <div class="heading-block">
        <img alt="" class="soil-icon" src="/assets/kiaar-web/images/nabard/crop-icon.svg" />
        <?php
          $monthno  	= $crop_images[0]['month'];
          $monthname 	= date('F', mktime(0, 0, 0, $monthno, 10)); // March
          $month_change = date('M', mktime(0, 0, 0, $monthno, 10)); // March
        ?>
        <h2 class="subheading">Crop Health Map - <?php echo $monthname; ?> <?php echo $crop_images[0]['year']; ?></h2>
    </div>
    <div class="select-month">
        <select class="dropdown-select" id="crop-month" onchange="getCrops_by_month()">
            <?php foreach($months_from_year as $yearly){
              $monthNum  = $yearly['month_new'];
              $monthName = date('M', mktime(0, 0, 0, $monthNum, 10)); // March
              $month = date('F', mktime(0, 0, 0, $monthNum, 10)); // March
            ?>
                <option value="<?php echo $monthNum; ?>" <?php if($monthname == $month){ echo "selected"; }?>><?php echo $month; ?></option>
            <?php } ?> 
        </select>
    </div>
</div>
<div class="crop-month-content">
   <div class="crop-month-col <?php echo $monthno; ?>">
	    <div class="crop-mapping-detail" id="crop_images">
		</div>
	</div>  
</div>

<script type="text/javascript">
	function getCrops_by_month(page_num) 
	{	
    	page_num = page_num?page_num:0;
        // dynamic to get selected year
        var selected_month=$('#crop-month').val();
        var year = <?php echo $crop_images[0]['year']; ?>;
        var farmer_id = <?php echo $crop_images[0]['FARMER_ID']; ?>
        // console.log(year);        
        jQuery.ajax({
            type:"post",
            url: '<?php echo base_url(); ?>kiaar_general/getCrops_by_month/'+page_num,
            data:'page_no='+page_num+'&month='+selected_month+'&year='+year+'&farmer_id='+farmer_id+'&lang=<?php echo $lang; ?>',

            beforeSend: function () {
            $('.loading').show();
            },

            success: function (html) {
              //console.log(html);

              $("#crop_images").html(html);
              //$('.loading').fadeOut("slow");
            }
        });
    }
    getCrops_by_month(0);
</script>