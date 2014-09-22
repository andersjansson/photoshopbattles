var changeAvatarForm 	= document.getElementById("avatar-edit");
var changeAvatarButton 	= document.getElementById("change-avatar-button");
var editInfoForm	   	= document.getElementById("info-edit");
var editInfoButton 	   	= document.getElementById("change-info-button");
var userInfo 			= document.getElementById("user-info");
var showingAvatarForm  	= false;
var showingInfoForm    	= false;

changeAvatarButton.addEventListener("click", function(e){
	e.preventDefault();

	if(showingAvatarForm){
		hideForm("avatar-edit", "Change avatar");
		showingAvatarForm = false;
	}
	else{
		showForm("avatar-edit", "Never mind, don't change it");
		showingAvatarForm = true;
	}

	hideForm("info-edit", "Edit your information");
	showingInfoForm = false;
	
});

editInfoButton.addEventListener("click", function(e){
	e.preventDefault();

	if(showingInfoForm){
		hideForm("info-edit", "Edit your information");
		userInfo.className = "info";
		showingInfoForm = false;
	}
	else{
		showForm("info-edit", "Never mind, don't change it");
		userInfo.className += " invisible";
		showingInfoForm = true;
	}

	hideForm("avatar-edit", "Change avatar");
	showingAvatarForm = false;
});

function hideForm(formId, buttonText)
{
	theForm = document.getElementById(formId);
	theForm.className += " invisible";
	button = getNextElementSibling(theForm);
	button.innerHTML = buttonText;
}

function showForm(formId, buttonText)
{
	theForm = document.getElementById(formId);
	theForm.className = "form";
	button = getNextElementSibling(theForm);
	button.innerHTML = buttonText;
}

function getNextElementSibling(node)
{
	do {
        node = node.nextSibling;
    } while (node && node.nodeType !== 1);
    
    return node; 
}