navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia;

navigator.getUserMedia({ "audio": true, "video": true }, successCallback, errorCallback);

function successCallback(stream) {
	document.getElementById('myself').src = URL.createObjectURL(stream);
}

function errorCallback() {}