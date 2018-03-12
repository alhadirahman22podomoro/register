<div class="container">
    <header>
        <h1>Upload Proof of Payment</h1>
    </header>
    <section>       
        <div id="container_demo" >
            <!-- hidden anchor to stop jump http://www.css3create.com/Astuce-Empecher-le-scroll-avec-l-utilisation-de-target#wrap4  -->
            <a class="hiddenanchor" id="toregister"></a>
            <a class="hiddenanchor" id="tologin"></a>
            <div id="wrapper">
                <div id="login" class="animate form">
                    <div align = "center">
                      <img src="<?php echo base_url('images/logo_tr.png'); ?>" alt="Podomoro University" /> 
                    </div>
                    <br>
                    <p> 
                        <label for="firstname" class="uname" >Firstname</label>
                        <input id="firstname" name="username" required="required" type="text" placeholder="Your Firstname"/>
                    </p>
                    <p> 
                        <label for="lastname" class="uname" > Lastname</label>
                        <input id="lastname" name="username" required="required" type="text" placeholder="Your Lastname"/>
                    </p>
                    <p> 
                        <label class="youpasswd"> Email </label>
                        <input id="regEmail" name="password" required="required" type="email" placeholder="myusername or mymail@mail.com" /> 
                    </p>
                    <p> 
                        <label class="youpasswd"> Upload File </label>
                        <input type="file" id="uploadFile" name="uploadfile">
                    </p>
                    <p class="signin button"> 
                      <button class="btn btn-inverse btn-notification" id="sbmt-reg">Submit</button>
                    </p>
                </div>
            </div>
        </div>  
    </section>
</div>

<script type="text/javascript">
$(document).ready(function() {
    
});

</script>

