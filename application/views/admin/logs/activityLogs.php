<input type="hidden" class="csrf_token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

<div class="wrapper">
    <div class="bg-light-custom p-3">
        <?php if ($activityLogs->num_rows() > 0) : ?>
            <div class="text-left">
                <a href="<?php echo base_url('clear-activity'); ?>" class="btn btn-danger clear_activityLogs">
                    <i class="fas fa-trash-alt mr-2"></i>Clear Data
                </a>
            </div>
        <?php endif; ?>

        <table class='table-borderless' id="logstable" data-toggle="table" data-search="true" data-show-export="true" data-buttons-prefix="btn-sm btn" data-buttons-align="right" data-pagination="true">
            <thead>
                <tr>
                    <th data-field="activity" data-sortable="true">Activity</th>
                    <th data-field="date" data-sortable="true">Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($activityLogs->result() as $log) : ?>
                    <tr>
                        <td><?php echo $log->msg ?></td>
                        <td class="date"><?php echo $log->act_time ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>





<script>
    var csrfName = $('.csrf_token').attr('name');
    var csrfHash = $('.csrf_token').val();

    $(document).ready(function() {
        $(document).on('click', '.clear_activityLogs', function(e) {
            e.preventDefault();

            var con = confirm("Are you sure you want to clear this data?");
            if (con === false) {
                return false;
            } else {
                var linkurl = $(this).attr('href');
                window.location.assign(linkurl);
            }
        });
    });
</script>