// ************************************************************************** //
//                                                                            //
//                                                        :::      ::::::::   //
//   webcam.js                                          :+:      :+:    :+:   //
//                                                    +:+ +:+         +:+     //
//   By: rchiorea <rchiorea@student.42.fr>          +#+  +:+       +#+        //
//                                                +#+#+#+#+#+   +#+           //
//   Created: 2017/05/23 16:28:23 by rchiorea          #+#    #+#             //
//   Updated: 2017/05/23 19:07:58 by rchiorea         ###   ########.fr       //
//                                                                            //
// ************************************************************************** //

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
		context.drawImage(video, 0, 0, width, height);
		var img = canvas.toDataURL("image/bmp");
		image.src = img;
	};
})
