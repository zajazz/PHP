<?php
/**
 * @var string $title
 */
?>
<div class="row">
  <div class="col"><h1 class="h1 mt-5 mb-3"><?= $title ?></h1></div>
  <div class="col d-flex align-items-end justify-content-end">
    <div class=" mb-3"><a href="?p=product">Back to product list</a></div>
  </div>
</div>

<div class="row">
  <div class="col-6">
    <form class="form" enctype="multipart/form-data" method="POST">


          <div class="input-group my-2">
            <div class="input-group-prepend">
              <span class="input-group-text label-w" id="inputTitle">Title</span>
            </div>
            <input name="title" type="text" class="form-control" placeholder="New product title" required="">
          </div>


          <div class="input-group my-2">
            <div class="input-group-prepend">
              <span class="input-group-text label-w" id="inputPrice">Price</span>
            </div>
            <input name="price" type="text" class="form-control" placeholder="99.99" required="">
          </div>


          <div class="input-group my-2">
            <div class="input-group-prepend">
              <span class="input-group-text label-w" id="inputInfo">Description</span>
            </div>
            <input name="info" type="text" class="form-control" placeholder="Description">
          </div>


          <div class="input-group my-2">
            <div class="input-group-prepend">
              <span class="input-group-text label-w">Image</span>
            </div>
            <div class="custom-file">
              <input name="picture" type="file" class="custom-file-input" id="inputFile" required="">
              <label class="custom-file-label" for="inputFile">Choose file</label>
            </div>
          </div>


          <div class="input-group my-2">
            <button type="submit" class="btn btn-primary mb-2">Загрузить</button>
          </div>



    </form>

  </div>
</div>
