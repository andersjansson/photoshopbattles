function AjaxHelper()

{

   	if(!this.createXmlHttpObject())

   		alert("Ajax error!");

}



	AjaxHelper.prototype.createXmlHttpObject = function() 

	{

	    if(this.xmlHttp = new XMLHttpRequest())

			return true;

		else{

			if(this.xmlHttp = new ActiveXObject("Microsoft.XMLHttp"))

				return true;

			else

				return false;

		}	

	}



	AjaxHelper.prototype.set = function(type, url, params, async)

	{

		this.type 	  = typeof type   !== 'undefined' ? type 	 : "GET";

		this.url 	  = typeof url 	  !== 'undefined' ? url 	 : "lib/ajax.php";

		this.params   = typeof params !== 'undefined' ? params 	 : "";

		this.async    = typeof async  !== 'undefined' ? async 	 : true;



		switch(type){

    		case "POST":

    			this.contentType = "application/x-www-form-urlencoded";

    			break;

    		default:

    			this.contentType = "";

    	}

	}



	AjaxHelper.prototype.process = function(howToHandleResponse) 

	{

        if (this.xmlHttp) {



	        this.xmlHttp.onreadystatechange = this.handleRequestStateChange(howToHandleResponse);

	        this.xmlHttp.open(this.type, this.url, this.async);

	        this.xmlHttp.setRequestHeader("Content-Type", this.contentType);

	        this.xmlHttp.send(this.params);

	    }

	    else{

	        alert("Unable to connect to server");

	    }

	}



	AjaxHelper.prototype.handleRequestStateChange = function(howToHandleResponse) 
	{
	    var _this = this;

	    return function() {
            if (_this.xmlHttp.readyState == 4 && _this.xmlHttp.status == 200) {

            	switch(howToHandleResponse){
					case "isLoggedIn":
						_this.isLoggedInResponse();

						break;

					default:

						_this.handleServerResponse();

				}

            }

	    };

	}

	AjaxHelper.prototype.isLoggedIn = function() 

	{

	    this.set("GET", "lib/ajax.php?check_login=yes", "", false);

	    this.process("isLoggedIn");

	}



	AjaxHelper.prototype.isLoggedInResponse = function()

	{

		if(this.xmlHttp.responseText == "true")

	    	this.loggedIn = true;

	    else 

	    	this.loggedIn = false;

	}



	AjaxHelper.prototype.handleServerResponse = function() 

	{

	    

	}



	







function VoteHelper()

{

	AjaxHelper.call(this);

}



VoteHelper.prototype = Object.create( AjaxHelper.prototype );

VoteHelper.prototype.constructor = VoteHelper;



	VoteHelper.prototype.init = function(votesArrayObject)

	{

		this.upArrows     = document.getElementsByClassName("icon-arrow-up");

		this.downArrows   = document.getElementsByClassName("icon-arrow-down");

		this.voteDivs     = document.getElementsByClassName("voting");

		this.votesObject  = votesArrayObject;



		this.initialScore = Array();

		this.isLoggedIn();



		this.setupListeners(this.upArrows);

		this.setupListeners(this.downArrows);

	}



	VoteHelper.prototype.setupListeners = function(nodeList)

	{	

		_this = this;



		for(var i = 0; i < nodeList.length; i++){

			

			nodeList[i].addEventListener("click", function(e){

				if(_this.loggedIn){		

					e.preventDefault();

					var parent = this.parentElement;

					var image  = parent.getAttribute("name");

											

					if(this.className.indexOf("up") === -1){

						var vote = -1;

					}



					else{

						var vote = 1;

					}



					_this.updateVoteArrows(image, vote, parent);

				}

				else

					alert("You need to be logged in to vote.");

			});

		}

	}



	VoteHelper.prototype.handleServerResponse = function() 

	{

	    if(this.xmlHttp.responseText){

	    	//document.getElementById("test").innerHTML = this.xmlHttp.responseText;

	    	

	    }

	}



	VoteHelper.prototype.updateVoteArrows = function(image, vote, parent)

	{

		var currentScore  = parseInt(parent.children[1].innerHTML, 10);

		var previousVote  = (this.votesObject[image] !== null) ? this.votesObject[image] : 0;

		var newVote       = vote;



		if(newVote === previousVote){

			parent.children[0].className = "icon-arrow-up";

			parent.children[2].className = "icon-arrow-down";

			parent.children[1].innerHTML = currentScore-newVote;

			this.set("GET", "lib/ajax.php?score="+0+"&img="+image);

			this.votesObject[image] = 0;

		}



		else if(newVote > 0){

			parent.children[0].className = "icon-arrow-up orange";

			parent.children[2].className = "icon-arrow-down";

			this.set("GET", "lib/ajax.php?score="+newVote+"&img="+image);

			if(previousVote === 0)

				parent.children[1].innerHTML = currentScore+1;

			if(previousVote < 0)

				parent.children[1].innerHTML = currentScore+2;

			this.votesObject[image] = 1;

		}



		else if(newVote < 0){

			parent.children[0].className = "icon-arrow-up";

			parent.children[2].className = "icon-arrow-down blue";

			this.set("GET", "lib/ajax.php?score="+newVote+"&img="+image);

			if(previousVote === 0)

				parent.children[1].innerHTML = currentScore-1;

			if(previousVote > 0)

				parent.children[1].innerHTML = currentScore-2;

			this.votesObject[image] = -1;

		}

		

		this.process();

	}

