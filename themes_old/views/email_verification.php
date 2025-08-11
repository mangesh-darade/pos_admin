<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<main id="main">
    <section id="trial" style="">
        <header class="section-header" style="padding-top:140px;">
            
        </header>
        <div class="row">
            <div class="col-md-12 left_box wow fadeInUp">
                <div class="form" style="padding-top:30px;">
                    <div class="text-center">


                        <?php if ($_GET['verification'] == "success") : ?> 
                            <h1 style="font-family: sans-serif; font-size: 40px; font-weight: normal; text-align: center; color: #777; padding: 15px 50px; border-bottom: thin solid #999;" class="text-center">Congratulation <?php echo $_GET['name']; ?>!</h1>


                            <div class="alert alert-success"><i class="fa fa-check" aria-hidden="true"></i> Verification  Successfully Completed.</div>
                        <?php endif; ?>     

                        <?php
                        if (isset($responseData['status']) === 'ERROR') {
                            ?>
                            <h1 style="font-family: sans-serif; font-size: 40px; font-weight: normal; text-align: center; color: #777; padding: 15px 50px; border-bottom: thin solid #999;" class="text-center"> <?php echo $responseData['msg']; ?>!</h1>


                            <div class="alert alert-danger"><i class="fa fa-close" aria-hidden="true"></i> <?php echo $responseData['response']['error']; ?></div>
                            <?php
                        }//End if Status === ERROR
                        ?>

                    </div>
                    
                </div>
            </div>
        </div>
    </section>
</main>    