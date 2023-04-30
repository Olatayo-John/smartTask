<div class="wrapper-fluid">
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-4">
                <div class="bg-light-custom p-3">
                    <h5><?= $innertitle ?> Activity</h5>
                    <hr class='h_hr'>

                    <form action="<?php echo base_url('project-activities') ?>" method="post">
                        <input type="hidden" class="csrf_token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                        <input type="hidden" name="project_activity_id" value="<?php echo $projectActivity->id ?>">

                        <div class="form-group">
                            <label>Activity</label>
                            <input type="text" class='form-control' name='project_activity_name' value="<?php echo $projectActivity->activity ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Category</label>
                            <select name="project_activity_category_id" class="form-control" required>
                                <option value="">Select</option>
                                <?php foreach ($projectCategories->result_array()  as $cat) : ?>
                                    <option value="<?php echo $cat['id'] ?>" <?php echo ($cat['id'] === $projectActivity->category_id) ? "selected" : "" ?>><?php echo $cat['category'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group text-right">
                            <button class="btn save_project_activity_btn btn-bg-custom">Save</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-8">
                <div class="bg-light-custom p-3">
                    <h5>Activity List</h5>
                    <hr class='h_hr'>

                    <table id="projectactivityTable" class="table-borderless table-sm" data-toggle="table" data-search="true" data-show-export="true" data-buttons-prefix="btn-md btn" data-buttons-align="right" data-pagination="true">
                        <thead>
                            <tr>
                                <th data-field="activityName" data-sortable="true">Activity</th>
                                <th data-field="categoryName" data-sortable="true">Category</th>
                                <th data-field="action" data-sortable="true">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($projectActivities->result_array() as $act) : ?>
                                <tr>
                                    <td><?php echo $act['activity'] ?></td>
                                    <td><?php echo $act['category'] ?></td>
                                    <td class='w-25'>
                                        <div class="tableActions">
                                            <a href="<?php echo base_url('project-activities/') . $act['p_a_id'] ?>" class="text-dark"><i class="fa-solid fa-pen"></i></a>
                                            <a href="" class="delete_project_activity text-dark" id="<?php echo $act['p_a_id'] ?>" aName="<?php echo $act['activity'] ?>"><i class="fa-solid fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            <?PHP endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>





<script>
    var csrfName = $('.csrf_token').attr('name');
    var csrfHash = $('.csrf_token').val();

    $(document).ready(function() {
        $('.delete_project_activity').on('click', function(e) {
            e.preventDefault();

            var id = $(this).attr('id');
            var aName = $(this).attr('aName');
            var con = confirm('Are you sure you want to delete?');

            if (con === false) {
                return false;
            } else if (con === true) {
                $.ajax({
                    method: 'post',
                    url: '<?php echo base_url("delete-project-activity") ?>',
                    dataType: 'json',
                    data: {
                        [csrfName]: csrfHash,
                        id: id,
                        aName: aName
                    },
                    beforeSend: function() {
                        clearAlert();
                    },
                    success: function(res) {
                        if (res.status === true) {
                            $(".ajax_res_succ").append(res.msg);
                            $(".ajax_succ_div").fadeIn();

                            chillAndReload(t = 1000);
                        } else if (res.status === false) {
                            $(".ajax_res_err").append(res.msg);
                            $(".ajax_err_div").fadeIn();
                        } else {
                            window.location.reload();
                        }
                    },
                    error: function(res) {

                    }
                })
            }
        });
    });
</script>