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

function grayscale (ctx) {
	for (let i = 0; i < 640; i++)
		for (let j = 0; j < 480; j++) {
			let tmp = ctx.getImageData(i, j, 1, 1);
			let r = tmp.data[0];
			let g = tmp.data[1];
			let b = tmp.data[2];
			let v = 0.2126*r + 0.7152*g + 0.0722*b;
			tmp.data[0] = tmp.data[1] = tmp.data[2] = v;
			ctx.putImageData(tmp, i, j);
		}
	return (ctx);
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
	button.onclick = function() {
		var context = canvas.getContext('2d');
		canvas.width = 640;
		canvas.height = 480;
		context.translate(width, 0);
		context.scale(-1, 1);
		context.drawImage(video, 0, 0);
		var img = canvas.toDataURL("image/bmp");
		post('upload.php', {
			image: img
		});
	};
})
