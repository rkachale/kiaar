<?php
$CI =& get_instance();
$CI->load->model('Kiaar_general_model');
$soil_data = $CI->Kiaar_general_model->soil_master_details($farmers_details[0]['FARMER_ID']);
// $j = 0;
// foreach ($soil_data as $key => $value) 
// {
//   $link_urls = $this->Kiaar_general_model->get_reports($value['soilID']);

//   $soil_data[$j]['link_urls'] = $link_urls;
//   $j++;
// }
// echo "<pre>";print_r($soil_data);exit;
?>
<div>
  <div class="about-main top-sec">
    <div class="banner-sec"><img alt="" class="w-100" src="/assets/kiaar-web/images/nabard/soil-test-banner.jpg" /></div>
  </div>
  <section class="about-introsec">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
          <div class="back-btn">
              <a href="<?=base_url().$lang?>/nabard/">Back</a>
          </div>
          <div class="heading-block"><img alt="" class="soil-icon" src="/assets/kiaar-web/images/nabard/soil-test-icon.svg" />
            <h2 class="subheading">Soil Test Results and Target Yield Based Nutrient Management Recommendation</h2>
          </div>
        </div>
      </div>
    </div>
  </section>
  <?php foreach($farmers_details as $farmers) { ?>
    <section class="sec-two-soiltest">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 col-md-12 col-12">
            <div class="soiltest-content">
              <div class="info-content">
                <div class="about-test">
                  <div class="user-info-data test-info">
                    <div class="text">Cultivator Code</div>
                    <div class="text-value">: <?=$farmers['FARMER_ID']?></div>
                  </div>
                  <?php if($farmers['survey_no'] != '') { ?>
                    <div class="user-info-data test-info">
                      <div class="text">Survey No:</div>
                      <div class="text-value">: <?=$farmers['survey_no']?></div>
                    </div>
                  <?php } ?>
                  <?php if($farmers['area'] != '') { ?>
                    <div class="user-info-data test-info">
                      <div class="text">Area:</div>
                      <div class="text-value">: <?=$farmers['area']?></div>
                    </div>
                  <?php } ?>
                  <div class="user-info-data test-info">
                    <div class="text">Farmer Name</div>
                    <div class="text-value">: <?=$farmers['FIRST_NAME']?> <?=$farmers['MIDDLE_NAME']?> <?=$farmers['LAST_NAME']?></div>
                  </div>
                  <?php if($farmers['future_crop'] != '') { ?>
                    <div class="user-info-data test-info">
                      <div class="text">Future Crop:</div>
                      <div class="text-value">: <?=$farmers['future_crop']?></div>
                    </div>
                  <?php } ?>
                  <?php if($farmers['soil_type'] != '') { ?>
                    <div class="user-info-data test-info">
                      <div class="text">Soil Type:</div>
                      <div class="text-value">: <?=$farmers['soil_type']?></div>
                    </div>
                  <?php } ?>
                </div>
              </div>
              <div class="">
                <div class="soil-data1">
                  <?php if(!empty($soil_data[0])) { ?>
                    <div class="table-data table-responsive">
                      <table class="table border-table og-table">
                        <thead>
                            <tr>
                              <th class="tbmainsubhead">Plot No</th>
                              <th class="tbmainsubhead">Report</th>
                              <th class="tbmainsubhead">Sample Date</th>
                              <th class="tbmainsubhead">Test Date</th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($soil_data as $key => $value) { ?>
                            <tr>
                              <td><?=$value['plot_no']?></td>
                              <td class=""><a style="color: #069;text-decoration: underline;" href="<?=$value['report_link']?>"><?=$value['report_name']?></a></td>
                              <td><?=$value['sampledate']?></td>
                              <td><?=$value['date']?></td>
                            </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>
                  <?php } ?>
                </div>
                <div id="graphdiv" class="col-md-7">&nbsp;</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="sec-three-aboutcrop">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 col-md-12 col-12">
            <div class="crop-selection-block">
              <div class="heading-block">
                <img alt="" class="soil-icon" src="/assets/kiaar-web/images/nabard/crop-icon.svg" />
                <h2 class="subheading">Crop Health Monitoring - Crop Health Map</h2>
              </div>
              <div class="select-year">
                <select class="dropdown-select" id="crop-year" name="selected_year" onchange="getCrops_by_filter()">
                  <?php foreach ($farmers['crop_values_year'] as $key => $value) { ?>
                    <option value="<?php echo $value['year']; ?>"><?php echo $value['year']; ?></option>
                  <?php } ?> 
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="crop-year-content" id="crop_data">
          </div>
        </div>
      </div>
    </section>
  <?php } ?>
  
  <!-- Modal -->

</div>

<!-- Modal -->
<div aria-hidden="true" aria-labelledby="exampleModalCenterTitle" class="modal" id="crop-modal" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content"><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true" class="close-icon"></span></button>
      <div class="row month-row" id="crop_details">
        
      </div>
    </div>
  </div>
</div>

<div class="modal" id="carousalModal" role="dialog">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content modal-data">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true" class="close-icon"></span>
      </button>
      <h3 class="modal-title subheading"></h3>
      <div class="modal-body">
        <div id="modalCarousel" class="carousel slide">
          <div class="carousel-inner" id="carousel_inner"></div>
          <a class="carousel-control-prev prev-icon modal-carousel-control" href="#modalCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next next-icon modal-carousel-control" href="#modalCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<input type="hidden" id="year_image" name="year" value="2021">
<input type="hidden" id="month_image" name="month" value="08">
<input type="hidden" id="farmer_id_image" name="farmer_id" value="348385">

<script src="<?=base_url()?>assets/kiaar-web/js/core.js"></script>
<script src="<?=base_url()?>assets/kiaar-web/js/charts.js"></script>
<script src="<?=base_url()?>assets/kiaar-web/js/dataviz.js"></script>
<script src="<?=base_url()?>assets/kiaar-web/js/animated.js"></script>
<script src="<?=base_url()?>assets/kiaar-web/js/kiaar.js"></script>

<script type="text/javascript">
  function getArrayMax(array){
   return Math.max.apply(null, array);
}

  //soil-graph
  am4core.ready(function() {

    // Themes begin
    am4core.useTheme(am4themes_dataviz);
    am4core.useTheme(am4themes_animated);
    // Themes end
    
    // Create chart instance
    var chart = am4core.create("graphdiv", am4charts.XYChart);
    
    
    // Add data
    chart.data = [{
    "names": "pH",
    "amount1": <?php echo $graph_data_response[0][ph]; ?>
    }, {
    "names": "EC",
    "amount2": <?php echo $graph_data_response[0][ec]; ?>
    }, {
    "names": "OC",
    "amount3": <?php echo $graph_data_response[0][oc]; ?>
    }, {
    "names": "N",
    "amount4": <?php echo $graph_data_response[0][n]; ?>
    }, {
    "names": "P",
    "amount5": <?php echo $graph_data_response[0][p]; ?>
    }, {
    "names": "K",
    "amount6": <?php echo $graph_data_response[0][k]; ?>
    }, {
    "names": "S",
    "amount7": <?php echo $graph_data_response[0][s]; ?>
    }, {
    "names": "Ca",
    "amount8": <?php echo $graph_data_response[0][ca]; ?>
    }, {
    "names": "Mg",
    "amount9": <?php echo $graph_data_response[0][mg]; ?>
    }, {
    "names": "Zn",
    "amount10": <?php echo $graph_data_response[0][zn]; ?>
    }, {
    "names": "Fe",
    "amount11": <?php echo $graph_data_response[0][fe]; ?>
    }, {
    "names": "Mn",
    "amount12": <?php echo $graph_data_response[0][mn]; ?>
    }, {
    "names": "Cu",
    "amount13": <?php echo $graph_data_response[0][cu]; ?>
    }, {
    "names": "Bd",
    "amount14": <?php echo $graph_data_response[0][bulk_densilty]; ?>
    }, {
    "names": "SIC",
    "amount15": <?php echo $graph_data_response[0][sic]; ?>
    }, {
    "names": "SOC",
    "amount16": <?php echo $graph_data_response[0][soc]; ?>
    }, {
    "names": "TOC",
    "amount17": <?php echo $graph_data_response[0][toc]; ?>
    }];
    
    chart.responsive.enabled = true;
    
    var max_values=[<?php echo $graph_data_response[0][ph]; ?>,<?php echo $graph_data_response[0][ec]; ?>,<?php echo $graph_data_response[0][oc]; ?>,<?php echo $graph_data_response[0][n]; ?>,<?php echo $graph_data_response[0][p]; ?>,<?php echo $graph_data_response[0][k]; ?>,<?php echo $graph_data_response[0][s]; ?>,<?php echo $graph_data_response[0][ca]; ?>,<?php echo $graph_data_response[0][mg]; ?>,<?php echo $graph_data_response[0][zn]; ?>,<?php echo $graph_data_response[0][fe]; ?>,<?php echo $graph_data_response[0][mn]; ?>,<?php echo $graph_data_response[0][cu]; ?>,<?php echo $graph_data_response[0][bulk_densilty]; ?>,<?php echo $graph_data_response[0][sic]; ?>,<?php echo $graph_data_response[0][soc]; ?>,<?php echo $graph_data_response[0][toc]; ?>];
    var maxValue=getArrayMax(max_values); //92
    // console.log(maxValue);

    // Create axes
    var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
    categoryAxis.dataFields.category = "names";
    categoryAxis.renderer.grid.template.location = 0;
    // categoryAxis.renderer.labels.template.rotation = -90;

    categoryAxis.renderer.cellStartLocation = 0.2;
    categoryAxis.renderer.cellEndLocation = 0.8;
    categoryAxis.cursorTooltipEnabled = false;
    categoryAxis.renderer.minGridDistance = 8;
    
    
    var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
    // valueAxis.renderer.inside = true;
    // valueAxis.renderer.labels.template.disabled = true;
    valueAxis.min = 0;
    valueAxis.max = maxValue + 2;
    // valueAxis.strictMinMax = true; 
    valueAxis.renderer.minGridDistance = 30;
    
        chart.colors.list = [
          am4core.color("#4285F4"),
          am4core.color("#EA4335"),
          am4core.color("#FBBC04"),
          am4core.color("#34A853"),
          am4core.color("#FF6A01"),
          am4core.color("#46BDC6"),
          am4core.color("#7BAAF7"),
          am4core.color("#F07B72"),
          am4core.color("#FCD04F"),
          am4core.color("#71C287"),
          am4core.color("#FF994D"),
          am4core.color("#7ED1D7"),
          am4core.color("#B3CEFB"),
          am4core.color("#F7B4AE"),
          am4core.color("#FDE49B"),
          am4core.color("#A25723"),
          am4core.color("#FFC75F"),
        ];
    
    // Create series
    function createSeries(field, name) {
    
    // Set up series
    var series = chart.series.push(new am4charts.ColumnSeries());
    series.name = name;
    series.dataFields.valueY = field;
    series.dataFields.categoryX = "names";
    series.sequencedInterpolation = true;
    
    // Make it stacked
    series.stacked = true;
    
    // Configure columns
    series.columns.template.width = am4core.percent(60);
    series.columns.template.tooltipText = "{categoryX}: {valueY}";
    series.tooltip.label.fontSize = 14;
    
    // Add label
    var labelBullet = series.bullets.push(new am4charts.LabelBullet());
    labelBullet.label.text = "{valueY}";
    // labelBullet.locationY = 0.5;
    // labelBullet.label.hideOversized = false;
    labelBullet.label.fill = am4core.color("#000");
    labelBullet.dy = -20;
    labelBullet.interactionsEnabled = false

    return series;
    }
    
    createSeries("amount1", "pH");
    createSeries("amount2", "EC");
    createSeries("amount3", "OC");
    createSeries("amount4", "N");
    createSeries("amount5", "P");
    createSeries("amount6", "K");
    createSeries("amount7", "S");
    createSeries("amount8", "Ca");
    createSeries("amount9", "Mg");
    createSeries("amount10", "Zn");
    createSeries("amount11", "Fe");
    createSeries("amount12", "Mn");
    createSeries("amount13", "Cu");
    createSeries("amount14", "Bd");
    createSeries("amount15", "SIC");
    createSeries("amount16", "SOC");
    createSeries("amount17", "TOC");
    
    
    // Legend
    //chart.legend = new am4charts.Legend();
    
    }); // end am4core.ready()
    
    $('#graphdiv g:has(> g[stroke="#3cabff"])').hide();
    </script>


<script type="text/javascript">
function getCrops_by_filter(page_num) {

        page_num = page_num?page_num:0;

        // dynamic to get selected year
        var selected_year=$('#crop-year').val();
        var farmer_id = <?php echo $_GET['id']; ?>;
        // console.log(farmer_id);        
        jQuery.ajax({
            type:"post",
            url: '<?php echo base_url(); ?>kiaar_general/getCrops_by_filter/'+page_num,
            data:'page_no='+page_num+'&year='+selected_year+'&farmer_id='+farmer_id+'&lang=<?php echo $lang; ?>',

            beforeSend: function () {
            $('.loading').show();
            },

            success: function (html) {
              //console.log(html);

              $("#crop_data").html(html);
              //$('.loading').fadeOut("slow");
            }
        });
    }
    getCrops_by_filter(0);

    $(document).ready(function(){  
      $(document).on('click', '.view_data', function(){  
           var id = $(this).attr("id");
           var month = $(this).attr("data-id"); 
           console.log(month); 
           $.ajax({  
                url:"<?php echo base_url(); ?>kiaar_general/get_crop_details",  
                method:"post",  
                data:{id:id,month:month},  
                success:function(data){  
                     $('#crop_details').html(data);  
                     $('#crop-modal').modal("show");  
                }  
           });  
      });

      $('.modal-carousel-control').click(function(e){
        e.preventDefault();
        $('#modalCarousel').carousel( $(this).data() );
       });  
  });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

<script>
// assumes you're using jQuery
$(document).ready(function() {
  <?php if($this->session->flashdata('flsh_msg_after_login')){ ?>
    toastr.success("<?php echo $this->session->flashdata('flsh_msg_after_login'); ?>");
  <?php } ?>
});
</script>
<style type="text/css">
  .soil-data1 {
    padding: 20px;
    float: left;
    width: 100%;
  }
  @media only screen and (max-width: 767px)
  {
    .soil-data1 
    {
      padding: 30px 0px;
    }
  }
</style>