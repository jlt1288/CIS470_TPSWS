<?php if (isset($_POST['edit']) || isset($_GET['edit'])){ ?>
<script type="text/javascript">

  document.addEventListener("DOMContentLoaded", function() {

    // JavaScript form validation
    var checkPassword = function(str)
    {
      var re = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}$/;
      return re.test(str);
    };

    var checkForm = function(e)
    {
      if(this.pwd.value != "") {
		if (this.pwd.value == this.confirm_pwd.value){
	        return true;
        }else{
			this.pwd.focus();
	        e.preventDefault();
			return false;
		}
      } else {
        return true;
      }
    };

    var myForm = document.getElementById("account");
    myForm.addEventListener("submit", checkForm, true);

    // HTML5 form validation

    var supports_input_validity = function()
    {
      var i = document.createElement("input");
      return "setCustomValidity" in i;
    }

    if(supports_input_validity()) {
      var usernameInput = document.getElementById("current_pwd");
      //usernameInput.setCustomValidity(usernameInput.title);

      var pwd1Input = document.getElementById("pwd");
      //pwd1Input.setCustomValidity(pwd1Input.title);

      var pwd2Input = document.getElementById("confirm_pwd");

      // input key handlers

      usernameInput.addEventListener("keyup", function() {
        usernameInput.setCustomValidity(this.validity.patternMismatch ? usernameInput.title : "");
      }, false);

      pwd1Input.addEventListener("keyup", function() {
        this.setCustomValidity(this.validity.patternMismatch ? pwd1Input.title : "");
        if(this.checkValidity()) {
          pwd2Input.pattern = this.value;
          pwd2Input.setCustomValidity(pwd2Input.title);
        } else {
          pwd2Input.pattern = this.pattern;
          pwd2Input.setCustomValidity("");
        }
      }, false);

      pwd2Input.addEventListener("keyup", function() {
        this.setCustomValidity(this.validity.patternMismatch ? pwd2Input.title : "");
      }, false);

    }

  }, false);

</script><?php } ?>