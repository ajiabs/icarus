
<div class="container container-div">
    <div class="row container-div-pad">
        <div class="col-lg-12">
            <h3>Your account has been successfully created</h3><br><br>
            {if PageContext::$response->SAAS ==true && PageContext::$response->dynamicdb ==true}
            <p>Your  application ID is <strong>{PageContext::$response->appid}</strong></p>
            <p>Click <a href="{php} echo BASE_URL;{/php}app/">here</a> to get started now</p>
            {else}
            <p>Click <a href="{php} echo BASE_URL;{/php}login/">here</a> to get started now</p>
            {/if}
        </div>
    </div>
</div>
