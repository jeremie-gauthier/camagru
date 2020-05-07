const canvas = document.getElementById("canvas");
const picArea = document.getElementById("picture-area");
const snap = document.getElementById("snapshot-toggler");
const cam = document.getElementById("video-toggler");
const uploadBtn = document.getElementById("upload-toggler");
const fileInput = document.getElementById("file-input");
const sendBtn = document.getElementById("send-btn-toggler");
const listElems = document.getElementById("list-elems");
const stickerGlueBtn = document.getElementById("sticker-glue-toggler");
const stickerWipeBtn = document.getElementById("sticker-wipe-toggler");

const props = {
	video: null,
	recording: false,
	editing: false,
	pic: null,
	original: null,
	wipeCurrentSticker: false,
	dehydration: false,
	addingSticker: false,
	elems: [],
	id: 0,
};

const handlers = {
	set: (obj, prop, value) => {
		const previous = obj[prop];
		// if (previous === value) return;
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
		} else if (prop === "wipeCurrentSticker") {
			handleWipe(previous, value);
			obj[prop] = false;
		}
	},
};

const state = new Proxy(props, handlers);

const setState = (obj) => {
	const keys = Object.keys(obj);
	keys.forEach((key) => (state[key] = obj[key]));
};

// window.addEventListener("resize", () => {
// 	var w = document.documentElement.clientWidth;
// 	var h = document.documentElement.clientHeight;

// 	// Display result inside a div element
// 	console.log("Width: " + w + ", " + "Height: " + h);
// });

/* ----- STATE HANDLERS ----- */

const handleRecording = (previous, value) => {
	if (value === true) {
		uploadBtn.disabled = true;
		cam.innerHTML = "videocam_off";
		canvas.setAttribute("hidden", "");
		setState({
			video: createElement(picArea, "video", { autoplay: true, id: "stream" }),
			pic: null,
			elems: [],
			id: 0,
		});
	} else if (value === false) {
		uploadBtn.disabled = false;
		cam.innerHTML = "videocam";
		removeElement(state.video);
		setState({ video: null });
		canvas.removeAttribute("hidden");
	}
	snap.disabled = !value;
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
	stickerWipeBtn.disabled = !value;
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
			sendBtn.disabled = true;
			for (let i = 0; i <= state.id; i++) {
				let elem = document.getElementById(`elem${i}`);
				removeElement(elem);
			}
			if (state.dehydration) state.pic?.sticker.rehydrate();
		}
	} else if (len >= 1) {
		sendBtn.disabled = false;
	}
};

const handleWipe = (previous, value) => {
	state.pic?.sticker.wipe();
};
