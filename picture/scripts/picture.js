const [canvas, picArea, snap, cam, listElems, stickerGlueBtn] = mapElements([
	"canvas",
	"picture-area",
	"snapshot-toggler",
	"video-toggler",
	"list-elems",
	"sticker-glue-toggler",
]);

const props = {
	video: null,
	recording: false,
	editing: false,
	pic: null,
	original: null,
	dehydration: false,
	addingSticker: false,
	elems: [],
	id: 0,
};

const handlers = {
	set: (obj, prop, value) => {
		const previous = obj[prop];
		obj[prop] = value;
		// console.log(prop, previous, value);
		if (prop === "recording") {
			handleRecording(previous, value);
		} else if (prop === "pic") {
			handlePic(previous, value);
		} else if (prop === "addingSticker") {
			handleStickerAdd(previous, value);
		} else if (prop === "dehydration") {
			handleHydration(previous, value);
			obj[prop] = false;
		} else if (prop === "elems") {
			handleElemsChange(previous, value);
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
			elems: [],
			id: 0,
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

const handleStickerAdd = (previous, value) => {
	stickerGlueBtn.disabled = !value;
};

const handleHydration = (previous, value) => {
	if (value === false || state.pic === null || !state.elems) return;

	state.pic.sticker.rehydrate();
};

const handleElemsChange = (previous, value) => {
	const len = value.length;
	if (previous.length > len) {
		state.pic?.filter.commit(0, 0);
		if (len === 0) {
			for (let i = 0; i <= state.id; i++) {
				let elem = document.getElementById(`elem${i}`);
				removeElement(elem);
			}
			if (state.dehydration) state.pic?.sticker.rehydrate();
		}
	}
};
