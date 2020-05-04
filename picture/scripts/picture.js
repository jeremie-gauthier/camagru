const [canvas, picArea, snap, cam] = mapElements([
	"canvas",
	"picture-area",
	"snapshot-toggler",
	"video-toggler",
]);

const props = {
	video: null,
	recording: false,
	editing: false,
	pic: null,
	original: null,
	elems: [],
};

const handlers = {
	set: (obj, prop, value) => {
		const previous = obj[prop];
		obj[prop] = value;
		console.log(prop, previous, value);
		if (prop === "recording") {
			handleRecording(previous, value);
		} else if (prop === "pic") {
			handlePic(previous, value);
		}
	},
};

const state = new Proxy(props, handlers);

const setState = (obj) => {
	const keys = Object.keys(obj);
	keys.forEach((key) => (state[key] = obj[key]));
};

/* ----- STATE HANDLERS ----- */

const handleRecording = (previous, value) => {
	snap.disabled = !value;
	if (value === true) {
		cam.innerHTML = "Eteindre la camera";
		canvas.setAttribute("hidden", "");
		setState({
			video: createElement(picArea, "video", {
				autoplay: "true",
				class: "picture",
				id: "stream",
			}),
			pic: null,
		});
	} else if (value === false) {
		cam.innerHTML = "Allumer la camera";
		removeElement(state.video);
		setState({ video: null });
		canvas.removeAttribute("hidden");
	}
};

const handlePic = (previous, value) => {
	if (value === null) {
		if (previous !== null) {
			previous.ctx.clearRect(0, 0, previous.width, previous.height);
		}
	} else {
		const { ctx, width, height } = value;
		setState({ original: ctx.getImageData(0, 0, width, height) });
	}
};
