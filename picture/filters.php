<link rel="stylesheet" type="text/css" href="style/filters.css">

<div id="list-filters" aria-labelledby="btn-filters" hidden>
  <button
    type="button"
    class="filter"
    id="no-filter"
    onclick="apply('normal')"
  >
    Sans filtre
  </button>

  <button
    type="button"
    class="filter"
    id="grey-filter"
    onclick="apply('grey')"
  >
    Filtre gris
  </button>

  <button
    type="button"
    class="filter"
    id="sepia-filter"
    onclick="apply('sepia')"
  >
    Filtre sepia
  </button>
</div>

<script>
  const apply = (filter) => {
    if (!state.pic) return;

    const commit = (firstX, firstY) => {
      state.hasFilter = true;
      ctx.putImageData(picData, firstX, firstY);
      console.log("CHANGE");
    }

    const normal = () => {
      state.hasFilter = false;
      ctx.putImageData(state.original, 0, 0);
    }

    const grey = () => {
      for (let i = 0; i < length; i += 4) {
        let grey =
          (refPixels[i] + refPixels[i + 1] + refPixels[i + 2]) / 3;
        data[i] = grey;
        data[i + 1] = grey;
        data[i + 2] = grey;
      }
      commit(0, 0);
    }

    const sepia = () => {
      for (let i = 0; i < length; i += 4) {
        let [red, green, blue] = [
          refPixels[i], refPixels[i + 1], refPixels[i + 2]
        ];
        data[i] = 0.393 * red + 0.769 * green + 0.189 * blue;
        data[i + 1] = 0.349 * red + 0.686 * green + 0.168 * blue;
        data[i + 2] = 0.272 * red + 0.534 * green + 0.131 * blue;
      }
      commit(0, 0);
    }

    const { ctx, width, height } = state.pic;
    const refPixels = state.original.data;
    const picData = ctx.getImageData(0, 0, width, height);
    const data = picData.data;
    const length = data.length;
    const fns = {
      "normal": normal,
      "grey": grey,
      "sepia": sepia
    };
    if (filter in fns) fns[filter]();
  }
</script>
