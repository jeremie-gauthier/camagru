<link rel="stylesheet" type="text/css" href="style/sticker.css">

<div id="list-stickers" aria-labelledby="btn-stickers">
  <div class="sticker" onclick="collage('assets/minion.png', 50, 50)">
    <img class="img-sticker" src="assets/minion.png" height=50 width=50 />
    <span class="text-sticker">Minion</span>
  </div>
</div>

<script>
  const collage = (src, dimX, dimY) => {
    if (!state.pic) return;
    const startDragging = () => isDragging = true;

    const stopDragging = () => isDragging = false;

    const handleDragging = (e) => {
      if (!isDragging || !sticker) return;
      const canMouseX = parseInt(e.clientX - offsetX);
      const canMouseY = parseInt(e.clientY - offsetY * 3);
      ctx.putImageData(ImgDataBeforeSticker, 0, 0)
      ctx.drawImage(sticker, canMouseX - dimX / 2, canMouseY - dimY / 2, dimX, dimY);
    }

    const { ctx, width, height } = state.pic;
    const ImgDataBeforeSticker = ctx.getImageData(0, 0, width, height);
    let isDragging = false;
    const sticker = new Image();
    sticker.src = src;
    sticker.onload = () => ctx.drawImage(sticker, 0, 0, dimX, dimY);
    state.nbStickers += 1;

    const offsetX = canvas.offsetLeft;
    const offsetY = canvas.offsetTop;
    canvas.onmousedown = (e) => startDragging(e);
    canvas.onmouseup = (e) => stopDragging(e);
    canvas.onmouseout = (e) => stopDragging(e);
    canvas.onmousemove = (e) => handleDragging(e);
  }
</script>
