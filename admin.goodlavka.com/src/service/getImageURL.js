export function getImageURL(images, quality = 1) {
  let url;
  for (let img in images) {
    url = img;
    let one = images[img];
    let i = 0;
    for (let two in one) {
      if (i > 0) continue;
      i++;
      url += two;
      url += one[two][quality];
    }
  }
  return url;
}
