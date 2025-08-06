    <?php if(isset($data) && count($data)!=0){ ?>

                   <?php foreach($data["body"] as $item){ ?>
                    <div>
                        <?=$item['description']?>
                    </div>
                        <?php } ?>
    <?php } ?>

    <div class="about-main">
        <div class="banner-sec contactbannersec">
            <img data-lazy="/assets/kiaar-web/images/banners/contact-us.jpg" src="/assets/kiaar-web/images/banners/contact-us.jpg" alt="" class="w-100 lazyloadimg">
        </div>
    
        <section class="about-introsec contactus">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="heading">Contact Us</h2>
                    </div>
    
                </div>

                <div class="fullwidth bg-grey">
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class=" contactcard">
                            <div class="imgbox">
                                <img class="img-fluid" src="/assets/kiaar-web/images/general-body/kadlag-n.png" alt="">
                            </div>
                            <div class="contentbox">
                                <h3 class="general-head">Dr. Nandkumar Kunchge</h3>
                                <p class="desgn">Director, K.J. Somaiya Institute of Applied Agricultural Research (KIAAR), Sameerwadi, Karnataka, India.</p>
                            </div>
                        </div>
                         
                        <div class="width50 mt-5">
                            <h3 class="contacthead">Address: </h3>
                            <p>At/Po: Sameerwadi Rabkavi-Banahatti Taluk, Bagalkot District, Pin: 587316, Karnataka</p>
                        </div>
                        <div class="fullwidth mt-3">
                           <p><b>Tel(R):</b> (08350) 260046/47/48</p>
                           <p><b>Mobile:</b> +91-70222 60486</p>
                          <!--  <p><b>Skype:</b> virupakshagouda</p> -->
                           <p><b>Email:</b> <a href="mailto:director.kiaar@somaiya.edu">director.kiaar@somaiya.edu</a></p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <form id="contactform" action="" class="contactform" name="contactform" method="post" >
                            <div class="row form-group">
                                <div class="col-md-3 justify-content-start align-items-start d-flex">
                                    <h4 class="formheading">First Name*</h4>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="first_name" required />
                                    <span class="error first_name_error"></span>
                               
                                </div>
                            </div>

                            <div class="row form-group"> 
                                <div class="col-md-3 justify-content-start align-items-start d-flex">
                                    <h4 class="formheading">Last Name*</h4>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="last_name" required />
                                    <span class="error last_name_error"></span>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-md-3 justify-content-start align-items-start d-flex">
                                    <h4 class="formheading">Email*</h4>
                                </div>
                                <div class="col-md-9">
                                    <input type="email" class="form-control" name="email_id" required />
                                    <span class="error email_id_error"></span>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-md-3 justify-content-start align-items-start d-flex">
                                    <h4 class="formheading">Phone*</h4>
                                </div>
                                <div class="col-md-9">
                                    <input type="tel" class="form-control" name="mobile_number" maxlength="10" autocomplete="off" required />
                                    <span class="error mobile_number_error"></span>
                                </div>
                            </div>

                            
                            <div class="row form-group">
                                <div class="col-md-3 justify-content-start align-items-start d-flex">
                                    <h4 class="formheading">Subject*</h4>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="subject" required />
                                    <span class="error subject_error"></span>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-md-3 justify-content-start align-items-start d-flex">
                                    <h4 class="formheading">Message*</h4>
                                </div>
                                <div class="col-md-9">
                                    <textarea class="cnttextarea" id="textarea" name="user_message" rows="3" required /></textarea>
                                    <span class="error user_message_error"></span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3"></div>
                                <div class=" col-md-9 ">
                                    <button type="submit" id="kiaar_contact_submit" class="contactbtn">Enquire Now</button>
                                </div>
                            </div>

                        </form>
                        <div class="success_msg"></div>
                    </div>
                </div>
            </div>
               
            </div>
        </section>
    
    
    
    </div>                    


<script type="text/javascript">
    
    $(document).ready(function(){

    $('#kiaar_contact_submit').click(function(event){ 
        event.preventDefault(); //your ajax gets here: 
        
        //console.log("kiaar contact submit called");

        //var formDataone = new FormData($("#contactform")[0]);
        var formData = $('#contactform').serializeArray();
        //console.log(formData);
        
        jQuery.ajax({
            type:"post",
            dataType:"json",
            url: '<?php echo base_url(); ?>kiaar_general/kiaar_contact_form_submit/en/',
            //data: {action: 'submit_data', info: 'test'},
            data: formData,
            success: function(response, textStatus, jqXHR)
            {
                var fetchResponse = JSON.parse(JSON.stringify(response));
                console.log(fetchResponse);

                if(fetchResponse.status == "failure")
                {
                    //console.log("error error ");
                    $.each(fetchResponse.error, function (i, v)
                    {
                        $('.'+i+'_error').html(v);
                    });
                    
                    $(".success_msg").html("");
                }
                else
                {
                    $(".error").html('');
                    //console.log("sussess");
                    //$(".success_msg").html("Thank you, we will get back to you. ");
                    $('#thankYouModal').modal('show');
                    $('#contactform').trigger("reset");

                }
            }
        });
    });
    
  });

</script>