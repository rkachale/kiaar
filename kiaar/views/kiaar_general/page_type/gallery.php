     
    <?php //if(isset($data) && count($data)!=0){ ?>

                   <?php //foreach($data["body"] as $item){ ?>
                    <!-- <div> -->
                        <?php //echo $item['description']; ?>
                    <!-- </div> -->
                        <?php //} ?>
    <?php //} ?>


<div class="home-main">
      <section class="hm-bannersec">
        <img src="/assets/kiaar-web/images/aboutpage/gallery.jpg" alt="Banner Image" class="w-100 ">
       
      </section>
    </div>
    <div class="ogfarm-main smartsgriculture sqi molecularbreeding">
      <div class="tabsmainsecs">
        <div class="container ">
          <div class="row">
           
            <div class="col-md-12">
              <h2 class="heading">Gallery</h2>
              <div class="main-content">
                <div class="tabs">
                 
                 
                 
                  <!-- Tab panes -->
                  <div class="row">
                    <div class="col-md-3"> <ul class="nav nav-tabs" role="tablist">
                      <p class="titles">Albums <button class="menus"><i class="fas fa-bars" style="font-size: 48px;"></i></button></p>
                        <?php if(isset($gallery) && count($gallery)!=0) {?>
                      <?php $i=1; foreach($gallery as $key => $mi) { ?>
                            <li class="nav-item">
                              <a class="nav-link <?php if($i==1) {echo 'active';}?>" data-toggle="tab" href="#album<?=$mi['g_id']?>"><?php echo $mi['title']; ?></a>
                            </li>
                          <?php $i++; } ?>
                  <?php } ?>
                    </ul></div>
                    <div class="col-md-9">
                      <div class="tab-content demo-gallery">
                        <?php //$j=1; foreach ($gallery as $key1 => $value1) { ?>
                          <!-- <div id="album<?=$value1['g_id']?>" class=" tab-pane <?php if($j==1){ echo "active"; }?>">
                            <div data-nanogallery2>
                              <?php foreach ($value1['banner_images'] as $images) { ?>
                                <a href="/upload_file/gallery_upload/<?=$images['image']?>" data-ngThumb="/upload_file/gallery_upload/<?=$images['image']?>"></a>
                              <?php } ?>
                            </div>
                          </div> -->
                      <?php //$j++; } ?>

                      <?php $j=1; foreach ($gallery as $key1 => $value1) { ?>
                      <div id="album<?=$value1['g_id']?>" class=" tab-pane <?php if($j==1){ echo "active"; }?>">
                        <ul id="lightgallery">
                          <?php foreach ($value1['banner_images'] as $images) { ?>
                      <li class="col-md-4" data-responsive="/upload_file/gallery_upload/<?=$images['image']?>" data-src="/upload_file/gallery_upload/<?=$images['image']?>" data-sub-html="<h4><?=$images['image_name']?></h4>" data-pinterest-text="Pin it" data-tweet-text="share on twitter ">
                        <a href="">
                            <img class="img-responsive lazyloadimg fade" data-lazy="/upload_file/gallery_upload/<?=$images['image']?>" src="/upload_file/gallery_upload/<?=$images['image']?>">
                            <!-- <div class="demo-gallery-poster">
                              <img src="https://sachinchoolur.github.io/lightGallery/static/img/zoom.png">
                            </div> -->
                        </a>
                      </li>
                    <?php } ?>
                </ul>
            </div>
              <?php $j++; } ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>



<!-- <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.6.14/css/lightgallery.css'> -->
<link href="/assets/kiaar-web/css/lightgallery.css" rel="stylesheet" type="text/css">
<script src='/assets/kiaar-web/js/lightgallery-all.min.js'></script>
<script type="text/javascript">
$(document).ready(() => {
  $("#lightgallery, #lightgallery1").lightGallery({
    pager: true
  });
});
</script>

 <!-- <link href="/assets/kiaar-web/css/nanogallery2.woff.min.css" rel="stylesheet" type="text/css"> -->

 <!-- <script src="<?=base_url()?>/assets/kiaar-web/js/jquery.nanogallery2.js"></script> -->

