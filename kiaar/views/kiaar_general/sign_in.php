<?php
$farmer_id = '';

if(isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id']))
{ 
    $farmer_id = $_GET['id'];
}

$CI =& get_instance();
$CI->load->model('Kiaar_general_model');
$mobile_number  = $CI->Kiaar_general_model->get_mobile_number($farmer_id);
?>
<div>
    <div class="about-main top-sec">
        <div class="banner-sec">
            <img alt="" class="w-100" src="/assets/kiaar-web/images/nabard/login-bg.png">
        </div>
    </div>
    <section class="login-section">
        <div class="login-content">
            <h2 class="heading text-center">Login</h2>
            <?php if($this->session->flashdata('flsh_msg_user')) { ?>
	            <div class="alert alert-danger">
	                <button class="close" data-close="alert"></button>
	                <span> <?php echo $this->session->flashdata('flsh_msg_user'); ?> </span>
	            </div>
	        <?php } ?>
	        <?php if($this->session->flashdata('flsh_msg')) { ?>
	            <div class="alert alert-danger">
	                <button class="close" data-close="alert"></button>
	                <span> <?php echo $this->session->flashdata('flsh_msg'); ?> </span>
	            </div>
	        <?php } ?>
	        <?php if($this->session->flashdata('flsh_msg_otp')) { ?>
	            <div class="alert alert-danger">
	                <button class="close" data-close="alert"></button>
	                <span> <?php echo $this->session->flashdata('flsh_msg_otp'); ?> </span>
	            </div>
	        <?php } ?>
	        <?php if($this->session->flashdata('flsh_msg_user_otp')) { ?>
	            <div class="alert alert-danger">
	                <button class="close" data-close="alert"></button>
	                <span> <?php echo $this->session->flashdata('flsh_msg_user_otp'); ?> </span>
	            </div>
	        <?php } ?>
	        <div class="form-details-content">
	            <form name="userlogin" action="<?php echo base_url('kiaar_general/loginwithuser') ?>" class="login-data" method="POST">
	                <div class="login-col">
	                	<h2 class="subheading">Admin</h2>
	                    <div class="label-content">
	                        <label class="user-labels">
	                            <img src="/assets/kiaar-web/images/nabard/user-icon.svg">
	                            <span>Username</span>
	                        </label>
	                        <input type="text" class="user-input" name="username" id="username" required>
	                    </div>
	                    <div class="label-content">
	                        <label class="user-labels">
	                            <img src="/assets/kiaar-web/images/nabard/password-icon.svg">
	                            <span>Password</span>
	                        </label>
	                        <input type="password" class="user-input" name="password" id="password" required>
	                    </div>
	                    <input type="hidden" name="farmer_id" value="<?=$farmer_id?>">
	                    <input type="submit" class="submit-btn" name="loginwithuser" value="Login">
	                </div>
	            </form>
	            <form name="mobilelogin" action="<?php echo base_url('kiaar_general/login') ?>" class="login-data" method="POST">
	                <div class="login-col">
	                	<h2 class="subheading">Farmer</h2>
	                    <div class="label-content">
	                        <label class="user-labels">
	                            <img src="/assets/kiaar-web/images/nabard/mobile-icon.svg">
	                            <span>Enter Mobile Number</span>
	                        </label>
	                        <input type="text" class="user-input" name="mobile" minlength="10" maxlength="10" required onkeypress="return isNumberKey(event)">
	                        <!-- <div class="error-text"><?php //echo $this->session->flashdata('flsh_msg'); ?></div> -->
	                    </div>
	                    <input type="hidden" name="farmer_id" value="<?=$farmer_id?>">
	                    <input type="submit" class="otp-btn" name="login" value="Get OTP">
	                    <!-- <button type="submit" name="login" class=""></button> -->
	                </div>
	            </form>
	        </div>
        </div>
    </section>
</div>
<?php echo $this->session->flashdata('success'); ?>
<?php if($this->session->flashdata('success') == 'true') { ?>
	<script>
	    $(document).ready(function(){
	        $("#otp-modal").modal('show');
	    });
	</script>
	<div id="otp-modal" class="modal fade">
	    <div class="modal-dialog modal-dialog-centered">
	        <div class="modal-content">
	            <div class="modal-header">
	                <h5 class="modal-title otp-title">OTP Verification</h5>
	                <button type="button" class="close" data-dismiss="modal">&times;</button>
	            </div>
	            <div class="modal-body">
	                <form name="otplogin" id="otplogin" method="post" action="<?php echo base_url('kiaar_general/verify') ?>">
                        <div class="otp-content">
                            <label class="otp-fields">Please enter verification code</label>
                            <input type="hidden" name="mobile_number" id="mobile_number" value="<?php echo $mobile_number[0]['MOBILE_NO']; ?>"  />
                            <input type="hidden" name="farmer_id" id="farmer_id" value="<?=$farmer_id?>">
                            <input type="password" name="otp" class="otp-pwd" id="otp" />
                            <div class="error-text">Wrong OTP</div>
                        </div>
                        <div class="otp-content">
                            <input type="submit" name="verify" value="Verify Code" class="verify-btn" />
                        </div>
									</form>
									<div class="resend-text"><a href="#" id="resend_otp" class="resend-btn">Resend OTP</a></div>
	            </div>
	        </div>
	    </div>
	</div>
<?php } ?>
<script type="text/javascript">
function isNumberKey(evt)
{
  var charCode = (evt.which) ? evt.which : evt.keyCode;
  if (charCode != 46 && charCode > 31 
    && (charCode < 48 || charCode > 57))
     return false;

  return true;
}
</script>

<script src="/assets/kiaar-web/js/jquery.validate.min.js"></script>
<script type="text/javascript">
// Wait for the DOM to be ready
$(function() {
  $("form[name='userlogin']").validate({
    rules: {
      username: "required",
      password: "required",
    },
    // Specify validation error messages
    messages: {
      username: "Please enter your username",
      password: "Please enter your password",
    },
    // Make sure the form is submitted to the destination defined
    // in the "action" attribute of the form when valid
    submitHandler: function(form) {
      form.submit();
    }
  });


  $("form[name='mobilelogin']").validate({
    rules: {
      mobile: {
        required: true,
        minlength: 10,
        maxlength: 10
      }
    },
    // Specify validation error messages
    messages: {
      mobile: {
        required: "Please provide a mobile no.",
        minlength: "Your mobile must be at least 10 digit long",
        minlength: "Your mobile must be at least 10 digit long"
      },
    },
    // Make sure the form is submitted to the destination defined
    // in the "action" attribute of the form when valid
    submitHandler: function(form) {
      form.submit();
    }
  });


  $("form[name='otplogin']").validate({
    rules: {
      otp: "required",
    },
    // Specify validation error messages
    messages: {
      otp: "Please enter your OTP",
    },
    // Make sure the form is submitted to the destination defined
    // in the "action" attribute of the form when valid
    submitHandler: function(form) {
      form.submit();
    }
  });


});


// resend otp

      $('#resend_otp').click(function(event){ 
          event.preventDefault(); //your ajax gets here: 

          var formData = $('#otplogin').serializeArray();
          console.log(formData);
          // var id = $(this).attr("id");
          // var month = $(this).attr("data-id"); 

          jQuery.ajax({
              type:"post",
              dataType:"json",
              url: '<?php echo base_url(); ?>kiaar_general/resend_otp/',
              //data: {action: 'submit_data', info: 'test'},
              // data:{id:id,month:month},
              data: formData,
              beforeSend: function () {
                $('.loader_bg').show();
              },
              success: function(response, textStatus, jqXHR)
              { 
                  $('.loader_bg').fadeOut(200);

                  var fetchResponse = JSON.parse(JSON.stringify(response));

                  if(fetchResponse.status == "failure")
                  {
                      $.each(fetchResponse.error, function (i, v)
                      {
                          $('.'+i+'_error').html(v);
                      });
                  }
                  else
                  {
                      $(".error").html('');
                      $(".resend_otp_success_msg").html("otp resend to your mobile");
                      //$('#otp_verify_modal').modal('hide');
                      //$('#contact_form').trigger("reset");
                      //window.location.href = "<?php echo base_url(); ?>en/success";

                  }
              }
          });
      });
</script>