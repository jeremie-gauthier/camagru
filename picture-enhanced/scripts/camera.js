const start = async () => {
	try {
		if (navigator.mediaDevices) {
			setState({ recording: true, editing: false });
			const stream = await navigator.mediaDevices.getUserMedia({ video: true });
			state.video.srcObject = stream;
		} else {
			// set state error that will display msg
		}
	} catch (err) {
		// set state error that will display msg
		console.error("Something went wrong: ", err);
	}
};

const stop = () => {
	const { video } = state;

	if (video.srcObject) {
		const tracks = video.srcObject.getTracks();

		tracks.forEach((track) => track.stop());
		setState({ recording: false, wipeCurrentSticker: true });
	}
};

const snapshot = () => {
	try {
		const { video } = state;

		const width = Math.min(video.videoWidth, window.innerWidth);
		const height = (width / 4) * 3;
		setAttributes(canvas, { width: width, height: height });

		const ctx = canvas.getContext("2d");
		ctx.translate(width, 0);
		ctx.scale(-1, 1);
		ctx.drawImage(video, 0, 0, width, height);
		ctx.translate(width, 0);
		ctx.scale(-1, 1);

		const filter = filters(ctx, width, height);
		const sticker = stickers(ctx, width, height);
		setState({
			pic: { width, height, ctx, filter, sticker },
			editing: true,
		});
		stop();
	} catch (err) {
		showToast("error", err.message);
	}
};

const upload = async (e) => {
	const file = e?.target?.files[0];

	if (!file || !file.type.match("image.*")) return;

	const data = await fileReader(file);
	const img = await imgLoader(data);

	const width = Math.min(640, window.innerWidth);
	const height = (width / 4) * 3;
	setAttributes(canvas, { width: width, height: height });

	const ctx = canvas.getContext("2d");

	ctx.drawImage(img, 0, 0, width, height);
	const filter = filters(ctx, width, height);
	const sticker = stickers(ctx, width, height);
	setState({
		pic: { width, height, ctx, filter, sticker },
		editing: true,
	});
};

fileInput.addEventListener("change", upload);

const send = () => {};
