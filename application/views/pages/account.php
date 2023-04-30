<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/account.css'); ?>">

<div class="wrapper-fluid">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="userInfo bg-light-custom">

                    <?php
                    if ($user_info->image && !empty($user_info->image) && isset($user_info->image)) {
                        $uLogo = base_url('uploads/user_profile/') . $user_info->image;
                    } else {
                        if ($user_info->gender === 'Male') {
                            $g = 'male.jpg';
                        } else if ($user_info->gender === 'Female') {
                            $g = 'female.jpg';
                        } else {
                            $g = 'no_image.png';
                        }

                        $uLogo = $this->df['location'] . '' . $g;
                    }
                    ?>
                    <div class="userImg">
                        <img src="<?php echo $uLogo ?>" class="navbar-label">
                        <h5><?php echo $user_info->username ?></h5>
                    </div>

                    <div class="userActions">

                    </div>

                    <div class="userDetails pt-3">
                        <h6>
                            <span>Username</span>
                            <a href='javascript:void(0)'> <?php echo $user_info->username ?></a>
                        </h6>
                        <h6>
                            <span>Email</span>
                            <a href='javascript:void(0)'> <?php echo $user_info->email ?></a>
                        </h6>

                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="tabLinkDiv bg-light-custom">
                    <a href="#activity" class="tab_link" tabName="profile">Activity</a>
                    <a href="#feedback" class="tab_link" tabName="projects">Projects</a>
                    <a href="#payments" class="tab_link" tabName="password">Password</a>
                </div>

                <div class="tabInfoDiv bg-light-custom p-3">
                    <div class="tabDiv" tabName="profile">
                        <P>Profile Info Tab</P>
                    </div>

                    <div class="tabDiv" tabName="projects">
                        <P>projects Info Tab</P>
                    </div>

                    <div class="tabDiv" tabName="password">
                        <P>password Info Tab</P>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>