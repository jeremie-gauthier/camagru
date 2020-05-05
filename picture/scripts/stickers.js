const stickers = (ctx, width, height) => {
	let isDragging = false;

	return {
		isDragging: false,
		startDragging: function () {
			this.isDragging = true;
		},
		stopDragging: function () {
			this.isDragging = false;
		},

		handleDragging: function (e, dimX, dimY, offsetX, offsetY) {
			if (!this.isDragging || !this.sticker) return;
			const canMouseX = parseInt(e.clientX - offsetX);
			const canMouseY = parseInt(e.clientY - offsetY * 2);
			ctx.putImageData(this.imgDataBeforeSticker, 0, 0);
			ctx.drawImage(
				this.sticker,
				canMouseX - dimX / 2,
				canMouseY - dimY / 2,
				dimX,
				dimY
			);
			this.stickerMeta = { x: canMouseX, y: canMouseY, dimX: dimX, dimY: dimY };
		},

		imgDataBeforeSticker: null,
		stickerMeta: null,
		sticker: null,

		add: function (src, dimX, dimY) {
			const offsetX = canvas.offsetLeft;
			const offsetY = canvas.offsetTop;

			setState({ addingSticker: true });
			if (this.imgDataBeforeSticker === null) {
				this.imgDataBeforeSticker = ctx.getImageData(0, 0, width, height);
			} else {
				ctx.putImageData(this.imgDataBeforeSticker, 0, 0);
			}
			this.sticker = new Image();
			this.sticker.src = src;
			this.sticker.name = src.split("/")[1].split(".")[0];
			this.sticker.onload = () => ctx.drawImage(this.sticker, 0, 0, dimX, dimY);

			canvas.onmousedown = () => this.startDragging();
			canvas.onmouseup = () => this.stopDragging();
			canvas.onmouseout = () => this.stopDragging();
			canvas.onmousemove = (e) =>
				this.handleDragging(e, dimX, dimY, offsetX, offsetY);
		},

		glue: function () {
			setState({ addingSticker: false });
			canvas.onmousemove = null;
			const { src, name } = this.sticker;
			const elemId = state.id;

			setState({
				elems: [
					...state.elems,
					{ id: state.id, src: src, ...this.stickerMeta },
				],
				addingSticker: false,
				id: state.id + 1,
			});
			this.imgDataBeforeSticker = null;
			this.stickerMeta = null;
			this.sticker = null;

			const elem = createElement(listElems, "div", {
				class: "element",
				id: `elem${elemId}`,
			});
			createElement(elem, "img", {
				class: "img-element",
				src: src,
			});
			createElement(elem, "span", { class: "text-element" }, name);
			const delIcon = createElement(
				elem,
				"span",
				{ class: "material-icons" },
				"delete"
			);
			delIcon.onclick = () => {
				setState({
					elems: state.elems.filter((elem) => elem.id !== elemId),
				});
				removeElement(elem);
			};
		},

		rehydrate: function () {
			try {
				console.log("REHYDRATE", state.elems);
				state.elems.forEach(async (elem) => {
					const sticker = await imgLoadAsync(elem.src);
					ctx.drawImage(
						sticker,
						elem.x - elem.dimX / 2,
						elem.y - elem.dimY / 2,
						elem.dimX,
						elem.dimY
					);
				});
			} catch (err) {
				console.error("an error occured =>", err);
			}
		},
	};
};
