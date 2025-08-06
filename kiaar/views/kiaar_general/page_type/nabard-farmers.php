<?php 
    $CI =& get_instance();
    $CI->load->model('Kiaar_general_model');
    $Villages            = $CI->Kiaar_general_model->Villages();
    $Cluster             = $CI->Kiaar_general_model->Cluster();
    // $Farmers             = $CI->Kiaar_general_model->Farmers();
    // $Code                = $CI->Kiaar_general_model->Code();
?>
<div class="about-main top-sec">
    <div class="banner-sec"><img alt="" class="w-100" src="/assets/kiaar-web/images/nabard/nabard-banner.jpg" /></div>
</div>

<section class="about-introsec">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <h2 class="heading">Smart Farming Solutions for Sustainable Agriculture<br />
                Funded by National Bank for Agriculture and Rural Development (NABARD)</h2>
            </div>
        </div>
    </div>
</section>
<!-- Static Code and Filter -->
<section class="sec-two-main">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <div class="sec-two-content">
                    <p>Smart farming supports cost-effective agriculture through the combination of navigation satellites, and earth observation input to make it easy for farmers to make a decision on how, where, and when to allocate resources for improved ecological and economic outputs. With smart farming, farmers find it easy to measure variables and process data with precision. This is aimed at ensuring that tasks are much simpler, yields are improved, and costs are reduced. Sustainability in agriculture can be achieved through the proper use of technologies in decision making. Sustainable agriculture refers to an agricultural production and distribution system that achieves the integration of natural biological cycles and controls, Protects and renews soil fertility and the natural resource base.</p>
                    <h5 class="text">Search By</h5>
                    <div class="search-by-data">
                        <div class="search-content">
                            <form>
                                <div class="search-col">
                                    <label class="labels">Village</label> 
                                    <select class="js-village-multiple form-control" name="village[]" id="village" multiple="multiple">
                                        <?php if(isset($Villages) && count($Villages)!=0){ ?>
                                        <?php foreach($Villages as $village){ ?>
                                            <option value="<?=$village['village_name']?>"><?php echo ucwords(strtolower($village['village_name'])); ?></option>
                                        <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="search-col">
                                    <label class="labels">Cluster</label> 
                                    <select class="js-cluster-multiple form-control" name="cluster[]" id="cluster" multiple="multiple">
                                        <?php if(isset($Cluster) && count($Cluster)!=0){ ?>
                                        <?php foreach($Cluster as $cluster){ ?>
                                            <option value="<?=$cluster['cluster_name']?>"><?php echo ucwords(strtolower($cluster['cluster_name'])); ?></option>
                                        <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="search-col">
                                    <label class="labels">Farmer Name</label> 
                                    <input class="user-input" type="text" id="farmer_name" />
                                </div>
                                <div class="search-col">
                                    <label class="labels">Cultivator Code</label> 
                                    <input class="user-input" type="text" id="farmer_id" />
                                </div>
                            </form>
                        </div>
                        <div class="btn-fields">
                            <button class="btn-search" type="submit" onclick="searchFilter();">Search</button>
                            <button class="btn-search" name="btn_clear" id="btn_clear" type="reset">Clear</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Ajax Code -->
<div id="refined"></div>

<!-- Maps -->
<section class="about-vilaage-maps" style="display:none;">
    <div class="container">
        <div class="row">
            <div class="col-md-3 pr-0">
                <div class="village-column">
                    <div class="head">Villages</div>
                    <div class="village-box">
                        <label class="village-data"><input checked="checked" class="chk-radio" name="names" type="radio" /> </label>
                        <div class="radio-btn">&nbsp;</div>
                        <label class="village-data"> </label>
                        <div class="village-name">
                            <label class="village-data">Cluster Name</label>
                        </div>
                        <label class="village-data"> </label> 
                        <label class="village-data"> <input class="chk-radio" name="names" type="radio" /> </label>
                        <div class="radio-btn">&nbsp;</div>
                    </div>
                </div>
            </div>
            <div class="col-md-9 pl-0">
                <div class="village-map-col">
                    <div class="village-maps active" data-info="cluster1"><iframe allowfullscreen="" aria-hidden="false" frameborder="0" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1885.3969790058081!2d72.89813605805409!3d19.072794596772418!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xce2e295605e442b1!2sK.%20J.%20Somaiya%20Polytechnic%20Hostel!5e0!3m2!1sen!2sin!4v1624076643866!5m2!1sen!2sin" style="border:0;" tabindex="0"></iframe></div>
                </div>
            </div>
        </div>
    </div>
</section>


<link href="<?=base_url()?>assets/kiaar-web/css/select2.min.css" rel="stylesheet" rel="preload" as="style" />
<script src="<?=base_url()?>assets/kiaar-web/js/select2.min.js" rel="preload" as="script" type="text/javascript"></script>

<script>
$(document).ready(function() 
{
    $('.js-village-multiple,.js-cluster-multiple').select2();

    $('#btn_clear').click(function(e){ 
        $('#farmer_name').val('');
        $('#farmer_id').val('');     
        $("#village,#cluster").val('').trigger('change');
        searchFilter();
    });
});
function searchFilter(page_num) 
{   
    page_num = page_num?page_num:0;
    var farmer_name = $('#farmer_name').val();
    var farmer_id = $('#farmer_id').val();
    var cluster=[];
    $. each($('select#cluster option:selected'), function(){          
    cluster. push($(this).val());       
    });
    cluster=cluster.toString();

    var village=[];
    $. each($('select#village option:selected'), function(){          
    village. push($(this).val());       
    });
    village=village.toString();

    $.ajax({
      type: 'POST',
      url: '<?php echo base_url(); ?>kiaar_general/nabard_farmers/'+page_num,
      data:'page_no='+page_num+'&farmer_name='+farmer_name+'&cluster='+cluster+'&farmer_id='+farmer_id+'&village='+village+'&lang=<?php echo $lang; ?>',
      beforeSend: function () {
          $('.loading').show();
          $('.refined').html('');
      },
      success: function (html) {
          $('#refined').html(html);
          $('.loading').fadeOut("slow");
      }
    });
}
searchFilter();
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

<script>
// assumes you're using jQuery
$(document).ready(function() {
  <?php if($this->session->flashdata('flsh_msg_after_logout')){ ?>
    toastr.success("<?php echo $this->session->flashdata('flsh_msg_after_logout'); ?>");
  <?php } ?>
});
</script>