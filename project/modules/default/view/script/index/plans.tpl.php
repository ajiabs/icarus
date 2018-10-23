<div class="container">

    <!-- Title -->
        <div class="row container-div-pad">
            <div class="col-lg-12 plan-label">
                <h3><span>Pick a plan & sign up in 60 seconds.</span> Upgrade, downgrade, cancel at any time.</h3>
            </div>
        </div>
    <div class="row text-center"> 
            {foreach PageContext::$response->planlist as $planList}
            <div class="col-md-4">
                <div class="thumbnail">
                    <img src="http://placehold.it/800x500" alt="">
                    <div class="caption">
                        <h3>{$planList->plan_name}</h3>
                        <h4>{$planList->plan_desc}</h4>
                        <p><h3>${$planList->plan_amount}</h3> per Month</p>
                        <p>
                            <a class="btn btn-primary" href="{PageContext::$response->BASE_URL}register/{$planList->plan_id}">Get Started</a>
                        </p>
                    </div>
                </div>
            </div>
            {/foreach}
        </div>
</div>




