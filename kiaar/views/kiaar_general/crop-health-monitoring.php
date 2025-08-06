
<?php

$previous_year = date("Y",strtotime("-1 year"));
//$prev_previous_year = date("Y",strtotime("-2 year"));
$current_year = date("Y");
$next_year = date('Y', strtotime('+1 year'));

$default_year = array($previous_year,$current_year,$next_year);

?>
<section class="about-introsec">

<div class="about-main top-sec">
		<div class="banner-sec"><img alt="" class="w-100" src="/assets/kiaar-web/images/nabard/soil-test-banner.jpg"></div>
	</div>
<div class="container">
	<div class="row">
        <div class="col-md-12">
			<div class="farmer_info">
				<div class="text-content">
		            <div class="text-type">Farmer Id:</div> 
		            <div class="text-val"><?php echo $farmer_id; ?></div>
		        </div>
		        <div class="text-content">
		            <div class="text-type">Name:</div> 
		            <div class="text-val"><?php echo $farmer_name[0]['farmer_name'];?></div>
		        </div>
			</div>
	<hr>
<?php

// $last_five_year = date('Y', strtotime('-5 years'));

// echo "<pre>";
// print_r($last_five_year);
?>
			<div class="monitoring-years">
				<div class="select-year">
					<select class="dropdown-select"  id="year_check" onchange="get_crophealth_monitoringImages('<?php echo $farmer_id; ?>','','<?php echo $month; ?>');">
						<!-- <option value="2020">2020</option>
						<option value="2021" selected="selected">2021</option>
						<option value="2022">2022</option> -->
						<?php
						foreach ($default_year as $key => $value) {
							?>
							<option value="<?php echo $value; ?>" <?php if($value == $year) {echo "selected";  } ?> ><?php echo $value; ?></option>
							<?php
						}
						?>
					</select>
				</div>
			</div>
		</div>
	</div>

  <div id="ajax_cropping_images">
  </div>
  
</div>
<!-- /.container -->
</section>




<script type="text/javascript">


	

function get_crophealth_monitoringImages(farmer_id,year,month) {

    var farmer_id = '<?php echo $farmer_id; ?>';
	var month = '<?php echo $month; ?>';

	//var year=[];
	if(year == '')
	{
		// $. each($('select#year_check option:selected'), function(){          
	 //      year. push($(this).val());       
	 //    });
	 //    year=year.toString();
	 	year = $("#year_check option:selected").val();
	}
	
	console.log("year");
	console.log(year);

    //var institute_id = <?php echo $id_of_institute; ?>;
    
     jQuery.ajax({
        type:"post",
        url: '<?php echo base_url(); ?>kiaar_general/get_crophealth_monitoringImages/',
        data:'farmer_id='+farmer_id+'&year='+year+'&month='+month,

        beforeSend: function () {
        $('.loading').show();
        },

        success: function (html) {
          //console.log(html);

          $("#ajax_cropping_images").html(html);
          //$('.loading').fadeOut("slow");
        }
    });
}

var farmer_id = '<?php echo $farmer_id; ?>';
var year = '<?php echo $year; ?>';
var month = '<?php echo $month; ?>';

get_crophealth_monitoringImages(farmer_id,year,month);



/*$(document).ready(function(){
  
  $(".getCropImage").on("click", function(){
  		console.log("getCropImage anchor clicked");
  		var old_tabcontent_id = $(this).attr('href');
  		console.log("old tab content id = "+old_tabcontent_id);
  		
  		var tabcontent_id = old_tabcontent_id.substring(1, old_tabcontent_id.length);
  		console.log("tab content id = "+tabcontent_id);

  		var crop_id = $(this).attr('data-id');
  		console.log("crop id "+crop_id);
  		var farmer_id = '<?php echo $farmer_id; ?>';
		var month = '<?php echo $month; ?>';
		year = $("#year_check option:selected").val();
		console.log("year"+year);

		jQuery.ajax({
		    type:"post",
		    url: '<?php echo base_url(); ?>kiaar_general/get_crophealth_image_by_id/',
		    data:'crop_id='+crop_id+'&farmer_id='+farmer_id+'&year='+year+'&month='+month,

		    beforeSend: function () {
		    $('.loading').show();
		    },

		    success: function (html) {
		      //console.log(html);

		      //$("#"+tabcontent_id).html(html);
		      $(old_tabcontent_id).html(html);
		      //$('.loading').fadeOut("slow");
		    }
		});

	});
});
*/

</script>