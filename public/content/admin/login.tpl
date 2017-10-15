    <div class="container">
        <br>
        <br>
        <div class="row" id="pwd-container">
            <div class="col-md-4"></div>

            <div class="col-md-4 bg-faded" style="padding: 10px;">
                <section class="login-form">
                    <form method="post" action="/admin/login" role="login">
                        <input name="login" placeholder="Login" required class="form-control input-lg" value="" />
                        <br>
                        <input name="password" type="password" class="form-control input-lg" id="password" placeholder="Password" required="" />
                        <br>
                        <button type="submit" name="go" class="btn btn-lg btn-primary btn-block">Sign in</button>

                        {if !empty($error) }
                            <div style="text-align: center; padding: 10px;">
                                <strong>
                                    <span style="color: #df1009;">
                                        {$error}
                                    </span>
                                </strong>
                            </div>
                        {/if}
                    </form>
                </section>
            </div>

            <div class="col-md-4"></div>
        </div>
    </div>