<?php
/**
 * @var string $title
 * @var string $img
 * @var string $error
 * @var App\models\Product $product
 */
?>
<div class="row">
  <div class="col"><h1 class="h1 mt-5 mb-3"><?= $title ?></h1></div>
</div>
<form class="form" enctype="multipart/form-data" method="POST">
<div class="row">
    <div class="col-md-6">
      <div class="input-group my-2">
        <div class="input-group-prepend">
          <span class="input-group-text label-w" id="inputTitle">Title</span>
        </div>
        <input name="title" type="text" class="form-control" placeholder="New product title"
               value="<?= $product->title ?>" required="">
      </div>

      <div class="input-group my-2">
        <div class="input-group-prepend">
          <span class="input-group-text label-w" id="inputPrice">Price</span>
        </div>
        <input name="price" type="text" class="form-control" placeholder="99.99"
               value="<?= $product->price ?>" required="">
      </div>

      <div class="input-group my-2">
        <div class="input-group-prepend">
          <span class="input-group-text label-w" id="inputInfo">Description</span>
        </div>
        <input name="info" type="text" class="form-control" placeholder="Description"
               value="<?= $product->info ?>">
      </div>

      <div class="input-group my-2">
        <div class="input-group-prepend">
          <span class="input-group-text label-w">Load new image</span>
        </div>
        <div class="custom-file">
          <input name="picture" type="file" class="custom-file-input" id="imageInput">
          <label class="custom-file-label" for="imageInput">Choose file</label>
        </div>
        <div class="w-100 mt-3 text-danger"><?= $error ?></div>

      </div>
    </div>
    <div class="col-md-6">
      <img id="preview_image" src="<?= $img . $product->img ?>" alt="<?= $product->title ?>" class="img-thumbnail mb-n1">
    </div>
    <div class="w-100"></div>
    <div class="col">
      <div class="input-group my-2">
        <button type="submit" class="btn btn-info mb-2">Save changes</button>
        <a class="btn btn-light mb-2 ml-3" href="?c=product&a=one&id=<?= $product->id ?>">Cancel</a>
      </div>
      <div class="input-group my-2">
      </div>
</div>
</form>
<script lang="javascript">
function changeImg(event) {
  let input = event.target;
  if (input.files && input.files[0]) {
    let reader = new FileReader();
    reader.onload = function (e) {
      document.getElementById('preview_image').setAttribute('src', e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
  }
}
document.getElementById('imageInput').addEventListener('change', changeImg);
</script>