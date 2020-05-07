const start = async () => {
	try {
		if (navigator.mediaDevices) {
			state.recording = true;
			const stream = await navigator.mediaDevices.getUserMedia({ video: true });
			video.srcObject = stream;
			video.removeAttribute("hidden");
			cam.innerHTML = "videocam_off";
			snap.disabled = false;
			uploadImg.disabled = true;
		} else {
			showToast(err.message);
		}
	} catch (err) {
		showToast(err.message);
	}
};

const stop = () => {
	if (video.srcObject) {
		video.setAttribute("hidden", "");
		snap.disabled = true;
		const tracks = video.srcObject.getTracks();
		tracks.forEach((track) => track.stop());
		state.recording = false;
		cam.innerHTML = "videocam";
		uploadImg.disabled = false;
	}
};

const snapshot = async () => {
	try {
		const xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function () {
			if (this.readyState == 4 && this.status == 200) {
				console.log(this.responseText);
				alert(this.responseText);
			}
		};
		xhttp.open("POST", "server/handlers/picture.php", true);
		xhttp.send();
	} catch (err) {
		showToast(err.message);
	}
};

const upload = () => {};
