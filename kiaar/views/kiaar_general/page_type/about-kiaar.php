    <?php //if(isset($data) && count($data)!=0){ ?>

                   <?php //foreach($data["body"] as $item){ ?>
                    <!-- <div>
                        <?=$item['description']?>
                    </div> -->
                        <?php //} ?>
    <?php //} ?>





<div class="about-main">
	<div class="banner-sec">
		<img alt="" class="w-100 lazyloadimg" data-lazy="<?=base_url()?>/assets/kiaar-web/images/banners/about.jpg" src="<?=base_url()?>/assets/kiaar-web/images/banners/about.jpg" />
	</div>
	<section class="about-introsec">
		<div class="container">
			<div class="row">
				<div class="col-lg-7 col-md-12">
					<h2 class="heading">About KIAAR</h2>
					<p>When it was decided to establish the Godavari Sugar Mills Ltd., in the backward region of Northern Karnataka it was found that agriculture was at subsistence level and there was no awareness of irrigated farming in general and sugarcane cultivation in particular. The agronomic practices were primitive, in spite of abundant potential for sugarcane cultivation. Sugarcane crop was cultivated over an area of 10,000 acres only, with an average sugarcane yield of only 10-15 tonnnes/acre, and an average sugar recovery of 9%.</p>

					<p>To overcome this situation, it was thought necessary to get the guidance from Eminent Scientists and &ldquo;Lab to Land&rdquo; programme was conceived. Thus, the Karnataka Institute of Applied Agricultural Research (KIAAR) was established in the year 1971 that is one year before the Godavari Sugar Mills Ltd., was established.</p>

					<p>The institute was renamed as K.J. Somaiya Institute of Applied Agricultural Research (KIAAR), during the year 1999, in memory of the Founder of the Institute, Late Shri Padmabhushan Karamshibhai J. Somaiya.</p>

					<p>The institute is registered under the Mysore Societies Registration Act of 1961, and is also recognized by the &ldquo;Indian Council of Agricultural Research, New Delhi&rdquo; as a Centre of Research in Agriculture.</p>
				</div>
				<div class="col-lg-5"><img alt="" class="abtrightimg " src="/assets/kiaar-web/images/aboutpage/about.png" /></div>
			</div>
		</div>
	</section>

    <?php if(isset($event) && count($event)!=0){ ?>
		<section class="about-newsevents">
			<div class="container">
				<div class="row">
					<div class="col-md-6">
						<h2 class="subheading"><img class="icon lazyloadimg" alt="" data-lazy="/assets/kiaar-web/images/aboutpage/book-icon.svg"  src="/assets/kiaar-web/images/aboutpage/book-icon.svg"/>Latest News &amp; Events</h2>
					</div>
					<div class="col-md-6 links-sec"><a href="<?=base_url().$lang?>/news-events/"> View all News &amp; Events</a></div>
				</div>
				<div class="row news-sec">
					<?php $i = 0;foreach($event as $eventdata){ ?>
						<div class="col-md-4">
							<h3 class="news-head"><?=$eventdata['event_name']?> <?php echo date("F", strtotime($eventdata['to_date'])); ?>  <?php echo date("d", strtotime($eventdata['to_date'])); ?> ,  <?php echo date("Y", strtotime($eventdata['to_date'])); ?></h3>
							<p><?=$eventdata['description']?></p>
							<!-- <a class="read-more-link" href="">Read More</a> -->
						</div>
					<?php  } ?>
				</div>
			</div>
		</section>
	<?php } ?>

<section class="about-introsec bottom">
<div class="container">
<div class="row justify-content-center align-items-center">
<div class="col-md-5"><img alt="" class="abtinstimg " src="/assets/kiaar-web/images/homepage/about-institute.png" /></div>

<div class="col-md-7">
<h2 class="subheading text-orange">About Institute</h2>

<p>The institute is registered under the Mysore Societies Registration Act of 1961, and is also recognized by the &ldquo;Indian Council of Agricultural Research, New Delhi&rdquo; as a Centre of Research in Agriculture.</p>

<p>KIAAR was established in the year 1971 that is one year before the Godavari Sugar Mills Ltd., was established. The institute was renamed as K. J. Somaiya Institute of Applied Agricultural Research (KIAAR), during the year 1999, in memory of the Founder of the Institute, Late Shri Padmabhushan Karamshibhai J. Somaiya.</p>
</div>
</div>
</div>
</section>
</div>
