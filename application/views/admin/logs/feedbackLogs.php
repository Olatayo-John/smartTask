<input type="hidden" class="csrf_token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

<div class="wrapper">
    <div class="bg-light-custom p-3">
        <?php if ($feedbackLogs->num_rows() > 0) : ?>
            <div class="text-left">
                <a href="<?php echo base_url('clear-feedbacks'); ?>" class="btn btn-danger clear_activityLogs">
                    <i class="fas fa-trash-alt mr-2"></i>Clear Data
                </a>
            </div>
        <?php endif; ?>

        <table class="table-borderless" id="feedbackstable" data-toggle="table" data-search="true" data-show-export="true" data-buttons-prefix="btn-sm btn" data-buttons-align="right" data-pagination="true">
            <thead>
                <tr>
                    <th data-field="name" data-sortable="true">Name</th>
                    <th data-field="mail" data-sortable="true">E-mail</th>
                    <th data-field="msg" data-sortable="true">Message</th>
                    <th data-field="date" data-sortable="true">Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($feedbackLogs->result_array() as $msg) : ?>
                    <tr>
                        <td><?php echo $msg['name'] ?></td>
                        <td><a href="mailto:<?php echo $msg['mail'] ?>"><?php echo $msg['mail'] ?></a></td>
                        <td><?php echo $msg['message'] ?></td>
                        <td class="date"><?php echo $msg['date'] ?></td>
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
        $(document).on('click', '.clear_feedbackLogs', function(e) {
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