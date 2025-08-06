<?php mk_use_uploadbox($this); ?>
<div class="row">
    <div class="col-md-12">
    <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-brown"></i>
                    <?php if(isset($data['user_id'])) { ?>
                        <span class="caption-subject font-brown bold uppercase">Edit User</span>
                    <?php } else { ?>
                        <span class="caption-subject font-brown bold uppercase">Add New User</span>
                    <?php } ?>
                </div> 
                &nbsp;&nbsp;<span class="custpurple"><a class="brownsmall btn brown" href="<?php echo base_url('admin/user/'); ?>">Back </a></span>
            </div>
            <div class="portlet-body form">
                <div class="form-body">
                    <form id="user_manipulate" class="cmxform form-horizontal tasi-form" method="post" action="<?php echo $base_url.'edituser'.(isset($data['user_id'])?'/'.$data['user_id']:"") ?>">
                        <input type="hidden" id="user_id" name="user_id" value="<?php echo isset($data['user_id']) ? $data['user_id'] : ''; ?>">
                        <input type="hidden" id="login_type" name="login_type" value="1">
                        <div class="form-group">
                            <div class="col-lg-12">
                                <div class="000"></div>
                            </div>
                        </div>

                        <div class="fields_wrap">
                            <div class="form-group ">
                                <label for="username" class="control-label col-lg-2">Username</label>
                                <div class="col-lg-10">
                                    <input class=" form-control" id="username" name="username" value="<?php echo isset($data['username'])?$data['username']:''; ?>" required="" type="text">
                                    <!-- <div class="usernameerror error_msg"><?php echo form_error('username', '<label class="error">', '</label>'); ?></div> -->
                                </div>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="email" class="control-label col-lg-2">Email</label>
                            <div class="col-lg-10">
                                <input class=" form-control" id="email" name="email" value="<?php echo isset($data['email'])?$data['email']:''; ?>" required="" type="email">
                                <!-- <div class="emailerror error_msg"><?php echo form_error('email', '<label class="error">', '</label>'); ?></div> -->
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="fullname" class="control-label col-lg-2">Name</label>
                            <div class="col-lg-10">
                                <input class=" form-control" id="fullname" name="fullname" value="<?php echo isset($data['fullname'])?$data['fullname']:''; ?>" type="text">
                            </div>
                        </div>

                        <div class="fields_wrap">
                            <div class="form-group ">
                                <label for="password" class="control-label col-lg-2">Password</label>
                                <div class="col-lg-10">
                                    <input class=" form-control" id="password" name="password" value="" type="password">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input class="btn green" value="Submit" type="submit" id="submit_user">
                                <a href="<?php echo base_url('admin/user'); ?>" class="btn btn-default" type="button">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <!-- END SAMPLE FORM PORTLET-->                                
    </div>
</div>
<?php mk_popup_uploadfile(_l('Upload Avatar',$this),"avatar",$base_url."upload_image/20/"); ?>

<script type="text/javascript">
    $(document).ready(function() {
        var login_type = '<?php echo isset($data["login_type"]) ? $data["login_type"] : ""; ?>';
        var user_id = $('#user_id').val();
        handle_fields(login_type);
    });

    $(document).on('change', '#login_type', function (e) {
        var login_type = $("#login_type option:selected").val();
        handle_fields(login_type);
    });

    function handle_fields(login_type) {
        if(login_type == '1')
        {
            $('.fields_wrap').removeClass('hidden');
            $('#email').removeAttr('required');
            $('#username').attr('required', 'required');
        }
        else if(login_type == '2')
        {
            $('.fields_wrap').addClass('hidden');
            $('#email').attr('required', 'required');
            $('#username').removeAttr('required');
        }
    }

    //var logintyperequired   = 'Please select login type';
    var usernamerequired    = 'Please enter username';
    var usernameexist       = 'Username already exist';
    var emailrequired       = 'Please enter email';
    var emailvalid          = 'Please enter valid email';
    //var emailexist          = 'Email already exist';

    // var email_regex         = /^[^@\s]+@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)+$/i;

    // $.validator.addMethod("email_regex", function(value, element) {
    //     if(value == '')
    //     {
    //         return true;
    //     }
    //     else
    //     {
    //         return email_regex.test(value);
    //     }
    // }, '');

    // $.validator.addMethod("check_unique_username", function(value) {
    //     var username           = $('#username').val();
    //     var user_id             = '<?php echo isset($data["user_id"]) ? $data["user_id"] : ""; ?>';
    //     var check_result        = true;

    //     $.ajax({
    //         type: "POST",
    //         url: base_url+"kiaar_general_admin/ajax_check_username",
    //         async: false,
    //         data: {username : username, user_id : user_id},
    //         success: function(response){
    //             check_result = response;
    //         }
    //     });
    //     return check_result;
    // }, '');

    // $.validator.addMethod("check_unique_email", function(value) {
    //     var email               = $('#email').val();
    //     var user_id             = '<?php echo isset($data["user_id"]) ? $data["user_id"] : ""; ?>';
    //     var check_result        = true;

    //     $.ajax({
    //         type: "POST",
    //         url: base_url+"arigel_general_admin/ajax_check_email",
    //         async: false,
    //         data: {email : email, user_id : user_id},
    //         success: function(response){
    //             check_result = response;
    //         }
    //     });
    //     return check_result;
    // }, '');

    $("#user_manipulate").validate({
        rules: {
            // login_type: {
            //     required: true
            // },
            username: {
                // required: true,
                // check_unique_username: '#username',
            },
            email: {
                // required: true,
                email_regex: '#email',
                // check_unique_email: '#email',
            },
        },
        messages: {
            // login_type: {
            //     required: logintyperequired
            // },
            username:{
                required: usernamerequired,
                // check_unique_username: usernameexist
            },
            email:{
                required: emailrequired,
                email_regex: emailvalid,
                // check_unique_email: emailexist
            },
        },
        errorElement : 'div',
        errorPlacement: function(error, element) {
            var placement = $(element).data('error');
            if (placement) {
                $(placement).append(error)
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function(form){
            $("#submit_user").val("Please Wait...");
            $("#submit_user").attr('disabled', 'disabled');

            // $('.usernameerror').html('');
            // $('.emailerror').html('');

            // function check_unique_username() {
            //     var username           = $('#username').val();
            //     var user_id             = '<?php echo isset($data["user_id"]) ? $data["user_id"] : ""; ?>';
            //     var check_username_result        = true;

            //     if($('#login_type').val() == 1)
            //     {
            //         $.ajax({
            //             type: "POST",
            //             url: base_url+"kiaar_general_admin/ajax_check_username",
            //             async: false,
            //             data: {username : username, user_id : user_id},
            //             success: function(response){
            //                 check_username_result = response;
            //             }
            //         });
            //     }
            //     return check_username_result;
            // }

            // function check_unique_email() {
            //     var email               = $('#email').val();
            //     var user_id             = '<?php echo isset($data["user_id"]) ? $data["user_id"] : ""; ?>';
            //     var check_email_result  = true;

            //     $.ajax({
            //         type: "POST",
            //         url: base_url+"kiaar_general_admin/ajax_check_email",
            //         async: false,
            //         data: {email : email, user_id : user_id},
            //         success: function(response){
            //             check_email_result = response;
            //         }
            //     });
            //     return check_email_result;
            // }

            // var username_res = check_unique_username();
            // var email_res = check_unique_email();
            var submit_form = true;

            // if(username_res == false)
            // {
            //     $('.usernameerror').html(usernameexist);
            //     submit_form = false;
            // }
            // if(email_res == false)
            // {
            //     $('.emailerror').html(emailexist);
            //     submit_form = false;
            // }

            if(submit_form == true)
            {
                form.submit();
            }
            else
            {
                $("#submit_user").val("SUBMIT");
                $("#submit_user").removeAttr('disabled');
                return false;
            }
        }
    });





function select_institute(id) {
    $.ajax({
      url: '<?php echo site_url("admin/appendinstitute");?>',
      success: function(data) {
        $('#singleinst'+id).html(data);
        $('#singleinst'+id).select2();
      }
    });
}

function select_group(id) {
    $.ajax({
      url: '<?php echo site_url("admin/appendgroups");?>',
      success: function(data) {
        $('#singlegrp'+id).html(data);
        $('#singlegrp'+id).select2();
      }
    });
}


// i=$('.group_wrap').length;
i=1;
$(document).on('click', 'a.add', function (e) {
    e.preventDefault();
    $(".group_wrap:last").after('<tr class="group_wrap"><td class="group_td"><div class="p10"><select id="singlegrp'+i+'" class="form-control select2" name="group_array[]" data-placeholder="Group Name"><option value="">Select Group</option><option value=""></option></select></div></td><td class="institute_td"><div class="p10"><select id="singleinst'+i+'" class="form-control select2" name="institute_array[]" data-placeholder="Select Institute"><option value="">Select Institute</option><option value=""></option></select></div></td><td class="add_remove_td"><div class="p10"><a class="removeMore'+i+'" data-id="'+i+'"><i title="<?=_l("Delete",$this)?>" class="fa fa-trash-o"></i></a></div></td></tr>');
    // removeMore();
    $(".removeMore"+i).click(function(){
        var ugiid = $(this).attr("data-id");
        var answer = confirm ("Are you sure you want to delete?");
        if(answer)
        {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('admin/deleteusergroup');?>",
                data: "ugiid="+ugiid,
                success: function (response) {
                  if (response == 1) {
                    $(".imagelocation"+ugiid).remove(".imagelocation"+ugiid);
                  };
                }
            });
        }
        $(this).parent().parent().parent().fadeOut("slow", function() {
            // $(this).parent().parent().parent().remove();
            $(this).remove();
        });
    });
    select_institute(i);
    select_group(i);
    i++;
});

$(".removeMore").click(function(){
    var ugiid = $(this).attr("data-id");
    var answer = confirm ("Are you sure you want to delete?");
    if(answer)
    {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('admin/deleteusergroup');?>",
            data: "ugiid="+ugiid,
            success: function (response) {
              if (response == 1) {
                $(".imagelocation"+ugiid).remove(".imagelocation"+ugiid);
              };
            }
        });
    }
    $(this).parent().parent().parent().fadeOut("slow", function() {
        // $(this).parent().parent().parent().remove();
        $(this).remove();
    });
});
</script>

<style>
div.boxform{
    border: 1px solid lightgrey;
    padding: 25px;
    margin: 25px;
}
</style>