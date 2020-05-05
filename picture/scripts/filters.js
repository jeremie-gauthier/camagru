const bitmap = (array, width) => {
	return {
		bot: (i) => [array[i + width], array[i + 1 + width], array[i + 2 + width]],
		top: (i) => [array[i - width], array[i + 1 - width], array[i + 2 - width]],
		right: (i) => [array[i + 4], array[i + 5], array[i + 6]],
		left: (i) => [array[i - 4], array[i - 3], array[i - 2]],

		merge: (arr1, arr2, predicate) => [
			predicate(arr1[0], arr2[0]),
			predicate(arr1[1], arr2[1]),
			predicate(arr1[2], arr2[2]),
		],
	};
};

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
			if (state.elems.length > 0) setState({ dehydration: true });
		},

		normal: function () {
			ctx.putImageData(state.original, 0, 0);
			if (state.elems.length > 0) setState({ dehydration: true });
		},

		grey: function () {
			const refPixels = state.original.data;
			for (let i = 0; i < length; i += 4) {
				const grey = (refPixels[i] + refPixels[i + 1] + refPixels[i + 2]) / 3;
				data[i] = grey;
				data[i + 1] = grey;
				data[i + 2] = grey;
			}
			this.commit(0, 0);
		},

		sepia: function () {
			const refPixels = state.original.data;
			for (let i = 0; i < length; i += 4) {
				const [red, green, blue] = [
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

		sketch: function () {
			const refPixels = state.original.data;
			const INTENSITY_FACTOR = 120;
			for (let i = 0; i < length; i += 4) {
				const intensity =
					(refPixels[i] + refPixels[i + 1] + refPixels[i + 2]) / 3;
				if (intensity > INTENSITY_FACTOR) {
					data[i] = 0xff;
					data[i + 1] = 0xff;
					data[i + 2] = 0xff;
				} else if (intensity > 100) {
					data[i] = 0x96;
					data[i + 1] = 0x96;
					data[i + 2] = 0x96;
				} else {
					data[i] = 0x00;
					data[i + 1] = 0x00;
					data[i + 2] = 0x00;
				}
			}
			this.commit(0, 0);
		},

		dealWithNeighbours: function (predicate) {
			const refPixels = state.original.data;
			const bm = bitmap(refPixels, width);

			for (let i = 0; i < length; i += 4) {
				let initial = [refPixels[i], refPixels[i + 1], refPixels[i + 2]];
				if (i + width < length) {
					const bot = bm.bot(i);
					initial = bm.merge(initial, bot, predicate);
				} else if (i - width > 0) {
					const top = bm.top(i);
					initial = bm.merge(initial, top, predicate);
				} else if (i + 4 < length) {
					const right = bm.right(i);
					initial = bm.merge(initial, right, predicate);
				} else if (i - 4 > 0) {
					const left = bm.left(i);
					initial = bm.merge(initial, left, predicate);
				}
				[data[i], data[i + 1], data[i + 2]] = initial;
			}
		},

		xor: function () {
			const xor_predicate = (a, b) => a ^ b;
			this.dealWithNeighbours(xor_predicate);
			this.commit(0, 0);
		},

		inversion: function () {
			const refPixels = state.original.data;
			for (let i = 0; i < length; i += 4) {
				data[i] = 0xff - refPixels[i];
				data[i + 1] = 0xff - refPixels[i + 1];
				data[i + 2] = 0xff - refPixels[i + 2];
			}
			this.commit(0, 0);
		},
	};
};
