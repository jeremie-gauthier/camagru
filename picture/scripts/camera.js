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

const snapshot = () => {};

const upload = () => {};
