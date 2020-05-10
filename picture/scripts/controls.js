const start = async () => {
	try {
		if (navigator.mediaDevices) {
			setState({ addingSticker: false, recording: true, editing: false });
			const stream = await navigator.mediaDevices.getUserMedia({ video: true });
			state.video.srcObject = stream;
		} else {
			showToast("error", "Une erreur est survenue");
		}
	} catch (err) {
		showToast("error", err.message);
	}
};

const stop = () => {
	const { video } = state;

	if (video?.srcObject) {
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
	try {
		stop();
		setState({ wipeCurrentSticker: true, pic: null, elems: [], id: 0 });

		const file = e?.target?.files[0];

		if (!file) return;
		if (!file.type.match("image.*")) {
			showToast("error", "Not a valid file");
			return;
		}

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
	} catch (err) {
		showToast("error", err.message);
	}
};

fileInput.addEventListener("change", upload);

const addImgToList = (id, src) => {
	const divElem = createElement(listPics, "div", {
		class: "picture-container",
		id: `my-picture${id}`,
	});
	createElement(divElem, "img", { class: "picture-img", src });
	const delIcon = createElement(
		divElem,
		"i",
		{ class: "material-icons md-inactive picture-action" },
		"clear"
	);
	// add events delIcon
	delIcon.addEventListener("click", () => console.log(`Delete: ${id}`));
};

const send = async () => {
	try {
		const b64img = canvas.toDataURL();
		const url = "server/handlers/picture.php";
		const data = { picture: b64img };

		const { message } = await AsyncRequest.post(url, data);
		addImgToList(1, b64img);
		showToast("success", message);
	} catch (err) {
		showToast("error", err.message);
	}
};
