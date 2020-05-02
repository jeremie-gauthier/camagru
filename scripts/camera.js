const start = async (element) => {
	try {
		const stream = await navigator.mediaDevices.getUserMedia({ video: true });
		element.srcObject = stream;
	} catch (err) {
		console.error("Something went wrong: ", err);
	}
};

const stop = (element) => {
	const stream = element.srcObject;
	const tracks = stream.getTracks();

	tracks.forEach((track) => track.stop());
	element.srcObject = null;
};

class Picture {
	constructor(element, canvas) {
		this.width = element.offsetWidth;
		this.height = element.offsetHeight;
		canvas.width = this.width;
		canvas.height = this.height;
		this.canvas = canvas;
		this.ctx = this.canvas.getContext("2d");
		this.ctx.drawImage(element, 0, 0, this.width, this.height);
	}

	save() {}
}

class Filter {
	constructor(ctx, width, height) {
		this.ctx = ctx;
		this.original = this.ctx.getImageData(0, 0, width, height);
		this.refPixels = this.original.data;
		this.picData = this.ctx.getImageData(0, 0, width, height);
		this.data = this.picData.data;
		this.length = this.data.length;
	}

	commit(firstX, firstY) {
		this.ctx.putImageData(this.picData, firstX, firstY);
	}

	normal() {
		this.ctx.putImageData(this.original, 0, 0);
	}

	grey() {
		for (let i = 0; i < this.length; i += 4) {
			let grey =
				(this.refPixels[i] + this.refPixels[i + 1] + this.refPixels[i + 2]) / 3;
			this.data[i] = grey;
			this.data[i + 1] = grey;
			this.data[i + 2] = grey;
		}
		this.commit(0, 0);
	}

	sepia() {
		for (let i = 0; i < this.length; i += 4) {
			let [red, green, blue] = [
				this.refPixels[i],
				this.refPixels[i + 1],
				this.refPixels[i + 2],
			];
			this.data[i] = 0.393 * red + 0.769 * green + 0.189 * blue;
			this.data[i + 1] = 0.349 * red + 0.686 * green + 0.168 * blue;
			this.data[i + 2] = 0.272 * red + 0.534 * green + 0.131 * blue;
		}
		this.commit(0, 0);
	}
}
