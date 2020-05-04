const filters = (ctx, width, height) => {
	const picData = ctx.getImageData(0, 0, width, height);
	const data = picData.data;
	const length = data.length;

	return {
		picData: picData,
		data: data,
		length: length,
		commit: function (firstX, firstY) {
			ctx.putImageData(picData, firstX, firstY);
			setState({ dehydration: true });
		},

		normal: function () {
			ctx.putImageData(state.original, 0, 0);
			setState({ dehydration: true });
		},

		grey: function () {
			const refPixels = state.original.data;
			for (let i = 0; i < length; i += 4) {
				let grey = (refPixels[i] + refPixels[i + 1] + refPixels[i + 2]) / 3;
				data[i] = grey;
				data[i + 1] = grey;
				data[i + 2] = grey;
			}
			this.commit(0, 0);
		},

		sepia: function () {
			const refPixels = state.original.data;
			for (let i = 0; i < length; i += 4) {
				let [red, green, blue] = [
					refPixels[i],
					refPixels[i + 1],
					refPixels[i + 2],
				];
				data[i] = 0.393 * red + 0.769 * green + 0.189 * blue;
				data[i + 1] = 0.349 * red + 0.686 * green + 0.168 * blue;
				data[i + 2] = 0.272 * red + 0.534 * green + 0.131 * blue;
			}
			this.commit(0, 0);
		},
	};
};
