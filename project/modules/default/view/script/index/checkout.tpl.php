<script>
  $(window).load(function() { 
    $('.popup-with-zoom-anim').magnificPopup({
      type: 'inline',
      fixedContentPos: false,
      fixedBgPos: true,
      overflowY: 'auto',
      closeBtnInside: true,
      preloader: false,
      midClick: true,
      removalDelay: 300,
      mainClass: 'my-mfp-zoom-in'
  });
});
</script>

<div class="main">
	<div class="container">
       <div class="plans-head">
       	   <div class="heading"><span><em>Checkout</em></span></div>
       	   <div class="row">
		    <div class="col-md-7">
		    	<h3 class="margin-b-30px">Billing & Shipping</h3>
				<form class="card_purchase" id="subscribeForm" method="post" action="subscribe">
								  <div class="row">
								    <div class="col-md-6">
								    	<div class="form-group">
									    	<label>First Name *</label>
									      	<input type="text" id="firstname" name="firstname" class="form-control" placeholder="First Name">
									    	<div class="clearfix"></div>
									    	<span class="errortext">Please fill the first name</span>
								    	</div>
								    </div>
								    <div class="col-md-6">
								    	<div class="form-group">
									    	<label>Last Name *</label>
									      	<input type="text" class="form-control" name="lastname" id="lastname" placeholder="Last Name">
									      	<div class="clearfix"></div>
									    	<span class="errortext">Please fill the last name</span>
								    	</div>
								    </div>
								  </div>
								  <div class="row">
								  	<div class="col-md-6">
								  		<div class="form-group">
									    	<label>Email *</label>
									      	<input type="text" id="email" name="email" class="form-control" placeholder="Email">
									      	<div class="clearfix"></div>
									    	<span class="errortext">Please fill the valid email</span>
									    </div>
								    </div>
								    <div class="col-md-6">
								    	<div class="form-group">
									    	<label>Company Name</label>
									      	<input type="text" class="form-control" name="companyname" id="companyname" placeholder="Company Name">
									      	<div class="clearfix"></div>
								      	</div>
								    </div>
								  </div>
								  <div class="row">
								  	<div class="col-md-12">
								    	<div class="form-group">
									    	<label>Address *</label>
									      	<input type="text" class="form-control" name="address" id="address" placeholder="Address">
									      	<div class="clearfix"></div>
									    	<span class="errortext">Please fill the address</span>
								      	</div>
								      </div>
								  </div>
								  <div class="clear"> </div>
								  <div class="row">
								    <div class="col-md-6">
								    	<div class="form-group">
									    	<label>City *</label>
									      	<input type="text" id="phone" name="city" class="form-control" placeholder="City">
									      	<div class="clearfix"></div>
									    	<span class="errortext">Please fill the city</span>
								      	</div>
								    </div>
								    <div class="col-md-6">
								    	<div class="form-group">
									    	<label>State/Province *</label>
									      	<select id="billing_state" name="billing[state]" class="form-control pointer">
												<option value="">Select...</option>
												<option value="1">Alabama</option>
												<option value="2">Alaska</option>
												<option value="">..............</option>
											</select>
									      	<div class="clearfix"></div>
								      	</div>
								    </div>
								  </div>
								  <div class="clear"> </div>
								  <div class="row">
								    <div class="col-md-6">
								    	<div class="form-group">
									    	<label>Zip/Postal Code *</label>
									      	<input type="text" id="phone" name="zip" class="form-control" placeholder="Zipcode">
									      	<div class="clearfix"></div>
									    	<span class="errortext">Please fill the city</span>
								      	</div>
								    </div>
								    <div class="col-md-6">
								    	<div class="form-group">
									    	<label>Country *</label>
									      	<select id="billing_country" name="billing[country]" class="form-control pointer">
												<option value="">Select...</option>
												<option value="1">united States</option>
												<option value="2">united Kingdom</option>
												<option value="">..............</option>
											</select>
									      	<div class="clearfix"></div>
								      	</div>
								    </div>
								  </div>
								  <div class="clear"> </div>
								  <div class="row">
								    <div class="col-md-6">
								    	<div class="form-group">
									    	<label>Phone *</label>
									      	<input type="text" id="phone" name="phone" class="form-control" placeholder="Phone">
									      	<div class="clearfix"></div>
									    	<span class="errortext">Please fill the valid phone</span>
								      	</div>
								    </div>
								    <div class="col-md-6">
								    	<div class="form-group">
									    	<label>Fax</label>
									      	<input type="text" class="form-control" name="address" id="address" placeholder="Address">
									      	<div class="clearfix"></div>
									    	<span class="errortext">Please fill the address</span>
								      	</div>
								    </div>
								  </div>
									
								</form>
								<hr class="margin-t-20px margin-b-20px">
								<div class="clearfix"> </div>
								<div class="row">
									<div class="col-lg-12 m-0 clearfix margin-b-20px">
										<label class="checkbox float-left"><!-- see assets/js/view/demo.shop.js - CHECKOUT section -->
											<input id="shipswitch" name="shipping[same_as_billing]" type="checkbox" value="1" checked="checked">
											<i></i> <span class="fw-300">Ship to the same address</span>
										</label>
									</div>

								</div>
								<div class="clearfix"></div>
								<h4 class="margin-b-30px">Shipping Address</h4>
								<form class="card_purchase" id="subscribeForm" method="post" action="subscribe">
								  <div class="row">
								    <div class="col-md-6">
								    	<div class="form-group">
									    	<label>First Name *</label>
									      	<input type="text" id="firstname" name="firstname" class="form-control" placeholder="First Name">
									    	<div class="clearfix"></div>
									    	<span class="errortext">Please fill the first name</span>
								    	</div>
								    </div>
								    <div class="col-md-6">
								    	<div class="form-group">
									    	<label>Last Name *</label>
									      	<input type="text" class="form-control" name="lastname" id="lastname" placeholder="Last Name">
									      	<div class="clearfix"></div>
									    	<span class="errortext">Please fill the last name</span>
								    	</div>
								    </div>
								  </div>
								  <div class="row">
								  	<div class="col-md-6">
								  		<div class="form-group">
									    	<label>Email *</label>
									      	<input type="text" id="email" name="email" class="form-control" placeholder="Email">
									      	<div class="clearfix"></div>
									    	<span class="errortext">Please fill the valid email</span>
									    </div>
								    </div>
								    <div class="col-md-6">
								    	<div class="form-group">
									    	<label>Company Name</label>
									      	<input type="text" class="form-control" name="companyname" id="companyname" placeholder="Company Name">
									      	<div class="clearfix"></div>
								      	</div>
								    </div>
								  </div>
								  <div class="row">
								  	<div class="col-md-12">
								    	<div class="form-group">
									    	<label>Address *</label>
									      	<input type="text" class="form-control" name="address" id="address" placeholder="Address">
									      	<div class="clearfix"></div>
									    	<span class="errortext">Please fill the address</span>
								      	</div>
								      </div>
								  </div>
								  <div class="clear"> </div>
								  <div class="row">
								    <div class="col-md-6">
								    	<div class="form-group">
									    	<label>City *</label>
									      	<input type="text" id="phone" name="city" class="form-control" placeholder="City">
									      	<div class="clearfix"></div>
									    	<span class="errortext">Please fill the city</span>
								      	</div>
								    </div>
								    <div class="col-md-6">
								    	<div class="form-group">
									    	<label>State/Province *</label>
									      	<select id="billing_state" name="billing[state]" class="form-control pointer">
												<option value="">Select...</option>
												<option value="1">Alabama</option>
												<option value="2">Alaska</option>
												<option value="">..............</option>
											</select>
									      	<div class="clearfix"></div>
								      	</div>
								    </div>
								  </div>
								  <div class="clear"> </div>
								  <div class="row">
								    <div class="col-md-6">
								    	<div class="form-group">
									    	<label>Zip/Postal Code *</label>
									      	<input type="text" id="phone" name="zip" class="form-control" placeholder="Zipcode">
									      	<div class="clearfix"></div>
									    	<span class="errortext">Please fill the city</span>
								      	</div>
								    </div>
								    <div class="col-md-6">
								    	<div class="form-group">
									    	<label>Country *</label>
									      	<select id="billing_country" name="billing[country]" class="form-control pointer">
												<option value="">Select...</option>
												<option value="1">united States</option>
												<option value="2">united Kingdom</option>
												<option value="">..............</option>
											</select>
									      	<div class="clearfix"></div>
								      	</div>
								    </div>
								  </div>
								  <div class="clear"> </div>
								  <div class="row">
								    <div class="col-md-6">
								    	<div class="form-group">
									    	<label>Phone *</label>
									      	<input type="text" id="phone" name="phone" class="form-control" placeholder="Phone">
									      	<div class="clearfix"></div>
									    	<span class="errortext">Please fill the valid phone</span>
								      	</div>
								    </div>
								    <div class="col-md-6">
								    	<div class="form-group">
									    	<label>Fax</label>
									      	<input type="text" class="form-control" name="address" id="address" placeholder="Address">
									      	<div class="clearfix"></div>
									    	<span class="errortext">Please fill the address</span>
								      	</div>
								    </div>
								  </div>
									
								</form>
		     </div>

	         <div class="col-md-5">
							<div class="pricing-table-grid">
								<h3 class="paymenthd">Payment Method</h3>
								<ul>
									<li>
										<form class="card_purchase" id="paymentForm">
											    <div class="col-md-12">
											    	<div class="form-group">
												    	<label>Name on card *</label>
												      	<input type="text" class="form-control" placeholder="Name on card">
												      	<div class="clearfix"></div>
												    	<span class="errortext">Please fill the Name</span>
											      	</div>
											    </div>
											    <div class="col-md-12">
											    	<div class="form-group">
												    	<label>Credit Card Type *</label>
												      	<select id="payment:state" name="payment[state]" class="form-control pointer">
															<option value="">Select...</option>
															<option value="AE">American Express</option>
															<option value="VI">Visa</option>
															<option value="MC">Mastercard</option>
															<option value="DI">Discover</option>
														</select>
												      	<div class="clearfix"></div>
												    	<span class="errortext">Please fill the card type</span>
											      	</div>
											    </div>
											    <div class="col-md-12">
											    	<div class="form-group">
												    	<label>Card number *</label>
												      	<input type="text" class="form-control" placeholder="Card number">
												      	<div class="clearfix"></div>
												    	<span class="errortext">Please fill the card number</span>
											      	</div>
											    </div>
											  	<div class="form-group">
												  	<div class="col-md-12">
												    	<label>Expiration date *</label>
												    </div>
												    <div class="col-md-6">
												      <input type="text" class="form-control" placeholder="Month">
												    </div>
												    <div class="col-md-6">
												      <input type="text" class="form-control" placeholder="Year">
												    </div>
												    <div class="clearfix"></div>
												    <div class="col-md-12">
												    	<span class="errortext">Please fill the expiration date</span>
												    </div>
											    </div>
											    <div class="col-md-12">
											    	<div class="form-group">
												    	<label>CVV2 *</label>
												      	<input type="text" class="form-control" placeholder="CVV2">
												      	<div class="clearfix"></div>
												    	<span class="errortext">Please fill the CVV</span>
											      	</div>
											    </div>
											<div class="clearfix"> </div>
											</form>
									</li>
									<li>
										<span class="total">
											<div class="leftside">TOTAL</div>
											<div class="rightside">$128.75</div>
										</span>
									</li>
								</ul>
								<a class="popup-with-zoom-anim order-btn" href="#small-dialog">Place Order Now</a>
							</div>
		    </div>
	        </div>
		    <div class="clearfix"> </div>
       </div>
   </div>
</div>
