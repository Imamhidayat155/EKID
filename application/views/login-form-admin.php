
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Login | ENKEI <?php echo $this->config->item('app')?></title>
        <link rel="icon" type="image/x-icon" href="<?php echo base_url()?>assets/assets_new/images/faviconn.jpeg" />

        <link href="<?php echo base_url()?>assets/assets_new/css/styles.css" rel="stylesheet" />
        <!-- animation -->
        <link rel="stylesheet" href="<?php echo base_url()?>assets/assets_new/css/animate.min.css">

        <script data-search-pseudo-elements defer src="<?php echo base_url()?>assets/assets_new/js/font-awesome-5.15.3-all.min.js" crossorigin="anonymous"></script>
        <script src="<?php echo base_url()?>assets/assets_new/js/feather.min.js" crossorigin="anonymous"></script>

    </head>
    <style>
        .css-selector {
            background: linear-gradient(272deg, #ff0000, #ffff00);
            background-size: 400% 400%;
            -webkit-animation: AnimationName 10s ease infinite;
            -moz-animation: AnimationName 10s ease infinite;
            animation: AnimationName 10s ease infinite;
        }

        @-webkit-keyframes AnimationName {
            0%{background-position:0% 50%}
            50%{background-position:100% 50%}
            100%{background-position:0% 50%}
        }
        @-moz-keyframes AnimationName {
            0%{background-position:0% 50%}
            50%{background-position:100% 50%}
            100%{background-position:0% 50%}
        }
        @keyframes AnimationName {
            0%{background-position:0% 50%}
            50%{background-position:100% 50%}
            100%{background-position:0% 50%}
        }
        .field-icon {
            /* position: absolute;
            display: inline-block;
            cursor: pointer;
            right: 3.0rem; */
            /* top: 22.1rem; */
            /* color: $input-label-color; */
            /* z-index: 2; */
        }

        @media (min-width:994px) { /**tampilan desktop */   
            /* .field-icon {
                top: 22.1rem;
            } */
        }

        @media (min-width: 320px) and (max-width: 480px) { /**tampilan mobile */   
            /* .field-icon {
                top: 23.5rem;
            } */
        }

    </style>

    <body class="bg-primary-old css-selector">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container-xl px-4">
                        <div class="row justify-content-center">
                            <div class="col-xl-5 col-lg-6 col-md-8 col-sm-11">
                                <!-- Social login form-->
                                <div class="card my-5">
                                    <div class="card-body p-3 text-center animated fadeInRight1 delay-1s">
                                        <div class="h3 fw-light mb-3">Sign In</div>
                                    </div>
                                    <div class="card-body p-1 text-center animated bounceInDown delay-1s">
                                        <div class="h3 fw-light mb-3"><?php echo $this->config->item('nama_app')?></div>
                                    </div>
                                    <div class="text-center animated zoomIn delay-1s" style="margin-bottom: 10px;">
                                        <img id="" class="img-thumbnail" src="<?php echo base_url()?>assets/assets_new/images/logo-enkei.png" style="height:60px;width:auto;">
                                    </div>
                                    <hr class="my-0" />
                                    <div class="card-body p-5">
                                        <!-- Login form-->
                                        <form method="post" action="<?php echo base_url('login/aksi_login_admin')?>">
                                            
                                            <label class="text-gray-600 small" for="emailExample">Handpunch PIN</label>
                                            <div class="input-group input-group-joined mb-3">
                                                <input class="form-control form-control-solid" type="text" name="username" value="<?=$username?>" placeholder="Username" aria-label="Email Address" aria-describedby="emailExample" />
                                            </div>

                                            <label class="text-gray-600 small" for="passwordExample">Password</label>
                                            <div class="input-group input-group-joined mb-3">
                                                <input id="password-field" class="form-control form-control-solid" type="password" name="password" value="<?=$password?>" placeholder="Password" autocomplete="off" aria-label="Password" aria-describedby="passwordExample" />
                                                <!-- <input id="password-field" class="form-control" type="password" name="password" required="" placeholder="Password">  -->
                                                <span onclick="return toogle_password()" id="toggle-password" toggle="#password-field" class="input-group-text field-icon toggle-password">
                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                </span>
                                            </div>
                                            
                                            <div class="d-flex align-items-center justify-content-between mb-0">
                                                <div class="form-check">
                                                    <input class="form-check-input" id="remember_me" type="checkbox" value="0" name="remember_me" onclick="get_checked()"/>
                                                    <label class="form-check-label" for="remember_me">Remember Me</label>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Login</button>
                                            </div>
                                        </form>
                                    </div>
                                    <hr class="my-0" />
                                    <div class="card-body px-5 py-4">
                                        <div class="small text-center">
                                            Copyright &copy; <?php echo $this->config->item('programmer')?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="footer-admin mt-auto footer-dark">
                    <div class="container-xl px-4">
                        <div class="row">
                            <div class="col-md-6 small">Development &copy; <?php echo $this->config->item('app')?> | 2021</div>
                            <div class="col-md-6 text-md-end small">
                                <a href="#!">Privacy Policy</a>
                                &middot;
                                <a href="#!" onclick="return alert('Silahkan hubungi Admin Janisoft.co')">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="<?php echo base_url()?>assets/assets_new/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="<?php echo base_url()?>assets/assets_new/js/scripts.js"></script>
        <script src="<?php echo base_url()?>assets/assets_new/js/jquery-3.3.1.js"></script>
                
        <script>

            $( document ).ready( function () {
                var is_cookies = <?=$is_cookies?>;
                if(is_cookies == 1) {
                    $("#remember_me").prop('checked', true);
                    $("#remember_me").val(1);
                }
            });

            // toggle password visibility
            function toogle_password(){
                var thiss = $('#toggle-password').attr("toggle");
                // alert(thiss)

                var input = $(thiss);
                if (input.attr("type") == "password") {
                    input.attr("type", "text");
                    $('#toggle-password').html('<i class="fa fa-eye-slash" aria-hidden="true"></i>');
                } else {
                    input.attr("type", "password");
                    $('#toggle-password').html('<i class="fa fa-eye" aria-hidden="true"></i>');
                }
            }

            function get_checked() {
                var is_checked = $("input[name='remember_me']:checked").val();
                // alert(is_checked)
                if($("#remember_me").is(":checked")){
                    $('#remember_me').val(1);
                }else{
                    $('#remember_me').val(0);
                    // var tes = $('#remember_me').val(); alert(tes)
                }
            };

        </script>

    </body>
    
</html>
