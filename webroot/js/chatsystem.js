$(document).ready(function() {
		auReloadLatestMessages(6000);
	}
);

function auReloadLatestMessages(time) {
    setInterval(function() {
    	getLatestMessage();
    }, time);
}

function getLatestMessage(){
	var dataRequest = $('#MessageThreadId').val() + '/' + $('#MessageLastMessageId').val();
	console.log(dataRequest);
	$.ajax({
        url: 'http://192.168.33.11/chatdemo/messages/getLatestMessage/',
        data: dataRequest,
        type: "POST",
        dataType: 'json',
        beforeSend: function() {
        },
        success: function(response) {
        	if(response){
        		if(response.status == 'success'){
        			
        		}
        	}
        },
        error: function(xhr, status, error){
        	console.log(error);
        }
	});
}
