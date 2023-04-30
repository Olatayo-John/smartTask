<input type="hidden" class="csrf_token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

<div class="wrapper">
    <div class="bg-light-custom p-3">
    <h5><?= ucwords($title) ?></h5>
    </div>

</div>





<script>
    var csrfName = $('.csrf_token').attr('name');
    var csrfHash = $('.csrf_token').val();

    $(document).ready(function() {


    });
</script>