<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1.0,shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="index, nofollow">
      <?php $is_home = ($this->router->fetch_class() === 'Kiaar_general' && $this->router->fetch_method() === 'index') ? true : false; ?>
        <?php if($is_home){ ?>
            <title>K J Somaiya Institute of Applied Agricultural Research</title>
            <meta name="description" content="Our agricultural research institute provides research in organic farming, molecular breeding, energy cane & soil testing. Also have services like soil testing & supply of quality inputs" />
        <?php } else { ?>
            <?php if(isset($keyword) && count($keyword)!=0){ ?>
                <title><?php foreach($keyword as $product) { if($product['meta_title'] != ''){echo $product['meta_title'];}else{echo isset($title)?"  ".$title:"";}}?></title>
                <meta name="keywords" content="<?php foreach($keyword as $product) {?><?php echo $product['meta_keywords']; ?><?php } ?>" />
                <meta name="description" content="<?php foreach($keyword as $product) {?><?php echo $product['meta_description']; ?><?php } ?>" />
            <?php } else { ?>
                <title><?php echo isset($title)?"  ".$title:"";?></title>
                <meta name="keywords" content="<?php if(isset($keywords)) echo $keywords; ?>" />
                <meta name="description" content="<?php if(isset($description)) echo substr_string(strip_tags($description),0,50); ?>" />
            <?php } ?>
        <?php } ?>
    <meta http-equiv="Content-Type" content="application/json; charset=UTF-8" />
    <link rel="icon" href="<?=base_url()?>assets/kiaar-web/images/favicon.png" type="image/x-icon" sizes="16x16"/>
    <link rel="stylesheet" href="<?=base_url()?>assets/kiaar-web/css/kiaar.css" />
    <link type="text/css" rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" >
    <script src="<?=base_url()?>assets/kiaar-web/js/jquery-3.4.1.min.js"></script>
    <link rel="sitemap" type="application/xml" title="Sitemap" href="<?php echo base_url().$lang; ?>/sitemap.xml" />
    <link rel="robots" type="application/txt" title="robots" href="https://kiaar.org/robots.txt" /> 
    <!-- Google Tag Manager1 -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-P95GCL4');</script>
<!-- End Google Tag Manager--->

</head>

<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-P95GCL4"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<header>
    <div class="container">
        <div class="nav-container">
            <nav class="navbar  sidenav"  id="headermainav">
                <ul>
                    <li id="toggleMenu"  aria-haspopup="true">
                        <a href="javascript:void(0);">
                            <span class="icon-menu" id="hamburger">&#9776;</span>
                            <span class="icon-menu-closed" id="closebtn">×</span>
                        </a>
                    </li>

                    <li><a href="<?=base_url().$lang?>" class="menu-item">Home</a></li>

                    <li>
                        <a href="javascript:void(0);" class="menu-item">About Us</a>
                        <ul class="levelone-dropdown">
                            <li><a href="<?=base_url().$lang?>/about-kiaar/" class="childmenu-item">About KIAAR</a></li>
                            <li><a href="<?=base_url().$lang?>/mission-values-goals/">Mission, Values & Goals</a></li>
                            <li><a href="<?=base_url().$lang?>/founders/">Founders </a></li>
                            <li><a href="<?=base_url().$lang?>/chairman/">Chairman</a></li>
                            <li><a href="<?=base_url().$lang?>/general-body/" class="childmenu-item">General Body</a></li>
                            <li><a href="<?=base_url().$lang?>/rac-members/" class="childmenu-item">Research Advisory Committee</a></li>
                            <li><a href="<?=base_url().$lang?>/past-directors/">Past Directors</a></li>
                            <li><a href="<?=base_url().$lang?>/directors-message/"> Director's Message</a></li>
                        </ul>
                    </li>

                      <li>
                        <a href="javascript:void(0);" class="menu-item">Our Community</a>
                        <ul class="levelone-dropdown">
                              <li><a href="<?=base_url().$lang?>/governing-council/" class="childmenu-item">Governing Council</a>
                            </li>
                             <li><a href="<?=base_url().$lang?>/our-staff/" class="childmenu-item">Our Staff</a></li>
                            <li><a href="<?=base_url().$lang?>/collaborators/" class="childmenu-item">Collaborators</a></li>
                             <!-- <li><a href="<?=base_url().$lang?>/eminent-visitors/" class="childmenu-item">Eminent Visitors</a></li> -->
                        </ul>
                    </li>
                    
                    <li>
                        <a href="javascript:void(0);" class="menu-item">What We Do</a>
                        <ul class="levelone-dropdown">
                            <!-- <li><h3 class="menu-heading">Research</h3></li> -->
                            <li>
                                <a href="javascript:void(0);" class="childmenu-item">Research</a>
                                <ul class="leveltwo-dropdown">
                                    <li><a href="<?=base_url().$lang?>/research/">Current research projects</a></li>
                                    <li><a href="<?=base_url().$lang?>/externally-funded-projects">Externally funded
                                            research projects</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="childmenu-item">Impact Areas</a>
                                <ul class="leveltwo-dropdown">
                                    <li><a href="<?=base_url().$lang?>/sustainable-sugarcane-production/">Sustainable Sugarcane Production </a></li>
                                    <li><a href="<?=base_url().$lang?>/organicfarming/"> Organic Farming</a></li>
                                    <li><a href="<?=base_url().$lang?>/smart-agriculture/">Smart Agriculture</a></li>
                                    <li><a href="<?=base_url().$lang?>/molecularbreeding/">Molecular Breeding </a></li>
                                    <li><a href="<?=base_url().$lang?>/energy-cane/"> Energy Cane</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="<?=base_url().$lang?>/transfer-of-technology/" class="childmenu-item">Transfer of Technology</a>
                                <ul class="leveltwo-dropdown">
                                    <li><a href="<?=base_url().$lang?>/transfer-of-technology#training">On Campus / Onsite Training</a></li>
                                    <li><a href="<?=base_url().$lang?>/transfer-of-technology#extensionLiterature">Extension Literature</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="childmenu-item">Services</a>
                                 <ul class="leveltwo-dropdown">
                                    <li><a href="<?=base_url().$lang?>/soil-testing/">Soil Testing</a></li>
                                    <li><a href="<?=base_url().$lang?>/supply-of-quality-inputs/">Supply of Quality Inputs</a></li>
                                
                                </ul>
                            </li>
                           
                            
                        </ul>
                    </li>

                    <li><a href="<?=base_url().$lang?>/education" class="menu-item">Education</a></li>

                    <li>
                        <a href="javascript:void(0);" class="menu-item">Publications</a>
                        <ul class="levelone-dropdown">
                            <li><a href="<?=base_url().$lang?>/publications#journals">Peer-Reviewed Journals</a></li>
                            <li><a href="<?=base_url().$lang?>/publications#bookchapters">Book Chapters</a></li>
                            <li><a href="<?=base_url().$lang?>/publications#conference-papers">Conference Papers</a></li>
                        </ul>
                    </li>

                    <li><a href="<?=base_url().$lang?>/news-events/" class="menu-item">News & Events</a></li>
                    <li><a href="<?=base_url().$lang?>/nabard/" class="menu-item">NABARD</a></li>
                    <li><a href="<?=base_url().$lang?>/gallery/" class="menu-item">Gallery</a></li>

                    <li><a href="<?=base_url().$lang?>/contact-us/" class="menu-item">Contact Us</a></li>
                    <?php if($this->session->userdata('username') != '' OR $this->session->userdata('login_mobile') != ''){ ?>
                        <li><a href="<?php echo base_url('kiaar_general/logout') ?>" class="menu-item">Logout</a></li>
                    <?php } ?>

                </ul>


             
            </nav>
        </div>

        <div class="desktop bottom-header">
            <div class="width50 leftlogowrapper">
                <h1>
                    <a href="<?=base_url().$lang?>" class="mobdnone">
                        <img src="<?=base_url()?>assets/kiaar-web/images/kiaar-logo.png" alt="" class="dektop-kiarlogo">
                    </a>
                    <a href="<?=base_url().$lang?>" class="mobdblock">
                        <img src="<?=base_url()?>assets/kiaar-web/images/kiarlogo-mobile.png" alt="" class=" mob-kiarlogo">
                    </a>
                </h1>
            </div>
            <div class="width50 rightlogowrapper">
                 <a aria-label="somaiya trust logo" href="https://somaiya.com/" target="_blank">
                    <img src="<?=base_url()?>assets/kiaar-web/images/Somaiya-Group-logo.jpg" alt="" class="Group-logo">
                </a>
            </div>
        </div>

      

    </div>

</header>
<div id="cu-overlay" class=""></div>
