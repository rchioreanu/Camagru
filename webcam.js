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
	var overlay = document.getElementById('overlay');
	var hasWebcam = false;
	var sel = document.getElementById('list');
	var upload = document.getElementById('uploadbtn');
	var submit = document.getElementById('submitbtn');
	var uimage = document.getElementById('uimage');

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
		upload.style.display = "none";
		submit.style.display = "none";
	}
	navigator.mediaDevices.getUserMedia(constraints).
		then(handleSuccess, function () {
			button.style.display = 'none';
			upload.onchange = function () {
				var reader = new FileReader();
				reader.onload = function (e) {
					var im = new Image();
					im.src = e.target.result;
					im.onload = function () {
						if (im.width != width || im.height != height) {
							alert ("The image may not look like expected! For best results, please upload 640x480 images");
						}
					}
					uimage.style.backgroundImage = 'url("' + e.target.result + '")';
					submit.onclick = function () {
						post('upload.php?filter=' + sel.options[sel.selectedIndex].value, {
							image: e.target.result
						});
					}
				}
				if (this.files[0].name.match(/.(jpg|jpeg|png|bmp)$/i)) {
					reader.readAsDataURL(this.files[0]);
				}
				else {
					alert ("You must choose an image!");
				}
			}
		});
	sel.onchange = function () {
		overlay.src = "image/" + sel.options[sel.selectedIndex].value + ".png"
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
			post('upload.php?filter=' + sel.options[sel.selectedIndex].value, {
				image: img
			});
		}
		else
			alert ("NO WEBCAM");
	};
})
