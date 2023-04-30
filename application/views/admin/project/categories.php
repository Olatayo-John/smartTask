<div class="wrapper-fluid">
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-4">
                <div class="bg-light-custom p-3">
                    <h5><?= $innertitle ?> Category</h5>
                    <hr class='h_hr'>

                    <form action="<?= base_url('project-categories') ?>" method="post">
                        <input type="hidden" class="csrf_token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                        <input type="hidden" name="project_category_id" value="<?php echo $projectCategory->id ?>">

                        <div class="form-group">
                            <label>Category</label><span class='req'> *</span>
                            <input type="text" class='form-control' name='project_category_name' value="<?php echo $projectCategory->category ?>" required>
                        </div>

                        <div class="form-group text-right">
                            <button class="btn save_project_category_btn btn-bg-custom" type="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-8">
                <div class="bg-light-custom p-3">
                    <h5>Category List</h5>
                    <hr class='h_hr'>

                    <table id="projectCategoryTable" class="table-borderless table-sm" data-toggle="table" data-search="true" data-show-export="true" data-buttons-prefix="btn-sm btn" data-buttons-align="right" data-pagination="true">
                        <thead>
                            <tr>
                                <th data-field="categoryName" data-sortable="true">Category</th>
                                <th data-field="action" data-sortable="false">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($projectCategories->result_array() as $cat) : ?>
                                <tr>
                                    <td><?php echo $cat['category'] ?></td>
                                    <td class='w-25'>
                                        <div class="tableActions">
                                            <a href="<?php echo base_url('project-categories/') . $cat['id'] ?>" class="text-dark"><i class="fa-solid fa-pen"></i></a>
                                            <a href="" class="delete_project_category text-dark" id="<?php echo $cat['id'] ?>" cName="<?php echo $cat['category'] ?>"><i class="fa-solid fa-trash"></i></a>
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
        $('.delete_project_category').on('click', function(e) {
            e.preventDefault();

            var id = $(this).attr('id');
            var cName = $(this).attr('cName');
            var con = confirm('Are you sure you want to delete?');

            if (con === false) {
                return false;
            } else if (con === true) {
                $.ajax({
                    method: 'post',
                    url: '<?php echo base_url("delete-project-category") ?>',
                    dataType: 'json',
                    data: {
                        [csrfName]: csrfHash,
                        id: id,
                        cName:cName
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