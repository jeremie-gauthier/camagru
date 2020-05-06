const start = async () => {
	try {
		if (navigator.mediaDevices) {
			const stream = await navigator.mediaDevices.getUserMedia({ video: true });
			setState({ recording: true, editing: false });
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
	const {
		video: { srcObject },
	} = state;
	const tracks = srcObject.getTracks();

	tracks.forEach((track) => track.stop());
	setState({ recording: false, wipeCurrentSticker: true });
};

const snapshot = () => {
	const { video } = state;

	const width = Math.min(video.videoWidth, window.innerWidth);
	const height = (width / 4) * 3;
	setAttributes(canvas, { width: width, height: height });

	const ctx = canvas.getContext("2d");
	ctx.drawImage(video, 0, 0, width, height);

	setState({
		pic: {
			width,
			height,
			ctx,
			filter: filters(ctx, width, height),
			sticker: stickers(ctx, width, height),
		},
		editing: true,
	});
	stop();
};
