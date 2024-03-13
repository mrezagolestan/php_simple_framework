<?php sectionStart();?>
<div class="content-wrapper d-flex align-items-center auth">
    <div class="row flex-grow">
        <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left p-5">
                <div class="brand-logo">
                    <img src="/assets/images/logo.svg">
                </div>
                <h4>Hello! let's get started</h4>
                <h6 class="font-weight-light">Sign in to continue.</h6>
                <?php includeView('layout/components/alert'); ?>
                <form class="pt-3" method="post">
                    <div class="form-group">
                        <input type="text" name="username" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Username" value="mreza_golestan">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password" value="helloworld">
                    </div>
                    <div class="mt-3">
                        <input type="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn" value="SIGN IN">
                    </div>
                    <div class="form-group mt-3">
                        <p>username: <b>mreza_golestan</b></p>
                        <p>password: <b>helloworld</b></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php sectionEnd('content'); ?>

<?php layout('simple'); ?>
