<script src="{php} echo BASE_URL; {/php}project/js/validations.js"></script>

<div class="container container-div" style="padding-top: 10px;">

{if PageContext::$response->staticPageContent}                       
<div class="entry">
    <h3 class="bhimqr"><span>{PageContext::$response->staticPageTitle}</span></h3>
    <div>{PageContext::$response->staticPageContent}</div>
</div>                 
{/if}  
	<h3 class="bhimqr"><span>Contact us</span></h3>
	<div class="row">
					<div class="col-md-7">
						<form class="contact-form-wrapper usersignform" name="contact_form" id="contactform" method="post" novalidate="novalidate">
                                                    <div class="clearfix"></div>
                <div class="{php} echo $_SESSION['message_class'];{/php}" id="jpmessage">
                {php} echo $_SESSION['page_message'];
                    $_SESSION['page_message']='';
                    $_SESSION['message_class']='';
                {/php}
               
                </div>
                
                <div class="clearfix"></div>
								<div class="form-group row">
				                    <label class="col-md-1 col-form-label"><i class="fa fa-user-o" aria-hidden="true"></i> </label>
				                    <div class="col-md-11">
				                        <input type="text" class="form-control {literal}{validate:{required:true, messages:{required:&quot;Please enter your name&quot;,}}}{/literal}" name="name" placeholder="Name">
				                    </div>
				                </div>
				                <div class="form-group row">
				                    <label class="col-md-1 col-form-label"><i class="fa fa-envelope-o" aria-hidden="true"></i></label>
				                    <div class="col-md-11">
				                        <input type="email" class="form-control input-email fill-this {literal}{validate:{required:true, messages:{required:&quot;Please enter your email&quot;,}}}{/literal}" name="email" placeholder="Email">
				                    </div>
				                </div>
				                <div class="form-group row">
				                    <label class="col-md-1 col-form-label"><i class="fa fa-mobile" aria-hidden="true"></i> </label>
				                    <div class="col-md-11">
				                        <input type="text" class="form-control {literal}{validate:{required:true, messages:{required:&quot;Please enter your contact number&quot;,}}}{/literal}" name="phone" placeholder="Phone">
				                    </div>
				                </div>
				                <div class="form-group row">
				                    <label class="col-md-1 col-form-label"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></label>
				                    <div class="col-md-11">
				                        <textarea class="form-control {literal}{validate:{required:true, messages:{required:&quot;Please enter your message&quot;,}}}{/literal}" name="message" rows="3" placeholder="Message"></textarea>
				                    </div>
				                </div>
								<div class="form-group row">
									<label class="col-md-1 col-form-label"></label>
									<div class="col-md-11">
										<input class="btn btn-default" type="submit" name="btnContact" id="btnContact" value="Send Message">
									</div>
								</div>
						</form>
					</div>
					<div class="col-md-offset-1 col-md-4">
						<div class="contact_rt_section">
						<p>
							<b class="text-dark"><i class="fa fa-phone" aria-hidden="true"></i> Phone</b>
							91-484-2415227
							<div class="clearfix"></div>
						</p>
						<p>
							<b class="text-dark"><i class="fa fa-envelope-o" aria-hidden="true"></i> Email</b>
							support@bhim.io
							<div class="clearfix"></div>
						</p>
						<p>
							<b><i class="fa fa-map-marker" aria-hidden="true"></i> Address</b>
							Bhim.io, Vismaya Buildings Infopark <br/>
							Cochin 682042 India
							<div class="clearfix"></div>
						</p>
						</div>
					</div>
                </div>
</div>


