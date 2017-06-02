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
	var hasWebcam = false;

	function handleSuccess(stream) {
		var videoTracks = stream.getVideoTracks();
		console.log('Got stream with constraints:', constraints);
		console.log('Using video device: ' + videoTracks[0].label);
		stream.oninactive = function() {
			console.log('Stream inactive');
		};
		window.stream = stream;
		video.srcObject = stream;
		hasWebcam = true;
		overlay.src = "image/dragnea.png";
	}
	navigator.mediaDevices.getUserMedia(constraints).
		then(handleSuccess, function () {
			overlay.src = "";
			button.style.display = 'none';
		});
	select.onclick = function () {
		if (!hasWebcam) {
			alert ("You can't do that, you don't have a webcam!");
		}
		else {
			var sel = document.getElementById("list");
			overlay.src = "image/" + sel.options[sel.selectedIndex].value + ".png"
		}
	}
	button.onclick = function () {
		if (hasWebcam) {
			var context = canvas.getContext('2d');
			canvas.width = 640;
			canvas.height = 480;
			context.translate(width, 0);
			context.scale(-1, 1);
			context.drawImage(video, 0, 0);
			var img = canvas.toDataURL("image/png");
			var sel = document.getElementById("list");
			post('upload.php?filter=' + sel.options[sel.selectedIndex].value, {
				image: img
			});
		}
		else
			alert ("NO WEBCAM");
	};
})
