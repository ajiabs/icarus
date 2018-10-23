<script>
function validate(evt){
    var theEvent = evt || window.event;
    var key = theEvent.keyCode || theEvent.which;

    if(key == 8 || key == 9 || key == 127){
        theEvent.returnValue = true;
    }else{
        key = String.fromCharCode( key );
        var regex = /[0-9]|\.|\-/;
        if(!regex.test(key)){
            theEvent.returnValue = false;
            if(theEvent.preventDefault) theEvent.preventDefault();
        }
    }
}

function validateEmail(email){
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function validateForm(){
    var name                = $("#firstName").val();
    var email               = $("#emailId").val();
    var subject             = $("#subject").val();
    var message             = $("#message").val();

    if(email == "" || name == "" || message == "" || subject == ""){
        if(email != ""){
           if(!validateEmail(email)){
               $("#emailId").val("");
               $("#emailId").focus();
               $("#validation_message").show();
               $("#response_message").html('');
               $("#validation_message").html('Kindly fill a valid email address!');
               return false;
           }
        }
        if(name == ""){
            $("#firstName").focus();
            $("#validation_message").show();
            $("#firstName").addClass("validationborder");
            $("#response_message").html('');
            $("#validation_message").html('Kindly fill all the mandatory fields!');

            if(email == ""){
                $("#emailId").addClass("validationborder");
            }else{
                $("#emailId").removeClass("validationborder");
            }
            if(subject == ""){
                $("#subject").addClass("validationborder");
            }else{
                $("#subject").removeClass("validationborder");
            }
            if(message == ""){
                $("#message").addClass("validationborder");
            }else{
                $("#message").removeClass("validationborder");
            }
        }
        else if(email == ""){
            $("#emailId").focus();
            $("#validation_message").show();
            $("#emailId").addClass("validationborder");
            $("#response_message").html('');
            $("#validation_message").html('Kindly fill all the mandatory fields!');

            if(name == ""){
                $("#firstName").addClass("validationborder");
            }else{
                $("#firstName").removeClass("validationborder");
            }
            if(subject == ""){
                $("#subject").addClass("validationborder");
            }else{
                $("#subject").removeClass("validationborder");
            }
            if(message == ""){
                $("#message").addClass("validationborder");
            }else{
                $("#message").removeClass("validationborder");
            }
        }
        else if(subject == ""){
            $("#subject").focus();
            $("#validation_message").show();
            $("#subject").addClass("validationborder");
            $("#response_message").html('');
            $("#validation_message").html('Kindly fill all the mandatory fields!');

            if(name == ""){
                $("#firstName").addClass("validationborder");
            }else{
                $("#firstName").removeClass("validationborder");
            }
            if(email == ""){
                $("#emailId").addClass("validationborder");
            }else{
                $("#emailId").removeClass("validationborder");
            }
            if(message == ""){
                $("#message").addClass("validationborder");
            }else{
                $("#message").removeClass("validationborder");
            }
        }
        else if(message == ""){
            $("#message").focus();
            $("#validation_message").show();
            $("#message").addClass("validationborder");
            $("#response_message").html('');
            $("#validation_message").html('Kindly fill all the mandatory fields!');

            if(name == ""){
                $("#firstName").addClass("validationborder");
            }else{
                $("#firstName").removeClass("validationborder");
            }
            if(email == ""){
                $("#emailId").addClass("validationborder");
            }else{
                $("#emailId").removeClass("validationborder");
            }
            if(subject == ""){
                $("#subject").addClass("validationborder");
            }else{
                $("#subject").removeClass("validationborder");
            }
        }
        else{
            $("#firstName").removeClass("validationborder");
            $("#emailId").removeClass("validationborder");
            $("#subject").removeClass("validationborder");
            $("#message").removeClass("validationborder");
        }
        return false;
    }
    else if(email != ""){
        if(!validateEmail(email)){
            $("#validation_message").show();
            $("#emailId").addClass("validationborder");
            $("#response_message").html('');
            $("#validation_message").html('Kindly fill a valid email address!');
            return false;
        }else{
            $("#emailId").removeClass("validationborder");
        }
    }else{
        $("#firstName").removeClass("validationborder");
        $("#emailId").removeClass("validationborder");
        $("#subject").removeClass("validationborder");
        $("#message").removeClass("validationborder");
        $("#validation_message").hide();
    }
    //return true;
}
</script>

<!--<h1>{PageContext::$response->section[0]->title}</h1>-->

<div class="container container-div main_content_outer">


<section class="countact-us-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <div class="contact-form">
                            <div class="form-heading">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="<?php echo BASE_URL;?>">Home</a></li>
                                    <li class="breadcrumb-item active">&nbsp;<?php  echo PageContext::$response->content[0]->title; ?></li>
                                </ol>
                                <h3><?php  echo PageContext::$response->content[0]->title; ?><!--Send a Message--></h3>
                                <!-- <em>Lorem ipsum dolor sit amet adipisicing</em> -->
                            </div>
                            <div class="form-description">
                                <p><?php  echo stripslashes(PageContext::$response->content[0]->description); ?></p>
                            </div>
                            <form id="contact-form" role="form" method="post" action="" name="feedback-form" onsubmit="return validateForm();">
                                <div id="validation_message" class="error_div" style="display:none;"></div>
                                <div id="response_message"><?php echo PageContext::$response->message; ?></div>
                                <div id="response">
                                     <div class="alert alert-success hidden" id="MessageSent">
                                        We have received your message, we will contact you soon.
                                    </div>
                                    <div class="alert alert-danger hidden" id="MessageNotSent">
                                        Oops! Something went wrong, please refresh the page and try again.
                                </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="firstName" id="firstName"  placeholder="First Name *" autocomplete="off" />
                                        </div>
                                    </div>
                                    <?php if(trim(PageContext::$response->contact_last_name) == "true"){ ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="lastName" id="lastName" placeholder="Last Name" autocomplete="off" />
                                        </div>
                                    </div>
                                  <?php }if(trim(PageContext::$response->contact_address) == "true"){ ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="address" id="address" placeholder="Address" autocomplete="off" />
                                        </div>
                                    </div>
                                  <?php } ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="emailId" id="emailId" placeholder="Email *" autocomplete="off" />
                                        </div>
                                    </div>
                                    <?php if(trim(PageContext::$response->contact_phone_number) == "true"){ ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="phone" id="phone" placeholder="Phone" onkeypress="validate(event);" autocomplete="off" maxlength="10" />
                                        </div>
                                    </div>
                                  <?php
                                    }
                                    if(trim(PageContext::$response->contact_country) == "true"){
                                    ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php
                                            if(is_array(PageContext::$response->countries) && count(PageContext::$response->countries) > 0){
                                                ?>
                                                <select name="country" id="country">
                                                  <option value="">Choose Country</option>
                                                <?php
                                                foreach(PageContext::$response->countries as $country){
                                                ?>
                                                <option value="<?php echo $country->country_name; ?>"><?php echo $country->country_name; ?></option>
                                                <?php
                                                }
                                                ?>
                                              </select>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <?php }if(trim(PageContext::$response->contact_city) == "true"){ ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="city" id="city" placeholder="City" autocomplete="off" />
                                        </div>
                                    </div>
                                  <?php } ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="subject"  id="subject" placeholder="Subject *" autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <textarea name="message" id="message" placeholder="Message *"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button type="submit" name="btnSubmit" id="submit" class="btn btn-default cotact-btn" value="Send">Send Message</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php if(trim(PageContext::$response->show_contact_details) == 1){ ?>
                    <div class="col-md-4 contact-pad">
                        <div class="row">
                            <div class="col-md-12 col-sm-6">
                                <div class="contact-block">
                                    <h3>Keep in Touch</h3>
                                    <div class="row ">
                                        <?php if(trim(PageContext::$response->contact_address) <> ""){ ?>
                                        <div class="col-md-12 clearfix">
                                            <div class="type-info pull-left contact-caps">
                                                ADDRESS
                                            </div>
                                            <div class="clearfix"> </div>
                                            <div class="info">
                                                <p class="no-margin"><?php echo stripslashes(PageContext::$response->contact_address); ?></p>
                                            </div>
                                        </div>
                                      <?php }if(trim(PageContext::$response->contact_phone) <> ""){ ?>
                                        <div class="col-md-12 clearfix">
                                            <div class="type-info pull-left contact-caps">
                                                PHONE
                                            </div>
                                            <div class="clearfix"> </div>
                                            <div class="info">
                                                <p class="no-margin"><?php echo stripslashes(PageContext::$response->contact_phone); ?></p>
                                            </div>
                                        </div>
                                        <?php }if(trim(PageContext::$response->contact_email) <> ""){ ?>
                                        <div class="col-md-12 clearfix">
                                            <div class="type-info pull-left contact-caps">
                                                EMAIL
                                            </div>
                                            <div class="clearfix"> </div>
                                            <div class="info">
                                                <p class="no-margin"><?php echo stripslashes(PageContext::$response->contact_email); ?></p>
                                            </div>
                                        </div>
                                        <?php }if(trim(PageContext::$response->skype_address) <> ""){ ?>
                                        <div class="col-md-12 clearfix">
                                            <div class="type-info pull-left contact-caps">
                                                SKYPE
                                            </div>
                                            <div class="clearfix"> </div>
                                            <div class="info">
                                                <p class="no-margin"><?php echo stripslashes(PageContext::$response->skype_address); ?></p>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                  <?php }else{ ?>
                    <div class="col-md-4 contact-pad">&nbsp;</div>
                  <?php } ?>
                </div>
            </div>
        </section>

</div> <!-- Container close -->
