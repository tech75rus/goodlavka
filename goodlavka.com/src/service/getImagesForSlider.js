export function getImage(product, quality = 1) {
  let pathImages = [];
  for (let keyProduct in product) {
    let path = keyProduct;
    let images = product[keyProduct];
    for (let keyImage in images) {
      let img = '';
      img += keyImage;
      img += images[keyImage][quality];
      pathImages.push(path + img);
    }
  }
  return pathImages;
}
