$(document).ready(function() {
	const viewTable = $("#table-queue-body");
	var model = null;
	
	function updateModel() {
		$.ajax({
			type: 'POST',
			//url: window.location,
			data: { q: null, get: "" },
			dataType: 'json',
			/*dataFilter: function(data, type) {
				alert(type + "\n" + data);
				return data;
				
			},*/
			success: function(data) {
				//alert("Success:\n" + data);
				//model = (!(data == null || data == '') ? data : false);
				if(data == null || data == '') {
					viewTable.empty();
				} else {
						model = data;
						
						viewTable.empty();
						updateView();
						//alert("Model updated:\n" + model);
				}
			},
			error: function(xmlHttpRequest, err) {
				//alert("Failure:\n" + err + "\n");
			}
		});
	}
	
	function updateView() {
		$.each(model, function(callSid, call) {
			//alert("conferenceSid:\n" + call["ConferenceSid"] + "\n" + "conferenceFriendlyName:\n" + call["ConferenceName"] + "\n" + "callSid:\n" + call["CallSid"] + "\n" + "caller:\n" + call["Caller"] + "\n" + "startTime:\n" + call["StartTime"] + "\n");
			var wait = Math.round((new Date().getTime()-Date.parse(call['StartTime']))/1000);
			var seconds = wait % 60;
			var minutes = Math.floor(wait / 60) % 60;
			var hours = Math.floor(minutes / 60);
			var waitTime = (minutes < 10 ? '0' : '') + minutes + ":" + (seconds < 10 ? '0' : '') + seconds;
			
			viewTable.append("<tr>");
				viewTable.append("<td>" + call['QueueName'] + "</td>");
				viewTable.append("<td>" + call['From'] + "</td>");
				viewTable.append("<td>" + call['FromCity'] + "</td>");
				viewTable.append("<td>" + call['FromState'] + "</td>");
				viewTable.append("<td>" + call['FromCountry'] + "</td>");
				viewTable.append("<td>" + call['FromZip'] + "</td>");
				viewTable.append("<td>" + waitTime + "</td>");
			viewTable.append("</tr>");
		});
	}
	
	$("#select-available").change(function() {
		$.post(window.location, { q: null, setAvailable: $("#select-available option:selected").val() });
		if ($("#select-available option:selected").val() != 0) {
			$.notify("You are now on duty and will recieve calls.");
		} else {
			$.notify("You are no longer on duty and will not recieve calls.");
		}
		//alert($("#select-available").$("option:selected").text());
	});
	
	setInterval(function() {updateModel()}, 1000);
	//setInterval(function() {updateView()}, 500);
});