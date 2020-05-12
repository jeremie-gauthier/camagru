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
			const y = parseInt(e.clientY - offsetY);
			ctx.putImageData(this.imgDataBeforeSticker, 0, 0);
			ctx.drawImage(this.sticker, x - dimX / 2, y - dimY / 2, dimX, dimY);
			this.stickerMetaData = { x, y, dimX, dimY };
		},

		// data use to moves sticker
		imgDataBeforeSticker: null,
		stickerMetaData: null,
		sticker: null,

		add: function (src, dimX, dimY) {
			this.wipe();
			const navbar = document.getElementById("navbar");
			const offsetX = canvas.offsetLeft;
			const offsetY = canvas.offsetTop + navbar.offsetHeight;

			setState({ addingSticker: true });
			this.imgDataBeforeSticker = ctx.getImageData(0, 0, width, height);
			this.sticker = new Image();
			this.sticker.src = src;
			this.sticker.name = src.split("/")[2].split(".")[0];
			this.sticker.onload = () => ctx.drawImage(this.sticker, 0, 0, dimX, dimY);
			this.stickerMetaData = { x: dimX / 2, y: dimY / 2, dimX, dimY };

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
			const stickerData = { id: state.id, ...this.stickerMetaData, src, name };

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
			this._addStickerToElems(stickerData);
		},

		wipe: function () {
			setState({ addingSticker: false });
			if (this.imgDataBeforeSticker) {
				ctx.putImageData(this.imgDataBeforeSticker, 0, 0);
			}
			canvas.onmousemove = null;
			this.imgDataBeforeSticker = null;
			this.stickerMetaData = null;
			this.sticker = null;
		},

		_addStickerToElems: function (stickerData) {
			const divElem = createElement(listElems, "div", {
				class: "element",
				id: `elem${stickerData.id}`,
			});
			createElement(divElem, "img", {
				class: "img-element",
				src: stickerData.src,
			});
			createElement(
				divElem,
				"span",
				{ class: "text-element" },
				stickerData.name
			);
			const moveIcon = createElement(
				divElem,
				"i",
				{ class: "material-icons action-icon" },
				"gps_fixed"
			);

			let ctxBeforeSelecting = null;
			moveIcon.onmousedown = () => {
				setState({ wipeCurrentSticker: true });
				ctxBeforeSelecting = ctx.getImageData(0, 0, width, height);
				const { x, y, dimX, dimY } = stickerData;
				const topLeftX = x - dimX / 2;
				const topLeftY = y - dimY / 2;

				ctx.fillStyle = "red";
				ctx.fillRect(topLeftX - 2, topLeftY - 2, dimX + 2, 2);
				ctx.fillRect(topLeftX - 2, topLeftY, 2, dimY + 2);
				ctx.fillRect(topLeftX - 2, topLeftY + dimY + 2, dimX + 2, 2);
				ctx.fillRect(topLeftX - 2 + dimX, topLeftY, 2, dimY + 2);
			};
			moveIcon.onmouseout = () => {
				if (ctxBeforeSelecting) ctx.putImageData(ctxBeforeSelecting, 0, 0);
			};
			moveIcon.onmouseup = () => {
				if (ctxBeforeSelecting) ctx.putImageData(ctxBeforeSelecting, 0, 0);
			};

			const delIcon = createElement(
				divElem,
				"i",
				{ class: "material-icons action-icon" },
				"delete"
			);
			delIcon.onclick = () => {
				setState({
					wipeCurrentSticker: true,
					elems: state.elems.filter((elem) => elem.id !== stickerData.id),
				});
				removeElement(divElem);
			};
		},

		rehydrate: function () {
			try {
				state.elems.forEach(async (elem) => {
					const sticker = await imgLoader(elem.src);
					await ctx.drawImage(
						sticker,
						elem.x - elem.dimX / 2,
						elem.y - elem.dimY / 2,
						elem.dimX,
						elem.dimY
					);
				});
			} catch (err) {
				showToast("error", err.message);
			}
		},
	};
};
