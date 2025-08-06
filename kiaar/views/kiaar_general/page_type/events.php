
<div class="newsevents-listingmain">
<div class="bannersec "><img alt="" class="w-100" src="/assets/kiaar-web/images/banners/News-and-Events.jpg" /></div>

<section class="maincontentarea">
<div class="container">
<div class="row">
<div class="col-md-12">
<h2 class="heading">News and Events</h2>
</div>
</div>

<div>
<div class="row ">
<div class="col-md-12 bg-grey">
<h2 class="news-heading">News</h2>
</div>
</div>

<div class="row">
<?php if(isset($news_event) && count($news_event)!=0){ ?>
	 <?php $i = 0;foreach($news_event as $eventdata){ ?>
		<div class="col-lg-6 col-md-6  events-card">
		<div class="newscard">
			<h3 class="news-head"><?=$eventdata['event_name']?>  <?php echo date("F", strtotime($eventdata['to_date'])); ?>  <?php echo date("d", strtotime($eventdata['to_date'])); ?> ,  <?php echo date("Y", strtotime($eventdata['to_date'])); ?></h3>
		<!-- <h3 class="news-date"><?php echo date(" jS", strtotime($eventdata['to_date'])); ?>  <?php echo date("F", strtotime($eventdata['to_date'])); ?> ,  <?php echo date("Y", strtotime($eventdata['to_date'])); ?></h3> -->

		<p><?=$eventdata['description']?></p>

		<!-- <div class="linksbox"><a class="news-link" href="">Read More</a></div> -->
		</div>
		</div>
 <?php  } 
		}
 ?>
</div>
</div>
</div>
</section>
</div>
