<div class="dashboard_navigation">
				<div class="sitewidth">
					<ul>
					  <li {php} echo (PageContext::$response->activeSubMenu == 'dashboard')?'class="active"':'';{/php}><a href="{php} echo PageContext::$response->baseUrl;{/php}dashboard">Dashboard</a></li>
					 
					    
	 			   
					  
					</ul>
					<div class="dboard_userdropdown">
						<div class="image">
						 
					   
					 	
						</div>
						<a href="#" class="myaccount" ></a>
                                                <div class="submenu" style="display:none" >
                                                    <ul class="root">
                                                        <li >
                                                           <!--  <a href="{php} echo PageContext::$response->baseUrl;{/php}index/profile" >My Profile</a> -->
                                                             <a href="{php} echo PageContext::$response->baseUrl;{/php}agents/view" >My Profile</a>
                                                        </li>
                                                        
                                                        <li>
                                                            <a href="{php} echo PageContext::$response->baseUrl;{/php}index/logout">Logout</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                
						<div class="clear"></div>
					</div>
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
			</div>