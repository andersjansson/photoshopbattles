

function RegisterHelper()
{
	this.signin = document.getElementById("submit_button");
	this.password = document.getElementById("passwordsignup");
	this.passwordConfirm = document.getElementById("passwordsignup_confirm");
	this.theForm = document.getElementsByTagName("form")[0];

	_this = this;

	this.signin.addEventListener("click", function(e){
		if(!_this.checkIfSame(_this.password, _this.passwordConfirm))
			e.preventDefault();
	});
}

	RegisterHelper.prototype.checkIfSame = 
		function(input1, input2) {
			if(input1.value != input2.value)
			{
				var error = this.theForm.appendChild(document.createElement("p"));
					error.appendChild(document.createTextNode("Passwords do not match"));
					error.className = "form-error";

				document.getElementsByClassName("error")[0]

				return false;
			}
			else
				return true;
		};

//regHelp = new RegisterHelper();
