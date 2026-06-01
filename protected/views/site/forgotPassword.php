<div class="row topPadding" >
    <div class="small-12 medium-10 medium-centered large-6 large-centered columns">
    <h3 class="text-center">Retrieve Password</h3>
    <p class="text-center">Please enter your <b>username</b> or <b>email</b> below.
        <br/>We will send you your new password</p>
    </div>
       <form id="forgotPasswordForm" name="forgotPasswordForm" method="POST">

        <div class="small-12 medium-5 medium-centered large-3 large-centered columns">

                <?php 
                echo CHtml::textField('username', '', 
                    array(
                        'Placeholder' => 'Username',
                        'size'=>20,
                    )
                ); 
            ?>
                                <?php 
                    echo CHtml::submitButton('Submit',
                        array(
                            "class" => "button tiny",
                            'role'=>'button'
                        )
                    );
                    
                    if(isset($msg)){
                    echo "<br/><b>$msg</b>";
                }
                    
                    
                ?>

        </div>

    </form>

 

</div>
