<div>
    <div>

            <div class="row">
            	<div class="small-12 columns">
                    <br/>
                        Dear subscriber,
                        <?php 
                        
                            if(!empty($_GET['reason'])){
                                echo "<br/><br/>Your session expired.";
                            }
                        ?>
                        <br/><br/>
                        The number of simultaneous users has exceeded. Please ask a colleague to log out of their session or alternatively wait a moment until one of the sessions has expired so you can gain access.
                        <br/><br/>
                        
                        <a class="yes_no" href='index.php?r=site/loginIFrame'>Log In Again</a>		
                </div>
            </div>

            
            
    </div>

    
</div>