function post(path, params, method) {
	method = method || "post";
	var form = document.createElement("form");
	form.setAttribute("method", method);
	form.setAttribute("action", path);

	for(var key in params) {
		if(params.hasOwnProperty(key)) {
			var hiddenField = document.createElement("input");
			hiddenField.setAttribute("type", "hidden");
			hiddenField.setAttribute("name", key);
			hiddenField.setAttribute("value", params[key]);

			form.appendChild(hiddenField);
		}
	}
	document.body.appendChild(form);
	form.submit();
}

document.addEventListener("DOMContentLoaded", function () {

	"use strict";
	var video = document.getElementById('video');
	var constraints = window.constraints = { audio: false, video: true };
	var button = document.getElementById('button');
	var canvas = document.getElementById('canvas');
	var image = document.getElementById('image');
	var width = 640;
	var height = 480;
	var select = document.getElementById('refresh');
	var overlay = document.getElementById('overlay');

	function handleSuccess(stream) {
		var videoTracks = stream.getVideoTracks();
		console.log('Got stream with constraints:', constraints);
		console.log('Using video device: ' + videoTracks[0].label);
		video.style.filter = 'grayscale(100%)';
		stream.oninactive = function() {
			console.log('Stream inactive');
		};
		window.stream = stream;
		video.srcObject = stream;
	}
	navigator.mediaDevices.getUserMedia(constraints).
		then(handleSuccess);
	select.onclick = function () {
		var sel = document.getElementById("list");
		overlay.src = "image/" + sel.options[sel.selectedIndex].value + ".png"
	}
	button.onclick = function() {
		var context = canvas.getContext('2d');
		canvas.width = 640;
		canvas.height = 480;
		context.translate(width, 0);
		context.scale(-1, 1);
		context.drawImage(video, 0, 0);
		var img = canvas.toDataURL("image/png");
		post('upload.php', {
			image: img
		});
	};
})
