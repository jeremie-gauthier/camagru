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
	const {
		video: { srcObject },
	} = state;
	const tracks = srcObject.getTracks();

	tracks.forEach((track) => track.stop());
	setState({ recording: false, wipeCurrentSticker: true });
};

const snapshot = () => {
	const { video } = state;
	const { offsetWidth: width, offsetHeight: height } = video;
	const ctx = canvas.getContext("2d");
	canvas.width = width;
	canvas.height = height;
	ctx.drawImage(video, 0, 0, width, height);
	setState({
		editing: true,
		pic: {
			width: width,
			height: height,
			ctx: ctx,
			filter: filters(ctx, width, height),
			sticker: stickers(ctx, width, height),
		},
	});
	stop();
};
