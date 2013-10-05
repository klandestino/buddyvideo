$(document).ready(function() {

	var url = window.location.href.split('/');
	if (url.length === 4 && url[3].length === 0) {
		window.location.href = '/' + (Math.PI * Math.max(0.01, Math.random())).toString(36).substr(2, 7);
		return;
	}

	var chatDataChannel;
	var rtcOptions = {
		connect: function(peerConnection) {
			$('#content').show();

			// We want more connections!
			console.log('CONNECTED!');
			var chatDataChannel = null;

			function startChat() {
				chatDataChannel = peerConnection.createDataChannel('chat', { reliable: false });
				chatDataChannel.onopen = function() {
					console.log('Chat Channel Opened!');
					console.dir(chatDataChannel);
					$('#chat').show();
				};
				chatDataChannel.onclose = function() {
					console.log('Chat Channel Closed!');
					console.dir(chatDataChannel);
					startChat();
					$('#chat').hide();
				};
				chatDataChannel.onerror = function() {
					console.log('Chat Channel Error');
					console.dir(chatDataChannel);
					startChat();
					$('#chat').hide();
				};
				chatDataChannel.onmessage = function(e) {
					$('#msgs').append('<p>' + e.data + '</p>');
				};
			}

			startChat();

			$('#chatinput').keyup(function(e) {
				if (e.keyCode == 13) {
					console.dir(chatDataChannel);
					chatDataChannel.send($(this).val());
					$(this).val('');
				}
			});

			$('#addVideo').click(function() {
				navigator.webkitGetUserMedia({ "audio": true, "video": true }, function(stream) {
					peerConnection.addStream(stream);
				});
			});
			peerConnection.onaddstream = function(e) {
				console.log('onaddstream.');
				$video = $('<video width="160" height="120" autoplay="autoplay" />');
				$('#video').append($video);
				$video[0].src = URL.createObjectURL(e.stream);
			}

		},
		sigRTCurl: '//sigrtc.turnservers.com/',
		customPostData: {
			'action': 'buddyvideo'
		}
	};
	sigRTC(rtcOptions);

});
