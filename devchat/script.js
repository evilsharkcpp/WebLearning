$(".messages").animate({ scrollTop: $(document).height() }, "fast");

$("#profile-img").click(function() {
	$("#status-options").toggleClass("active");
});

$(".expand-button").click(function() {
  $("#profile").toggleClass("expanded");
	$("#contacts").toggleClass("expanded");
});

function getId(userid, fun,fun2)
{
	$.ajax({
		url: 'index.php',
		type: 'post',
		data: 
		{ 
			"getSessionId": "1",
		},
		success: function(response) {
			fun(userid, $.trim(response),fun2);
		}
	});
}
function createRoom(userid, id,fun)
{
	$.ajax({
		url: 'functions.php',
		type: 'post',
		data: 
		{ 
			"createRoom": "1",
			"userid": userid,
			"senderid" : id,
		},
		success: function(response) { 
			roomid = response;
			console.log(roomid);
			fun($.trim(roomid));
			$(".contact.active").attr("id",$.trim(roomid));
		}
	});
}
function loadMsg(roomid)
{
	var msg = $(".messages").find("ul#" + roomid);
	console.log(msg);
	if(typeof $(msg).attr("id") == "undefined")
	{
		var str = '"' + roomid + '"';
		var obj = $("<ul id="+str+"></ul>");
		console.log($(obj).appendTo($(".messages")));
		msg = $(".messages").find("ul#" + roomid);	
	}
	$(msg).removeAttr("hidden");
}
$(document).on('click','.contact',function(e){
	var prevObj = $(".contact.active");
	console.log($(prevObj));
	$(prevObj).removeClass("active");
	//$($(".messages").find("ul#" + $(prevObj).attr("id"))).removeAttr("hidden");
	$($(".messages").find("ul#" + $(prevObj).attr("id"))).attr("hidden","hidden");
	//console.log($($(".messages").find("ul#" + $(prevObj).attr("id"))).addClass("ng-hide"));
	console.log(e.currentTarget);
	$(e.currentTarget).addClass("active");
	
	var roomid = $(".contact.active").attr("id");
	var userid = $(".contact.active .meta .name").attr("id");
	console.log(userid);
	console.log(roomid);
	var id;
	
	console.log("Your id: " + id);
	if (roomid == -1)
	{
		getId(userid,createRoom,loadMsg);
	}
	else
		loadMsg(roomid);
	//Load messages
	$.ajax({
		url: 'functions.php',
		type: 'post',
		data: 
		{ 
			"getUser": "1",
			"userid": userid,
		},
		success: function(response) { 
			var tmp = $.trim(response);
			$(".contact-profile").html(tmp);
		}
	});
	var div = $(".messages");
	div.scrollTop(div.prop('scrollHeight'));
	//$(msg).attr("hidden");
});
$("#status-options ul li").click(function() {
	$("#profile-img").removeClass();
	$("#status-online").removeClass("active");
	$("#status-away").removeClass("active");
	$("#status-busy").removeClass("active");
	$("#status-offline").removeClass("active");
	$(this).addClass("active");
	
	if($("#status-online").hasClass("active")) {
		$("#profile-img").addClass("online");
	} else if ($("#status-away").hasClass("active")) {
		$("#profile-img").addClass("away");
	} else if ($("#status-busy").hasClass("active")) {
		$("#profile-img").addClass("busy");
	} else if ($("#status-offline").hasClass("active")) {
		$("#profile-img").addClass("offline");
	} else {
		$("#profile-img").removeClass();
	};
	
	$("#status-options").removeClass("active");
});
function getYourId(roomid, message, fun)
{
	$.ajax({
		url: 'index.php',
		type: 'post',
		data: 
		{ 
			"getSessionId": "1",
		},
		success: function(response) {
			fun(roomid,message, $.trim(response));
		}
	});
}
function sendMessage(roomid,message,senderid)
{
	$.ajax({
		url: 'functions.php',
		type: 'post',
		data: 
		{ 
			"pushMessage": "1",
			"message": message,
			"roomid": roomid,
			"senderid":senderid
		},
		success: function(response) { 
			roomid = response;
			console.log(roomid);
			//$(".contact.active").attr("id",$.trim(roomid));
		}
	});
}
var oldResponce="";
var oldResponce2="";

function forRedraw(fun)
{
	$.ajax({
		url: 'index.php',
		type: 'post',
		data: 
		{ 
			"getSessionId": "1",
		},
		success: function(response) {
			fun($.trim(response));
		}
	});
}

function redrawMessage($id)
{
	$.ajax({
		url: 'functions.php',
		type: 'post',
		data: 
		{ 
			"drawAllMessage": "1",
			"yourId":$id,
			"activeId":$('.contact.active').attr("id")
		},
		success: function(response) {
			//console.log($.trim(response));
			var tmp = $.trim(response);
			if(tmp !=oldResponce)
			{
				oldResponce = tmp;
				
				var div = $(".messages");
				console.log("scrollHeight: " + div.prop('scrollHeight'));
				var res = div.outerHeight(true) + div.scrollTop();
				console.log("scrollTop: " + res);
				if(div.prop('scrollHeight') - res < 65)
				{
					$(".messages").html($.trim(response));
					div.scrollTop(div.prop('scrollHeight'));
				}
				else
				{
					$(".messages").html($.trim(response));
				}
					
				
			}
			//$(".messages").load("/current.html .messages > *"); 
			
		}
	});
}
function newMessage(txt = "") {
	
	message = $(".message-input input").val();
	if(txt != "null")
	{
		message = txt;
	}
	if($.trim(message) == '') {
		return false;
	}
	//$('<li class="sent"><img src="http://emilcarlsson.se/assets/mikeross.png" alt="" /><p>' + message + '</p></li>').appendTo($('.messages ul'));
	$('.message-input input').val(null);
	//$('.contact.active .preview').html('<span>You: </span>' + message);
	//$(".messages").animate({ scrollTop: $(document).height() }, "fast");
	console.log("Message: "+ message);
	var roomid = $(".contact.active").attr("id");
	getYourId(roomid,message,sendMessage);
};

function redrawContacts($id)
{
	$.ajax({
		url: 'functions.php',
		type: 'post',
		data: 
		{ 
			"getAllContacts": "1",
			"yourId":$id,
			"activeId":$('.contact.active').attr("id"),
		},
		success: function(response) {
			//console.log($.trim(response));
			var tmp = $.trim(response);
			if(tmp != oldResponce2)
			{
				oldResponce2 = tmp;
				console.log(tmp);
				$("#contacts").html($.trim(response));
			}
			//$(".messages").load("/current.html .messages > *"); 
			
		}
	});
}


let timerId = setInterval(forRedraw,500,redrawMessage);
let timerId2 = setInterval(forRedraw,500,redrawContacts);
$('.attachment').click(function(){
	setTimeout(function(){
		$('#uploadedFile').trigger('click');
	  }, 1);
});
$('.submit').click(function() {
	setTimeout(function(){
		$('#upload').trigger('click');
	  }, 1);
    newMessage();
  //$('<li class="contact"></li>').appendTo("#contacts ul");
});

$(window).on('keydown', function(e) {
  if (e.which == 13) {
    newMessage();
    return false;
  }
});
$("#uploadedFile").change(function(){
	if (window.FormData === undefined) {
		alert('В вашем браузере FormData не поддерживается')
	} else {
		var formData = new FormData();
		formData.append('file', $("#uploadedFile")[0].files[0]);
 
		$.ajax({
			type: "POST",
			url: './upload.php',
			cache: false,
			contentType: false,
			processData: false,
			data: formData,
			dataType : 'json',
			success: function(msg){
				if (msg.error == '') {
					$("#uploadedFile").hide();
					console.log(msg.success);
					newMessage(msg.success);
				} else {
					$('#result').html(msg.error);
				}
			}
		});
	}
});
