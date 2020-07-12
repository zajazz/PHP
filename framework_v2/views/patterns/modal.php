<?php
/**
 * @var string $content
 * @var string $mode
 */
?>
<!-- Modal -->
<div class="modal fade show" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true" onload="$('body').addClass('modal-open')">
  <div class="modal-dialog modal-dialog-centered mt-n5">

    <div class="modal-content m-3" >
      <div class="row position-relative">
        <div class="col">

          <button type="button" class="close position-absolute close-btn" data-dismiss="modal" aria-label="Close"
                  onclick="$('#myModal').removeClass('d-block');">
            <span aria-hidden="true">&times;</span>
          </button>

          <div class="modal-body mt-3">
            <p class="text-info text-center "><?= $content ?></p>
          </div>

        </div>
      </div>

    </div>

  </div>
</div>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    $('#myModal').modal('toggle');
  });
</script>