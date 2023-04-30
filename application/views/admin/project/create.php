<div class="wrapper">
    <div class="bg-light-custom p-3">
        <h5><?= ($innertitle) ?></h5>
        <hr class='h_hr'>

        <form action="">
            <input type="hidden" class="csrf_token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

            <div class="form-group">
                <label>Project Name</label>
                <input type="text" name="add_project_name" class="form-control">
            </div>

            <div class="form-group row">
                <div class="col-md-6 form-group">
                    <label>Category</label>
                    <select name="add_project_category" class="form-control" required>
                        <option value="">Select</option>
                        <?php foreach ($projectCategories->result_array()  as $cat) : ?>
                            <option value="<?php echo $cat['id'] ?>"><?php echo $cat['category'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-6 form-group">
                    <label>Activities</label>
                    <select name="add_project_activities" class="form-control" required>
                        <option value="">Select</option>
                    </select>
                </div>
            </div>

            <div class="form-group text-right">
                <button class="btn add_project_btn btn-bg-custom">Add</button>
            </div>
        </form>
    </div>
</div>