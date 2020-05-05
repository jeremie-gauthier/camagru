const stickers = (ctx, width, height) => {
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
			const x = parseInt(e.clientX - offsetX);
			const y = parseInt(e.clientY - offsetY * 2);
			ctx.putImageData(this.imgDataBeforeSticker, 0, 0);
			ctx.drawImage(this.sticker, x - dimX / 2, y - dimY / 2, dimX, dimY);
			this.stickerMetaData = { x, y, dimX, dimY };
		},

		// data use to moves sticker
		imgDataBeforeSticker: null,
		stickerMetaData: null,
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
					{ id: state.id, src: src, ...this.stickerMetaData },
				],
				addingSticker: false,
				id: state.id + 1,
			});
			this.imgDataBeforeSticker = null;
			this.stickerMetaData = null;
			this.sticker = null;
			this.addStickerToElems(src, name, elemId);
		},

		addStickerToElems: function (src, name, id) {
			const elem = createElement(listElems, "div", {
				class: "element",
				id: `elem${id}`,
			});
			createElement(elem, "img", {
				class: "img-element",
				src: src,
			});
			createElement(elem, "span", { class: "text-element" }, name);
			const moveIcon = createElement(
				elem,
				"span",
				{ class: "material-icons" },
				"open_with"
			);
			moveIcon.onclick = () => console.log("RETOUCHE");
			const delIcon = createElement(
				elem,
				"span",
				{ class: "material-icons" },
				"delete"
			);
			delIcon.onclick = () => {
				setState({
					elems: state.elems.filter((elem) => elem.id !== id),
				});
				removeElement(elem);
			};
		},

		rehydrate: function () {
			try {
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
